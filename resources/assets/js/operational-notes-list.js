$(document).ready(function () {
  // Initial data fetch when page loads
  getFilteredNotesData();

  //Custom Selct2 Placeholder
  $('#patient_id').select2({
    placeholder: "Select a patient", // Custom placeholder for patients
    allowClear: true
  });

  $('#ipd_case').select2({
    placeholder: "Select a case", // Custom placeholder for ipd_case
    allowClear: true
  });

  $('#surgeon_id').select2({
    placeholder: "Select a surgeon", // Custom placeholder for surgeon_id
    allowClear: true
  });

  $('#assistant_id').select2({
    placeholder: "Select an assistant", // Custom placeholder for assistant_id
    allowClear: true
  });
  // Show the modal when the page loads
  // $('#oprNoteModal').modal('show');

  // Function to handle Print button click
  $('#print-btn').click(function () {
    var printWindow = window.open('', '', 'height=600,width=800');
    var content = document.getElementById('note-details').innerHTML;

    var printContent = `
      <html>
      <head>
          <title>Note Details</title>
          <style>
              body {
                  font-family: Arial, sans-serif;
                  margin: 0;
                  padding: 20px;
                  width: 100%;
                  box-sizing: border-box;
                  display: flex;
                  flex-direction: column;
                  align-items: center;
              }
              .header-img, .footer-img {
                  display: block;
                  width: 60%;
                  max-width: 100%;
                  margin-bottom: 20px;
                  text-align: center;
              }
              .container {
                  width: 60%;
                  padding: 0 15px;
                  box-sizing: border-box;
                  text-align: left;
              }
          </style>
      </head>
      <body>
          <img src="${headerImage}" class="header-img" alt="Header Image">
          <div class="container">
              ${content}
          </div>
          <img src="${footerImage}" class="footer-img" alt="Footer Image">
      </body>
      </html>
    `;

    printWindow.document.write(printContent);
    printWindow.document.close();
    printWindow.focus();
    printWindow.print();
  });

  // Function to handle Download button click
  $('#download-btn').click(function () {
    var content = document.getElementById('note-details').innerHTML;

    var downloadContent = `
      <html>
      <head>
          <title>Note Details</title>
          <style>
              body {
                  font-family: Arial, sans-serif;
                  margin: 0;
                  padding: 20px;
                  width: 100%;
                  box-sizing: border-box;
                  display: flex;
                  flex-direction: column;
                  align-items: center;
              }
              .header-img, .footer-img {
                  display: block;
                  width: 60%;
                  max-width: 100%;
                  margin-bottom: 20px;
                  text-align: center;
              }
              .container {
                  width: 60%;
                  padding: 0 15px;
                  box-sizing: border-box;
                  text-align: left;
              }
          </style>
      </head>
      <body>
          <img src="${headerImage}" class="header-img" alt="Header Image">
          <div class="container">
              ${content}
          </div>
          <img src="${footerImage}" class="footer-img" alt="Footer Image">
      </body>
      </html>
    `;

    var blob = new Blob([downloadContent], { type: 'text/html' });
    var url = URL.createObjectURL(blob);
    var a = document.createElement('a');
    a.href = url;
    a.download = 'note-details.html';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
  });

  // Bind click event to the Add New Note button
  $('#add-note').click(function () {
    window.location.href = '/create/operational-note';
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

    var noteId = $(this).data('id');

    $.ajax({
      url: '/getNoteDetails/' + noteId,
      type: 'GET',
      dataType: 'json',
      success: function (data) {
        $('#note-details').html(`
          <div style="display: flex; justify-content: space-between; gap: 20px;">
              <div style="flex: 1;">
                  <p style="margin-bottom: 0.5rem;"><strong>Note ID:</strong> ${data.id}</p>
                  <p style="margin-bottom: 0.5rem;"><strong>Surgeon Name:</strong> ${data.doctor.name}</p>
                  <p style="margin-bottom: 0.5rem;"><strong>Indication Of Surgery:</strong> ${data.indication_of_surgery}</p>
                  <p style="margin-bottom: 0.5rem;"><strong>Operative Findings:</strong> ${data.operative_findings}</p>
              </div>
              <div style="flex: 1;">
                  <p style="margin-bottom: 0.5rem;"><strong>Patient Name:</strong> ${data.patient.name}</p>
                  <p style="margin-bottom: 0.5rem;"><strong>Procedure Name:</strong> ${data.procedure_name}</p>
                  <p style="margin-bottom: 0.5rem;"><strong>Post Operation Orders:</strong> ${data.post_operation_orders}</p>
                  <p style="margin-bottom: 0.5rem;"><strong>Special Instructions:</strong> ${data.special_instruction}</p>
              </div>
          </div>
        `);

        // Show the modal
        $('#noteDetailsModal').modal('show');
      },
      error: function (error) {
        console.log('AJAX request failed.');
        console.log(error);
      }
    });
  });

  // Function to fetch filtered data
  function getFilteredNotesData() {
    $.ajax({
      url: '/getFilteredNotesData', // Your actual backend URL
      type: 'get',
      dataType: 'json',
      success: function (data) {
        var dataSet = [];

        // Prepare data for DataTable
        $.each(data, function (index, val) {
          var action = `
            <a href="/view/operational-note/${val.id}" class="btn btn-sm btn-light">View</a>
            <a href="/edit/operational-note/${val.id}" class="btn btn-sm btn-primary">Edit</a>
          `;

          // Conditionally include delete button if canDelete is true
          if (canDelete) {
            action += `
              <form action="${baseUrl}delete/operational-note/${val.id}" method="POST" style="display:inline;">
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="_token" value="${csrfToken}">
                <button type="button" class="btn btn-sm btn-icon delete-button" data-id="${val.id}">
                  <i class="ti ti-trash"></i> <!-- Delete icon -->
                </button>
              </form>`;
          }

          // Add each row to the dataSet
          dataSet.push([val.id, val.patient_name, val.surgeon_name, val.appointment_date, action]);
        });

        // Destroy and reinitialize DataTable with the new data
        var table = $('.datatables-notes').DataTable();
        table.destroy(); // Destroy the existing table
        $('.datatables-notes').DataTable({
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
