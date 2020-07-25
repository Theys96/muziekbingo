<?php
if (isset($_POST['codeType']) && isset($_POST['code'])) {

  if (isset($_POST['captcha_code'])) {
    session_start();
    require 'lib/securimage/securimage.php';
    $securimage = new Securimage();
    if ($securimage->check($_POST['captcha_code']) == false) {
      header('location: /new?err=captcha');
      exit();
    }
  } else {
    header('location: /new?err=captcha');
    exit();
  }


  $codeType = $_POST['codeType'];
  $code = strtoupper($_POST['code']);


  if ($codeType != 'randomCode') {
    $check = checkNewCode($Db, $code, $codeType == "customCode");
    if ($check != "valid") {
      header('location: /new?err=validation');
      exit();
    }
  } else {
    $code = generateCode();
  }

  if ($admin_code = createNewCode($Db, $code)) {
    header('location: /new/' . $admin_code . "?" . $p);
  }


}
?>
