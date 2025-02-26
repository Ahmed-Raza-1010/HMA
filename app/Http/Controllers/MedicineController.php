<?php

namespace App\Http\Controllers;

use App\Models\Medication;
use App\Models\Medicine;
use Faker\Provider\Medical;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    public function index(){
        // $currentUser = Auth::user();
        // $canDelete = $currentUser->can('delete records');
        $medications = Medication::orderBy('name', 'asc')->get();
        return view('medicine.index', compact('medications'));
    }
    public function create(){
        // $currentUser = Auth::user();
        // $canDelete = $currentUser->can('delete records');
        return view('medicine.create-med');
    }
    public function store(Request $request)
{
    // Create a new instance of the Medicine model
    Medication::create([
        'name' => $request->input('name'),
        'dose' => $request->input('dose'),
        'frequency' => $request->input('frequency'),
    ]);

    return redirect()->route('medicine.index')->with('success', 'Medicine added successfully.');
}
public function getFilteredMedicineData(Request $request)
{
    $query = Medication::query();

    // Filter by medicine name
    if ($request->has('name') && $request->name) {
        $query->where('name', $request->name);
    }   

    $query->orderBy('name', 'asc');
    $medications = $query->get();

    // Adjust the response format
    $data = $medications->map(function ($medication) {
        return [
            'id' => $medication->id,
            'name' => $medication->name,
            'dose' => $medication->dose,
            'frequency' => $medication->frequency,
        ];
    });

    return response()->json($data);
}

public function edit($id)
{
  $medicine = Medication::where('id', $id)->firstOrFail();

  return view('medicine.edit-med', compact('medicine'));
}

public function update(Request $request, $id)
  {
    $medicine = Medication::findOrFail($id);

    $medicine->update([
      'name' => $request->input('name'),
      'dose' => $request->input('dose'),
      'frequency' => $request->input('frequency'),
    ]);

    return redirect()->route('medicine.index')->with('success', 'Medicine Updated successfully.');
  }
public function destroy($id)
{
  $medicine = Medication::find($id);

  if (!$medicine) {
    return redirect()->route('medicine.index')->with('error', 'Medicine not found.');
  }

  $medicine->delete();

  return redirect()->route('medicine.index')->with('success', 'Medicine deleted successfully.');
}
}
