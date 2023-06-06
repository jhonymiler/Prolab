/**
 * App user list
 */

$(function () {
    "use strict";

    var dataTablePermissions = $(".datatables-permissions"),
        assetPath = "../../../app-assets/",
        dt_permission,
        userList = "app-user-list.html";

    if ($("body").attr("data-framework") === "laravel") {
        assetPath = $("body").attr("data-asset-path");
        userList = assetPath + "users/niveis";
    }

    // Users List datatable
    if (dataTablePermissions.length) {
        dt_permission = dataTablePermissions.DataTable({
            ajax: assetPath + "users/permissoes/list", // JSON file to add data

            columns: [
                // columns according to JSON
                { data: "" },
                { data: "id" },
                { data: "name" },
                { data: "roles" },
                { data: "created_at" },
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
                    targets: 1,
                    visible: false,
                },
                {
                    // remove ordering from Name
                    targets: 2,
                    orderable: false,
                },
                {
                    // User Role
                    targets: 3,
                    orderable: false,
                    render: function (data, type, full, meta) {
                        var $assignedTo = full["roles"],
                            $output = "";
                        var roleBadgeObj = {
                            Administrador:
                                '<a href="' +
                                userList +
                                '" class="me-50"><span class="badge rounded-pill badge-light-danger">Administrator</span></a>',
                            Gestor:
                                '<a href="' +
                                userList +
                                '" class="me-50"><span class="badge rounded-pill badge-light-warning">Gestor</span></a>',
                            Usuario:
                                '<a href="' +
                                userList +
                                '" class="me-50"><span class="badge rounded-pill badge-light-success">Users</span></a>',
                        };
                        for (var i = 0; i < $assignedTo.length; i++) {
                            var val = $assignedTo[i].name;

                            if (roleBadgeObj[val]) {
                                $output += roleBadgeObj[val];
                            } else {
                                $output +=
                                    '<a href="' +
                                    userList +
                                    '" class="me-50"><span class="badge rounded-pill badge-light-primary">' +
                                    val +
                                    "</span></a>";
                            }
                        }
                        return $output;
                    },
                },
                {
                    // remove ordering from Name
                    targets: 4,
                    title: "Data Criação",
                    orderable: false,
                    render: function (data, type, full, meta) {
                        let dd = new Date(full["created_at"]);

                        let data_criacao = dd.toLocaleString("pt-BR");
                        return data_criacao;
                    },
                },
                {
                    // Actions
                    targets: -1,
                    title: "Ações",
                    visible: false,
                    orderable: false,
                    render: function (data, type, full, meta) {
                        return (
                            '<button class="btn btn-sm btn-icon delete-record" id="' +
                            full["id"] +
                            '">' +
                            feather.icons["trash"].toSvg({
                                class: "font-medium-2 text-body",
                            }) +
                            "</button>"
                        );
                    },
                },
            ],
            order: [[1, "asc"]],
            dom:
                '<"d-flex justify-content-between align-items-center header-actions text-nowrap mx-1 row mt-75"' +
                '<"col-sm-12 col-lg-4 d-flex justify-content-center justify-content-lg-start" l>' +
                '<"col-sm-12 col-lg-8"<"dt-action-buttons d-flex align-items-center justify-content-lg-end justify-content-center flex-md-nowrap flex-wrap"<"me-1"f><"user_role mt-50 width-200 me-1">B>>' +
                '><"text-nowrap" t>' +
                '<"d-flex justify-content-between mx-2 row mb-1"' +
                '<"col-sm-12 col-md-6"i>' +
                '<"col-sm-12 col-md-6"p>' +
                ">",

            // Buttons with Dropdown
            buttons: [
                {
                    text: "Adicionar Permissão",
                    className: "add-new btn btn-primary mt-50",
                    attr: {
                        "data-bs-toggle": "modal",
                        "data-bs-target": "#addPermissionModal",
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
                            return "Detalhes da Permissão";
                        },
                    }),
                    type: "column",
                    renderer: function (api, rowIdx, columns) {
                        var data = $.map(columns, function (col, i) {
                            return col.title !== "" // ? Do not show row in modal popup if title is blank (for check box)
                                ? '<tr data-dt-row="' +
                                      col.rowIndex +
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
                            ? $('<table class="table"/><tbody />').append(data)
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

                        var select = $(
                            '<select id="UserRole" class="form-select text-capitalize"><option value=""> Selecione um nível </option></select>'
                        )
                            .appendTo(".user_role")
                            .on("change", function () {
                                debugger;

                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );
                                column
                                    .search(
                                        val ? "[" + val + "]+" : "",
                                        true,
                                        false
                                    )
                                    .draw();
                            });

                        var dadosPermissao = [];
                        column
                            .data()
                            .unique()
                            .sort()
                            .each(function (d, j) {
                                for (let i = 0; i < d.length; i++) {
                                    if (
                                        dadosPermissao.indexOf(d[i].name) === -1
                                    ) {
                                        select.append(
                                            '<option value="' +
                                                d[i].name +
                                                '" class="text-capitalize">' +
                                                d[i].name +
                                                "</option>"
                                        );
                                        dadosPermissao.push(d[i].name);
                                    }
                                }
                            });
                    });
            },
        });
    }

    // Delete Record
    $(".datatables-permissions tbody").on(
        "click",
        ".delete-record",
        function () {
            var linha = $(this).parents("tr");
            var id = $(this).attr("id");

            Swal.fire({
                html:
                    '<div class="alert alert-danger" role="alert">' +
                    '<h6 class="alert-heading">Cuidado!</h6>' +
                    '<div class="alert-body">' +
                    "Ao deletar a permissão, você pode quebrar a funcionalidade de permissões do sistema." +
                    "Certifique-se de ter certeza absoluta antes de prosseguir." +
                    "</div>" +
                    "</div>",
                icon: "danger",
                showCancelButton: true,
                confirmButtonText: "Sim",
                cancelButtonText: "Não",
                customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: "btn btn-outline-danger ms-2",
                },
                buttonsStyling: false,
            }).then(function (result) {
                var post = [];
                if (result.value) {
                    $.ajaxSetup({
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                        },
                    });
                    $.get(
                        "/users/permissoes/delete/" + id,
                        post,
                        function (result) {
                            if (result) {
                                Swal.fire({
                                    icon: "success",
                                    title: "Deletado com Sucesso",
                                    text: "A permissão foi excluída com sucesso!",
                                    customClass: {
                                        confirmButton: "btn btn-success",
                                    },
                                }).then(function () {
                                    dt_permission.row(linha).remove().draw();
                                });
                            } else {
                                Swal.fire({
                                    icon: "error",
                                    title: "Erro",
                                    text: "Por algum motivo a permissão não pode ser excluída",
                                    customClass: {
                                        confirmButton: "btn btn-success",
                                    },
                                });
                            }
                        }
                    );
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    Swal.fire({
                        title: "Cancelado",
                        text: "Operação cancelada",
                        icon: "error",
                        customClass: {
                            confirmButton: "btn btn-success",
                        },
                    });
                }
            });
        }
    );

    // Filter form control to default size
    // ? setTimeout used for multilingual table initialization
    setTimeout(() => {
        $(".dataTables_filter .form-control").removeClass("form-control-sm");
        $(".dataTables_length .form-select").removeClass("form-select-sm");
    }, 300);

    $(document).on("keyup", "#permissao", function (e) {
        let valor = $(this).val();
        let rex = /([^a-z]+)/g;
        $(this).val(valor.replace(rex, ""));
    });
});
