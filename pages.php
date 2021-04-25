<?php

include 'template.php';
include_once 'db/bancoDados.php';
include_once 'pages/login.php';
include_once __DIR__ . "/config.php";

function listarProdutos(){
$tags = [
  'titulo' => 'BotanicShop - Produtos',
  'header' => render('pages/header.html'),
  'login' => renderLogin(),
  'main' => render('pages/produtos.html'),
  'listaProdutos'=> getProdutos(),
  'footer' => render('pages/footer.html'),
  'nome' => 'Carol Kaji'
];

return render('pages/home.html', $tags);
}

function listarComentarioProduto(){
  $tags = [
    'titulo' => 'BotanicShop - Extratos puros',
    'header' => render('../pages/header.html'),
    'produtoDescricao' => getProdutoId($_GET['id']),
    'login' => renderLogin(),
    'main' => render('../pages/comentarios.html'),
    'listaProdutos'=> getProdutos(),
    'footer' => render('../pages/footer.html'),
    'nome' => 'Carol Kaji'
  ];
  
  return render('../pages/home.html', $tags);
  }
