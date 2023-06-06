@extends('layouts/contentLayoutMaster')

@section('title', 'Controle de Ativos')

@section('vendor-style')
    {{-- Page Css files --}}
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/rowGroup.bootstrap5.min.css')) }}">
    <link rel='stylesheet' href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
    <link rel='stylesheet' href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/charts/apexcharts.css')) }}">


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
                    @can('criar ativos')
                        <div class="dt-buttons d-inline-flex">
                            <button class="dt-button create-new novo btn btn-primary" tabindex="0" id="new-ativos"
                                type="button"><span><i data-feather='plus'></i> Novo
                                    Ativo</span></button>
                        </div>
                    @endcan

                </div>
            </div>
            <div class="card-datatable table-responsive pt-0">
                <table id="tabela-dados" class="table">
                    <thead class="table-light">
                        <tr>
                            <th>Equipamento</th>
                            <th>Modelo</th>

                            <th>Fabricante</th>
                            <th>R$ Total / Hr Uso</th>
                            <th>Ano Aquisição</th>
                            <th>Valor Unit.</th>
                            <th>Valor R$</th>
                            <th>Vida Útil</th>
                            <th>Potência (W)</th>
                            <th>Hrs / Dia Funcionamento</th>
                            <th>Qtd. Dias Ligado</th>
                            <th>Valor Energia Mês</th>
                            <th>Valor Energia Hora</th>
                            <th>Custo Manutenção</th>
                            <th>Custo Peças Reposição</th>
                            <th>Aferição?</th>
                            <th>% Depreciação / Ano</th>
                            <th>R$ Depreciação / Mês</th>
                            <th>R$ Depreciação / Hr</th>
                            <th>Status</th>
                            @canany(['editar ativos', 'deletar ativos'])
                                <th>Ações</th>
                            @endcanany
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ativos as $ativo)
                            <tr>
                                <td>{{ $ativo->equipamento }}</td>
                                <td>{{ $ativo->modelo }}</td>
                                <td>{{ $ativo->fabricante }}</td>
                                <td>{{ Helper::Money($ativo->total) }}</td>
                                <td>{{ $ativo->ano }}</td>
                                <td>
                                    {{ Helper::Money($ativo->valor > 0 ? $ativo->valor : 0, $ativo->moeda) }}
                                </td>
                                <td>{{ Helper::Money($ativo->valor_convertido > 0 ? $ativo->valor_convertido : 0) }}
                                </td>
                                <td>{{ $ativo->vida_util }}</td>
                                <td>{{ $ativo->potencia }}</td>
                                <td>{{ $ativo->horas }}</td>
                                <td>{{ $ativo->dias }}</td>
                                <td>{{ Helper::Money($ativo->energia_mes) }}</td>
                                <td>{{ Helper::Money($ativo->energia_hora) }}</td>
                                <td>{{ $ativo->custo_manutencao }}</td>
                                <td>{{ $ativo->custo_pecas }}</td>
                                <td>{{ $ativo->afericao == 1 ? 'Sim' : 'Não' }}</td>
                                <td>{{ $ativo->depreciacao }}</td>
                                <td>{{ Helper::Money($ativo->depreciacao_mes) }}</td>
                                <td>{{ Helper::Money($ativo->depreciacao_hora) }}</td>
                                <td>
                                    @if ($ativo->status == 1)
                                        <span class="badge rounded-pill badge-light-success me-1">Ativo</span>
                                    @else
                                        <span class="badge rounded-pill badge-light-danger me-1">Inativo</span>
                                    @endif
                                </td>
                                @canany(['editar ativos', 'deletar ativos'])
                                    <td>
                                        @can('editar ativos')
                                            <button data-id="{{ $ativo->id }}" data-json="{{ json_encode($ativo) }}"
                                                type="button" class="btn btn-icon btn-flat-info editar waves-effect"
                                                data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Editar">
                                                <i data-feather='edit'></i>
                                            </button>
                                        @endcan
                                        @can('deletar ativos')
                                            @if ($ativo->status == 1)
                                                <button data-id="{{ $ativo->id }}" data-status="{{ $ativo->status }}"
                                                    type="button"
                                                    class="btn btn-icon btn-flat-danger ativar_desativar waves-effect"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    data-bs-original-title="Desativar">
                                                    <i data-feather='trash-2'></i>
                                                </button>
                                            @else
                                                <button data-id="{{ $ativo->id }}" data-status="{{ $ativo->status }}"
                                                    type="button"
                                                    class="btn btn-icon btn-flat-success ativar_desativar waves-effect"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    data-bs-original-title="Ativar">
                                                    <i data-feather='check'></i>
                                                </button>
                                            @endif
                                        @endcan
                                    </td>
                                @endcanany
                            </tr>
                        @endforeach

                    </tbody>

                </table>
            </div>
            <!-- Modal to add new user starts-->
            @canany(['criar ativos', 'editar ativos'])
                <!-- Modal -->
                <div class="modal fade" id="ativos" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalCenterTitle">Ativos</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form id="form-ativos" class="add-new-user modal-content pt-0" method="post"
                                action="{{ route('ativos-save') }}">
                                @csrf

                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <div class="mb-1">
                                                <label class="form-label" for="equipamento">Equipamento</label>
                                                <input type="text" class="form-control dt-full-name" id="equipamento"
                                                    placeholder="" name="equipamento" />
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-3">
                                            <div class="mb-1">
                                                <label class="form-label" for="modelo">Modelo</label>
                                                <input type="text" class="form-control dt-full-name" id="modelo"
                                                    placeholder="" name="modelo" />
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <div class="mb-1">
                                                <label class="form-label" for="fabricante">Fabricante </label>
                                                <input type="text" class="form-control dt-full-name" id="fabricante"
                                                    placeholder="" name="fabricante" />
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-3">
                                            <div class="mb-1">
                                                <label class="form-label" for="valor">Custo de Aquisição</label>

                                                <div class="input-group">
                                                    <button type="button" id="botao_sigla"
                                                        class="btn btn-outline-primary dropdown-toggle px-1"
                                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        R$
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item conversao" data-rate="BRL" data-sigla="R$"
                                                            href="#">R$</a>
                                                        <a class="dropdown-item conversao" data-rate="USD" data-sigla="$"
                                                            href="#">$</a>
                                                        <a class="dropdown-item conversao" data-rate="EUR" data-sigla="€"
                                                            href="#">€</a>
                                                    </div>
                                                    <input type="hidden" id="moeda" name="moeda" placeholder=""
                                                        value="BRL" />
                                                    <input type="hidden" id="sigla" name="sigla" placeholder=""
                                                        value="R$" />

                                                    <input type="numeric" class="form-control dt-full-name dinheiro"
                                                        id="valor" placeholder="" name="valor" />
                                                </div>

                                            </div>


                                        </div>


                                        <div class="col-12 col-md-3">
                                            <div class="mb-1">
                                                <label class="form-label" for="valor_convertido_view">Valor Convertido</label>
                                                <input type="text" class="form-control dt-full-name"
                                                    id="valor_convertido_view" disabled placeholder=""
                                                    name="valor_convertido" />

                                                <input type="hidden" class="form-control valor_convertido dt-full-name"
                                                    id="valor_convertido" placeholder="" name="valor_convertido" />

                                            </div>
                                        </div>

                                        <div class="col-12 col-md-3">
                                            <div class="mb-1">
                                                <label class="form-label" for="potencia">Potência (W)</label>
                                                <input type="integer" class="form-control dt-full-name" id="potencia"
                                                    placeholder="" name="potencia" />
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <div class="mb-1" data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Custo de serviço de manutenção (inspeções periodicas) / ano">
                                                <label class="form-label" for="custo_manutencao">Custo Manutenção</label>
                                                <input type="numeric" class="form-control dt-full-name" id="custo_manutencao"
                                                    placeholder="" name="custo_manutencao" />
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">

                                        <div class="col-12 col-md-3">
                                            <div class="mb-1" data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Hrs / dia em funcionamento">
                                                <label class="form-label" for="horas">Horas

                                                </label>

                                                <input type="numeric" class="form-control dt-full-name" id="horas"
                                                    placeholder="" name="horas" />
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-3">
                                            <div class="mb-1" data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="nº de dias Ligado">
                                                <label class="form-label" for="dias">Dias</label>
                                                <input type="numeric" class="form-control dt-full-name" id="dias"
                                                    placeholder="" name="dias" />
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-3">
                                            <div class="mb-1" data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Custo de peças de reposição / Ano">
                                                <label class="form-label" for="custo_pecas">Custo Peças Reposição

                                                </label>

                                                <input type="numeric" class="form-control dt-full-name" id="custo_pecas"
                                                    placeholder="" name="custo_pecas" />
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-3">
                                            <div class="mb-1" data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="% Depreciação por Ano">
                                                <label class="form-label" for="depreciacao">% Depreciação</label>
                                                <input type="numeric" class="form-control dt-full-name" id="depreciacao"
                                                    placeholder="" name="depreciacao" />
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">

                                        <div class="col-12 col-md-3">
                                            <div class="mb-1">
                                                <label class="form-label" for="ano">Ano Aquisição </label>
                                                <input type="text" data-mask="9999" class="form-control dt-full-name"
                                                    id="ano" placeholder="" name="ano" />
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-3">
                                            <div class="mb-1">
                                                <label class="form-label" for="vida_util">Vida útil (Anos)</label>
                                                <input type="numeric" class="form-control dt-full-name" id="vida_util"
                                                    placeholder="" name="vida_util" />
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-3">
                                            <div class="mb-1">
                                                <label class="form-label" for="afericao">Necessita Aferição?</label>
                                                <div class="demo-inline-spacing">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="afericao"
                                                            id="afericao-sim" value="1" />
                                                        <label class="form-check-label" for="afericao-sim">Sim</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="afericao"
                                                            id="afericao-nao" value="0" checked />
                                                        <label class="form-check-label" for="afericao-nao">Não</label>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary me-1">Enviar</button>
                                    <button type="reset" class="btn btn-outline-secondary"
                                        data-bs-dismiss="modal">Cancelar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Vertical modal end-->
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
        var myHeaders = new Headers();
        myHeaders.append("apikey", "etB9Z9yJujUozu0Lnf5IQy7tCA3G3lgH");

        var requestOptions = {
            method: 'GET',
            redirect: 'follow',
            headers: myHeaders
        };

        var Rate = 1

        function reverseFormatNumber(val, locale) {
            var group = new Intl.NumberFormat(locale).format(1111).replace(/1/g, '');
            var decimal = new Intl.NumberFormat(locale).format(1.1).replace(/1/g, '');
            var reversedVal = val.replace(new RegExp('\\' + group, 'g'), '');
            reversedVal = reversedVal.replace(new RegExp('\\' + decimal, 'g'), '.');
            return Number.isNaN(reversedVal) ? 0 : reversedVal;
        }

        function numberToReal(num, sigla = true) {
            var numero = num.toFixed(2);
            numero = numero.split('.');
            numero[0] = numero[0].split(/(?=(?:...)*$)/).join('.');
            valor = numero.join(',');
            return sigla ? 'R$ ' + valor : valor;
        }


        $(document).ready(function() {

            $(".dinheiro").maskMoney({
                allowNegative: true,
                thousands: '.',
                decimal: ',',
                affixesStay: false
            });


            $('.decimal').mask("####0.00", {
                reverse: true
            });

            $(".conversao").on('click', function() {

                val = $(this).data('rate')
                var moeda = $(this).data('rate')
                var sigla = $(this).data('sigla')
                $("#botao_sigla").text(sigla)
                $(".valor_convertido,#valor_convertido_view").val('...')

                fetch("https://api.apilayer.com/exchangerates_data/convert?to=BRL&from=" + val +
                        "&amount=1",
                        requestOptions)
                    .then(response => response.text())
                    .then((result) => {
                        json = JSON.parse(result)
                        Rate = json.info.rate;
                        valor = reverseFormatNumber($("#valor").val());
                        valor_convertido = (valor * json.info.rate).toFixed(2)

                        reais = numberToReal(Number(valor_convertido));

                        $("#valor_convertido_view").val(reais)

                        $(".valor_convertido").val(valor_convertido)
                        $("#moeda").val(moeda)
                        $("#sigla").val(sigla)

                    })
                    .catch(error => console.log('error', error));

            });

            $("#valor").on('keyup', function() {
                valor = reverseFormatNumber($(this).val())
                valor_convertido = (valor * Rate).toFixed(2)
                reais = numberToReal(Number(valor_convertido));

                $("#valor_convertido_view").val(reais)
                $(".valor_convertido").val(valor_convertido)
            })


            var form = $("#form-ativos");

            $(".novo").click(function() {
                form.attr('action', '/ativos/save/')
                form.trigger("reset");
                $("#ativos").modal('show')
            });

            $(".editar").click(function() {
                json = $(this).data('json')
                form.attr('action', '/ativos/save/' + json.id)
                for (var v in json) {
                    if (v == 'moeda') {
                        $("a[data-rate]").removeClass('active')
                        $("a[data-rate='" + json[v] + "']").addClass('active')
                        $("#botao_sigla").text($("a[data-rate='" + json[v] + "']").data('sigla'))

                    } else if (v == 'valor') {
                        $("#valor").val(numberToReal(Number(json[v]), false));

                    } else if (v == 'valor_convertido') {
                        $("#valor_convertido_view").val(numberToReal(Number(json[v])));
                        $(".valor_convertido").val(json[v]);

                    } else {
                        $("[name='" + v + "']").val(json[v])
                    }




                }

                $("#ativos").modal('show')
            });

            // Form Validation
            if (form.length) {
                form.validate({
                    errorClass: "error",
                    rules: {
                        equipamento: {
                            required: true,
                        },
                        valor: {
                            required: (e) => {
                                p = $("#potencia").val()
                                return p == "" || p == 0;
                            }
                        },
                        potencia: {
                            required: (e) => {
                                v = $("#valor").val()
                                return v == "" || v == 0;
                            }
                        },
                        vida_util: {
                            required: (e) => {
                                return $("#valor").val() > 0;
                            }
                        }
                    },
                    messages: {
                        valor: 'Campo valor é obrigatório se o campo Potência estiver vazio.',
                        potencia: 'Campo valor é obrigatório se o campo Valor estiver vazio.'
                    }
                });


            }


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
                        window.location.href = '/ativos/ativa_desativa/' + id;
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


            $('#tabela-dados').removeAttr('width').DataTable({
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.1/i18n/pt-BR.json",
                },

                responsive: true,
                columnDefs: [{
                        width: 400,
                        responsivePriority: 1,
                        targets: 0
                    },
                    {
                        responsivePriority: 2,
                        targets: -1
                    },
                    {
                        className: 'none',
                        targets: 1
                    },
                    {
                        className: 'none',
                        targets: 2
                    },
                    {
                        responsivePriority: 3,
                        targets: 3
                    },
                    {
                        className: 'none',
                        responsivePriority: 3,
                        targets: 4
                    },
                    {
                        responsivePriority: 4,
                        targets: 5
                    },
                    {
                        responsivePriority: 5,
                        targets: 6
                    },
                    {
                        className: 'none',
                        targets: 7
                    },
                    {
                        className: 'none',
                        responsivePriority: 6,
                        targets: 8
                    },
                    {
                        className: 'none',
                        targets: 9
                    }, {
                        className: 'none',
                        targets: 10
                    },
                    {
                        className: 'none',
                        responsivePriority: 7,
                        targets: 11
                    },
                    {
                        className: 'none',
                        responsivePriority: 8,
                        targets: 12
                    },
                    {
                        className: 'none',
                        targets: 13
                    }, {
                        className: 'none',
                        targets: 14
                    }, {
                        className: 'none',
                        targets: 15
                    }, {
                        className: 'none',
                        targets: 16
                    },
                    {
                        className: 'none',
                        responsivePriority: 9,
                        targets: 17
                    },
                    {
                        className: 'none',
                        responsivePriority: 10,
                        targets: 18
                    },

                ],
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
                    '<"col-md-12 col-lg-4 d-flex justify-content-center justify-content-lg-start" l>' +
                    '<"col-md-12 col-lg-8 ps-xl-75 ps-0"<"dt-action-buttons d-flex align-items-center justify-content-center justify-content-lg-end flex-lg-nowrap flex-wrap"<"me-1"f>B>>' +
                    ">t" +
                    '<"d-flex justify-content-between mx-2 row mb-1"' +
                    '<"col-sm-12 col-md-6"i>' +
                    '<"col-sm-12 col-md-6"p>' +
                    ">",

            });


        });
    </script>
@endsection
