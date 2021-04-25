<?php

include_once __DIR__ . '/../config.php';
include_once __DIR__  . "/../bancoDados.php";




/**
 * Realiza a publicação do comentário. Caso seja usuário logado apresenta foto e nome. Se não logado, apresenta imagem padrão e nome anônimo.
 *
 * @return void
 */
function publicarComentario(){

  $msgAlertaComentario = '';
  $idProduto = $_GET['id'];
  if (isset($_POST['publicar'])) {
    if ($_POST['comentario'] == '') {
      $msgAlertaComentario = "O campo deve conter texto.";
    } else if(!isset($_SESSION['id'])){
      postComentario($_POST['comentario'], null, $idProduto);
      
    } else {
      postComentario($_POST['comentario'], $_SESSION['id'], $idProduto);
    }
  }


return "<div class='container'>
<div class='row p-3'>
  <div class='col-7'>
    <div class='form-group '>
      <form action='' method='post'>
        <label for='exampleFormControlTextarea1 '>Deixe seu comentário</label>
        <textarea class='form-control' id='exampleFormControlTextarea1' rows='5' name='comentario'></textarea>
        <button type='submit' class='btn btn-green my-2' name='publicar'>Publicar</button> <span
          class='msgAlertaComentario'>{$msgAlertaComentario}</span>
      </form>
    </div>
  </div>
</div>
</div>
</div>
</div>";

}



