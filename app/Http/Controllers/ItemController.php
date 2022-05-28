<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ItemController extends Controller
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

        return Request()->expectsJson()
            ? Response()->json(compact('departments'))
            : Inertia::render('Item/Index', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments = Department::all();

        return Request()->expectsJson()
            ? Response()->json(compact('departments'))
            : Inertia::render('Item/Create', compact('departments'));
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
            "name" => ["required", "max:128", 'unique:departments'],
            "department_id" => ["required", 'exists:departments,id']
        ]);

        Item::create( $input );

        return Redirect::route('items.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        $departments = Department::all();

        return Request()->expectsJson()
            ? Response()->json(compact('departments'))
            : Inertia::render('Item/Edit', compact('departments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        $departments = Department::orderBy('name', 'asc')->get();

        return Request()->expectsJson()
            ? Response()->json(compact('item', 'departments'))
            : Inertia::render('Item/Edit', compact('item', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        $input = $request->validate([
            "name" => ["required", "max:128", 'unique:departments'],
            "department_id" => ["required", 'exists:departments,id']
        ]);

        $item->update( $input );

        return Redirect::route('items.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        return Response()->json(['success' => $item->delete()]);
    }
}
