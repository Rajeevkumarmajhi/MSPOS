<?php

namespace App\Http\Controllers;

use App\Table;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;

class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()->can('table-index')){
            $tables = Table::where('status','Active')->get();
            return view('table.index',compact('tables'));
        }
        return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(auth()->user()->can('table-add'))
            return view('table.create');
        return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!auth()->user()->can('table-add'))
            return redirect()->back()->with('not permitted','Sorry! You are not allowed to access this module');
        $table = new Table();
        $table->name = $request->name;
        $table->save();
        return redirect()->route('table.index')->with('message1','Table Added successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Table  $table
     * @return \Illuminate\Http\Response
     */
    public function show(Table $table)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Table  $table
     * @return \Illuminate\Http\Response
     */
    public function edit(Table $table)
    {
        if(auth()->user()->can('table-edit'))
            return view('table.edit',compact('table'));
        
        return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Table  $table
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Table $table)
    {
        if(!auth()->user()->can('table-edit'))
            return redirect()->back()->with('not permitted','Sorry! You are not allowed to access this module');
        $table->name = $request->name;
        $table->save();
        return redirect()->route('table.index')->with('message1','Table updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Table  $table
     * @return \Illuminate\Http\Response
     */
    public function destroy(Table $table)
    {
        if(!auth()->user()->can('table-delete'))
            return redirect()->back()->with('not permitted','Sorry! You are not allowed to access this module');
        $table->delete();
        return redirect()->route('table.index')->with('message3','Table deleted successfully');


            
    }
}
