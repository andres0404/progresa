/*!
 * Developer:
 * Luis Felipe Cáceres Bustos.
 * Uniminuto - Campus Virtual
 * Copyright(c) 2018-2022
 */



var SUPER_ADMIN = 6;
var ADMIN = 4;
var REVISOR = 2;
var VALIDADOR = 1;
var ESTUDIANTE = 0;
var hostLC = 'http://localhost/logincentral/';

function getAccess(ROL){
    bit_usuario = parseInt(usDat[3]);
    ROL = parseInt(ROL);
    //console.log("usuario: " +bit_usuario + " rol: " + ROL );
    return (bit_usuario & ROL) == 0 ? false : true;
}


var dataQuerys = new Map();




function ControllerSA(){
    // constructor
}
/*
 * DOCUMENTOS INICIO
 */

/*
 * Guardar documentos
 * @returns {undefined}
 */
ControllerSA.prototype.createDocument = function(){    
    var param = $( "#frm-documentos" ).serializeArray();    
    param.push({name: 'funcion', value: 3});
    $.ajax({
        url : '../../business/controller/class.controlador.php',
        data : param,
        type : 'POST',
        dataType : 'json',
        success : function(json) {
            if(json.ok == 1){
                $('#frm-confg-documentos').modal('hide');
                insCSA.viewDocuments();
            }
        },
        error: function(){
            alert('Error');
        }
    });
};


/*
 * Listar documentos
 * @returns {undefined}
 */

ControllerSA.prototype.viewDocuments = function(){    

    $.ajax({
        url : '../../business/controller/class.controlador.php',
        data : {funcion: 23},
        type : 'POST',
        dataType : 'json',
        success : function(json) {
            if(json.ok == 1){
                $("#list-documents").empty();
                dataQuerys.set('data-documents', json.datos);
                idCmp = "id_nombre_archivo";
                $.each(json.datos, function(k,v){
                    $('#list-documents').append('<tr>'+
                        '<td><a href="#">'+v['archivo']+'<br></a>'+v['descripcion']+'</td>'+
                        '<td style="width: 50px;"><a onclick="insCSA.setId('+v['id']+',idCmp)" class="btn btn-block btn-success" data-toggle="modal" data-target="#frm-confg-documentos">EDITAR</a></td>'+
                        '<td style="width: 50px;"><a onclick="insCSA.deleteDocuments('+v['id']+')" class="btn btn-block btn-danger">ELIMINAR</a></td>'+
                    '</tr>');
                });
            }else{
                alert(json.mensaje);
            }
        },
        error: function(){
            alert('Error');
        }
    });
};


/*
 * Listar documentos
 * @returns {undefined}
 */

ControllerSA.prototype.deleteDocuments = function(id){    

    $.ajax({
        url : '../../business/controller/class.controlador.php',
        data : {funcion: 3, borrar: 1,  id_nombre_archivo: id, nombre_archivo: '' , desc_archivo: '' },
        type : 'POST',
        dataType : 'json',
        success : function(json) {
            if(json.ok == 1){
                insCSA.viewDocuments();
            }else{
                alert(json.mensaje);
            }
        },
        error: function(){
            alert('Error');
        }
    });
};


/*
 * DOCUMENTOS FIN
 */



/*
 * Set id documentos para editar
 * @param {type} id
 * @returns {undefined}
 */

ControllerSA.prototype.setId = function(id, idCmp){    
    $( '#'+idCmp ).val(id);
    for(var i = 0; i < dataQuerys.get('data-documents').length; i++){
        if(dataQuerys.get('data-documents')[i].id == id){
            $( '#nombre_archivo' ).val(dataQuerys.get('data-documents')[i].archivo);
            $( '#desc_archivo' ).val(dataQuerys.get('data-documents')[i].descripcion);
        }
    }
};


/*
 * Limpiar formularios
 */

ControllerSA.prototype.clearForm = function(id){
    $('#'+id).trigger("reset");
};


/*
 * CONFIGURACIÓN PRÁCTICA - INICIO
 */


/*
 * Lista de documentos para seleccionar
 * @param {type} id
 * @returns {undefined}
 */

ControllerSA.prototype.getDocuments = function(id){

    $.ajax({
        url : '../../business/controller/class.controlador.php',
        data : {funcion: 23},
        type : 'POST',
        dataType : 'json',
        success : function(json) {
            if(json.ok == 1){
                $("#lista_tipo_archivos").empty();
                dataQuerys.set('data-list-documents', json.datos);
                idCmp = "id_nombre_archivo";
                $.each(json.datos, function(k,v){
                    $('#lista_tipo_archivos').append('<option value="'+v['id']+'">'+v['archivo']+'<br></a>'+v['descripcion']+'</option>');
                });
            }else{
                alert(json.mensaje);
            }
        },
        error: function(){
            alert('Error');
        }
    });

}  

