@extends('layouts/layoutMaster')

@section('title', 'Edit IPD Case')

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
                        <b><i class="menu-icon tf-icons ti ti-emergency-bed"> </i></i> Edit IPD</b>
                    </h5>
                </div>
            </div>
        </div>
        <form id="ipd-case-form" class="card-body" action="{{ route('ipd-case.update', $ipdCase->id) }}" method="POST">
            @csrf
            @method('PUT')
            <h6>BASIC INFORMATION</h6>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label" for="patient_id">Patient's Name</label>
                    <input type="text" id="patient_id" name="patient_id" class="form-control"
                        value="{{ old('patient_id', $ipdCase->patient->name) }}" readonly />
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="visit_no">Visit.No/ipd.No</label>
                    <input type="text" id="visit_no" name="visit_no" class="form-control" placeholder="1"
                        value="{{ old('visit_no', $ipdCase->visit_no) }}" readonly />
                </div>
                <hr />
                <div class="col-md-4">
                    <label class="form-label" for="height">Height</label>
                    <input type="text" id="height" name="height" class="form-control"
                        value="{{ old('height', $ipdCase->patient->height . ' ft in') }}" readonly />
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="weight">Weight</label>
                    <input type="text" id="weight" name="weight" class="form-control"
                        value="{{ old('weight', $ipdCase->patient->weight . ' kg') }}" readonly />
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="pulse">Pulse</label>
                    <input type="text" id="pulse" name="pulse" class="form-control"
                        value="{{ old('pulse', $ipdCase->patient->pulse . ' bpm') }}" readonly />
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="blood_pressure">Blood Pressure</label>
                    <input type="text" id="blood_pressure" name="blood_pressure" class="form-control"
                        value="{{ old('blood_pressure', $ipdCase->patient->blood_pressure . ' mm Hg') }}" readonly />
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="temperature">Temperature</label>
                    <input type="text" id="temperature" name="temperature" class="form-control"
                        value="{{ old('temperature', $ipdCase->patient->temperature . ' °C') }}" readonly />
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="respiratory">Respiratory</label>
                    <input type="number" id="respiratory" name="respiratory" class="form-control"
                        value="{{ old('respiratory', $ipdCase->patient->respiratory) }}" readonly />
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="appointment">Appointment Date</label>
                    <input type="text" id="appointment" name="appointment" class="form-control dob-picker"
                        placeholder="YYYY-MM-DD" value="{{ old('appointment', $ipdCase->appointment_date) }}" />
                    <span id="apt-error" style="color: red; display: none;">Please enter a valid date.</span>
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="doctor_id">Doctor</label>
                    <select class="select2 form-select text-capitalize" id="doctor_id" name="doctor_id">
                        <option value=""> {{ __('Doctor Name') }} </option>
                        @foreach ($doctors as $doctor)
                            <option value="{{ $doctor->id }}"
                                {{ old('doctor_id', $ipdCase->doctor_id) == $doctor->id ? 'selected' : '' }}>
                                {{ $doctor->id }}{{ ' - ' }}{{ $doctor->name }}
                            </option>
                        @endforeach
                    </select>
                    <span id="doctor-error" style="color: red; display: none;">Please make a selection.</span>
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="bed">Bed</label>
                    <input type="text" id="bed" name="bed" class="form-control"
                        value="{{ old('bed', $ipdCase->bed) }}" placeholder="5" />
                    <span id="bed-error" style="color: red; display: none;">Field required.</span>
                </div>
            </div>
            <hr />
            <h6>COMPLAINT</h6>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label" for="complaint">Presenting Complaint</label>
                    <textarea id="complaint" name="complaint" class="form-control" placeholder="Complaint here"
                        style="height: 110px; resize: none;">{{ old('complaint', $ipdCase->presenting_complaint) }}</textarea>
                    <span id="complaint-error" style="color: red; display: none;">Field required.</span>
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="history">History</label>
                    <textarea id="history" name="history" class="form-control" placeholder="History here"
                        style="height: 110px; resize: none;">{{ old('history', $ipdCase->history) }}</textarea>
                    <span id="history-error" style="color: red; display: none;">Field required.</span>

                </div>
            </div>
            <hr />
            <h6>EXAMINATION</h6>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label" for="diagnose">Provisional Diagnose</label>
                    <textarea id="diagnose" name="diagnose" class="form-control" placeholder="Write provisional diagnose"
                        style="height: 110px; resize: none;">{{ old('diagnose', $ipdCase->provisional_diagnose) }}</textarea>
                    <span id="diagnose-error" style="color: red; display: none;">Field required.</span>
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="treatment">Treatment</label>
                    <textarea id="treatment" name="treatment" class="form-control" placeholder="Write about treatment"
                        style="height: 100px; resize: none;">{{ old('treatment', $ipdCase->treatment) }}</textarea>
                    <span id="treatment-error" style="color: red; display: none;">Field required.</span>
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="instruction">Special Instruction</label>
                    <textarea id="instruction" name="instruction" class="form-control" placeholder="Instructions here"
                        style="height: 100px; resize: none;">{{ old('instruction', $ipdCase->special_instruction) }}</textarea>
                    <span id="instruction-error" style="color: red; display: none;">Field required.</span>
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="follow_up">Follow up in days</label>
                    <input type="number" id="follow_up" name="follow_up" class="form-control"
                        value="{{ old('follow_up', $ipdCase->follow_up_days) }}" placeholder="5" />
                    <span id="follow-up-error" style="color: red; display: none;">Field required.</span>
                </div>
            </div>
            <hr />
            <h6>MEDICATION</h6>
            <div id="medication-container">
                @foreach ($ipdCase->medicine as $index => $medication)
                    <div class="row g-3 medication-row">
                        <div class="col-md-3">
                            <label class="form-label" for="medicine-{{ $index }}">Medicine</label>
                            <select name="medicine[]" class="form-select text-capitalize"
                                id="medicine-{{ $index }}">
                                <option value="" disabled>Select Medicine</option>
                                @foreach ($medications as $medicine)
                                    <option value="{{ $medicine->name }}"
                                        {{ $medicine->name == $medication->medicine_name ? 'selected' : '' }}
                                        data-dose="{{ $medicine->dose }}" data-frequency="{{ $medicine->frequency }}"
                                        data-duration="{{ $medicine->duration }}">
                                        {{ $medicine->name }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="medication-error text-danger" style="display: none;">Medicine is required.</span>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label" for="duration-{{ $index }}">Duration in days</label>
                            <input type="number" name="duration[]" class="form-control" placeholder="2"
                                value="{{ $medication->duration }}" min="1" />
                            <span class="medication-error text-danger" style="display: none;">Days are required.</span>
                            <span class="duration-error text-danger" style="display: none;">Enter a positive
                                number.</span>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label" for="dose-{{ $index }}">Dose</label>
                            <input type="number" name="dose[]" class="form-control" placeholder="6"
                                value="{{ $medication->dose }}" readonly />
                            <span class="medication-error text-danger" style="display: none;">Dose is required.</span>
                            <span class="dose-error text-danger" style="display: none;">Enter a valid integer
                                value.</span>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label" for="frequency-{{ $index }}">Frequency</label>
                            <input type="text" name="frequency[]" class="form-control"
                                placeholder="Instructions here" value="{{ $medication->frequency }}" />
                            <span class="medication-error text-danger" style="display: none;">Frequency is
                                required.</span>
                        </div>
                        <div class="col-md-1">
                            <label class="form-label">&nbsp;</label>
                            @if ($loop->last)
                                <button type="button" class="form-control btn btn-primary add-medicine-btn">+</button>
                            @else
                                <button type="button" class="form-control btn btn-danger remove-medicine-btn">-</button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="pt-4">
                <button type="submit" class="btn btn-primary me-sm-3 me-1">Update</button>
                <button type="reset" onclick="window.location.href='{{ route('ipd-case.index') }}'"
                    class="btn btn-label-secondary">Cancel</button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            function validateAppointmentDate(inputElement, errorMessageElement) {
                const value = inputElement.value;
                const currentDate = new Date();
                const inputDate = new Date(value);

                currentDate.setHours(0, 0, 0, 0);
                inputDate.setHours(0, 0, 0, 0);

                if (value === '') {
                    errorMessageElement.textContent = 'Please enter a valid date.';
                    errorMessageElement.style.display = 'block';
                    inputElement.style.borderColor = 'red';
                    return false;
                } else {
                    errorMessageElement.style.display = 'none';
                    inputElement.style.borderColor = '';
                    return true;
                }
            }

            function validateSelection(selectElement, errorMessageElement) {
                if (selectElement.value === '') {
                    errorMessageElement.textContent = 'This field is required.';
                    errorMessageElement.style.display = 'block';
                    selectElement.style.borderColor = 'red';
                    return false;
                } else {
                    errorMessageElement.style.display = 'none';
                    selectElement.style.borderColor = '';
                    return true;
                }
            }

            function validateMedicationRows() {
                const medicationRows = document.querySelectorAll('.medication-row');
                let isValid = true;

                medicationRows.forEach(row => {
                    const inputs = row.querySelectorAll('input');
                    const errorMessages = row.querySelectorAll('.medication-error');

                    inputs.forEach((input, index) => {
                        if (input.value.trim() === '') {
                            errorMessages[index].textContent = 'This field is required.';
                            errorMessages[index].style.display = 'block';
                            input.style.borderColor = 'red';
                            isValid = false;
                        } else {
                            errorMessages[index].style.display = 'none';
                            input.style.borderColor = '';
                        }
                    });
                });

                if (medicationRows.length === 0) {
                    alert('At least one medication must be added.');
                    isValid = false;
                }

                return isValid;
            }

            function attachEventListener(selector, event, handler) {
                const element = document.querySelector(selector);
                if (element) {
                    element.addEventListener(event, handler);
                }
            }

            attachEventListener('#appointment', 'input', function() {
                validateAppointmentDate(this, document.getElementById('apt-error'));
            });

            // Remove validation for readonly fields
            // attachEventListener('#patient_id', 'change', function() {
            //     validateSelection(this, document.getElementById('patient-error'));
            // });
            attachEventListener('#doctor_id', 'change', function() {
                validateSelection(this, document.getElementById('doctor-error'));
            });

            const fieldsToValidate = ['#bed', '#complaint', '#history', '#diagnose', '#treatment',
                '#instruction'
            ];
            fieldsToValidate.forEach(field => {
                attachEventListener(field, 'change', function() {
                    validateSelection(this, document.getElementById(`${this.id}-error`));
                });
            });

            attachEventListener('#ipd-case-form', 'submit', function(event) {
                const isAppointmentDateValid = validateAppointmentDate(document.getElementById(
                    'appointment'), document.getElementById('apt-error'));
                const isDoctorSelected = validateSelection(document.getElementById('doctor_id'), document
                    .getElementById('doctor-error'));
                const isComplaintValid = validateSelection(document.getElementById('complaint'), document
                    .getElementById('complaint-error'));
                const isHistoryValid = validateSelection(document.getElementById('history'), document
                    .getElementById('history-error'));
                const isBedValid = validateSelection(document.getElementById('bed'), document
                    .getElementById('bed-error'));
                const isDiagnoseValid = validateSelection(document.getElementById('diagnose'), document
                    .getElementById('diagnose-error'));
                const isTreatmentValid = validateSelection(document.getElementById('treatment'), document
                    .getElementById('treatment-error'));
                const isInstructionValid = validateSelection(document.getElementById('instruction'),
                    document.getElementById('instruction-error'));
                const isFollowUpValid = validateSelection(document.getElementById('follow_up'),
                    document.getElementById('follow-up-error'));
                const areMedicationsValid = validateMedicationRows();


                if (!isAppointmentDateValid || !isDoctorSelected || !isComplaintValid || !isHistoryValid ||
                    !isDiagnoseValid || !isTreatmentValid || !isInstructionValid || !isFollowUpValid || !
                    isBedValid || !areMedicationsValid) {
                    event.preventDefault(); // Prevent form submission if any validation fails
                    return false; // Explicitly return false to ensure the form is not submitted
                }
            });

            // Function to initialize event listeners for medicine selects and duration inputs
            function initializeMedicationRows() {
                const medicationContainer = document.getElementById('medication-container');

                // Initialize existing rows
                medicationContainer.querySelectorAll('.medication-row').forEach(row => {
                    const select = row.querySelector('select[name="medicine[]"]');
                    const selectedOption = select.options[select.selectedIndex];
                    const dose = selectedOption.getAttribute('data-dose');
                    const frequency = selectedOption.getAttribute('data-frequency');
                    const duration = parseInt(row.querySelector('input[name="duration[]"]').value, 10) ||
                    1; // Default to 1 if empty

                    // Update fields in the row
                    const doseInput = row.querySelector('input[name="dose[]"]');
                    doseInput.dataset.originalDose = dose || '';

                    // Calculate initial dose based on duration
                    if (dose) {
                        doseInput.value = dose * duration; // Multiply original dose by duration
                    }

                    row.querySelector('input[name="frequency[]"]').value = frequency || '';
                    row.querySelector('input[name="duration[]"]').value = duration || '';
                });

                // Event delegation for medicine select changes
                medicationContainer.addEventListener('change', function(event) {
                    if (event.target.matches('select[name="medicine[]"]')) {
                        const selectedOption = event.target.options[event.target.selectedIndex];
                        const row = event.target.closest('.medication-row');
                        const dose = selectedOption.getAttribute('data-dose');
                        const frequency = selectedOption.getAttribute('data-frequency');
                        const duration = parseInt(row.querySelector('input[name="duration[]"]').value,
                            10) || 1; // Default to 1 if empty

                        // Update fields in the row
                        const doseInput = row.querySelector('input[name="dose[]"]');
                        doseInput.dataset.originalDose = dose || '';

                        // Set the dose based on the selected dose and current duration
                        if (dose) {
                            doseInput.value = dose * duration;
                        }

                        row.querySelector('input[name="frequency[]"]').value = frequency || '';
                    }
                });

                // Event delegation for duration input changes
                medicationContainer.addEventListener('input', function(event) {
                    if (event.target.matches('input[name="duration[]"]')) {
                        const row = event.target.closest('.medication-row');
                        const durationValue = parseInt(event.target.value, 10);
                        const doseInput = row.querySelector('input[name="dose[]"]');
                        const originalDose = parseFloat(doseInput.dataset.originalDose);

                        // Validate duration value
                        if (isNaN(durationValue) || durationValue <= 0) {
                            event.target.style.borderColor = 'red';
                            row.querySelector('.duration-error').style.display = 'inline';
                            return;
                        } else {
                            event.target.style.borderColor = '';
                            row.querySelector('.duration-error').style.display = 'none';
                        }

                        // Calculate dose based on original dose and duration
                        if (!isNaN(originalDose) && durationValue > 0) {
                            doseInput.value = originalDose * durationValue;
                        } else {
                            doseInput.value = ''; // Clear dose if original dose is not valid
                        }
                    }
                });

                // Event delegation for removing medication rows
                medicationContainer.addEventListener('click', function(event) {
                    if (event.target.classList.contains('remove-medicine-btn')) {
                        event.target.closest('.medication-row').remove();
                    }
                });
            }

            // Function to handle adding new medication rows
            function handleAddMedicineRow() {
                const addMedicineBtn = document.querySelector('.add-medicine-btn');
                if (addMedicineBtn) {
                    addMedicineBtn.addEventListener('click', function() {
                        const medicationRow = document.querySelector('.medication-row').cloneNode(true);

                        // Clear the values of input fields in the cloned row
                        const inputs = medicationRow.querySelectorAll('input');
                        const selects = medicationRow.querySelectorAll('select');
                        const errorMessages = medicationRow.querySelectorAll('.medication-error');
                        inputs.forEach((input, index) => {
                            input.value = '';
                            input.removeAttribute(
                            'data-original-dose'); // Remove original dose data attribute
                            errorMessages[index].style.display =
                            'none'; // Hide error messages in the new row
                        });
                        selects.forEach((select) => {
                            select.selectedIndex = 0; // Reset selection
                        });

                        // Replace the + button in the cloned row with a - button
                        const addButton = medicationRow.querySelector('.add-medicine-btn');
                        if (addButton) {
                            addButton.classList.remove('btn-primary', 'add-medicine-btn');
                            addButton.classList.add('btn-danger', 'remove-medicine-btn');
                            addButton.innerText = '-';

                            addButton.addEventListener('click', function() {
                                medicationRow.remove();
                            });
                        }

                        // Append the cloned row to the container
                        document.getElementById('medication-container').appendChild(medicationRow);

                        // Initialize event listeners for new rows
                        initializeMedicationRows();
                    });
                }
            }

            // Initialize event listeners for existing rows and adding new rows
            initializeMedicationRows();
            handleAddMedicineRow();

        });
    </script>




@endsection
