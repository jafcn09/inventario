var tabla;
let num_comprobante;
let serie_comprobante;

//Función que se ejecuta al inicio
function init() {
	mostrarform(false);
	limpiar();
	listar();
	listarArticulos();

	$("#formulario").on("submit", function (e) {
		guardaryeditar(e);
	});

	//Cargamos los items al select razón social
	$.post("../ajax/remision.php?op=selectPersonas", function (r) {
		$("#razonsocial").html(r);
		$('#razonsocial').selectpicker('refresh');
	});

	$.post("../ajax/confComprobante.php?op=getNumerosSerieComprobantes", function (data) {
		var obj = JSON.parse(data);
		console.log(obj);

		num_comprobante = obj.num_serie_comprobante3.split("-")[0];
		serie_comprobante = obj.num_serie_comprobante3.split("-")[1];

		$("#num_remision").val(num_comprobante);
		$("#correlativo").val(serie_comprobante);
	});

	$('#mRemision').addClass("treeview active");
	$('#lRemision').addClass("active");
}

//Función limpiar
function limpiar() {
	$("#domicilio_partida").val("");
	$("#domicilio_llegada").val("");

	$("#num_remision").val(num_comprobante);
	$("#correlativo").val(serie_comprobante);

	$("#fecha_emision").val("");
	$("#fecha_traslado").val("");
	$("#num_documento").val("");

	$("#razonsocial").val($("#razonsocial option:first").val());
	$("#razonsocial").selectpicker('refresh');

	$("#marca").val("");
	$("#placa").val("");
	$("#certificado").val("");
	$("#licencia").val("");

	$("#total_compra").val("");
	$(".filas").remove();
	$("#total").html("0");

	//Obtenemos la fecha y hora actual
	var fecha = new Date();
	var anio = fecha.getFullYear();
	var mes = ('0' + (fecha.getMonth() + 1)).slice(-2);
	var dia = ('0' + fecha.getDate()).slice(-2);
	var hora = ('0' + fecha.getHours()).slice(-2);
	var minuto = ('0' + fecha.getMinutes()).slice(-2);
	var fechaHora = anio + '-' + mes + '-' + dia + 'T' + hora + ':' + minuto;
	$("#fecha_emision").val(fechaHora);
	$("#fecha_traslado").val(fechaHora);

	//Marcamos el primer tipo_comprobante
	$("#tipo_comprobante").val("Remision");
	$("#tipo_comprobante").selectpicker('refresh');
}

