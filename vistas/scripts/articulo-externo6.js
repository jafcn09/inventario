var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listararticuloexterno();

	$("#formulario").on("submit",function(e)
	{
		guardaryeditararticuloexterno(e);	
	})

	//Cargamos los items al select categoria
	$.post("../ajax/articulo.php?op=selectCategoria", function(r){
		$("#idcategoria").html(r);
		$('#idcategoria').selectpicker('refresh');
	});

	//Cargamos los items al select almacen
	$.post("../ajax/articulo.php?op=selectAlmacen", function(r){
		$("#idalmacen").html(r);
		$('#idalmacen').selectpicker('refresh');
});

	$("#imagenmuestra").hide();
	$('#mControlv').addClass("treeview active");
    $('#lArticuloE').addClass("active");
}

//Función limpiar
function limpiar()
{
	$("#codigo").val("");
	$("#nombre").val("");
	$("#descripcion").val("");

	$("#medida").val("");
	$("#cubicaje").val("");
	$("#material").val("");

	$("#stock").val("");
	$("#imagenmuestra").attr("src","");
	$("#imagenactual").val("");
	$("#print").hide();
	$("#idarticulo").val("");
}

//Función mostrar formulario
function mostrarform(flag)
{
	limpiar();
	if (flag)
	{
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
	}
	else
	{
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
	}
}

//Función cancelarform
function cancelarform()
{
	limpiar();
	mostrarform(false);
}

//Función Listar
function listararticuloexterno()
{
	tabla=$('#tbllistado').dataTable(
	{
		"lengthMenu": [ 5, 10, 25, 75, 100],//mostramos el menú de registros a revisar
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
					url: '../ajax/articulo.php?op=listararticuloexterno',
					type : "get",
					dataType : "json",						
					error: function(e){
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

function guardaryeditararticuloexterno(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../ajax/articulo.php?op=guardaryeditararticuloexterno",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {                    
	          bootbox.alert(datos);	          
	          mostrarform(false);
	        //   tabla.ajax.reload();
			  setTimeout(function(){
				window.location.reload()
			  }, 2500);
	    }

	});
	limpiar();
}

function mostrararticuloexterno(idarticulo)
{
	$.post("../ajax/articulo.php?op=mostrararticuloexterno",{idarticulo : idarticulo}, function(data, status)
	{
		data = JSON.parse(data);
		console.log(data);		
		mostrarform(true);

		$("#idcategoria").val(data.idcategoria);
		$('#idcategoria').selectpicker('refresh');
		$("#idalmacen").val(data.idalmacen);
		$('#idalmacen').selectpicker('refresh');
		$("#codigo").val(data.codigo);
		$("#nombre").val(data.nombre);
		$("#stock").val(data.stock);
		$("#descripcion").val(data.descripcion);

		$("#medida").val(data.medida);
		$("#cubicaje").val(data.cubicaje);
		$("#material").val(data.material);

		$("#imagenmuestra").show();
		$("#imagenmuestra").attr("src","../files/articulos/"+data.imagen);
		$("#imagenactual").val(data.imagen);
 		$("#idarticulo").val(data.idarticulo);
 		generarbarcode();

 	})
}

//Función para desactivar registros
function desactivararticuloexterno(idarticulo)
{
	bootbox.confirm("¿Está Seguro de desactivar el artículo?", function(result){
		if(result)
        {
        	$.post("../ajax/articulo.php?op=desactivararticuloexterno", {idarticulo : idarticulo}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

//Función para activar registros
function activararticuloexterno(idarticulo)
{
	bootbox.confirm("¿Está Seguro de activar el Artículo?", function(result){
		if(result)
        {
        	$.post("../ajax/articulo.php?op=activararticuloexterno", {idarticulo : idarticulo}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

//Función para eliminar los registros
function eliminararticuloexterno(idarticulo)
{
	bootbox.confirm("¿Estás seguro de eliminar el artículo?", function(result){
		if(result)
		{
			$.post("../ajax/articulo.php?op=eliminararticuloexterno", {idarticulo : idarticulo}, function(e){
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	})
}

//función para generar el código de barras
function generarbarcode()
{
	codigo=$("#codigo").val();
	JsBarcode("#barcode", codigo);
	$("#print").show();
}

//Función para imprimir el Código de barras
function imprimir()
{
	$("#print").printArea();
}

init();