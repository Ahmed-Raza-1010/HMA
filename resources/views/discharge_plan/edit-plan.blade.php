@extends('layouts/layoutMaster')

@section('title', 'Edit Discharge Plan')

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
                    <h5 class="mb-0"> <i class="menu-icon tf-icons ti ti-checkup-list"> </i>
                        <b>Edit Discharge Plan</b></h5>
                </div>
            </div>
        </div>
        <form id="discharge-plan-form" class="card-body" action="{{ route('discharge-plan.update', $plan->id) }}"
            method="POST">
            @csrf
            @method('PUT')
            <h6>BASIC INFORMATION</h6>
            <!-- Patient Selection -->
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label" for="patient_id">Patient's Name</label>
                        <input type="text" id="patient_id" name="patient_id" class="form-control text-capitalize"
                            value="{{ $plan->patient->name }}" readonly />
                    </div>
                </div>

                <!-- IPD Case Selection -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label" for="ipd_case">IPD Case</label>
                        <input type="text" id="ipd_case" name="ipd_case" class="form-control text-capitalize"
                            value="{{ $plan->ipdCase->id }}" readonly />
                    </div>
                </div>
            </div>
            <hr />
            <!-- Patient Details -->
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label" for="name">Patient's Name</label>
                    <input type="text" name="name" id="name" class="form-control"
                        value="{{ $plan->patient->name }}" readonly />
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="gender">Gender</label>
                    <input type="text" name="gender" id="gender" class="form-control"
                        value="{{ $plan->patient->gender }}" readonly />
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="age">Age</label>
                    <input type="number" name="age" id="age" class="form-control"
                        value="{{ $plan->patient->age }}" readonly />
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="provisional_diagnose">Provisional Diagnose</label>
                    <input type="text" name="provisional_diagnose" id="provisional_diagnose" class="form-control"
                        value="{{ $plan->ipdCase->provisional_diagnose }}" readonly />
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="phone">Phone No</label>
                    <input type="text" id="phone" name="phone" class="form-control"
                        value="{{ $plan->patient->phone }}" readonly />
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="address">Address</label>
                    <textarea id="address" name="address" class="form-control" style="height: 110px; resize: none;" readonly>{{ $plan->patient->address }}</textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="operative_findings">Diagnose Findings</label>
                    <textarea id="operative_findings" name="operative_findings" class="form-control" style="height: 110px; resize: none;">{{ $plan->operative_findings }}</textarea>
                    <span id="findings-error" style="color: red; display: none;">Field required.</span>
                </div>
            </div>
            <hr />

            <!-- Treatment Details -->
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label" for="treatment_in_hospital">Treatment in Hospital</label>
                    <textarea id="treatment_in_hospital" name="treatment_in_hospital" class="form-control"
                        style="height: 110px; resize: none;">{{ $plan->treatment_in_hospital }}</textarea>
                    <span id="hospital-error" style="color: red; display: none;">Field required.</span>
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="treatment_in_home">Treatment in Home</label>
                    <textarea id="treatment_in_home" name="treatment_in_home" class="form-control" style="height: 110px; resize: none;">{{ $plan->treatment_in_home }}</textarea>
                    <span id="home-error" style="color: red; display: none;">Field required.</span>
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="special_instruction">Special Instruction</label>
                    <textarea id="special_instruction" name="special_instruction" class="form-control"
                        style="height: 110px; resize: none;" readonly>{{ $plan->ipdCase->special_instruction }}</textarea>
                </div>
            </div>

            <div class="pt-4">
                <button type="submit" class="btn btn-primary me-sm-3 me-1">Update</button>
                <button type="reset" onclick="window.location.href='{{ route('discharge-plan.index') }}'"
                    class="btn btn-label-secondary">Cancel</button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

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

            document.getElementById('operative_findings').addEventListener('input', function() {
                validateSelection(this, document.getElementById('findings-error'));
            });

            document.getElementById('treatment_in_hospital').addEventListener('input', function() {
                validateSelection(this, document.getElementById('hospital-error'));
            });

            document.getElementById('treatment_in_home').addEventListener('input', function() {
                validateSelection(this, document.getElementById('home-error'));
            });

            // Add form validation on submit
            document.getElementById('discharge-plan-form').addEventListener('submit', function(event) {
                const isFindingValid = validateSelection(document.getElementById('operative_findings'),
                    document
                    .getElementById('findings-error'));
                const isHospitalValid = validateSelection(document.getElementById('treatment_in_hospital'),
                    document
                    .getElementById('hospital-error'));
                const isHomeValid = validateSelection(document.getElementById('treatment_in_home'),
                    document
                    .getElementById('home-error'));

                if (!isFindingValid || !isHospitalValid || !isHomeValid) {
                    event.preventDefault(); // Prevent form submission if any validation fails
                }
            });

            const patientsSelect = document.getElementById('patient_id');
            const ipdCasesSelect = document.getElementById('ipd_case');
            const provisional_diagnoseInput = document.getElementById('provisional_diagnose');
            const specialInstructionInput = document.getElementById('special_instruction');

            // Function to update patient details
            function updatePatientDetails() {
                const selectedOption = patientsSelect.options[patientsSelect.selectedIndex];
                const patientName = selectedOption.getAttribute('data-name');
                const gender = selectedOption.getAttribute('data-gender');
                const age = selectedOption.getAttribute('data-age');
                const phone = selectedOption.getAttribute('data-phone');
                const address = selectedOption.getAttribute('data-address');

                // Fill in the fields
                document.getElementById('name').value = patientName || '';
                document.getElementById('gender').value = gender || '';
                document.getElementById('age').value = age || '';
                document.getElementById('phone').value = phone || '';
                document.getElementById('address').value = address || '';

                // Clear and fetch IPD cases
                fetchIpdCases(selectedOption.value);
            }

            // Function to fetch IPD cases based on selected patient
            function fetchIpdCases(patientId) {
                ipdCasesSelect.innerHTML = '<option selected="" value="">Select IPD Case</option>';
                provisional_diagnoseInput.value = ''; // Clear provisional_diagnose field
                specialInstructionInput.value = ''; // Clear special instruction field

                if (patientId) {
                    fetch(`/ipd-cases/${patientId}`)
                        .then(response => response.json())
                        .then(data => {
                            data.forEach(ipdCase => {
                                const option = document.createElement('option');
                                option.value = ipdCase.id;
                                option.textContent = `Appointment Date: ${ipdCase.appointment_date}`;
                                option.setAttribute('data-special_instruction', ipdCase
                                    .special_instruction);
                                option.setAttribute('data-provisional_diagnose', ipdCase
                                    .provisional_diagnose
                                ); // Assuming 'provisional_diagnose' field exists in the IPD case
                                ipdCasesSelect.appendChild(option);
                            });
                        })
                        .catch(error => console.error('Error fetching IPD cases:', error));
                }
            }

            // Event listener for patient selection change
            if (patientsSelect) {
                patientsSelect.addEventListener('change', updatePatientDetails);
            }

            // Event listener for IPD case selection change
            if (ipdCasesSelect) {
                ipdCasesSelect.addEventListener('change', function() {
                    const selectedOption = this.options[this.selectedIndex];
                    const specialInstruction = selectedOption.getAttribute('data-special_instruction');
                    const provisional_diagnose = selectedOption.getAttribute('data-provisional_diagnose');

                    // Update the fields based on selected IPD case
                    specialInstructionInput.value = specialInstruction || '';
                    provisional_diagnoseInput.value = provisional_diagnose || '';
                });
            }
        });
    </script>

@endsection
