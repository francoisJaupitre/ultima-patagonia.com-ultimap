<?php
if(isset($_POST['uid'])){
  include("../prm/fct.php");
  include("../prm/aut.php");
  $id_mel = $_POST['id_mel'];
  $uid = $_POST['uid'];
  $box = $_POST['box'];
  include("mel_cnx.php");
  if($_POST['act']==1){imap_clearflag_full($mbox,$uid,"\\Flagged",ST_UID);}
  else{imap_setflag_full($mbox,$uid,"\\Seen \\Flagged",ST_UID);}
}
?>
