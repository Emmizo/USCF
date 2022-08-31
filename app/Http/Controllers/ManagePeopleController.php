<?php

namespace App\Http\Controllers;

use App\Models\People;
use App\Models\PaidHouse;
use App\Models\PeopleHouse;
use App\Models\House;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use DataTables;
use DB;
use Auth;
use Carbon\Carbon;
class ManagePeopleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        

        $data['add']="add People";
        $data['title']="Peoples";
        if ($request->ajax()) {
            $data = DB::table('peoples')
            ->join('house_peoples','peoples.id','house_peoples.people_id')
            ->join('houses','houses.id','house_peoples.house_id')
            ->join('cells','cells.id','houses.cell_id')
            ->join('categories','categories.id','peoples.cat_id')
            ->leftjoin('paid_houses','paid_houses.house_people_id','house_peoples.id')
            ->select('peoples.*','houses.house_code','cells.cell_name','categories.category_name','categories.amount','houses.paid')
            ->where('house_peoples.status',1)
            ->distinct();
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
                        $paid = ($data->paid == 1) ? 'checked' : '';
                        return '<input class="toggle-class2 " type="checkbox" disabled readonly data-id="'.$data->id.'" '.$paid.'  data-toggle="toggle" data-on="Active" data-off="Inactive" data-onstyle="success" data-offstyle="danger" data-url="'.route('manage-payment') .'">';
                    })
                    ->rawColumns(['action','status','paid'])
                    ->make(true);
        }
        $cells=DB::table('cells')->get();
        foreach($cells as $cell){
            $cellid[]=$cell->id;
        }
       
        $data = DB::table('peoples')
        ->join('house_peoples','peoples.id','house_peoples.people_id')
        ->join('houses','houses.id','house_peoples.house_id')
        ->join('cells','cells.id','houses.cell_id')
        ->join('categories','categories.id','peoples.cat_id')
        ->leftjoin('paid_houses','paid_houses.house_people_id','house_peoples.id')
        ->select('house_peoples.id','houses.house_code','cells.cell_name','categories.category_name','categories.amount','houses.paid')->where('houses.cell_id',$cellid)->get();
        foreach($data as $people){
        $data['add']="add People";
        $data['title']="Peoples";
        $data['people']=$people->id;
        }
        return view('manage-people.index',$data);
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    
  public function status(Request $request){
      $id=$request->id;
      $status = $request->status;
      
      $status=DB::table('peoples')->where('id',$id)->update(['status'=>$status]);
      if($status==1){
          $dd=DB::table('house_peoples')->where('people_id',$id)->update(['status'=>0]);
      }
  }
  //register paid house
  public function pay(Request $request){
    $id=$request->id;
    $paid = $request->paid;
    $house = $request->house_people_id;
    $userId=Auth::user()->id;
            $g=House::where('id',$id)->update(['paid'=>1]);
            // return $house;
        $check=PaidHouse::where('house_people_id',$house)
        ->whereMonth('paid_houses.created_at', Carbon::now()->month)->first();
        // return $check;
        if(!empty($check)){
            $request->session()->flash('error', "Unable to pay twice in one month.");
            
        }else{
{
        $dd=PaidHouse::create([
            'house_people_id'=>$house,
            'user_id'=>$userId,
        ]);
        return $dd;
    }
    }
    // }
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
            'first_name' => 'required',
            'last_name' =>'required',
            'phone' => 'required',
            'identity' => 'required',
            'cat_id' => 'required',
            
        ]);
        
        $datas['add']="add People";
        $datas['title']="Peoples";
        $datas['people']=null;
        $userId=Auth::user()->id;
        $cell=DB::table('cells')->join('users','users.cell_id','cells.id')
        ->select('cells.*')
        ->where('users.id',$userId)->first();
        $check=DB::table('peoples')->where('identity',$request->identity)->first();
        if(!empty($check))
        $checkPeople=PeopleHouse::where('house_id',$request->house_id)->where(  'people_id' ,$check->id)->first();
        if(!empty($checkPeople)){
            $update=PeopleHouse::where('id',$checkPeople->id)->update(['status'=>1]);
            $update=DB::table('houses')->where('id',$request->house_id)->update(['is_taken'=>1]);
        }else{
    
        if(empty($check)){
            $add=People::create([
                'first_name' => $request->first_name,
                'last_name'=> $request->last_name,
                'phone' => $request->phone,
                'identity' => $request->identity,
                'cat_id' => $request->cat_id,
              ]);
              
              $addPeople=PeopleHouse::create([
                'house_id'=>$request->house_id,
                'people_id' =>$add->id,
            ]);
            $datas['people']=$add->id??'';
            $update=DB::table('houses')->where('id',$request->house_id)->update(['is_taken'=>1]);
        }else{
            $update=DB::table('houses')->where('id',$request->house_id)->update(['is_taken'=>1]);
            $update=PeopleHouse::where('house_id',$request->house_id)->update(array('status'=>0));
            $check=DB::table('peoples')->where('identity',$request->identity)->first();
            
            $addPeople=PeopleHouse::create([
                'house_id'=>$request->house_id,
                'people_id' =>$check->id,
            ]);
            $datas['people']=$check->id??'';
        }
    }
          
        return view('Manage-collector.showPeople',$datas);
        //
    }
    //add people
