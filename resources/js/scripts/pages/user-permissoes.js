$(function () {
    "use strict";
    const selectAll = document.querySelector("#selectAll"),
        checkboxList = document.querySelectorAll('[type="checkbox"]');
    selectAll.addEventListener("change", (t) => {
        checkboxList.forEach((e) => {
            e.checked = t.target.checked;
        });
    });
});
