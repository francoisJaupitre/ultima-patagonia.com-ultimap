<?php
if(isset($_POST['src_mel'])){
  include("../prm/fct.php");
  include("../prm/aut.php");
  $emails = array();
  $id_mel = $_POST['id_mel'];
  $box = $_POST['box'];
  $sel_uid = $_POST['sel_uid'];
  $unseen = $flagged = '';
  include("mel_cnx.php");
  $msgs = imap_search($mbox,'TEXT "'.addslashes($_POST['src_mel']).'"');
  if($msgs){$emails = array_merge($emails,$msgs);}//array_reverse($msgs);// order by date?
  unset($_POST['id_mel'],$msgs,$uids);
  $msgs = imap_search($mbox,'UNSEEN');
  if(is_array($msgs)){
    foreach($msgs as $email){$uids[] = imap_uid($mbox,$email);}
  }
  if(isset($uids)){
  	$imp = implode("|",$uids);
  	$unseen .= $imp;
  }
  else{$unseen .= 0;}
  unset($msgs,$uids);
  $msgs = imap_search($mbox,'FLAGGED');
  if(is_array($msgs)){
    foreach($msgs as $email){$uids[] = imap_uid($mbox,$email);}
  }
  if(isset($uids)){
  	$imp = implode("|",$uids);
  	$flagged .= $imp;
  }
  else{$flagged .= 0;}
  if(is_array($emails)){
    if(!empty($emails)){
      $tmst = array();
      foreach($emails as $i => $email){
        $uid = imap_uid($mbox,$email);
        $overv = imap_fetch_overview($mbox,$uid,FT_UID);
        $tmst[$i] = strtotime($overv[0]->date);
      }
      array_multisort($tmst,SORT_DESC,$emails);
      unset($tmst);
      include("vue_dt_box.php");
      echo '||'.$unseen.'||'.$flagged;
    }
  }
}
?>
