var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	});

	$('#mVisitas').addClass("treeview active");
    $('#lVisitas').addClass("active");
}

//Función limpiar
function limpiar()
{
	$("#nombres").val("");
	$("#fecha_entrada").val("");
	$("#fecha_salida").val("");
	$("#num_documento").val("");
	$("#motivo").val("");

	$(".filas").remove();

    //Marcamos el primer tipo_documento
    $("#tipo_documento").val("DNI");
	$("#tipo_documento").selectpicker('refresh');
}

//Función mostrar formulario
function mostrarform(flag)
{
	//limpiar();
	if (flag)
	{
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		//$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();

		$("#btnGuardar").show();
		$("#btnCancelar").show();
		detalles=0;
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
function listar()
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
					url: '../ajax/visitas.php?op=listar',
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

function guardaryeditar(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	//$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../ajax/visitas.php?op=guardaryeditar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {                    
	          bootbox.alert(datos);
	          mostrarform(false);
	        //   listar();
			  setTimeout(function(){
				window.location.reload()
			  }, 2500);
	    }

	});
	limpiar();
}

// idvisitas
// nombres
// fecha_entrada
// fecha_salida
// tipo_documento
// num_documento
// motivo

function mostrar(idvisitas)
{
	$.post("../ajax/visitas.php?op=mostrar",{idvisitas : idvisitas}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);
		console.log(data);

		$("#idvisitas").val(data.idvisitas);
		$("#nombres").val(data.nombres);
		$("#fecha_entrada").val(data.fecha_entrada);
		$("#fecha_salida").val(data.fecha_salida);
		$("#tipo_documento").val(data.tipo_documento);
		$("#tipo_documento").selectpicker('refresh');
		$("#num_documento").val(data.num_documento);
		$("#motivo").val(data.motivo);

		//Ocultar y mostrar los botones
		$("#btnGuardar").hide();
		$("#btnCancelar").show();
		$("#btnAgregarRms").hide();
 	});
}

//Función para anular registros
function anular(idvisitas)
{
	bootbox.confirm("¿Está Seguro de finalizar el registro de visita?", function(result){
		if(result)
        {
        	$.post("../ajax/visitas.php?op=anular", {idvisitas : idvisitas}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

//Función para eliminar los registros
function eliminar(idvisitas)
{
	bootbox.confirm("¿Estás seguro de eliminar el registro de visita?", function(result){
		if(result)
		{
			$.post("../ajax/visitas.php?op=eliminar", {idvisitas : idvisitas}, function(e){
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	})
}

init();