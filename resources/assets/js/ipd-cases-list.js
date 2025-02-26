$(document).ready(function () {
  // Initial data fetch when page loads
  getFilteredIPDData();

  //Custom Selct2 Placeholder
  $('#patient_name').select2({
    placeholder: "Select a patient", // Custom placeholder for patients
    allowClear: true
  });

  // $('#patient_id').select2({
  //   placeholder: "Select a patient", // Custom placeholder for patient_id
  //   allowClear: true
  // });

  $('#doctor_id').select2({
    placeholder: "Select a doctor", // Custom placeholder for doctor_id
    allowClear: true
  });

  $(document).ready(function () {
    // Print button click handler
    $('#print-btn').click(function () {
      var printWindow = window.open('', '', 'height=600,width=800');

      // Retrieve the IPD details content
      var ipdDetailsContent = document.getElementById('ipd-details').innerHTML;

      // Full content including header and footer images
      var content = `
          <html>
          <head>
              <title>IPD Case Details</title>
              <style>
                  body {
                      font-family: Arial, sans-serif;
                      margin: 0;
                      padding: 20px;
                      width: 100%;
                      box-sizing: border-box;
                      display: flex;
                      flex-direction: column;
                      align-items: center; /* Center content horizontally */
                  }
                  .header-img, .footer-img {
                      display: block;
                      width: 60%; /* Set width to 60% of the viewport width */
                      max-width: 100%;
                      margin-bottom: 20px; /* Margin between images and content */
                      text-align: center; /* Center image horizontally */
                  }
                  .container {
                      width: 60%; /* Set container width to 60% */
                      padding: 0 15px;
                      box-sizing: border-box;
                      text-align: left; /* Align text content */
                  }
              </style>
          </head>
          <body>
              <img src="${headerImage}" class="header-img" alt="Header Image">
              <div class="container">
                  ${ipdDetailsContent}
              </div>
              <img src="${footerImage}" class="footer-img" alt="Footer Image">
          </body>
          </html>
      `;

      printWindow.document.write(content);
      printWindow.document.close();
      printWindow.focus();
      printWindow.print();
    });
  });

  // Download button click handler
  $('#download-btn').click(function () {
    var ipdDetailsContent = document.getElementById('ipd-details').innerHTML;

    // Full content including header and footer images
    var content = `
        <html>
        <head>
            <title>IPD Case Details</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 0;
                    padding: 20px;
                    width: 100%;
                    box-sizing: border-box;
                    display: flex;
                    flex-direction: column;
                    align-items: center; /* Center content horizontally */
                }
                .header-img, .footer-img {
                    display: block;
                    width: 60%; /* Set width to 60% of the viewport width */
                    max-width: 100%;
                    margin-bottom: 20px; /* Margin between images and content */
                    text-align: center; /* Center image horizontally */
                }
                .container {
                    width: 60%; /* Set container width to 60% */
                    padding: 0 15px;
                    box-sizing: border-box;
                    text-align: left; /* Align text content */
                }
            </style>
        </head>
        <body>
            <img src="${headerImage}" class="header-img" alt="Header Image">
            <div class="container">
                ${ipdDetailsContent}
            </div>
            <img src="${footerImage}" class="footer-img" alt="Footer Image">
        </body>
        </html>
    `;

    var blob = new Blob([content], { type: 'text/html' });
    var url = URL.createObjectURL(blob);
    var a = document.createElement('a');
    a.href = url;
    a.download = 'ipd-details.html';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
  });

  // Add New IPD Case button click handler
  $('#add-ipd-case').click(function () {
    window.location.href = '/create/ipd-case';
  });

  // Apply Filters button click handler
  $('#apply-filters').click(function () {
    applyFilter();
  });

  // Reset Filters button click handler
  $('#reset-filters').click(function () {
    resetFilter();
  });

  // Delete button confirmation with SweetAlert
  $(document).on('click', '.delete-button', function (e) {
    e.preventDefault(); // Prevent default form submission

    var form = $(this).closest('form'); // Get the form related to the delete button

    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, delete it!',
      cancelButtonText: 'Cancel',
      customClass: {
        confirmButton: 'btn btn-primary me-2 waves-effect waves-light',
        cancelButton: 'btn btn-label-secondary waves-effect waves-light'
      },
      buttonsStyling: false
    }).then(function (result) {
      if (result.isConfirmed) {
        form.submit(); // If confirmed, submit the form
      }
    });
  });

  // View button click handler to show modal
  $(document).on('click', '.view-button', function (e) {
    e.preventDefault();

    var ipdCaseId = $(this).data('id');

    $.ajax({
      url: '/getIPDCaseDetails/' + ipdCaseId,
      type: 'get',
      dataType: 'json',
      success: function (data) {
        // Populate modal with IPD case details
        $('#ipd-details').html(`
            <div style="display: flex; justify-content: space-between; gap: 20px;">
              <div style="flex: 1;">
                <p style="margin-bottom: 0.5rem;"><strong>Pateint Name:</strong> ${data.patient_name}</p>
                <p style="margin-bottom: 0.5rem;"><strong>Doctor Name:</strong> ${data.doctor_name}</p>
                <p style="margin-bottom: 0.5rem;"><strong>Gender:</strong> ${data.gender}</p>
                <p style="margin-bottom: 0.5rem;"><strong>Contact # :</strong> ${data.phone}</p>
                <p style="margin-bottom: 0.5rem;"><strong>Diagnose:</strong> ${data.provisional_diagnose}</p>
                <p style="margin-bottom: 0.5rem;"><strong>Appointment Date:</strong> ${data.appointment_date}</p>
                <p style="margin-bottom: 0.5rem;"><strong>History:</strong> ${data.history}</p>
                <p style="margin-bottom: 0.5rem;"><strong>Respiratory:</strong> ${data.respiratory}</p>
                <p style="margin-bottom: 0.5rem;"><strong>Visit No:</strong> ${data.visit_no}</p>
                <p style="margin-bottom: 0.5rem;"><strong>Presenting Complaint:</strong> ${data.presenting_complaint}</p>
                <p style="margin-bottom: 0.5rem;"><strong>Treatment:</strong> ${data.treatment}</p>
                <p style="margin-bottom: 0.5rem;"><strong>Special Instruction:</strong> ${data.special_instruction}</p>
                <p style="margin-bottom: 0.5rem;"><strong>Follow Up Days:</strong> ${data.follow_up_days}</p>

              </div>
            </div>
          `);

        // Show the modal
        $('#ipdCaseDetailsModal').modal('show');
      },
      error: function (error) {
        console.log('AJAX request failed.');
        console.log(error);
      }
    });
  });
});

