<?php
include "config.php";
include "utils.php";

$dbConn=connect($db);

#listar
if ($_SERVER['REQUEST_METHOD'] == 'GET')
{
    if (isset($_GET['id']))
    {
      //Mostrar un user
      $sql = $dbConn->prepare("SELECT * FROM usuario where id=:id");
      $sql->bindValue(':id', $_GET['id']);
      $sql->execute();
      header("HTTP/1.1 200 OK");
      echo json_encode(  $sql->fetch(PDO::FETCH_ASSOC)  );
      exit();
	  }
    else {
      //Mostrar lista de users
      $sql = $dbConn->prepare("SELECT * FROM usuario");
      $sql->execute();
      $sql->setFetchMode(PDO::FETCH_ASSOC);
      header("HTTP/1.1 200 OK");
      echo json_encode( $sql->fetchAll()  );
      exit();
	}
}

#registrar un usuario
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $input = $_POST;
    $sql = "INSERT INTO usuario
          (nombre, usuario, clave, rol)
          VALUES
          (:nombre, :usuario, :clave, :rol)";
    $statement = $dbConn->prepare($sql);
    bindAllValues($statement, $input);
    $statement->execute();
    $userID = $dbConn->lastInsertId();
    if($userID)
    {
      $input['id'] = $userID;
      header("HTTP/1.1 200 OK");
      echo json_encode($input);
      exit();
	 }
}

#eliminar usuario
if ($_SERVER['REQUEST_METHOD'] == 'DELETE')
{
	$id = $_GET['id'];
  $statement = $dbConn->prepare("DELETE FROM usuario where id=:id");
  $statement->bindValue(':id', $id);
  $statement->execute();
	header("HTTP/1.1 200 OK");
	exit();
}

#actualizar
if ($_SERVER['REQUEST_METHOD'] == 'PUT')
{
    $input = $_GET;
    $userID = $input['id'];
    $fields = getParams($input);

    $sql = "
          UPDATE usuarios
          SET $fields
          WHERE id='$userID'
           ";

    $statement = $dbConn->prepare($sql);
    bindAllValues($statement, $input);

    $statement->execute();
    header("HTTP/1.1 200 OK");
    exit();
}


#si no se ha seleccionado ninguna accion
header("HTTP/1.1 400 Bad Request");
