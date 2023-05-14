<?php

namespace App\Http\Controllers\Item;

use App\Http\Controllers\Controller;
use App\Http\Requests\Item\ItemRequest;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
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
