@extends('layouts/contentLayoutMaster')

@section('title', 'Cadastro de Clientes')

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
                    @can('criar clientes')
                        <div class="dt-buttons d-inline-flex">
                            <button class="dt-button create-new btn btn-primary" tabindex="0" id="new-cliente" type="button"
                                data-bs-toggle="modal" data-bs-target="#cliente"><span><i data-feather='plus'></i> Novo
                                    Cliente</span></button>
                        </div>
                    @endcan

                </div>
            </div>
            <div class="card-datatable table-responsive pt-0">
                <table id="tabela-clientes" class="table .table-striped" style="width:100%">
                    <thead class="table-light">
                        <tr>
                            <th>Nome</th>
                            <th>Contato</th>
                            <th>Endereço</th>
                            <th>Atualização</th>
                            <th>Status</th>
                            @canany(['editar clientes', 'deletar clientes'])
                                <th>Ações</th>
                            @endcanany
                        </tr>
                    </thead>
                    <tbody>
                        @if ($clientes)
                            @foreach ($clientes as $cli)
                                <tr>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="text-truncate fw-bold">{{ $cli->nome_fantasia }}</span>
                                            <small class="text-truncate text-muted">
                                                {{ $cli->razao_social }}</small>
                                            <small class="text-truncate text-muted">CNPJ: {{ $cli->cnpj }}, IE:
                                                {{ $cli->ie }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="text-truncate fw-bold">{{ $cli->email }}</span>
                                            <small class="text-truncate text-muted">Telefone:
                                                {{ $cli->telefone }}</small>
                                            <small class="text-truncate text-muted">Celular:
                                                {{ $cli->celular }}</small>
                                            <small class="text-truncate text-muted">Responsável:
                                                {{ $cli->responsavel }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class=" text-truncate fw-bold">{{ $cli->rua }},
                                                {{ $cli->num }} {{ $cli->complemento }}</span>
                                            <small class=" text-truncate text-muted">{{ $cli->bairro }},
                                                {{ $cli->cidade }}/{{ $cli->uf }}</small>
                                            <small class=" text-truncate text-muted">CEP:
                                                {{ $cli->cep }}</small>
                                        </div>
                                    </td>
                                    <td>{{ $cli->updated_at->format('d/m/Y H:m:i') }}</td>
                                    <td>
                                        @if ($cli->status == 1)
                                            <span class="badge rounded-pill badge-light-success me-1">Ativo</span>
                                        @else
                                            <span class="badge rounded-pill badge-light-danger me-1">Inativo</span>
                                        @endif
                                    </td>
                                    @canany(['editar clientes', 'deletar clientes'])
                                        <td>
                                            <div class="d-flex">
                                                @can('editar clientes')
                                                    <button data-id="{{ $cli->id }}" data-json="{{ json_encode($cli) }}"
                                                        type="button" class="btn btn-icon btn-flat-info editar waves-effect"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        data-bs-original-title="Editar">
                                                        <i data-feather='edit'></i>
                                                    </button>
                                                @endcan
                                                @can('deletar clientes')
                                                    @if ($cli->status == 1)
                                                        <button data-id="{{ $cli->id }}" data-status="{{ $cli->status }}"
                                                            type="button"
                                                            class="btn btn-icon btn-flat-danger ativar_desativar waves-effect"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            data-bs-original-title="Desativar">
                                                            <i data-feather='trash-2'></i>
                                                        </button>
                                                    @else
                                                        <button data-id="{{ $cli->id }}" data-status="{{ $cli->status }}"
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
            @canany(['criar clientes', 'editar clientes'])
                <div class="modal modal-slide-in new-user-modal fade" id="cliente">
                    <div class="modal-dialog">
                        <form id="form-clientes" class="add-new-user modal-content pt-0" method="post"
                            action="{{ route('cliente-save') }}">
                            @csrf
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                            <div class="modal-header mb-1">
                                <h5 class="modal-title" id="exampleModalLabel">Adicionar Usuário</h5>
                            </div>
                            <div class="modal-body flex-grow-1">
                                <div class="row">
                                    <div class="col-md-6 col-12 mb-1 position-relative">
                                        <label class="form-label" for="cnpj">CNPJ</label>
                                        <input type="text" class="form-control" id="cnpj" name="cnpj"
                                            data-mask="99.999.999/9999-99" required="">
                                    </div>
                                    <div class="col-md-6 col-12 mb-1 position-relative">
                                        <label class="form-label" for="ie">IE</label>
                                        <input type="text" class="form-control" id="ie" name="ie"
                                            required="">
                                    </div>
                                </div>
                                <div class="mb-1">
                                    <label class="form-label" for="razao_social">Razão Social</label>
                                    <input type="text" class="form-control dt-full-name" id="razao_social" placeholder=""
                                        name="razao_social" required />
                                </div>
                                <div class="mb-1">
                                    <label class="form-label" for="nome_fantasia">Nome Fantazia</label>
                                    <input type="text" id="nome_fantasia" class="form-control dt-email" placeholder=""
                                        name="nome_fantasia" required />
                                </div>
                                <div class="mb-1">
                                    <label class="form-label" for="email">E-Mail</label>
                                    <input type="email" id="email" class="form-control dt-email" placeholder=""
                                        name="email" required />
                                </div>

                                <div class="row g-1">
                                    <div class="col-md-6 col-12 mb-1 position-relative">
                                        <label class="form-label" for="telefone">Telefone Fixo</label>
                                        <input type="text" class="form-control" id="telefone" name="telefone"
                                            data-mask="(99) 9999-9999" required="">
                                    </div>
                                    <div class="col-md-6 col-12 mb-1 position-relative">
                                        <label class="form-label" for="celular">Celular</label>
                                        <input type="text" class="form-control" id="celular" name="celular"
                                            data-mask="(99) 99999-9999" required="">
                                    </div>
                                </div>
                                <div class="mb-1">
                                    <label class="form-label" for="responsavel">Nome Responsável</label>
                                    <input type="text" id="responsavel" class="form-control dt-email" name="responsavel"
                                        required />
                                </div>

                                <div class="mb-1">
                                    <label class="form-label" for="cep">CEP</label>
                                    <input type="text" id="cep" class="form-control dt-email" data-mask="99999-999"
                                        name="cep" required />
                                </div>
                                <div class="row g-1">
                                    <div class="col-md-9 col-12 mb-1 position-relative">
                                        <label class="form-label" for="rua">Rua</label>
                                        <input type="text" class="form-control" id="rua" name="rua"
                                            required="">
                                    </div>
                                    <div class="col-md-3 col-12 mb-1 position-relative">
                                        <label class="form-label" for="num">Nº</label>
                                        <input type="text" class="form-control" id="num" name="num"
                                            required="">
                                    </div>
                                </div>
                                <div class="row g-1">
                                    <div class="col-md-6 col-12 mb-1 position-relative">
                                        <label class="form-label" for="complemento">Complemento</label>
                                        <input type="text" class="form-control" id="complemento" name="complemento">
                                    </div>
                                    <div class="col-md-6 col-12 mb-1 position-relative">
                                        <label class="form-label" for="bairro">Bairro</label>
                                        <input type="text" class="form-control" id="bairro" name="bairro"
                                            required="">
                                    </div>
                                </div>

                                <div class="row g-1">
                                    <div class="col-md-9 col-12 mb-1 position-relative">
                                        <label class="form-label" for="cidade">Cidade</label>
                                        <input type="text" class="form-control" id="cidade" name="cidade"
                                            required="">
                                    </div>
                                    <div class="col-md-3 col-12 mb-1 position-relative">
                                        <label class="form-label" for="uf">UF</label>
                                        <select class="form-select" id="uf" name="uf">
                                            <option id="AC" value="AC">AC</option>
                                            <option id="AL" value="AL">AL</option>
                                            <option id="AP" value="AP">AP</option>
                                            <option id="AM" value="AM">AM</option>
                                            <option id="BA" value="BA">BA</option>
                                            <option id="CE" value="CE">CE</option>
                                            <option id="DF" value="DF">DF</option>
                                            <option id="ES" value="ES">ES</option>
                                            <option id="GO" value="GO">GO</option>
                                            <option id="MA" value="MA">MA</option>
                                            <option id="MT" value="MT">MT</option>
                                            <option id="MS" value="MS">MS</option>
                                            <option id="MG" value="MG">MG</option>
                                            <option id="PA" value="PA">PA</option>
                                            <option id="PB" value="PB">PB</option>
                                            <option id="PR" value="PR">PR</option>
                                            <option id="PE" value="PE">PE</option>
                                            <option id="PI" value="PI">PI</option>
                                            <option id="RJ" value="RJ">RJ</option>
                                            <option id="RN" value="RN">RN</option>
                                            <option id="RS" value="RS">RS</option>
                                            <option id="RO" value="RO">RO</option>
                                            <option id="RR" value="RR">RR</option>
                                            <option id="SC" value="SC">SC</option>
                                            <option id="SP" value="SP">SP</option>
                                            <option id="SE" value="SE">SE</option>
                                            <option id="TO" value="TO">TO</option>
                                            <option id="EX" value="EX">EX</option>
                                        </select>
                                    </div>
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
    <script src="{{ asset(mix('vendors/js/jquery-mask/jquery.maskMoney.min.js')) }}"></script>
    <script src="http://cdn.datatables.net/plug-ins/1.13.1/sorting/currency.js"></script>

    <script>
        $(document).ready(function() {
            var form = $("#form-clientes");

            $("#cnpj").on('blur', function() {
                var cnpj = $(this).val();
                cnpj = cnpj.replace(/[^0-9]/gm, "");
                $.getJSON("https://publica.cnpj.ws/cnpj/" + cnpj, function(data) {
                    $("#ie").val(data.estabelecimento.inscricoes_estaduais[0].inscricao_estadual)
                    $("#razao_social").val(data.razao_social)
                    $("#nome_fantasia").val(data.estabelecimento.nome_fantasia)
                    $("#email").val(data.estabelecimento.email)
                    $("#telefone").mask(
                            '(99) 9999-9999').val(
                            `${data.estabelecimento.ddd1}${data.estabelecimento.telefone1}`)
                        .trigger('input')
                    $("#rua").val(
                        `${data.estabelecimento.tipo_logradouro} ${data.estabelecimento.logradouro}`
                    )
                    $("#complemento").val(data.estabelecimento.complemento)
                    $("#num").val(data.estabelecimento.numero)
                    $("#bairro").val(data.estabelecimento.bairro)
                    $("#cidade").val(data.estabelecimento.cidade.nome)
                    $("#cep").mask('99999-999').val(data.estabelecimento.cep).trigger('input')
                    $("#uf option:contains(" + data.estabelecimento.estado.sigla + ")").attr(
                        'selected', true);
                    if (data.socios.length) {
                        $("#responsavel").val(data.socios[0].nome)
                    }

                });
            })

            $("#new-cliente").click(function() {
                form.attr('action', "{{ route('cliente-save') }}").reset()
            });

            $(".editar").click(function() {
                json = $(this).data('json')
                form.attr('action', '/clientes/save/' + json.id)
                for (var v in json) {
                    $("[name='" + v + "']").val(json[v])
                }
                $("#cliente").modal('show')
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
                        window.location.href = '/clientes/ativa_desativa/' + id;
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


            // Form Validation
            if (form.length) {
                form.validate({
                    errorClass: "error",
                    rules: {
                        cargo: {
                            required: true,
                        },
                        valor_mercado: {
                            required: true,
                        }
                    },
                });


            }

            $('#tabela-clientes').DataTable({
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.1/i18n/pt-BR.json",
                },
                columnDefs: [{
                    type: 'date',
                    targets: [3]
                }, {
                    width: "10%",
                    targets: 0
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
                            },
                            {
                                extend: "csv",
                                text: feather.icons["file-text"].toSvg({
                                    class: "font-small-4 me-50",
                                }) + "Csv",
                                className: "dropdown-item",
                            },
                            {
                                extend: "excel",
                                text: feather.icons["file"].toSvg({
                                    class: "font-small-4 me-50",
                                }) + "Excel",
                                className: "dropdown-item",
                            },
                            {
                                extend: "pdf",
                                text: feather.icons["clipboard"].toSvg({
                                    class: "font-small-4 me-50",
                                }) + "Pdf",
                                className: "dropdown-item",
                            },
                            {
                                extend: "copy",
                                text: feather.icons["copy"].toSvg({
                                    class: "font-small-4 me-50",
                                }) + "Copiar",
                                className: "dropdown-item",
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
