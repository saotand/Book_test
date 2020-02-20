<?php
/*****************************************************
*
*      Nucleo de API de consultas turepuesto.com
*
*****************************************************/

namespace ApiCore;
use
\Jacwright\RestServer\RestException,
\ApiCore\modules\books,
\ApiCore\modules\author;


class ApiCore extends bin\Core {

  function __construct(){
    bin\Core::__construct();
    try{
      // Registro de modulos de Backend
       $this->books = new books;
       $this->author = new author;
    }catch(PDOException $e){
      die('no se pudo conectar');
    }
  }

/**
* Main with no attributes load on server
* @noAuth
* @url GET /
*/
public function main(){
  return ['data'=>null,'message'=> 'ready on GET Request'];
}

/**
* Main with no attributes load on server
* @noAuth
* @url GET /about
*/
public function about(){
  return ['data'=>['application'=>APP,'ver'=>VER,'web'=>DEVELOPER],'message'=> 'ready'];
}

/**
* Mostrar todos los libros.
* @noAuth
* @url GET /books/
*/
public function book_show(){
  return $this->books->show();
}

/**
* Mostrar libros segun ID.
* @noAuth
* @url GET /books/$ID
*/
public function book_show_ID($ID){
  return $this->books->show($ID);
}

/**
* Añadir Libro.
* @noAuth
* @url POST /books/add
*/
public function book_add(){
  return $this->books->add();
}

/**
* Editar Libro.
* @noAuth
* @url POST /books/edit/$ID
*/
public function book_edit($ID){
  return $this->books->edit($ID);
}

/**
* Eliminar Libro.
* @noAuth
* @url POST /books/del/$ID
*/
public function book_del($ID){
  return $this->books->del($ID);
}


/**
* Mostrar Autores.
* @noAuth
* @url GET /authors
*/
public function author_show(){
  return $this->author->show();
}

/**
* Mostrar Autor segun ID.
* @noAuth
* @url GET /authors/$ID
*/
public function author_show_ID($ID){
  return $this->author->show($ID);
}

/**
* Añadir Autor.
* @noAuth
* @url POST /authors/add
*/
public function author_add(){
  return $this->author->add();
}

/**
* Editar Autor.
* @noAuth
* @url POST /authors/edit/$ID
*/
public function author_edit($ID){
  return $this->author->edit($ID);
}


/**
* Eliminar Autor.
* @noAuth
* @url POST /authors/del/$ID
*/
public function author_del($ID){
  return $this->author->del($ID);
}

}
?>
