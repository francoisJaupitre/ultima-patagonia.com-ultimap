<?php
if(isset($_POST['uid'])){
  include("../prm/fct.php");
  include("../prm/aut.php");
  $id_mel = $_POST['id_mel'];
  $uid = $_POST['uid'];
  $box = $_POST['box'];
  include("mel_cnx.php");
  //imap_delete($mbox,$uid,FT_UID);
  imap_mail_move($mbox,$uid,'INBOX.Trash',FT_UID);
  imap_expunge($mbox);
  unlink("../tmp/".$dir."/".$user."/mel"."_".$box."_".$uid.".html");
}
?>
