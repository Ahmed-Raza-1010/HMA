$(document).ready(function(){r(),$("#patient_id").select2({placeholder:"Select a patient",allowClear:!0}),$("#ipd_case").select2({placeholder:"Select a case",allowClear:!0}),$("#surgeon_id").select2({placeholder:"Select a surgeon",allowClear:!0}),$("#assistant_id").select2({placeholder:"Select an assistant",allowClear:!0}),$("#print-btn").click(function(){var t=window.open("","","height=600,width=800"),o=document.getElementById("note-details").innerHTML,e=`
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
              ${o}
          </div>
          <img src="${footerImage}" class="footer-img" alt="Footer Image">
      </body>
      </html>
    `;t.document.write(e),t.document.close(),t.focus(),t.print()}),$("#download-btn").click(function(){var t=document.getElementById("note-details").innerHTML,o=`
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
              ${t}
          </div>
          <img src="${footerImage}" class="footer-img" alt="Footer Image">
      </body>
      </html>
    `,e=new Blob([o],{type:"text/html"}),a=URL.createObjectURL(e),n=document.createElement("a");n.href=a,n.download="note-details.html",document.body.appendChild(n),n.click(),document.body.removeChild(n),URL.revokeObjectURL(a)}),$("#add-note").click(function(){window.location.href="/create/operational-note"}),$(document).on("click",".delete-button",function(t){t.preventDefault();var o=$(this).closest("form");Swal.fire({title:"Are you sure?",text:"You won't be able to revert this!",icon:"warning",showCancelButton:!0,confirmButtonText:"Yes, delete it!",cancelButtonText:"Cancel",customClass:{confirmButton:"btn btn-primary me-2 waves-effect waves-light",cancelButton:"btn btn-label-secondary waves-effect waves-light"},buttonsStyling:!1}).then(function(e){e.isConfirmed&&o.submit()})}),$(document).on("click",".view-button",function(t){t.preventDefault();var o=$(this).data("id");$.ajax({url:"/getNoteDetails/"+o,type:"GET",dataType:"json",success:function(e){$("#note-details").html(`
          <div style="display: flex; justify-content: space-between; gap: 20px;">
              <div style="flex: 1;">
                  <p style="margin-bottom: 0.5rem;"><strong>Note ID:</strong> ${e.id}</p>
                  <p style="margin-bottom: 0.5rem;"><strong>Surgeon Name:</strong> ${e.doctor.name}</p>
                  <p style="margin-bottom: 0.5rem;"><strong>Indication Of Surgery:</strong> ${e.indication_of_surgery}</p>
                  <p style="margin-bottom: 0.5rem;"><strong>Operative Findings:</strong> ${e.operative_findings}</p>
              </div>
              <div style="flex: 1;">
                  <p style="margin-bottom: 0.5rem;"><strong>Patient Name:</strong> ${e.patient.name}</p>
                  <p style="margin-bottom: 0.5rem;"><strong>Procedure Name:</strong> ${e.procedure_name}</p>
                  <p style="margin-bottom: 0.5rem;"><strong>Post Operation Orders:</strong> ${e.post_operation_orders}</p>
                  <p style="margin-bottom: 0.5rem;"><strong>Special Instructions:</strong> ${e.special_instruction}</p>
              </div>
          </div>
        `),$("#noteDetailsModal").modal("show")},error:function(e){console.log("AJAX request failed."),console.log(e)}})});function r(){$.ajax({url:"/getFilteredNotesData",type:"get",dataType:"json",success:function(t){var o=[];$.each(t,function(a,n){var i=`
            <a href="/view/operational-note/${n.id}" class="btn btn-sm btn-light">View</a>
            <a href="/edit/operational-note/${n.id}" class="btn btn-sm btn-primary">Edit</a>
          `;canDelete&&(i+=`
              <form action="${baseUrl}delete/operational-note/${n.id}" method="POST" style="display:inline;">
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="_token" value="${csrfToken}">
                <button type="button" class="btn btn-sm btn-icon delete-button" data-id="${n.id}">
                  <i class="ti ti-trash"></i> <!-- Delete icon -->
                </button>
              </form>`),o.push([n.id,n.patient_name,n.surgeon_name,n.appointment_date,i])});var e=$(".datatables-notes").DataTable();e.destroy(),$(".datatables-notes").DataTable({aaSorting:[],data:o,columnDefs:[{className:"text-nowrap text-left",targets:[0,1,2,3,4]}],drawCallback:function(a){feather.replace(),$('[data-toggle="tooltip"]').tooltip()}})},error:function(t){console.log("AJAX request failed."),console.log(t)}})}});
