<?php

namespace App\Http\Controllers\Item;

use App\Http\Controllers\Controller;
use App\Http\Requests\Item\ItemRequest;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        return view('my-todo-list');
    }

    public function items()
    {
        $data = Item::orderBy('created_at')->paginate(5);
        return response()->json([
            'message' => 'success',
            'response' => $data
        ]);
    }

    public function store(ItemRequest $request)
    {
        try {
            \DB::beginTransaction();

            $request->validated();

            Item::create();

            \DB::commit();
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
        //
    }


    public function update(Request $request, string $id)
    {
        $item = Item::findOrFail($id);
    }


    public function destroy(string $id)
    {
        $item = Item::findOrFail($id);
    }

    public function restore(string $id)
    {
        $item = Item::findOrFail($id);
    }

    public function archived(string $id)
    {

    }

    public function completed()
    {

    }

    public function markAsDone(Request $request, string $id)
    {
        $item = Item::findOrFail($id);
        $is_completed = $request->input('is_completed');
        if ($is_completed) {
            try {
                \DB::beginTransaction();
                $item->update([
                    'created_at' => now()
                ]);
                \DB::commit();
                return response()->json([
                    'message' => 'Task Completed.'
                ]);
            } catch (\Exception $exception) {
                \DB::rollBack();
                reportLog($exception);
                return response()->json([
                    'message' => 'Oops, Something Went Wrong!'
                ]);
            }
        } else {
            $item->update([
                'created_at' => null
            ]);
        }
        return response()->json();
    }
}
