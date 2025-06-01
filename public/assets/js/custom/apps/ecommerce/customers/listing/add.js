"use strict";
var KTModalCustomersAdd = (function () {
  var t, e, o, n, r, i;
  return {
    init: function () {
      (i = new bootstrap.Modal(
        document.querySelector("#kt_modal_add_customer")
      )),
        (r = document.querySelector("#kt_modal_add_customer_form")),
        (t = r.querySelector("#kt_modal_add_customer_submit")),
        (e = r.querySelector("#kt_modal_add_customer_cancel")),
        (o = r.querySelector("#kt_modal_add_customer_close")),
        (n = FormValidation.formValidation(r, {
          fields: {
            'clients[nomComplet]': {
              validators: {
                notEmpty: { message: "Le nom du client est requis" },
              },
            },
            'clients[telephone]': {
              validators: {
                notEmpty: { message: "Le numéro de téléphone est obligatoire" },
              },
            },
            "clients[categorie]": {
                validators: {
                    notEmpty: {
                        message: 'Choisissir une catégorie'
                    }
                }
            },
          },
          plugins: {
            trigger: new FormValidation.plugins.Trigger(),
            bootstrap: new FormValidation.plugins.Bootstrap5({
              rowSelector: ".fv-row",
              eleInvalidClass: "",
              eleValidClass: "",
            }),
          },
        })),
        $(r.querySelector('[name="country"]')).on("change", function () {
          n.revalidateField("country");
        }),
        t.addEventListener("click", function (e) {
          e.preventDefault(),
            n &&
              n.validate().then(function (e) {
                console.log("validated!"),
                  "Valid" == e
                    ? (t.setAttribute("data-kt-indicator", "on"),
                      (t.disabled = !0),
                      setTimeout(function () {
                        t.removeAttribute("data-kt-indicator"),
                        (i.hide(),
                            (t.disabled = !1),
                            r.submit()
                        )
                      }, 2e3))
                    : Swal.fire({
                        text: "Désolé il semble y avoir une erreur, veuillez vérrifier les champs obligatoires.",
                        icon: "error",
                        buttonsStyling: !1,
                        confirmButtonText: "Ok, compris !",
                        customClass: { confirmButton: "btn btn-primary" },
                      });
              });
        }),
        e.addEventListener("click", function (t) {
          t.preventDefault(),
            (r.reset(), i.hide())
        }),
        o.addEventListener("click", function (t) {
          t.preventDefault(),
            (r.reset(), i.hide())
        });
    },
  };
})();
KTUtil.onDOMContentLoaded(function () {
  KTModalCustomersAdd.init();
});
