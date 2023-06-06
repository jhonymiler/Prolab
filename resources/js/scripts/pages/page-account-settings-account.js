$(function () {
    ("use strict");

    // variables
    var form = $(".validate-form"),
        accountUploadImg = $("#account-upload-img"),
        accountUploadBtn = $("#account-upload"),
        accountUserImage = $(".uploadedAvatar"),
        accountResetBtn = $("#account-reset"),
        accountNumberMask = $(".account-number-mask"),
        accountZipCode = $(".account-zip-code"),
        select2 = $(".select2"),
        deactivateAcc = document.querySelector("#formAccountDeactivation"),
        deactivateButton = document.querySelector(".deactivate-account"),
        reactivateAcc = document.querySelector("#formAccountReactivation"),
        reactivateButton = document.querySelector(".reactivate-account");

    // Update user photo on click of button

    if (accountUserImage) {
        var resetImage = accountUserImage.attr("src");
        accountUploadBtn.on("change", function (e) {
            debugger;
            var reader = new FileReader(),
                files = e.target.files;
            reader.onload = function () {
                if (accountUploadImg) {
                    accountUploadImg.attr("src", reader.result);
                }
            };
            reader.readAsDataURL(files[0]);
        });

        accountResetBtn.on("click", function () {
            accountUserImage.attr("src", resetImage);
        });
    }

    // jQuery Validation for all forms
    // --------------------------------------------------------------------
    if (form.length) {
        form.each(function () {
            var $this = $(this);

            $this.validate({
                rules: {
                    name: {
                        required: true,
                    },
                    celular: {
                        required: true,
                    },
                    email: {
                        required: true,
                    },
                },
            });
            // $this.on("submit", function (e) {
            //     e.preventDefault();
            // });
        });
    }

    //=============================================================
    // DESATIVAÇÃO DA CONTA
    // disabled submit button on checkbox unselect
    if (deactivateAcc) {
        $("#accountDectivation").on("change", function () {
            if ($(this).is(":checked") == true) {
                deactivateButton.removeAttribute("disabled");
            } else {
                deactivateButton.setAttribute("disabled", "disabled");
            }
        });
    }

    // Deactivate account alert
    const accountDectivation = document.querySelector("#accountDectivation");

    // Alert With Functional Confirm Button
    if (accountDectivation) {
        deactivateButton.onclick = function () {
            if (accountDectivation.checked == true) {
                Swal.fire({
                    text: "Tem certeza que deseja DESATIVAR esta conta?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Sim",
                    cancelButtonText: "Não",
                    customClass: {
                        confirmButton: "btn btn-primary",
                        cancelButton: "btn btn-outline-danger ms-2",
                    },
                    buttonsStyling: false,
                }).then(function (result) {
                    if (result.value) {
                        id = $("#statusUserId").val();
                        conta = $("#formAccountDeactivation").serialize();
                        $.post(
                            "/users/toogleStatus/" + id,
                            conta,
                            function (result) {
                                Swal.fire({
                                    icon: "success",
                                    title: "Desativado!",
                                    text: "Essa conta foi desativada com sucesso.",
                                    customClass: {
                                        confirmButton: "btn btn-success",
                                    },
                                }).then(function () {
                                    window.location.reload();
                                });
                            }
                        );
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        Swal.fire({
                            title: "Cancelado",
                            text: "Desativação de conta, cancelada!!",
                            icon: "error",
                            customClass: {
                                confirmButton: "btn btn-success",
                            },
                        });
                    }
                });
            }
        };
    }
    //=============================================================
    // ATIVAÇÃO DA CONTA
    // disabled submit button on checkbox unselect
    if (reactivateAcc) {
        $("#accountReactivation").on("change", function () {
            if ($(this).is(":checked") == true) {
                reactivateButton.removeAttribute("disabled");
            } else {
                reactivateButton.setAttribute("disabled", "disabled");
            }
        });
    }

    // Deactivate account alert
    const accountReactivation = document.querySelector("#accountReactivation");

    // Alert With Functional Confirm Button
    if (reactivateButton) {
        reactivateButton.onclick = function () {
            if (accountReactivation.checked == true) {
                Swal.fire({
                    text: "Tem certeza que deseja ATIVAR esta conta?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Sim",
                    cancelButtonText: "Não",
                    customClass: {
                        confirmButton: "btn btn-primary",
                        cancelButton: "btn btn-outline-danger ms-2",
                    },
                    buttonsStyling: false,
                }).then(function (result) {
                    if (result.value) {
                        id = $("#statusUserId").val();
                        conta = $("#formAccountReactivation").serialize();
                        $.post(
                            "/users/toogleStatus/" + id,
                            conta,
                            function (result) {
                                Swal.fire({
                                    icon: "success",
                                    title: "Ativado!",
                                    text: "Essa conta foi ATIVADA com sucesso.",
                                    customClass: {
                                        confirmButton: "btn btn-success",
                                    },
                                }).then(function () {
                                    window.location.reload();
                                });
                            }
                        );
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        Swal.fire({
                            title: "Cancelado",
                            text: "Ativação de conta, cancelada!!",
                            icon: "error",
                            customClass: {
                                confirmButton: "btn btn-success",
                            },
                        });
                    }
                });
            }
        };
    }
    //=============================================================

    //phone
    if (accountNumberMask.length) {
        accountNumberMask.each(function () {
            $(this).mask("(00) 0 0000-0000");
        });
    }

    //zip code
    if (accountZipCode.length) {
        accountZipCode.each(function () {
            $(this).mask("00000-000");
        });
    }

    // For all Select2
    if (select2.length) {
        select2.each(function () {
            var $this = $(this);
            $this.wrap('<div class="position-relative"></div>');
            $this.select2({
                dropdownParent: $this.parent(),
            });
        });
    }
});
