<?php

namespace App\Http\Controllers;

use App\Models\DeviceData;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Hash;
use App\Models\Farmer;
use Illuminate\Http\Request;


use App\Notifications\NewFarmerNotification;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\FarmerExport;
class FarmersController extends Controller
{
    public function index()
    {
        // $farmers=Farmer::all();
         $farmers= Farmer::paginate(7);

        return view('farmers.index', compact('farmers'));
    }
   public function search(Request $request){
    $search=$request->search;
    $farmers=Farmer::where(function($query) use ($search){
        $query->where('name','like',"%$search%")
                ->orWhere('email','like',"%$search%");
    })->paginate(7);

    return view('farmers.index',compact('farmers','search'));


   }

   public function display(Request $request){
$farmers=Farmer::paginate(7);

if($request->has('download')){
    $format=$request->get('download');
    if ($format === 'pdf') {

        $pdf = Pdf::loadView('farmers.pdf', ['data' => $farmers]);
        return $pdf->download('farmers.pdf');
    }
    elseif ($format === 'excel') {

        return Excel::download(new FarmerExport($farmers), 'farmers.xlsx');
    }
    elseif ($format === 'csv') {

        $csvData = $farmers->map(function ($farmer) {
            return implode(',', [
                $farmer->id,
                $farmer->name,
                $farmer->email,
                $farmer->district,
                $farmer->phone,
            ]);
        })->implode("\n");

        return response($csvData)
        ->header('Content-Type', 'text/csv')
        ->header('Content-Disposition', 'attachment; filename="farmers.csv"');
}}
$farmers = Farmer::paginate(7);
return view('farmers.index', compact('farmers'));

}

protected function downloadPdf($data)
{
    $pdf = Pdf::loadView('farmers.pdf', compact('farmers'));
    return $pdf->download('farmers.pdf');
}

protected function downloadExcel($data)
{
    return Excel::download(new FarmerExport($data), 'farmers.xlsx');
}



    public function create(Request $request)
    {
        // $devices = DeviceData::all();
        $devices = DeviceData::select('DEVICE_ID')->distinct()->get();
        $cooperatives = \App\Models\Cooperative::all();
        // dd($devices)
        return view('farmers.register', compact('devices', 'cooperatives'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'province' => 'required',
            'district' => 'required',
            'sector' => 'required',
            'cell' => 'required',
            'phone' => 'required',
            'password' => 'required',
            'gender' => 'required',
            'cooperative_id' => 'nullable|exists:cooperatives,id',
        ]);

        $farmer = Farmer::create([
            'name' => $request->name,
            'email' => $request->email,
            'province' => $request->province,
            'district' => $request->district,
            'sector' => $request->sector,
            'cell' => $request->cell,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'gender' => $request->gender,
            'cooperative_id' => $request->cooperative_id,
        ]);

        // Find the device using DEVICE_ID
        $device = DeviceData::where('DEVICE_ID', $request->device_id)->first();
        if ($device) {
            $device->farmer_id = $farmer->id;
            $device->device_state = 1;
            $device->save();
        }



        return redirect()->route('farmers.index')->with('success', 'Farmer created successfully');
    }

    public function show(Farmer $farmers)
    {
        return view('farmers.show', compact('farmers'));
    }

    public function edit(Farmer $farmers)
    {
        $devices = DeviceData::select('DEVICE_ID')->distinct()->get();
        $cooperatives = \App\Models\Cooperative::all();
        return view('farmers.edit', compact('farmers', 'devices', 'cooperatives'));
    }

    public function update(Request $request, Farmer $farmers)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'province' => 'required',
            'district' => 'required',
            'sector' => 'required',
            'cell' => 'required',
            'phone' => 'required',
            'cooperative_id' => 'nullable|exists:cooperatives,id',
        ]);

        $farmers->update($request->all());

        // Find the device using DEVICE_ID
        $device = DeviceData::where('DEVICE_ID', $request->device_id)->first();
        if ($device) {
            $device->farmer_id = $farmers->id;
            $device->device_state = 1;
            $device->save();
        } else {
            return redirect()
                ->back()
                ->with('error', 'Device not found.');
        }

        return redirect()->route('farmers.index')->with('success', 'Farmer updated successfully');
    }

    public function destroy(Farmer $farmers)
    {
        $farmers->delete();

        return redirect()
            ->route('farmers.index')
            ->with('success', 'Farmer has been deleted successfully.');
    }

    public function notifications(Request $request)
    {
        $notifications = $request->user()->notifications;

        return view('notifications.index', compact('notifications'));
    }
}
