var timestamp = 0;
if (pathname.includes("finger-list")) {
    setInterval(getFingerprintByUser, 1000);
}

if (pathname === base_url) {
    activeSensorRead(false);
    getFingerCurrentChekInOut();
}

function srnPc() {
    var d = new Date();
    var dateint = d.getTime();
    var letters = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    var total = letters.length;
    var keyTemp = "";
    for (var i = 0; i < 6; i++) {
        keyTemp += letters[parseInt((Math.random() * (total - 1) + 1))];
    }
    keyTemp += dateint;
    return keyTemp;
}

function generarToken() {
    if (!localStorage.getItem("srnPc")) {
        localStorage.setItem("srnPc", srnPc());
        Swal.fire({
            icon: 'success',
            title: 'Token generado..!',
            text: 'Token: ' + localStorage.getItem("srnPc")
        });
    } else {
        Swal.fire({
            icon: 'warning',
            title: 'El token generado es:',
            text: localStorage.getItem("srnPc")
        });
    }
}

function consulta(current_page, from) {
    var dataInfo = $("#element-find").val();
    var link = $("#link").val();
    if (dataInfo === "") {
        window.location = link;
        return;
    }
    var campos = $("#fields").val().split(",");
    var token = $("input[name='_token']").val();
    var show_action = $("#show_action").val();
    var data = new FormData();
    data.append("search", dataInfo);
    data.append("_token", token);
    data.append("from", from);
    var currentPage = current_page;
    $.ajax({
        type: 'POST',
        url: base_url + "/" + link + "/search",
        data: data,
        dataType: 'json',
        contentType: false,
        processData: false,
        cache: false,
        success: function (response) {
            var totalPages = Math.ceil(response.count / 15);
            var r = "";
            var classDisabled_a = "";
            var cursor_a = "cursor:pointer;";
            if (currentPage === 1) {
                classDisabled_a = "disabled";
                cursor_a = "";
            }
            var classDisabled_s = "";
            var cursor_s = "cursor:pointer;";
            if (currentPage === totalPages) {
                classDisabled_s = "disabled";
                cursor_s = "";
            }
            for (var i = 0; i < response.total_registros; i++) {
                r += "<tr class='even pointer'>";
                for (var j = 1; j < campos.length; j++) {
                    r += "<td>" + response[i][campos[j]] + "</td>";
                }
                if (show_action == 'Y') {
                    r += "<td class=' last'>"
                    r += "<a href='" + link + "/" + response[i][campos[0]] + "/edit' style='font-size: 15px;'><i class='fa fa-pencil'></i></a>";
                    if (link === 'usuarios') {
                        r += "<a href='" + link + "/" + response[i][campos[0]] + "/finger-list' style='font-size: 15px;margin-left: 7px;color:#03579f;'><i class='fa fa-hand-o-up'></i></a>";
                    }
                    r += "<a href='javascript:void(0)' class='eliminar' data-titulo='¿Esta seguro de eliminar este registro?' data-id='" + response[i]['id'] + "' style='color:#dc3545;margin-left: 5px;font-size: 15px;margin-left: 7px;' data-placement='top'><i class='fa fa-trash'></i></a>";
                    r += "</td>";
                }
                r += "</tr>";
            }
            var paginator = "";
            if (totalPages > 1) {
                paginator += "<nav style='margin-top: -2%;'>";
                paginator += "<ul class='pagination'>";
                paginator += "<li class='page-item " + classDisabled_a + "' onclick='anterior(" + (currentPage) + ", " + totalPages + ", " + (from) + ")' aria-disabled='true' aria-label='Anterior'>";
                paginator += "<span class='page-link' style='color: #405467;" + cursor_a + "' aria-hidden='true'>Anterior</span>";
                paginator += "</li>";
                var limit = 0;
                var active = "";
                var style = "";

                for (var j = 0; j < totalPages; j++) {
                    var page = (j + 1);
                    if (currentPage === page) {
                        active = "active";
                        style = "style='background-color: #405467;border-color: #405467;cursor:pointer;'";
                    } else {
                        active = "";
                        style = "style='color: #405467;cursor:pointer;'";
                    }
                    paginator += "<li class='page-item " + active + "' aria-current='page'>";
                    paginator += "<span " + style + " data-limit='" + limit + "' data-page='" + page + "' class='search page-link' onclick='consulta(" + page + ", " + limit + ")'>" + page + "</span></li>";
                    paginator += "</li>";
                    limit += 15;
                }
                paginator += "<li class='page-item " + classDisabled_s + "'>";
                paginator += "<a class='page-link' style='color: #405467;" + cursor_s + "' onclick='siguiente(" + currentPage + ", " + totalPages + ", " + from + ")' href='javascript:void(0)' rel='next' aria-label='Siguiente'>Siguiente</a>";
                paginator += "</li>";
                paginator += "</ul></nav>";
            }
            $("#_results").html(r);
            $("#pagination_").html(paginator);
            $("#total_paginas").val(totalPages);
        }
    });
}

