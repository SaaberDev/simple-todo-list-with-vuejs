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
        $data = Item::orderByRaw('ISNULL(completed_at), completed_at ASC')->paginate(5);
//        $data = Item::orderBy('created_at')->paginate(5);
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
                'msg' => 'Oops, Something Went Wrong!'
            ]);
        }
    }


    public function edit(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        //
    }


    public function destroy(string $id)
    {
        //
    }

    public function restore()
    {

    }

    public function archived()
    {

    }

    public function completed()
    {

    }

    public function markAsDone()
    {

    }
}