$(document).on('click', '.view-diagnose-btn', function () {
  var ipdCaseId = $(this).data('id');

  $.ajax({
    url: '/getIPDCaseDetails/' + ipdCaseId,  // Update with your actual route
    type: 'GET',
    dataType: 'json',
    success: function (data) {
      // Populate modal with OPD details
      $('#diagnose-details').html(`
              <p style="margin-bottom: 0.5rem;">${data.provisional_diagnose}</p>
          `);

      // Show the modal
      $('#detailsModal').modal('show');
    },
    error: function (error) {
      console.log('Error fetching details:', error);
    }
  });
});

$(document).on('click', '.create-operational-note', function (e) {
  e.preventDefault();
  var patientId = $(this).data('patient-id');
  var ipdId = $(this).data('ipd-id');
  // Redirect to the create operational note page with parameters
  window.location.href = `/create/operational-note?patient_id=${patientId}&ipd_id=${ipdId}`;
});

$(document).on('click', '.create-discharge-plan', function (e) {
  e.preventDefault();
  var patientId = $(this).data('patient-id');
  var ipdId = $(this).data('ipd-id');
  // Redirect to the create discharge plan page with parameters
  window.location.href = `/create/discharge-plan?patient_id=${patientId}&ipd_id=${ipdId}`;
});

// Apply filters
function applyFilter() {
  getFilteredIPDData();
}

