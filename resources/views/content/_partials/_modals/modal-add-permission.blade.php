<!-- Add Permission Modal -->


<div class="modal fade" id="addPermissionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-sm-5 pb-5">
                <div class="text-center mb-2">
                    <h1 class="mb-1">Adicionar Nova Permissão</h1>
                    <p>Estas permissões, após criadas, devem ser adicionadas a níveis ou usuários.</p>
                </div>
                <form id="addPermissionForm" class="row" action="{{ route('permissoes-novo') }}" method="post">
                    @csrf
                    <div class="col-12">
                        <label class="form-label" for="permissao">Nome da permissão</label>
                        <input type="text" id="permissao" name="permissao" class="form-control" value=''
                            placeholder="Ex: usuarios" autofocus data-msg="Por favor digite um nome para a permissão" />
                    </div>

                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary mt-2 me-1">Salvar</button>
                        <button type="reset" class="btn btn-outline-secondary mt-2" data-bs-dismiss="modal"
                            aria-label="Close">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--/ Add Permission Modal -->
