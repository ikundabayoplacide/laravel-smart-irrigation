<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Farmer;
use App\Models\DeviceData;
use App\Models\Cooperative;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DeviceDataExport; // We'll need to create or reuse this
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        $districts = Farmer::select('district')->distinct()->pluck('district');
        $cooperatives = Cooperative::all();
        return view('reports.index', compact('districts', 'cooperatives'));
    }

    public function generate(Request $request)
    {
        $type = $request->input('type');
        $format = $request->input('format', 'pdf');

        if ($type === 'farmers') {
            return $this->generateFarmerReport($request, $format);
        } elseif ($type === 'devices') {
            return $this->generateDeviceReport($request, $format);
        }

        return redirect()->back()->with('error', 'Invalid report type selected.');
    }

    private function generateFarmerReport(Request $request, $format)
    {
        $query = Farmer::query();

        if ($request->filled('district')) {
            $query->where('district', $request->district);
        }
        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }
        // Add more filters as needed

        $farmers = $query->get();
        $filters = $request->only(['district', 'gender']);

        if ($format === 'pdf') {
            $pdf = Pdf::loadView('reports.pdf.farmers', compact('farmers', 'filters'));
            return $pdf->download('farmers_report_' . date('Y-m-d') . '.pdf');
        }

        // Implement Excel if needed
        return redirect()->back()->with('error', 'Excel format not supported for farmers yet.');
    }

    private function generateDeviceReport(Request $request, $format)
    {
        $query = DeviceData::query();

        if ($request->filled('status')) {
            // Assuming 'device_state' 1=Active, 0=Inactive or similar logic
            // Adjust based on your actual column values
             $query->where('device_state', $request->status);
        }

        $devices = $query->with('farmer')->get();
        $filters = $request->only(['status']);

        if ($format === 'pdf') {
            $pdf = Pdf::loadView('reports.pdf.devices', compact('devices', 'filters'));
            return $pdf->download('devices_report_' . date('Y-m-d') . '.pdf');
        }
        
        // Reuse existing export or create new one
        // return Excel::download(new DeviceDataExport($devices), 'devices_report.xlsx');
         return redirect()->back()->with('error', 'Excel format not supported for devices yet.');
    }
}
