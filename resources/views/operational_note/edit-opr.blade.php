@extends('layouts/layoutMaster')

@section('title', 'Edit Operational Note')

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
                    <h5 class="mb-0"> <i class="menu-icon tf-icons ti ti-notes"> </i>
                        <b>Edit Operational Note</b>
                    </h5>
                </div>
            </div>
        </div>
        <form id="opr-note-form" class="card-body" action="{{ route('operational-note.update', $note->id) }}" method="POST">
            @csrf
            @method('PUT')
            <h6>BASIC INFORMATION</h6>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label" for="name">Patient's Name</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Muhammad Ali"
                        value="{{ $note->patient->name }}" readonly />
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="procedure">Procedure's Name</label>
                    <input type="text" id="procedure" name="procedure" class="form-control" placeholder="Surgery"
                        value="{{ $note->procedure_name }}" />
                    <span id="procedure-error" style="color: red; display: none;">Field required.</span>
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="surgeon_id">Select Surgeon</label>
                    <select class="select2 form-select text-capitalize" id="surgeon_id" name="surgeon_id">
                        <option value="" disabled>Surgeon Name</option>
                        @foreach ($doctors as $doctor)
                            <option value="{{ $doctor->id }}" {{ $note->surgeon_id == $doctor->id ? 'selected' : '' }}>
                                {{ $doctor->id }}{{ ' - ' }}{{ $doctor->name }}
                            </option>
                        @endforeach
                    </select>
                    <span id="surgeon-error" style="color: red; display: none;">Please select a surgeon.</span>
                </div>

                <div class="col-md-4">
                    <label class="form-label" for="assistant_id">Select Assistant</label>
                    <select class="select2 form-select text-capitalize" id="assistant_id" name="assistant_id">
                        <option value="" disabled>Assistant Name</option>
                        @foreach ($assistants as $assistant)
                            <option value="{{ $assistant->id }}"
                                {{ $note->assistant_id == $assistant->id ? 'selected' : '' }}>
                                {{ $assistant->id }}{{ ' - ' }}{{ $assistant->name }}
                            </option>
                        @endforeach
                    </select>
                    <span id="assistant-error" style="color: red; display: none;">Please select an assistant.</span>
                </div>

                <div class="col-md-8">
                    <label class="form-label" for="surgery">Indication for Surgery</label>
                    <input type="text" id="surgery" name="surgery" class="form-control" placeholder="Leg surgery"
                        value="{{ $note->indication_of_surgery }}" />
                    <span id="surgery-error" style="color: red; display: none;">Field required.</span>
                </div>

                <div class="col-md-4">
                    <label class="form-label" for="opr_findings">Operative Findings</label>
                    <textarea id="opr_findings" name="opr_findings" class="form-control" placeholder="There is a crack in the bone"
                        style="height: 110px; resize: none;">{{ $note->operative_findings }}</textarea>
                    <span id="opr-findings-error" style="color: red; display: none;">Field required.</span>
                </div>

                <div class="col-md-4">
                    <label class="form-label" for="opr_orders">Post Operation Orders</label>
                    <textarea id="opr_orders" name="opr_orders" class="form-control" placeholder="What's the condition after Operation"
                        style="height: 110px; resize: none;">{{ $note->post_operation_orders }}</textarea>
                    <span id="opr-orders-error" style="color: red; display: none;">Field required.</span>
                </div>

                <div class="col-md-4">
                    <label class="form-label" for="instruction">Special Instruction</label>
                    <textarea id="instruction" name="instruction" class="form-control" placeholder="Instructions here"
                        style="height: 110px; resize: none;">{{ $note->special_instruction }}</textarea>
                    <span id="instruction-error" style="color: red; display: none;">Field required.</span>
                </div>
            </div>

            <div class="pt-4">
                <button type="submit" class="btn btn-primary me-sm-3 me-1">Update</button>
                <button type="reset" onclick="window.location.href='{{ route('operational-note.index') }}'"
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

            // Event listener for patient selection change
            document.getElementById('surgeon_id').addEventListener('change', function() {
                validateSelection(this, document.getElementById('surgeon-error'));
            });

            // Event listener for patient selection change
            document.getElementById('assistant_id').addEventListener('change', function() {
                validateSelection(this, document.getElementById('assistant-error'));
            });

            // Event listener for patient selection change
            document.getElementById('procedure').addEventListener('change', function() {
                validateSelection(this, document.getElementById('procedure-error'));
            });

            // Event listener for patient selection change
            document.getElementById('surgery').addEventListener('change', function() {
                validateSelection(this, document.getElementById('surgery-error'));
            });

            // Event listener for patient selection change
            document.getElementById('opr_findings').addEventListener('change', function() {
                validateSelection(this, document.getElementById('opr-findings-error'));
            });

            // Event listener for patient selection change
            document.getElementById('opr_orders').addEventListener('change', function() {
                validateSelection(this, document.getElementById('opr-orders-error'));
            });

            // Event listener for patient selection change
            document.getElementById('instruction').addEventListener('change', function() {
                validateSelection(this, document.getElementById('instruction-error'));
            });

            // Add form validation on submit
            document.getElementById('opr-note-form').addEventListener('submit', function(event) {
                const isSurgeonSelected = validateSelection(document.getElementById('surgeon_id'),
                    document.getElementById('surgeon-error'));
                const isAssistantSelected = validateSelection(document.getElementById('assistant_id'),
                    document.getElementById('assistant-error'));
                const isProcdureValid = validateSelection(document.getElementById('procedure'),
                    document.getElementById('procedure-error'));
                const isSurgeryValid = validateSelection(document.getElementById('surgery'),
                    document.getElementById('surgery-error'));
                const isOprFindingValid = validateSelection(document.getElementById('opr_findings'),
                    document.getElementById('opr-findings-error'));
                const isOprOrderValid = validateSelection(document.getElementById('opr_orders'),
                    document.getElementById('opr-orders-error'));
                const isInstructionValid = validateSelection(document.getElementById('instruction'),
                    document.getElementById('instruction-error'));

                if (!isSurgeonSelected || !isSurgeonSelected || !isProcdureValid || !isSurgeryValid || !
                    isOprFindingValid || !isOprOrderValid || !isInstructionValid) {
                    event.preventDefault(); // Prevent form submission if any validation fails
                    return false; // Explicitly return false to ensure the form is not submitted
                }
            });
        });
    </script>

@endsection
