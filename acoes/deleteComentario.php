<?php

include_once __DIR__ . '/../config.php';
include_once PATH_ROOT . "/db/bancoDados.php";


if(isset($_POST['deletarComentario'])){
  deleteComentario($usuario['id']);

  echo $_GET['id'];
  //header('Location: ../comentariosProduto.php');
}
