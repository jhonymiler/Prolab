@extends('layouts/contentLayoutMaster')

@section('title', 'Tipo de Projeto')

@section('vendor-style')
    {{-- Page Css files --}}
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/rowGroup.bootstrap5.min.css')) }}">
    <link rel='stylesheet' href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
    <link rel='stylesheet' href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">

@endsection

@section('page-style')
    {{-- Page Css files --}}
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
@endsection

@section('content')
    <!-- users list start -->
    <section class="app-user-list">

        <!-- list and filter start -->
        <div class="card">
            <div class="card-header border-bottom p-1">
                <div class="head-label">
                </div>
                <div class="dt-action-buttons text-end">
                    @can('criar configuracoes')
                        <div class="dt-buttons d-inline-flex">
                            <button class="dt-button create-new btn btn-primary" tabindex="0" id="new-tipo-projeto"
                                type="button" data-bs-toggle="modal" data-bs-target="#tipo-projeto"><span><i
                                        data-feather='plus'></i> Novo
                                    Tipo de Projeto</span></button>
                        </div>
                    @endcan

                </div>
            </div>
            <div class="card-datatable table-responsive pt-0">
                <table id="tabela-dados" class="table" style="width:100%">
                    <thead class="table-light">
                        <tr>
                            <th>Id</th>
                            <th>Nome</th>
                            <th>Data Criação</th>
                            <th>Data Atualização</th>
                            <th>Status</th>
                            @canany(['editar configuracoes', 'deletar configuracoes'])
                                <th>Ações</th>
                            @endcanany
                        </tr>
                    </thead>
                    <tbody>
                        @if ($tipos)
                            @foreach ($tipos as $tipo)
                                <tr>
                                    <td>{{ $tipo->id }}</td>

                                    <td>{{ $tipo->nome }}</td>
                                    <td>{{ $tipo->created_at->format('d/m/Y H:m:i') }}</td>
                                    <td>{{ $tipo->updated_at->format('d/m/Y H:m:i') }}</td>
                                    <td>
                                        @if ($tipo->status == 1)
                                            <span class="badge rounded-pill badge-light-success me-1">Ativo</span>
                                        @else
                                            <span class="badge rounded-pill badge-light-danger me-1">Inativo</span>
                                        @endif
                                    </td>
                                    @canany(['editar configuracoes', 'deletar configuracoes'])
                                        <td>
                                            <div class="d-flex">
                                                @can('editar configuracoes')
                                                    <button data-id="{{ $tipo->id }}" data-nome="{{ $tipo->nome }}"
                                                        type="button" class="btn btn-icon btn-flat-info editar waves-effect"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        data-bs-original-title="Editar">
                                                        <i data-feather='edit'></i>
                                                    </button>
                                                @endcan
                                                @can('deletar configuracoes')
                                                    @if ($tipo->status == 1)
                                                        <button data-id="{{ $tipo->id }}" data-status="{{ $tipo->status }}"
                                                            type="button"
                                                            class="btn btn-icon btn-flat-danger ativar_desativar waves-effect"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            data-bs-original-title="Desativar">
                                                            <i data-feather='trash-2'></i>
                                                        </button>
                                                    @else
                                                        <button data-id="{{ $tipo->id }}" data-status="{{ $tipo->status }}"
                                                            type="button"
                                                            class="btn btn-icon btn-flat-success ativar_desativar waves-effect"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            data-bs-original-title="Ativar">
                                                            <i data-feather='check'></i>
                                                        </button>
                                                    @endif
                                                @endcan
                                            </div>


                                        </td>
                                    @endcanany
                                </tr>
                            @endforeach

                        @endif

                    </tbody>

                </table>
            </div>
            <!-- Modal to add new user starts-->
            @canany(['criar configuracoes', 'editar configuracoes'])
                <div class="modal modal-slide-in new-user-modal fade" id="tipo-projeto">
                    <div class="modal-dialog">
                        <form id="form-tipo-projeto" class="add-new-user modal-content pt-0" method="post"
                            action="{{ route('tipo-projeto-save') }}">
                            @csrf
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                            <div class="modal-header mb-1">
                                <h5 class="modal-title" id="exampleModalLabel">Adicionar Tipo de Projeto</h5>
                            </div>
                            <div class="modal-body flex-grow-1">
                                <div class="mb-1">
                                    <label class="form-label" for="nome">Nome</label>
                                    <input type="text" class="form-control dt-full-name" id="nome"
                                        placeholder="Tipo de Projeto" name="nome" />
                                </div>


                                <button type="submit" class="btn btn-primary me-1">Enviar</button>
                                <button type="reset" class="btn btn-outline-secondary"
                                    data-bs-dismiss="modal">Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Modal to add new user Ends-->
            @endcanany

        </div>
        <!-- list and filter end -->
    </section>
    <!-- users list ends -->
