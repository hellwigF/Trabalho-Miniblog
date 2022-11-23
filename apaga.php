<?php

$index  = $_POST['index'];

if ($index >= 0) {

    // leio todos os livros para um array
    $livros = file('comentario.csv');

    // percorro o array procurando pelo item a ser apagado
    for ($i = 0; $i < count($livros); $i++) {
        if (intval($index) === $i) {
            // destroi o livro na memoria
            unset($livros[$i]);
            break;
        }
    }
    
    // preciso atualizar o arquivo biblioteca.csv
    $livrosAtualizados = '';
    for ($i = 0; $i <= count($livros); $i++) {
        if (isset($livros[$i])) {
            $livrosAtualizados .= $livros[$i];
        }        
    }

    file_put_contents('comentario.csv', $livrosAtualizados);

    // le o arquivo lista-livros.html 
    $template       = file_get_contents('INDEX.html');
    $templateLinha  = file_get_contents('posts.html');

    // ler o arquivo de biblioteca.csv
    $livros   = file('comentario.csv');

    $linhas   = '';
    for ($i = 0; $i < count($livros); $i++) {
        $dadosArquivo = explode(';', $livros[$i]);
        if (isset($dadosArquivo[0]) and isset($dadosArquivo[1]) and isset($dadosArquivo[2])) {
            $postagem  = $dadosArquivo[0];
            $autor   = $dadosArquivo[1];
            $date    = $dadosArquivo[2];
        } else {
            continue;
        }
        
        $linha   = $templateLinha;
        $linha   = str_replace('{date}', $i, $linha);
        $linha   = str_replace('{AUTOR}', $autor, $linha);
        $linha   = str_replace('{Postagem}', $postagem, $linha);

        $linhas .= $linha;
    }

    $template = str_replace('{posts}', $linhas, $template);

    // escreve o template como resposta
    echo $template;
}
