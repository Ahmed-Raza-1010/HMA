$(document).ready(function () {
  // Initial data fetch when page loads
  getFilteredDischargeData();

  //Custom Selct2 Placeholder
  $('#patient_id').select2({
    placeholder: "Select a patient", // Custom placeholder for patients
    allowClear: true
  });

  $('#ipd_case').select2({
    placeholder: "Select a case", // Custom placeholder for ipd_case
    allowClear: true
  });

  // Function to handle Print button click
  $('#print-btn').click(function () {
      var printWindow = window.open('', '', 'height=600,width=800');
      var content = document.getElementById('plan-details').innerHTML;

      var content = `
          <html>
          <head>
              <title>Discharge Plan Details</title>
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
                      width: 90%;
                      margin: 0 auto;
                  }
                  .row {
                      display: flex;
                      flex-wrap: wrap;
                      margin: -15px;
                  }
                  .col-md-6, .col-md-4 {
                      padding: 15px;
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
                  p {
                      margin: 0;
                  }
                  hr {
                      margin: 20px 0;
                  }
                  .mb-3 {
                      margin-bottom: 20px;
                  }
                  .img-fluid {
                      max-width: 100%;
                      height: auto;
                  }
              </style>
          </head>
          <body>
              <img src="${headerImage}" alt="Header Image">
              <div class="container">
                  ${content}
              </div>
              <img src="${footerImage}" alt="Footer Image">
          </body>
          </html>
      `;

      printWindow.document.write(content);
      printWindow.document.close();
      printWindow.focus();
      printWindow.print();
  });

  // Function to handle Download button click
  $('#download-btn').click(function () {
      var content = document.getElementById('plan-details').innerHTML;

      var content = `
          <html>
          <head>
              <title>Discharge Plan Details</title>
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
                      width: 90%;
                      margin: 0 auto;
                  }
                  .row {
                      display: flex;
                      flex-wrap: wrap;
                      margin: -15px;
                  }
                  .col-md-6, .col-md-4 {
                      padding: 15px;
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
                  p {
                      margin: 0;
                  }
                  hr {
                      margin: 20px 0;
                  }
                  .mb-3 {
                      margin-bottom: 20px;
                  }
                  .img-fluid {
                      max-width: 100%;
                      height: auto;
                  }
              </style>
          </head>
          <body>
              <img src="${headerImage}" alt="Header Image" style="width: 100%; margin-bottom: 20px;">
              <div class="container">
                  ${content}
              </div>
              <img src="${footerImage}" alt="Footer Image" style="width: 100%; margin-top: 20px;">
          </body>
          </html>
      `;

      var blob = new Blob([content], { type: 'text/html' });
      var url = URL.createObjectURL(blob);
      var a = document.createElement('a');
      a.href = url;
      a.download = 'discharge-plan-details.html';
      document.body.appendChild(a);
      a.click();
      document.body.removeChild(a);
      URL.revokeObjectURL(url);
  });

  // Bind click event to the Add New Discharge Plan button
  $('#add-discharge-plan').click(function () {
      window.location.href = '/create/discharge-plan';
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

  // Bind click event to the View button to show modal
  $(document).on('click', '.view-button', function (e) {
      e.preventDefault();

      var planId = $(this).data('id');
      $.ajax({
          url: '/getDischargeDetails/' + planId,
          type: 'GET',
          dataType: 'json',
          success: function (data) {
              $('#plan-details').html(`
                  <div style="display: flex; justify-content: space-between; gap: 20px;">
                      <div style="flex: 1;">
                          <p style="margin-bottom: 0.5rem;"><strong>Plan ID:</strong> ${data.id}</p>
                          <p style="margin-bottom: 0.5rem;"><strong>Visit Number:</strong> ${data.ipd_case.visit_no}</p>
                      </div>
                      <div style="flex: 1;">
                          <p style="margin-bottom: 0.5rem;"><strong>Patient Name:</strong> ${data.patient.name}</p>
                          <p style="margin-bottom: 0.5rem;"><strong>Appointment Date:</strong> ${data.ipd_case.appointment_date}</p>
                      </div>
                  </div>
              `);

              // Show the modal
              $('#dischargePlanModal').modal('show');
          },
          error: function (error) {
              console.log('AJAX request failed.');
              console.log(error);
          }
      });
  });

  // Function to fetch filtered data
  function getFilteredDischargeData() {
      $.ajax({
          url: '/getFilteredDischargeData', // Your actual backend URL
          type: 'get',
          dataType: 'json',
          success: function (data) {
              var dataSet = [];

              // Prepare data for DataTable
              $.each(data, function (index, val) {
                var action = `
                  <a href="/view/discharge-plan/${val.id}" class="btn btn-sm btn-light">View</a>
                  <a href="/edit/discharge-plan/${val.id}" class="btn btn-sm btn-primary">Edit</a>
                `;

                // Conditionally include delete button if canDelete is true
                if (canDelete) {
                  action += `
                    <form action="${baseUrl}delete/discharge-plan/${val.id}" method="POST" style="display:inline;">
                      <input type="hidden" name="_method" value="DELETE">
                      <input type="hidden" name="_token" value="${csrfToken}">
                      <button type="button" class="btn btn-sm btn-icon delete-button" data-id="${val.id}">
                        <i class="ti ti-trash"></i> <!-- Delete icon -->
                      </button>
                    </form>`;
                }

                  // Add each row to the dataSet
                  dataSet.push([val.id, val.patient_name, val.visit_no, val.appointment_date, action]);
              });

              // Destroy and reinitialize DataTable with the new data
              var table = $('.datatables-plans').DataTable();
              table.destroy(); // Destroy the existing table
              $('.datatables-plans').DataTable({
                  aaSorting: [],
                  data: dataSet,
                  columnDefs: [{ className: 'text-nowrap text-left', targets: [0, 1, 2, 3, 4] }],
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
});
