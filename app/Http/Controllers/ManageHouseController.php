<?php

namespace App\Http\Controllers;

use App\Models\House;
use App\Models\User;
use App\Models\paidHouse;
use Illuminate\Http\Request;
use DataTables;
use DB;
use Auth;
use Carbon\Carbon;
class ManageHouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['add']="add House";
        $data['title']="Houses";
        $userId=Auth::user()->id;
        $cell=DB::table('cells')->join('users','users.cell_id','cells.id')
        ->select('cells.*')
        ->where('users.id',$userId)->first();
        if ($request->ajax()) {
            $data = DB::table('houses')
            ->join('cells','cells.id','houses.cell_id')
            ->select('houses.house_code','houses.is_taken','cells.*')->where('houses.is_deleted',0);
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->editColumn('is_taken', function ($data) {
                        $paid = ($data->is_taken == 1) ? 'checked' : '';
                        return '<input class="toggle-class " type="checkbox" data-id="'.$data->id.'" '.$paid.'  data-toggle="toggle" data-on="Active" data-off="Inactive" data-onstyle="success" data-offstyle="danger" data-url="'.route('manage-payment') .'">';
                    })
                    ->rawColumns(['is_taken'])
                    ->make(true);
        }
        
        return view('manage-house.index',$data);
        //
    }

    //house paid

    public function paidAllHouse(Request $request){
        // $data['add']="add House";
        $data['title']="Houses Paid";
        // $userId=Auth::user()->id;
        // $cell=DB::table('cells')->join('users','users.cell_id','cells.id')
        // ->select('cells.*')
        // ->where('users.id',$userId)->first();
        if ($request->ajax()) {
            $data = DB::table('houses')
            ->join('cells','cells.id','houses.cell_id')
           
            ->select('houses.house_code','houses.paid','cells.*')
            ->where('houses.paid',1)
            ->Orwhere('houses.paid',0)
            ->where('houses.is_deleted',0);
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->editColumn('paid', function ($data) {
                        $paid = ($data->paid == 1) ? 'checked' : '';
                        return '<input class="toggle-class " type="checkbox"  data-id="'.$data->id.'" '.$paid.'  data-toggle="toggle" data-on="Active" data-off="Inactive" data-onstyle="success" data-offstyle="danger" data-url="'.route('manage-payment') .'">';
                    })
                    ->rawColumns(['paid'])
                    ->make(true);
        }
        
        return view('manage-house.allHousePaid',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'house_code' => 'required',
            'cell_id' =>'required',
            
        ]);
        $datas['add']="add house";
        $datas['title']="House";
        $data = $request->all();
        $check = $this->create($data);
         
        return view("Manage-collector.house",$datas)->withSuccess('Great! You have Successfully loggedin');
        //
    }
    public function addHouse()
    {
        $userId=Auth::user()->id;
        $cell=DB::table('cells')->join('users','users.cell_id','cells.id')
        ->select('cells.*')
        ->where('users.id',$userId)->first();
        $data['cell_id']=$cell->id;
        $data['cell_name']=$cell->cell_name;
        
        return view('Manage-collector.addhouse',$data);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\House  $house
     * @return \Illuminate\Http\Response
     */
    public function show(House $house, Request $request)
    {
        
        $userId=Auth::user()->id;
        $cell=DB::table('cells')->join('users','users.cell_id','cells.id')
        ->select('cells.*')
        ->where('users.id',$userId)->first();

        if ($request->ajax()) {
            $data = DB::table('houses')->where('houses.cell_id',$cell->id)->where('is_deleted',0)->get();
           
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($data) {
						return ' <a href="' . route('manage-house-edit',['id' => $data->id]) . '"   class="btn btn-info btn-xs" title="Edit"><i class="fas fa-pencil-alt" aria-hidden="true" ></i></a> | <span title="Delete" class="delete-sportcategory btn btn-danger btn-xs" data-id="'.$data->id.'" data-url="'.route('manage-house-delete', $data->id) .'"><i class="fas fa-trash"></i></a></span>';
				})
                    ->editColumn('is_taken', function ($data) {
                        $status = ($data->is_taken == 1) ? 'checked' : '';
                       return '<input class="toggle-class" type="checkbox" data-id="'.$data->id.'" '.$status.' data-toggle="toggle" data-on="Active" data-off="Inactive" data-onstyle="success" data-offstyle="danger" data-url="'.route('manage-house-status') .'">';
                   })
                    ->rawColumns(['action','is_taken'])
                    ->make(true);
        }
    	
        $data = array();
        $data['add']="add House";
        $data['title']="Houses";
        $data['house'] = $house;
        // $data['people'] = $people;
        $data['cell']=$cell->cell_name;
        // $data['paid'] = $paid;

		return view('Manage-collector.house',$data);
        //
    }


