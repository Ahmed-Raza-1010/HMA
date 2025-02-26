<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\IpdCase;
use App\Models\Medicine;
use App\Models\Medication;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IpdCaseController extends Controller
{
  public function index()
  {
    $currentUser = Auth::user();
    $canDelete = $currentUser->can('delete records');
    $patients = Patient::orderBy('created_at', 'desc')->get();
    $doctors = User::orderBy('created_at', 'desc')->get();
    return view('ipd_cases.index', compact('patients', 'doctors', 'canDelete'));
  }
  public function create()
  {
    $ipdCases = ipdCase::with('patient')->get();
    $doctors = User::all();
    $medications = Medication::all();
    $patients = Patient::orderBy('created_at', 'desc')->get();
    return view('ipd_cases.create-ipd', compact('ipdCases', 'doctors', 'patients', 'medications'));
  }
  public function store(Request $request)
  {
    $ipdCase = ipdCase::create([
      'patient_id' => $request->patient_id,
      'doctor_id' => $request->doctor_id,
      'visit_no' => $request->visit_no,
      'respiratory' => $request->respiratory,
      'appointment_date' => $request->appointment,
      'presenting_complaint' => $request->complaint,
      'history' => $request->history,
      'provisional_diagnose' => $request->diagnose,
      'treatment' => $request->treatment,
      'special_instruction' => $request->instruction,
      'bed' => $request->bed,
      'follow_up_days' => $request->follow_up,
    ]);

    foreach ($request->medicine as $index => $medicine) {
      Medicine::create([
        'ipd_case_id' => $ipdCase->id,
        'medicine_name' => $request->medicine[$index],
        'dose' => $request->dose[$index],
        'frequency' => $request->frequency[$index],
        'duration' => $request->duration[$index],
      ]);
    }
    return redirect()->route('ipd-case.view', ['id' => $ipdCase->id])
      ->with('success', 'IPD Case added successfully.');
  }
  public function getFilteredIPDData(Request $request)
  {
    $query = IpdCase::query();

    // Filter by patient number
    if ($request->has('patient_name') && $request->patient_name) {
      $query->whereHas('patient', function ($query) use ($request) {
        $query->where('name', $request->patient_name); // Assuming the patient's name field is 'name'
      });
    }
    // Filter by appointment_date
    if ($request->has('appointment_date') && $request->appointment_date) {
      $query->where('appointment_date', 'LIKE', '%' . $request->appointment_date . '%'); // Partial match
    }

    $query->orderBy('created_at', 'desc');
    $ipdCases = $query->get();

    // Adjust the response format
    $data = $ipdCases->map(function ($ipdCase) {
      return [
        'id' => $ipdCase->id,
        'bed' => $ipdCase->bed,
        'history' => $ipdCase->history,
        'appointment_date' => $ipdCase->appointment_date,
        'provisional_diagnose' => $ipdCase->provisional_diagnose,
        'patient_name' => $ipdCase->patient->name,
        'patient_id' => $ipdCase->patient->id,
        'doctor_name' => $ipdCase->doctor->name,
        'gender' => $ipdCase->patient->gender,
        'phone' => $ipdCase->patient->phone,
      ];
    });

    return response()->json($data);
  }

  public function getIPDCaseDetails($id)
  {
    // Fetch IPD case along with the related Patient data
    $ipdCase = IPDCase::with(['patient', 'doctor'])->where('id', $id)->first();

    if ($ipdCase) {
      // Prepare the response data
      $response = [
        'doctor_name' => $ipdCase->doctor ? $ipdCase->doctor->name : 'N/A',
        'patient_name' => $ipdCase->patient ? $ipdCase->patient->name : 'N/A',
        'patient_id' => $ipdCase->patient ? $ipdCase->patient->id : 'N/A',
        'gender' => $ipdCase->patient ? $ipdCase->patient->gender : 'N/A',
        'phone' => $ipdCase->patient ? $ipdCase->patient->phone : 'N/A',
        'provisional_diagnose' => $ipdCase->provisional_diagnose,
        'appointment_date' => $ipdCase->appointment_date,
        'history' => $ipdCase->history,
        // 'date_of_birth' => $ipdCase->patient->date_of_birth,
        'city' => $ipdCase->patient->city,
        'address' => $ipdCase->patient->address,
        'visit_no' => $ipdCase->visit_no,
        'presenting_complaint' => $ipdCase->presenting_complaint,
        'treatment' => $ipdCase->treatment,
        'special_instruction' => $ipdCase->special_instruction,
        'follow_up_days' => $ipdCase->follow_up_days,
      ];
      return response()->json($response);
    } else {
      return response()->json(['error' => 'IPD case not found'], 404);
    }
  }

  public function destroy($id)
  {
    try {
      // Find the IPD case by ID
      $ipdCase = IpdCase::findOrFail($id);

      // Delete the IPD case
      $ipdCase->delete();

      // Return success response
      return redirect()->back()->with('success', 'IPD case deleted successfully.');
    } catch (\Exception $e) {
      // Return error response
      return redirect()->back()->with('error', 'Error deleting IPD case.');
    }
  }


  public function view($ipdCase)
  {
    $doctors = User::all();
    $ipdCase = ipdCase::with('medicine')->where('id', $ipdCase)->firstOrFail();
    return view('ipd_cases.view-ipd', compact('ipdCase', 'doctors'));
  }

  public function edit($ipdCase)
  {
    $doctors = User::all();
    $ipdCase = ipdCase::with('medicine')->where('id', $ipdCase)->firstOrFail();
    $medications = Medication::all();
    return view('ipd_cases.edit-ipd', compact('ipdCase', 'doctors', 'medications'));
  }

  public function update(Request $request, $id)
  {
    $ipdCase = ipdCase::where('id', $id)->firstOrFail();

    $ipdCase->update([
      'doctor_id' => $request->doctor_id,
      'visit_no' => $request->visit_no,
      'appointment_date' => $request->appointment,
      'presenting_complaint' => $request->complaint,
      'history' => $request->history,
      'provisional_diagnose' => $request->diagnose,
      'treatment' => $request->treatment,
      'special_instruction' => $request->instruction,
      'follow_up_days' => $request->follow_up,
      'bed' => $request->bed,

    ]);

    $ipdCase->medicine()->delete();

    foreach ($request->medicine as $index => $medicine) {
      Medicine::create([
        'ipd_case_id' => $ipdCase->id,
        'medicine_name' => $medicine,
        'dose' => $request->dose[$index],
        'frequency' => $request->frequency[$index],
        'duration' => $request->duration[$index],
      ]);
    }

    return redirect()->route('ipd-case.index')->with('success', 'IPD Case updated successfully.');
  }
}