public function addPeople(){
    $category=DB::table('categories')->get();
    $userId=Auth::user()->id;
    $cell=DB::table('cells')->join('users','users.cell_id','cells.id')
    ->select('cells.*')
    ->where('users.id',$userId)->first();
    $house=DB::table('houses')->where('cell_id',$cell->id)->where('is_taken',0)->where('is_deleted',0)->get();
    $data['category']=$category;
    $data['houses']=$house;
    $data['people']=null;

    return view('manage-people.add',$data);
}
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\People  $people
     * @return \Illuminate\Http\Response
     */
    public function show(People $people)
    {
        $userId=Auth::user()->id;
        $cell=DB::table('cells')->join('users','users.cell_id','cells.id')
        ->select('cells.*')
        ->where('users.id',$userId)->first();
    $people = DB::table("houses")
    ->join('cells','cells.id','houses.cell_id')
    ->join('house_peoples','house_peoples.house_id','houses.id')
    ->join('peoples','peoples.id','house_peoples.people_id')
    ->where('peoples.status',0)->get();
    $data=array();
    $data['people']=$people;
    return view('Manage-collector.people',$data);
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\People  $people
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {

        $id = $request->id;
        if(!$id){
            $request->session()->flash('error', "Something Went Wrong!.");
            return view('manage-collector.showPeople', $data);
        }
        $data['info'] = $info = People::find($id);
        if(!$info) {
            $request->session()->flash('error', "Unable to find people info.");
            return view('manage-collector.showPeople', $data);
        }
        $cat = Category::select('id','category_name')->where('status',1)->get();
        $data['categories'] = $cat;
        $data['title'] = "Manage People - Edit";
        $data['brVal'] = "Manage People";
        return view('manage-people.edit', $data);
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\People  $people
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data['add']="add People";
        $data['title']="Peoples";
        // $data['people']=$people->id;
        if((new People)->updatePeople($request->all())) {
            $request->session()->flash('success', "People Updated Successfully.");
            return view('manage-collector.showPeople',$data);
        } else {            
            $request->session()->flash('error', "Nothing to update (or) unable to update.");
            return view('Manage-collector.showPeople',$data)->withInput();
        }
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\People  $people
     * @return \Illuminate\Http\Response
     */
    public function destroy(People $people)
    {
        //
    }
    public function showPeople(Request $request){
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
            ->select('peoples.*','house_peoples.id as ids','houses.house_code','cells.cell_name','categories.category_name','categories.amount','houses.id as idss','houses.paid')->where('houses.cell_id',$cell->id);
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
            ->addColumn('option', function ($data) {
                return '
                    <a href="' . route('edit-people',['id' => $data->id]) . '"   class="btn btn-info btn-xs" title="Add"><i class="fas fa-pencil-alt" aria-hidden="true" ></i></a> ';
            })  
                    ->rawColumns(['status','paid','option'])
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
        return view('Manage-collector.showPeople',$data);
    }

    public function sendSMS(){
        $nonPaid=DB::table('peoples')
    ->join('house_peoples','peoples.id','house_peoples.people_id')
    ->join('houses','houses.id','house_peoples.house_id')
    ->join('cells','cells.id','houses.cell_id')
    ->join('categories','categories.id','peoples.cat_id')
    ->leftjoin('paid_houses','paid_houses.house_people_id','house_peoples.id')
    ->select('peoples.*','houses.house_code','cells.cell_name','categories.category_name','categories.amount','houses.paid')
    ->where('houses.paid',0)
    // ->whereMonth('house_peoples.created_at', Carbon::now()->month)
    // ->WhereMonth(
    //     'houses.updated_at', '=', Carbon::now()->month
    // )
    ->get();
    // return $nonPaid;
    foreach($nonPaid as $sms){
        $this->notify($sms->phone,$sms->first_name,$sms->last_name,$sms->cell_name);
    }
    $notify['notify']="Thank you to notify";
    if(auth::user()->role_id==1){
    return view('layout.app',$notify);
    }else{
        return view('layout.Collector',$notify);  
    }
    }
    //send  notification
    public function notify($phone,$fname,$lname,$cell){
        $data['add']="add People";
        $data['title']="Peoples";
        $message = "Muturage wa ".$cell." witwa ".$fname." ".$lname.", Igihe cyokwishyura amafranga y'umutekano kirikurenga, mukwirinda gukererwa kwishyura wakwishyura mbere yuko ukwezi kuzura. Murako!";
        $curl = curl_init();
                    curl_setopt_array($curl, array(
                      CURLOPT_URL => "https://api.mista.io/sms",
                      CURLOPT_RETURNTRANSFER => true,
                      CURLOPT_ENCODING => "",
                      CURLOPT_MAXREDIRS => 10,
                      CURLOPT_TIMEOUT => 0,
                      CURLOPT_FOLLOWLOCATION => true,
                      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                      CURLOPT_CUSTOMREQUEST => "POST",
                      CURLOPT_POSTFIELDS => array('to' => "+25".$phone,'sms' => $message,'from' => 'uscf','unicode' => '0','action' => 'send-sms'),
                      CURLOPT_HTTPHEADER => array(
                        "x-api-key: ZHBJbkViTD1xcGFkb256UD1zcGE="),
                    ));
    
                    $response = curl_exec($curl);

                    return $response;
                    // return view('manage-people.index',$data);
                    // $pattern = "/Successfully/i";
                    // $wrongpattern = "/invalid/i";
                    // if(preg_match_all($pattern, $response, $matches)) {
                    // $_SESSION['messages'] = "Successfully recommendation sent";
                    // }
                    // else{
                    // $_SESSION['messages'] = "Successfully recomendation not sent";
                    // }
    }
}
