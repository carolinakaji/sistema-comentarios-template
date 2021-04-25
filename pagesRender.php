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
  $tags = [
    'titulo' => 'BotanicShop - Produtos',
    'header' => render('components/header.html'),
    'login' => isLogado(),
    'main' => render('components/produtos.html'),
    'listaProdutos' => getProdutos(),
    'footer' => render('components/footer.html'),
    'nome' => 'Carol Kaji'
  ];

return render('pages/home.html', $tags);
}
/**
 * Renderiza a página usuario com a área do usuário logada
 *
 * @return string
 */
function areaUsuario(){
  $tags = [
    'titulo' => 'BotanicShop - Produtos',
    'header' => render('components/header.html'),
    'login' => isLogado(),
    'main' => render('components/produtos.html'),
    'listaProdutos' => getProdutos(),
    'footer' => render('components/footer.html'),
    'nome' => 'Carol Kaji'
  ];

return render('pages/usuario.html', $tags);
}

/**
 * Renderiza a página de comentários de cada produto
 *
 * @return string
 */
function produtoComentarios(){
  $tags = [
    'titulo' => 'BotanicShop - Comentários dos Produtos',
    'header' => render('components/header.html'),
    'login' => isLogado(),
    'produtoDescricao' => getProdutoId($_GET['id']),
    'caixaComentario' => publicarComentario(),
    'listaComentarios' => getComentariosProduto($_GET['id'],isset($_SESSION['email'])),
    'footer' => render('components/footer.html'),
    'nome' => 'Carol Kaji'
  ];

return render('pages/comentarios.html', $tags);
}

/**
 * Renderiza a página de cadastro de usuários
 *
 * @return string
 */
function cadastroUsuario(){
  $tags = [
    'titulo' => 'BotanicShop - Cadastro de Usuarios',
    'header' => render('components/header.html'),
    'login' => isLogado(),
    'cadastro' => cadastrar(),
    'footer' => render('components/footer.html'),
    'nome' => 'Carol Kaji'
  ];

return render('pages/cadastroUsuario.html', $tags);
}



