<?php
session_start();
header("Content-type: text/html; charset=utf-8");
header('X-FRAME-OPTIONS: SAMEORIGIN');

if ($_POST['token'] != sha1(session_id()) ){
	exit();
}

if (empty($_POST)) {
	header("Location: form.php");
	exit();
}

$mailTo = 'tomohisa.masaki@excd.cloud';
$returnMail = 'tomohisa.masaki@excd.cloud';

$name = $_SESSION['name'];
$mail = $_SESSION['mail'];
$subject = "問い合わせ";
$body = $_SESSION['comment'];

mb_language('ja');
mb_internal_encoding('UTF-8');

$header = 'From: ' . mb_encode_mimeheader($name). ' <' . $mail. '>';

if (mb_send_mail($mailTo, $subject, $body, $header, '-f'. $returnMail)) {
	$_SESSION = array();
	if (isset($_COOKIE["PHPSESSID"])) {
		setcookie("PHPSESSID", '', time() - 1800, '/');
	}
 	session_destroy();
 	$status = 0;
 } else {
  $status = 1;
}
 
?>

<!DOCTYPE html>
<html>
  <head>
    <title>お問い合わせ・完了</title>
    <meta charset="utf-8">
  </head>
  <body>
  
  <?php if ($status === 0): ?>
  
    <h1>お問い合わせ　送信完了</h1>
    <p>
      お問い合わせありがとうございました。<br>
      内容を確認のうえ、回答させて頂きます。<br>
      しばらくお待ちください。
    </p>
    <a href="form.php">
      <button type="button">お問い合わせに戻る</button>
    </a>
  
  <?php elseif($status === 1): ?>
  
    <h1>お問い合わせ　送信失敗</h1>
    <p>
      お問い合わせ頂いた内容について<br>
      送信が失敗しました。<br>
      もう一度最初から入力してください。
    </p>
    <a href="form.php">
      <button type="button">お問い合わせに戻る</button>
    </a>

  <?php endif; ?>
  </body>
</html>