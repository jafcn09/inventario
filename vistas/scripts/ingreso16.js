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
	//Cargamos los items al select proveedor
	$.post("../ajax/ingreso.php?op=selectProveedor", function (r) {
		$("#idproveedor").html(r);
		$('#idproveedor').selectpicker('refresh');
	});

	$.post("../ajax/confComprobante.php?op=getNumerosSerieComprobantes", function (data) {
		var obj = JSON.parse(data);
		console.log(obj);

		num_comprobante = obj.num_serie_comprobante1.split("-")[0];
		serie_comprobante = obj.num_serie_comprobante1.split("-")[1];

		$("#num_comprobante").val(num_comprobante);
		$("#serie_comprobante").val(serie_comprobante);
	});

	$('#mCompras').addClass("treeview active");
	$('#lIngresos').addClass("active");
}

//Función limpiar
function limpiar() {
	$("#idproveedor").val($("#idproveedor option:first").val());
	$("#idproveedor").selectpicker('refresh');
	$("#proveedor").val("");
	$("#serie_comprobante").val(serie_comprobante);
	$("#num_comprobante").val(num_comprobante);
	$("#impuesto").val("0");
	$("#impuesto").selectpicker('refresh');

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
	$('#fecha_hora').val(fechaHora);

	//Marcamos el primer tipo_documento
	$("#tipo_comprobante").val("Boleta");
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
				url: '../ajax/ingreso.php?op=listar',
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
			url: '../ajax/ingreso.php?op=listarArticulos',
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

			// Y obtenemos los detalles actuales
			var detalles = getDetalles();

			// Aquí itero sobre cada detalle y deshabilita el botón correspondiente
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

//Función para guardar o editar
function guardaryeditar(e) {
	e.preventDefault(); //No se activará la acción predeterminada del evento
	//$("#btnGuardar").prop("disabled",true);
	modificarSubototales();
	// habilito los campos (para obtener su valor).
	$("#serie_comprobante").prop("disabled", false);
	$("#num_comprobante").prop("disabled", false);

	var formData = new FormData($("#formulario")[0]);

	// y vuelvo a deshabilitar los campos.
	$("#serie_comprobante").prop("disabled", true);
	$("#num_comprobante").prop("disabled", true);

	$("#btnGuardar").prop("disabled", true);
	$.ajax({
		url: "../ajax/ingreso.php?op=guardaryeditar",
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

function mostrar(idingreso) {
	$("#num_comprobante").val("");
	$("#serie_comprobante").val("");
	$.post("../ajax/ingreso.php?op=mostrar", { idingreso: idingreso }, function (data, status) {
		data = JSON.parse(data);
		mostrarform(true);

		$("#idproveedor").val(data.idproveedor);
		$("#idproveedor").selectpicker('refresh');
		$("#tipo_comprobante").val(data.tipo_comprobante);
		$("#tipo_comprobante").selectpicker('refresh');
		$("#serie_comprobante").val(data.serie_comprobante);
		$("#num_comprobante").val(data.num_comprobante);
		$("#fecha_hora").val(data.fecha);

		var impuesto = parseInt(data.impuesto);
		$("#impuesto").val(impuesto);
		$("#impuesto").selectpicker('refresh');

		$("#idingreso").val(data.idingreso);

		//Ocultar y mostrar los botones
		$("#btnGuardar").hide();
		$("#btnCancelar").show();
		$("#btnAgregarArt").hide();
	});

	$.post("../ajax/ingreso.php?op=listarDetalle&id=" + idingreso, function (r) {
		$("#detalles").html(r);
	});
}

//Función para desactivar registros
function desactivar(idingreso) {
	bootbox.confirm("¿Está Seguro de desactivar el ingreso?", function (result) {
		if (result) {
			$.post("../ajax/ingreso.php?op=desactivar", { idingreso: idingreso }, function (e) {
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	})
}

//Función para eliminar los registros
function eliminar(idingreso) {
	bootbox.confirm("¿Estás seguro de eliminar el ingreso?", function (result) {
		if (result) {
			$.post("../ajax/ingreso.php?op=eliminar", { idingreso: idingreso }, function (e) {
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	})
}

//Declaración de variables necesarias para trabajar con las compras y
//sus detalles
var impuesto = 18;
var cont = 0;
var detalles = 0;
//$("#guardar").hide();
$("#btnGuardar").hide();
$("#tipo_comprobante").change(marcarImpuesto);

function marcarImpuesto() {
	var tipo_comprobante = $("#tipo_comprobante option:selected").text();
	if (tipo_comprobante == 'Factura') {
		$("#impuesto").val(impuesto);
		$("#impuesto").selectpicker('refresh');
	}
	else {
		$("#impuesto").val("0");
		$("#impuesto").selectpicker('refresh');
	}
	modificarSubototales();
}

function agregarDetalle(idarticulo, articulo) {
	var cantidad = 1;
	var precio_compra = 1;
	var precio_venta = 1;

	if (idarticulo != "") {
		var subtotal = cantidad * precio_compra;
		var fila = '<tr class="filas" id="fila' + cont + '">' +
			'<td><button type="button" class="btn btn-danger" onclick="eliminarDetalle(' + cont + ', ' + idarticulo + ')">X</button></td>' +
			'<td><input type="hidden" name="idarticulo[]" value="' + idarticulo + '">' + articulo + '</td>' +
			'<td><input type="number" name="cantidad[]" id="cantidad[]" value="' + cantidad + '"></td>' +
			'<td><input type="number" step="any" name="precio_compra[]" id="precio_compra[]" value="' + precio_compra + '"></td>' +
			'<td><input type="number" step="any" name="precio_venta[]" value="' + precio_venta + '"></td>' +
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
	var igv = 0.0;

	for (var i = 0; i < sub.length; i++) {
		total += document.getElementsByName("subtotal")[i].value;
	}

	var impuesto = document.getElementById("impuesto").value;

	igv = impuesto == 18 ? total * 0.18 : total * 0;
	total = impuesto == 18 ? total + (total * 0.18) : total;

	$("#igv").html("S/. " + igv.toFixed(2));
	$("#total").html("S/. " + total.toFixed(2));
	$("#total_venta").val(total.toFixed(2));
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
	// con esto busco el botón del idarticulo que estoy eliminando de la tabla "#detalles" para habilitarlo nuevamente.
	$('#tblarticulos button[data-idarticulo="' + idarticulo + '"]').removeAttr('disabled');
	console.log("Habilito a: " + idarticulo + " =)");
	calcularTotales();
	detalles = detalles - 1;
	evaluar()
}

init();