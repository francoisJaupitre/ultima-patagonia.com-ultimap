<?php
$request = file_get_contents("php://input");
$emailRequest = json_decode($request);
$headers[] = "MIME-Version: 1.0";
$headers[] .= "Content-type:text/html; charset=iso-8859-1";
$headers[] = "From: Ultima Patagonia <".$emailRequest->from.">";
$headers[] = "Bcc: Ultima Patagonia <".$emailRequest->bcc.">";
$res = mail($emailRequest->to,$emailRequest->subject,chunk_split(utf8_decode($emailRequest->message), 998),implode("\r\n", $headers));
if(!$res) { echo json_encode("message unsent"); }
else {
  include("../../prm/fct.php");
  include("../../prm/aut.php");
  if(isset($emailRequest->lst_srv)){
    foreach(explode('|',$emailRequest->lst_srv) as $id_srv) {
      upd_quo("dev_srv",array("res","dt_res"),array("1",date("Y-m-d")),$id_srv);
    }
    $rq_res = sel_quo("id","grp_res",array("id_grp","id_frn"),array($emailRequest->id_grp,$emailRequest->id_frn));
    if(num_rows($rq_res)==0) { insert("grp_res",array("id_grp","id_frn"),array($emailRequest->id_grp,$emailRequest->id_frn)); }
  }
  elseif(isset($emailRequest->lst_hbr)){
    foreach(explode('|',$emailRequest->lst_hbr) as $id_hbr) {
      upd_quo("dev_hbr",array("res","dt_res"),array("1",date("Y-m-d")),$id_hbr);
    }
    $rq_res = sel_quo("id","grp_res",array("id_grp","id_hbr"),array($emailRequest->id_grp,$emailRequest->id_hbr));
    if(num_rows($rq_res)==0) { insert("grp_res",array("id_grp","id_hbr"),array($emailRequest->id_grp,$emailRequest->id_hbr)); }
  }
  $id_mel = 3; //reservas@
  $box = 'INBOX.Sent';
  $message = "MIME-Version: 1.0"."\r\n";
  $message .= "Content-type:text/html; charset=iso-8859-1"."\r\n";
  $message .= "From: Ultima Patagonia <".$emailRequest->from.">"."\r\n";
  $message .= "To: <".$emailRequest->to.">"."\r\n";
  $message .= "Subject: ".$emailRequest->subject."\r\n"."\r\n";
  $message .= utf8_decode($emailRequest->message);
  include("../../mel/mel_cnx.php");
  imap_append($mbox, "{".$server.":".$port."}".$box, $message);
  imap_close($mbox);
}
?>
