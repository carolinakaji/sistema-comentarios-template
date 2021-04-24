<?php
include_once ('config.php');

/**
 * Responsável pela substituição das tags e retornar a página HTML
 *
 * @param string $page
 * @param array $tags
 * @return string
 */
function render($page, $tags=[]){

  $addChaves = fn($tag) => '{{' . $tag . '}}' ;
  $keys = array_map($addChaves , array_keys($tags));

  $template = file_get_contents($page);
  return str_replace($keys, $tags, $template);
}