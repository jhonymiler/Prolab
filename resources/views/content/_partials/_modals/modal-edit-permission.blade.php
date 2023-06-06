<!-- Edit Permission Modal -->
<div class="modal fade" id="editPermissionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3 pt-0">
                <div class="text-center mb-2">
                    <h1 class="mb-1">Editar Permissão</h1>
                    <p>Edit permission as per your requirements.</p>
                </div>

                <div class="alert alert-warning" role="alert">
                    <h6 class="alert-heading">Cuidado!</h6>
                    <div class="alert-body">
                        Ao editar o nome da permissão, você pode quebrar a funcionalidade de permissões do sistema.
                        Certifique-se de ter certeza absoluta antes de prosseguir.
                    </div>
                </div>

                <form id="editPermissionForm" class="row" onsubmit="return false">
                    <div class="col-sm-9">
                        <label class="form-label" for="editPermissionName">Nome da Permissão</label>
                        <input type="text" id="editPermissionName" name="editPermissionName" class="form-control"
                            placeholder="Enter a permission name" tabindex="-1"
                            data-msg="Please enter permission name" />
                    </div>
                    <div class="col-sm-3 ps-sm-0">
                        <button type="submit" class="btn btn-primary mt-2">Atualizar</button>
                    </div>
                    <div class="col-12 mt-75">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="editCorePermission" />
                            <label class="form-check-label" for="editCorePermission"> Set as core permission </label>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--/ Edit Permission Modal -->