public function status(Request $request){
    $id = $request->id;
    $status = $request->status;
        if($id)
            return (new House)->updateStatus($id,$status);
        else
            return false;
}
/**
     * This function is used to delete manage sportcategory
     *
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Routing\Redirector
     * @author Techaffinity:kaurnakarans
     */
    public function delete(Request $request)
    {
        $id = $request->id;
        if($id)
            return (new House)->deleteHouse($id);
        else
            return false;
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\House  $house
     * @return \Illuminate\Http\Response
     */
    public function edit(House $house)
    {
        //
    }
    public function create(array $data)
    { 
      return House::create([
        'house_code' => $data['house_code'],
        'cell_id'=>$data['cell_id'],
      ]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\House  $house
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, House $house)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\House  $house
     * @return \Illuminate\Http\Response
     */
    public function destroy(House $house)
    {
        //
    }
    public function showHouse(Request $request){
        $data['add']="add House";
        $data['title']="Houses";
        $userId=Auth::user()->id;
        $cell=DB::table('cells')->join('users','users.cell_id','cells.id')
        ->select('cells.*')
        ->where('users.id',$userId)->first();
        if ($request->ajax()) {
            $data = DB::table('houses')
            ->join('cells','cells.id','houses.cell_id')
            ->select('houses.house_code','houses.status','cells.*')->where('houses.is_deleted',0)->where('houses.cell_id',$cell->id);
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->editColumn('status', function ($data) {
                        $status = ($data->status == 1) ? 'checked' : '';
                       return '<input class="toggle-class" type="checkbox" data-id="'.$data->id.'" '.$status.' data-toggle="toggle" data-on="Active" data-off="Inactive" data-onstyle="success" data-offstyle="danger" data-url="'.route('manage-house-status') .'">';
                   })
                    ->rawColumns(['status'])
                    ->make(true);
        }
        
        return view('manage-house.showHouse',$data);
    }
    public function paidHouse(Request $request){
        // $data['add']="add House";
        $data['title']="Houses";
        $userId=Auth::user()->id;
        $cell=DB::table('cells')->join('users','users.cell_id','cells.id')
        ->select('cells.*')
        ->where('users.id',$userId)->first();
        if ($request->ajax()) {
            $data = DB::table('houses')
            ->join('cells','cells.id','houses.cell_id')
            
            ->select('houses.house_code','houses.paid','cells.*')
            ->where('houses.paid',1)
            ->orwhere('houses.paid',0)
            ->where('houses.is_deleted',0)->where('houses.cell_id',$cell->id);
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->editColumn('paid', function ($data) {
                        $status = ($data->status == 1) ? 'checked' : '';
                       return '<input class="toggle-class" type="checkbox" data-id="'.$data->id.'" '.$status.' data-toggle="toggle" data-on="Active" data-off="Inactive" data-onstyle="success" data-offstyle="danger" data-url="'.route('manage-house-status') .'">';
                   })
                    ->rawColumns(['paid'])
                    ->make(true);
        }
        
        return view('Manage-collector.housePaid',$data);
    }

    //overdue to pay
    public function overdue(Request $request){
        $userId=Auth::user()->id;
        $cell=DB::table('cells')->join('users','users.cell_id','cells.id')
        ->select('cells.*')
        ->where('users.id',$userId)->first();

        
        if ($request->ajax()) {
            $data = DB::table('peoples')
            ->join('house_peoples','peoples.id','house_peoples.people_id')
            ->join('houses','houses.id','house_peoples.house_id')
            ->join('cells','cells.id','houses.cell_id')
            ->join('categories','categories.id','peoples.cat_id')
            ->leftjoin('paid_houses','paid_houses.house_people_id','house_peoples.id')
            ->where('house_peoples.status',1)
            ->distinct()
            ->select('peoples.*','house_peoples.id as ids','houses.house_code','cells.cell_name','categories.category_name','categories.amount','houses.id as idss','houses.paid')->where('houses.cell_id',$cell->id)
            ->whereMonth(
                'houses.updated_at', '=', Carbon::now()->subMonth()->month
            );
            // ->whereMonth('house_peoples.created_at', Carbon::now()->month)
            // ->whereMonth('houses.updated_at', Carbon::now()->month);
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
     
                           $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';
    
                            return $btn;
                    })
                    ->editColumn('status', function ($data) {
                        $status = ($data->status == 1) ? 'checked' : '';
                        return '<input class="toggle-class" type="checkbox" data-id="'.$data->id.'" '.$status.' data-toggle="toggle" data-on="Active" data-off="Inactive" data-onstyle="success" data-offstyle="danger" data-url="'.route('manage-people-status') .'">';
                    })
                    ->editColumn('paid', function ($data) {
                    $approve = ($data->paid == 1) ? 'checked' : '';
                return '<input class="toggle-class2 approve" type="checkbox" data-id="' . $data->ids . '" ' . $approve . ' data-id2="'.$data->idss.'" data-toggle="toggle" data-on="Approved" data-off="Approve" data-onstyle="success" data-offstyle="danger" data-url="' . route('manage-payment') . '">';
            })
                   
                    ->rawColumns(['status','paid'])
                    ->make(true);
        }
        $data = DB::table('peoples')
        ->join('house_peoples','peoples.id','house_peoples.people_id')
        ->join('houses','houses.id','house_peoples.house_id')
        ->join('cells','cells.id','houses.cell_id')
        ->join('categories','categories.id','peoples.cat_id')
        ->leftjoin('paid_houses','paid_houses.house_people_id','house_peoples.id')
        ->select('house_peoples.id','houses.house_code','cells.cell_name','categories.category_name','categories.amount','houses.paid')->where('houses.cell_id',$cell->id)->get();
        foreach($data as $people){
        $data['add']="add People";
        $data['title']="Peoples";
        $data['people']=$people->id;
        }
        // return view('Manage-collector.showPeople',$data);


        // $userId=Auth::user()->id;
        // $cell=DB::table('cells')->join('users','users.cell_id','cells.id')
        // ->select('cells.*')
        // ->where('users.id',$userId)->first();

        
        // if ($request->ajax()) {
        //     $data = DB::table('peoples')
        //     ->join('house_peoples','peoples.id','house_peoples.people_id')
        //     ->join('houses','houses.id','house_peoples.house_id')
        //     ->join('cells','cells.id','houses.cell_id')
        //     ->join('categories','categories.id','peoples.cat_id')
        //     ->leftjoin('paid_houses','paid_houses.house_people_id','house_peoples.id')
        //     ->where('house_peoples.status',1)
        //     ->distinct()
        //     ->select('peoples.*','house_peoples.id as ids','houses.house_code','cells.cell_name','categories.category_name','categories.amount','houses.id as idss','houses.paid')->where('houses.cell_id',$cell->id)
        //     ->whereMonth(
        //         'houses.updated_at', '=', Carbon::now()->subMonth()->month
        //     );
        //     return Datatables::of($data)
        //             ->addIndexColumn()
        //             ->addColumn('action', function($row){
     
        //                    $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';
    
        //                     return $btn;
        //             })
        //             ->editColumn('status', function ($data) {
        //                 $status = ($data->status == 1) ? 'checked' : '';
        //                 return '<input class="toggle-class" type="checkbox" data-id="'.$data->id.'" '.$status.' data-toggle="toggle" data-on="Active" data-off="Inactive" data-onstyle="success" data-offstyle="danger" data-url="'.route('manage-people-status') .'">';
        //             })
        //             ->editColumn('paid', function ($data) {
        //             $approve = ($data->paid == 1) ? 'checked' : '';
        //         return '<input class="toggle-class2 approve" type="checkbox" data-id="' . $data->ids . '" ' . $approve . ' data-id2="'.$data->idss.'" data-toggle="toggle" data-on="Approved" data-off="Approve" data-onstyle="success" data-offstyle="danger" data-url="' . route('manage-payment') . '">';
        //     })
                   
        //             ->rawColumns(['status','paid'])
        //             ->make(true);
        // }
        $data['title']="Overdue To pay";
        return view('Manage-house.overdue',$data);
    }


    //overdue in sector
    public function overduePay(Request $request){

        // $userId=Auth::user()->id;
        //         $cell=DB::table('cells')->join('users','users.cell_id','cells.id')
        //         ->select('cells.*')
        //         ->where('users.id',$userId)->first();
        
                
                if ($request->ajax()) {
                    $data = DB::table('peoples')
                    ->join('house_peoples','peoples.id','house_peoples.people_id')
                    ->join('houses','houses.id','house_peoples.house_id')
                    ->join('cells','cells.id','houses.cell_id')
                    ->join('categories','categories.id','peoples.cat_id')
                    ->leftjoin('paid_houses','paid_houses.house_people_id','house_peoples.id')
                    ->where('house_peoples.status',1)
                    ->distinct()
                    ->select('peoples.*','house_peoples.id as ids','houses.house_code','cells.cell_name','categories.category_name','categories.amount','houses.id as idss','houses.paid')
                    ->whereMonth(
                        'houses.updated_at', '=', Carbon::now()->subMonth()->month
                    );
                    return Datatables::of($data)
                            ->addIndexColumn()
                            ->addColumn('action', function($row){
             
                                   $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';
            
                                    return $btn;
                            })
                            ->editColumn('status', function ($data) {
                                $status = ($data->status == 1) ? 'checked' : '';
                                return '<input class="toggle-class" type="checkbox" data-id="'.$data->id.'" '.$status.' data-toggle="toggle" data-on="Active" data-off="Inactive" data-onstyle="success" data-offstyle="danger" data-url="'.route('manage-people-status') .'">';
                            })
                            ->editColumn('paid', function ($data) {
                            $approve = ($data->paid == 1) ? 'checked' : '';
                        return '<input class="toggle-class2 approve" type="checkbox" disabled readonly data-id="' . $data->ids . '" ' . $approve . ' data-id2="'.$data->idss.'" data-toggle="toggle" data-on="Approved" data-off="Approve" data-onstyle="success" data-offstyle="danger" data-url="' . route('manage-payment') . '">';
                    })
                           
                            ->rawColumns(['status','paid'])
                            ->make(true);
                }
                $data['title']="Overdue To pay";
                return view('Manage-house.overduePay',$data);
            }
        
    public function reset(){
        $house=House::where('paid',1)
        ->whereMonth(
            'houses.updated_at', '=', Carbon::now()->subMonth()->month
        )->update(['paid'=>0]);
        
        $lastmont=paidHouse::whereMonth(
            'paid_houses.created_at', '=', Carbon::now()->subMonth()->month
        )->update(['status'=>0]);
        $notify['notify']="Data reseted";
        return view('layout.app',$notify);
    }
   
   
}
