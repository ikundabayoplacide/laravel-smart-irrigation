<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\DeviceData;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DeviceDataExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;
use App\Notifications\NewUserNotification; // Import the notification class
use Illuminate\Foundation\Validation\ValidatesRequests;

class UserController extends Controller
{
    use ValidatesRequests;

    public function index(Request $request){
        $users = User::with('roles')->paginate(5);
        return view("users.index", compact("users"));
    }

    public function searching(Request $request){
        $searching = $request->search;

        $users = User::where(function($query) use ($searching){
            $query->where('name', 'like', "%$searching%")
                  ->orWhere('email', 'like', "%$searching%");
        })->paginate(5);

        return view('users.index', compact('users', 'searching'));
    }

    public function display(Request $request)
    {
        $data = User::all();

        if ($request->has('download')) {
            if ($request->get('download') === 'pdf') {
                return $this->downloadPdf($data);
            } elseif ($request->get('download') === 'excel') {
                return $this->downloadExcel($data);
            }
        }

        return view('users.index', compact('data'));
    }

    protected function downloadPdf($data)
    {
        Log::info('Generating PDF...');
        $pdf = Pdf::loadView('users.pdf', compact('data'));
        return $pdf->download('users.pdf');
    }
    
    protected function downloadExcel($data)
    {
        Log::info('Generating Excel...');
        return Excel::download(new DeviceDataExport($data), 'users.xlsx');
    }
    

    public function create()
    {
        $roles = Role::pluck("name", "name")->all();
        return view("users.create", compact("roles"));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required',
            'gender' => 'required',
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        $user->assignRole($request->input('roles'));

        $user->notify(new NewUserNotification($user));

        return redirect()->route('users.index')
            ->with('success', 'User created successfully');
    }

    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->route('users.index')->withErrors('User not found');
        }

        return view('users.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles()->pluck('name', 'name')->all();
        
        // Get all distinct device IDs for assignment
        $devices = DeviceData::select('DEVICE_ID')->distinct()->get();
        
        // Get currently assigned device for this user
        $assignedDevice = DeviceData::where('user_id', $user->id)
            ->select('DEVICE_ID')
            ->first();

        return view('users.edit', compact('user', 'roles', 'userRole', 'devices', 'assignedDevice'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'device_id' => 'nullable|exists:device_data,DEVICE_ID',
        ]);

        $user = User::findOrFail($id);

        $user->name = $request->input('name');
        $user->address = $request->input('address');
        $user->phone = $request->input('phone');

        $user->save();
        
        // Handle device assignment for self_farmer users
        if ($user->hasRole('self_farmer') && $request->has('device_id')) {
            // First, remove this device from any other user
            DeviceData::where('DEVICE_ID', $request->device_id)
                ->update(['user_id' => null]);
            
            // Then assign it to this user
            if ($request->device_id) {
                DeviceData::where('DEVICE_ID', $request->device_id)
                    ->update(['user_id' => $user->id]);
            }
        }

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully');
    }

    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully');
    }

    public function notifications(Request $request)
    {
        $notifications = $request->user()->notifications;

        return view('notifications.index', compact('notifications'));
    }
}