function siguiente(currentp, totalp, from) {
    if (currentp < totalp) {
        consulta(currentp + 1, from + 15);
    }
}

function anterior(currentp, totalp, from) {
    if (currentp >= totalp) {
        consulta(currentp - 1, from - 15);
    }
}

$(".table").on('click', '.eliminar', function () {
    var titulo = $(this).data("titulo");
    var id = $(this).data("id");
    var link = $("#link").val();
    Swal.fire({
        title: titulo,
        icon: 'warning',
        showCancelButton: true,
        cancelButtonColor: "#3085d6",
        cancelButtonText: 'Cancelar',
        confirmButtonText: "Eliminar",
        confirmButtonColor: "#d33"
    }).then((result) => {       
        if (result.isConfirmed) {
            $("form#delete").attr("action", base_url + "/" + link + "/" + id);
            $('form#delete').submit();
        }
    });
});


function getFingerprintByUser() {
    var _url = $("#_url").val();
    var userId = $("#user_id").val();
    $.get(base_url + "/get-finger/" + userId, function (data) {
        if (data.length > 0) {
            window.location = _url;
        }
    });
}

//verificar check in o check out
function getFingerCurrentChekInOut() {
    $.get(base_url + "/check-in/" + localStorage.getItem("srnPc") + "/" + timestamp, function (data) {
        console.log(data)
        timestamp = data.updated_at;
        if (data.image !== null) {
            var html = "Identificacion: " + data.user_id_number + "<br>Nombre: " + data.name;
            $("#" + localStorage.getItem("srnPc") + "_user").html(html);
            $("#" + localStorage.getItem("srnPc")).attr("src", "data:image/png;base64," + data.image);
            if (data.name !== '-----') {
                $("#" + localStorage.getItem("srnPc") + "_texto").text("Usuario verificado");
                icono = "success"
                if (data.text === "Ya registraste salida..!") {
                    icono = "warning";
                }
                Swal.fire({
                    position: 'top-end',
                    icon: icono,
                    title: data.text,
                    showConfirmButton: false,
                    timer: 3000
                })
            } else {
                $("#" + localStorage.getItem("srnPc") + "_texto").text("El Usuario No existe");
            }
        }
        setTimeout("getFingerCurrentChekInOut()", 1000);
    });
}

jQuery('body').on('click', '.new-finger', function () {
    Swal.fire({
        title: 'Seleccione el nombre del dedo',
        input: 'select',
        inputOptions: {
            'Seleccione': 'Seleccione',
            "Dedos Mano Derecha": {
                Pulgar_Derecho: 'Pulgar',
                Indice_Derecho: 'Indice',
                Corazon_Derecho: 'Corazon',
                Anular_Derecho: 'Anular',
                Meñique_Derecho: 'Meñique'
            },
            "Dedos Mano Izquierda": {
                Pulgar_Izquierdo: 'Pulgar',
                Indice_Izquierdo: 'Indice',
                Corazon_Izquierdo: 'Corazon',
                Anular_Izquierdo: 'Anular',
                Meñique_Izquierdo: 'Meñique'
            },
        },
        showCancelButton: true,
        inputValidator: (value) => {
            return new Promise((resolve) => {
                if (value !== 'Seleccione') {
                    var token = $("input[name='_token']").val();
                    var data = new FormData();
                    data.append("_token", token);
                    data.append("token_pc", localStorage.getItem("srnPc"));
                    data.append("user_id", $("#user_id").val());
                    data.append("finger_name", value);
                    $.ajax({
                        type: 'POST',
                        url: base_url + "/active_sensor_enroll",
                        data: data,
                        dataType: 'json',
                        contentType: false,
                        processData: false,
                        cache: false,
                        success: function (response) {
                            if (!response.code) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error activando el lector..!',
                                    text: "Ha ocurrido un error activando el lector."
                                });
                            }
                        }
                    });
                    resolve();
                } else {
                    resolve('Debes seleccionar un dedo..!');
                }
            });
        }
    });
});

