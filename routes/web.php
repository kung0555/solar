<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ThingsboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ForgotpasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UsersmanageController;


Route::resource('thingsboard', ThingsboardController::class);
// Route::resource('index', [ThingsboardController::class,'dashboard']);


// Route::get('/thingsboard',[ThingsboardController::class,'index']);
Route::get('/dashboard', [ThingsboardController::class, 'dashboard']);
// Route::get('/thingsboard/billing',[ThingsboardController::class,'billing']);

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

//home
Route::get('/admin', function () {
    return view('/admin/parameter/allvalue');
});

// Route::get('/', function () {
//     return view('home');
// })->middleware('check');
// Route::get('/home', function () {
//     return view('home');
// })->name('home');
Route::get('/', [HomeController::class, 'index'])->name('home')->middleware('check');

Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('check');

Route::get('/user_home', [HomeController::class, 'user_home'])->name('user_home');


// parameter
Route::get('/admin/parameter/allparameter', [AdminController::class, 'index'])->name('allparameter')->middleware('check');
// Route::get('/admin/parameter/parameterAddForm',[AdminController::class,'parameterAddForm'])->name('parameterAddForm')->middleware('check');
Route::get('/admin/parameter/parameterAddForm', function () {
    return view('/admin/parameter/parameterAddForm');
})->name('parameterAddForm')->middleware('check');
Route::post('/admin/parameter/parameterAddChk', [AdminController::class, 'parameterAddChk'])->name('parameterAddChk')->middleware('check');
Route::get('/admin/parameter/parameterEditID/{id}', [AdminController::class, 'parameterEditID'])->name('parameterEditID')->middleware('check');
Route::get('/admin/parameter/parameterEditForm', [AdminController::class, 'parameterEditForm'])->name('parameterEditForm')->middleware('check');
Route::post('/admin/parameter/parameterEditChk/{id}', [AdminController::class, 'parameterEditChk'])->name('parameterEditChk')->middleware('check');
Route::get('/admin/parameter/parameterDelete/{id}', [AdminController::class, 'parameterDelete'])->name('parameterDelete')->middleware('check');



// contract
Route::get('/admin/contract/contractAddForm', function () {
    return view('/admin/contract/contractAddForm');
})->name('contractAddForm')->middleware('check');
Route::get('/admin/contract/contractView', [AdminController::class, 'contractView'])->name('contractView')->middleware('check');
Route::get('/admin/contract/contractEditForm', [AdminController::class, 'contractEditForm'])->name('contractEditForm')->middleware('check');
Route::post('/admin/contract/contractChk', [AdminController::class, 'contractChk'])->name('contractChk')->middleware('check');


//billing
Route::get('/admin/billing/billingAuto', [AdminController::class, 'billingAuto'])->name('billingAuto');

Route::get('/admin/billing/allBillings', [AdminController::class, 'allBillings'])->name('allBillings')->middleware('check');
Route::get('/admin/billing/billingManualAuto', [AdminController::class, 'billingManualAuto'])->name('billingManualAuto')->middleware('check');
Route::post('/admin/billing/billingManualAutoChk', [AdminController::class, 'billingManualAutoChk'])->name('billingManualAutoChk')->middleware('check');
Route::get('/admin/billing/billingManualAdd', [AdminController::class, 'billingManualAdd'])->name('billingManualAdd')->middleware('check');
Route::post('/admin/billing/billingManualAddChk', [AdminController::class, 'billingManualAddChk'])->name('billingManualAddChk')->middleware('check');
Route::get('/admin/billing/billingPDF', [AdminController::class, 'billingPDF'])->name('billingPDF')->middleware('check');
Route::get('/admin/billing/billingSendEmail/{id}', [AdminController::class, 'billingSendEmail'])->name('billingSendEmail')->middleware('check');
// Route::get('/admin/billing/billingManual', function () {
//     return view('/admin/billing/billingManual');
// })->name('billingManual')->middleware('check');

//data
Route::get('/admin/data/viewData', [AdminController::class, 'viewData'])->name('viewData')->middleware('check');
Route::get('/admin/data/viewGain', [AdminController::class, 'viewGain'])->name('viewGain')->middleware('check');
Route::get('/admin/data/gainEditID/{id}', [AdminController::class, 'gainEditID'])->name('gainEditID')->middleware('check');
Route::post('/admin/data/gainChk/{id}', [AdminController::class, 'gainChk'])->name('gainChk')->middleware('check');


//pdf
Route::get('generatePDF', [PDFController::class, 'generatePDF']);

//sendmail
Route::get('sendmail', [AdminController::class, 'sendmail']);


// Login
Route::group(['middleware' => ['guest']], function () {
    Route::get('/login', function () {
        return view('/auth/login');
    })->name('login');

    Route::post('loginChk', [LoginController::class, 'loginChk'])->name('loginChk');
});
// Route::group(['middleware' => ['prevent-back-history','otherMiddlewares']], function () {
//     // Auth::routes();
//     Route::get('/login', function () {
//         return view('/auth/login');
//     })->name('login');

//     Route::post('loginChk', [LoginController::class, 'loginChk'])->name('loginChk');
// });



//register
// Route::get('/register', function () {
//     return view('/auth/register');
// })->name('register');
Route::get('/register', [RegisterController::class, 'show'])->name('register');
Route::post('/registerChk', [RegisterController::class, 'registerChk'])->name('registerChk');


//forget password

Route::get('/forgot_password', [ForgotpasswordController::class, 'showForgot'])->name('forgot_password');
Route::post('/forgotChk', [ForgotpasswordController::class, 'forgotChk'])->name('forgotChk');

//recover password
Route::get('/recover_password/{token}/{email}', [ResetPasswordController::class, 'showRecover_password'])->name('recover_password');
Route::post('/recover_passwordChk', [ResetPasswordController::class, 'recover_passwordChk'])->name('recover_passwordChk');

// Route::get('/recover_password', function () {
//     return view('/auth/recover_password');
// })->name('recover_password');

Route::group(['middleware' => ['auth']], function () {

    Route::get('/logout', [LogoutController::class, 'logout'])->name('logout');

    Route::get('/admin/users/viewUsers', [UsersmanageController::class, 'viewUsers'])->name('viewUsers');
    Route::get('/admin/users/userEdit/{id}', [UsersmanageController::class, 'userEdit'])->name('userEdit');
    Route::post('/admin/users/updateUserChk/{id}', [UsersmanageController::class, 'updateUserChk'])->name('updateUserChk');
});
