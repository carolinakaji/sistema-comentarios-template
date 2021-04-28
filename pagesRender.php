<?php

include 'template.php';
include_once 'bancoDados.php';
include_once 'dinamics/login.php';
include_once 'acoes/cadastrarUsuario.php';
include_once 'acoes/publicaComentario.php';
include_once __DIR__ . "/config.php";


/**
 * Renderiza a página home com a lista de produtos
 *
 * @return string
 */
function listarProdutos(){
  $route = $_GET['url']??'home';
  $tags = [
    'titulo' => 'BotanicShop - Produtos',
    'header' => render('components/header.html'),
    'login' => isLogado(),
    'main' => render('components/produtos.html'),
    'listaProdutos' => getProdutos(),
    'footer' => render('components/footer.html'),
    'nome' => 'Carol Kaji'
  ];

  if(file_exists("pages/{$route}.html")){
    return render("pages/{$route}.html", $tags);
  } else {
    return render("pages/home.html", $tags);
  }

}
/**
 * Renderiza a página usuario com a área do usuário logada
 *
 * @return string
 */
function areaUsuario(){
  $route = $_GET['url']??'usuario';
  $tags = [
    'titulo' => 'BotanicShop - Produtos',
    'header' => render('components/header.html'),
    'login' => isLogado(),
    'main' => render('components/produtos.html'),
    'listaProdutos' => getProdutos(),
    'footer' => render('components/footer.html'),
    'nome' => 'Carol Kaji'
  ];
  if(file_exists("pages/{$route}.html")){
    return render("pages/{$route}.html", $tags);
  } else {
    return render("pages/usuario.html", $tags);
  }
}

/**
 * Renderiza a página de comentários de cada produto
 *
 * @return string
 */
function produtoComentarios(){
  $route = $_GET['url']??'comentarios';
  $tags = [
    'titulo' => 'BotanicShop - Comentários dos Produtos',
    'header' => render('components/header.html'),
    'login' => isLogado(),
    'produtoDescricao' => getProdutoId($_GET['idP']),
    'caixaComentario' => publicarComentario(),
    'listaComentarios' => getComentariosProduto($_GET['idP'],isset($_SESSION['email'])),
    'footer' => render('components/footer.html'),
    'nome' => 'Carol Kaji'
  ];
  if(file_exists("pages/{$route}.html")){
    return render("pages/{$route}.html", $tags);
  } else {
    return render('pages/comentarios.html', $tags);
  }
}

/**
 * Renderiza a página de cadastro de usuários
 *
 * @return string
 */
function cadastroUsuario(){
  $route = $_GET['url']??'cadastroUsuario';
  $tags = [
    'titulo' => 'BotanicShop - Cadastro de Usuarios',
    'header' => render('components/header.html'),
    'login' => isLogado(),
    'cadastro' => cadastrar(),
    'footer' => render('components/footer.html'),
    'nome' => 'Carol Kaji'
  ];
  if(file_exists("pages/{$route}.html")){
    return render("pages/{$route}.html", $tags);
  } else {
    return render('pages/cadastroUsuario.html', $tags);
  }
}



