@extends('layouts/contentLayoutMaster')

@section('title', 'Senha')

@section('vendor-style')
    <!-- vendor css files -->
    <link rel='stylesheet' href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
@endsection
@section('page-style')
    <!-- Page css files -->
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            @include('minha-conta.menu', ['senha' => 'active', 'conta' => ''])

            <!-- security -->

            <div class="card">
                <div class="card-header border-bottom">
                    <h4 class="card-title">Alteração de senha</h4>
                </div>
                <div class="card-body pt-1">
                    <!-- form -->
                    <form class="validate-form" method="post" action="{{ route('troca-senha') }}">
                        @csrf
                        <div class="row">
                            <div class="col-12 col-sm-6 mb-1">
                                <label class="form-label" for="senha-atual">Senha atual</label>
                                <div class="input-group form-password-toggle input-group-merge">
                                    <input type="password" class="form-control" id="senha-atual" name="senha-atual"
                                        placeholder="Entre com sua senha atual"
                                        data-msg="Por favor, digite sua senha atual." />
                                    <div class="input-group-text cursor-pointer">
                                        <i data-feather="eye"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-6 mb-1">
                                <label class="form-label" for="senha">Nova Senha</label>
                                <div class="input-group form-password-toggle input-group-merge">
                                    <input type="password" id="senha" class="form-control" name="senha"
                                        placeholder="Digite a nova senha" data-msg="Por favor, digite a nova senha." />
                                    <div class="input-group-text cursor-pointer">
                                        <i data-feather="eye"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 mb-1">
                                <label class="form-label" for="senha_confirmation">Confirme a nova senha</label>
                                <div class="input-group form-password-toggle input-group-merge">
                                    <input type="password" class="form-control" id="senha_confirmation"
                                        name="senha_confirmation" name="senha" placeholder="Confirme sua nova senha" />
                                    <div class="input-group-text cursor-pointer"><i data-feather="eye"></i></div>
                                </div>
                            </div>
                            <div class="col-12">
                                <p class="fw-bolder">Recomendação de senha:</p>
                                <ul class="ps-1 ms-25">
                                    <li class="mb-50">Mínimo de 8 caracteres entre letras e números</li>
                                    <li class="mb-50">Ao menos uma letra maiúscula</li>
                                    <li>Ao menos um número ou símbolo (caractere especial)</li>
                                </ul>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary me-1 mt-1">Salvar</button>
                                <button type="reset" class="btn btn-outline-secondary mt-1">Cancelar</button>
                            </div>
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
@endsection
@section('page-script')
    <!-- Page js files -->
    <script src="{{ asset(mix('js/scripts/pages/page-account-settings-security.js')) }}"></script>
@endsection
