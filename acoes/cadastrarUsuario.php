<?php

include_once __DIR__ . '/../config.php';
include_once __DIR__  . "/../bancoDados.php";


function cadastrar(){

return '<div class="container">
<h2 class="my-5 text-center">Preencha o formulário de cadastro</h2>
<form class="form-cadastro" method="POST" enctype="multipart/form-data">
  <div class="row">
    <div class="col-5">
      <img src="./src/imgs/cadastro-img.jpg" alt="" width="400">
    </div>
    <div class="col-7">
      <div class="row ">
        <div class="mb-3 col-8">
          <label for="nome" class="form-label">Nome</label>
          <input id="nome" type="text" class="form-control" name="nome">
        </div>
      </div>
      <div class="row">
        <div class="mb-3 col-md-8">
          <label for="email" class="form-label">E-mail</label>
          <input type="email" class="form-control" id="email" name="email">
        </div>
      </div>
      <div class="row">
        <div class="mb-3 col-6">
          <label for="cidade" class="form-label">Cidade</label>
          <input id="cidade" type="cidade" class="form-control" name="cidade">
        </div>
        <div class="mb-3 col-2">
          <label for="estado" class="form-label">UF</label>
          <input id="estado" type="text" class="form-control" name="estado">
        </div>
      </div>
      <div class="row">
        <div class="mb-3 col-6">
          <label for="exampleInputPassword1" class="form-label">Senha</label>
          <input type="password" class="form-control" name="senha">
        </div>
      </div>
      <div class="row">
        <div class="my-3 col-4">
          <input type="file" name="foto" accept="image/*">
        </div>
      </div>
      <div class="row">
        <div class="col-8 text-right m-3">
          <button type="submit" class="btn btn-green-invert" name="limparCadastro">Limpar</button>
          <button type="submit" class="btn btn-green" name="cadastrar">Cadastrar</button>
        </div>
      </div>
    </div>
  </div>
</form>
</div>';

}


$senha = isset($_POST['senha']) ? $_POST['senha'] : '';
$nome = isset($_POST['nome']) ? $_POST['nome'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$cidade = isset($_POST['cidade']) ? $_POST['cidade'] : '';
$estado = isset($_POST['estado']) ? $_POST['estado'] : '';
$senhaSegura = password_hash($senha, PASSWORD_DEFAULT);


if (isset($_POST['cadastrar'])) {

 $foto = $_FILES['foto'];

  if($foto['name']!== ''){
    $nomeImagem = md5($foto['name'] . rand(0,9999));
    $tipo = substr($foto['name'], -4);
    $nomeTipoImagem = "{$nomeImagem}{$tipo}";
    
    $imagem = $foto['tmp_name'];
    move_uploaded_file($imagem, "./src/imgs/{$nomeTipoImagem}");
    var_dump($_FILES['foto']);
  }

  var_dump($_FILES);
  postUsuario($nome, $email, $cidade, $estado, $senhaSegura, $nomeTipoImagem);
  header("Location: ./index.php");
}

if (isset($_POST['limparCadastro'])) {
  $_POST['nome'] = '';
  $_POST['email'] = '';
  $_POST['cidade'] = '';
  $_POST['estado'] = '';
  $_POST['senha'] = '';
}


