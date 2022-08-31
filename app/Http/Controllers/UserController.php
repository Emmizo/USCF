<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\User;
use App\Models\Role;
use App\Models\Cell;
use DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['add']="add user";
        $data['title']="Users";
        if ($request->ajax()) {
            $data = DB::table('users')
            ->join('cells','cells.id','users.cell_id')
            ->select('users.id','users.name','users.cell_id','users.email','cells.cell_name','users.status');
            return Datatables::of($data)
                    ->addIndexColumn()
                   
                    ->editColumn('status', function ($data) {
                        $status = ($data->status == 1) ? 'checked' : '';
                       return '<input class="toggle-class" type="checkbox" data-id2="'.$data->cell_id.'" data-id="'.$data->id.'" '.$status.' data-toggle="toggle" data-on="Active" data-off="Inactive" data-onstyle="success" data-offstyle="danger" data-url="'.route('manage-status') .'">';
                   })
                   ->addColumn('action', function ($data) {
                    return '
                        <a href="' . route('edit-user',['id' => $data->id]) . '"   class="btn btn-info btn-xs" title="Add"><i class="fas fa-pencil-alt" aria-hidden="true" ></i></a> ';
                })
                    ->rawColumns(['status','action'])
                    ->make(true);
        }
        
        return view('manage-user.index',$data);
        //
    }
    public function status(Request $request){
        $id = $request->id;
        $status = $request->status;
        $taken = $request->cell;
        if($status==1){
        $update=DB::table('cells')->where('id',$request->cell)->update(['taken'=>1]);
        }else{
            $update=DB::table('cells')->where('id',$request->cell)->update(['taken'=>0]);
        }
        //    echo $taken;
            if($id){
           
                return (new User)->updateStatus($id,$status);
            }else
                return false;
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
    public function edit(Request $request)
    {

        $id = $request->id;
        if(!$id){
            $request->session()->flash('error', "Something Went Wrong!.");
            return view('manage-user.edit', $data);
        }
        $data['info'] = $info = User::find($id);
        if(!$info) {
            $request->session()->flash('error', "Unable to find tour info.");
            return view('manage-user.edit', $data);
        }
        $roles = Role::select('id','role_name')->where('status',1)->get();
        $cells = Cell::select('id','cell_name')->where('status',1)->get();
        $data ['roles'] = $roles;
        $data['cells'] = $cells;
        $data['title'] = "Manage User - Edit";
        $data['brVal'] = "Manage User";
        return view('manage-user.edit', $data);
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data['add']="add user";
        $data['title']="Users";
        if((new User)->updateUser($request->all())) {
            $request->session()->flash('success', "User Updated Successfully.");
            return redirect(route('manage-user.index',$data));
        } else {            
            $request->session()->flash('error', "Nothing to update (or) unable to update.");
            return redirect(route('manage-user.index',$data))->withInput();
        }
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
