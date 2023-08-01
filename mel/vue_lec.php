<?php
if(isset($_POST['uid'])){
  include("../prm/fct.php");
  include("../prm/aut.php");
  $id_mel = $_POST['id_mel'];
  include("lst_mov.php");
  include("lst_cop.php");
  $uid = $_POST['uid'];
  $box = $_POST['box'];
  if($id_mel>0 and $uid>0){include("mel_cnx.php");}
}
else{$uid = $uids[0];}
if(isset($uid) and $uid>0){
  $overv = imap_fetch_overview($mbox,$uid,FT_UID);
  $overv = $overv[0];
  $flag = $overv->flagged;
  $seen = $overv->seen;
  $tmst = strtotime($overv->date);
  $from = str_replace('"',"",(iconv_mime_decode($overv->from)));
  $subj = iconv_mime_decode($overv->subject);
  include_once("mel_fct.php");
  getmsg($mbox,$uid);
  if(strlen($htmlmsg)>0){$body = $htmlmsg;}
  else{$body = nl2br($plainmsg);}
  if(strtoupper($charset)=='UTF-8'){$body = imap_utf8($body);}
  elseif(strtoupper($charset)=='US-ASCII'){$body = html_entity_decode($body);}
  else{$body = html_entity_decode(utf8_encode($body));}
  $body = str_replace(array("<html>","</html>"),"",$body);
  $body = str_replace("href=","target='blank' href=",$body);
  $date = date("d/m/Y H:i", $tmst);
  $hText = imap_fetchbody($mbox, $uid, '0', FT_UID);
  $header = imap_rfc822_parse_headers($hText);
  $addr = $header->from[0]->mailbox."@".$header->from[0]->host;
  mb_internal_encoding('UTF-8');
  foreach($attachments as $attname => $attachment){file_put_contents("../tmp/".$dir."/".str_replace("_"," ", mb_decode_mimeheader($attname)), $attachment);}
  $dom = new DOMDocument;
  $dom->loadHTML($body);
  $xp = new DOMXpath($dom);
  $nodes = $xp->query('//input[@name="ultimap"]');
  $node = $nodes->item(0);
  if(isset($node)) {$new_dev = $node->getAttribute('value');}
  $dom = new DOMDocument;
  $dom->loadHTML('<?xml encoding="utf-8" ?>'.$body);
  $xp = new DOMXpath($dom);
  preg_match_all('/src="cid:(.*)"/Uims', $body, $matches);
  if(count($matches)) {
    $search = array();
    $replace = array();
    foreach($matches[0] as $match){
      $filename = substr($match,9,-1);
      $pos = strpos($filename, '@');
      $attname = substr($filename,0,$pos);
      if(isset($attachments[$attname])){
        file_put_contents("../tmp/".$dir."/".str_replace("_"," ", mb_decode_mimeheader($filename)), $attachments[$attname]);
        $search[] = $match;
        $replace[] = 'src="'.str_replace("_"," ", mb_decode_mimeheader($filename)).'"';
      }
      else{
        foreach($dom->getElementsByTagName('img') as $img){
          if($img->getAttribute('src') == substr($match,5,-1)){
            $attname = $img->getAttribute('alt');
            if(isset($attachments[$attname])){
              file_put_contents("../tmp/".$dir."/".str_replace("_"," ", mb_decode_mimeheader($attname)), $attachments[$attname]);
              $search[] = $match;
              $replace[] = 'src="'.str_replace("_"," ", mb_decode_mimeheader($attname)).'"';
            }
            else{
              //can't match attachmenet with outlook image $filename = substr($match,9,-1);
            }
          }
        }
      }
    }
    $body = str_replace($search, $replace, $body);
    $dom = new DOMDocument;
    $dom->loadHTML('<?xml encoding="utf-8" ?>'.$body);

  //print_r($search);
  //print_r($replace);
  }
  preg_match_all('/alt="cid:(.*)"/Uims', $body, $matches);
  if(count($matches) and !empty($matches[0])){
    foreach($matches[0] as $match){
      $filename = substr($match,9,-1);
      $pos = strpos($filename, '@');
      $attname = substr($filename,0,$pos);
      file_put_contents("../tmp/".$dir."/".str_replace("_"," ", mb_decode_mimeheader($filename)), $attachments[$attname]);
      foreach($dom->getElementsByTagName('img') as $img){
        if(!file_exists($img->getAttribute('src'))){//remplacer par: sauver les <img > avant et apres modif pour faire une str_replace et ne pas utiliser saveHTML(); -> inutile puisque iframe???
          $alt = $img->getAttribute('alt');
          if(strstr($alt,substr($match,5,-1))){$img->setAttribute('src',"$filename");}
        }
      }
    }
  }
  preg_match_all('/id="cid:(.*)"/Uims', $body, $matches);
  if(count($matches) and !empty($matches[0])){
    $matches[0] = array_unique($matches[0]);
    foreach($matches[0] as $match){
      $id = substr($match,4,-1);
      $node = $dom->getElementById($id);
      $children = $node->childNodes;
      foreach ($children as $child) {
        $innerHTML = $child->ownerDocument->saveXML($child);
        $attnames = array_keys($attachments);
        foreach ($attnames as $attname){
          $a = html_entity_decode($innerHTML);
          $a = substr($a,strrpos($a," "));
          $b = substr($attname,strrpos($attname," ")+1);
          if(strstr($a,$b)){
            file_put_contents("../tmp/".$dir."/".str_replace("_"," ", mb_decode_mimeheader($attname)), $attachments[$attname]);
            $newnode = $dom->createElement("img");
            $src = str_replace("_"," ", mb_decode_mimeheader($attname));
            $newnode->setAttribute('src', $src);
            $node->parentNode->appendChild($newnode);
            $node->parentNode->removeChild($node);
          }
        }
      }
    }
  }
  $html = $dom->saveHTML();
  $file = "../tmp/".$dir."/mel.html";
  file_put_contents($file, $html);
  $body = nl2br($plainmsg); //trop long à charger pour outlook
  $html = '<br/><hr/>'.date('j M Y', $tmst).', '.date('h:i', $tmst).', '.$from.' '.$addr.':<br/><br/>'.$body;
  $file = "../tmp/".$dir."/body.html";
  file_put_contents($file, $html);
?>
<div id="drag2" class="drag"></div>
<div class="t2m3bp">
  <div class="div_acc">
    <table>
      <tr>
        <td>
          <div class="frpl"><?php echo $date; ?></div>
          <div class="wsn fwb dboh">
<?php
  if(!$seen){echo '&#128309; ';}
  echo $from.' <'.$addr.'>';
?>
            <span id="flag_dt" style="<?php if(!$flag){echo 'display: none';} ?>"><img src="../prm/img/flg-mini.png" /></span>
          </div>
        </td>
      </tr>
      <tr>
        <td><?php echo $subj; ?><hr /></td>
      </tr>
      <tr>
        <td>
          <span onclick="vue_cmd('vue_rsp');">
        <!--COMMANDES-->
            <button><img src="../prm/img/rsp.png" /></button>
            <div id="vue_rsp" class="cmd wsn">
              <ul>
                <li onclick="window.open('mel2.php?act=re&melfr=<?php echo $mel_usr ?>&melto=<?php echo $addr ?>&subj=<?php echo urlencode($subj) ?>&bccrt=<?php echo $user ?>&from=<?php echo urlencode($from) ?>');">REPONDRE</li>
                <li onclick="window.open('mel2.php?act=re&melfr=<?php echo $mel_usr ?>&melto=<?php echo $addr ?>&subj=<?php echo urlencode($subj) ?>&bccrt=<?php echo $user ?>&from=<?php echo urlencode($from) ?>&atxt=pay');">REPONDRE (PAIEMENT)</li>
                <li onclick="window.open('mel2.php?act=rv&melfr=<?php echo $mel_usr ?>&subj=<?php echo urlencode($subj) ?>&bccrt=<?php echo $user ?>&from=<?php echo urlencode($from) ?>');">RENVOYER</li>
<?php
  if(count($attachments)>0){
    $att_lst .= '';
    foreach($attachments as $attname => $attachment) {$att_lst .= $attname.'|';}
    $att_lst = substr($att_lst,0,-1);
?>
                <li onclick="window.open('mel2.php?act=rv&melfr=<?php echo $mel_usr ?>&subj=<?php echo urlencode($subj) ?>&bccrt=<?php echo $user ?>&from=<?php echo urlencode($from) ?>&att=<?php echo urlencode($att_lst) ?>');">RENVOYER AVEC PIECES-JOINTES</li>
<?php
  }
?>
              </ul>
            </div>
          </span>
<?php
  if(count($attachments)>0){
?>
          <select onclick="this.selectedIndex=0">
            <option>ADJUNTO</option>
<?php
    foreach($attachments as $attname => $attachment) {
?>
            <option onclick="opn('../tmp/<?php echo $dir."/".addslashes(str_replace("_"," ", mb_decode_mimeheader($attname))) ?>');"><?php echo str_replace("_"," ", mb_decode_mimeheader($attname)); ?></option>
<?php
    }
?>
          </select>
<?php
  }
?>
          <button onclick="flag(<?php echo $id_mel ?>,'<?php echo $box ?>',<?php echo $uid ?>);"><img src="../prm/img/flg.png"/></button>
<?php
  if($box != 'INBOX.TRASH'){
?>
          <button onclick="del(<?php echo $id_mel ?>,'<?php echo $box ?>',<?php echo $uid ?>);"><img src="../prm/img/trash.png" /></button>
<?
  }
?>
          <select onclick="this.selectedIndex=0">
            <option>MOVER</option>
<?php
  foreach($map_mov as $fol => $nom){
    if($box!=$fol){
?>
            <option onclick="mov(<?php echo $id_mel ?>,'<?php echo $box ?>',<?php echo $uid ?>,'<?php echo addslashes(mb_convert_encoding($fol,"UTF7-IMAP","utf-8")); ?>');"><?php echo $nom; ?></option>
<?php
    }
  }
?>
          </select>
          <select onclick="this.selectedIndex=0">
            <option>COPIAR</option>
<?php
  foreach($lst_mel as $mel_id => $nom_mel){
?>
            <optgroup label="<?php echo $nom_mel ?>">
<?php
    foreach($map_cop[$mel_id] as $box2 => $nom){
?>
              <option onclick="cop(<?php echo $id_mel ?>,'<?php echo $box ?>',<?php echo $uid ?>,<?php echo $mel_id ?>,'<?php echo $box2 ?>')"><?php echo $nom; ?></option>
<?php
    }
?>
            </optgroup>
<?php
  }
?>
          </select>
<?php
  if(isset($new_dev)){
?>
          <input type="hidden" id="newDev" value="<?php echo $new_dev; ?>">
          <button onclick="ajt_ctc('<?php echo $new_dev; ?>')">CREER CONTACT CRM</button>
          <button id="adDev">CREER DEVIS</button>
<?php
  }
  else{
    $new_dev = rawurlencode("nom=".$from."&mail=".$addr);
  ?>
            <button onclick="ajt_ctc('<?php echo $new_dev; ?>')">CREER CONTACT CRM</button>
  <?php
  }
?>
          <hr />
        </td>
      </tr>
    </table>
  </div>
  <div class="div_acc ust w-100"><iframe src='../tmp/<?php echo $dir ?>/mel.html' class="w-100" frameborder="0" scrolling="no" onload="resizeIframe(this)" /></div>
</div>
<?php
}
else{
?>
<div id="drag2" class="drag"></div>
<div class="t2m3bp"></div>
<?php
}
?>
