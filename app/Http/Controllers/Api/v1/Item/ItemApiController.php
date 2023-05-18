<?php

namespace App\Http\Controllers\Api\v1\Item;

use App\Http\Controllers\Controller;
use App\Http\Requests\Item\StoreRequest;
use App\Http\Requests\Item\UpdateRequest;
use App\Models\Item;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ItemApiController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->get('perPage', 5);
        $data = Item::where('user_id', '=', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return response()->json([
            'message' => 'success',
            'response' => $data->items(),
            'total' => $data->total(),
            'currentPage' => $data->currentPage(),
            'totalPages' => $data->lastPage(),
            'hasNextPage' => !$data->hasMorePages()
        ]);
    }

    public function store(StoreRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $validated = $request->validated();
            $validated['user_id'] = Auth::user()->id;
            Item::create($validated);

            DB::commit();
            return response()->json([
                'message' => __('Item added successfully.'),
            ]);
        } catch (Exception $exception) {
            DB::rollBack();
            reportLog($exception);
            return response()->json([
                'message' => 'Oops, Something Went Wrong!'
            ]);
        }
    }

    public function edit(string $id): JsonResponse
    {
        $item = Item::findOrFail($id);
        return response()->json([
            'message' => 'success',
            'response' => $item
        ]);
    }

    public function update(UpdateRequest $request, string $id): JsonResponse
    {
        $item = Item::findOrFail($id);
        $validated = $request->validated();
        try {
            $item->update($validated);
            return response()->json([
                'message' => 'Item updated successfully.'
            ]);
        } catch (Exception $exception) {
            reportLog($exception);
            return response()->json([
                'message' => 'Oops, Something Went Wrong!'
            ]);
        }
    }

    public function destroy(string $id): JsonResponse
    {
        $item = Item::findOrFail($id);
        try {
            $item->forceDelete();
            return response()->json([
                'message' => 'Item has been permanently deleted.',
            ]);
        } catch (Exception $exception) {
            reportLog($exception);
            return response()->json([
                'message' => 'Oops, Something Went Wrong!'
            ]);
        }
    }

    public function markAsDone(Request $request, string $id): JsonResponse
    {
        $item = Item::findOrFail($id);
        $is_completed = $request->input('is_completed');
        if ($is_completed) {
            try {
                $item->update([
                    'status' => $is_completed
                ]);

                return response()->json([
                    'message' => 'Item marked as completed.'
                ]);
            } catch (Exception $exception) {
                reportLog($exception);
                return response()->json([
                    'message' => 'Oops, Something Went Wrong!'
                ]);
            }
        } else {
            try {
                $item->update([
                    'status' => $is_completed
                ]);

                return response()->json([
                    'message' => 'Item marked as incomplete.'
                ]);
            } catch (Exception $exception) {
                reportLog($exception);
                return response()->json([
                    'message' => 'Oops, Something Went Wrong!'
                ]);
            }
        }
    }
}