@endsection

@section('vendor-script')
    {{-- Vendor js files --}}
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/jszip.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/pdfmake.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/vfs_fonts.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.html5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.print.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.rowGroup.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
@endsection

@section('page-script')
    {{-- Page js files --}}
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>

    <script>
        $(document).ready(function() {

            var form = $("#form-tipo-projeto");
            // Form Validation
            if (form.length) {
                form.validate({
                    errorClass: "error",
                    rules: {
                        nome: {
                            required: true,
                        }
                    },
                });


            }


            $("#new-tipo-projeto").click(function() {
                form.attr('action', "{{ route('tipo-projeto-save') }}").reset()
            });

            $(".editar").click(function() {
                id = $(this).data('id')
                nome = $(this).data('nome')
                form.attr('action', '/config/tipo-projeto/' + id)
                $("#nome").val(nome);
                $("#tipo-projeto").modal('show')
            });

            $(".ativar_desativar").click(function() {
                var id = $(this).data('id')
                var status = $(this).data('status')
                var texto = (status == 0) ? 'Tem certeza que deseja ATIVAR este registro?' :
                    'Por segurança este registro será INATIVADO, deseja mesmo inativá-lo?';
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
                }).then(function(result) {
                    if (result.value) {
                        window.location.href = '/config/tipo-projeto/ativa_desativa/' + id;
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
            })

            $('#tabela-dados').DataTable({
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.1/i18n/pt-BR.json",
                },
                columnDefs: [{
                    type: 'date',
                    targets: [2, 3]
                }],
                buttons: [{
                        extend: "collection",
                        className: "btn btn-outline-secondary dropdown-toggle me-2",
                        text: feather.icons["external-link"].toSvg({
                            class: "font-small-4 me-50",
                        }) + "Exportar",
                        buttons: [{
                                extend: "print",
                                text: feather.icons["printer"].toSvg({
                                    class: "font-small-4 me-50",
                                }) + "Imprimir",
                                className: "dropdown-item",
                                // exportOptions: {
                                //     columns: [1, 2, 3, 4, 5, 6]
                                // },
                            },
                            {
                                extend: "csv",
                                text: feather.icons["file-text"].toSvg({
                                    class: "font-small-4 me-50",
                                }) + "Csv",
                                className: "dropdown-item",
                                // exportOptions: {
                                //     columns: [1, 2, 3, 4, 5, 6]
                                // },
                            },
                            {
                                extend: "excel",
                                text: feather.icons["file"].toSvg({
                                    class: "font-small-4 me-50",
                                }) + "Excel",
                                className: "dropdown-item",
                                // exportOptions: {
                                //     columns: [1, 2, 3, 4, 5, 6]
                                // },
                            },
                            {
                                extend: "pdf",
                                text: feather.icons["clipboard"].toSvg({
                                    class: "font-small-4 me-50",
                                }) + "Pdf",
                                className: "dropdown-item",
                                // exportOptions: {
                                //     columns: [1, 2, 3, 4, 5, 6]
                                // },
                            },
                            {
                                extend: "copy",
                                text: feather.icons["copy"].toSvg({
                                    class: "font-small-4 me-50",
                                }) + "Copiar",
                                className: "dropdown-item",
                                // exportOptions: {
                                //     columns: [1, 2, 3, 4, 5, 6]
                                // },
                            },
                        ],
                        init: function(api, node, config) {
                            $(node).removeClass("btn-secondary");
                            $(node).parent().removeClass("btn-group");
                            setTimeout(function() {
                                $(node)
                                    .closest(".dt-buttons")
                                    .removeClass("btn-group")
                                    .addClass("d-inline-flex mt-50");
                            }, 50);
                        },
                    },

                ],
                dom: '<"d-flex justify-content-between align-items-center header-actions mx-2 row mt-75"' +
                    '<"col-sm-12 col-lg-4 d-flex justify-content-center justify-content-lg-start" l>' +
                    '<"col-sm-12 col-lg-8 ps-xl-75 ps-0"<"dt-action-buttons d-flex align-items-center justify-content-center justify-content-lg-end flex-lg-nowrap flex-wrap"<"me-1"f>B>>' +
                    ">t" +
                    '<"d-flex justify-content-between mx-2 row mb-1"' +
                    '<"col-sm-12 col-md-6"i>' +
                    '<"col-sm-12 col-md-6"p>' +
                    ">",

            });
        });
    </script>
@endsection
