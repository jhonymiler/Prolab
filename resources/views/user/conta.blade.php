@extends('layouts/contentLayoutMaster')

@section('title', 'Conta do Usuário')

@section('vendor-style')
    <!-- vendor css files -->
    <link rel='stylesheet' href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel='stylesheet' href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
    <link rel='stylesheet' href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">

@endsection
@section('page-style')
    <!-- Page css files -->

    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            @include('user.menu', ['conta' => 'active', 'permissoes' => ''])

            <!-- profile -->
            <div class="card">
                <div class="card-header border-bottom">
                    <h4 class="card-title">Detalhes do Perfil</h4>
                </div>
                <div class="card-body py-2 my-25">
                    <!-- form -->
                    <form class="validate-form pt-50" method="post"
                        action="@isset($user->id){{ url('/users/edit/' . $user->id) }}@else {{ route('user-create') }} @endisset"
                        enctype="multipart/form-data">
                        @csrf
                        <!-- header section -->
                        <div class="d-flex">
                            <a href="#" class="me-25 avatar ">
                                <img src="{{ asset('avatar/' . $user->avatar) }}" id="account-upload-img"
                                    class="uploadedAvatar" alt="profile image" height="100" width="100" />
                            </a>
                            <!-- upload and reset button -->
                            <div class="d-flex align-items-end mt-75 ms-1">
                                <div>
                                    <label for="account-upload" class="btn btn-sm btn-primary mb-75 me-75">Upload</label>
                                    <input type="file" name="avatar" id="account-upload" hidden accept="image/*" />
                                    <button type="button" id="account-reset"
                                        class="btn btn-sm btn-outline-secondary mb-75">Limpar</button>
                                    <p class="mb-0">Apenas imagens: png, jpg, jpeg.</p>
                                </div>
                            </div>
                            <!--/ upload and reset button -->
                        </div>
                        <!--/ header section -->
                        <div class="row mt-2">
                            <div class="col-12 col-sm-6 mb-1">
                                <label class="form-label" for="name">Nome</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="John"
                                    value="{{ $user->name }}" data-msg="Please enter first name" />
                            </div>
                            <div class="col-12 col-sm-6 mb-1">
                                <label class="form-label" for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email"
                                    value="{{ $user->email }}" />
                            </div>
                            <div class="col-12 col-sm-6 mb-1">
                                <label class="form-label" for="celular">Celular</label>
                                <input type="text" class="form-control account-number-mask" id="celular" name="celular"
                                    placeholder="Número de celular" data-mask="(00) 0 0000-0000"
                                    value="{{ $user->celular }}" />
                            </div>
                            <div class="col-12 col-sm-6 mb-1">
                                <label class="form-label" for="nivel">Nível de Acesso</label>
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

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary mt-1 me-1">Salvar</button>
                                <button type="reset" class="btn btn-outline-secondary mt-1">Cancelar</button>
                            </div>
                        </div>
                    </form>
                    <!--/ form -->
                </div>
            </div>

            @can('deletar usuarios')
                @isset($user->id)
                    <!-- deactivate account  -->
                    @include('content._partials.desativa-user')
                @endcan
            @endisset
        </div>
    </div>
@endsection

@section('vendor-script')
    <!-- vendor files -->
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/cleave/cleave.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/cleave/addons/cleave-phone.us.js')) }}"></script>
@endsection
@section('page-script')
    <!-- Page js files -->
    <script src="{{ asset(mix('js/scripts/pages/page-account-settings-account.js')) }}"></script>
@endsection
