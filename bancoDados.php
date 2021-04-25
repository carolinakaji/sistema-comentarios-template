<?php
date_default_timezone_set('America/Sao_Paulo');
include_once __DIR__ . "/config.php";
include_once "pagesRender.php";
include_once ('acoes/deletar.php');
session_start();

/**
 * Realiza abertura de conexão
 *
 * @return obj
 */
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

/**
 * Realiza fechamento de conexão
 *
 * @return void
 */
function fecharConexao()
{
  $connection = NULL;
  return $connection;
}

// CADASTRO USUÁRIO
/**
 * Realiza cadastro do usuário
 *
 * @param string $nome
 * @param string $email
 * @param string $cidade
 * @param string $estado
 * @param string $senhaSegura
 * @param string $nomeTipoImagem
 * @return void
 */
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

  echo '<script>alert("Postagem realizada com sucesso")</script>';
}


// LOGAR
/**
 * Realiza o login
 *
 * @param string $email
 * @param string $senha
 * @return void
 */
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
      header("location: ./usuario.php");
    } 
  }
}

/****************** COMENTÁRIOS ******************/

// POST COMENTARIO
/**
 * Cria o comentário salvando no banco de dados
 *
 * @param string $comentario
 * @param integer $idUsuarioLogado
 * @param integer $idProduto
 * @return void
 */
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
  echo '<script>alert("Postagem realizada com sucesso")</script>';
}

// GET COMENTÁRIOS
/**
 * Realiza retorno dos comentários a serem listados
 *
 * @param integer $id
 * @param boolean $logged
 * @return void
 */
function getComentariosProduto($id, $logged)
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
          <img src='./src/imgs/{$usuario['imagem']}' width='80' height='80'>
        </div>
        <div class='col-10'>
            <h5>{$usuario['nome']} - {$dataEHora}</h5> 
            <p>{$usuario['comentario']}</p> 
            " . editaDeleta($usuario['email'], $logged, $usuario['id'], $id) . "
        </div>  
      </div>
      <hr>
      ";
    }
  }
  return "<div class='container'>{$comments}</div>";
}

/**
 * Retorna os botões de editar e deletar, para o usuário logado
 *
 * @param array $userLogado
 * @param boolean $logged
 * @param integer $id
 * @param string $comentario
 * @return string
 */
function editaDeleta($userLogado, $logged, $id, $comentarioId){
  if($logged && $_SESSION['email'] === $userLogado){
    $onclick = "onclick=\"return confirm('Deseja excluir o comentário: {$id})\"";
    return "
    <div class='text-right'> 
     <a  class='btn btn-warning' name='editarComentario'><i class='bi bi-pencil-fill px-4'></i></a>
    <a  class='btn btn-danger ' href='./acoes/deletar.php?id={$id}' {$onclick}><i class='bi bi-trash-fill px-4'></i></a>
 
    </div>"
    ;
  }
}


// UPDATE COMENTÁRIOS
/**
 * Realiza a atualização do comentário
 *
 * @param integer $id
 * @param string $comentario
 * @return void
 */
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

/**
 * Realiza a exclusão do comentário
 *
 * @param integer $id
 * @return void
 */
function deleteComentario($id)
{
  $sql = "delete from comentarios where id = :id";
  $result = abrirConnection()->prepare($sql);
  $result->bindValue(':id', $id);
  $result->execute();
  fecharConexao(); 
  //header("location: /index.php");
}

/**
 * Busca todos os comentários
 *
 * @return array
 */
function selectComments(){
  $sql = "select * from comentarios";
  $result = abrirConnection()->prepare($sql);
  $result->execute();
  $comentario = $result->fetchAll(PDO::FETCH_ASSOC);
  return $comentario;
}


// PRODUTOS
/**
 * Lista os produtos apresentando os em cards com a imagem, título e descrição
 *
 * @return string
 */
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
      <img src='./src/imgs/{$produto['imagem']}' class='card-img-top'>
      <div class='card-body'>
        <h5 class='card-title'>{$produto['titulo']}</h5>
        <p class='card-text'>{$produto['descricao']}</p>
        <a href='./comentariosProduto.php?id={$produto['id']}' class='btn btn-primary'>Comentários</a>
      </div>
    </div>
  </div>";
      
    }
  return $card;
}
/**
 * Obtém o produto selecionado
 *
 * @param integer $id
 * @return string
 */
function getProdutoId($id){
  $produtoSelecionado ='';
  $sql = "select * from produtos where id=:id";
  $result = abrirConnection()->prepare($sql);
  $result->bindValue(':id', $id);
  $result->execute();
  $produto = $result->fetchAll(PDO::FETCH_ASSOC);
  $produtoSelecionado ="
  <div class='container'>
  <div class='row'>
    <div class='py-5'>
      <div class='text-center'><img src='./src/imgs/{$produto[0]['imagem']}'></div>
      <h2 class='text-center'>{$produto[0]['titulo']}</h2>
      <p>{$produto[0]['descricao']}</p>
    </div>
  </div>
  </div>";
  return $produtoSelecionado;
}

/**
 * Transforma a data para o formato desejado
 *
 * @param date $data
 * @return void
 */
function dataBrasil($data){
  return date('d/m/Y H:i', strtotime($data));
}

/**
 * Retorna o comentário pertencente ao id desejado
 *
 * @param integer $id
 * @return void
 */
function verificaIdComentario($id)
{
  $sql = "select * from comentarios where id=:id";
  $result = abrirConnection()->prepare($sql);
  $result->bindValue(':id', $id);
  $result->execute();
  $comentario = $result->fetchAll(PDO::FETCH_ASSOC);
  echo $comentario[0]['comentario'];
  return $comentario[0]['comentario'];
  };