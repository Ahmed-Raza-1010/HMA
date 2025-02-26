<?php

namespace App\Http\Controllers;

use App\Models\IpdCase;
use App\Models\Patient;
use Illuminate\Http\Request;
use App\Models\DischargePlan;
use Illuminate\Support\Facades\Auth;

class DischargePlanController extends Controller
{

  public function index()
  {
    $currentUser = Auth::user();
    $canDelete = $currentUser->can('delete records');
    $dischargePlans = DischargePlan::with('patient')->orderBy('created_at', 'desc')->get();
    return view('discharge_plan.index', compact('dischargePlans', 'canDelete'));
  }
  public function create(Request $request)
  {
    $patientID = $request->query('patient_id');
    $ipdID = $request->query('ipd_id');
    $patients = Patient::orderBy('created_at', 'desc')->get();
    $ipdCases = IpdCase::all();
    $lastIpdCase = IpdCase::latest()->first();

    return view('discharge_plan.create-plan', [
      'patients' => $patients,
      'ipdCases' => $ipdCases,
      'lastIpdCase' => $lastIpdCase,
      'patientID' => $patientID,
      'ipdID' => $ipdID,
    ]);
  }
  public function view($id)
  {
    $patients = Patient::orderBy('created_at', 'desc')->get();
    $ipdCases = IpdCase::all();
    $plan = DischargePlan::where('id', $id)->firstOrFail();
    return view('discharge_plan.view-plan', compact('plan', 'patients', 'ipdCases'));
  }
  public function getIpdCasesByPatient($patientId)
  {
    $ipdCases = IpdCase::where('patient_id', $patientId)
      ->orderBy('appointment_date', 'desc')
      ->get();
    return response()->json($ipdCases);
  }
  public function store(Request $request)
  {
    // Retrieve input data from the form
    $patientId = $request->input('patient_id');
    $ipdCaseId = $request->input('ipd_case');
    $treatmentInHospital = $request->input('treatment_in_hospital');
    $treatmentInHome = $request->input('treatment_in_home');
    $operativeFindings = $request->input('operative_findings');

    // Create a new DischargePlan or update if it already exists
    $plan = DischargePlan::updateOrCreate(
      ['patient_id' => $patientId, 'ipd_case_id' => $ipdCaseId],
      [
        'treatment_in_hospital' => $treatmentInHospital,
        'treatment_in_home' => $treatmentInHome,
        'operative_findings' => $operativeFindings
      ]
    );
    // return redirect()->route('discharge-plan.index')->with('success', 'Discharge Plan added successfully.');
    return redirect()->route('discharge-plan.view', ['id' => $plan->id])
      ->with('success', 'Discharge Plan added successfully.');
  }
  public function edit($id)
  {
    $patients = Patient::orderBy('created_at', 'desc')->get();
    $ipdCases = IpdCase::all();
    $plan = DischargePlan::where('id', $id)->firstOrFail();
    return view('discharge_plan.edit-plan', compact('plan', 'patients', 'ipdCases'));
  }

  public function update(Request $request, $id)
  {
    $dischargePlan = DischargePlan::findOrFail($id);

    $dischargePlan->treatment_in_hospital = $request->input('treatment_in_hospital');
    $dischargePlan->treatment_in_home = $request->input('treatment_in_home');
    $dischargePlan->operative_findings = $request->input('operative_findings');

    $dischargePlan->save();

    $patient = Patient::find($request->patient_id);
    $ipdCase = IpdCase::find($request->ipd_case);

    return redirect()->route('discharge-plan.index')->with([
      'dischargePlan' => $dischargePlan,
      'patient' => $patient,
      'ipdCase' => $ipdCase,
      'success' => 'Discharge plan updated successfully!'
    ]);
  }


  public function getFilteredDischargeData(Request $request)
  {
    $query = DischargePlan::query();

    // // Filter by exact name match
    // if ($request->has('name') && $request->name) {
    //   $query->where('name', $request->name); // Exact match
    // }

    // // Filter by date
    // if ($request->has('filterDate') && $request->filterDate) {
    //   $query->whereDate('created_at', $request->filterDate);
    // }

    $query->orderBy('created_at', 'desc');
    $plans = $query->get();

    // Adjust the response format
    $data = $plans->map(function ($plan) {
      return [
        'id' => $plan->id,
        'patient_name' => $plan->patient->name,
        'visit_no' => $plan->ipdCase->visit_no,
        'appointment_date' => $plan->ipdCase->appointment_date,
      ];
    });

    return response()->json($data);
  }
  public function getDischargeDetails($id)
  {
    $plan = DischargePlan::with(['patient', 'ipdCase'])->where('id', $id)->first();

    if ($plan) {
      return response()->json($plan);
    } else {
      return response()->json(['error' => 'Note not found'], 404);
    }
  }

  public function destroy($id)
  {
    $plan = DischargePlan::find($id);

    if (!$plan) {
      return redirect()->route('discharge-plan.index')->with('error', 'Discharge Plan not found.');
    }

    $plan->delete();

    return redirect()->route('discharge-plan.index')->with('success', 'Discharge Plan deleted successfully.');
  }
}
