@if ($user->status == 1 || $user->status === null)
    <div class="card">
        <div class="card-header border-bottom">
            <h4 class="card-title">Desativar Conta de Usuário</h4>
        </div>
        <div class="card-body py-2 my-25">
            <div class="alert alert-warning">
                <h4 class="alert-heading">Tem certeza que deseja desativar a conta deste usuário?</h4>
                <div class="alert-body fw-normal">
                    Para desativar a conta, marque a opção abaixo de confirmação e clique "Desativar Conta".
                </div>
            </div>

            <form id="formAccountDeactivation" class="validate-form" onsubmit="return false">
                @csrf
                <div class="form-check">
                    <input type="hidden" id="statusUserId" name="id" value="{{ $user->id }}">
                    <input type="hidden" name="status" value="0">
                    <input class="form-check-input" type="checkbox" name="accountDectivation" id="accountDectivation"
                        data-msg="Por favor confirme a Inativação desta Conta" value="" />
                    <label class="form-check-label font-small-3" for="accountDectivation">
                        Confirmo a desativação desta conta
                    </label>
                </div>
                <div>
                    <button type="submit" class="btn btn-danger deactivate-account mt-1" disabled>Desativar
                        Conta</button>
                </div>
            </form>
        </div>

    </div>
@else
    <div class="card">
        <div class="card-header border-bottom">
            <h4 class="card-title">Reativar Conta de Usuário</h4>
        </div>
        <div class="card-body py-2 my-25">
            <div class="alert alert-warning">
                <h4 class="alert-heading">Tem certeza que deseja reativar a conta deste usuário?</h4>
                <div class="alert-body fw-normal">
                    Para reativar a conta, marque a opção abaixo de confirmação e clique "Reativar Conta".
                </div>
            </div>

            <form id="formAccountReactivation" class="validate-form" onsubmit="return false">
                @csrf
                <div class="form-check">
                    <input type="hidden" name="id" id="statusUserId" value="{{ $user->id }}">
                    <input type="hidden" name="status" value="1">
                    <input class="form-check-input" type="checkbox" name="accountReactivation" id="accountReactivation"
                        data-msg="Por favor confirme a Reativação desta Conta" value="" />
                    <label class="form-check-label font-small-3" for="accountReactivation">
                        Confirmo a desativação desta conta
                    </label>
                </div>
                <div>
                    <button type="submit" class="btn btn-success reactivate-account mt-1">Reativar
                        Conta</button>
                </div>
            </form>
        </div>
    </div>
    <!--/ profile -->
@endif
