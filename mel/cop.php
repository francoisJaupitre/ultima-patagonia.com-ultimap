<?php
if(isset($_POST['uid'])){
  include("../prm/fct.php");
  include("../prm/aut.php");
  $id_mel = $_POST['id_mel'];
  $uid = $_POST['uid'];
  $box = $_POST['box'];
//  $fol = $_POST['fol'];
  $id_mel2 = $_POST['id_mel2'];
  $box2 = $_POST['box2'];
  include("mel_cnx.php");
//  imap_mail_move($mbox,$uid,$fol,FT_UID);
//  imap_expunge($mbox);
//  unlink("../tmp/".$dir."/".$user."/mel"."_".$box."_".$uid.".html");
  $dt_mel = ftc_ass(sel_quo("*","cfg_mel","id",$id_mel2));
  $server = $dt_mel['server'];
  $port = $dt_mel['port'];
  $user = $dt_mel['user'];
  $pass = $dt_mel['pass'];
  $mbox2 = imap_open("{".$server.":".$port."}".$box2,$user,$pass);
  $header = imap_fetchheader($mbox,$uid,FT_UID);
  $body = imap_body($mbox,$uid,FT_UID);
  if(imap_append($mbox2,"{".$server.":".$port."}".$box2,$header."\r\n".$body)){echo "1";}
  else{echo "0";}
}
?>
