<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\User;
use App\Models\House;
use App\Models\People;
use App\Models\Cell;
use App\Models\PaidHouse;
use App\Models\PeopleHouse;
use Auth;
use Carbon\Carbon;
class ManageCollectorController extends Controller
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
    	$house = House::where('houses.cell_id',$cell->id)->where('is_deleted',0)->count();

        $people = DB::table("houses")
        ->join('cells','cells.id','houses.cell_id')
        ->join('house_peoples','house_peoples.house_id','houses.id')
        ->join('peoples','peoples.id','house_peoples.people_id')
        ->where('peoples.status',0)->count();

        $paid = DB::table('houses')
        ->join('house_peoples','house_peoples.house_id','houses.id')
        ->join('paid_houses','house_peoples.id','paid_houses.house_people_id')
        ->where('houses.paid',1)
        ->whereMonth('paid_houses.created_at', Carbon::now()->month)
        ->where('paid_houses.status',1)->where('houses.cell_id',$cell->id)->count();

        $data = array();
        $houseTaken = House::where('houses.cell_id',$cell->id)->where('is_deleted',0)->where('is_taken',1)->count();
        
        $userId=Auth::user()->id;
        $cell=DB::table('cells')->join('users','users.cell_id','cells.id')
        ->select('cells.*')
        ->where('users.id',$userId)->first();

        $over = DB::table('peoples')
        ->join('house_peoples','peoples.id','house_peoples.people_id')
        ->join('houses','houses.id','house_peoples.house_id')
        ->join('cells','cells.id','houses.cell_id')
        ->join('categories','categories.id','peoples.cat_id')
        ->leftjoin('paid_houses','paid_houses.house_people_id','house_peoples.id')
        ->where('house_peoples.status',1)
        ->where('houses.cell_id',$cell->id)
        ->distinct()
        ->whereMonth(
            'houses.updated_at', '=', Carbon::now()->subMonth()->month
        )->count();
        $data['house'] = $house;
        $data['people'] = $people;
        $data['cells']=$cell->cell_name;
        $data['paid'] = $paid;
        $data['houseTaken']=$houseTaken;
        $data['overdue']=$over;

        
		return view('Manage-collector.index',$data);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
