<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\UserUpdateRequest;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Auth;
use Hash;
use Exception;
class ProfileController extends Controller
{
    /**
	 * This controller method is used to change admin password
	 *
	 * @param Request $request
	 * @return view
	 */
	public function changePassword(Request $request) {
		$title = 'Change Password';
		return view('role.change_password', compact('title'));
	}

	/**
	 * This controller method is used to update admin password
	 *
	 * @param ChangePasswordRequest $request
	 * @return redirect
	 */
	public function doChangePassword(ChangePasswordRequest $request) {
		(new User)->updateUserInfo(Auth::id(), ['password' => Hash::make($request->password)]);
		$request->session()->flash('success', trans('custom.password_updated'));
		return redirect(route('change-password'));
	}


	 /**
     * This function is used to get edit profile
     *
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Routing\Redirector
     * @author Techaffinity:Karunakarans
     */
    public function edit(Request $request)
    {
    	$user = Auth::user();

    	$id   = $user->id;

        $data['info'] = $info = User::find($id);
        if(!$info) {
            $request->session()->flash('error', "Unable to find user.");
            return redirect(route('manage-edit-profile'))->withInput();
        }
        $data['roles'] = Role::all();
        $data['title'] = "Profile - Edit";
        $data['brVal'] = "Edit Profile";
        return view('manage_users.edit_profile', $data);
    }
    
    /**
     * This function is used to profile update
     *
     * @param SportsUpdateRequest $request
     * @return \Illuminate\View\View|\Illuminate\Routing\Redirector
     * @author Techaffinity:karunakarans
     */

	public function update(UserUpdateRequest $request) {

        $info['fname'] = $request->fname;
        $info['lname'] = $request->lname;
        $info['uname'] = $request->uname;
        $info['email'] = $request->email;
        $info['phone'] = $request->phone;
        $info['status'] = $request->status;
        $info['role']  = $request->role;
        $info['id']    = $request->id;
        $image_name    = $request->hidden_image;
        $info['profile_pic'] = $image_name;
        if($request->profile_pic) {
            $directory = public_path().'/users_pic';
            if (!is_dir($directory)) {
                mkdir($directory);
                chmod($directory, 0777);
            }
            $imageName = strtotime(date('Y-m-d H:i:s')) . '-' . str_replace(' ', '-', $request->file('profile_pic')->getClientOriginalName());
            $request->file('profile_pic')->move($directory, $imageName);
            $info['profile_pic'] = 'users_pic/'.$imageName;
        }
        if((new User)->updateUser($info)) {
            $request->session()->flash('success', "User Info Updated Successfully.");
            return redirect(route('manage-edit-profile'));
        } else {            
            $request->session()->flash('error', "Nothing to update (or) unable to update.");
            return redirect(route('manage-edit-profile'))->withInput();
        }
     }
}
