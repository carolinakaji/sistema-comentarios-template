<?php
include_once __DIR__ . '/../config.php';
include_once __DIR__  . "/../bancoDados.php";


$comentariosRegistrados = selectComments();
//var_dump($comentariosRegistrados[$_GET['id']]);

  if (isset($_GET['id'])) {
    //verificaIdComentario($id);
    deleteComentario($_GET['id']);
    echo "<script>alert('Deletado'"."{$_GET['id']})</script>";
  }


