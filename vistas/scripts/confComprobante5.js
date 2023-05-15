var tabla;

//Función que se ejecuta al inicio
function init() {
	listarCompCompra()
	$("#formulario1").on("submit", function (e) {
		guardaryeditar1(e);
	});
	$("#formulario2").on("submit", function (e) {
		guardaryeditar2(e);
	});
	$("#formulario3").on("submit", function (e) {
		guardaryeditar3(e);
	});

	$.post("../ajax/confComprobante.php?op=getNumerosSerieComprobantes", function (data) {
		var obj = JSON.parse(data);
		console.log(obj);

		let num_comprobante1 = obj.num_serie_comprobante1.split("-")[0];
		let serie_comprobante1 = obj.num_serie_comprobante1.split("-")[1];

		let num_comprobante2 = obj.num_serie_comprobante2.split("-")[0];
		let serie_comprobante2 = obj.num_serie_comprobante2.split("-")[1];

		let num_comprobante3 = obj.num_serie_comprobante3.split("-")[0];
		let serie_comprobante3 = obj.num_serie_comprobante3.split("-")[1];

		$("#num_comprobante1").val(num_comprobante1);
		$("#serie_comprobante1").val(serie_comprobante1);

		$("#num_comprobante2").val(num_comprobante2);
		$("#serie_comprobante2").val(serie_comprobante2);

		$("#num_comprobante3").val(num_comprobante3);
		$("#serie_comprobante3").val(serie_comprobante3);
	});

	$('#mPerfilUsuario').addClass("treeview active");
	$('#lConfComprobante').addClass("active");
}

function guardaryeditar1(e) {
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar1").prop("disabled", true);
	var formData = new FormData($("#formulario1")[0]);
	var regex = /^FQ\d{4}$/;

	if (!regex.test(formData.get("num_comprobante1"))) {
		bootbox.alert("El formato del número de comprobante no es correcto.");
		$("#btnGuardar1").prop("disabled", false);
		return;
	}

	$.ajax({
		url: "../ajax/confComprobante.php?op=guardaryeditar1",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,

		success: function (datas) {
			console.log(datas);
			if (datas == "El número de comprobante que ha ingresado ya existe.") {
				bootbox.alert(datas);
				$("#btnGuardar1").prop("disabled", false);
				return;
			}
			bootbox.alert(datas);
			$("#btnGuardar1").prop("disabled", false);
		}
	});
}


function guardaryeditar2(e) {
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar2").prop("disabled", true);
	var formData = new FormData($("#formulario2")[0]);
	var regex = /^FQ\d{4}$/;

	if (!regex.test(formData.get("num_comprobante2"))) {
		bootbox.alert("El formato del número de comprobante no es correcto.");
		$("#btnGuardar2").prop("disabled", false);
		return;
	}

	$.ajax({
		url: "../ajax/confComprobante.php?op=guardaryeditar2",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,

		success: function (datas) {
			console.log(datas);
			if (datas == "El número de comprobante que ha ingresado ya existe.") {
				bootbox.alert(datas);
				$("#btnGuardar2").prop("disabled", false);
				return;
			}
			bootbox.alert(datas);
			$("#btnGuardar2").prop("disabled", false);
		}
	});
}

function guardaryeditar3(e) {
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar3").prop("disabled", true);
	var formData = new FormData($("#formulario3")[0]);
	var regex = /^GR\d{4}$/;

	if (!regex.test(formData.get("num_comprobante3"))) {
		bootbox.alert("El formato del número de comprobante no es correcto.");
		$("#btnGuardar3").prop("disabled", false);
		return;
	}

	$.ajax({
		url: "../ajax/confComprobante.php?op=guardaryeditar3",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,

		success: function (datas) {
			console.log(datas);
			if (datas == "El número de comprobante que ha ingresado ya existe.") {
				bootbox.alert(datas);
				$("#btnGuardar3").prop("disabled", false);
				return;
			}
			bootbox.alert(datas);
			$("#btnGuardar3").prop("disabled", false);
		}
	});
}

// Función listar comporbantes de Compra
function listarCompCompra() {
	tabla = $('#tbllistado').dataTable(
		{
			"lengthMenu": [5, 10, 25, 75, 100],//mostramos el menú de registros a revisar
			"aProcessing": true,//Activamos el procesamiento del datatables
			"aServerSide": true,//Paginación y filtrado realizados por el servidor
			dom: '<Bl<f>rtip>',//Definimos los elementos del control de tabla
			buttons: [],
			"ajax":
			{
				url: '../ajax/confComprobante.php?op=listarCompCompra',
				data: "",
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
			"iDisplayLength": 5,
			"order": []
		}).DataTable();
}

// Función listar comporbantes de Compra
function listarCompVenta() {
	tabla = $('#tbllistado').dataTable(
		{
			"lengthMenu": [5, 10, 25, 75, 100],//mostramos el menú de registros a revisar
			"aProcessing": true,//Activamos el procesamiento del datatables
			"aServerSide": true,//Paginación y filtrado realizados por el servidor
			dom: '<Bl<f>rtip>',//Definimos los elementos del control de tabla
			buttons: [],
			"ajax":
			{
				url: '../ajax/confComprobante.php?op=listarCompVenta',
				data: "",
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
			"iDisplayLength": 5,
			"order": []
		}).DataTable();
}

// Función listar comporbantes de Compra
function listarCompRemision() {
	tabla = $('#tbllistado').dataTable(
		{
			"lengthMenu": [5, 10, 25, 75, 100],//mostramos el menú de registros a revisar
			"aProcessing": true,//Activamos el procesamiento del datatables
			"aServerSide": true,//Paginación y filtrado realizados por el servidor
			dom: '<Bl<f>rtip>',//Definimos los elementos del control de tabla
			buttons: [],
			"ajax":
			{
				url: '../ajax/confComprobante.php?op=listarCompRemision',
				data: "",
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
			"iDisplayLength": 5,
			"order": []
		}).DataTable();
}

init();