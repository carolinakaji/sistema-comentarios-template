<?php
date_default_timezone_set('America/Sao_Paulo');
include_once __DIR__ . "/../config.php";

function abrirConnection()
{
  try {
    $connection = new PDO(db['host'], db['user'], db['pass']);
    return $connection;
  } catch (Exception $error) {
    echo "Ocorreu o seguinte erro: {$error->getMessage()}";
    exit;
  }
}
function fecharConexao()
{
  $connection = NULL;
  return $connection;
}

// CADASTRO USUÁRIO
function postUsuario($nome, $email, $cidade, $estado, $senhaSegura, $nomeTipoImagem)
{
  $sql = "insert into usuarios (nome, email, cidade, estado, senha, imagem) values (:nome, :email, :cidade, :estado, :senha, :imagem)";
  $result = abrirConnection()->prepare($sql);
  $result->bindValue(':nome', $nome);
  $result->bindValue(':email', $email);
  $result->bindValue(':cidade', $cidade);
  $result->bindValue(':estado', $estado);
  $result->bindValue(':senha', $senhaSegura);
  $result->bindValue(':imagem', $nomeTipoImagem);
  $result->execute();
  fecharConexao();

  $cadastrado = true;
  return $cadastrado;
}


// LOGAR
function login($email, $senha)
{

  $sql = "select * from usuarios";
  $result = abrirConnection()->prepare($sql);
  $result->execute();
  $usuarios = $result->fetchAll(PDO::FETCH_ASSOC);
  foreach ($usuarios as $usuario) {
    if (password_verify($senha, $usuario['senha']) && $usuario['email'] === $email) {
      
      $_SESSION['email'] = $usuario['email'];
      $_SESSION['id'] = $usuario['id'];
     // echo 'Quem logado: ' . $_SESSION['id'];
      header("location: ../index.php");

    }
  }
}

/****************** COMENTÁRIOS ******************/

// POST COMENTARIO
function postComentario($comentario, $idUsuarioLogado, $idProduto)
{
  
  $currentDateTime = date('Y-m-d H:i:s');
  $sql = "insert into comentarios (comentario, date, usuario, produto) values (:comentario, :date, :usuario, :produto)";
  $result = abrirConnection()->prepare($sql);
  $result->bindValue(':comentario', $comentario);
  $result->bindValue(':date', $currentDateTime);
  $result->bindValue(':usuario', $idUsuarioLogado);
  $result->bindValue(':produto', $idProduto);

  $result->execute();
  fecharConexao();

  header("Location: ../pages/comentariosProduto.php?id={$idProduto}");
  $alertaMensagem = "Cadastro realizado com sucesso";
}

// GET COMENTÁRIOS
function getComentariosProduto($id)
{
  $comments = '';
  $sql = "select * from 
          usuarios 
          right join comentarios on usuarios.id = comentarios.usuario";
  $result = abrirConnection()->prepare($sql);
  $result->execute();
  $usuarios = $result->fetchAll(PDO::FETCH_ASSOC);

  foreach($usuarios as $usuario){
      if($usuario['produto'] == $id){
        if($usuario['usuario'] == null){
          $usuario['nome'] = 'Anônimo';
          $usuario['imagem'] = 'anonim.jpg';
        }
      $dataEHora = dataBrasil($usuario['date']);
      $comments .="
      <div class='row'>
        <div class='col-2'>
          <img src='../src/imgs/{$usuario['imagem']}' width='80' height='80'>
        </div>
        
          <div class='col-10'>
            <h5>{$usuario['nome']} - {$dataEHora}</h5> 
          <p>{$usuario['comentario']}</p>
          <form method='post'>
            <button type='submit' class='btn btn-warning' name='editarComentario'><i class='bi bi-pencil-fill px-4'></i></button>
            <button type='submit' class='btn btn-danger ' name='deletarComentario'><i class='bi bi-trash-fill px-4'></i></button>
            </form>
          <div class='d-inline'>
          
        </div>
      </div>
        
      </div>
      <hr>";
    }
  }
  return $comments;
}

// UPDATE COMENTÁRIOS
function update($id,$comentario)
{
  $sql = "update comentarios set (comentario=:comentario) where id=:id";
  $var = abrirConnection();
  $result = $var->prepare($sql);
  $result->bindValue(':comentario', $comentario);
  $result->bindValue(':id', $id);
  $result->execute();
  fecharConexao();
}

function deleteComentario($id)
{
  $sql = "delete from comentarios where id = :id";
  $result = abrirConnection()->prepare($sql);
  $result->bindValue(':id', $id);
  $result->execute();
  fecharConexao();
}

// PRODUTOS

function getProdutos()
{
  $card = '';
  $sql = "select * from produtos";
  $result = abrirConnection()->prepare($sql);
  $result->execute();
  $produtos = $result->fetchAll(PDO::FETCH_ASSOC);

  foreach($produtos as $produto){
    $card .= "
    <div class='col-lg-4 col-md-6 col-sm-12 my-3'>
    <div class='card' style='width: 18rem;'>
      <img src='../src/imgs/{$produto['imagem']}' class='card-img-top'>
      <div class='card-body'>
        <h5 class='card-title'>{$produto['titulo']}</h5>
        <p class='card-text'>{$produto['descricao']}</p>
        <a href='../pages/comentariosProduto.php?id={$produto['id']}' class='btn btn-primary'>Comentários</a>
      </div>
    </div>
  </div>";
      
    }
  return $card;
}

function getProdutoId($id){
  $produtoSelecionado ='';
  $sql = "select * from produtos where id=:id";
  $result = abrirConnection()->prepare($sql);
  $result->bindValue(':id', $id);
  $result->execute();
  $produto = $result->fetchAll(PDO::FETCH_ASSOC);
  $produtoSelecionado ="
  <div class='row'>
    <div class='py-5'>
      <div class='text-center'><img src='../src/imgs/{$produto[0]['imagem']}'></div>
      <h2 class='text-center'>{$produto[0]['titulo']}</h2>
      <p>{$produto[0]['descricao']}</p>
    </div>
  </div>";
  return $produtoSelecionado;
}


function dataBrasil($data){
  return date('d/m/Y H:i', strtotime($data));
}

function verificaQuemEstaLogado($email)
{
  $sql = "select id, nome from usuarios where email=:email";
  $result = abrirConnection()->prepare($sql);
  $result->bindValue(':email', $email);
  $result->execute();
  $usuario = $result->fetchAll(PDO::FETCH_ASSOC);
  return $usuario[0]['nome'];
  };


