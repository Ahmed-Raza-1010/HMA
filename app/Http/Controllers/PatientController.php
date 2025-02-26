<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
{
  public function index()
  {
    $currentUser = Auth::user();
    $canDelete = $currentUser->can('delete records');
    $patients = Patient::orderBy('name', 'asc')->get();
    return view('patient.index', compact('patients', 'canDelete'));
  }
  
  public function create()
  {
    $currentYear = date('Y');
    $currentMonth = date('m');
    $lastPatient = Patient::whereYear('created_at', $currentYear)
      ->whereMonth('created_at', $currentMonth)
      ->orderBy('created_at', 'desc')
      ->first();
    if ($lastPatient) {
      $lastMRN = $lastPatient->mrn;
      $incrementedMRN = $this->incrementMRN($lastMRN, $currentYear, $currentMonth);
    } else {
      $incrementedMRN = "{$currentYear}-{$currentMonth}-000001";
    }
    return view('patient.create-patient', ['lastMRN' => $incrementedMRN]);
  }

  private function incrementMRN($lastMRN, $currentYear, $currentMonth)
  {
    $yearPart = substr($lastMRN, 0, 4);
    $monthPart = substr($lastMRN, 5, 2);
    $numericPart = intval(substr($lastMRN, -6));
    if ($yearPart === $currentYear && $monthPart === $currentMonth) {
      $newNumericPart = str_pad($numericPart + 1, 6, '0', STR_PAD_LEFT);
    } else {
      $newNumericPart = '000001';
    }
    return "{$currentYear}-{$currentMonth}-{$newNumericPart}";
  }

  public function store(Request $request)
  {
    $patient = Patient::create([
      'mrn' => $request->mrn,
      'name' => $request->name,
      'gender' => $request->gender,
      // 'date_of_birth' => $request->date_of_birth,
      'age' => $request->age,
      'city' => $request->city,
      'phone' => $request->phone,
      'address' => $request->address,
      'height' => $request->height,
      'weight' => $request->weight,
      'pulse' => $request->pulse,
      'blood_pressure' => $request->blood_pressure,
      'temperature' => $request->temperature,
      'respiratory' => $request->respiratory,
    ]);
    return redirect()->route('patient.view', ['id' => $patient->id])
      ->with('success', 'Patient added successfully.');
  }

  public function getFilteredPatientData(Request $request)
  {
    $query = Patient::query();

    // Filter by exact name match
    if ($request->has('name') && $request->name) {
      $query->where('name', $request->name); // Exact match
    }

    // Filter by date
    if ($request->has('filterDate') && $request->filterDate) {
      $query->whereDate('created_at', $request->filterDate);
    }

    $query->orderBy('name', 'asc');
    $patients = $query->get();

    // Adjust the response format
    $data = $patients->map(function ($patient) {
      return [
        'id' => $patient->id,
        'mrn' => $patient->mrn,
        'name' => $patient->name,
        'gender' => $patient->gender,
        // 'date_of_birth' => $patient->date_of_birth,
        'age' => $patient->age,
        'city' => $patient->city,
        'phone' => $patient->phone,
        'address' => $patient->address,
        'date' => $patient->created_at->format('Y-m-d')
      ];
    });

    return response()->json($data);
  }
  public function view($id)
  {
    $patient = Patient::where('id', $id)->firstOrFail();
    return view('patient.view-patient', compact('patient'));
  }

  public function edit($id)
  {
    $patient = Patient::where('id', $id)->firstOrFail();
    return view('patient.edit-patient', compact('patient'));
  }

  public function update(Request $request, $id)
  {
    $patient = Patient::where('id', $id)->firstOrFail();

    $patient->update([
      'mrn' => $request->mrn,
      'name' => $request->name,
      'gender' => $request->gender,
      // 'date_of_birth' => $request->date_of_birth,
      'age' => $request->age,
      'city' => $request->city,
      'phone' => $request->phone,
      'address' => $request->address,
      'height' => $request->height,
      'weight' => $request->weight,
      'pulse' => $request->pulse,
      'blood_pressure' => $request->blood_pressure,
      'temperature' => $request->temperature,
      'respiratory' => $request->respiratory,
    ]);

    return redirect()->route('patient.index')->with('success', 'Patient updated successfully.');
  }

  public function getPatientDetails($id)
  {
    $patient = Patient::where('id', $id)->first();

    if ($patient) {
      return response()->json($patient);
    } else {
      return response()->json(['error' => 'Patient not found'], 404);
    }
  }

  public function destroy($id)
  {
    $patient = Patient::find($id);

    if (!$patient) {
      return redirect()->route('patient.index')->with('error', 'Patient not found.');
    }

    $patient->delete();

    return redirect()->route('patient.index')->with('success', 'Patient deleted successfully.');
  }
}
