<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\AdminRegistationController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\cooperativeController;
use App\Http\Controllers\DeviceDataController;
use App\Http\Controllers\FarmersController;
use App\Http\Controllers\HighChartController;
use App\Http\Controllers\SettingsController;



Route::get('/', function () {
    return view('home.home');
})->name('home');


// Locale Change Route
Route::get('/lang',[LanguageController::class , 'change'])->name('user.lang');

// Public Registration Routes
Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'index'])->name('user.register');
Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'store'])->name('user.register.store');

// Admin authentication routes
Route::get('admin/register', [AdminRegistationController::class, 'create'])->name('admin.register');
Route::post('admin/register', [AdminRegistationController::class, 'store'])->name('admin.store');
Route::get('/login', [AdminLoginController::class, 'index'])->name('admin.login')->middleware('clear_cookies');
Route::post('admin/check', [AdminLoginController::class, 'admincheck'])->name('admin.check');
Route::get('/farmers/display', [FarmersController::class, 'display'])->name('farmers.display');

// Reporting Routes
Route::get('/reports', [App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');
Route::post('/reports/generate', [App\Http\Controllers\ReportController::class, 'generate'])->name('reports.generate');
Route::get('/weather', [App\Http\Controllers\WeatherController::class, 'index'])->name('weather.index');


// Authenticated routes
Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::get('/searching',[UserController::class,'searching']);
    Route::get('/searching',[cooperativeController::class,'searching']);
    Route::get('/searches',[RoleController::class,'searches']);

    Route::get('/search',[FarmersController::class,'search']);
    Route::get('farmers/index', [FarmersController::class, 'index'])->name('farmers.index');
    Route::get('farmers/create', [FarmersController::class, 'create'])->name('farmers.register');
    Route::post('farmers', [FarmersController::class, 'store'])->name('farmers.store');
    Route::get('/farmers/{farmers}', [FarmersController::class, 'show'])->name('farmers.show');
    Route::put('/farmers/{farmers}', [FarmersController::class, 'update'])->name('farmers.update');
    Route::delete('farmers/{farmers}', [FarmersController::class, 'destroy'])->name('farmers.destroy');
    Route::get('farmers/{farmers}/edit', [FarmersController::class, 'edit'])->name('farmers.edit');


    Route::get('/admin/dashboard', [AdminDashboardController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout')->middleware('clear_cookies');
    Route::get('/role/add', [RoleController::class, 'add'])->name('role.add');
    Route::get('role/edit/{id}', [RoleController::class, 'edit']);
    Route::get('role/delete/{id}', [RoleController::class, 'delete']);
    Route::post('role/edit/{id}', [RoleController::class, 'update']);
    Route::get('role/list', [RoleController::class, 'list'])->name('role.list');
    Route::post('/role/add', [RoleController::class, 'store'])->name('role.store');

    Route::get('device_data', [DeviceDataController::class, 'index'])->name('device_data.index');
    Route::get('tabular', [DeviceDataController::class, 'display'])->name('device_data.visualizeData');


    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/download', [UserController::class, 'display'])->name('users.download');

   Route::get('/device-data/display', [DeviceDataController::class, 'display'])->name('device_data.display');
  Route::get('/users/display',[UserController::class,'display'])->name('users.display');
    Route::get('device_data/create', [DeviceDataController::class, 'create'])->name('device_data.create');
    Route::post('device_data', [DeviceDataController::class, 'store'])->name('device_data.store');
    Route::get('/device_data/{device_data}', [DeviceDataController::class, 'show'])->name('device_data.show');
    Route::put('device_data/{device_data}', [DeviceDataController::class, 'update'])->name('device_data.update');
    Route::delete('device_data/{device_data}', [DeviceDataController::class, 'destroy'])->name('device_data.destroy');
    Route::get('device_data/{device_data}/edit', [DeviceDataController::class, 'edit'])->name('device_data.edit');
    Route::post('device_data/toggle/{id}', [DeviceDataController::class, 'toggle'])->name('device_data.toggle');
    Route::get('tabular', [DeviceDataController::class, 'display'])->name('device_data.visualizeData');
    Route::delete('/device_data/delete/{device_id}', [DeviceDataController::class, 'delete'])->name('device_data.delete');


    Route::resource('cooperatives', cooperativeController::class);
    Route::get('/assign', [CooperativeController::class, 'showAssignForm'])->name('cooperatives.showAssignForm');
    Route::post('/cooperatives/assign', [CooperativeController::class, 'assignFarmerToCooperative'])->name('cooperatives.assign');
    Route::get('cooperative/assignment-details', [CooperativeController::class, 'showAssignmentDetails'])->name('cooperatives.showAssignmentDetails');
    Route::get('/testChart',[HighChartController::class,'visual']);

    // Settings Route
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    
    // Profile Routes
    Route::get('/profile/edit', [SettingsController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile/update', [SettingsController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/password/change', [SettingsController::class, 'changePassword'])->name('profile.password.change');




});

Route::get('/sse', [App\Http\Controllers\SSEController::class, 'stream']);



Route::get('/device-data/{device_id}', [DeviceDataController::class, 'showByDeviceId'])->name('device_data.showByDeviceId');