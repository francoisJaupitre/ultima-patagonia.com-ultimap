<?php
$mel_id = $id_mel;
$box = '*';
$rq_cfg_mel = sel_whe("*","cfg_usr_mel","id_mel != ".$mel_id." AND id_usr=".$id_usr);
if(num_rows($rq_cfg_mel)>0){
  while($dt_cfg_mel = ftc_ass($rq_cfg_mel)){
    $id_mel = $dt_cfg_mel['id_mel'];
    include("mel_cnx.php");
    $boxes = imap_getmailboxes($mbox,"{".$server."}", "*");
    if($boxes !== false){
      asort($boxes);
      $no_list = array(
        "INBOX.Archive",
        "INBOX.Sent",
        "INBOX.Drafts",
        "INBOX.spam",
        "INBOX.Trash",
        "INBOX.Confirme&AwE-s",
        "INBOX.Confirme&AwE-s.zz_Archives",
        "INBOX.Confirme&AwE-s.zz_Archives.zz_Archives 2018-19",
        "INBOX.Devis",
        "INBOX.Devis.zz_Sans Suite"
      );
      foreach($boxes as $k => $val){
        $mapname = str_replace("{".$server."}", "", mb_convert_encoding($val->name,"utf-8","UTF7-IMAP"));
        $name = str_replace("{".$server."}", "",$val->name);
        if($mapname[0] != "." and !in_array(utf8_encode($name),$no_list)){
          if($mapname == 'INBOX'){
            $lst_mel[$id_mel] = $user;
            $map_cop[$id_mel][$mapname] = $mapname;
          }
          else{
            $nom = str_replace('.','/',substr($mapname,strpos($mapname, ".")+1));
            $map_cop[$id_mel][$mapname] = $nom;
          }

          /*while(!is_bool(strpos($txt, "."))){
            $fld = substr($txt,0,strpos($txt,"."));
            if(!in_array($fld,$fol)){$fol[$id_mel][] = $fld;}
            $txt = substr($txt, strpos($txt,".")+1);
          }*/
        //  $fol[$id_mel][] = $txt;
        }
      }
    }
    imap_close($mbox);
  }
}
$id_mel = $mel_id;
?>
