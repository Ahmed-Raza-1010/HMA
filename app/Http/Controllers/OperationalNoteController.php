<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\IpdCase;
use App\Models\OpdCase;
use App\Models\Patient;
use App\Models\Medicine;
use Illuminate\Http\Request;
use App\Models\OperationalNote;
use Illuminate\Support\Facades\Auth;

class OperationalNoteController extends Controller
{
  public function index()
  {
    $currentUser = Auth::user();
    $canDelete = $currentUser->can('delete records');
    $oprNotes = OperationalNote::with('patient')->orderBy('created_at', 'desc')->get();
    return view('operational_note.index', compact('oprNotes', 'canDelete'));
  }
  public function create(Request $request)
  {
    $patientID = $request->query('patient_id');
    $ipdID = $request->query('ipd_id');
    $patients = Patient::orderBy('created_at', 'desc')->get();
    $ipdCases = IpdCase::all();
    $doctors = User::whereIn('designation', ['Doctor', 'Surgeon'])->get();
    $assistants = User::where('designation', 'Assistant')->get();

    return view('operational_note.create-opr', [
      'patients' => $patients,
      'ipdCases' => $ipdCases,
      'doctors' => $doctors,
      'assistants' => $assistants,
      'patientID' => $patientID,
      'ipdID' => $ipdID,
    ]);
  }
  public function store(Request $request)
  {
    $oprNote = OperationalNote::create([
      'patient_id' => $request->patient_id,
      'ipd_case_id' => $request->ipd_case,
      'procedure_name' => $request->procedure,
      'surgeon_id' => $request->surgeon_id,
      'assistant_id' => $request->assistant_id,
      'indication_of_surgery' => $request->surgery,
      'operative_findings' => $request->opr_findings,
      'post_operation_orders' => $request->opr_orders,
      'special_instruction' => $request->instruction,
    ]);

    $patient = Patient::find($request->patient_id);
    $surgeon = User::find($request->surgeon_id);
    $assistant = User::find($request->assistant_id);

    // return redirect()->route('operational-note.index')->with([
    //   'oprNote' => $oprNote,
    //   'patient' => $patient,
    //   'surgeon' => $surgeon,
    //   'assistant' => $assistant,
    //   'success' => 'Operational Note created successfully!'
    // ]);
    return redirect()->route('operational-note.view', ['id' => $oprNote->id])
      ->with('success', 'Operational Note added successfully.');
  }
  public function view($id)
  {
    $patients = Patient::orderBy('created_at', 'desc')->get();
    $ipdCases = IpdCase::all();
    $doctors = User::whereIn('designation', ['Doctor', 'Surgeon'])->get();
    $assistants = User::where('designation', 'Assistant')->get();
    $note = OperationalNote::where('id', $id)->firstOrFail();
    return view('operational_note.view-opr', compact('note', 'patients', 'ipdCases', 'doctors', 'assistants'));
  }
  public function edit($id)
  {
    $patients = Patient::orderBy('created_at', 'desc')->get();
    $ipdCases = IpdCase::all();
    $doctors = User::whereIn('designation', ['Doctor', 'Surgeon'])->get();
    $assistants = User::where('designation', 'Assistant')->get();
    $note = OperationalNote::where('id', $id)->firstOrFail();
    return view('operational_note.edit-opr', compact('note', 'patients', 'ipdCases', 'doctors', 'assistants'));
  }

  public function update(Request $request, $id)
  {
    $note = OperationalNote::where('id', $id)->firstOrFail();

    $note->update([
      'procedure_name' => $request->procedure,
      'surgeon_id' => $request->surgeon_id,
      'assistant_id' => $request->assistant_id,
      'indication_of_surgery' => $request->surgery,
      'operative_findings' => $request->opr_findings,
      'post_operation_orders' => $request->opr_orders,
      'special_instruction' => $request->instruction,
    ]);

    return redirect()->route('operational-note.index')->with('success', 'Operational Note updated successfully.');
  }
  public function getFilteredNotesData(Request $request)
  {
    $query = OperationalNote::query();

    // // Filter by exact name match
    // if ($request->has('name') && $request->name) {
    //   $query->where('name', $request->name); // Exact match
    // }

    // // Filter by date
    // if ($request->has('filterDate') && $request->filterDate) {
    //   $query->whereDate('created_at', $request->filterDate);
    // }

    $query->orderBy('created_at', 'desc');
    $notes = $query->get();

    // Adjust the response format
    $data = $notes->map(function ($note) {
      return [
        'id' => $note->id,
        'patient_name' => $note->patient->name,
        'surgeon_name' => $note->doctor->name,
        'procedure_name' => $note->procedure_name,
        'appointment_date' => $note->ipdCase->appointment_date,
      ];
    });

    return response()->json($data);
  }

  public function getNoteDetails($id)
  {
    $note = OperationalNote::with(['patient', 'doctor'])->where('id', $id)->first();

    if ($note) {
      return response()->json($note);
    } else {
      return response()->json(['error' => 'Note not found'], 404);
    }
  }

  public function destroy($id)
  {
    $note = OperationalNote::find($id);

    if (!$note) {
      return redirect()->route('operational-note.index')->with('error', 'Operational Note not found.');
    }

    $note->delete();

    return redirect()->route('operational-note.index')->with('success', 'Operational Note deleted successfully.');
  }
}
