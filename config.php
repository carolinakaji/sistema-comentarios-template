<?php

const PATH_ROOT = __DIR__;
const URL = "http://localhost/ds1/prova/projeto-final";

// Banco de dados Local
const db = [
  'host' => 'mysql:host=localhost;port=3306;dbname=cadastroComentario',
  'user' => 'root',
  'pass' => ''
];

// Banco de dados AWS
// const db = [
//   'host' => 'mysql:host=cadastrocomentario.ce5egeagt469.us-east-1.rds.amazonaws.com;port=3306;dbname=cadastroComentario',
//   'user' => 'root',
//   'pass' => 'fatec12345678'
// ];