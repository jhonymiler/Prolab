!function(){var e=$("#addRoleForm");e.length&&e.validate({rules:{modalRoleName:{required:!0}}}),$(".modal").on("hidden.bs.modal",(function(){$(this).find("form")[0].reset()}));const o=document.querySelector("#selectAll"),t=document.querySelectorAll('[type="checkbox"]');o.addEventListener("change",(e=>{t.forEach((o=>{o.checked=e.target.checked}))}));var c=$(".role-edit-modal"),d=$(".add-new-role"),l=$(".role-title");d.on("click",(function(){l.text("Adicionar Novo Nível de Acesso")})),c.on("click",(function(){l.text("Editar Nível de Acesso")}))}();
