<?php
if(isset($_POST['li_sel'])){
  include("../prm/fct.php");
  include("../prm/aut.php");
  $li_sel = $_POST['li_sel'];
  $li_map = explode('|',rawurldecode($_POST['li_map']));
  $sel_box = $_POST['sel_box'];
  $sel_uid = $_POST['sel_uid'];

}
$tot_unseen = 0;
?>
<div class="wsn dof">
<?php
$rq_cfg_mel = sel_quo("*","cfg_usr_mel","id_usr",$id_usr);
if(num_rows($rq_cfg_mel)>0){
  while($dt_cfg_mel = ftc_ass($rq_cfg_mel)){
    $id_mel = $dt_cfg_mel['id_mel'];
    $box = '';
    include("mel_cnx.php");
    unset($_POST);
    if($mbox){
      $boxes = imap_getmailboxes($mbox,"{".$server."}", "*");
      if($boxes !== false){
        $no_list = array(
          "INBOX.Archive",
          "INBOX.Drafts",
          "INBOX.spam",
        );
        foreach($boxes as $k => $val){
          $mapname = str_replace("{".$server."}", "", mb_convert_encoding($val->name,"utf-8","UTF7-IMAP"));
          $name = str_replace("{".$server."}", "",$val->name);
          if($mapname[0] != "." and !in_array(utf8_encode($name),$no_list)){
            $map[] = $txt = $mapname;
            while(!is_bool(strpos($txt, "."))){
              $fld = substr($txt,0,strpos($txt,"."));
              if(!in_array($fld,$fol)){$fol[] = $fld;}
              $txt = substr($txt, strpos($txt,".")+1);
            }
            $fol[] = $txt;
          }
        }
        $ulname ='';
        natcasesort($map);
        foreach($map as $i => $mapname){
          $estado = imap_status($mbox, "{".$server."}".$mapname, SA_UNSEEN);
          $root = substr($mapname,0,strrpos($mapname,"."));
          if(isset($ul)){
            for($j=$ul;$j>substr_count($mapname,'.');$j--){echo '</ul>';}
          }
          else{$ul=0;}
          $np = substr_count($mapname,'.');
          if(in_array('span'.$id_mel.'_'.$ulname,$li_map)){$style = "display: block;";}
          else{$style = " display: none;";}
          for($j=0; $j<$np-$ul; $j++){echo '<ul id="'.$id_mel.'_'.$ulname.'" class="mpl" style="'.$style.'">';}
          $ul = substr_count($mapname,'.');
          $px = 10+15*$np;
          $style = '';
          if($mapname != 'INBOX'){$style .= 'padding-left: '.$px.'px;';}
          if('li_'.$id_mel.'_'.$i == $li_sel){
            $style .= " background-color: darkgray;";
            $flg_sel = true;
            $sel_mel = $id_mel;
            $sel_fol = $i;
          }
          else{$flg_sel = false;}
?>
  <li id="li_<?php echo $id_mel.'_'.$i; ?>" class="li_map<?php if($flg_sel){echo ' li_sel';} ?>" style="<?php echo $style; ?>" >
    <div>
<?php
          if($estado->unseen){
            echo $estado->unseen;
            $tot_unseen += $estado->unseen;
          }
?>
    </div>
<?php
          $ulname = str_replace(array('.',' '),'_',$mapname);
          if($mapname == substr($map[$i+1],0,strlen($mapname))){
            if(in_array('span'.$id_mel.'_'.$ulname,$li_map)){
?>
    <span id="<?php echo 'span'.$id_mel.'_'.$ulname; ?>" class="fsm span_map li_opn" onclick="vue_fold(<?php echo $id_mel; ?>,'<?php echo $ulname; ?>')"><?php echo '&#9660;'; ?></span>
<?php
            }
            else{
?>
    <span id="<?php echo 'span'.$id_mel.'_'.$ulname; ?>" class="fsm span_map" onclick="vue_fold(<?php echo $id_mel; ?>,'<?php echo $ulname; ?>')"><?php echo '&#9658;'; ?></span>
<?php
            }
          }
          else{
?>
    <span id="<?php echo 'span'.$id_mel.'_'.$ulname; ?>" class="span_map"><?php echo '&nbsp;&nbsp;&nbsp;'; ?></span>
<?
          }
?>
    <a class="fsm" onclick="vue_box(<?php echo $id_mel; ?>,'<?php echo addslashes(mb_convert_encoding($mapname,"UTF7-IMAP","utf-8")); ?>',<?php echo $i; ?>,0);">
<?php
          if($fol[$i]=='INBOX'){echo $user;}
          else{echo $fol[$i];}
?>
    </a>
  </li>
<?php
        }
        echo '</ul>';
        unset($boxes,$map,$fol);
      }
      imap_close($mbox);
    }
    else{echo 'ERROR DE CONNEXION A '.$user.'<br />';}
  }
}
?>
</div>
<input id="unseen" type="hidden" value="<?php echo $tot_unseen; ?>" />
<input id="sel_mel" type="hidden" value="<?php echo $sel_mel; ?>" />
<input id="sel_fol" type="hidden" value="<?php echo $sel_fol; ?>" />
<input id="sel_box" type="hidden" value="<?php echo $sel_box; ?>" />
<input id="sel_uid" type="hidden" value="<?php echo $sel_uid; ?>" />
