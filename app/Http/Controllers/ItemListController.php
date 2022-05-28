<?php

namespace App\Http\Controllers;

use App\Models\ItemList;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;


class ItemListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = Department::with(['items' => function($items) {
            $items->orderBy('name', 'asc');
        }])->whereHas('items')->orderBy('name', 'asc')->get();

        $itemLists = Department::with(['item_list.item' => function($item) {
            $item->orderBy('name', 'asc');
        }])->whereHas('item_list')->orderBy('name', 'asc')->get();

        return Request()->expectsJson()
            ? Response()->json(compact('itemLists', 'departments'))
            : Inertia::render('ItemList/Index', compact('itemLists', 'departments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->validate([
            "quantity" => ["required", "numeric", "gt:0"],
            "item_id" => ["required", 'exists:items,id']
        ]);

        $itemList = ItemList::create( $input );
        return Response()->json(['success' => true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ItemList  $itemList
     * @return \Illuminate\Http\Response
     */
    public function show(ItemList $itemList)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ItemList  $itemList
     * @return \Illuminate\Http\Response
     */
    public function edit(ItemList $itemList)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ItemList  $itemList
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $itemList = ItemList::find($id);

        $input = $request->validate([
            "purchased" => ["boolean"],
            "quantity" => ["numeric"]
        ]);

        $itemList->update( $input );
        return Response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ItemList  $itemList
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $itemList = ItemList::find($id);
        return Response()->json(['success' => $itemList->delete()]);
    }
}
