<?php
if(isset($_POST['id_mel'])){
  include("../prm/fct.php");
  include("../prm/aut.php");
  $id_mel = $_POST['id_mel'];
  $box = $_POST['box'];
  $fol = $_POST['fol'];
  $sel_uid = $_POST['sel_uid'];
  include("mel_cnx.php");
  $emails = imap_sort($mbox, SORTDATE, 1);
}
else{$sel_uid = 0;}
if(is_array($emails)){
  foreach($emails as $email){
    $uids[] = $uid = imap_uid($mbox,$email);
    if(file_exists("../tmp/".$dir."/".$user."/mel_".$box."_".$uid.".html")){$flg_body = true;}
    else{$flg_body = false;}
    $event = "if(xhr_map != null){xhr_map.abort();} if(xhr_dt_box != null){xhr_dt_box.abort();} vue_lec(".$id_mel.",'".$box."',".$uid.");";
    $class = 'tb_box';
    if(!$flg_body){
      $class .= ' nocache';
      $event .= "";
    }
    if($uid == $sel_uid){$style = "background-color: gainsboro";}
    else{$style = "";}
?>
<table id="tb_<?php echo $uid; ?>" style="<?php echo $style; ?>" class="<?php echo $class; ?>" onclick="<?php echo $event; ?>">
<?php
    if($flg_body){include("../tmp/".$dir."/".$user."/mel_".$box."_".$uid.".html");}
?>
</table>
<?php
  }
  unset($emails,$msgs,$uids);
  if(isset($_POST['id_mel'])){
    echo '||';
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
  }
}
?>