/*
 * Crear configuración de práctica
 * @returns {undefined}
 */

ControllerSA.prototype.saveConfigPracticas = function(){

    $.ajax({
        url : '../../business/controller/class.controlador.php',
        data : {funcion: 5, lista_tipo_archivos:$("#lista_tipo_archivos").val(), cf_nombre:  $("#cf_nombre").val(), cf_estado: 1, cf_linea_practica:$("#cf_linea_practica").val(), id_conf_linea: $('#id_conf_linea').val() },
        type : 'POST',
        dataType : 'json',
        success : function(json) {
            if(json.ok == 1){
                $('#frm-confg-practica').modal('hide');
                insCSA.viewListPracticas();
            }else{
                alert(json.mensaje);
            }
        },
        error: function(){
            alert('Error');
        }
    });
    
};


/*
 * Crear configuración de práctica
 * @returns {undefined}
 */

ControllerSA.prototype.viewListPracticas = function(){

    $.ajax({
        url : '../../business/controller/class.controlador.php',
        data : {funcion: 25},
        type : 'POST',
        dataType : 'json',
        success : function(json) {
            if(json.ok == 1){
                $("#list-practicas").empty();
                dataQuerys.set('data-practicas', json.datos);
                $.each(json.datos, function(k,v){
                    $('#list-practicas').append('<tr>'+
                        '<td><a href="">'+v['cf_nombre']+'</a></td>'+
                        '<td style="width: 80px;"><a onclick="insCSA.viewDetailPractica('+v['id_conf_linea']+')" class="btn btn-block btn-primary" data-toggle="modal" data-target="#view-practica">VER</a></td>'+
                        '<td style="width: 80px;"><a onclick="insCSA.setIdPra('+v['id_conf_linea']+')"  class="btn btn-block btn-success" data-toggle="modal" data-target="#frm-confg-practica">EDITAR</a></td>'+
                    '</tr>');
                });
                                        
            }else{
                alert(json.mensaje);
            }
        },
        error: function(){
            alert('Error');
        }
    });
};
// onclick="insCSA.deleteDocuments('+v['id']+')"
// 
ControllerSA.prototype.viewDetailPractica = function(id){
    for(var i = 0; i < dataQuerys.get('data-practicas').length; i++){
        if(dataQuerys.get('data-practicas')[i].id_conf_linea == id){
            $('#tit-detail-practica').html(dataQuerys.get('data-practicas')[i].cf_nombre);
            $('#data-practica-config').html('LÍNEA '+dataQuerys.get('data-practicas')[i].cf_linea_practica);
            $("#list-practica-documents").empty();
            $.each(dataQuerys.get('data-practicas')[i].archivos, function(k,v){
                $('#list-practica-documents').append('<tr>'+
                    '<td><a href="#">'+v['archivo_nombre']+'<br></a>'+v['archivo_desc']+'</td>'+
                '</tr>');
            });
            return false; 
        }
    }  
};

/*
 * CONFIGURACIÓN PRÁCTICA - FIN
 */


/*
 * USUARIOS SEDE - INICIO
 */

/*
 * Crear usuarios
 * @returns {undefined}
 */
ControllerSA.prototype.createUser = function(){
    var param = $( "#frm-users" ).serializeArray();    
    param.push({name: 'funcion', value: 1},{name: 'u_tipo_usuario', value: 0},{name: 'id_rol', value: 4}, {name: 'u_password', value: $('#u_numero_docu').val()});
    
    $.ajax({
        url : '../../business/controller/class.usuarios.php',
        data :param,
        type : 'POST',
        dataType : 'json',
        success : function(json) {
            if(json.ok == 1){
                window.location.reload();
                $('#frm-confg-documentos').modal('hide');
                $('#list-admins-linea').dataTable().fnDestroy();
                insCSA.viewListUsers();
                
                
                
                //frm-confg-documentos
            }
        },
        error: function(){
            alert('Error');
        }
    });
};

/*
 * Lista de usuarios
 * @returns {undefined}
 */

ControllerSA.prototype.viewListUsers = function(){

    $.ajax({
        url : '../../business/controller/class.usuarios.php',
        data :{funcion: 10, id_rol: 4},
        type : 'POST',
        dataType : 'json',
        success : function(json) {
            
            if(json.ok == 1){
                //console.log(json);
                $("#list-documents").empty();
                dataQuerys.set('data-list-users', json.datos);
                $.each(json.datos, function(k,v){

                    $('#list-admins-linea').append('<tr>'+
                        '<td><div class="dataName">'+v['strNombres']+" "+v['strApellidos']+' </div><div class="dataId">'+v['u_id_genesis']+'</div><div class="dataId">'+v['strLineaPractica']+'</div></td>'+
                        '<td style="width: 80px;"><a onclick="insCSA.editUser('+v['id_usu_cent']+')" class="btn btn-block btn-success" data-toggle="modal" data-target="#frm-confg-practica">EDITAR</a></td>'+
                        '<td>'+v['strSede']+'</td>'+
                    '</tr>');

                }); 
                
            }
        },
        error: function(){
            alert('Error');
        }
    });
};