function activeSensorRead(showMessage) {
    if (!localStorage.getItem("srnPc")) {
        Swal.fire({
            icon: 'warning',
            title: 'Aun no se ha generado un token para este navegador..!',
            text: "No se puede activar el lector."
        });
    } else {
        $(".imgFinger").attr("id", localStorage.getItem("srnPc"));
        $(".txtFinger").attr("id", localStorage.getItem("srnPc") + "_texto");
        $(".dataUser").attr("id", localStorage.getItem("srnPc") + "_user");
        var token = $("input[name='_token']").val();
        var data = new FormData();
        data.append("_token", token);
        data.append("token_pc", localStorage.getItem("srnPc"));
        $.ajax({
            type: 'POST',
            url: base_url + "/active_sensor_read",
            data: data,
            dataType: 'json',
            contentType: false,
            processData: false,
            cache: false,
            success: function (response) {
                if (!response.code) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error activando el lector..!',
                        text: "Ha ocurrido un error activando el lector."
                    });
                } else {
                    if (showMessage) {
                        Swal.fire({
                            position: 'top-end',
                            icon: "success",
                            title: "Sensor Activado",
                            showConfirmButton: false,
                            timer: 2000
                        })
                    }
                }
            }
        });
    }
}


function closeSensorRead() {
    var token = $("input[name='_token']").val();
    var data = new FormData();
    data.append("_token", token);
    data.append("token_pc", localStorage.getItem("srnPc"));
    $.ajax({
        type: 'POST',
        url: base_url + "/sensor_close",
        data: data,
        dataType: 'json',
        contentType: false,
        processData: false,
        cache: false,
        success: function (response) {
            if (response.code) {
                Swal.fire({
                    position: 'top-end',
                    icon: "success",
                    title: "Sensor Desactivado",
                    showConfirmButton: false,
                    timer: 2000
                })
            }
        }
    });
}


jQuery('body').on('click', '.goLogin', function () {
    var _url = $(this).data("url");
    var token = $("input[name='_token']").val();
    var data = new FormData();
    data.append("_token", token);
    data.append("token_pc", localStorage.getItem("srnPc"));
    $.ajax({
        type: 'POST',
        url: base_url + "/sensor_close",
        data: data,
        dataType: 'json',
        contentType: false,
        processData: false,
        cache: false,
        success: function (response) {
            if (response.code) {
                window.location = _url;
            }
        }
    });
});

jQuery('body').on('click',".boton", function () {
        $.alert("Estas aqui,load");
	return !!(navigator.getUserMedia || (navigator.mozGetUserMedia || navigator.mediaDevices.getUserMedia) || navigator.webkitGetUserMedia || navigator.msGetUserMedia);
        });
        
jQuery('body').on('click', '#register', function () {
    var user_id_number = $("#user_id_number").val();
    if (user_id_number !== "") {
        $("#user_id_number").css("border", "1px solid #73879C");
        var token = $("input[name='_token']").val();
        var data = new FormData();
        data.append("_token", token);
        data.append("user_id_number", user_id_number);
        $.ajax({
            type: 'POST',
            url: base_url + "/save_record",
            data: data,
            dataType: 'json',
            contentType: false,
            processData: false,
            cache: false,
            success: function (response) {
                $("#user_id_number").val("");
                Swal.fire({
                    position: 'top-end',
                    icon: response.icono,
                    title: response.mensaje,
                    showConfirmButton: false,
                    timer: 2000
                });
            }
        });
    } else {
        Swal.fire({
            position: 'top-end',
            icon: "warning",
            title: "Debes ingresar tu identificación..!",
            showConfirmButton: false,
            timer: 2000
        });
        $("#user_id_number").css("border", "1px solid #dc3545");
    }
});