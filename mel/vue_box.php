<?php
if(isset($_POST['id_mel'])){
  include("../prm/fct.php");
  include("../prm/aut.php");
  $id_mel = $_POST['id_mel'];
  $box = $_POST['box'];
  $fol = $_POST['fol'];
  include("mel_cnx.php");
  unset($_POST['id_mel']);
  $emails = imap_sort($mbox, SORTDATE, 1);
  if(is_array($emails)){
?>
<input id="src_mel" type="text" placeholder="search" oninput="$('#vue_dt_box').html('');if(this.value.length>0){vue_src(<?php echo $id_mel ?>,'<?php echo $box; ?>',0);} else{vue_dt_box(<?php echo $id_mel ?>,'<?php echo $box; ?>',<?php echo $fol; ?>);}" />
<hr/>
<div id="vue_dt_box"><?php include("vue_dt_box.php"); ?></div>
<?php
    unset($msgs,$uids);
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
