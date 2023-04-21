<?php
include("../cfg/crr.php");
$rq = sel_whe("dev_hbr.nom,dev_hbr.id_cat,dev_hbr_pay.id AS id_hbr_pay,dev_hbr_pay.date,dev_hbr_pay.crr,liq,fin,dev_prs.id AS id_dev_prs,dev_crc.id AS id_crc,dev_crc.groupe","((((dev_hbr INNER JOIN dev_prs ON dev_hbr.id_prs = dev_prs.id) INNER JOIN dev_jrn ON dev_prs.id_jrn = dev_jrn.id) INNER JOIN dev_mdl ON dev_jrn.id_mdl = dev_mdl.id) INNER JOIN dev_crc ON dev_mdl.id_crc = dev_crc.id) INNER JOIN dev_hbr_pay ON dev_hbr.id = dev_hbr_pay.id_hbr","cnf>0 AND pay='0'","date, nom");
$nb = num_rows($rq);
if($nb>0){
  $flg_nb_date  = $flg_nb_hbr = $flg_nb_crc = false;
  $nb_date  = $nb_hbr = $nb_crc = 0;
  $dt_all = ftc_all($rq);
?>
<div class="floating-box"><?php include("vue_pay_hbr.php"); ?></div>
<input type="button" value="<?php echo $txt->lst->acc->exp->$id_lng ?>" onclick="window.open('doc_pay.php');"/>
<?php
}
$rq = sel_whe("id_frn,dev_srv_pay.id AS id_srv_pay,dev_srv_pay.date,dev_srv_pay.crr,liq,fin,dev_prs.id AS id_dev_prs,dev_crc.id AS id_crc,dev_crc.groupe","((((dev_srv INNER JOIN dev_prs ON dev_srv.id_prs = dev_prs.id) INNER JOIN dev_jrn ON dev_prs.id_jrn = dev_jrn.id) INNER JOIN dev_mdl ON dev_jrn.id_mdl = dev_mdl.id) INNER JOIN dev_crc ON dev_mdl.id_crc = dev_crc.id) INNER JOIN dev_srv_pay ON dev_srv.id = dev_srv_pay.id_srv","cnf>0 AND pay='0'","date, id_frn");
$nb = num_rows($rq);
if($nb>0){
  $flg_nb_date  = $flg_nb_frn = $flg_nb_crc = false;
  $nb_date  = $nb_frn = $nb_crc = 0;
  $dt_all = ftc_all($rq);
?>
<div class="floating-box"><?php include("vue_pay_frn.php"); ?></div>
<?php
}
?>
