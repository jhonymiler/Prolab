@can('criar permissoes|editar permissoes')
    @if ($form)
        <div class="row">
            <div class="col-12">

                <div class="card">
                    <div class="card-header border-bottom">
                        <h4 class="card-title">Adicionar Novo Nível de Acesso</h4>
                        <p>Marque as permissões para este nível</p>
                    </div>
                    <div class="card-body py-2 my-25">
                        <!-- Add role form -->
                        <form id="addRoleForm" class="row" action="{{ $action }}" method="post">
                            @csrf
                            <div class="col-12">
                                <label class="form-label" for="nivel">Nome do Nível de Acesso

                                    <span data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="Digite apenas uma palavra, sem espaços.">
                                        <i data-feather="info"></i>
                                    </span>
                                </label>
                                <input type="text" id="nivel" name="nivel" class="form-control"
                                    placeholder="Digite apenas o nome do nível. Ex: Gerente" tabindex="-1"
                                    data-msg="Por favor digite um nome do nível" value="{{ $dadosNivel->name ?? '' }}" />
                            </div>
                            <div class="col-12">
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
                                                                        @if (isset($dadosNivel->id) && in_array($perm['id'], $dadosNivel->permissions->pluck('id')->toArray())) @checked(true) @endif />
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
                    </div>
                </div>
            </div>
        </div>
    @endisset

@endcan
