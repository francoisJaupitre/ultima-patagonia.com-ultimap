<?php
$request = file_get_contents("php://input");
if(!empty($request))
{
  $data = json_decode($request, true);
  $id = $data['id'];
  $vols_id = json_decode($data['vols_id'], true);
  $txt_prg = simplexml_load_file('txt_prg.xml');
	include("../prm/fct.php");
  include("../cfg/crr.php");
	include("../cfg/lng.php");
  include("../cfg/vll.php");
  $dt_crc = ftc_ass(sel_quo("crr", "dev_crc", "id", $id));
}
if(isset($vols_id))
{
	$t = 0;
?>
<hr />
<span class="fs_mdl3"><?php echo $txt_prg->lst_vol->$id_lng; ?></span>
<br />
<br />
<table class="wsn">
<?php
	foreach($vols_id as $id_vol)
  {
		if(strpos($id_vol, '_'))
    {
			$id_v1 = intval(strstr($id_vol, '_', true));
			$pos = strpos($id_vol, '_');
			$id_v2 = intval(substr($id_vol, $pos + 1));
			$msg_vol = "";
			if($id_v1 > 0)
      {
        $msg_vol = $vll[$id_v1];
      }
			$msg_vol .= " - ";
			if($id_v2 > 0)
      {
        $msg_vol .= $vll[$id_v2].' :';
      }
			$dt_vol = ftc_ass(sel_quo("id, trf, cpp", "dev_vol", array("id_crc", "id_v1", "id_v2"), array($id, $id_v1, $id_v2)));
?>
	<tr>
		<td class="fs_mdl3"><?php echo $msg_vol ?></td>
		<td class="fs_mdl3">
			<input type="text" id="<?php echo 'X'.$id_vol ?>" class="majhtml" autocomplete="off" style="width: 50px"
        value="<?php
          if($dt_vol['trf'])
          {
            echo $dt_vol['trf'];
          }elseif(!$dt_vol['id'])
          {
            echo 'X';
          }
        ?>"
        onchange="<?php
          if($dt_vol['id'])
          {
            echo "maj('dev_vol', 'trf', this.value, ".$dt_vol['id'].");";
          }else{
            echo "ajt_vol(".$id.", ".$id_v1.", ".$id_v2.", 'trf', this.value);";
          }
        ?>"
      />
		</td>
		<td class="fs_mdl3">
      <input type="text" id="<?php echo 'C'.$id_vol ?>" class="majhtml" autocomplete="off" style="width: 60px"
        value="<?php
          if($dt_vol['id'])
          {
            echo $dt_vol['cpp'];
          }else{
            echo $prm_crr_nom[$dt_crc['crr']].$txt_prg->pers2->$id_lng;
          }
        ?>"
        onchange="<?php
          if($dt_vol['id'])
          {
            echo "maj('dev_vol', 'cpp', this.value, ".$dt_vol['id'].");";
          }else{
            echo "ajt_vol(".$id.", ".$id_v1.", ".$id_v2.", 'cpp', this.value);";
          }
        ?>"
      />
    </td>
	</tr>
<?php
			$t++;
		}
	}
	if($t>1)
  {
		$dt_vol = ftc_ass(sel_quo("id, trf", "dev_vol", array("id_crc", "id_v1", "id_v2"), array($id, 0, 0)));
?>
	<tr>
		<td class="fs_mdl3">TOTAL :</td>
		<td class="fs9">
      <input type="text" id="totvol" class="majhtml" autocomplete="off" style="width: 50px"
        value="<?php
          if($dt_vol['trf'])
          {
            echo $dt_vol['trf'];
          }elseif(!$dt_vol['id'])
          {
            echo 'X';
          }
        ?>"
        onchange="<?php
          if($dt_vol['id'])
          {
            echo "maj('dev_vol', 'trf', this.value, ".$dt_vol['id'].");";
          }else{
            echo "ajt_vol(".$id.", 0, 0, 'trf', this.value);";
          }
        ?>"
      />
    </td>
		<td class="fs_mdl3"><?php echo $prm_crr_nom[$dt_crc['crr']].$txt_prg->pers2->$id_lng ?></td>
	</tr>
<?php
	}
?>
</table>
<?php
}
?>
