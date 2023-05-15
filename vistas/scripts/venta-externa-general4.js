var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listarventaexternaAdmin();

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	})

	//Cargamos los items al select articulo
	$.post("../ajax/venta-externa.php?op=selectArticuloGeneral", function(r){
		$("#idarticulo").html(r);
		$('#idarticulo').selectpicker('refresh');
	});

	$("#imagenmuestra").hide();
	$('#mControlvAdmin').addClass("treeview active");
    $('#lVentasEadmin').addClass("active");
}

//Función limpiar
function limpiar()
{
    $("#idarticulo").val("");

	$("#telefono").val("");
	$("#correo").val("");
	$("#descripcion").val("");

	$("#print").hide();
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

//Función Listar todos los registros
function listarventaexternaAdmin()
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
					url: '../ajax/venta-externa.php?op=listarventaexternaAdmin',
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
	}).DataTable();
}
//Función para guardar o editar

function guardaryeditar(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../ajax/venta-externa.php?op=guardaryeditar",
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

function mostrar(idventaexterna)
{
	$.post("../ajax/venta-externa.php?op=mostrar",{idventaexterna : idventaexterna}, function(data, status)
	{
		data = JSON.parse(data);
		console.log(data);		
		mostrarform(true);

		$("#telefono").val(data.telefono);
        $("#correo").val(data.correo);
        $("#descripcion").val(data.descripcion);
        $("#idarticulo").val(data.idarticulo);
        $("#idarticulo").selectpicker('refresh');

 		$("#idventaexterna").val(data.idventaexterna);
 	})
}

//Función para eliminar los registros
function eliminar(idventaexterna)
{
	bootbox.confirm("¿Estás seguro de eliminar la venta externa?", function(result){
		if(result)
		{
			$.post("../ajax/venta-externa.php?op=eliminar", {idventaexterna : idventaexterna}, function(e){
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	})
}

//Función para desactivar registros
function desactivar(idventaexterna)
{
	bootbox.confirm("¿Está Seguro de desactivar la venta externa?", function(result){
		if(result)
        {
        	$.post("../ajax/venta-externa.php?op=desactivar", {idventaexterna : idventaexterna}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

//Función para activar registros
function activar(idventaexterna)
{
	bootbox.confirm("¿Está Seguro de activar la venta externa?", function(result){
		if(result)
        {
        	$.post("../ajax/venta-externa.php?op=activar", {idventaexterna : idventaexterna}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

//Función para imprimir el Código de barras
function imprimir()
{
	$("#print").printArea();
}

init();