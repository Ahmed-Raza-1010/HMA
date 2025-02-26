<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\OpdCase;
use App\Models\Patient;
use App\Models\Medicine;
use App\Models\Medication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OpdCaseController extends Controller
{
  public function index()
  {
    $currentUser = Auth::user();
    $canDelete = $currentUser->can('delete records');
    $opdCases = OpdCase::with('patient')->orderBy('created_at', 'desc')->get();
    return view('opd_case.index', compact('opdCases', 'canDelete'));
  }

  public function create()
  {
    $opdCases = OpdCase::with('patient')->get();
    $doctors = User::all();
    $medications = Medication::all();
    $patients = Patient::orderBy('created_at', 'desc')->get();
    return view('opd_case.create-opd', compact('opdCases', 'doctors', 'patients', 'medications'));
  }

  public function getFilteredOpdData(Request $request)
  {
    $query = OpdCase::query();
    // Filter by exact name match
    if ($request->has('name') && $request->name) {
      $query->whereHas('patient', function ($q) use ($request) {
        $q->where('name', $request->name); // Exact match
      });
    }
    // Filter by date
    if ($request->has('filterDate') && $request->filterDate) {
      $query->whereDate('created_at', $request->filterDate);
    }

    $query->orderBy('created_at', 'desc');
    $opdCases = $query->get();

    // Adjust the response format
    $data = $opdCases->map(function ($opdCase) {
      return [
        'id' => $opdCase->id,
        'patient_id' => $opdCase->patient->mrn,
        'doctor_id' => $opdCase->doctor->id,
        'name' => $opdCase->patient->name,
        'gender' => $opdCase->patient->gender,
        // 'date_of_birth' => $opdCase->patient->date_of_birth,
        'city' => $opdCase->patient->city,
        'phone' => $opdCase->patient->phone,
        'address' => $opdCase->patient->address,
        'visit_no' => $opdCase->visit_no,
        'respiratory' => $opdCase->patient->respiratory,
        'appointment_date' => $opdCase->appointment_date,
        'presenting_complaint' => $opdCase->presenting_complaint,
        'history' => $opdCase->history,
        'provisional_diagnose' => $opdCase->provisional_diagnose,
        'treatment' => $opdCase->treatment,
        'special_instruction' => $opdCase->special_instruction,
        'follow_up_days' => $opdCase->follow_up_days,
      ];
    });

    return response()->json($data);
  }
  public function store(Request $request)
  {
    $opdCase = OpdCase::create([
      'patient_id' => $request->patient_id,
      'doctor_id' => $request->doctor_id,
      'visit_no' => $request->visit_no,
      'appointment_date' => $request->appointment,
      'presenting_complaint' => $request->complaint,
      'history' => $request->history,
      'provisional_diagnose' => $request->diagnose,
      'treatment' => $request->treatment,
      'special_instruction' => $request->instruction,
      'follow_up_days' => $request->follow_up,
    ]);

    foreach ($request->medicine as $index => $medicine) {
      Medicine::create([
        'opd_case_id' => $opdCase->id,
        'medicine_name' => $request->medicine[$index],
        'dose' => $request->dose[$index],
        'frequency' => $request->frequency[$index],
        'duration' => $request->duration[$index],
      ]);
    }
    return redirect()->route('opd-case.view', ['id' => $opdCase->id])
      ->with('success', 'OPD Case added successfully.');
  }


  public function view($opdCase)
  {
    $doctors = User::all();
    $opdCase = OpdCase::with('medicine')->where('id', $opdCase)->firstOrFail();
    return view('opd_case.view-opd', compact('opdCase', 'doctors'));
  }

  public function edit($opdCase)
  {
    $doctors = User::all();
    $opdCase = OpdCase::with('medicine')->where('id', $opdCase)->firstOrFail();
    $medications = Medication::all();
    return view('opd_case.edit-opd', compact('opdCase', 'doctors', 'medications'));
  }

  public function update(Request $request, $id)
  {
    $opdCase = OpdCase::where('id', $id)->firstOrFail();

    $opdCase->update([
      'doctor_id' => $request->doctor_id,
      'visit_no' => $request->visit_no,
      'appointment_date' => $request->appointment,
      'presenting_complaint' => $request->complaint,
      'history' => $request->history,
      'provisional_diagnose' => $request->diagnose,
      'treatment' => $request->treatment,
      'special_instruction' => $request->instruction,
      'follow_up_days' => $request->follow_up,
    ]);

    $opdCase->medicine()->delete();

    foreach ($request->medicine as $index => $medicine) {
      Medicine::create([
        'opd_case_id' => $opdCase->id,
        'medicine_name' => $medicine,
        'dose' => $request->dose[$index],
        'frequency' => $request->frequency[$index],
        'duration' => $request->duration[$index],
      ]);
    }

    return redirect()->route('opd-case.index')->with('success', 'OPD Case updated successfully.');
  }

  public function getOpdDetails($id)
  {
    $opdCase = OpdCase::with(['patient', 'doctor'])->where('id', $id)->first();

    if ($opdCase) {
      return response()->json($opdCase);
    } else {
      return response()->json(['error' => 'OPD Case not found'], 404);
    }
  }

  public function destroy($id)
  {
    $opdCase = OpdCase::find($id);

    if (!$opdCase) {
      return redirect()->route('opd-case.index')->with('error', 'OPD Case not found.');
    }

    $opdCase->delete();

    return redirect()->route('opd-case.index')->with('success', 'OPD Case deleted successfully.');
  }
}
