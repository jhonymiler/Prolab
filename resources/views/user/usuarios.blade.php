@extends('layouts/contentLayoutMaster')

@section('title', 'Cadastro de Usuários')

@section('vendor-style')
    {{-- Page Css files --}}
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
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
        <div class="row">
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <h3 class="fw-bolder mb-75">{{ $totalUsers }}</h3>
                            <span>Total de Usuários</span>
                        </div>
                        <div class="avatar bg-light-primary p-50">
                            <span class="avatar-content">
                                <i data-feather="user" class="font-medium-4"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <h3 class="fw-bolder mb-75">{{ $usersInativos }}</h3>
                            <span>Usuários Inativos</span>
                        </div>
                        <div class="avatar bg-light-danger p-50">
                            <span class="avatar-content">
                                <i data-feather="user-plus" class="font-medium-4"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <h3 class="fw-bolder mb-75">{{ $usersAtivos }}</h3>
                            <span>Usuários Ativos</span>
                        </div>
                        <div class="avatar bg-light-success p-50">
                            <span class="avatar-content">
                                <i data-feather="user-check" class="font-medium-4"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <h3 class="fw-bolder mb-75">{{ $usersPendentes }}</h3>
                            <span>Usuários Pendentes</span>
                        </div>
                        <div class="avatar bg-light-warning p-50">
                            <span class="avatar-content">
                                <i data-feather="user-x" class="font-medium-4"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- list and filter start -->
        <div class="card">
            <div class="card-body border-bottom">
                <h4 class="card-title">Busca & Filtro</h4>
                <div class="row">
                    <div class="col-md-4 user_role"></div>
                    <div class="col-md-4 user_status"></div>
                </div>
            </div>
            <div class="card-datatable table-responsive pt-0">
                <table class="user-list-table table">
                    <thead class="table-light">
                        <tr>
                            <th></th>
                            <th>Nome</th>
                            <th>Celular</th>
                            <th>Nível</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <!-- Modal to add new user starts-->
            <div class="modal modal-slide-in new-user-modal fade" id="modals-slide-in" method="post"
                action="{{ route('user-create') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-dialog">
                    <form class="add-new-user modal-content pt-0" method="post" action="{{ route('user-create') }}">
                        @csrf
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                        <div class="modal-header mb-1">
                            <h5 class="modal-title" id="exampleModalLabel">Adicionar Usuário</h5>
                        </div>
                        <div class="modal-body flex-grow-1">
                            <div class="mb-1">
                                <label class="form-label" for="name">Nome Completo</label>
                                <input type="text" class="form-control dt-full-name" id="name"
                                    placeholder="John Doe" name="name" />
                            </div>
                            <div class="mb-1">
                                <label class="form-label" for="email">Email</label>
                                <input type="email" id="email" class="form-control dt-email"
                                    placeholder="john.doe@example.com" name="email" />
                            </div>
                            <div class="mb-1">
                                <label class="form-label" for="celular">Celular</label>
                                <input type="text" id="celular" data-mask="(00) 0 0000-0000"
                                    class="form-control dt-contact" placeholder="(99) 9 9999-9999" name="celular" />
                            </div>

                            <div class="mb-1">
                                <label class="form-label" for="nivel">Nível de Permissão</label>
                                <select id="nivel" name="nivel" class="select2 form-select" tabindex="-1">
                                    <option value="">Selecione um nível</option>
                                    @if (isset($niveis) && count($niveis) > 0)
                                        @foreach ($niveis as $nivel)
                                            <option
                                                {{ isset($user->id) && $user->nivel->id == $nivel->id ? 'selected' : '' }}
                                                value="{{ $nivel->id }}">
                                                {{ $nivel->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary me-1 data-submit">Enviar</button>
                            <button type="reset" class="btn btn-outline-secondary"
                                data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Modal to add new user Ends-->
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

    <script src="{{ asset(mix('js/scripts/pages/app-user-list.js')) }}"></script>
@endsection