ControllerSA.prototype.editUser = function(id){
    $('#frm-confg-documentos').modal('show');
    console.log(id, dataQuerys.get('data-list-users').length);
    for(var i = 0; i < dataQuerys.get('data-list-users').length; i++){
        console.log(dataQuerys.get('data-list-users')[i].id_usu_cent);
        if(dataQuerys.get('data-list-users')[i].id_usu_cent == id){
            console.log(dataQuerys.get('data-list-users')[i].strNombresApellidos);
            
            $('#u_id_genesis').val(dataQuerys.get('data-list-users')[i].u_id_genesis);
            $('#id_usu_cent').val(dataQuerys.get('data-list-users')[i].id_usu_cent);
            $('#cf_linea_practica').select2().val(dataQuerys.get('data-list-users')[i].cf_linea_practica).trigger("change"); 
            $('#u_apellidos').val(dataQuerys.get('data-list-users')[i].strApellidos);
            $('#u_nombres').val(dataQuerys.get('data-list-users')[i].strNombres);
            $('#u_sede').select2().val(dataQuerys.get('data-list-users')[i].u_sede).trigger("change"); 
            $('#u_tipo_docu').select2().val(dataQuerys.get('data-list-users')[i].u_tipo_docu).trigger("change"); 
            $('#u_numero_docu').val(dataQuerys.get('data-list-users')[i].u_numero_docu);
            $('#u_correo_inst').val(dataQuerys.get('data-list-users')[i].u_correo_inst);
            $('#u_correo_pers').val(dataQuerys.get('data-list-users')[i].u_correo_pers);
            $('#u_tel_movil').val(dataQuerys.get('data-list-users')[i].u_cel_contacto);
            $('#u_tel_fijo').val(dataQuerys.get('data-list-users')[i].u_tel_contacto);
            //$('#u_sede').val(dataQuerys.get('data-list-users')[i].strSede);
            
            return false;
        }
    }
};




/*

cf_linea_practica: "1"
id_emp: null
id_rol: "4"
id_usu_cent: "156772"
id_usu_cp: "3"
nomCargo: null
nomSede: "Bogota Distancia UVD - Principal Calle 80"
nomTipoUsuario: null
strApellidos: "admin"
strIdGenesis: "1100212"
strLineaPractica: "Linea 1"
strNombres: "demo"
strRol: "ADMIN_LINEA"
strSede: "Bogota Distancia UVD - Principal Calle 80"
u_apellidos: "admin"
u_cel_contacto: "1100212"
u_correo_inst: "demo@uni.edu"
u_correo_pers: "demo@uni.edu"
u_id_genesis: "1100212"
u_nombres: "demo"
u_numero_docu: "1100212"
u_sede: "2"
u_tel_contacto: "1100212"
u_tipo_docu: "1"


*/

/*
 * USUARIOS SEDE - FIN
 */



ControllerSA.prototype.viewListLineas = function(){
    $.ajax({
        url : '../../business/controller/class.consultamt.php',
        data : {id_tabla: 7},
        type : 'POST',
        dataType : 'json',
        success : function(json) {
            $("#cf_linea_practica").empty();
            $.each(json, function(k,v){
                $('#cf_linea_practica').append('<option value="'+v['valor_valor']+'">'+v['valor_nombre']+'</option>');
            });
        },
        error: function(){
            alert('Error');
        }
    });
}

/*
 * Set id documentos para editar
 * @param {type} id
 * @returns {undefined}
 */

ControllerSA.prototype.setIdPra = function(id){    
    $( '#id_conf_linea' ).val(id);
    var ids = [];
    for(var i = 0; i < dataQuerys.get('data-practicas').length; i++){
        if(dataQuerys.get('data-practicas')[i].id_conf_linea == id){
            $('#cf_nombre').val(dataQuerys.get('data-practicas')[i].cf_nombre);
            $('#cf_linea_practica').select2().val(dataQuerys.get('data-practicas')[i].cf_linea_practica).trigger("change");  
            $.each(dataQuerys.get('data-practicas')[i].archivos, function(k,v){
                ids.push(v['archivo_id']); 
            });  
            $('#lista_tipo_archivos').select2().val(ids).trigger("change");  
        }
    }
};



ControllerSA.prototype.getSedes = function(){
    $.ajax({
        url : hostLC+'business/controller/class.MTablas.php',
        data : { m_id_tabla: 2 },
        type : 'POST',
        dataType : 'json',
        success : function(json) {
            $("#u_sede").empty();
            $.each(json.datos, function(k,v){
                $("#u_sede").append("<option value=\""+v.valor+"\">"+v.nombre+"</option>");
            });

        }
    });
};


var insCSA = new ControllerSA();

