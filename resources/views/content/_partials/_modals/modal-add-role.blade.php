<!-- Add Role Modal -->
<div class="modal fade" id="addRoleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-add-new-role">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-5 pb-5">
                <div class="text-center mb-4">
                    <h1 class="role-title">Adicionar Novo Nível de Acesso</h1>
                    <p>Marque as permissões para este nível</p>
                </div>
                <!-- Add role form -->
                <form id="addRoleForm" class="row" onsubmit="return false">
                    <div class="col-12">
                        <label class="form-label" for="modalRoleName">Role Name</label>
                        <input type="text" id="modalRoleName" name="modalRoleName" class="form-control"
                            placeholder="Ex: Modulo" tabindex="-1" data-msg="Por favor digite um nome de permissão" />
                    </div>
                    <div class="col-12">
                        <h4 class="mt-2 pt-50">Permissões</h4>
                        <!-- Permission table -->
                        <div class="table-responsive">
                            <table class="table table-flush-spacing">
                                <tbody>
                                    <tr>
                                        <td class="text-nowrap fw-bolder">
                                            Permissões
                                            <span data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Modulos do sistema">
                                                <i data-feather="info"></i>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="selectAll" />
                                                <label class="form-check-label" for="selectAll"> Selecionar Todos
                                                </label>
                                            </div>
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
                                                                @if (isset($permissaoUsuario->id) && $permissaoUsuario->id == $perm['id']) @checked(true) @endif />
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
                <!--/ Add role form -->
            </div>
        </div>
    </div>
</div>
<!--/ Add Role Modal -->
