<?php

namespace App\Http\Controllers;

use App\Models\Cooperative;
use App\Models\DeviceData;
use App\Models\Farmer;
use App\Models\Membership;
use Illuminate\Http\Request;

class cooperativeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   $cooperatives = Cooperative::paginate(5);
        $memberships = Membership::paginate(10);

        $farmers = Farmer::all(); // Get all farmers

        return view('cooperatives.index', compact('cooperatives', 'farmers'));
    }

    public function searching(Request $request){
        $searching = $request->search;

        $cooperatives = Cooperative::where(function($query) use ($searching){
            $query->where('name', 'like', "%$searching%")
                  ->orWhere('location', 'like', "%$searching%")
                  ->orWhere('services_offered','like',"%$searching");
        })->paginate(5);

        return view('cooperatives.index', compact('cooperatives', 'searching'));
    }
    public function create()
    {
        $farmers=Farmer::all();
        $devices = DeviceData::select('DEVICE_ID')->distinct()->get();
        return view('cooperatives.create',compact('farmers', 'devices'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'province' => 'required',
            'district' => 'required',
            'sector' => 'required',
            'cell' => 'required',
            'device_id' => 'required|exists:device_data,DEVICE_ID',
            'services' => 'required|array|min:1',
        ]);

        $data = $request->all();
        // Convert services array to comma-separated string
        $data['services_offered'] = implode(', ', $request->services);
        // Create location from detailed location fields
        $data['location'] = $request->province . ', ' . $request->district . ', ' . $request->sector . ', ' . $request->cell;

        Cooperative::create($data);
        return redirect()->route('cooperatives.index')->with('success', 'Cooperative created successfully');

    }

    public function show(Cooperative $cooperative)
    {
        return view('cooperatives.show', compact('cooperative'));
    }

    public function edit(Cooperative $cooperative)
    {
        $devices = DeviceData::select('DEVICE_ID')->distinct()->get();
        return view('cooperatives.edit', compact('cooperative', 'devices'));
    }

    public function update(Request $request, Cooperative $cooperative)
    {
        $request->validate([
            'name' => 'required',
            'province' => 'required',
            'district' => 'required',
            'sector' => 'required',
            'cell' => 'required',
            'device_id' => 'required|exists:device_data,DEVICE_ID',
            'services' => 'required|array|min:1',
        ]);

        $data = $request->all();
        // Convert services array to comma-separated string
        $data['services_offered'] = implode(', ', $request->services);
        // Create location from detailed location fields
        $data['location'] = $request->province . ', ' . $request->district . ', ' . $request->sector . ', ' . $request->cell;

        $cooperative->update($data);
        return redirect()->route('cooperatives.index')->with('success', 'Cooperative updated successfully');
    }

    public function destroy(Cooperative $cooperative)
    {
        $cooperative->delete();
        return redirect()->route('cooperatives.index');
    }
// This is About Details



    public function showAssignForm()
    {

        $cooperatives = Cooperative::all();
        $farmers = Farmer::all();


        return view('cooperatives.assign', compact('cooperatives', 'farmers'));
    }


    public function assignFarmerToCooperative(Request $request)
    {
        $request->validate([
            'cooperative_id' => 'required|exists:cooperatives,id',
            'farmer_id' => 'required|exists:farmers,id',
        ]);

        $cooperative = Cooperative::findOrFail($request->cooperative_id);
        $dataInfo = Farmer::findOrFail($request->farmer_id);



        $assignmentData = [
            'member_name' => $dataInfo->name,
            'cooperative_name' => $cooperative->name,
            'location' => $cooperative->location,
        ];

        Membership::create($assignmentData);

        $details=Membership::all();
        // $memberships=membership::all();
        $memberships = Membership::paginate(10);




        // return redirect()->route('cooperatives.showAssignmentDetails')
        //     ->with('success', 'Farmer assigned successfully.')
        //     ->with('details', $details);

            return view('memberships.index', compact('details','memberships'));



    }

    public function showAssignmentDetails()
    {
        $details = session('details', []);
        return view('cooperatives.assignment_details', compact('details'));
    }


}