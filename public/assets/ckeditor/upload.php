<?php

$server = $_SERVER['HTTP_HOST'];
$temp_file = explode('.',$_FILES['upload']['name']);
$extensao_imagem = end($temp_file);
$extensao_imagem = strtolower($extensao_imagem);
$nome_imagem = date('YmdHis').'.'.$extensao_imagem;
$diretorio_imagem = 'http://localhost:8080/uploads/';

move_uploaded_file($_FILES['upload']['tmp_name'], '../../uploads/'.$nome_imagem);

// Required: anonymous function reference number as explained above.
$funcNum = $_GET['CKEditorFuncNum'];
// Optional: instance name (might be used to load a specific configuration file or anything else).
$CKEditor = $_GET['CKEditor'];
// Optional: might be used to provide localized messages.
$langCode = $_GET['langCode'];

// Check the $_FILES array and save the file. Assign the correct path to a variable ($url).
//$url = "../img/" . $_FILES["upload"]["name"];
// $url = 'http://'.$server.$diretorio_imagem.$nome_imagem;
$url = $diretorio_imagem.$nome_imagem;
// Usually you will only assign something here if the file could not be uploaded.
$message = '';

echo "<script type='text/javascript'> window.parent.CKEDITOR.tools.callFunction($funcNum, '$url', '$message');</script>";
