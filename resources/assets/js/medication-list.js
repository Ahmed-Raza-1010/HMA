$(document).ready(function () {
    // Initial data fetch when page loads
    getFilteredMedicineData();

    //Custom Selct2 Placeholder
    $('#medicine-name').select2({
      placeholder: "Select a medicine", // Custom placeholder for patients
      allowClear: true
    });

    // Add New Medicine button click handler
    $('#add-medicine').click(function () {
        window.location.href = '/create/medicine';
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

    // Apply filters
    $('#apply-filters').click(function () {
        getFilteredMedicineData();
    });

    // Reset filters
    $('#reset-filters').click(function () {
        $('#medicine-name').val(''); // Clear the medicine name filter
        getFilteredMedicineData(); // Fetch all data again
    });

    // Fetch filtered data
    function getFilteredMedicineData() {
        var dataSet = [];

        // Get the filter values
        var medicineName = $('#medicine-name').val();

        $.ajax({
            url: '/getFilteredMedicineData', // Your actual backend URL
            type: 'get',
            dataType: 'json',
            data: {
                name: medicineName
                        }, // Send filters in request
            success: function (data) {
                var dataSet = [];

                // Prepare data for DataTable
                $.each(data, function (index, val) {
                    var action = `
                        <a href="/edit/medicine/${val.id}" class="btn btn-sm btn-primary">Edit</a>
                    `;

                    // Conditionally include delete button if canDelete is true
                    if (!val.canDelete) {
                        action += `
                            <form action="${baseUrl}delete/medicine/${val.id}" method="POST" style="display:inline;">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="${csrfToken}">
                                <button type="button" class="btn btn-sm btn-icon delete-button" data-id="${val.id}">
                                    <i class="ti ti-trash"></i> <!-- Delete icon -->
                                </button>
                            </form>`;
                    }

                    // Add each row to the dataSet
                    dataSet.push([val.id, val.name, val.dose, val.frequency, action]);
                });

                // Destroy and reinitialize DataTable with the new data
                var table = $('.datatables-medicines').DataTable();
                table.destroy(); // Destroy the existing table
                $('.datatables-medicines').DataTable({
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
