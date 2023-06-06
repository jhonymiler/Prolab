@extends('layouts/contentLayoutMaster')

@section('title', 'Nível de Acesso')

@section('vendor-style')
    <!-- vendor css files -->
    <link rel='stylesheet' href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
@endsection
@section('page-style')
    <!-- Page css files -->
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
    <style>
        .form-check-input:disabled {
            background-color: #283046;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            @include('user.menu', ['conta' => '', 'permissoes' => 'active'])

            <!-- security -->

            <div class="card">
                <div class="card-header border-bottom">
                    <h4 class="card-title">Nível de Acesso: <a
                            href="{{ url('/users/niveis/editar/' . $user->nivel->id) }}">{{ $user->nivel->name }}</a></h4>
                </div>
                <div class="card-body pt-1">
                    <!-- form -->
                    <form class="validate-form row" id="addRoleForm" action="{{ $action }}" method="post">
                        @csrf
                        <div class="col-12">
                            <h4 class="mt-2 pt-50">Permissões de Acesso <span data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Modulos do sistema">
                                    <i data-feather="info"></i>
                                </span></h4>

                            <div class="table-responsive">
                                <table class="table table-flush-spacing">
                                    <tbody>
                                        <tr>
                                            <td class="text-nowrap fw-bolder">

                                            </td>
                                            <td>

                                            </td>
                                        </tr>
                                        @foreach ($permissoes as $model => $permissao)
                                            <tr>
                                                <td class="text-nowrap fw-bolder">{{ $model }}</td>
                                                <td>
                                                    <div class="d-flex">
                                                        @foreach ($permissao as $k => $perm)
                                                            <div class="form-check me-3 me-lg-5">
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="permissoes[]"
                                                                    id="{{ $model }}_{{ $perm['name'] }}"
                                                                    value="{{ $perm['name'] }} {{ $model }}"
                                                                    @if (isset($permViaNivel) && in_array($perm['id'], $permViaNivel)) @checked(true) @disabled(true)
                                                                    @else
                                                                        @if ($permDireta && in_array($perm['id'], $permDireta)) @checked(true) @endif
                                                                    @endif/>
                                                                <label class="form-check-label"
                                                                    for="{{ $model }}_{{ $perm['name'] }}">
                                                                    {{ $perm['name'] }}
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach


                                    </tbody>
                                </table>
                            </div>
                            <!-- Permission table -->
                        </div>
                        <div class="col-12 text-center mt-2">
                            <button type="submit" class="btn btn-primary me-1">Enviar</button>
                            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                                aria-label="Close">
                                Cancelar
                            </button>
                        </div>
                    </form>
                    <!--/ form -->
                </div>
            </div>


        </div>
    </div>

@endsection

@section('vendor-script')
    <!-- vendor files -->
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/cleave/cleave.min.js')) }}"></script>
@endsection
@section('page-script')
    <!-- Page js files -->
    <script src="{{ asset(mix('js/scripts/pages/user-permissoes.js')) }}"></script>
@endsection
