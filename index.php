<?php


  // $path_name = explode('/', $_SERVER['REQUEST_URI']);

  $path_name = '';

  if(strpos($_SERVER['REQUEST_URI'], '?')){
    $front_path = explode('?', $_SERVER['REQUEST_URI'])[0];
    $path_name = explode('/', $front_path);
  } else {
    $path_name = explode('/', $_SERVER['REQUEST_URI']);
  }


  $inc_path = ['register', 'admin', 'product', 'cart'];
  $inc_adrs_post = ['signup', 'signin', 'is_signin', 'insert_product', 'add_cart']; // post로 저달되는 주소
  $inc_adrs_get = ['signout', 'check_admin_signin', 'get_users', 'get_products', 'get_cart']; // get으로 전달되는 주소
  $inc_adrs_put = ['update_user'];
  $inc_adrs_delete = ['delete_user', 'del_cart'];

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

  // put path
  foreach($inc_path as $path){
    foreach($inc_adrs_put as $adrs){
      if($path_name[2] == $path && $path_name[3] == $adrs && $_SERVER['REQUEST_METHOD'] == "PUT"){
        include $_SERVER['DOCUMENT_ROOT'].'/baexang_back/'.$path.'/'.$adrs.'.php';
      }
    }   
  }

  // delete path
  foreach($inc_path as $path){
    foreach($inc_adrs_delete as $adrs){
      if($path_name[2] == $path && $path_name[3] == $adrs && $_SERVER['REQUEST_METHOD'] == "DELETE"){
        include $_SERVER['DOCUMENT_ROOT'].'/baexang_back/'.$path.'/'.$adrs.'.php';
      }
    }   
  }

  if(
   !in_array($path_name[3], $inc_adrs_post) &&
   !in_array($path_name[3], $inc_adrs_get) &&
   !in_array($path_name[3], $inc_adrs_put) &&
   !in_array($path_name[3], $inc_adrs_delete)
   ){ // 배열에 없는 문자열이 나오면 index.php로 전달
    echo 'index.php';
  }

  

  
?>