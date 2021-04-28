<?php
include_once __DIR__ . '/../config.php';
include_once __DIR__  . "/../bancoDados.php";


  if (isset($_GET['id'])) {
    echo 'entrou';
    $comentarioTexto = verificaIdComentario($_GET['id']);
echo $comentarioTexto;
    //updateComentario($_GET['id'], 'comenteiii');
    echo "<script>alert('Editado com sucesso'})</script>";
    //header("location: ../comentariosProduto.php?idP={$_GET['idP']}");
  }


