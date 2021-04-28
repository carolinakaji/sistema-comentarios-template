<?php
include_once __DIR__ . '/../config.php';
include_once __DIR__  . "/../bancoDados.php";


$comentariosRegistrados = selectComments();

  if (isset($_GET['id'])) {
    deleteComentario($_GET['id']);
    echo "<script>alert('Deletado'"."{$_GET['id']})</script>";
    header("location: ../comentariosProduto.php?idP={$_GET['idP']}");
  }


