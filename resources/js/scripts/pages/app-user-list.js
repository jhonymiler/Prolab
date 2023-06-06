/*=========================================================================================
    File Name: app-user-list.js
    Description: User List page
    --------------------------------------------------------------------------------------
    Item Name: Vuexy  - Vuejs, HTML & Laravel Admin Dashboard Template
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent

==========================================================================================*/
var statusObj = {
    null: {
        title: "Pendente",
        class: "badge-light-warning",
    },
    1: { title: "Ativo", class: "badge-light-success" },
    0: { title: "Inativo", class: "badge-light-secondary" },
};

function ativa_desativa(user, status) {
    var id = user;
    var conta = {};

    switch (status) {
        case null || 1:
            texto = "Tem certeza que deseja DESATIVAR esta conta?";
            titulo = "Desativado!";
            texto2 = "Essa conta foi desativada com sucesso.";
            texto3 = "Desativação de conta, cancelada!!";
            conta["status"] = 0;
            icon =
                feather.icons["user-check"].toSvg({
                    class: "font-small-4 me-50",
                }) + "Ativar";
            break;

        default:
            texto = "Tem certeza que deseja ATIVAR esta conta?";
            titulo = "Ativado!";
            texto2 = "Essa conta foi ativada com sucesso.";
            texto3 = "Ativação de conta, cancelada!!";
            conta["status"] = 1;
            icon =
                feather.icons["user-x"].toSvg({
                    class: "font-small-4 me-50",
                }) + "Desativar";
            break;
    }

    Swal.fire({
        text: texto,
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
            conta["_token"] = $('meta[name="csrf-token"]').attr("content");

            $.post("/users/toogleStatus/" + id, conta, function (result) {
                Swal.fire({
                    icon: "success",
                    title: titulo,
                    text: texto2,
                    customClass: {
                        confirmButton: "btn btn-success",
                    },
                }).then(function () {
                    st = conta["status"] === null ? "null" : conta["status"];

                    $(".user_" + id).removeClass(
                        "badge-light-warning badge-light-success badge-light-secondary"
                    );

                    $(".user_" + id)
                        .addClass(statusObj[st].class)
                        .text(statusObj[st].title);

                    $(".link_status_" + id)
                        .attr(
                            "href",
                            "javascript:ativa_desativa(" +
                                id +
                                "," +
                                conta["status"] +
                                ");"
                        )
                        .html(icon);
                });
            });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire({
                title: "Cancelado",
                text: texto3,
                icon: "error",
                customClass: {
                    confirmButton: "btn btn-success",
                },
            });
        }
    });
}

