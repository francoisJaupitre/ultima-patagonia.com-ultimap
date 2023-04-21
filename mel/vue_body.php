<?php
if(isset($_POST['uid'])){
  include("../prm/fct.php");
  include("../prm/aut.php");
  $id_mel = $_POST['id_mel'];
  $uid = $_POST['uid'];
  $box = $_POST['box'];
  include("mel_cnx.php");
  unset($_POST);
}
$overv = imap_fetch_overview($mbox,$uid,FT_UID);
$overv = $overv[0];
$seen = $overv->seen;
$tmst = strtotime($overv->date);
$from = str_replace('"',"",(iconv_mime_decode($overv->from)));
$subj = iconv_mime_decode($overv->subject);
$date = date("d/m/Y", $tmst);
include_once("mel_fct.php");
if($seen){
  getmsg($mbox,$uid);
  $ok_encode = mb_check_encoding($plainmsg,$charset);
  if(strtoupper($charset)=='UTF-8' and $ok_encode){$body = imap_utf8(strip_tags($plainmsg));}
  elseif(strtoupper($charset)=='US-ASCII'){$body = html_entity_decode(strip_tags($plainmsg));}
  else{$body = html_entity_decode(utf8_encode($plainmsg));}
}
ob_start();
?>
<tr>
  <td style="width: 15px; vertical-align: top; text-align: center;" rowspan="3">
    <div id="seen<?php echo $uid; ?>" style="display: none"><?php echo '&#128309;'; ?></div>
    <div id="flag<?php echo $uid; ?>" style="display: none"><img src="../prm/img/flg.png" /></div>
  </td>
  <td>
      <div class="frpl"><?php echo $date; ?></div>
      <div class="wsn fwb dboxh"><?php echo $from; ?></div>
  </td>
</tr>
<tr>
  <td><?php echo $subj; ?></td>
</tr>
<tr>
  <td>
    <div class="hoh"><?php echo substr($body,0,200); ?></div>
  </td>
</tr>
<?php
$html = ob_get_contents();
ob_end_flush();
if(!is_dir("../tmp/".$dir."/".$user)){mkdir("../tmp/".$dir."/".$user);}
$fp = @fopen("../tmp/".$dir."/".$user."/mel"."_".$box."_".$uid.".html", "w");
if($fp){
	fwrite($fp, $html);
	fclose($fp);
}
?>
