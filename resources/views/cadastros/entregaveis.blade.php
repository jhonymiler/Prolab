@extends('layouts/contentLayoutMaster')

@section('title', 'Entregaveis')

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
                    @can('criar entregaveis')
                        <div class="dt-buttons d-inline-flex">
                            <button class="dt-button create-new btn btn-primary" tabindex="0" id="new-entregaveis"
                                type="button" data-bs-toggle="modal" data-bs-target="#entregaveis"><span><i
                                        data-feather='plus'></i> Novo
                                    Entregavel</span></button>
                        </div>
                    @endcan

                </div>
            </div>
            <div class="card-datatable table-responsive pt-0">
                <table id="tabela-dados" class="table" style="width:100%">
                    <thead class="table-light">
                        <tr>
                            <th>Nome</th>
                            <th>Und.</th>
                            <th>R$ Valor</th>
                            <th>Data Atualização</th>
                            <th>Status</th>
                            <th>Observação</th>
                            @canany(['editar entregaveis', 'deletar entregaveis'])
                                <th>Ações</th>
                            @endcanany
                        </tr>
                    </thead>
                    <tbody>
                        @if ($entregaveis)
                            @foreach ($entregaveis as $m)
                                <tr>
                                    <td>{{ $m->descricao }}</td>
                                    <td>{{ $m->medida->sigla }}</td>
                                    <td> {{ Helper::Money($m->valor) }}</td>
                                    <td>{{ $m->updated_at->format('d/m/Y') }}</td>
                                    <td>
                                        @if ($m->status == 1)
                                            <span class="badge rounded-pill badge-light-success me-1">Ativo</span>
                                        @else
                                            <span class="badge rounded-pill badge-light-danger me-1">Inativo</span>
                                        @endif
                                    </td>
                                    <td>{{ $m->observacao }}</td>
                                    @canany(['editar entregaveis', 'deletar entregaveis'])
                                        <td>
                                            <div class="d-flex">
                                                @can('editar entregaveis')
                                                    <button data-id="{{ $m->id }}" data-json="{{ json_encode($m) }}"
                                                        type="button" class="btn btn-icon btn-flat-info editar waves-effect"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        data-bs-original-title="Editar">
                                                        <i data-feather='edit'></i>
                                                    </button>
                                                @endcan
                                                @can('deletar entregaveis')
                                                    @if ($m->status == 1)
                                                        <button data-id="{{ $m->id }}" data-status="{{ $m->status }}"
                                                            type="button"
                                                            class="btn btn-icon btn-flat-danger ativar_desativar waves-effect"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            data-bs-original-title="Desativar">
                                                            <i data-feather='trash-2'></i>
                                                        </button>
                                                    @else
                                                        <button data-id="{{ $m->id }}" data-status="{{ $m->status }}"
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
            @canany(['criar entregaveis', 'editar entregaveis'])
                <div class="modal fade" id="entregaveis" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Adicionar Entregavel</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form id="form-entregaveis" class="add-new-user modal-content pt-0" method="post"
                                action="{{ route('entregavel-save') }}">
                                @csrf

                                <div class="modal-body flex-grow-1">
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <div class="mb-1">
                                                <label class="form-label" for="nome">Nome do Entregavel</label>
                                                <input type="text" class="form-control dt-full-name" id="descricao"
                                                    placeholder="" name="descricao" />
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-3">
                                            <div class="mb-1">
                                                <div class="col-md-12 col-12 mb-1 position-relative">
                                                    <label class="form-label" for="medida_id">Unidade de Medida</label>
                                                    <select class="form-select" id="medida_id" name="medida_id">
                                                        <option>Selecione uma Unidade</option>

                                                        @if ($unidades)
                                                            @foreach ($unidades as $unid)
                                                                <option id="{{ $unid->sigla }}" value="{{ $unid->id }}">
                                                                    ({{ $unid->sigla }})
                                                                    - {{ $unid->nome }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <div class="mb-1">
                                                <label class="form-label" for="fabricante">Valor R$</label>
                                                <input type="text" class="form-control dt-full-name dinheiro"
                                                    id="valor" placeholder="" name="valor" />
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="nome">Observação</label>
                                                <textarea  class="form-control" id="observacao" rows="2" 
                                                    placeholder="" name="observacao" > </textarea>

                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary me-1">Enviar</button>
                                            <button type="reset" class="btn btn-outline-secondary"
                                                data-bs-dismiss="modal">Cancelar</button>
                                        </div>
                                    </div>



                                </div>
                            </form>
                        </div>
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
    <script src="{{ asset(mix('vendors/js/jquery-mask/jquery.maskMoney.min.js')) }}"></script>

    <script>
        function numberToReal(num, sigla = true) {
            var numero = num.toFixed(2);
            numero = numero.split('.');
            numero[0] = numero[0].split(/(?=(?:...)*$)/).join('.');
            valor = numero.join(',');
            return sigla ? 'R$ ' + valor : valor;
        }

        $(document).ready(function() {

            var form = $("#form-entregaveis");
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

            $(".dinheiro").maskMoney({
                prefix: 'R$ ',
                allowNegative: true,
                thousands: '.',
                decimal: ',',
                affixesStay: false
            });


            $("#new-entregaveis").click(function() {
                form.attr('action', "{{ route('entregavel-save') }}").reset()
            });

            $(".editar").click(function() {
                json = $(this).data('json')
                form.attr('action', '/entregavel/save/' + json.id)
                for (var v in json) {
                    if (v == 'valor') {
                        $("[name='" + v + "']").val(numberToReal(Number(json[v])))
                    } else {
                        $("[name='" + v + "']").val(json[v])
                    }
                }
                $("#entregaveis").modal('show')
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
                        window.location.href = '/entregavel/ativa_desativa/' + id;
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
