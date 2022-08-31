<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\House;
use App\Models\People;
use App\Models\PaidHouse;
use App\Models\PeopleHouse;
use DB;
use Auth;
use Carbon\Carbon;
use PDF;
class DashboardController extends Controller
{
    //*******************THE FUNCTION FOR LISTING NUMBERS OF THE TOURS,PLACES,USERS AND TEAMS FOUND IN DATABASE******************/
    public function index(Request $request) {
       
    	$user = User::where('status',1)->count();

    	$house = House::where('is_deleted',0)->count();

        $people = People::where('is_deleted',0)->count();
         
        $houseTaken = House::where('is_deleted',0)->where('is_taken',1)->count();


        $paid = DB::table('houses')
        ->join('house_peoples','house_peoples.house_id','houses.id')
        ->join('paid_houses','house_peoples.id','paid_houses.house_people_id')
        
        ->whereMonth('paid_houses.created_at', Carbon::now()->month)
        ->where('houses.paid',1)
        ->where('paid_houses.status',1)->count();

        $overdue = DB::table('peoples')
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
        )->count();
        $data = array();

        $data['user'] = $user;
        $data['house'] = $house;
        $data['people'] = $people;
        $data['paid'] = $paid;
        $data['houseTaken'] = $houseTaken;
        $data['overduePay']=$overdue;

		return view('dashboard',$data);
	}

    public function report(){
        $data['report']="Generate Report Here!";
         return view('report',$data);
    }
    public function generateReport(Request $request){
        
        $startDate=$request->from;
        $endDate=$request->end;
        
        $data = DB::table('peoples')
        ->join('house_peoples','peoples.id','house_peoples.people_id')
        ->join('houses','houses.id','house_peoples.house_id')
        ->join('cells','cells.id','houses.cell_id')
        ->join('categories','categories.id','peoples.cat_id')
        ->leftjoin('paid_houses','paid_houses.house_people_id','house_peoples.id')
        // ->distinct()
        ->select('peoples.first_name','peoples.last_name','peoples.phone','houses.status','house_peoples.id','houses.house_code','cells.cell_name','categories.category_name','categories.amount','houses.id as idss','houses.paid')
        ->whereBetween('house_peoples.created_at', [$startDate, $endDate])->get();
        
        $pdf = PDF::loadView('generateReport', compact('data'));
        // return $pdf->download('pdf_file.pdf');
        return view('generateReport',compact('data'));
    }
    // Generate PDF
    public function createPDF() {
        // retreive all records from db
        $startDate=$request->from;
        $endDate=$request->end;
        $data = DB::table('peoples')
        ->join('house_peoples','peoples.id','house_peoples.people_id')
        ->join('houses','houses.id','house_peoples.house_id')
        ->join('cells','cells.id','houses.cell_id')
        ->join('categories','categories.id','peoples.cat_id')
        ->leftjoin('paid_houses','paid_houses.house_people_id','house_peoples.id')
        // ->distinct()
        ->select('peoples.first_name','peoples.last_name','peoples.phone','houses.status','house_peoples.id','houses.house_code','cells.cell_name','categories.category_name','categories.amount','houses.id as idss','houses.paid')
        ->whereBetween('house_peoples.created_at', [$startDate, $endDate])->get();
        // PDF::loadView('generateReport', $data);
        view()->share('generateReport',$data);
        $pdf = PDF::loadView('pdf_view', $data);
  
        // download PDF file with download method
        return $pdf->download('pdf_file.pdf');
      }

}
