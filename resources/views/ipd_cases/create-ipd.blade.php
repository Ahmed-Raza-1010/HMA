@extends('layouts/layoutMaster')

@section('title', 'Create IPD Case')

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
    @vite('resources/assets/js/ipd-cases-list.js')
@endsection

@section('content')
    <!-- Multi Column with Form Separator -->
    <div class="card mb-4">
        <div class="card-header border-bottom mb-4">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5 class="mb-0">
                        <b><i class="menu-icon tf-icons ti ti-emergency-bed"> </i></i> Create IPD</b>
                    </h5>
                </div>
            </div>
        </div>
        <form id="ipd-case-form" class="card-body" action="{{ route('ipd-case.store') }}" method="POST">
            @csrf
            <h6>BASIC INFORMATION</h6>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label" for="patient_id">Patient's Name</label>
                    <select class="select2 form-select text-capitalize" id="patient_id" name="patient_id">
                        <option selected="" value="" disabled>
                            {{ __('Select Patient') }}
                        </option>
                        @foreach ($patients as $patient)
                            <option value="{{ $patient->id }}" data-visit="{{ $patient->ipdCases->count() }}"
                                data-name="{{ $patient->name }}" data-height="{{ $patient->height }}"
                                data-weight="{{ $patient->weight }}" data-pulse="{{ $patient->pulse }}"
                                data-blood_pressure="{{ $patient->blood_pressure }}"
                                data-temperature="{{ $patient->temperature }}"
                                data-respiratory="{{ $patient->respiratory }}">
                                {{ $patient->name }}
                            </option>
                        @endforeach
                    </select>
                    <span id="patient-error" style="color: red; display: none;">Please select a patient.</span>
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="visit_no">Visit.No/ipd.No</label>
                    <input type="text" id="visit_no" name="visit_no" class="form-control" placeholder="1" readonly />
                    <span id="visit-error" style="color: red; display: none;">Enter a numeric value.</span>
                </div>
                <hr />
                <div class="col-md-4">
                    <label class="form-label" for="height">Height</label>
                    <input type="text" id="height" name="height" class="form-control" placeholder="5.6 ft in"
                        readonly />
                    <span id="height-error" style="color: red; display: none;">Enter a valid floating-point number.</span>
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="weight">Weight</label>
                    <input type="text" id="weight" name="weight" class="form-control" placeholder="50 kg" readonly />
                    <span id="weight-error" style="color: red; display: none;">Enter a valid floating-point number.</span>
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="pulse">Pulse</label>
                    <input type="text" id="pulse" name="pulse" class="form-control" placeholder="60 bpm"
                        readonly />
                    <span id="pulse-error" style="color: red; display: none;">Enter a valid integer value.</span>
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="blood_pressure">Blood Pressure</label>
                    <input type="text" id="blood_pressure" name="blood_pressure" class="form-control"
                        placeholder="120/80 mm Hg" readonly />
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="temperature">Temperature</label>
                    <input type="text" id="temperature" name="temperature" class="form-control" placeholder="96 °C"
                        readonly />
                    <span id="temperature-error" style="color: red; display: none;">Enter a valid floating-point
                        number.</span>
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="respiratory">Respiratory</label>
                    <input type="text" id="respiratory" name="respiratory" class="form-control"
                        placeholder="Respirator here" readonly />
                    <span id="temperature-error" style="color: red; display: none;">Enter a valid floating-point
                        number.</span>
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="appointment">Appointment Date</label>
                    <input type="text" id="appointment" name="appointment" class="form-control dob-picker"
                        placeholder="YYYY-MM-DD" />
                    <span id="apt-error" style="color: red; display: none;">Please enter a valid date.</span>
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="doctor_id">Doctor</label>
                    <select class="select2 form-select text-capitalize" id="doctor_id" name="doctor_id">
                        <option selected="" value="">
                            {{ __('Doctor Name') }}
                        </option>
                        @foreach ($doctors as $doctor)
                            <option value="{{ $doctor->id }}">
                                {{ $doctor->id }}{{ ' - ' }}{{ $doctor->name }}
                            </option>
                        @endforeach
                    </select>
                    <span id="doctor-error" style="color: red; display: none;">Please make a selection.</span>
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="bed">Bed</label>
                    <input type="number" id="bed" name="bed" class="form-control" placeholder="05" />
                    <span id="bed-error" style="color: red; display: none;">Field required.</span>
                </div>
            </div>
            <hr />
            <h6>COMPLAINT</h6>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label" for="complaint">Presenting Complaint</label>
                    <textarea id="complaint" name="complaint" class="form-control" placeholder="Complaint here"
                        style="height: 110px; resize: none;"></textarea>
                    <span id="complaint-error" style="color: red; display: none;">Field required.</span>

                </div>
                <div class="col-md-4">
                    <label class="form-label" for="history">History</label>
                    <textarea id="history" name="history" class="form-control" placeholder="History here"
                        style="height: 110px; resize: none;"></textarea>
                    <span id="history-error" style="color: red; display: none;">Field required.</span>

                </div>
            </div>
            <hr />
            <h6>EXAMINATION</h6>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label" for="diagnose">Provisional Diagnose</label>
                    <textarea id="diagnose" name="diagnose" class="form-control" placeholder="Write provisional diagnose"
                        style="height: 110px; resize: none;"></textarea>
                    <span id="diagnose-error" style="color: red; display: none;">Field required.</span>
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="treatment">Treatment</label>
                    <textarea id="treatment" name="treatment" class="form-control" placeholder="Write about treatment"
                        style="height: 110px; resize: none;"></textarea>
                    <span id="treatment-error" style="color: red; display: none;">Field required.</span>
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="instruction">Special Instruction</label>
                    <textarea id="instruction" name="instruction" class="form-control" placeholder="Instructions here"
                        style="height: 110px; resize: none;"></textarea>
                    <span id="instruction-error" style="color: red; display: none;">Field required.</span>
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="follow_up">Follow up in days</label>
                    <input type="number" id="follow_up" name="follow_up" class="form-control" placeholder="5"
                        value="7" />
                    <span id="follow-up-error" style="color: red; display: none;">Field required.</span>
                </div>
            </div>
            <hr />
            <h6>MEDICATION</h6>
            <div id="medication-container">
                <div class="row g-3 medication-row">
                    <div class="col-md-3">
                        <label class="form-label" for="medicine">Medicine's Name</label>
                        <select class="form-select text-capitalize" id="medicine" name="medicine[]">
                            <option selected="" value="" disabled>
                                {{ __('Select Medicine') }}
                            </option>
                            @foreach ($medications as $medication)
                                <option value="{{ $medication->name }}" data-dose="{{ $medication->dose }}"
                                    data-frequency="{{ $medication->frequency }}">
                                    {{ $medication->name }}
                                </option>
                            @endforeach
                        </select>
                        <span id="medication-error" style="color: red; display: none;">Please select a medicine.</span>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label" for="duration">Duration in days</label>
                        <input type="number" id="duration" name="duration[]" class="form-control" placeholder="2"
                            min="1" />
                        <span class="medication-error" style="display: none; color: red;">Days are required.</span>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label" for="dose">Dose</label>
                        <input type="number" id="dose" name="dose[]" class="form-control" placeholder="6"
                            readonly />
                        <span class="medication-error" style="display: none; color: red;">Dose is required.</span>
                        <span id="dose-error" style="color: red; display: none;">Enter a valid integer value.</span>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label" for="frequency">Frequency</label>
                        <input type="text" id="frequency" name="frequency[]" class="form-control"
                            placeholder="Instructions here" />
                        <span class="medication-error" style="display: none; color: red;">Frequency is required.</span>
                    </div>
                    <div class="col-md-1">
                        <label class="form-label" for="add-button"></label>
                        <button type="button"
                            class="form-control btn btn-primary add-medicine-btn me-sm-3 me-1">+</button>
                    </div>
                </div>
            </div>
            <div class="pt-4">
                <button type="submit" class="btn btn-primary me-sm-3 me-1">Save</button>
                <button type="reset" onclick="window.location.href='{{ route('ipd-case.index') }}'"
                    class="btn btn-label-secondary">Cancel</button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // // Validation function for appointment date
            //   function validateAppointmentDate(inputElement, errorMessageElement) {
            //       const value = inputElement.value;
            //       if (value === '') {
            //           errorMessageElement.style.display = 'block';
            //           inputElement.style.borderColor = 'red';
            //           return false;
            //       } else {
            //           errorMessageElement.style.display = 'none';
            //           inputElement.style.borderColor = '';
            //           return true;
            //       }
            //   }

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
                } else if (inputDate < currentDate) {
                    errorMessageElement.textContent = 'Date must be today or greater.';
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

            // Validation function for medication fields
            function validateMedicationRows() {
                const medicationRows = document.querySelectorAll('.medication-row');
                let isValid = true;

                medicationRows.forEach(row => {
                    const inputs = row.querySelectorAll('input');
                    const errorMessages = row.querySelectorAll('.medication-error');

                    inputs.forEach((input, index) => {
                        if (input.value.trim() === '') {
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

            // Event listener for appointment date input
            document.getElementById('appointment').addEventListener('input', function() {
                validateAppointmentDate(this, document.getElementById('apt-error'));
            });

            // Event listener for patient selection change
            document.getElementById('patient_id').addEventListener('change', function() {
                validateSelection(this, document.getElementById('patient-error'));
            });

            // Event listener for patient selection change
            document.getElementById('doctor_id').addEventListener('change', function() {
                validateSelection(this, document.getElementById('doctor-error'));
            });

            // Event listener for patient selection change
            document.getElementById('complaint').addEventListener('change', function() {
                validateSelection(this, document.getElementById('complaint-error'));
            });
            // Event listener for patient selection change

            document.getElementById('bed').addEventListener('change', function() {
                validateSelection(this, document.getElementById('bed-error'));
            });

            // Event listener for patient selection change
            document.getElementById('history').addEventListener('change', function() {
                validateSelection(this, document.getElementById('history-error'));
            });

            // Event listener for patient selection change
            document.getElementById('diagnose').addEventListener('change', function() {
                validateSelection(this, document.getElementById('diagnose-error'));
            });

            // Event listener for patient selection change
            document.getElementById('treatment').addEventListener('change', function() {
                validateSelection(this, document.getElementById('treatment-error'));
            });

            // Event listener for patient selection change
            document.getElementById('instruction').addEventListener('change', function() {
                validateSelection(this, document.getElementById('instruction-error'));
            });

            // Event listener for patient selection change
            document.getElementById('follow_up').addEventListener('change', function() {
                validateSelection(this, document.getElementById('follow-up-error'));
            });

            // Add form validation on submit
            document.getElementById('ipd-case-form').addEventListener('submit', function(event) {
                const isAppointmentDateValid = validateAppointmentDate(document.getElementById(
                    'appointment'), document.getElementById('apt-error'));
                const isPatientSelected = validateSelection(document.getElementById('patient_id'),
                    document.getElementById('patient-error'));
                const isDoctorSelected = validateSelection(document.getElementById('doctor_id'),
                    document.getElementById('doctor-error'));
                const isBedValid = validateSelection(document.getElementById('bed'),
                    document.getElementById('bed-error'));
                const isComplaintValid = validateSelection(document.getElementById('complaint'),
                    document.getElementById('complaint-error'));
                const isHistoryValid = validateSelection(document.getElementById('history'),
                    document.getElementById('history-error'));
                const isDiagnoseValid = validateSelection(document.getElementById('diagnose'),
                    document.getElementById('diagnose-error'));
                const isTreatmentValid = validateSelection(document.getElementById('treatment'),
                    document.getElementById('treatment-error'));
                const isInstructionValid = validateSelection(document.getElementById('instruction'),
                    document.getElementById('instruction-error'));
                const isFollowUpValid = validateSelection(document.getElementById('follow_up'),
                    document.getElementById('follow-up-error'));
                const areMedicationsValid = validateMedicationRows();

                if (!isAppointmentDateValid || !isPatientSelected || !isDoctorSelected || !
                    isComplaintValid || !isBedValid || !isHistoryValid || !
                    isDiagnoseValid || !isTreatmentValid || !isInstructionValid || !isFollowUpValid || !
                    areMedicationsValid) {
                    event.preventDefault(); // Prevent form submission if any validation fails
                    return false; // Explicitly return false to ensure the form is not submitted
                }
            });

            // Patient select change event
            const patientsSelect = document.getElementById('patient_id');
            if (patientsSelect) {
                // patientsSelect.addEventListener('change', function() {
                $('#patient_id').on('select2:select', function(e) {
                    // const selectedOption = this.options[this.selectedIndex];
                    const selectedOption = e.params.data.element;
                    // Retrieve data attributes
                    const visit = selectedOption.getAttribute('data-visit');
                    const height = selectedOption.getAttribute('data-height');
                    const weight = selectedOption.getAttribute('data-weight');
                    const pulse = selectedOption.getAttribute('data-pulse');
                    const bloodPressure = selectedOption.getAttribute('data-blood_pressure');
                    const temperature = selectedOption.getAttribute('data-temperature');
                    const respiratory = selectedOption.getAttribute('data-respiratory');

                    // Fill in the fields
                    document.getElementById('visit_no').value = (parseInt(visit) + 1) || '';
                    document.getElementById('height').value = height + ' ft in' || '';
                    document.getElementById('weight').value = weight + ' kg' || '';
                    document.getElementById('pulse').value = pulse + ' bpm' || '';
                    document.getElementById('blood_pressure').value = bloodPressure + ' mm Hg' || '';
                    document.getElementById('temperature').value = temperature + ' °C' || '';
                    document.getElementById('respiratory').value = respiratory || '';
                    document.getElementById('patient_id').value = selectedOption.value;
                });
            }

            // Function to initialize event listeners for medicine selects and duration inputs
            function initializeMedicineSelects() {
                const medicationRows = document.querySelectorAll('.medication-row');

                medicationRows.forEach(row => {
                    const medicineSelect = row.querySelector('select[name="medicine[]"]');
                    const durationInput = row.querySelector('input[name="duration[]"]');

                    // Event listener for medicine select change
                    if (medicineSelect) {
                        medicineSelect.addEventListener('change', function() {
                            // Get the selected option
                            const selectedOption = this.options[this.selectedIndex];

                            // Retrieve data attributes
                            const dose = selectedOption.getAttribute('data-dose');
                            const frequency = selectedOption.getAttribute('data-frequency');

                            // Update the fields in the same row
                            row.querySelector('input[name="dose[]"]').dataset.originalDose = dose ||
                                ''; // Store original dose
                            row.querySelector('input[name="frequency[]"]').value = frequency || '';
                            row.querySelector('input[name="duration[]"]').value =
                                ''; // Clear duration to require manual input

                            // Clear the dose value if duration is not set
                            if (durationInput && !durationInput.value) {
                                row.querySelector('input[name="dose[]"]').value = '';
                            }
                        });
                    }

                    // Event listener for duration input change
                    if (durationInput) {
                        durationInput.addEventListener('input', function() {
                            const doseInput = row.querySelector('input[name="dose[]"]');
                            const durationValue = this.value;

                            // Calculate dose based on original dose and duration
                            if (doseInput.dataset.originalDose) {
                                doseInput.value = doseInput.dataset.originalDose * durationValue ||
                                    '';
                            }
                        });
                    }
                });
            }

            // Function to handle adding new medication rows
            function handleAddMedicineRow() {
                // Attach click event listener to the plus button
                const addMedicineBtn = document.querySelector('.add-medicine-btn');
                if (addMedicineBtn) {
                    addMedicineBtn.addEventListener('click', function() {
                        // Clone the first medication row
                        var medicationRow = document.querySelector('.medication-row').cloneNode(true);

                        // Clear the values of input fields in the cloned row
                        var inputs = medicationRow.querySelectorAll('input');
                        var errorMessages = medicationRow.querySelectorAll('.medication-error');
                        inputs.forEach(function(input, index) {
                            input.value = '';
                            input.removeAttribute(
                                'data-original-dose'); // Remove original dose data attribute
                            errorMessages[index].style.display =
                                'none'; // Hide error messages in the new row
                        });

                        // Replace the + button in the cloned row with a - button
                        var addButton = medicationRow.querySelector('.add-medicine-btn');
                        addButton.classList.remove('btn-primary', 'add-medicine-btn');
                        addButton.classList.add('btn-danger', 'remove-medicine-btn');
                        addButton.innerText = '-';

                        // Attach click event to remove the row when - button is clicked
                        addButton.addEventListener('click', function() {
                            medicationRow.remove();
                        });

                        // Append the cloned row to the container
                        document.getElementById('medication-container').appendChild(medicationRow);

                        // Reinitialize event listeners for new rows
                        initializeMedicineSelects();
                    });
                }
            }

            // Initialize event listeners for existing rows
            initializeMedicineSelects();

            // Initialize the functionality for adding new rows
            handleAddMedicineRow();
        });
    </script>

@endsection
