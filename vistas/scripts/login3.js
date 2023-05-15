//Función que se ejecuta al inicio
function init() {
    $("#frmAcceso").on("submit", function (e) {
        validar(e);
    });
    $('#mPerfilUsuario').addClass("treeview active");
    $('#lConfPortada').addClass("active");

    mostrar();
}

function validar(e) {
    e.preventDefault();
    logina = $("#logina").val();
    clavea = $("#clavea").val();

    $.post("../ajax/usuario.php?op=verificar",
        { "logina": logina, "clavea": clavea },
        function (data) {
            if (data != "null") {
                $(location).attr("href", "escritorio.php");
            }
            else {
                bootbox.alert("Usuario y/o Contraseña incorrectos");
            }
        });
}

function mostrar() {
    var imagen = localStorage.getItem('imagen') || '';
    if (imagen !== '') {
        $("body").css("background-image", "url('../files/portadas/" + imagen + "')");
    } else {
        $.post("../ajax/verPortada.php?op=mostrar", function (datas, status) {
            data = JSON.parse(datas);
            console.log(data);
            $("#imagenmuestra").attr("src", "../files/portadas/" + data.imagen);
            $("body").css("background-image", "url('../files/portadas/" + data.imagen + "')");
            localStorage.setItem('imagen', data.imagen);
        });
    }
}

init();