@extends('layouts/layoutMaster')

@section('title', 'View OPD')

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss', 'resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss'])
@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/select2/select2.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.js', 'resources/assets/vendor/libs/cleavejs/cleave.js', 'resources/assets/vendor/libs/cleavejs/cleave-phone.js'])
@endsection

@section('page-script')
    @vite('resources/assets/js/app-user-list.js')
    @vite('resources/assets/js/opd-cases-list.js')
@endsection
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        width: 100%;
        box-sizing: border-box;
    }

    img {
        width: 100%;
        display: block;
    }

    .container {
        width: 100%;
        margin: 0 auto;
    }

    .row {
        display: flex;
        flex-wrap: wrap;
        margin: 0 -5px;
    }

    .h4 {
        margin: 10px 0;
        font-size: 18px;
        line-height: 1.2;
    }

    .col-md-6,
    .col-md-4,
    .col-md-12,
    .col-md-3,
    .col-md-2 {
        padding: 0 10px;
        box-sizing: border-box;
    }

    .col-md-6 {
        flex: 0 0 50%;
        max-width: 50%;
    }

    .col-md-4 {
        flex: 0 0 33.333%;
        max-width: 33.333%;
    }

    .col-md-3 {
        flex: 0 0 25%;
        max-width: 25%;
    }

    .col-md-2 {
        flex: 0 0 16.666%;
        max-width: 16.666%;
    }

    p {
        margin: 0;
        padding-right: 15px;
        font-size: 14px;
        line-height: 1.5;
    }

    hr {
        margin: 10px 0;
        border: 1px solid #ccc;
    }

    .mb-3 {
        margin-bottom: 10px;
    }

    .img-fluid {
        max-width: 100%;
        height: auto;
    }

    .btn {
        display: inline-block;
        padding: 10px 20px;
        margin: 10px;
        font-size: 16px;
        text-align: center;
        cursor: pointer;
        border: none;
        border-radius: 4px;
        color: #fff;
        background-color: #007bff;
        text-decoration: none;
    }

    .btn:hover {
        background-color: #0056b3;
    }
</style>

