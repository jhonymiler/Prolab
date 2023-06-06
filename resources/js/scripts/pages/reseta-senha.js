$(function () {
    ("use strict");

    // variables
    var form = $(".validate-form");

    // jQuery Validation for all forms
    // --------------------------------------------------------------------
    if (form.length) {
        form.each(function () {
            var $this = $(this);

            $this.validate({
                rules: {
                    senha: {
                        required: true,
                        minlength: 8,
                    },
                    senha_confirmation: {
                        required: true,
                        minlength: 8,
                        equalTo: "#senha",
                    },
                },
                messages: {
                    senha: {
                        required: "Entre com a nova senha",
                        minlength: "Senha deve ter no mínimo 8 caracteres",
                    },
                    senha_confirmation: {
                        required: "Por favor, confirme a senha",
                        minlength: "Senha deve ter no mínimo 8 caracteres",
                        equalTo:
                            "As senhas não são iguais, confirme novamente a senha.",
                    },
                },
            });
        });
    }
});