// Reset filters
function resetFilter() {
  $('#patient_name').val(''); // Clear the doctor_name filter
  $('#appointment_date').val(''); // Clear the history filter
  getFilteredIPDData(); // Fetch all data again
}

// Fetch filtered data
function getFilteredIPDData() {
  var dataSet = [];
  // Get the filter values
  var patientName = $('#patient_name').val(); // Ensure you use the correct filter ID
  var appointmentDate = $('#appointment_date').val(); // Ensure you use the correct filter ID

  $.ajax({
    url: '/getFilteredIPDData', // Your actual backend URL
    type: 'get',
    dataType: 'json',
    data: { patient_name: patientName, appointment_date: appointmentDate }, // Send filters in request
    success: function (data) {
      var dataSet = [];
      // if (data.length === 0) {
      //   alert('No IPD cases found for the given filters.');
      // }

      // Prepare data for DataTable
      $.each(data, function (index, val) {
        var action = `
          <a href="/view/ipd-case/${val.id}" class="btn btn-sm btn-light">View</a>
          <a href="/edit/ipd-case/${val.id}" class="btn btn-sm btn-primary">Edit</a>

          <button type="button" class="btn btn-sm btn-icon create-operational-note"
                                data-patient-id="${val.patient_id}"
                                data-ipd-id="${val.id}"
                                data-ipd-id="${val.id}"
                                title="Add Operational Note">
            <i class="ti ti-notes"></i> <!-- Operational Note icon -->
          </button>

          <button type="button" class="btn btn-sm btn-icon create-discharge-plan"
                                data-patient-id="${val.patient_id}"
                                data-ipd-id="${val.id}"
                                data-ipd-id="${val.id}"
                                title="Add Discharge Note">
            <i class="ti ti-checkup-list"></i> <!-- Discharge Plan icon -->
          </button>`;

        // <button type="button" class="btn btn-sm btn-icon" id="dropdownMenuButton${val.id}" data-bs-toggle="dropdown">
        //   <i class="ti ti-arrow-up-right"></i>
        // </button>
        // <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton${val.id}">
        //   <li><a class="dropdown-item create-operational-note" href="#" data-patient-id="${val.patient_id}" data-ipd-id="${val.id}">Create Operational Note</a></li>
        //     <li><a class="dropdown-item create-discharge-plan" href="#" data-patient-id="${val.patient_id}" data-ipd-id="${val.id}">Create Discharge Plan</a></li>
        // </ul>

        // Conditionally include delete button if canDelete is true
        if (canDelete) {
          action += `
            <form action="/delete/ipd-case/${val.id}" method="POST" style="display:inline;">
              <input type="hidden" name="_method" value="DELETE">
              <input type="hidden" name="_token" value="${csrfToken}">
              <button type="button" class="btn btn-sm btn-icon delete-button"
                                    data-id="${val.id}"
                                    title="Delete Case">
                <i class="ti ti-trash"></i> <!-- Delete icon -->
              </button>
            </form>`;
        }

        var viewButton = `
                    <button class="btn btn-sm view-diagnose-btn" data-id="${val.id}">
                        <i class="fas fa-eye"></i>
                    </button>
                    `;

        // Add each row to the dataSet
        dataSet.push([
          val.id, // Patient name
          val.patient_name, // Patient id
          val.gender, // Gender
          viewButton, // Provisional diagnose
          val.phone, // Phone
          action // Action buttons
        ]);
      });

      // Destroy and reinitialize DataTable with the new data
      var table = $('.datatables-ipd-cases').DataTable();
      table.destroy(); // Destroy the existing table
      $('.datatables-ipd-cases').DataTable({
        aaSorting: [],
        data: dataSet,
        columnDefs: [{ className: 'text-nowrap text-left', targets: [0, 1, 2, 3, 4, 5] }],
        drawCallback: function (settings) {
          feather.replace(); // Reapply feather icons
          $('[data-toggle="tooltip"]').tooltip(); // Reapply tooltips
        }
      });
    },
    error: function (error) {
      console.log('AJAX request failed.');
      console.log(error);
    }
  });
}