$(function () {
    ("use strict");

    var dtUserTable = $(".user-list-table"),
        newUserSidebar = $(".new-user-modal"),
        newUserForm = $(".add-new-user"),
        select = $(".select2"),
        dtContact = $(".dt-contact");

    var assetPath = "../../../app-assets/",
        userView = "users/show/";

    if ($("body").attr("data-framework") === "laravel") {
        assetPath = $("body").attr("data-asset-path");
        userView = assetPath + "users/show/";
    }

    select.each(function () {
        var $this = $(this);
        $this.wrap('<div class="position-relative"></div>');
        $this.select2({
            // the following code is used to disable x-scrollbar when click in select input and
            // take 100% width in responsive also
            dropdownAutoWidth: true,
            width: "100%",
            dropdownParent: $this.parent(),
        });
    });

    // Users List datatable
    if (dtUserTable.length) {
        dtUserTable.DataTable({
            ajax: assetPath + "users/getUsers", // JSON file to add data
            columns: [
                // columns according to JSON
                { data: "" },
                { data: "name" },
                { data: "celular" },
                { data: "nivel" },
                { data: "status" },
                { data: "" },
            ],
            language: {
                url: "//cdn.datatables.net/plug-ins/1.13.1/i18n/pt-BR.json",
            },
            columnDefs: [
                {
                    // For Responsive
                    className: "control",
                    orderable: false,
                    responsivePriority: 2,
                    targets: 0,
                    render: function (data, type, full, meta) {
                        return "";
                    },
                },
                {
                    // User full name and username
                    targets: 1,
                    responsivePriority: 4,
                    render: function (data, type, full, meta) {
                        var $name = full["name"],
                            $email = full["email"],
                            $image = full["avatar"];
                        if ($image) {
                            // For Avatar image
                            var $output =
                                '<img src="' +
                                assetPath +
                                "avatar/" +
                                $image +
                                '" alt="Avatar" height="32" width="32">';
                        } else {
                            // For Avatar badge
                            var stateNum = Math.floor(Math.random() * 6) + 1;
                            var states = [
                                "success",
                                "danger",
                                "warning",
                                "info",
                                "dark",
                                "primary",
                                "secondary",
                            ];
                            var $state = states[stateNum],
                                $name = full["name"],
                                $initials = $name.match(/\b\w/g) || [];
                            $initials = (
                                ($initials.shift() || "") +
                                ($initials.pop() || "")
                            ).toUpperCase();
                            $output =
                                '<span class="avatar-content">' +
                                $initials +
                                "</span>";
                        }
                        var colorClass =
                            $image === "" ? " bg-light-" + $state + " " : "";
                        // Creates full output for row
                        var $row_output =
                            '<div class="d-flex justify-content-left align-items-center">' +
                            '<div class="avatar-wrapper">' +
                            '<div class="avatar ' +
                            colorClass +
                            ' me-1">' +
                            $output +
                            "</div>" +
                            "</div>" +
                            '<div class="d-flex flex-column">' +
                            '<a href="' +
                            userView +
                            full["id"] +
                            '" class="user_name text-truncate text-body"><span class="fw-bolder">' +
                            $name +
                            "</span></a>" +
                            '<small class="emp_post text-muted">' +
                            $email +
                            "</small>" +
                            "</div>" +
                            "</div>";
                        return $row_output;
                    },
                },
                {
                    targets: 2,
                    render: function (data, type, full, meta) {
                        var $celular = full["celular"];

                        return (
                            '<span class="text-nowrap">' + $celular + "</span>"
                        );
                    },
                },
                {
                    // User Role
                    targets: 3,
                    render: function (data, type, full, meta) {
                        var $role = full["nivel"].name;
                        var roleBadgeObj = {
                            Usuario: feather.icons["user"].toSvg({
                                class: "font-medium-3 text-primary me-50",
                            }),
                            Administrador: feather.icons["settings"].toSvg({
                                class: "font-medium-3 text-warning me-50",
                            }),
                            "Super-Admin": feather.icons["database"].toSvg({
                                class: "font-medium-3 text-success me-50",
                            }),
                            Gestor: feather.icons["edit-2"].toSvg({
                                class: "font-medium-3 text-info me-50",
                            }),
                        };

                        nivel_name = roleBadgeObj[$role]
                            ? roleBadgeObj[$role]
                            : roleBadgeObj["Usuario"];
                        return (
                            "<span class='text-truncate align-middle'>" +
                            nivel_name +
                            $role +
                            "</span>"
                        );
                    },
                },

                {
                    // User Status
                    targets: 4,
                    render: function (data, type, full, meta) {
                        var $status =
                            full["status"] === null ? "null" : full["status"];

                        return (
                            '<span class="user_' +
                            full["id"] +
                            " badge rounded-pill " +
                            statusObj[$status].class +
                            '" text-capitalized>' +
                            statusObj[$status].title +
                            "</span>"
                        );
                    },
                },
                {
                    // Actions
                    targets: -1,
                    title: "Actions",
                    orderable: false,
                    render: function (data, type, full, meta) {
                        return (
                            '<div class="btn-group">' +
                            '<a class="btn btn-sm dropdown-toggle hide-arrow" data-bs-toggle="dropdown">' +
                            feather.icons["more-vertical"].toSvg({
                                class: "font-small-4",
                            }) +
                            "</a>" +
                            '<div class="dropdown-menu dropdown-menu-end">' +
                            '<a href="' +
                            userView +
                            full["id"] +
                            '" class="dropdown-item">' +
                            feather.icons["file-text"].toSvg({
                                class: "font-small-4 me-50",
                            }) +
                            "Editar</a>" +
                            '<a href="javascript:ativa_desativa(' +
                            full["id"] +
                            "," +
                            full["status"] +
                            ');" class="dropdown-item delete-record link_status_' +
                            full["id"] +
                            '">' +
                            feather.icons["user-x"].toSvg({
                                class: "font-small-4 me-50",
                            }) +
                            "Desativar</a></div>" +
                            "</div>" +
                            "</div>"
                        );
                    },
                },
            ],
            order: [[1, "desc"]],
            dom:
                '<"d-flex justify-content-between align-items-center header-actions mx-2 row mt-75"' +
                '<"col-sm-12 col-lg-4 d-flex justify-content-center justify-content-lg-start" l>' +
                '<"col-sm-12 col-lg-8 ps-xl-75 ps-0"<"dt-action-buttons d-flex align-items-center justify-content-center justify-content-lg-end flex-lg-nowrap flex-wrap"<"me-1"f>B>>' +
                ">t" +
                '<"d-flex justify-content-between mx-2 row mb-1"' +
                '<"col-sm-12 col-md-6"i>' +
                '<"col-sm-12 col-md-6"p>' +
                ">",

            // Buttons with Dropdown
            buttons: [
                {
                    extend: "collection",
                    className: "btn btn-outline-secondary dropdown-toggle me-2",
                    text:
                        feather.icons["external-link"].toSvg({
                            class: "font-small-4 me-50",
                        }) + "Exportar",
                    buttons: [
                        {
                            extend: "print",
                            text:
                                feather.icons["printer"].toSvg({
                                    class: "font-small-4 me-50",
                                }) + "Imprimir",
                            className: "dropdown-item",
                            exportOptions: { columns: [1, 2, 3, 4, 5] },
                        },
                        {
                            extend: "csv",
                            text:
                                feather.icons["file-text"].toSvg({
                                    class: "font-small-4 me-50",
                                }) + "Csv",
                            className: "dropdown-item",
                            exportOptions: { columns: [1, 2, 3, 4, 5] },
                        },
                        {
                            extend: "excel",
                            text:
                                feather.icons["file"].toSvg({
                                    class: "font-small-4 me-50",
                                }) + "Excel",
                            className: "dropdown-item",
                            exportOptions: { columns: [1, 2, 3, 4, 5] },
                        },
                        {
                            extend: "pdf",
                            text:
                                feather.icons["clipboard"].toSvg({
                                    class: "font-small-4 me-50",
                                }) + "Pdf",
                            className: "dropdown-item",
                            exportOptions: { columns: [1, 2, 3, 4, 5] },
                        },
                        {
                            extend: "copy",
                            text:
                                feather.icons["copy"].toSvg({
                                    class: "font-small-4 me-50",
                                }) + "Copiar",
                            className: "dropdown-item",
                            exportOptions: { columns: [1, 2, 3, 4, 5] },
                        },
                    ],
                    init: function (api, node, config) {
                        $(node).removeClass("btn-secondary");
                        $(node).parent().removeClass("btn-group");
                        setTimeout(function () {
                            $(node)
                                .closest(".dt-buttons")
                                .removeClass("btn-group")
                                .addClass("d-inline-flex mt-50");
                        }, 50);
                    },
                },
                {
                    text: "Novo Usuário",
                    className: "add-new btn btn-primary",
                    attr: {
                        "data-bs-toggle": "modal",
                        "data-bs-target": "#modals-slide-in",
                    },
                    init: function (api, node, config) {
                        $(node).removeClass("btn-secondary");
                    },
                },
            ],
            // For responsive popup
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.modal({
                        header: function (row) {
                            var data = row.data();
                            return "Detalhes de " + data["name"];
                        },
                    }),
                    type: "column",
                    renderer: function (api, rowIdx, columns) {
                        var data = $.map(columns, function (col, i) {
                            return col.columnIndex !== 6 // ? Do not show row in modal popup if title is blank (for check box)
                                ? '<tr data-dt-row="' +
                                      col.rowIdx +
                                      '" data-dt-column="' +
                                      col.columnIndex +
                                      '">' +
                                      "<td>" +
                                      col.title +
                                      ":" +
                                      "</td> " +
                                      "<td>" +
                                      col.data +
                                      "</td>" +
                                      "</tr>"
                                : "";
                        }).join("");
                        return data
                            ? $('<table class="table"/>').append(
                                  "<tbody>" + data + "</tbody>"
                              )
                            : false;
                    },
                },
            },

            initComplete: function () {
                // Adding role filter once table initialized
                this.api()
                    .columns(3)
                    .every(function () {
                        var column = this;
                        var label = $(
                            '<label class="form-label" for="UserRole">Nível de Acesso</label>'
                        ).appendTo(".user_role");
                        var select = $(
                            '<select id="UserRole" class="form-select text-capitalize mb-md-0 mb-2"><option value=""> Selecione um Nível </option></select>'
                        )
                            .appendTo(".user_role")
                            .on("change", function () {
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );
                                column
                                    .search(
                                        val ? "^" + val + "$" : "",
                                        true,
                                        false
                                    )
                                    .draw();
                            });

                        column
                            .data()
                            .unique()
                            .sort()
                            .each(function (d, j) {
                                select.append(
                                    '<option value="' +
                                        d.name +
                                        '" class="text-capitalize">' +
                                        d.name +
                                        "</option>"
                                );
                            });
                    });

                this.api()
                    .columns(4)
                    .every(function () {
                        var column = this;
                        var label = $(
                            '<label class="form-label" for="FilterTransaction">Status</label>'
                        ).appendTo(".user_status");
                        var select = $(
                            '<select id="FilterTransaction" class="form-select text-capitalize mb-md-0 mb-2xx"><option value=""> Selecione um Status </option></select>'
                        )
                            .appendTo(".user_status")
                            .on("change", function () {
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );
                                column
                                    .search(
                                        val ? "^" + val + "$" : "",
                                        true,
                                        false
                                    )
                                    .draw();
                            });

                        column
                            .data()
                            .unique()
                            .sort()
                            .each(function (d, j) {
                                select.append(
                                    '<option value="' +
                                        statusObj[d].title +
                                        '" class="text-capitalize">' +
                                        statusObj[d].title +
                                        "</option>"
                                );
                            });
                    });
            },
        });
    }

    // Form Validation
    if (newUserForm.length) {
        newUserForm.validate({
            errorClass: "error",
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

                nivel: {
                    required: true,
                },
            },
        });

        // newUserForm.on("submit", function (e) {
        //     var isValid = newUserForm.valid();
        //     e.preventDefault();
        //     if (isValid) {
        //         newUserSidebar.modal("hide");
        //         newUserForm.submit();
        //     }
        // });
    }
});
