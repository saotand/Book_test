<?php
namespace Apicore\modules;
// Manejo de Excepciones
use
  \Apicore\bin\Core,
  \Jacwright\Restserver\RestException,
  \Firebase\JWT\BeforeValidException,
  \Firebase\JWT\ExpiredException,
  \Firebase\JWT\SignatureInvalidException,
  \Firebase\JWT\JWT,
  Exception,
  PDO;

class author extends Core{
  function __construct(){
    global $conexion, $lang;
    $this->data = json_decode(file_get_contents('php://input'),true,1024);
    $this->head = apache_request_headers();
    $this->auth = (!empty($this->head['Authorization']))?$this->head['Authorization']:null;
    $this->JWT = new JWT;
    // Inicio de la base de datos
    $this->db = $this->startdb();
  }

  function show($ID=NULL){
    // Tabla
    $t = 'authors';
    $w = ['ID'=> $ID];
    if($ID){
      $authors = $this->db->get($t,'*',$w);
    }else{
      $authors = $this->db->select($t,'*');
    }
    return $this->response($authors,'OK');
  }

  function add(){
    // Tabla
    $t='authors';
    // Objeto Json de datos
    $data = $this->data;
    // Filas afectadas
    $affected = null;
    // Verificamos si ya existe ese libre (proteccion mediante codigo aparte de campo unico por BBDD)
    $exist = $this->db->has($t,['name'=>$data['name']]);
    // Si no existe lo agregamops (Clase MEDOO [db])
    if($exist){
      return $this->response(null,null,"Ese Autor ya existe",406);
    }else{
      $affected = $this->db->insert($t,['ID'=>$this->uID(),'name'=>$data['name'],'description'=>$data['description']]);
    }
    // Consulta SQL con var_dump se puede ver en depuracion
    $qry = $this->db->last();
    // Capturamos errores si existen
    $err = $this->db->error();

    // Evaluamos is hay errores
    if($err[2]){
      return $this->response(null,null,$err[2],406);
    }else{
      // Si no hay errores verifica si se afectaron columnas en la BBDD
      if($affected){
        return $this->response(null,'OK');
      }else{
        return $this->response('No se realizaron cambios');
      }
    }
  }

  function edit($ID=NULL){
    // Verificamos si existe el ID para buscar el Autor a editar
    if($ID){
      // Tabla
      $t='authors';
      // Filas afectadas
      $affected = null;
      // Capturamos los datos a editar
      $data = $this->data;
      // Condicion Where de consulta SQL
      $w = ['ID'=>$ID];
      // Cargamos el Autor actual
      $actual = $this->db->get($t,'*',$w);
      // Verificamos si existe un Autor con datos iguales (incluye el Autor actual)
      $already = $this->db->get($t,'*',['name'=>$data['name']]);
if($actual){
      // Si ya hay un Autor con los datos
      if($already){
        // Si el Autor actual contiene los mismos datos que el Autor a editar
        if($actual['ID']===$already['ID']){
          return $this->response('OK',"No se realizaron cambios");
        }else{
          // Ya existe un Autor con esos datos
          return $this->response(null,null,"Ese author ya existe",406);
        }
      }else{
        // Realizamos los cambios
        $affected = $this->db->update($t,['name'=>$data['name'],'description'=>$data['description']],$w);
         // Consulta SQL con var_dump se puede ver en depuracion
        $qry = $this->db->last();
        // Capturamos errores si existen
        $err = $this->db->error();
        // Evaluamos is hay errores
        if($err[2]){
          return $this->response(null,null,$err[2],406);
        }else{
          // Si no hay errores verifica si se afectaron columnas en la BBDD
          if($affected){
            return $this->response(null,'OK :O');
          }else{
            return $this->response('No se realizaron cambios');
          }
        }
      }
    }else{
      return $this->response(null,null,"No se encuentra el autor a editar",404);
    }
    }else{
      return $this->response(null,null,"No se encuentra el autor a editar",404);
    }
  }

 function del($ID=NULL){
    if($ID){
      // Tabla
      $t='authors';
      // Filas afectadas
      $affected = null;
      // Capturamos los datos a editar
      $data = $this->data;
      // Condicion Where de consulta SQL
      $w = ['ID'=>$ID];
      // Cargamos el Autor actual
      $actual = $this->db->get($t,'*',$w);
      if($actual){
        // Eliminmos el registro
        $affected = $this->db->delete($t,$w);
        // Consulta SQL
        $qry = $this->db->last();
        // Capturamos errores si existen
        $err = $this->db->error();
        // Evaluamos is hay errores
        if($err[2]){
          return $this->response(null,null,$err[2],406);
        }else{
          // Si no hay errores verifica si se afectaron columnas en la BBDD
          if($affected){
            return $this->response(null,'OK');
          }else{
            return $this->response('No se realizaron cambios');
          }
        }
      }else{
        return $this->response(null,null,"No se encuentra el Autor a eliminar",404);
      }
    }else{
      return $this->response(null,null,"No se encuentra el Autor a eliminar",404);
    }
  }


}