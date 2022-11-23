<?php

$postagem = $_POST['postagem'];
$autor  = $_POST['autor'];
$date = date('d/m/Y H:i:s');

$linha = $postagem . ';' . $autor . ';' . $date . PHP_EOL;
 
file_put_contents('comentario.csv', $linha, FILE_APPEND);

$template       = file_get_contents('index.html');
$templateLinha  = file_get_contents('posts.html');
           
$livros   = file('comentario.csv');
$linhas   = '';
for ($i=0; $i < count($livros) ; $i++) { 
    $dadosArquivo = explode(';', $livros[$i]);
    if (isset($dadosArquivo[0]) and isset($dadosArquivo[1]) and isset($dadosArquivo[2])) {
        $postagem = $dadosArquivo[0];
        $autor    = $dadosArquivo[1];
        $date     = $dadosArquivo[2];
    } else {
        continue;
    }        

    $linha   = $templateLinha;
    $linha   = str_replace('{ID}', $i,$linha);
    $linha   = str_replace('{AUTOR}', $autor, $linha);
    $linha   = str_replace('{Postagem}', $postagem, $linha);
    $linha   = str_replace('{date}', $date, $linha);

    $linhas .= $linha;
}

$template = str_replace('{posts}', $linhas, $template);

echo $template;


