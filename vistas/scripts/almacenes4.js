var tabla;

//Función que se ejecuta al inicio
function init() {
	mostrarform(false);
	listar();

	$("#formulario").on("submit", function (e) {
		guardaryeditar(e);
	});
	$('#mAlmacen').addClass("treeview active");
	$('#lAlmacenes').addClass("active");
}

//Función limpiar
function limpiar() {
	$("#idalmacen").val("");
	$("#ubicacion").val("");
	$("#descripcion").val("");
}

//Función mostrar formulario
function mostrarform(flag) {
	limpiar();
	if (flag) {
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled", false);
		$("#btnagregar").hide();
	}
	else {
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
	}
}

//Función cancelarform
function cancelarform() {
	limpiar();
	mostrarform(false);
}

//Función Listar
function listar() {
	tabla = $('#tbllistado').dataTable(
		{
			"lengthMenu": [5, 10, 25, 75, 100],//mostramos el menú de registros a revisar
			"aProcessing": true,//Activamos el procesamiento del datatables
			"aServerSide": true,//Paginación y filtrado realizados por el servidor
			dom: '<Bl<f>rtip>',//Definimos los elementos del control de tabla
			buttons: [
				'copyHtml5',
				'excelHtml5',
				'csvHtml5',

			],
			"ajax":
			{
				url: '../ajax/almacenes.php?op=listar',
				type: "get",
				dataType: "json",
				error: function (e) {
					console.log(e.responseText);
				}
			},
			"language": {
				"lengthMenu": "Mostrar : _MENU_ registros",
				"buttons": {
					"copyTitle": "Tabla Copiada",
					"copySuccess": {
						_: '%d líneas copiadas',
						1: '1 línea copiada'
					}
				}
			},
			"bDestroy": true,
			"iDisplayLength": 5,//Paginación
			"order": []
		}).DataTable();
}
//Función para guardar o editar

function guardaryeditar(e) {
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled", true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../ajax/almacenes.php?op=guardaryeditar",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,

		success: function (datas) {
			if (datas == "La ubicación que ha ingresado ya existe.") {
				bootbox.alert(datas);
				$("#btnGuardar").prop("disabled", false);
				return;
			}
			limpiar();
			bootbox.alert(datas);
			mostrarform(false);
			setTimeout(function () {
				window.location.reload()
			}, 2500);
		}
	});
}

function mostrar(idalmacen) {
	$.post("../ajax/almacenes.php?op=mostrar", { idalmacen: idalmacen }, function (data, status) {
		data = JSON.parse(data);
		mostrarform(true);

		$("#ubicacion").val(data.ubicacion);
		$("#descripcion").val(data.descripcion);
		$("#idalmacen").val(data.idalmacen);

	})
}

//Función para desactivar registros
function desactivar(idalmacen) {
	bootbox.confirm("¿Está Seguro de desactivar el almacén?", function (result) {
		if (result) {
			$.post("../ajax/almacenes.php?op=desactivar", { idalmacen: idalmacen }, function (e) {
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	})
}

//Función para activar registros
function activar(idalmacen) {
	bootbox.confirm("¿Está Seguro de activar el almacén?", function (result) {
		if (result) {
			$.post("../ajax/almacenes.php?op=activar", { idalmacen: idalmacen }, function (e) {
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	})
}


init();