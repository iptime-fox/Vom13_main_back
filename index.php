<?php


  // print_r($_SERVER['REQUEST_URI']);


  $path_name = explode('/', $_SERVER['REQUEST_URI']);
  // print_r($path_name);
  // print_r($path_name[2]);


  if($path_name[2] == 'register' && $path_name[3] == 'signup' && $_SERVER['REQUEST_METHOD'] == "POST"){
    include $_SERVER['DOCUMENT_ROOT'].'/baexang_back/register/signup.php';
  } else{
    echo 'index.php page!!';
  }

  
?>