<?php

include_once __DIR__ . "/../config.php";
include_once __DIR__ . '/../bancoDados.php';

/**
 * Verifica se está logado, e realiza o login
 *
 * @return boolean
 */
function isLogado(){
  $msgAlerta = '';
  $_SESSION['logged'] = false;

  if (isset($_POST['login'])) {
    if ($_POST['email'] == '' && $_POST['senha'] == '') {
      $msgAlerta = 'Os campos devem ser preenchidos';
      $_SESSION['logged'] = false;
    } else {
      $_SESSION['logged'] = true;
      login($_POST['email'], $_POST['senha']);
    }
  }

  if (!isset($_SESSION['email'])){
    return "<div class='row d-flex'>
    <div class='mr-auto pl-3'>
      <small>Digite seu login e senha:</small>
    </div>
    <div >
      <small class='msgLoginErro'>{$msgAlerta}</small>
    </div>
    </div>
    
    <form class='form-inline ' method='POST' action=''>
    <label class='sr-only' for='inlineFormInputName2'>E-mail</label>
    <input type='email' class='form-control mb-2 mr-sm-2' id='inlineFormInputName2' placeholder='botanicshop@email.com' name='email'>
    
    <label class='sr-only' for='inlineFormInputGroupUsername2'>Senha</label>
    <div class='input-group mb-2 mr-sm-2'>
    <input type='password' class='form-control' id='inlineFormInputGroupUsername2' placeholder='********' name='senha'>
    </div>
    
    <button type='submit' class='btn btn-green mb-2' name='login'>Login</button>
    </form>
    
    <div>
    <p class='cadastre'><a href='./cadastroUsuario.php'>Cadastrar-se</a></p>
    </div>";
  }  else {
    return "<ul class='nav'>
      <li class='nav-item'>
        <span class='nav-link'>Bem vindo!</span>
      </li>
      <li class='nav-item'>
        <a class='nav-link' href='./acoes/logout.php'>Sair</a>
      </li>
    </ul>";
  }
  

}
