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

class books extends Core{
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
    $t = 'books';
    $w = ['ID'=> $ID];
    if($ID){
      $books = $this->db->get($t,'*',$w);
    }else{
      $books = $this->db->select($t,'*');
    }
    return $this->response($books,'OK');
  }

  function add(){
    // Tabla
    $t='books';
    // Objeto Json de datos
    $data = $this->data;
    // Filas afectadas
    $affected = null;
    // Verificamos si ya existe ese libre (proteccion mediante codigo aparte de campo unico por BBDD)
    $exist = $this->db->has($t,['title'=>$data['title']]);
    // Si no existe lo agregamops (Clase MEDOO [db])
    if($exist){
      return $this->response(null,null,"Ese libro ya existe",406);
    }else{
      $affected = $this->db->insert($t,['ID'=>$this->uID(),'title'=>$data['title'],'author'=>$data['author'],'pages'=>$data['pages']?$data['pages']:'0']);
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
    // Verificamos si existe el ID para buscar el libre a editar
    if($ID){
      // Tabla
      $t='books';
      // Filas afectadas
      $affected = null;
      // Capturamos los datos a editar
      $data = $this->data;
      // Condicion Where de consulta SQL
      $w = ['ID'=>$ID];
      // Cargamos el libro actual
      $actualbook = $this->db->get($t,'*',$w);
      // Verificamos si existe un libro con datos iguales (incluye el libro actual)
      $already = $this->db->get($t,'*',['title'=>$data['title']]);

      if($actualbook){
        // Si ya hay un libro con los datos
        if($already){
          // Si el libro actual contiene los mismos datos que el libro a editar
          if($actualbook['ID']===$already['ID']){
            return $this->response('OK',"No se realizaron cambios");
          }else{
            // Ya existe un libro con esos datos
            return $this->response(null,null,"Ese libro ya existe",406);
          }
        }else{
          // Realizamos los cambios
          $affected = $this->db->update($t,['title'=>$data['title'],'pages'=>$data['pages'],'author'=>$data['author']],$w);
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
      }else{
        return $this->response(null,null,"No se encuentra el libro a editar",404);
      }
    }else{
      return $this->response(null,null,"No se encuentra el libro a editar",404);
    }
  }

  function del($ID=NULL){
    if($ID){
      // Tabla
      $t='books';
      // Filas afectadas
      $affected = null;
      // Capturamos los datos a editar
      $data = $this->data;
      // Condicion Where de consulta SQL
      $w = ['ID'=>$ID];
      // Cargamos el libro actual
      $actualbook = $this->db->get($t,'*',$w);
      if($actualbook){
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
        return $this->response(null,null,"No se encuentra el libro a eliminar",404);
      }
    }else{
      return $this->response(null,null,"No se encuentra el libro a eliminar",404);
    }
  }
}