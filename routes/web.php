<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ManageHouseController;
use App\Http\Controllers\ManagePeopleController;
use App\Http\Controllers\ManageCollectorController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\ChangePasswordController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return redirect(route('Welcome'));
// });
Route::get('/access-denied', function(){
    return view('access_denied');
})->name('access-denied');

Route::get('/', [AuthController::class, 'welcome'])->name('welcome');
Route::get('/forget-password', [PasswordResetLinkController::class, 'create'])->name('forget');
Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post'); 
Route::get('logout', [AuthController::class, 'logout'])->name('logout');



Route::group(['middleware' => ['all']], function () {

Route::get('change-password', [ChangePasswordController::class,'index'])->name('change-password');
Route::post('change-password', [ChangePasswordController::class,'store'])->name('change.password');

Route::group(['middleware' => ['truck']], function () {
Route::get('registration', [AuthController::class, 'registration'])->name('register');
Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post'); 

Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');

Route::get('/users', [UserController::class, 'index'])->name('manage-user.index');
Route::get('/houses', [ManageHouseController::class, 'index'])->name('manage-house.index');
Route::get('/people',[ManagePeopleController::class,'index'])->name('manage-people.index');
Route::post('/status', [ManagePeopleController::class,'status'])->name('manage-people-status');
Route::get('/HousesAllPaid', [ManageHouseController::class,'paidAllHouse'])->name('paidAllHouse');
Route::post('/status-user',[UserController::class,'status'])->name('manage-status');
Route::get('/sendSMS',[ManagePeopleController::class,'sendSMS'])->name('send');
Route::get('new', [ManagePeopleController::class, 'addPeople'])->name('add');
Route::get('/reset',[ManageHouseController::class,'reset'])->name('reset');
Route::any('/report',[DashboardController::class,'report'])->name('report');
Route::any('/generatedReport',[DashboardController::class,'generateReport'])->name('generatedReport');
Route::get('/overduePay', [ManageHouseController::class,'overduePay'])->name('overduePay');
Route::get('/pdf', [DashboardController::class, 'createPDF'])->name('pdf');
Route::get('edit-user/{id}', [UserController::class, 'edit'])->name('edit-user');
Route::any('update-user', [UserController::class, 'update'])->name('update-user');
});

Route::group(['middleware' => ['collector']], function () {
Route::get('/Collector', [ManageCollectorController::class,'index'])->name('Collector');
Route::get('/Houses', [ManageHouseController::class,'showHouse'])->name('showHouse');
Route::get('/house-cell', [ManageHouseController::class, 'show'])->name('Manage-collector.house');
Route::post('/add-house', [ManageHouseController::class, 'store'])->name('add-house');
Route::get('/new-house', [ManageHouseController::class, 'addHouse'])->name('new-house');
Route::post('/status-house',[ManageHouseController::class,'status'])->name('manage-house-status');
Route::post('/delete-house/{id}',[ManageHouseController::class,'delete'])->name('manage-house-delete');
Route::get('/edit-house',[ManageHouseController::class,'update'])->name('manage-house-edit');
Route::get('new', [ManagePeopleController::class, 'addPeople'])->name('add');
Route::any('/new-people', [ManagePeopleController::class, 'store'])->name('add-people');
Route::get('/peoples-cell',[ManagePeopleController::class,'showPeople'])->name('showPeople');
Route::post('/approve-payment',[ManagePeopleController::class,'pay'])->name('manage-payment');
Route::get('/HousesPaid', [ManageHouseController::class,'paidHouse'])->name('paidHouse');

Route::get('/overdue', [ManageHouseController::class,'overdue'])->name('overdue');
Route::get('edit-people/{id}', [ManagePeopleController::class, 'edit'])->name('edit-people');
Route::any('update-people', [ManagePeopleController::class, 'update'])->name('update-people');
});
});