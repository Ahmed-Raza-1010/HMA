(function(){const e=document.querySelector(".cancel-subscription");e&&(e.onclick=function(){Swal.fire({text:"Are you sure you would like to cancel your subscription?",icon:"warning",showCancelButton:!0,confirmButtonText:"Yes",customClass:{confirmButton:"btn btn-primary me-2 waves-effect waves-light",cancelButton:"btn btn-label-secondary waves-effect waves-light"},buttonsStyling:!1}).then(function(t){t.value?Swal.fire({icon:"success",title:"Unsubscribed!",text:"Your subscription cancelled successfully.",customClass:{confirmButton:"btn btn-success waves-effect waves-light"}}):t.dismiss===Swal.DismissReason.cancel&&Swal.fire({title:"Cancelled",text:"Unsubscription Cancelled!!",icon:"error",customClass:{confirmButton:"btn btn-success waves-effect waves-light"}})})});const s=document.querySelector(".edit-address"),n=document.querySelector(".address-title"),c=document.querySelector(".address-subtitle");s.onclick=function(){n.innerHTML="Edit Address",c.innerHTML="Edit your current address"}})();
