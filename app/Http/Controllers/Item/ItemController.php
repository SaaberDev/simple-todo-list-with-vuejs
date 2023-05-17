<?php

namespace App\Http\Controllers\Item;

use App\Http\Controllers\Controller;
use App\Http\Requests\Item\StoreRequest;
use App\Http\Requests\Item\UpdateRequest;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        if ($request->expectsJson()) {
            $page = $request->get('page') ?? 1;
            $perPage = 5;
            $offset = $perPage * ($page - 1);
            $data = Item::when($page)
                ->orderBy('created_at', 'desc')
                ->skip($offset)
                ->take($perPage)
                ->get()
            ;

            return response()->json([
                'message' => 'success',
                'response' => $data
            ]);
        } else {
            return view('my-todo-list');
        }
    }

    public function store(StoreRequest $request)
    {
        try {
            \DB::beginTransaction();

            $validated = $request->validated();
            $validated['user_id'] = \Auth::user()->id;
            Item::create($validated);

            \DB::commit();
            return response()->json([
                'message' => __('Item added successfully.'),
            ]);
        } catch (\Exception $exception) {
            \DB::rollBack();
            reportLog($exception);
            return response()->json([
                'message' => 'Oops, Something Went Wrong!'
            ]);
        }
    }

    public function edit(string $id)
    {
        $item = Item::findOrFail($id);
        return response()->json([
            'message' => 'success',
            'response' => $item
        ]);
    }

    public function update(UpdateRequest $request, string $id)
    {
        $item = Item::findOrFail($id);
        $validated = $request->validated();
        try {
            $item->update($validated);
            return response()->json([
                'message' => 'Item updated successfully.'
            ]);
        } catch (\Exception $exception) {
            reportLog($exception);
            return response()->json([
                'message' => 'Oops, Something Went Wrong!'
            ]);
        }
    }

    public function destroy(string $id)
    {
        $item = Item::findOrFail($id);
        try {
            $item->forceDelete();
            return response()->json([
                'message' => 'Item has been permanently deleted.',
            ]);
        } catch (\Exception $exception) {
            reportLog($exception);
            return response()->json([
                'message' => 'Oops, Something Went Wrong!'
            ]);
        }
    }

    public function markAsDone(Request $request, string $id)
    {
        $item = Item::findOrFail($id);
        $is_completed = $request->input('is_completed');
        if ($is_completed) {
            try {
                $item->update([
                    'completed_at' => now()
                ]);

                return response()->json([
                    'message' => 'Item marked as completed.'
                ]);
            } catch (\Exception $exception) {
                reportLog($exception);
                return response()->json([
                    'message' => 'Oops, Something Went Wrong!'
                ]);
            }
        } else {
            try {
                $item->update([
                    'completed_at' => null
                ]);

                return response()->json([
                    'message' => 'Item marked as incomplete.'
                ]);
            } catch (\Exception $exception) {
                reportLog($exception);
                return response()->json([
                    'message' => 'Oops, Something Went Wrong!'
                ]);
            }
        }
    }
}
