<?php

include_once __DIR__ . '/../config.php';
include_once PATH_ROOT . "/db/bancoDados.php";

$comentario = '';

if(isset($_POST['editarComentario'])){
  $comentario = verificaIdComentario($_SESSION['id']);
  //update($_SESSION['id'],'aaaa');
  //echo $_SESSION['id'] . ' id';
 // echo $_POST['comentario'] . ' comm';
  echo 'Teste editar';
}
