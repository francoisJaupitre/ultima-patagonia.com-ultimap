<h4>
<?php
include("../prm/usr.php");
echo $txt->tsk->$id_lng;
if($cbl=='tsk'){ //else $cbl=='hom'  version simplifiée
?>
<span class="dib vam" onclick="ajt_tsk();"><img src="../prm/img/ajt.png" /></span>
<?php
}
?>
</h4>
<?php
if($nb_tsk>0){
?>
  <table class="w-100">
    <tr>
      <td class="td"><?php echo $txt->action->$id_lng ?></td>
      <td class="td"><?php echo $txt->grp->$id_lng ?></td>
      <td class="td"><?php echo $txt->respon->$id_lng ?></td>
      <td class="td"><?php echo $txt->delai->$id_lng ?></td>
      <td class="td"><?php echo $txt->statut->$id_lng ?></td>
      <td class="td"><?php echo $txt->commen->$id_lng ?></td>
    </tr>
<?php
  while($dt_tsk = ftc_ass($rq_tsk)){
?>
  <tr>
<?php
    if($dt_tsk['id_grp']>0){
?>
    <td class="td_acc"><?php
      if((!$aut['tsk'] and $id_usr != $dt_tsk['respon']) or $cbl!='tsk'){echo stripslashes($dt_tsk['nom']);}
      else{
?>
      <input type="text" style="min-width: 600px; width: 96%;" value="<?php echo stripslashes($dt_tsk['nom']) ?>" onChange="maj('grp_tsk','nom',this.value,<?php echo $dt_tsk['id_tsk']; ?>)" />
<?php
      }
?>
    </td>
    <td class="td_acc lnk" onclick="window.parent.opn_frm('grp/ctr.php?id=<?php echo $dt_tsk['id_grp'] ?>');"><?php echo $dt_tsk['nomgrp'] ?></td>
<?php
    }
    else{
?>
    <td class="td_acc" colspan="2">
<?php
      if((!$aut['tsk'] and $id_usr != $dt_tsk['respon']) or $cbl!='tsk'){echo stripslashes($dt_tsk['nom']);}
      else{
?>
      <input type="text" style="min-width: 700px; width: 96%;" value="<?php echo stripslashes($dt_tsk['nom']) ?>" onChange="maj('grp_tsk','nom',this.value,<?php echo $dt_tsk['id_tsk']; ?>)" />
<?php
      }
?>
    </td>
<?php
    }
?>
    <td class="td_acc">
<?php
    if((!$aut['tsk'] and $id_usr != $dt_tsk['usr']) or $cbl!='tsk'){
?>
      <div style="background-color: <?php if($id_usr==$dt_tsk['respon']){echo $col_stat_tsk[$dt_tsk['stat']];} ?>;"><?php echo $lst_usr[$dt_tsk['respon']];?></div>
<?php
    }
    else{
?>
      <select style="background-color: <?php if($id_usr==$dt_tsk['respon']){echo $col_stat_tsk[$dt_tsk['stat']];} ?>;" onchange="maj('grp_tsk','respon',this.value,<?php echo $dt_tsk['id_tsk'] ?>)">
<?php
      foreach($lst_usr as $usr_id => $qui){
?>
        <option <?php if($usr_id==$dt_tsk['respon']){echo ' selected';} ?> value="<?php echo $usr_id ?>"><?php echo $qui; ?></option>
<?php
      }
?>
      </select>
<?php
    }
?>
    </td>
    <td class="td_acc">
<?php
    if((!$aut['tsk'] and $id_usr != $dt_tsk['respon']) or $cbl!='tsk'){
?>
      <div style="<?php if($dt_tsk['date']<date("Y-m-d")){echo 'color: tomato';}elseif($dt_tsk['date']==date("Y-m-d")){echo 'background-color: coral';} ?>"><?php if($dt_tsk['date']!="0000-00-00"){echo date("d/m/Y",strtotime($dt_tsk['date']));} ?></div>
<?php
    }
    else{
?>
      <input id="tsk_date<?php echo $dt_tsk['id_tsk']; ?>" type="text" placeholder="jj/mm/aaaa" style="width: 70px; padding: 0 5px;<?php if($dt_tsk['date']<date("Y-m-d")){echo 'color: tomato';}elseif($dt_tsk['date']==date("Y-m-d")){echo 'background-color: coral';} ?>" value="<?php if($dt_tsk['date']!='0000-00-00'){echo date("d/m/Y", strtotime($dt_tsk['date']));}; ?>" onChange="maj('grp_tsk','date',this.value,<?php echo $dt_tsk['id_tsk']; ?>)" />
<?php
    }
?>
    </td>
    <td class="td_acc">
<?php
    if((!$aut['tsk'] and $id_usr != $dt_tsk['respon']) or $cbl!='tsk'){
?>
      <div style="background-color: <?php echo $col_stat_tsk[$dt_tsk['stat']] ?>;"><?php echo substr($stat_tsk[$id_lng][$dt_tsk['stat']],0,1); ?></div>
<?php
    }
    else{
?>
      <select style="border-style: hidden; width: 35px; background-color: <?php echo $col_stat_tsk[$dt_tsk['stat']] ?>;" onchange="maj('grp_tsk','stat',this.value,<?php echo $dt_tsk['id_tsk'] ?>)">
<?php
      foreach($stat_tsk[$id_lng] as $id_stat => $nom){
?>
        <option <?php if($id_stat==$dt_tsk['stat']){echo ' selected';} ?> value="<?php echo $id_stat ?>"><?php echo $nom; ?></option>
<?php
      }
?>
      </select>
<?php
    }
?>
    </td>
    <td class="td_acc">
<?php
    if((!$aut['tsk'] and $id_usr != $dt_tsk['respon']) or $cbl!='tsk'){echo stripslashes($dt_tsk['commen']);}
    else{
?>
      <input type="text" maxlength="60" style="width: 200px; width: 96%;" value="<?php echo stripslashes($dt_tsk['commen']) ?>" onChange="maj('grp_tsk','commen',this.value,<?php echo $dt_tsk['id_tsk']; ?>)" />
<?php
    }
?>
    </td>
<?php
    if(($aut['tsk'] or $id_usr != $dt_tsk['respon']) and $cbl=='tsk'){
?>
    <td onclick="sup_tsk(<?php echo $dt_tsk['id_tsk'] ?>);"><img src="../prm/img/sup.png" /></td>
<?php
    }
?>
  </tr>
<?php
  }
?>
</table>
<?php
}
?>
