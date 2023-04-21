<?php
include("../prm/fct.php");
include("../prm/aut.php");
$id_mel = $_POST['id_mel'];
$box = $_POST['box'];
include("mel_cnx.php");
$msgs = imap_search($mbox,'UNSEEN');
if(is_array($msgs)){
  foreach($msgs as $email){$uids[] = imap_uid($mbox,$email);}
}
if(isset($uids)){
	$imp = implode("|",$uids);
	echo $imp;
}
else{echo 0;}
unset($msgs,$uids);
echo '||';
$msgs = imap_search($mbox,'FLAGGED');
if(is_array($msgs)){
  foreach($msgs as $email){$uids[] = imap_uid($mbox,$email);}
}
if(isset($uids)){
	$imp = implode("|",$uids);
	echo $imp;
}
else{echo 0;}
?>
