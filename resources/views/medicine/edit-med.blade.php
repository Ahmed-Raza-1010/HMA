@extends('layouts/layoutMaster')

@section('title', 'Edit Medicine')

<!-- Vendor Styles -->
@section('vendor-style')
    @vite(['resources/assets/vendor/libs/flatpickr/flatpickr.scss', 'resources/assets/vendor/libs/select2/select2.scss'])
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
    @vite(['resources/assets/vendor/libs/cleavejs/cleave.js', 'resources/assets/vendor/libs/cleavejs/cleave-phone.js', 'resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/flatpickr/flatpickr.js', 'resources/assets/vendor/libs/select2/select2.js'])
@endsection

<!-- Page Scripts -->
@section('page-script')
    @vite(['resources/assets/js/form-layouts.js'])
@endsection

@section('content')

  <!-- Multi Column with Form Separator -->
  <div class="card mb-4">
    <div class="card-header border-bottom mb-4">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h5 class="mb-0">
                    <b><i class="menu-icon tf-icons ti ti-pill"></i> Edit Medicine</b>
                </h5>
            </div>
        </div>
    </div>
    <form id="medicine-form" class="card-body" method="POST" action="{{ route('medicine.update', $medicine->id) }}">
        @csrf
        @method('PUT')
        <h6>MEDICINE INFORMATION</h6>
        <div class="row g-3">
    
            <div class="col-md-6">
                <label class="form-label" for="name">Medicine Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $medicine->name) }}" />
                <span id="medicine-name-error" style="color: red; display: none;">Field required.</span>
            </div>
    
            <div class="col-md-6">
                <label class="form-label" for="number_of_doses">Number of Doses</label>
                <input type="number" name="dose" id="number_of_doses" class="form-control" value="{{ old('dose', $medicine->dose) }}" />
                <span id="number-of-doses-error" style="color: red; display: none;">Field required.</span>
            </div>
    
            <div class="col-md-4">
                <label class="form-label" for="frequency">Frequency</label>
                <input type="text" name="frequency" id="frequency" class="form-control" placeholder="2 times/day"
                    value="{{ old('frequency', $medicine->frequency) }}" />
                <span id="frequency-error" style="color: red; display: none;">Field required.</span>
            </div>
        </div>
    
        <div class="pt-4">
            <button type="submit" class="btn btn-primary me-sm-3 me-1">Save</button>
            <button type="button" class="btn btn-label-secondary" onclick="window.location.href='/medicines';">Cancel</button>
        </div>
    </form>
</div>











    <!-- Multi Column with Form Separator -->
    {{-- <div class="card mb-4">
        <div class="card-header border-bottom mb-4">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5 class="mb-0">
                        <b><i class="menu-icon tf-icons ti ti-pill"></i> Edit Medicine</b>
                    </h5>
                </div>
            </div>
        </div>
        <form id="medicine-form" class="card-body" method="POST" action="{{ route('medicine.update', $medicine->id) }}">
            @csrf
            @method('PUT')
            <h6>MEDICINE INFORMATION</h6>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label" for="name">Medicine Name</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Paracetamol"
                        value="{{ old('name', $medicine->name) }}" />
                    <span id="name-error" style="color: red; display: none;">Field required.</span>
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="frequency">Frequency</label>
                    <input type="text" name="frequency" id="frequency" class="form-control" placeholder="2 times/day"
                        value="{{ old('frequency', $medicine->frequency) }}" />
                    <span id="frequency-error" style="color: red; display: none;">Field required.</span>
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="dose">Dose</label>
                    <input type="text" name="dose" id="number-of-doses" class="form-control" placeholder="500 mg"
                        value="{{ old('dose', $medicine->dose) }}" />
                    <span id="number-of-doses-error" style="color: red; display: none;">Field required.</span>
                </div>
            </div>

            <div class="pt-4">
                <button type="submit" class="btn btn-primary me-sm-3 me-1">Update</button>
                <button type="reset" class="btn btn-label-secondary"
                    onclick="window.location.href='/medicines';">Cancel</button>
            </div>
        </form>
    </div> --}}

    <script>
        document.addEventListener('DOMContentLoaded', function() {

function validateInput(inputElement, errorMessageElement) {
    let isValid = true;
    if (inputElement.value.trim() === '') {
        errorMessageElement.textContent = 'Field required.';
        errorMessageElement.style.display = 'block';
        inputElement.style.borderColor = 'red';
        isValid = false;
    } else {
        errorMessageElement.style.display = 'none';
        inputElement.style.borderColor = '';
    }
    return isValid;
}

function validateSelection(selectElement, errorMessageElement) {
    if (selectElement.value === '') {
        errorMessageElement.style.display = 'block';
        selectElement.style.borderColor = 'red';
        return false;
    } else {
        errorMessageElement.style.display = 'none';
        selectElement.style.borderColor = '';
        return true;
    }
}

// Set up event listeners for validation
document.getElementById('name').addEventListener('input', function() {
    validateInput(this, document.getElementById('medicine-name-error'));
});

document.getElementById('number_of_doses').addEventListener('input', function() {
    validateInput(this, document.getElementById('number-of-doses-error'));
});

document.getElementById('frequency').addEventListener('change', function() {
    validateSelection(this, document.getElementById('frequency-error'));
});



// Add form validation on submit
document.getElementById('medicine-form').addEventListener('submit', function(event) {
    const isMedicineNameValid = validateInput(document.getElementById('name'), document
        .getElementById('medicine-name-error'));
    const isNumberOfDosesValid = validateInput(document.getElementById('number_of_doses'),
        document.getElementById('number-of-doses-error'));
    const isFrequencySelected = validateSelection(document.getElementById('frequency'), document
        .getElementById('frequency-error'));
  

    if (!isMedicineNameValid || !isNumberOfDosesValid || !isFrequencySelected) {
        event.preventDefault(); // Prevent form submission if any validation fails
    }
});

});
</script>

@endsection