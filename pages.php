<?php

include 'template.php';
include_once 'db/bancoDados.php';
include_once 'pages/login.php';


function listarProdutos(){
$tags = [
  'header' => render('pages/header.html'),
  'titulo' => 'BotanicShop - Produtos',
  'login' => renderLogin(),
  'main' => render('pages/produtos.html'),
  'listaProdutos'=>getProdutos(),
  'footer' => render('pages/footer.html'),
  'nome' => 'Carol Kaji'
];

return render('pages/home.html', $tags);
}
