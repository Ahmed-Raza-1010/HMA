@extends('layouts/layoutMaster')

@section('title', 'Create Patient')

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
                        <b> <i class="menu-icon tf-icons ti ti-heart-rate-monitor"> </i>Create Patient </b>
                    </h5>
                </div>
            </div>
        </div>
        <form id="patient-form" class="card-body" action="{{ route('patient.store') }}" method="POST">
            @csrf
            <h6>BASIC INFORMATION</h6>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label" for="mrn">MRN#</label>
                    <input type="text" id="mrn" name="mrn" class="form-control" placeholder="0270-24-003083"
                        value="{{ old('mrn', $lastMRN) }}" readonly />
                    <span id="mrn-error" style="color: red; display: none;">Enter a valid MRN number.</span>
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="name">Patient's Name</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="John Doe" />
                    <span id="name-error" style="color: red; display: none;">Field required.</span>
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="gender">Gender</label>
                    <select id="gender" name="gender" class="select form-select" data-allow-clear="true">
                        <option value="" selected="" disabled>Select</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                    <span id="gender-error" style="color: red; display: none;">Please make a selection.</span>
                </div>
                {{-- <div class="col-md-4">
                    <label class="form-label" for="date_of_birth">Date of Birth</label>
                    <input type="text" id="date_of_birth" name="date_of_birth" class="form-control dob-picker"
                        placeholder="YYYY-MM-DD" />
                    <span id="dob-error" style="color: red; display: none;">Please enter a valid date.</span>
                </div> --}}
                <div class="col-md-4">
                    <label class="form-label" for="city">City</label>
                    <input type="text" id="city" name="city" class="form-control" placeholder="Islamabad" />
                    <span id="city-error" style="color: red; display: none;">Field required.</span>
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="phone">Phone No</label>
                    <input type="text" id="phone" name="phone" class="form-control" placeholder="0312-1234567"
                        aria-label="0312-1234567" />
                    <span id="phone-error" style="color: red; display: none;">Enter a valid phone number.</span>
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="phone">Age</label>
                    <input type="number" id="age" name="age" class="form-control" placeholder="20" />
                    <span id="age-error" style="color: red; display: none;">Field required.</span>
                </div>
                <div class="col-md-12">
                    <label class="form-label" for="address">Address</label>
                    <textarea id="address" name="address" class="form-control" placeholder="e.g., 123 Main St, Apt 4B, New York, NY 10001"
                        style="height: 110px; resize: none;"></textarea>
                    <span id="address-error" style="color: red; display: none;">Field required.</span>
                </div>
            </div>
            <hr class="my-4 mx-n4" />
            <h6>MEDICAL INFORMATION</h6>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label" for="height">Height</label>
                    <div class="input-group">
                        <input type="text" id="height" name="height" class="form-control" placeholder="5.6" />
                        <span class="input-group-text">ft in</span>
                    </div>
                    <span id="height-error" style="color: red; display: none;">Enter a valid floating-point number.</span>
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="weight">Weight</label>
                    <div class="input-group">
                        <input type="text" id="weight" name="weight" class="form-control" placeholder="50.5" />
                        <span class="input-group-text">kg</span>
                    </div>
                    <span id="weight-error" style="color: red; display: none;">Enter a valid floating-point number.</span>
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="pulse">Pulse</label>
                    <div class="input-group">
                        <input type="number" id="pulse" name="pulse" class="form-control" placeholder="60" />
                        <span class="input-group-text">bpm</span>
                    </div>
                    <span id="pulse-error" style="color: red; display: none;">Enter a valid integer value.</span>
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="blood_pressure">Blood Pressure</label>
                    <div class="input-group">
                        <input type="text" id="blood_pressure" name="blood_pressure" class="form-control"
                            placeholder="120/80" />
                        <span class="input-group-text">mm Hg</span>
                    </div>
                    <span id="pressure-error" style="color: red; display: none;">Field required.</span>
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="temperature">Temperature</label>
                    <div class="input-group">
                        <input type="text" id="temperature" name="temperature" class="form-control"
                            placeholder="96" />
                        <span class="input-group-text">°C</span>
                    </div>
                    <span id="temperature-error" style="color: red; display: none;">Enter a valid floating-point
                        number.</span>
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="respiratory">Respiratory</label>
                    <input type="number" id="respiratory" name="respiratory" class="form-control"
                        placeholder="Respirator here" />
                    <span id="respiratory-error" style="color: red; display: none;">Field required.</span>
                </div>
            </div>
            <div class="pt-4">
                <button type="submit" class="btn btn-primary me-sm-3 me-1">Save</button>
                <button type="reset" onclick="window.location.href='{{ route('patient.index') }}'"
                    class="btn btn-label-secondary">Cancel</button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            function formatPhoneNumber(inputElement) {
                let value = inputElement.value.replace(/\D/g, ''); // Remove all non-digit characters

                if (value.length > 4) {
                    value = value.slice(0, 4) + '-' + value.slice(4);
                }

                inputElement.value = value;
            }

            function validatePhoneNumber(inputElement, errorMessageElement) {
                const value = inputElement.value;
                const regex = /^\d{4}-\d{7}$/; // Matches formats like 0312-1234567

                if (value === '') {
                    errorMessageElement.style.display = 'none';
                    inputElement.style.borderColor = '';
                    return true;
                } else if (!regex.test(value)) {
                    errorMessageElement.style.display = 'block';
                    inputElement.style.borderColor = 'red';
                    return false;
                } else {
                    errorMessageElement.style.display = 'none';
                    inputElement.style.borderColor = '';
                    return true;
                }
            }

            function formatMrnNumber(inputElement) {
                let value = inputElement.value.replace(/\D/g, ''); // Remove all non-digit characters

                if (value.length > 4) {
                    value = value.slice(0, 4) + '-' + value.slice(4);
                }
                if (value.length > 7) {
                    value = value.slice(0, 7) + '-' + value.slice(7);
                }

                inputElement.value = value;
            }

            function validateMrnNumber(inputElement, errorMessageElement) {
                const value = inputElement.value;
                const regex = /^\d{4}-\d{2}-\d{6}$/; // Matches formats like 0270-24-003083

                if (value === '') {
                    errorMessageElement.style.display = 'none';
                    inputElement.style.borderColor = '';
                    return true;
                } else if (!regex.test(value)) {
                    errorMessageElement.style.display = 'block';
                    inputElement.style.borderColor = 'red';
                    return false;
                } else {
                    errorMessageElement.style.display = 'none';
                    inputElement.style.borderColor = '';
                    return true;
                }
            }


            // Validation function for selection
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

            // Validation function for float values (height, weight, temperature)
            function validateFloat(inputElement, errorMessageElement) {
                const value = inputElement.value;
                const regex = /^[+-]?([0-9]*[.])?[0-9]+$/; // Allows float values

                if (value === '') {
                    errorMessageElement.style.display = 'none';
                    inputElement.style.borderColor = '';
                    return true;
                } else if (!regex.test(value)) {
                    errorMessageElement.style.display = 'block';
                    inputElement.style.borderColor = 'red';
                    return false;
                } else {
                    errorMessageElement.style.display = 'none';
                    inputElement.style.borderColor = '';
                    return true;
                }
            }

            // Real-time validation
            document.getElementById('mrn').addEventListener('blur', function() {
                formatMrnNumber(this);
                validateMrnNumber(this, document.getElementById('mrn-error'));
            });

            document.getElementById('name').addEventListener('input', function() {
                validateSelection(this, document.getElementById('name-error'));
            });

            document.getElementById('gender').addEventListener('change', function() {
                validateSelection(this, document.getElementById('gender-error'));
            });

            // document.getElementById('date_of_birth').addEventListener('input', function() {
            //     validateSelection(this, document.getElementById('dob-error'));
            // });

            document.getElementById('city').addEventListener('input', function() {
                validateSelection(this, document.getElementById('city-error'));
            });

            document.getElementById('phone').addEventListener('blur', function() {
                formatPhoneNumber(this);
                validatePhoneNumber(this, document.getElementById('phone-error'));
            });

            document.getElementById('age').addEventListener('input', function() {
                validateSelection(this, document.getElementById('age-error'));
            });

            document.getElementById('address').addEventListener('input', function() {
                validateSelection(this, document.getElementById('address-error'));
            });

            document.getElementById('height').addEventListener('input', function() {
                validateFloat(this, document.getElementById('height-error'));
                validateSelection(this, document.getElementById('height-error'));
            });

            document.getElementById('weight').addEventListener('input', function() {
                validateFloat(this, document.getElementById('weight-error'));
                validateSelection(this, document.getElementById('weight-error'));
            });

            document.getElementById('pulse').addEventListener('input', function() {
                validateSelection(this, document.getElementById('pulse-error'));
            });

            document.getElementById('blood_pressure').addEventListener('input', function() {
                validateSelection(this, document.getElementById('pressure-error'));
            });

            document.getElementById('temperature').addEventListener('input', function() {
                validateFloat(this, document.getElementById('temperature-error'));
                validateSelection(this, document.getElementById('temperature-error'));
            });

            document.getElementById('respiratory').addEventListener('input', function() {
                validateSelection(this, document.getElementById('respiratory-error'));
            });

            // Add form validation on submit
            document.getElementById('patient-form').addEventListener('submit', function(event) {
                const isMrnValid = validateMrnNumber(document.getElementById('mrn'), document
                    .getElementById('mrn-error')) && validateSelection(document.getElementById(
                    'mrn'), document.getElementById('mrn-error'));
                const isNameValid = validateSelection(document.getElementById('name'), document
                    .getElementById('name-error'));
                const isGenderSelected = validateSelection(document.getElementById('gender'), document
                    .getElementById('gender-error'));
                // const isDOBValid = validateSelection(document.getElementById('date_of_birth'), document
                //     .getElementById('dob-error'));
                const isCityValid = validateSelection(document.getElementById('city'), document
                    .getElementById('city-error'));
                const isPhoneValid = validatePhoneNumber(document.getElementById('phone'), document
                    .getElementById('phone-error')) && validateSelection(document.getElementById(
                    'phone'), document.getElementById('phone-error'));
                const isAgeValid = validateSelection(document.getElementById('age'), document
                    .getElementById('age-error'));
                const isAddressValid = validateSelection(document.getElementById('address'), document
                    .getElementById('address-error'));
                const isHeightValid = validateFloat(document.getElementById('height'), document
                    .getElementById('height-error')) && validateSelection(document.getElementById(
                        'height'), document
                    .getElementById('height-error'));
                const isWeightValid = validateFloat(document.getElementById('weight'), document
                    .getElementById('weight-error')) && validateSelection(document.getElementById(
                        'weight'), document
                    .getElementById('weight-error'));
                const isPulseValid = validateSelection(document.getElementById('pulse'), document
                    .getElementById('pulse-error'));
                const isBloodPressureValid = validateSelection(document.getElementById('blood_pressure'),
                    document
                    .getElementById('pressure-error'));
                const isTemperatureValid = validateFloat(document.getElementById('temperature'), document
                    .getElementById('temperature-error')) && validateSelection(document.getElementById(
                        'temperature'), document
                    .getElementById('temperature-error'));
                const isRespiratoryValid = validateSelection(document.getElementById('respiratory'),
                    document.getElementById('respiratory-error'));

                if (!isMrnValid || !isNameValid || !isGenderSelected || !isCityValid || !isPhoneValid || !
                    isAgeValid || !isAddressValid || !isHeightValid || !isWeightValid || !isPulseValid || !
                    isBloodPressureValid || !isTemperatureValid || !isRespiratoryValid) {
                    event.preventDefault(); // Prevent form submission if any validation fails
                }
            });
        });
    </script>

@endsection
