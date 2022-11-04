jQuery(function () {
    jQuery('body').on('click', '#validar', function () {
        var campos = ['email', 'password'];
        var counErrors = 0;
        for (var item in campos) {
            if ($("#" + campos[item]).val() === "") {
                counErrors++;
                $("#" + campos[item]).css("border", "1px solid #dc3545");
            } else {
                $("#" + campos[item]).css("border", "1px solid #d2d6de");
            }
        }
        if (counErrors > 0) {
           Swal.fire({
                position: "top-end" ,
                icon: "error",
                title: "Los campos marcados en rojo son obligatorios..!",
                showConfirmButton: false,
                timer: 3000
           });
        }else{
             $("form#ingresar").submit();
        }
    });
});


