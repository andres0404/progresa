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
 * USUARIOS SEDE - INICIO
 */

/*
 * Crear usuarios
 * @returns {undefined}
 */
ControllerSA.prototype.createUser = function(){
    var param = $( "#frm-users" ).serializeArray();    
    param.push({name: 'funcion', value: 1},{name: 'u_tipo_usuario', value: 0}, {name: 'id_rol', value: 3}, {name: 'u_password', value: $('#u_numero_docu').val()}, {name: 'u_sede', value: userData[0]}, {name: 'cf_linea_practica', value: userData[1]});
    
    $.ajax({
        url : '../../business/controller/class.usuarios.php',
        data :param,
        type : 'POST',
        dataType : 'json',
        success : function(json) {
            if(json.ok == 1){
                window.location.reload();
                $('#form-usuario').modal('hide');
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
        data :{funcion: 10, id_rol: 3},
        type : 'POST',
        dataType : 'json',
        success : function(json) {
            
            if(json.ok == 1){
                //console.log(json);
                $("#list-coordinadores").empty();
                dataQuerys.set('data-list-users', json.datos);
                $.each(json.datos, function(k,v){
                    var td = null;
                    if(v['u_tipo_docu'] == 1){td = 'TI'}else if(v['u_tipo_docu'] == 2){td = 'CC'}else if(v['u_tipo_docu'] == 3){td = 'CE'}
            
                    $('#list-coordinadores').append('<tr>'+
                        '<td>'+v['u_id_genesis']+'</td>'+
                        '<td>'+v['strNombres']+'</td>'+ 
                        '<td>'+v['strApellidos']+'</td>'+ 
                        '<td>'+td+'</td> '+
                        '<td>'+v['u_numero_docu']+'</td> '+
                        '<td>'+v['u_correo_inst']+'</td>'+ 
                        '<td>'+v['u_correo_pers']+'</td>'+ 
                        '<td>'+v['nomSede']+'</td>'+
                        '<td><a class="btn btn-info margin"><i class="fa fa-fw fa-edit"></i></a>'+
                            '<a class="btn btn-danger margin"><i class="fa fa-fw fa-trash"></i></a>'+
                        '</td>'+
                    '</tr>');

                }); 
                
            }
        },
        error: function(){
            alert('Error');
        }
    });
};



/*
 * Get Facultades
 * @returns {undefined}
 */

ControllerSA.prototype.getFacultades = function(){
    $.ajax({
        url : hostLC+'business/controller/class.MTablas.php',
        data : { m_id_tabla: 9 },
        type : 'POST',
        dataType : 'json',
        success : function(json) {
            $("#id_facultad").empty();
            $.each(json.datos, function(k,v){
                $("#id_facultad").append("<option value=\""+v.valor+"\">"+v.nombre+"</option>");
            });

        }
    });
};

/*
 * Get programas
 * @returns {undefined}
 */

ControllerSA.prototype.getProgramas = function(){
    $.ajax({
        url : hostLC+'business/controller/class.MTablas.php',
        data : { m_id_tabla: 1 },
        type : 'POST',
        dataType : 'json',
        success : function(json) {
            $("#id_programa").empty();
            $.each(json.datos, function(k,v){
                $("#id_programa").append("<option value=\""+v.valor+"\">"+v.nombre+"</option>");
            });

        }
    });
};

/*
 * Get plantillas
 * @returns {undefined}
 */

ControllerSA.prototype.getPlantillas = function(){
    $.ajax({
        url : '../../business/controller/class.controlador.php',
        data : { funcion: 25, cf_linea_practica: userData[1] },
        type : 'POST',
        dataType : 'json',
        success : function(json) {
            $("#id_conf_linea").empty();
            $.each(json.datos, function(k,v){
                $("#id_conf_linea").append("<option value=\""+v.id_conf_linea+"\">"+v.cf_nombre+"</option>");
            });

        }
    });
};

/*
 * get coordinadores
 * @returns {undefined}
 */

ControllerSA.prototype.getCoordinadores = function(){

    $.ajax({
        url : '../../business/controller/class.usuarios.php',
        data :{funcion: 10, id_rol: 3},
        type : 'POST',
        dataType : 'json',
        success : function(json) {
            
            if(json.ok == 1){
                //console.log(json);
                $("#id_usu_cp").empty();
                $.each(json.datos, function(k,v){
                    $("#id_usu_cp").append("<option value=\""+v.id_usu_cp+"\">"+v.u_nombres+" "+v.u_apellidos+"</option>");
                }); 
                
            }
        },
        error: function(){
            alert('Error');
        }
    });
};

/*
 * Crear la práctica
 * @returns {undefined}
*/

ControllerSA.prototype.createPractica = function(){
    var param = $( "#frm-create-practica" ).serializeArray();    
    param.push({name: 'funcion', value: 1});
    var a = JSON.stringify($('#id_programa').val());
    console.log('------', typeof $('#id_programa').val());
    console.log('------', a);
    $.ajax({
        url : '../../business/controller/class.controlador.php',
        data : param,
        data : {funcion: 1, id_linea:$("#id_linea").val(), ln_titulo:  $("#ln_titulo").val(), ln_desc: $("#ln_desc").val(), id_facultad:$("#id_facultad").val(), id_programa: $('#id_programa').val(), id_usu_cp: $('#id_usu_cp').val(), id_conf_linea: $('#id_conf_linea').val() },
        type : 'POST',
        dataType : 'json',
        success : function(json) {
            if(json.ok == 1){
                $('#frm-practica').modal('hide');
                insCSA.viewPracticas();
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
 * View práctica
 * @returns {undefined}
 */

ControllerSA.prototype.viewPracticas = function(){

    $.ajax({
        url : '../../business/controller/class.controlador.php',
        data : {funcion: 21},
        type : 'POST',
        dataType : 'json',
        success : function(json) {
            if(json.ok == 1){
                $("#list-practicas-config").empty();
                dataQuerys.set('data-practicas-config', json.datos);
                
               
                $.each(json.datos, function(k,v){
                    var fac = "";
                    var pro = "";
                    v.strPrograma = JSON.parse(v.strPrograma );
                    v.strFacultad = JSON.parse(v.strFacultad );
                    
                    for(var i = 0; i < v.strFacultad.length; i++){
                        for (var key in v.strFacultad[i]) {
                            if(fac == ''){
                                fac = fac+v.strFacultad[i][key];
                            }else{
                                fac = fac+', '+v.strFacultad[i][key];
                            }
                        }                 
                    }
                    
                    for(var j = 0; j < v.strPrograma.length; j++){
                        for (var key in v.strPrograma[j]) {
                            if(pro == ''){
                                pro = pro+v.strPrograma[j][key];
                            }else{
                                pro = pro+', '+v.strPrograma[j][key];
                            }
                        }                 
                    }
   
                    $('#list-practicas-config').append('<tr>'+
                        '<td>'+v.ln_titulo+'</td>'+
                        '<td>'+v.ln_desc+'</td>'+
                        '<td>'+fac+'</td>'+
                        '<td>'+pro+'</td>'+
                        '<td>'+v.strConfLineaNombre+'</td>'+
                        '<td>'+v.strUsuNombre+'</td>'+
                        '<td><a class="btn btn-info margin"><i class="fa fa-fw fa-edit"></i></a>'+
                            '<a class="btn btn-danger margin"><i class="fa fa-fw fa-trash"></i></a>'+
                        '</td>'+
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


 

var insCSA = new ControllerSA();

