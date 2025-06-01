"use strict";
var KTAppEcommerceCategories = (function () {
  var t,
    e,
    n = () => {
      t.querySelectorAll(
        '[data-kt-ecommerce-category-filter="delete_row"]'
      ).forEach((t) => {
        t.addEventListener("click", function (t) {
          t.preventDefault();
          const form = t.target.closest("form");
          const n = t.target.closest("tr"),
            o = n.querySelector(
              '[data-kt-ecommerce-category-filter="category_name"]'
            ).innerText;
          Swal.fire({
            html: "Êtes-vous sûr de vouloir supprimer la catégorie <b>" + o + "</b> ?",
            icon: "warning",
            showCancelButton: !0,
            buttonsStyling: !1,
            confirmButtonText: "Yes, delete!",
            cancelButtonText: "No, cancel",
            customClass: {
              confirmButton: "btn fw-bold btn-danger",
              cancelButton: "btn fw-bold btn-active-light-primary",
            },
          }).then(function (t) {
            t.value
              ? (
                  // e.row($(n)).remove().draw(),
                  form.submit()
                )
              : "cancel" === t.dismiss
          });
        });
      });
    };
  return {
    init: function () {
      (t = document.querySelector("#kt_ecommerce_category_table")) &&
        ((e = $(t).DataTable({
          info: !1,
          order: [],
          pageLength: 10,
          columnDefs: [
            { orderable: !1, targets: 0 },
            { orderable: !1, targets: 3 },
          ],
        })).on("draw", function () {
          n();
        }),
        document
          .querySelector('[data-kt-ecommerce-category-filter="search"]')
          .addEventListener("keyup", function (t) {
            e.search(t.target.value).draw();
          }),
        n());
    },
  };
})();
KTUtil.onDOMContentLoaded(function () {
  KTAppEcommerceCategories.init();
});
