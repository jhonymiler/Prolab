@extends('layouts/contentLayoutMaster')

@section('title', 'Níveis')

@section('vendor-style')
    <!-- Vendor css files -->
@endsection
@section('page-style')
    <!-- Page css files -->
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
@endsection

@section('content')
    <p class="mb-2">
        Um nível fornece acesso a menus e recursos predefinidos para que, dependendo<br>
        do nível atribuído, um administrador possa ter acesso ao que ele precisa
    </p>

    <!-- Role cards -->
    <div class="row">
        @foreach ($niveis as $nivel)
            <div class="col-xl-4 col-lg-6 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <span>Total {{ count($nivel->users) }} Usuário(s)</span>
                            <ul class="list-unstyled d-flex align-items-center avatar-group mb-0">
                                @foreach ($nivel->users as $user)
                                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                        title="{{ $user->name }}" class="avatar avatar-sm pull-up">
                                        <img class="rounded-circle" src="{{ asset('avatar/' . $user->avatar) }}"
                                            alt="Avatar" />
                                    </li>
                                @endforeach


                            </ul>
                        </div>
                        <div class="d-flex justify-content-between align-items-end mt-1 pt-25">
                            <div class="role-heading">
                                <h4 class="fw-bolder">{{ $nivel->name }}</h4>
                                <a href="/users/niveis/editar/{{ $nivel->id }}" class="role-edit-modal"
                                    id="{{ $nivel->id }}">
                                    <small class="fw-bolder">Editar Nível</small>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="col-xl-4 col-lg-6 col-md-6">
            <div class="card">
                <div class="row">
                    <div class="col-sm-5">
                        <div class="d-flex align-items-end justify-content-center h-100">
                            <img src="{{ asset('images/illustration/faq-illustrations.svg') }}" class="img-fluid mt-2"
                                alt="Image" width="85" />
                        </div>
                    </div>
                    <div class="col-sm-7">
                        <div class="card-body text-sm-end text-center ps-sm-0">
                            <a href="{{ url('users/niveis/novo') }}" class="stretched-link text-nowrap add-new-role">
                                <span class="btn btn-primary mb-1">Adicionar Novo Nível</span>
                            </a>
                            <p class="mb-0">Adicione um nível se ele não existir</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    @include('controle-acesso/lista-permissoes')
    @include('content/_partials/_modals/modal-add-role')
@endsection

@section('vendor-script')
    <!-- Vendor js files -->
    <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.bootstrap5.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
@endsection
@section('page-script')
    <!-- Page js files -->
    <script src="{{ asset(mix('js/scripts/pages/modal-add-role.js')) }}"></script>
@endsection