@section('content')
    <!-- Discharge Plan List Table -->
    <div class="card">
        <!-- Display success message -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <!-- Display error message -->
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="card-header border-bottom">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5 class="mb-0"><i class="menu-icon tf-icons ti ti-first-aid-kit"> </i>
                        <b>OPD Management</b>
                    </h5>
                </div>
                <div class="col-md-6 d-flex justify-content-end">
                    <button type="button" id="print-btn" class="btn btn-primary m-2">Print</button>
                    <button type="button" id="download-pdf-btn" class="btn btn-primary m-2">Download</button>
                </div>
            </div>
        </div>
        <!-- Header Image -->
        <div class="text-center">
            <img src="{{ asset('assets/img/tmh-icons/Header.png') }}" alt="Header Image" class=" my-3"
                style="max-width: 100%; height: auto;">
        </div>
        <div class="container my-2 mb-4">
            <!-- Patient Information -->
            <div class="ps-2">
                <h2 class="h4"><b>Patient Information</b></h2>
                <div class="row">
                    <div class="col-md-4 mb-0">
                        <p><strong>Name:</strong> {{ $opdCase->patient->name }}</p>
                    </div>
                    <div class="col-md-4 mb-0">
                        <p><strong>Visit No#:</strong> {{ $opdCase->visit_no }}</p>
                    </div>
                    <div class="col-md-4 mb-0">
                        <p><strong>Height:</strong> {{ $opdCase->patient->height . ' ft in' }}</p>
                    </div>
                    <div class="col-md-4 mb-0">
                        <p><strong>Weight:</strong> {{ $opdCase->patient->weight . ' kg' }}</p>
                    </div>
                    <div class="col-md-4 mb-0">
                        <p><strong>Pulse:</strong> {{ $opdCase->patient->pulse . ' bpm' }}</p>
                    </div>
                    <div class="col-md-4 mb-0">
                        <p><strong>Blood Pressure:</strong> {{ $opdCase->patient->blood_pressure . ' mm Hg' }}</p>
                    </div>
                    <div class="col-md-4 mb-0">
                        <p><strong>Temperature:</strong> {{ $opdCase->patient->temperature . ' °C' }}</p>
                    </div>
                    <div class="col-md-4 mb-0">
                        <p><strong>Respiratory:</strong> {{ $opdCase->patient->respiratory }}</p>
                    </div>
                    <div class="col-md-4 mb-0 pr-5">
                        <p><strong>Doctor:</strong> {{ $opdCase->doctor->name }}</p>
                    </div>
                    <hr>
                </div>
            </div>
            <!-- Discharge Plan Details -->
            <h2 class="h4"><b>Complaint</b></h2>
            <div class="col-md-12 m-0">
                <p><strong>Patient's complain:</strong> {{ $opdCase->presenting_complaint }}</p>
            </div>
            <div class="col-md-12 m-0">
                <p><strong>Patient's history:</strong> {{ $opdCase->history }}</p>
            </div>
            <h2 class="h4"><b>Examination</b></h2>
            <div class="col-md-12">
                <p><strong>Patient's diagnose:</strong> {{ $opdCase->provisional_diagnose }}</p>
            </div>
            <div class="col-md-12">
                <p><strong>Patient's treatment:</strong> {{ $opdCase->treatment }}</p>
            </div>
            <div class="col-md-12">
                <p><strong>Patient's instructions:</strong> {{ $opdCase->special_instruction }}</p>
            </div>
            <div class="col-md-3">
                <p><strong>Patient's follow-up-days:</strong> {{ $opdCase->follow_up_days }}</p>
            </div>
            <h2 class="h4 mb-2"><b>Medication</b></h2>
            <br>
            <div class="row g-4 ms-2">
                @foreach ($opdCase->medicine as $index => $medication)
                    <div class="row align-items-center" style="margin-bottom: 2px;">
                        <div class="col-md-4">
                            <p><strong> Medicine name:</strong> {{ $medication->medicine_name }}</p>
                        </div>
                        <div class="col-md-2">
                            <p><strong>Dose:</strong> {{ $medication->dose }}</p>
                        </div>
                        <div class="col-md-3">
                            <p><strong>Frequency:</strong> {{ $medication->frequency }}</p>
                        </div>
                        <div class="col-md-3">
                            <p><strong>Duration (days):</strong> {{ $medication->duration }}</p>

                        </div>
                    </div>
                @endforeach
            </div>

        </div>
        <!-- Footer Image -->
        <div class="text-center mt-4">
            <img src="{{ asset('assets/img/tmh-icons/Footer.png') }}" alt="Footer Image" class="img-fluid my-3"
                style="max-width: 100%; height: auto;">
        </div>
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script>
   document.addEventListener('DOMContentLoaded', function () {
    // Function to handle Print button click
    document.getElementById('print-btn')?.addEventListener('click', function () {
        var modalContent = document.querySelector('.container').innerHTML;
        var headerImage = '{{ asset('assets/img/tmh-icons/Header.png') }}';
        var footerImage = '{{ asset('assets/img/tmh-icons/Footer.png') }}';

        var printWindow = window.open('', '', 'height=600,width=800');
        var content = `
        <html>
        <head>
            <title>OPD Case Details</title>
            <style>
                body, html {
                    margin: 0;
                    padding: 0;
                    width: 100%;
                    height: 100%;
                    font-family: Arial, sans-serif;
                    box-sizing: border-box;
                }

                img {
                    width: 100%;
                    display: block;
                }

                .container {
                    width: 100%;
                    margin: 0 auto;
                    flex: 1; /* Allow the container to take available space */
                }

                .wrapper {
                    display: flex;
                    flex-direction: column;
                    min-height: 100vh; /* Ensure wrapper takes up full height of the viewport */
                }

                .footer {
                    margin-top: auto;
                    width: 100%;
                }

                .row {
                    display: flex;
                    flex-wrap: wrap;
                    margin: 0 -5px;
                }

                .h4 {
                    margin: 10px 0;
                    font-size: 18px;
                    line-height: 1.2;
                }

                .col-md-6,
                .col-md-4,
                .col-md-12,
                .col-md-3,
                .col-md-2 {
                    padding: 0 10px;
                    box-sizing: border-box;
                }

                .col-md-6 {
                    flex: 0 0 50%;
                    max-width: 50%;
                }

                .col-md-4 {
                    flex: 0 0 33.333%;
                    max-width: 33.333%;
                }

                .col-md-3 {
                    flex: 0 0 25%;
                    max-width: 25%;
                }

                .col-md-2 {
                    flex: 0 0 16.666%;
                    max-width: 16.666%;
                }

                p {
                    margin: 0;
                    padding-right: 15px;
                    font-size: 14px;
                    line-height: 1.5;
                }

                hr {
                    margin: 10px 0;
                    border: 1px solid #ccc;
                }

                .mb-3 {
                    margin-bottom: 10px;
                }

                .img-fluid {
                    max-width: 100%;
                    height: auto;
                }
            </style>
        </head>
        <body>
            <div class="wrapper">
                <img src="${headerImage}" alt="Header Image">
                <div class="container">
                    ${modalContent}
                </div>
                <div class="footer">
                    <img src="${footerImage}" alt="Footer Image">
                </div>
            </div>
        </body>
        </html>
        `;

        printWindow.document.write(content);
        printWindow.document.close();
        printWindow.focus();
        printWindow.print();
    });
});


        // Function to handle Download button click


        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('download-pdf-btn')?.addEventListener('click', function() {
                var modalContent = document.querySelector('.container');
                var headerImage = '{{ asset('assets/img/tmh-icons/Header.png') }}';
                var footerImage = '{{ asset('assets/img/tmh-icons/Footer.png') }}';

                const originalWidth = 2048; // Original width of your image in pixels
                const originalHeight = 443; // Original height of your image in pixels
                const pdfWidth = 190; // Desired width in the PDF in millimeters

                // Calculate height based on the aspect ratio
                const aspectRatio = originalHeight / originalWidth;
                const pdfHeight = pdfWidth * aspectRatio;

                html2canvas(modalContent).then(function(canvas) {
                    var imgData = canvas.toDataURL('image/png');

                    const {
                        jsPDF
                    } = window.jspdf;
                    var pdf = new jsPDF('p', 'mm', 'a4');

                    var header = new Image();
                    header.src = headerImage;
                    header.onload = function() {
                        pdf.addImage(header, 'PNG', 10, 10, pdfWidth, pdfHeight);

                        pdf.addImage(imgData, 'PNG', 10, 60, 190, 0);

                        var footer = new Image();
                        footer.src = footerImage;
                        footer.onload = function() {
                            pdf.addImage(footer, 'PNG', 10, pdf.internal.pageSize.height -
                                30, 190, 20);

                            // Trigger the Save As dialog
                            pdf.save('OPD_Case_Details.pdf');
                        };
                    };
                });
            });
        });
        var baseUrl = "{{ url('/') }}";
        var csrfToken = "{{ csrf_token() }}";
        var headerImage = "{{ asset('assets/img/tmh-icons/Header.png') }}";
        var footerImage = "{{ asset('assets/img/tmh-icons/Footer.png') }}";
    </script>
@endsection
