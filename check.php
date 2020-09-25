<?php
session_start();
header("Content-type: text/html; charset=utf-8");
header('X-FRAME-OPTIONS: SAMEORIGIN');

if ($_POST['token'] != sha1(session_id()) ){
	exit();
}

function trimSpaces ($str) {
	$str = preg_replace('/^[ 　]+/u', '', $str);
	$str = preg_replace('/[ 　]+$/u', '', $str);
	return $str;
}

$errors = array();
 
if (empty($_POST)) {
	header("Location: form.php");
	exit();
} else {
	$name = isset($_POST['name']) ? $_POST['name'] : NULL;
	$mail = isset($_POST['mail']) ? $_POST['mail'] : NULL;
	$comment = isset($_POST['comment']) ? $_POST['comment'] : NULL;
	
	$name = trimSpaces($name);
	$mail = trimSpaces($mail);
	$comment = trimSpaces($comment);
 
	if ($name == '') {
		$errors['name'] = "名前が入力されていません";
	} else {
		if (mb_strlen($name) > 20) {
			$errors['name_length'] = "名前は20文字以内で入力して下さい";
		}
	}
	
	if ($mail == '') {
		$errors['mail'] = "メールが入力されていません";
	} else {
		if (!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $mail)) {
			$errors['mail_check'] = "メールアドレスの形式が正しくありません";
		}
	}
	
	if ($comment == '') {
		$errors['comment'] = "コメントが入力されていません";
	}else{
		if (mb_strlen($comment) > 200) {
			$errors['comment_length'] = "コメントは200文字以内で入力して下さい";
		}
	}
}
 
if (count($errors) === 0) {
	$_SESSION['name'] = $name;
	$_SESSION['mail'] = $mail;
	$_SESSION['comment'] = $comment;
}
 
?>
 
<!DOCTYPE html>
<html>
  <head>
    <title>お問い合わせ・確認</title>
    <meta charset="utf-8">
  </head>
  <body>
  
  <?php if (count($errors) === 0): ?>
  
    <form action="send.php" method="post">
      <input type="hidden" name="token" value="<?=$_POST['token']?>">
      
      <label>名前</label>
      <?=htmlspecialchars($name, ENT_QUOTES)?>

      <label>メールアドレス</label>
      <?=htmlspecialchars($mail, ENT_QUOTES)?>

      <?=nl2br(htmlspecialchars($comment, ENT_QUOTES))?>
      
      <input type="button" value="戻る" onClick="history.back()">
      <input type="submit" value="送信する">
    
    </form>
  
  <?php elseif(count($errors) > 0): ?>
  
    <?php
    foreach ($errors as $value) {
      echo "<p>".$value."</p>";
    }
    ?>
  
    <input type="button" value="戻る" onClick="history.back()">
  
  <?php endif; ?>
  </body>
</html>