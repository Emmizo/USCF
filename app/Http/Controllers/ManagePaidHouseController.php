<?php

namespace App\Http\Controllers;

use App\Models\PaidHouse;
use Illuminate\Http\Request;
use DB;
use Auth;

class ManagePaidHouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId=Auth::user()->id;
    $cell=DB::table('cells')->join('users','users.cell_id','cells.id')
    ->select('cells.*')
    ->where('users.id',$userId)->first();
    $paid = DB::table('houses')
    ->join('paid_houses','houses.id','paid_houses.house_people_id')
    ->where('paid_houses.status',0)->where('houses.cell_id',$cell->id)->get();
    $data=array();
    $data['paid']=$paid;
    return view('Manage-collector.house',$data);
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PaidHouse  $paidHouse
     * @return \Illuminate\Http\Response
     */
    public function show(PaidHouse $paidHouse)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PaidHouse  $paidHouse
     * @return \Illuminate\Http\Response
     */
    public function edit(PaidHouse $paidHouse)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PaidHouse  $paidHouse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PaidHouse $paidHouse)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PaidHouse  $paidHouse
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaidHouse $paidHouse)
    {
        //
    }
}
