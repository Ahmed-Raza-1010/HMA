$(document).ready(function(){r(),$("#doctors").select2({placeholder:"Select a doctor",allowClear:!0}),$("#print-btn").click(function(){var e=window.open("","","height=600,width=800"),o=document.getElementById("doctor-details").innerHTML;e.document.write(`
        <html>
        <head>
            <title>Doctor Details</title>
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
                ${o}
            </div>
            <img src="${footerImage}" class="footer-img" alt="Footer Image">
        </body>
        </html>
    `),e.document.close(),e.focus(),e.print()}),$("#download-btn").click(function(){var e=document.getElementById("doctor-details").innerHTML,o=`
        <html>
        <head>
            <title>Doctor Details</title>
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
                ${e}
            </div>
            <img src="${footerImage}" class="footer-img" alt="Footer Image">
        </body>
        </html>
    `,t=new Blob([o],{type:"text/html"}),a=URL.createObjectURL(t),i=document.createElement("a");i.href=a,i.download="doctor-details.html",document.body.appendChild(i),i.click(),document.body.removeChild(i),URL.revokeObjectURL(a)}),$("#add-doctor").click(function(){window.location.href="/create/doctor"}),$("#apply-filters").click(function(){s()}),$("#reset-filters").click(function(){c()}),$(document).on("click",".delete-button",function(e){e.preventDefault();var o=$(this).closest("form");Swal.fire({title:"Are you sure?",text:"You won't be able to revert this!",icon:"warning",showCancelButton:!0,confirmButtonText:"Yes, delete it!",cancelButtonText:"Cancel",customClass:{confirmButton:"btn btn-primary me-2 waves-effect waves-light",cancelButton:"btn btn-label-secondary waves-effect waves-light"},buttonsStyling:!1}).then(function(t){t.isConfirmed&&o.submit()})}),$(document).on("click",".view-button",function(e){e.preventDefault();var o=$(this).data("id");$.ajax({url:"/getDoctorDetails/"+o,type:"GET",dataType:"json",success:function(t){$("#doctor-details").html(`
          <div style="display: flex; justify-content: space-between; gap: 20px;">
            <div style="flex: 1;">
              <p style="margin-bottom: 0.5rem;"><strong>Name:</strong> ${t.name}</p>
              <p style="margin-bottom: 0.5rem;"><strong>Email:</strong> ${t.email}</p>
              <p style="margin-bottom: 0.5rem;"><strong>Phone:</strong> ${t.phone}</p>
                            <p style="margin-bottom: 0.5rem;"><strong>Phone:</strong> ${t.gender}</p>

            </div>
            <div style="flex: 1;">
              <p style="margin-bottom: 0.5rem;"><strong>Designation:</strong> ${t.designation}</p>
                            <p style="margin-bottom: 0.5rem;"><strong>City:</strong> ${t.city}</p>
                                          <p style="margin-bottom: 0.5rem;"><strong>Address:</strong> ${t.address}</p>

            </div>
          </div>
        `),$("#doctorDetailsModal").modal("show")},error:function(t){console.log("AJAX request failed."),console.log(t)}})})});function s(){r()}function c(){$("#doctors").val(""),$("#designation").val(""),r()}function r(){var e=$("#doctors").val(),o=$("#designation").val();$.ajax({url:"/getFilteredDoctorData",type:"get",dataType:"json",data:{name:e,designation:o},success:function(t){var a=[];$.each(t,function(d,n){var l=`
          <a href="/view/doctor/${n.id}" class="btn btn-sm btn-light">View</a>
          <a href="/edit/doctor/${n.id}" class="btn btn-sm btn-primary">Edit</a>
        `;canDelete&&(l+=`
            <form action="${baseUrl}delete/doctor/${n.id}" method="POST" style="display:inline;">
              <input type="hidden" name="_method" value="DELETE">
              <input type="hidden" name="_token" value="${csrfToken}">
              <button type="button" class="btn btn-sm btn-icon delete-button" data-id="${n.id}">
                <i class="ti ti-trash"></i> <!-- Delete icon -->
              </button>
            </form>`),a.push([n.id,n.name,n.email,n.phone,n.designation,l])});var i=$(".datatables-users").DataTable();i.destroy(),$(".datatables-users").DataTable({aaSorting:[],data:a,columnDefs:[{className:"text-nowrap text-left",targets:[0,1,2,3,4,5]}],drawCallback:function(d){feather.replace(),$('[data-toggle="tooltip"]').tooltip()}})},error:function(t){console.log("AJAX request failed."),console.log(t)}})}
