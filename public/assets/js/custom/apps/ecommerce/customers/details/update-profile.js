"use strict";
var KTEcommerceUpdateProfile = (function () {
  var e, t, i;
  return {
    init: function () {
      (i = document.querySelector("#kt_ecommerce_customer_profile")),
        (e = i.querySelector("#kt_ecommerce_customer_profile_submit")),
        (t = FormValidation.formValidation(i, {
          fields: {
            'clients[nom]': {
              validators: { notEmpty: { message: "Le nom du client est requis" } },
            },
            'clients[registreCommerce]': {
              validators: { notEmpty: { message: "Le numéro du registre de commerce est requis" } },
            },
            'clients[regimeImposition]': {
              validators: { notEmpty: { message: "Le regime d'imposition est requis" } },
            },
            'clients[telephone]': {
              validators: { notEmpty: { message: "Le numéro de téléphone est requis" } },
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
        e.addEventListener("click", function (c) {
          c.preventDefault(),
            t &&
              t.validate().then(function (t) {
                console.log("validated!"),
                  "Valid" == t
                    ? (e.setAttribute("data-kt-indicator", "on"),
                      (e.disabled = !0),
                      setTimeout(function () {
                        e.removeAttribute("data-kt-indicator"),
                        (e.disabled = !1,
                            i.submit()
                        );
                      }, 2e3))
                    : Swal.fire({
                        text: "Désolé il semble y avoir une erreur, veuillez vérrifier les champs obligatoires.",
                        icon: "error",
                        buttonsStyling: !1,
                        confirmButtonText: "Ok, compris !",
                        customClass: { confirmButton: "btn btn-primary" },
                      });
              });
        });
    },
  };
})();
KTUtil.onDOMContentLoaded(function () {
  KTEcommerceUpdateProfile.init();
});
