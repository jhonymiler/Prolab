// Add new role Modal JS
//------------------------------------------------------------------
(function () {
    var addRoleForm = $("#addRoleForm");

    // add role form validation
    if (addRoleForm.length) {
        addRoleForm.validate({
            rules: {
                modalRoleName: {
                    required: true,
                },
            },
        });
    }

    // reset form on modal hidden
    $(".modal").on("hidden.bs.modal", function () {
        $(this).find("form")[0].reset();
    });

    // Select All checkbox click
    const selectAll = document.querySelector("#selectAll"),
        checkboxList = document.querySelectorAll('[type="checkbox"]');
    selectAll.addEventListener("change", (t) => {
        checkboxList.forEach((e) => {
            e.checked = t.target.checked;
        });
    });

    // On edit role click, update text
    var roleEdit = $(".role-edit-modal"),
        roleAdd = $(".add-new-role"),
        roleTitle = $(".role-title");

    roleAdd.on("click", function () {
        roleTitle.text("Adicionar Novo Nível de Acesso"); // reset text
    });
    roleEdit.on("click", function () {
        roleTitle.text("Editar Nível de Acesso");
    });
})();
