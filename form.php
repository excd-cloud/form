<?php
session_start();
header("Content-type: text/html; charset=utf-8");
header('X-FRAME-OPTIONS: SAMEORIGIN');
?>
 
<!DOCTYPE html>
<html>
  <head>
    <title>お問い合わせ</title>
    <meta charset="utf-8">
  </head>
  <body>
    <form action="check.php" method="post">
      <input type="hidden" name="token" value="<?=sha1(session_id())?>">

      <label>名前</label>
      <input type="text" name="name">

      <label>メールアドレス</label>
      <input type="email" name="mail">

      <textarea name="comment" rows="4" cols="40"></textarea>

      <input type="submit" value="確認する">
    </form>
  </body>
</html>