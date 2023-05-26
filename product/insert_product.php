<?php

  header('Access_Control-Allow-Origin: *'); // 크로스 오리진 허용
  header('Content-Type: application/json');  // 데이터 형식 json
  header('Access-Control-Allow-Methods: POST'); // 허용 메서드
  header('Access-Control-Allow-Headers: Access_Control-Allow_headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-Width');

  include $_SERVER["DOCUMENT_ROOT"].'/connect/db_conn.php';
  include_once $_SERVER["DOCUMENT_ROOT"].'/baexang_back/product/product.php';

  // echo $_POST['pr_img'], $_POST['pr_ttl'], $_POST['pr_wt_en'], $_POST['pr_wt_kr'], $_POST['pr_pri'], $_POST['pr_desc'], $_POST['pr_type'];


  $msg = [];
  $upload_dir = ''; // 사진 저장 파일

  $insert_product = new Product($db);


  // 포스트 텍스트 변수 클래스 연결
  $insert_product->pr_ttl     = $_POST['pr_ttl'];
  $insert_product->pr_wt_en   = $_POST['pr_wt_en'];
  $insert_product->pr_wt_kr   = $_POST['pr_wt_kr'];
  $insert_product->pr_pri     = $_POST['pr_pri'];
  $insert_product->pr_desc    = $_POST['pr_desc'];
  $insert_product->pr_type    = $_POST['pr_type'];

  // 테이블 이동 분개
  if($_POST['pr_type'] == 'picture'){
    $upload_dir = 'bx_pp';
  } else {

    $upload_dir = 'bx_dp';
  }

  // 이미지 파일 처리
  $ext_n_arr = explode('.', $_FILES['pr_img']['name']);
  $ext_t_arr = explode('/', $_FILES['pr_img']['tmp_name']);
  $img_t_size = $_FILES['pr_img']['size']; // 426577
  $img_n_start_name = $ext_n_arr[0]; // best-3
  $img_n_end_name = end($ext_n_arr); // png
  $img_t_end_name = end($ext_t_arr); // phpNnmeWO
  $allowed_exp = array('jpg', 'jpeg', 'png', 'gif');

  $img_f_name = $img_n_start_name.'_'.$img_t_end_name.'_'.time().'.'.$img_n_end_name;
  $insert_product->pr_img = $img_f_name; // 클래스로 보내는 최종 이미지 파일명

  // 이미지 사이즈 제한
  if($img_t_size > 3000000){ // 1MB
    $msg=['msg' => '파일 용량이 1MB를 초과했습니다.'];
  } else if(!in_array($img_n_end_name, $allowed_exp)){ // $allowed_exp 배열 안에 $img_n_end_name 문자열이 없다면 true
    $msg = ['msg' => '허용되지 않는 파일 형식입니다.'];
  } else {
    // copy 참조 https://solbel.tistory.com/1688
    // $msg = ['msg' => '상품 입력 준비 완료!!'];
    copy($_FILES['pr_img']['tmp_name'], $_SERVER['DOCUMENT_ROOT'].'/baexang_front/images/'.$upload_dir.'/'.$img_f_name);

    // 입력 성공 시 처리
    if(!$insert_product->insert_product()){
      $msg = ['msg' => '작품 입력에 실패했습니다.'];
    } else {
      $msg = ['msg' => '작품이 입력 되었습니다.'];
    }
  }

  echo json_encode($msg);


?>