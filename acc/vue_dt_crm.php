<table class="w-100">
  <tr>
    <td class="vam fwb text-center" colspan="3">
<?php
echo $txt->ajt_ctc->$id_lng;
?>
      <span class="dib" onclick="ajt_ctc();">
        <img class="vam" src="../prm/img/ajt.png">
      </span>
    </td>
  </tr>
  <tr><td colspan="8"><hr /></td></tr>
<?php
include("../prm/usr.php");
if($nb_ctc>0) {
  while($dt_ctc = ftc_ass($rq_ctc)) {
    $rq_ech = sel_quo("*","crm_ech","id_ctc",$dt_ctc['id'],"dt_ech DESC");
    $nb_ech = num_rows($rq_ech);
?>
  <tr>
    <td colspan="6"></td>
    <td class="vam fwb text-right" colspan="3">
<?php
    echo $txt->ajt_ech->$id_lng;
?>
      <span class="dib" onclick="ajt_ech(<?php echo $dt_ctc['id']; ?>);">
        <img class="vam" src="../prm/img/ajt.png" />
      </span>
    </td>
  </tr>
  <tr>
    <td <?php if($nb_ech>1) {echo 'rowspan="'.($nb_ech*2-1).'"';} ?>>
<?php
    if($aut['crm'] or $id_usr == $dt_ech['respon']) {
?>
      <span class="dib" onclick="sup_ctc(<?php echo $dt_ctc['id']; ?>);">
        <img src="../prm/img/sup.png" />
      </span>
<?php
    }
?>
    </td>
    <td <?php if($nb_ech>1) {echo 'rowspan="'.($nb_ech*2-1).'"';} ?>>
      <input type="text" <?php if(!$aut['crm'] and $nb_ech>1) {echo ' disabled';} ?> placeholder="<?php echo $txt->nom->$id_lng ?>" style="min-width: 80px; width: 96%;" value="<?php echo stripslashes($dt_ctc['nom']) ?>" onChange="maj('crm_ctc','nom',this.value,<?php echo $dt_ctc['id']; ?>)" />
      <br />
      <input type="text" <?php if(!$aut['crm'] and $nb_ech>1) {echo ' disabled';} ?> placeholder="<?php echo $txt->pre->$id_lng ?>" style="min-width: 80px; width: 96%;" value="<?php echo stripslashes($dt_ctc['pre']) ?>" onChange="maj('crm_ctc','pre',this.value,<?php echo $dt_ctc['id']; ?>)" />
      <br />
      <input type="text" <?php if(!$aut['crm'] and $nb_ech>1) {echo ' disabled';} ?> placeholder="<?php echo $txt->adresse->$id_lng ?>" style="min-width: 80px; width: 96%;" value="<?php echo stripslashes($dt_ctc['adresse']) ?>" onChange="maj('crm_ctc','adresse',this.value,<?php echo $dt_ctc['id']; ?>)" />
      <br />
      <input type="text" <?php if(!$aut['crm'] and $nb_ech>1) {echo ' disabled';} ?> placeholder="<?php echo $txt->prv->$id_lng ?>" style="min-width: 80px; width: 96%;" value="<?php echo stripslashes($dt_ctc['prv']) ?>" onChange="maj('crm_ctc','prv',this.value,<?php echo $dt_ctc['id']; ?>)" />
    </td>
    <td <?php if($nb_ech>1) {echo 'rowspan="'.($nb_ech*2-1).'"';} ?>>
      <input type="text" <?php if(!$aut['crm'] and $nb_ech>1) {echo ' disabled';} ?> placeholder="<?php echo $txt->mail->$id_lng ?>" style="min-width: 110px; width: 96%;" value="<?php echo stripslashes($dt_ctc['mail']) ?>" onChange="maj('crm_ctc','mail',this.value,<?php echo $dt_ctc['id']; ?>)" />
      <br />
      <input type="text" <?php if(!$aut['crm'] and $nb_ech>1) {echo ' disabled';} ?> placeholder="<?php echo $txt->tel->$id_lng ?>" style="min-width: 80px; width: 96%;" value="<?php echo stripslashes($dt_ctc['tel']) ?>" onChange="maj('crm_ctc','tel',this.value,<?php echo $dt_ctc['id']; ?>)" />
      <br />
      <input type="text" <?php if(!$aut['crm'] and $nb_ech>1) {echo ' disabled';} ?> placeholder="<?php echo $txt->canal->$id_lng ?>" style="min-width: 100px; width: 96%;" value="<?php echo stripslashes($dt_ctc['canal']) ?>" onChange="maj('crm_ctc','canal',this.value,<?php echo $dt_ctc['id']; ?>)" />
      <br />
      <input type="text" <?php if(!$aut['crm'] and $nb_ech>1) {echo ' disabled';} ?> placeholder="jj/mm/aaaa" style="width: 70px; padding: 0 5px;" value="<?php if($dt_ctc['dt_ctc']!='0000-00-00') {echo date("d/m/Y", strtotime($dt_ctc['dt_ctc']));}; ?>" onChange="maj('crm_ctc','dt_ctc',this.value,<?php echo $dt_ctc['id']; ?>)" />
    </td>
<?php
    $i = $nb_ech;
    while($dt_ech = ftc_ass($rq_ech)) {
      if($nb_ech > 1 and $i < $nb_ech) {
?>
  <tr><td colspan="6"><hr /></td></tr>
  <tr>
<?php
      }
?>
    <td>
      <input type="text" <?php if(!$aut['crm'] and $id_usr != $dt_ech['respon']) {echo ' disabled';} ?> placeholder="<?php echo $txt->periode->$id_lng ?>" style="min-width: 80px; width: 96%;" value="<?php echo stripslashes($dt_ech['periode']) ?>" onChange="maj('crm_ech','periode',this.value,<?php echo $dt_ech['id']; ?>)" />
      <br />
      <div style="white-space: nowrap">
        <input type="text" <?php if(!$aut['crm'] and $id_usr != $dt_ech['respon']) {echo ' disabled';} ?> placeholder="<?php echo $txt->nombre->$id_lng ?>" style="width: 20px;" value="<?php echo stripslashes($dt_ech['nombre']) ?>" onChange="maj('crm_ech','nombre',this.value,<?php echo $dt_ech['id']; ?>)" />
        <input type="text" <?php if(!$aut['crm'] and $id_usr != $dt_ech['respon']) {echo ' disabled';} ?> placeholder="<?php echo $txt->duree->$id_lng ?>" style="min-width: 70px;" value="<?php echo stripslashes($dt_ech['duree']) ?>" onChange="maj('crm_ech','duree',this.value,<?php echo $dt_ech['id']; ?>)" />
      </div>
    </td>
    <td>
      <textarea <?php if(!$aut['crm'] and $id_usr != $dt_ech['respon']) {echo ' readonly';} ?> placeholder="<?php echo $txt->motscles->$id_lng ?>" style="text-align-last:left; min-width: 250px; min-height: 42px; width: 96%;" onChange="maj('crm_ech','motscles',this.value,<?php echo $dt_ech['id']; ?>)"><?php echo stripslashes($dt_ech['motscles']) ?></textarea>
    </td>
    <td>
      <select <?php if(!$aut['crm']) {echo ' disabled';} ?> style="width: 78px; background-color: <?php if($id_usr==$dt_ech['respon']) {echo $col_stat_ech[$dt_ech['stat']];} ?>;" onchange="maj('crm_ech','respon',this.value,<?php echo $dt_ech['id'] ?>)">
        <optgroup label="<?php echo $txt->respon->$id_lng ?>">
<?php
      foreach($lst_usr as $usr_id => $qui) {
?>
          <option <?php if($usr_id==$dt_ech['respon']) {echo ' selected';} ?> value="<?php echo $usr_id ?>"><?php echo $qui; ?></option>
<?php
      }
?>
        </optgroup>
      </select>
      <br />
      <input type="text" <?php if(!$aut['crm'] and $id_usr != $dt_ech['respon']) {echo ' disabled';} ?> placeholder="jj/mm/aaaa" style="width: 70px;<?php if($dt_ech['stat']==0 or $dt_ech['stat']==2 or $dt_ech['stat']==3) {echo 'background-color: coral';} ?>" value="<?php if($dt_ech['dt_ech']!='0000-00-00') {echo date("d/m/Y", strtotime($dt_ech['dt_ech']));}; ?>" onChange="maj('crm_ech','dt_ech',this.value,<?php echo $dt_ech['id']; ?>)" />
    </td>
    <td>
      <textarea <?php if(!$aut['crm'] and $id_usr != $dt_ech['respon']) {echo ' readonly';} ?> placeholder="<?php echo $txt->commen->$id_lng ?>" style="text-align-last:left; min-width: 250px; min-height: 42px; width: 96%;" onChange="maj('crm_ech','commen',this.value,<?php echo $dt_ech['id']; ?>)"><?php echo stripslashes($dt_ech['commen']) ?></textarea>
    </td>
    <td>
      <select <?php if(!$aut['crm'] and $id_usr != $dt_ech['respon']) {echo ' disabled';} ?> style="width: 78px; background-color: <?php echo $col_stat_ech[$dt_ech['stat']] ?>;" onchange="maj('crm_ech','stat',this.value,<?php echo $dt_ech['id'] ?>)">
        <optgroup label="<?php echo $txt->statut->$id_lng ?>">
<?php
      foreach($stat_ech[$id_lng] as $id_stat => $nom) {
?>
          <option <?php if($id_stat==$dt_ech['stat']) {echo ' selected';} ?> value="<?php echo $id_stat ?>"><?php echo $nom; ?></option>
<?php
      }
?>
        </optgroup>
      </select>
      <br />
        <input type="text" <?php if(!$aut['crm'] and $id_usr != $dt_ech['respon']) {echo ' disabled';} ?> placeholder="jj/mm/aaaa" style="width: 70px;" value="<?php if($dt_ech['dt_stat']!='0000-00-00') {echo date("d/m/Y", strtotime($dt_ech['dt_stat']));}; ?>" onChange="maj('crm_ech','dt_stat',this.value,<?php echo $dt_ech['id']; ?>)" />
    </td>
    <td>
<?php
      if($nb_ech>1 and ($aut['crm'] or $id_usr == $dt_ech['respon'])) {
?>
      <span class="dib" onclick="sup_ech(<?php echo $dt_ech['id']; ?>);">
        <img src="../prm/img/sup.png" />
      </span>
<?php
      }
?>
    </td>
<?php
      if($i > 1) {
        $i--;
?>
  </tr>
<?php
      }
    }
?>
  </tr>
  <tr><td colspan="9"><hr /></td></tr>
<?php
  }
}
?>
</table>