//Función mostrar formulario
function mostrarform(flag) {
	//limpiar();
	if (flag) {
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		//$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
		listarArticulos();

		$("#btnGuardar").hide();
		$("#btnCancelar").show();
		$("#btnAgregarArt").show();
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
				url: '../ajax/remision.php?op=listar',
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

//Función ListarArticulos
function listarArticulos() {
	tabla = $('#tblarticulos').DataTable({
		"aProcessing": true,
		"aServerSide": true,
		"dom": 'Bfrtip',
		"buttons": [],
		"ajax": {
			url: '../ajax/remision.php?op=listarArticulos',
			type: "GET",
			dataType: "json",
			error: function (e) {
				console.log(e.responseText);
			}
		},
		"bDestroy": true,
		"iDisplayLength": 5,
		"order": [],
		"drawCallback": function (settings) {
			// Vuelve a habilitar los botones de los artículos
			$('#tblarticulos button[data-idarticulo]').removeAttr('disabled');

			// Obtén los detalles actuales
			var detalles = getDetalles();

			// Itera sobre cada detalle y deshabilita el botón correspondiente
			for (var i = 0; i < detalles.length; i++) {
				var idarticulo = detalles[i].idarticulo;
				$('#tblarticulos button[data-idarticulo="' + idarticulo + '"]').attr('disabled', true);
			}
		}
	});
}

function getDetalles() {
	var detalles = [];
	$("#detalles tbody tr").each(function (index) {
		var detalle = {
			idarticulo: $(this).find("input[name='idarticulo[]']").val(),
			cantidad: $(this).find("input[name='cantidad[]']").val(),
			precio_venta: $(this).find("input[name='precio_venta[]']").val(),
			descuento: $(this).find("input[name='descuento[]']").val(),
			subtotal: $(this).find("span[name='subtotal']").text(),
		};
		detalles.push(detalle);
	});
	return detalles;
}

function disableButton(button) {
	button.disabled = true;
}

function guardaryeditar(e) {
	e.preventDefault(); //No se activará la acción predeterminada del evento
	//$("#btnGuardar").prop("disabled",true);
	modificarSubototales();

	// habilito los campos (para obtener su valor).
	$("#correlativo").prop("disabled", false);
	$("#num_remision").prop("disabled", false);

	var formData = new FormData($("#formulario")[0]);

	// y vuelvo a deshabilitar los campos.
	$("#correlativo").prop("disabled", true);
	$("#num_remision").prop("disabled", true);

	$("#btnGuardar").prop("disabled", true);
	$.ajax({
		url: "../ajax/remision.php?op=guardaryeditar",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,
		success: function (datos) {
			$("#btnGuardar").prop("disabled", false);
			if (datos == "El número de comprobante que ha ingresado ya existe.") {
				bootbox.alert(datos);
				return;
			}
			bootbox.alert(datos);
			limpiar();
			mostrarform(false);
			setTimeout(() => {
				location.reload();
			}, 2500);
		}
	});
}

function mostrar(idremision) {
	$("#num_remision").val("");
	$("#correlativo").val("");

	$.post("../ajax/remision.php?op=mostrar", { idremision: idremision }, function (data, status) {
		data = JSON.parse(data);
		console.log(data);
		mostrarform(true);
		
		$("#tipo_comprobante").val(data.tipo_comprobante);
		$("#tipo_comprobante").selectpicker('refresh');
		$("#tipo_documento").val(data.tipo_documento);
		$("#tipo_documento").selectpicker('refresh');
		$("#domicilio_partida").val(data.domicilio_partida);
		$("#domicilio_llegada").val(data.domicilio_llegada);

		$("#num_remision").val(data.num_remision);
		$("#correlativo").val(data.correlativo);

		$("#marca").val(data.marca);
		$("#placa").val(data.placa);
		$("#certificado").val(data.certificado);
		$("#licencia").val(data.licencia);
		$("#fecha_emision").val(data.fecha_emision);
		$("#fecha_traslado").val(data.fecha_traslado);
		$("#num_documento").val(data.num_documento);

		$("#razonsocial").val(data.razonsocial);
		$("#razonsocial").selectpicker('refresh');

		$("#idremision").val(data.idremision);

		//Ocultar y mostrar los botones
		$("#btnGuardar").hide();
		$("#btnCancelar").show();
		$("#btnAgregarArt").hide();
	});

	$.post("../ajax/remision.php?op=listarDetalle&id=" + idremision, function (r) {
		$("#detalles").html(r);
	});
}

function mostrar2(idremision) {
	$.post("../ajax/remision.php?op=mostrar", { idremision: idremision }, function (data, status) {
		data = JSON.parse(data);
		mostrarform(true);

		$("#tipo_comprobante").val(data.tipo_comprobante);
		$("#tipo_comprobante").selectpicker('refresh');
		$("#tipo_documento").val(data.tipo_documento);
		$("#tipo_documento").selectpicker('refresh');
		$("#domicilio_partida").val(data.domicilio_partida);
		$("#domicilio_llegada").val(data.domicilio_llegada);
		$("#num_remision").val(data.num_remision);
		$("#marca").val(data.marca);
		$("#placa").val(data.placa);
		$("#certificado").val(data.certificado);
		$("#licencia").val(data.licencia);
		$("#fecha_emision").val(data.fecha_emision);
		$("#fecha_traslado").val(data.fecha_traslado);
		$("#num_documento").val(data.num_documento);
		$("#razonsocial").val(data.razonsocial);

		$("#idremision").val(data.idremision);

		//Ocultar y mostrar los botones
		$("#btnGuardar").show();
		$("#btnCancelar").show();
		$("#btnAgregarArt").hide();
	});
}

//Función para activar registros
function activar(idremision) {
	bootbox.confirm("¿Está Seguro de activar la remisión?", function (result) {
		if (result) {
			$.post("../ajax/remision.php?op=activar", { idremision: idremision }, function (e) {
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	})
}

//Función para anular registros
function anular(idremision) {
	bootbox.confirm("¿Está Seguro de anular la remisión?", function (result) {
		if (result) {
			$.post("../ajax/remision.php?op=anular", { idremision: idremision }, function (e) {
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	})
}

//Función para eliminar los registros
function eliminar(idremision) {
	bootbox.confirm("¿Estás seguro de eliminar la remisión?", function (result) {
		if (result) {
			$.post("../ajax/remision.php?op=eliminar", { idremision: idremision }, function (e) {
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	})
}

//Declaración de variables necesarias para trabajar con las compras y
//sus detalles
var cont = 0;
var detalles = 0;

$("#btnGuardar").hide();

function agregarDetalle(idarticulo, articulo) {
	var cantidad = 1;
	var precio_compra = 1;

	if (idarticulo != "") {
		var subtotal = cantidad * precio_compra;
		var fila = '<tr class="filas" id="fila' + cont + '">' +
			'<td><button type="button" class="btn btn-danger" onclick="eliminarDetalle(' + cont + ', ' + idarticulo + ')">X</button></td>' +
			'<td><input type="hidden" name="idarticulo[]" value="' + idarticulo + '">' + articulo + '</td>' +
			'<td><input type="number" name="cantidad[]" id="cantidad[]" value="' + cantidad + '"></td>' +
			'<td><input type="number" step="any" name="precio_compra[]" id="precio_compra[]" value="' + precio_compra + '"></td>' +
			'<td><span name="subtotal" id="subtotal' + cont + '">' + subtotal + '</span></td>' +
			'<td><button type="button" onclick="modificarSubototales()" class="btn btn-info"><i class="fa fa-refresh"></i></button></td>' +
			'</tr>';
		cont++;
		detalles = detalles + 1;
		$('#detalles').append(fila);
		modificarSubototales();
		// aquí busco el idarticulo del botón para deshabilitarlo y volver a agregarlo.
		console.log("Deshabilito a: " + idarticulo + " =)");
	}
	else {
		alert("Error al ingresar el detalle, revisar los datos del artículo");
	}
}

function modificarSubototales() {
	var cant = document.getElementsByName("cantidad[]");
	var prec = document.getElementsByName("precio_compra[]");
	var sub = document.getElementsByName("subtotal");

	for (var i = 0; i < cant.length; i++) {
		var inpC = cant[i];
		var inpP = prec[i];
		var inpS = sub[i];

		inpS.value = inpC.value * inpP.value;
		document.getElementsByName("subtotal")[i].innerHTML = inpS.value;
	}
	calcularTotales();
}

function calcularTotales() {
	var sub = document.getElementsByName("subtotal");
	var total = 0.0;

	for (var i = 0; i < sub.length; i++) {
		total += document.getElementsByName("subtotal")[i].value;
	}
	$("#total").html(total.toFixed(2) + " Kg");
	$("#total_compra").val(total.toFixed(2) + " Kg");
	evaluar();
}

function evaluar() {
	if (detalles > 0) {
		$("#btnGuardar").show();
	}
	else {
		$("#btnGuardar").hide();
		cont = 0;
	}
}

function eliminarDetalle(indice, idarticulo) {
	$("#fila" + indice).remove();
	$('#tblarticulos button[data-idarticulo="' + idarticulo + '"]').removeAttr('disabled');
	console.log("Habilito a: " + idarticulo + " =)");
	calcularTotales();
	detalles = detalles - 1;
	evaluar()
}

init();