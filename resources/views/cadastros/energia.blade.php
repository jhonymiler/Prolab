@extends('layouts/contentLayoutMaster')

@section('title', 'Controle de Energia')

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
        <div class="row">
            <div class="col-lg-4 col-sm-6">
                <div class="col-lg-12 col-md-6 col-12">
                    <div class="card earnings-card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-7">
                                    <h4 class="card-title mb-1">Última Média</h4>
                                    <div class="font-small-2">Últimos 6 Meses</div>
                                    <h5><span style="font-size: 2.07rem;">{{ Helper::Money($media) }}</span> kW/Hr
                                    </h5>
                                    @if ($diff_media['queda'])
                                        <p class="card-text text-muted ">
                                            <span class="badge badge-light-success">
                                                <span class="fw-bolder"
                                                    style="font-size: 2.9rem;">{{ $diff_media['perc'] }}</span>&ensp;
                                                <i data-feather="trending-down" class="font-medium-3"></i>
                                            </span>
                                        </p>
                                    @else
                                        <p
                                            class="card-text
                                                    text-muted ">
                                            <span class="badge badge-light-danger">
                                                <span class="fw-bolder"
                                                    style="font-size: 2.9rem;">{{ $diff_media['perc'] }}</span>&ensp;
                                                <i data-feather="trending-up" class="font-medium-3"></i>
                                            </span>
                                        </p>
                                    @endif
                                </div>
                                <div class="col-5">
                                    <div id="statistics-profit-chart"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-sm-6">
                <div class="card">
                    <div class="card-body d-flex align-items-center justify-content-between">

                        <canvas id="grafico_valores_kw"></canvas>
                    </div>
                </div>
            </div>

        </div>
        <!-- list and filter start -->
        <div class="card">
            <div class="card-header border-bottom p-1">
                <div class="head-label">
                </div>
                <div class="dt-action-buttons text-end">
                    @can('criar energia')
                        <div class="dt-buttons d-inline-flex">
                            <button class="dt-button create-new btn btn-primary" tabindex="0" id="new-energia" type="button"
                                data-bs-toggle="modal" data-bs-target="#energia"><span><i data-feather='plus'></i> Novo
                                    Lançamento</span></button>
                        </div>
                    @endcan

                </div>
            </div>
            <div class="card-datatable table-responsive pt-0">
                <table id="tabela-dados" class="table" style="width:100%">
                    <thead class="table-light">
                        <tr>
                            <th>Data</th>
                            <th>Consumo KW</th>
                            <th>Valor Pago</th>
                            <th>R$ / KW</th>
                            @canany(['editar energia', 'deletar energia'])
                                <th>Ações</th>
                            @endcanany
                        </tr>
                    </thead>
                    <tbody>
                        @if ($lancamentos)
                            @php
                                $valor_kw_Anterior = 0;
                                $valor_consumo_Anterior = 0;
                            @endphp
                            @foreach ($lancamentos as $energia)
                                <tr>
                                    <td>{{ $energia->data->format('m/Y') }}</td>

                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="fw-bolder me-1">
                                                {{ $energia->consumo }} KW
                                            </span>
                                            @if ($valor_consumo_Anterior > $energia->consumo)
                                                <i data-feather="trending-down" class="text-success font-medium-1"></i>
                                            @else
                                                <i data-feather="trending-up" class="text-danger font-medium-1"></i>
                                            @endif
                                        </div>
                                    </td>

                                    <td>{{ Helper::Money($energia->valor) }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="fw-bolder me-1">
                                                {{ Helper::Money($energia->valor_kw) }}
                                            </span>
                                            @if ($valor_kw_Anterior > $energia->valor_kw)
                                                <i data-feather="trending-down" class="text-success font-medium-1"></i>
                                            @else
                                                <i data-feather="trending-up" class="text-danger font-medium-1"></i>
                                            @endif
                                        </div>
                                    </td>

                                    @canany(['editar energia', 'deletar energia'])
                                        <td>
                                            <div class="d-flex">
                                                @can('editar energia')
                                                    <button data-id="{{ $energia->id }}" data-consumo="{{ $energia->consumo }}"
                                                        data-valor="{{ $energia->valor }}"
                                                        data-lanc="{{ $energia->data->format('m/Y') }}" type="button"
                                                        class="btn btn-icon btn-flat-info editar waves-effect"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        data-bs-original-title="Editar">
                                                        <i data-feather='edit'></i>
                                                    </button>
                                                @endcan

                                            </div>
                                        </td>
                                    @endcanany
                                </tr>
                                @php
                                    $valor_kw_Anterior = $energia->valor_kw;
                                    $valor_consumo_Anterior = $energia->consumo;

                                @endphp
                            @endforeach

                        @endif

                    </tbody>

                </table>
            </div>
            <!-- Modal to add new user starts-->
            @canany(['criar energia', 'editar energia'])
                <!-- Modal -->
                <div class="modal fade" id="energia" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalCenterTitle">Lançamentos</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form id="form-energia" class="add-new-user modal-content pt-0" method="post"
                                action="{{ route('energia-save') }}">
                                @csrf

                                <div class="modal-body flex-grow-1">

                                    <div class="mb-1">
                                        <label class="form-label" for="consumo">Consumo (kW)</label>
                                        <input type="numeric" class="form-control dt-full-name" id="consumo"
                                            placeholder="" name="consumo" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="form-label" for="valor">Valor R$</label>
                                        <input type="text" class="form-control dt-full-name" id="valor"
                                            placeholder="" name="valor" />
                                    </div>
                                    <div class="mb-1">
                                        <label class="form-label" for="data">Data</label>
                                        <input type="text" data-mask="99/9999" class="form-control dt-full-name"
                                            id="data" placeholder="MM/AAAA" name="data" />
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
    <script src="{{ asset(mix('vendors/js/charts/apexcharts.min.js')) }}"></script>

@endsection

@section('page-script')
    {{-- Page js files --}}
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/jquery-mask/jquery.maskMoney.min.js')) }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="http://cdn.datatables.net/plug-ins/1.13.1/sorting/currency.js"></script>

    <script>
        $(document).ready(function() {
            $("#valor").maskMoney({
                prefix: 'R$ ',
                allowNegative: true,
                thousands: '.',
                decimal: ',',
                affixesStay: false
            });

            var form = $("#form-energia");
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


            $("#new-energia").click(function() {
                form.attr('action', "{{ route('energia-save') }}").reset()
            });

            $(".editar").click(function() {
                id = $(this).data('id')
                consumo = $(this).data('consumo')
                valor = $(this).data('valor')
                data = $(this).data('lanc')

                form.attr('action', '/custo-energia/save/' + id)
                $("#consumo").val(consumo)
                $("#valor").val(valor)
                $("#data").val(data)

                $("#energia").modal('show')
            });



            $('#tabela-dados').DataTable({
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.1/i18n/pt-BR.json",
                },

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



            const ctx = document.getElementById('grafico_valores_kw');

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: {!! $graficoCompleto['mes'] !!},
                    datasets: [{
                        data: {!! $graficoCompleto['dados'] !!},
                        borderWidth: 1
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    plugins: {
                        legend: false // Hide legend
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });


            var $trackBgColor = '#EBEBEB';

            var $statisticsProfitChart = document.querySelector('#statistics-profit-chart');
            var statisticsProfitChartOptions;
            //------------ Statistics Line Chart ------------
            //-----------------------------------------------
            statisticsProfitChartOptions = {
                chart: {
                    height: 135,
                    type: 'line',
                    toolbar: {
                        show: false
                    },
                    zoom: {
                        enabled: false
                    }
                },
                grid: {
                    borderColor: $trackBgColor,
                    strokeDashArray: 5,
                    xaxis: {
                        lines: {
                            show: false
                        }
                    },
                    yaxis: {
                        lines: {
                            show: false
                        }
                    },
                    padding: {
                        top: -30,
                        bottom: -10
                    }
                },
                stroke: {
                    width: 3
                },
                colors: [window.colors.solid.info],
                series: [{
                    name: "Media KW",
                    data: {!! $graficoDados !!}
                }],
                markers: {
                    size: 2,
                    colors: window.colors.solid.info,
                    strokeColors: window.colors.solid.info,
                    strokeWidth: 2,
                    strokeOpacity: 1,
                    strokeDashArray: 0,
                    fillOpacity: 1,
                    discrete: [{
                        seriesIndex: 0,
                        dataPointIndex: 5,
                        fillColor: '#ffffff',
                        strokeColor: window.colors.solid.info,
                        size: 5
                    }],
                    shape: 'circle',
                    radius: 2,
                    hover: {
                        size: 3
                    }
                },
                xaxis: {
                    categories: {!! $graficoMes !!},
                    labels: {
                        show: true,
                        style: {
                            fontSize: '0px'
                        }
                    },
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    }
                },
                yaxis: {
                    show: false
                },
                tooltip: {
                    x: {
                        show: false
                    }
                }
            };
            statisticsProfitChart = new ApexCharts($statisticsProfitChart, statisticsProfitChartOptions);
            statisticsProfitChart.render();
        });
    </script>
@endsection
