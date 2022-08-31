<?php
  
namespace App\Http\Controllers\Auth;
  
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\User;
use Hash;
use App\Models\Role;
use App\Models\Cell;
use Mail;
use Illuminate\Support\Str;
use DB;
// use App\Mail\NotifyMail;
class AuthController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function welcome(){

        return view('Welcome');
    }
    //index
    public function index()
    {
        return view('Auth.login');
    }  
      
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function registration()
    {
        $role=Role::where('status',1)->get();
        $cell=Cell::where('taken',0)->get();
        $data['cells']=$cell;
        $data['roles']=$role;
        return view('Auth.register',$data);
    }
      
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
   
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            if(Auth::user()->status==1){
            if(Auth::user()->cell_id==null){
            return redirect()->intended('dashboard')
                        ->withSuccess('You have Successfully loggedin');
            }else{
                return redirect('Collector')
                ->withSuccess('You have Successfully loggedin');
            }
        }else{
            return redirect("login")->withError('Oppes! This account has been blocked');
        }
        }
  
        return redirect("login")->withSuccess('Oppes! You have entered invalid credentials');
    }
    
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function postRegistration(Request $request)
    {  
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',

        ]);
        $datas['add']="add user";
        $datas['title']="Users";
        $data = $request->all();
        $update=DB::table('cells')->where('cells.id',$request->cell_id)->update(['taken'=>1]);
        $check = $this->create($data);
        return view("manage-user.index",$datas)->withSuccess('Great! You have Successfully loggedin');
        
    }
    
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function dashboard()
    {
        if(Auth::check()){
            return view('dashboard');
        }
  
        return redirect("login")->withSuccess('Opps! You do not have access');
    }
    
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function create(array $data)
    {
        $password = Str::random(8);

        $data = [
            'subject'=>'USCF Kicukiro',
            'name'=>$data['name'],
            'email' => $data['email'],
            'username' => $data['email'],
            'password'=>$password,
            'role_id'=>$data['role_id'],
            'cell_id'=>$data['cell_id'],
          ];
          Mail::send('emails.profile', $data, function($message) use ($data) {
            $message->to($data['email'])
            ->subject($data['subject']);
          });
        $encryptpassword = Hash::make($password);
      return User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => $encryptpassword,
        'role_id' => $data['role_id'],
        'cell_id'=>$data['cell_id'],
      ]);
    }
    
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function logout() {
        Session::flush();
        Auth::logout();
  
        return Redirect('login');
    }
}