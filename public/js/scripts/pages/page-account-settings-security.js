$((function(){var e=$(".validate-form"),a=$(".select2"),r=$(".account-number-mask");e.length&&e.each((function(){$(this).validate({rules:{password:{required:!0},"new-password":{required:!0,minlength:8},"confirm-new-password":{required:!0,minlength:8,equalTo:"#account-new-password"},apiKeyName:{required:!0}},messages:{"new-password":{required:"Enter new password",minlength:"Enter at least 8 characters"},"confirm-new-password":{required:"Please confirm new password",minlength:"Enter at least 8 characters",equalTo:"The password and its confirm are not the same"}}})})),r.length&&r.each((function(){$(this).mask("(00) 0 0000-0000")})),a.length&&a.each((function(){var e=$(this);e.wrap('<div class="position-relative"></div>'),e.select2({dropdownParent:e.parent()})}))}));
