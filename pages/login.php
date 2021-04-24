<?php

function renderLogin(){
  isset($_SESSION['email'])  ?  include('../prova-final/components/loginAtivo.php') : include('../prova-final/components/loginFormulario.php');
}