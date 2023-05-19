<?php


  $path_name = explode('/', $_SERVER['REQUEST_URI']);

  $inc_path = ['register', 'admin'];
  $inc_adrs_post = ['signup', 'signin', 'is_signin']; // post로 저달되는 주소
  $inc_adrs_get = ['signout', 'check_admin_signin', 'get_users']; // get으로 전달되는 주소

  // post path
  foreach($inc_path as $path){
    foreach($inc_adrs_post as $adrs){
      if($path_name[2] == $path && $path_name[3] == $adrs && $_SERVER['REQUEST_METHOD'] == "POST"){
        include $_SERVER['DOCUMENT_ROOT'].'/baexang_back/'.$path.'/'.$adrs.'.php';
      }
    }   
  }

  // get path
  foreach($inc_path as $path){
    foreach($inc_adrs_get as $adrs){
      if($path_name[2] == $path && $path_name[3] == $adrs && $_SERVER['REQUEST_METHOD'] == "GET"){
        include $_SERVER['DOCUMENT_ROOT'].'/baexang_back/'.$path.'/'.$adrs.'.php';
      } 
    }
  }

  if(!in_array($path_name[3], $inc_adrs_post) && !in_array($path_name[3] , $inc_adrs_get)){ // 배열에 없는 문자열이 나오면 index.php로 전달
    echo 'index.php';
  }

  

  
?>