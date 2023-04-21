<?php
include("../prm/fct.php");
include("../prm/aut.php"); //timezone pour dt_web
include("../prm/lgg.php");
include("../prm/crr.php");
include("../prm/pays.php");
$id_lgg = $_POST['lgg'];
$id_lng = $lgg[$id_lgg];
$devise = $symbol = $info_tarif = '';
$tarif = 0;
$flg_err_trf = false;
if($_POST['obj']=='crc') {
  $id_crc = $_POST['id'];
  $fus_mdl = $sel_crc_jrn = array();
  $duree = 0;
  $rq_crc_mdl = sel_quo("cat_crc_mdl.id_mdl,fus,sel_mdl_jrn,web_uid","cat_crc_mdl LEFT JOIN cat_mdl_txt ON cat_crc_mdl.id_mdl = cat_mdl_txt.id_mdl",array("lgg","id_crc"),array($id_lgg,$id_crc),"ord");
  while($dt_crc_mdl = ftc_ass($rq_crc_mdl)) {
    $id_mdl = $id = $dt_crc_mdl['id_mdl'];
    $uid_mdl[] = '}'.$id_mdl.'}'.stripslashes(htmlspecialchars($dt_crc_mdl['web_uid']));
    $nb_jrn = ftc_ass(sel_quo("COUNT(*) as duree","cat_mdl_jrn",array("id_mdl","opt"),array($id_mdl,"1")));
    $duree += $nb_jrn['duree'];
    if($dt_crc_mdl['fus']) {
      $fus_mdl[] = $id_mdl;
      $duree--;
    }
    if(!empty($dt_crc_mdl['sel_mdl_jrn'])) {
      $sel_mdl_jrn = explode(",",$dt_crc_mdl['sel_mdl_jrn']);
      $sel_crc_jrn[] = '}'.$id_mdl.'}'.implode(",",$sel_mdl_jrn);
      $duree += count(explode(",",$dt_crc_mdl['sel_mdl_jrn']));
    }
  //  include("trf_mdl.php"); 'sel_mdl_jrn' n'est pas pris en compte dans fct/trf.php
    if(isset($err_hbr_jrn[$id_trf])) {
      foreach(array_unique($err_hbr_jrn[$id_trf]) as $jrn) {
        if($err_hbr_def[$id_trf][$jrn] or $err_hbr_db[$id_trf][$jrn] or $err_hbr_sel[$id_trf][$jrn] or $err_hbr_dup[$id_trf][$jrn]) {$flg_err_trf = true;}
      }
    }
    if(isset($err_trf_srv[$id_trf][0]) and $err_trf_srv[$id_trf][0]) {$flg_err_trf = true;}
    if(!$flg_err_trf) {
      $tarif += $prx;
      $devise = $prm_crr_nom[$id_crr_clt];
      $symbol = $prm_crr_sym[$id_crr_clt];
      $info_tarif = "Tarif en ".$prm_crr_ttr[$id_lng][$id_crr_clt]." par personne, sur la base de 2 personnes en chambre double, hors vols et options, variable selon les dates de voyages et le type d'hébergement.";
    }
    else{
      $devise = $symbol = $info_tarif = '';
      $tarif = 0;
    }
  }
  upd_var_quo("cat_crc_txt","dt_web",date("Y-m-d H:i:s"),array("lgg","id_crc"),array($id_lgg,$id_crc));
?>
<input type="text" name="duration" value="<?php echo $duree; ?>" />
<input type="text" name="modules" value="<?php echo '['.implode("][",$uid_mdl).']'; ?>" />
<input type="text" name="fusion" value="<?php echo implode(",",$fus_mdl); ?>" />
<input type="text" name="daySelections" value="<?php if(isset($sel_crc_jrn)) {echo '['.implode("][",$sel_crc_jrn).']';} ?>" />
<input type="text" name="price" value="<?php echo $tarif; ?>" />
<input type="text" name="currency" value="<?php echo $devise; ?>" />
<input type="text" name="symbol" value="<?php echo $symbol; ?>" />
<input type="text" name="priceInfo" value="<?php echo $info_tarif; ?>" />
<input type="text" name="lang" value="<?php echo $id_lng; ?>" />

<?php
}
elseif($_POST['obj']=='mdl') {
  $vll_nom = $lst_prs = array();
  $id_mdl = $_POST['id'];
  $ord_ant_jrn = $duree = 0;
  $opt_ant_jrn = 1;
  $flg_jrn = false;
  $dt_mdl = ftc_ass(sel_quo("sel_mdl_jrn","cat_mdl","id",$id_mdl));
  $sel_mdl_jrn = explode(",",$dt_mdl['sel_mdl_jrn']);
  $ord_sql = "ord, opt DESC";
  if(!empty($sel_mdl_jrn[0])) {
    $duree += count($sel_mdl_jrn);
    $ord_sql .= ",field(cat_mdl_jrn.id_jrn";
    foreach ($sel_mdl_jrn as $id_jrn) {$ord_sql .= ",".$id_jrn;}
    $ord_sql .= ") DESC";
  }
  $rq_mdl_jrn = sel_quo("cat_mdl_jrn.id_jrn,ord,opt,titre,dsc","cat_mdl_jrn LEFT JOIN cat_jrn_txt ON cat_mdl_jrn.id_jrn = cat_jrn_txt.id_jrn",array("lgg","id_mdl"),array($id_lgg,$id_mdl),$ord_sql);
  while($dt_mdl_jrn = ftc_ass($rq_mdl_jrn)) {
    $id_jrn = $dt_mdl_jrn['id_jrn'];
    $ord_jrn = $dt_mdl_jrn['ord'];
    $opt_jrn = $dt_mdl_jrn['opt'];
    $flg_prs = false;
    if($opt_jrn) {
      $jrn_txt_titre[$ord_jrn] = '}'.$id_jrn.'}'.stripslashes(htmlspecialchars($dt_mdl_jrn['titre']));
      $prs_txt_titre[$ord_jrn] = '||';
      $jrn_txt_dsc[$ord_jrn] = '}'.nl2br(stripslashes($dt_mdl_jrn['dsc']));
      $prs_txt_dsc[$ord_jrn] = '||';
      $flg_prs = $flg_jrn = true;
      $duree++;
    }
    else{
      // solo options independantes
      if($ord_jrn != $ord_ant_jrn) {
        $jrn_txt_titre[$ord_jrn] = '}'.$id_jrn.'}{'.stripslashes(htmlspecialchars($dt_mdl_jrn['titre']));
        $prs_txt_titre[$ord_jrn] = '||';
        $jrn_txt_dsc[$ord_jrn] = '}{'.nl2br(stripslashes($dt_mdl_jrn['dsc']));
        $prs_txt_dsc[$ord_jrn] = '||';
        $flg_prs = true;
        $flg_jrn = false;
      }
      elseif(!$opt_ant_jrn and !$flg_jrn) {
        $jrn_txt_titre[$ord_jrn] .= '}'.$id_jrn.'}{'.stripslashes(htmlspecialchars($dt_mdl_jrn['titre']));
        $prs_txt_titre[$ord_jrn] .= '||';
        $jrn_txt_dsc[$ord_jrn] .= '}{'.nl2br(stripslashes($dt_mdl_jrn['dsc']));
        $prs_txt_dsc[$ord_jrn] .= '||';
        $flg_prs = true;
      }
    }
    $ord_ant_jrn = $ord_jrn;
    $opt_ant_jrn = $opt_jrn;
    if($flg_prs) {
      $ord_ant_prs = 0;
      $rq_prs = sel_quo("cat_jrn_prs.id_prs,opt,ord,titre,dsc","cat_jrn_prs LEFT JOIN cat_prs_txt ON cat_jrn_prs.id_prs = cat_prs_txt.id_prs",array("lgg","id_jrn"),array($id_lgg,$id_jrn),"ord,opt DESC");
      while($dt_prs = ftc_ass($rq_prs)) {
        $id_prs = $dt_prs['id_prs'];
        $ord_prs = $dt_prs['ord'];
        $opt_prs = $dt_prs['opt'];
        if($ord_prs != $ord_ant_prs and $ord_prs > 1 and ($opt_prs or $opt_jrn or is_array($sel_mdl_jrn) and in_array($id_jrn,$sel_mdl_jrn))) {
          $prs_txt_titre[$ord_jrn] .= '|';
          $prs_txt_dsc[$ord_jrn] .= '|';
        }
        if($opt_prs) {
          $prs_txt_titre[$ord_jrn] .= '}'.$id_prs.'}'.stripslashes(htmlspecialchars($dt_prs['titre']));
          $prs_txt_dsc[$ord_jrn] .= nl2br(stripslashes($dt_prs['dsc']));
          if(!in_array($id_prs,$lst_prs)) {$lst_prs[] = $id_prs;}
        }
        elseif($opt_jrn or is_array($sel_mdl_jrn) and in_array($id_jrn,$sel_mdl_jrn)) { // pas d'options prestations pour les journees en options
          $prs_txt_titre[$ord_jrn] .= '}'.$id_prs.'}{'.stripslashes(htmlspecialchars($dt_prs['titre']));
          $prs_txt_dsc[$ord_jrn] .= '{'.nl2br(stripslashes($dt_prs['dsc']));
        }
        $ord_ant_prs = $ord_prs;
      }
      $rq_vll = sel_quo("nom,id_pays,lat,lon,dsc","cat_jrn_vll INNER JOIN (cat_vll LEFT JOIN cat_vll_txt ON cat_vll.id = cat_vll_txt.id_vll) ON cat_jrn_vll.id_vll = cat_vll.id","id_jrn",$id_jrn);
      while($dt_vll = ftc_ass($rq_vll)) {
        if(!in_array($dt_vll['nom'],$vll_nom)) {
          $vll_nom[] = $dt_vll['nom'];
          $vll_pays[] = $pays['fr'][$dt_vll['id_pays']];
          $lieu_latlon[] = $dt_vll['lat'].','.$dt_vll['lon'];
          if($dt_vll['lat']<0)  { $signlat = 'W'; } else { $signlat = 'E'; }
          $latAbs = abs( round($dt_vll['lat'] * 1000000.));
          $lat = ((floor($latAbs/1000000)).'° '. floor((($latAbs/1000000)-floor($latAbs/1000000))*60).'\' '.( floor((((($latAbs/1000000)-floor($latAbs/1000000))*60)-floor((($latAbs/1000000)-floor($latAbs/1000000))*60))*100000)*60/100000).'&quot;');
          if($dt_vll['lon']<0)  { $signlon = 'S'; } else { $signlon = 'N'; }
          $lonAbs = abs( round($dt_vll['lon'] * 1000000.));
          $lon = ((floor($lonAbs/1000000)).'° '. floor((($lonAbs/1000000)-floor($lonAbs/1000000))*60).'\' '.( floor((((($lonAbs/1000000)-floor($lonAbs/1000000))*60)-floor((($lonAbs/1000000)-floor($lonAbs/1000000))*60))*100000)*60/100000 ).'&quot;');
          $vll_latlon[] = $lat.' '.$signlat.'  '.$lon.' '.$signlon.'||'.$dt_vll['lat'].'||'.$dt_vll['lon'];
          $vll_dsc[] = $dt_vll['dsc'];
        }
      }
      $ids = join("','",$lst_prs);
      $rq_lieu = sel_whe("DISTINCT cat_lieu.id,lat,lon","cat_prs_lieu INNER JOIN cat_lieu ON cat_prs_lieu.id_lieu = cat_lieu.id","id_prs IN ('$ids')");
      while($dt_lieu = ftc_ass($rq_lieu)) {
        $lieu_latlon[] = $dt_lieu['lat'].','.$dt_lieu['lon'];
      }
    }
  }
  $id = $id_mdl;
  //  include("trf_mdl.php"); 'sel_mdl_jrn' n'est pas pris en compte dans fct/trf.php
  $flg_err_trf = false;
  if(isset($id_trf)) {
    if(isset($err_hbr_jrn[$id_trf])) {
      foreach(array_unique($err_hbr_jrn[$id_trf]) as $jrn) {
        if($err_hbr_def[$id_trf][$jrn] or $err_hbr_db[$id_trf][$jrn] or $err_hbr_sel[$id_trf][$jrn] or $err_hbr_dup[$id_trf][$jrn]) {$flg_err_trf = true;}
      }
    }
    if(isset($err_trf_srv[$id_trf][0]) and $err_trf_srv[$id_trf][0]) {$flg_err_trf = true;}
    if(!$flg_err_trf) {
      $tarif = $prx;
      $devise = $prm_crr_nom[$id_crr_clt];
      $symbol = $prm_crr_sym[$id_crr_clt];
      $info_tarif = "Tarif en ".$prm_crr_ttr[$id_lng][$id_crr_clt]." par personne, sur la base de 2 personnes en chambre double, hors vols et options, variable selon les dates de voyages et le type d'hébergement.";
    }
  }
  upd_var_quo("cat_mdl_txt","dt_web",date("Y-m-d H:i:s"),array("lgg","id_mdl"),array($id_lgg,$id_mdl));
?>
<input type="text" name="duration" value="<?php echo $duree; ?>" />
<input type="text" name="dayTitles" value="<?php echo '['.implode("][",$jrn_txt_titre).']'; ?>" />
<textarea name="dayDescriptions"><?php echo '['.implode("][",$jrn_txt_dsc).']'; ?></textarea>
<input type="text" name="prestationTitles" value="<?php echo '['.implode("][",$prs_txt_titre).']'; ?>" />
<textarea name="prestationDescriptions"><?php echo '['.implode("][",$prs_txt_dsc).']'; ?></textarea>
<input type="text" name="daySelections" value="<?php echo implode(",",$sel_mdl_jrn); ?>" />
<input type="text" name="cityTitles" value="<?php echo '['.implode("][",$vll_nom).']'; ?>" />
<input type="text" name="cityCountries" value="<?php echo '['.implode("][",$vll_pays).']'; ?>" />
<input type="text" name="cityCoordinates" value="<?php echo '['.implode("][",$vll_latlon).']'; ?>" />
<textarea name="cityDescriptions"><?php echo '['.implode("][",$vll_dsc).']'; ?></textarea>
<input type="text" name="placeCoordinates" value="<?php echo '['.implode("][",array_unique($lieu_latlon)).']'; ?>" />
<input type="text" name="price" value="<?php echo $tarif; ?>" />
<input type="text" name="currency" value="<?php echo $devise; ?>" />
<input type="text" name="symbol" value="<?php echo $symbol; ?>" />
<input type="text" name="priceInfo" value="<?php echo $info_tarif; ?>" />
<input type="text" name="lang" value="<?php echo $id_lng; ?>" />
<?php
}
?>
