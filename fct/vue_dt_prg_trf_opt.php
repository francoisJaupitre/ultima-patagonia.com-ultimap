<div style="page-break-inside: avoid">
  <span class="fs5">
    <?php echo $txt_prg->en_opt->$id_lgg; ?></span>
  <br/><br/>
<?php
$flg_trf_mdl = true;
$rq_mdl = sel_quo("*","dev_mdl","id_crc",$id,"ord");
while($dt_mdl = ftc_ass($rq_mdl)){
  if($dt_mdl['trf']){
    $id_trf = $dt_mdl['id'];
    $vue_sgl = $dt_mdl['vue_sgl'];
    $vue_dbl = $dt_mdl['vue_dbl'];
    $vue_tpl = $dt_mdl['vue_tpl'];
    $vue_qdp = $dt_mdl['vue_qdp'];
    $ptl = $dt_mdl['ptl'];
    $psg = $dt_mdl['psg'];
  }
  else{
    $id_trf = 0;
    $vue_sgl = $dt_crc['vue_sgl'];
    $vue_dbl = $dt_crc['vue_dbl'];
    $vue_tpl = $dt_crc['vue_tpl'];
    $vue_qdp = $dt_crc['vue_qdp'];
    $ptl = $dt_crc['ptl'];
    $psg = $dt_crc['psg'];
  }
  if($id_trf !=0 or $flg_trf_mdl){
    //SERVICES
    if(isset($opt_srv_id[$id_trf])){
      array_multisort($opt_srv_jrn[$id_trf],$opt_srv_id[$id_trf]);
      foreach($opt_srv_id[$id_trf] as $j => $id_srv){
        if($id_srv>0){$rq_nom_srv = sel_quo("nom,titre","cat_srv LEFT JOIN cat_srv_txt ON cat_srv.id = cat_srv_txt.id_srv AND cat_srv_txt.lgg=".$lgg_crc,"cat_srv.id",$id_srv);}
        else{$rq_nom_srv = sel_quo("nom","dev_srv","id",-$id_srv);}
        $dt_nom_srv = ftc_ass($rq_nom_srv);
?>
  <div style="page-break-inside: avoid">
    <span class="fs_mdl2" style="color:#<?php echo $col[$id_col]; ?>;">
<?php
        echo $txt_prg->jour->$id_lgg.' '.$opt_srv_jrn[$id_trf][$j].' : ';
        if(!empty($dt_nom_srv['titre'])){echo $dt_nom_srv['titre'];}
        else{echo $dt_nom_srv['nom'];}
?>
    </span>
    <br/>
    <table>
<?php
        if(isset($bss[$id_trf])){
          foreach($bss[$id_trf] as $i => $base){
            $prx = $trf_opt_srv[$id_trf][$j][$i];
?>
      <tr>
<?php
						if(!$clt_tmpl[$id_clt] or $flagMultiBss or $vue_sgl or $vue_tpl or $vue_qdp)
						{
?>
			  <td style="padding: 0px 5px;" class="fs6">
<?php
              echo $txt_prg->base->$id_lgg.' '.$base;
              if($ptl){echo '&#43;1';}
              echo ' :';

?>
        </td>
<?php
						}
?>
        <td style="padding: 0px 5px;" class="fs9">
<?php
            if($err_trf_opt_srv[$id_trf][$j][$i]){echo '<span class="color-red">'.$txt->err->opt_srv->$id_lng.'</span>';}
            echo number_format($prx,0,',',' ');
?>
        </td>
        <td style="padding: 0px 5px;" class="fs6"><?php echo $prm_crr_nom[$dt_crc['crr']].$txt_prg->pers2->$id_lgg; ?></td>
      </tr>
<?php
          }
        }
?>
    </table>
  </div>
  <br/>
<?php
      }
    }
    //PRESTATIONS
    if(isset($opt_prs_id[$id_trf])){
      foreach($opt_prs_id[$id_trf] as $i => $id_dev_prs){
        unset($id_cat_prs);
        $id_cat_prs = $opt_prs_id_cat[$id_trf][$id_dev_prs];
        if($id_cat_prs>-1){
          if($id_cat_prs>0){
            $jrn = implode(", ",$opt_prs_jrn_cat[$id_trf][$id_cat_prs]);
            $dt_ttr = ftc_ass(sel_quo("nom,titre","cat_prs LEFT JOIN cat_prs_txt ON cat_prs.id = cat_prs_txt.id_prs AND lgg=".$lgg_crc,"cat_prs.id",$id_cat_prs));
            if(count($opt_prs_jrn_cat[$id_trf][$id_cat_prs])>1){$flg_s = true;}
            else{$flg_s = false;}
          }
          else{
            $jrn = $opt_prs_jrn[$id_dev_prs];
            $dt_ttr = ftc_ass(sel_quo("titre","dev_prs","id",$id_dev_prs));
            $flg_s = false;
          }
?>
  <div style="page-break-inside: avoid">
    <span class="fs_mdl2" style="color:#<?php echo $col[$id_col]; ?>;">
<?php
          if($flg_s){echo $txt_prg->jours->$id_lgg.' '.$jrn.' : ';}
          else{echo $txt_prg->jour->$id_lgg.' '.$jrn.' : ';}
          if(!empty($dt_ttr['titre'])){echo stripslashes($dt_ttr['titre']);}
          else{echo stripslashes($dt_ttr['nom']);}
?>
    </span>
    <br/>
    <table>
<?php
          if($err_hbr_def_opt_prs[$id_dev_prs][$jrn]){echo '<span class="color-red">'.$txt->err->hbr_def->$id_lng.$jrn.'</span><br/>';}
          if($err_hbr_db_opt_prs[$id_dev_prs][$jrn]){echo '<span class="color-red">'.$txt->err->hbr_db->$id_lng.$jrn.'</span><br/>';}
          if($vue_sgl and $err_hbr_sg_opt_prs[$id_dev_prs][$jrn]){echo '<span class="color-red">'.$txt->err->hbr_sg->$id_lng.$jrn.'</span><br/>';}
          if($vue_tpl and $err_hbr_tp_opt_prs[$id_dev_prs][$jrn]){echo '<span class="color-red">'.$txt->err->hbr_tp->$id_lng.$jrn.'</span><br/>';}
          if($vue_qdp and $err_hbr_qd_opt_prs[$id_dev_prs][$jrn]){echo '<span class="color-red">'.$txt->err->hbr_qd->$id_lng.$jrn.'</span><br/>';}
          if(
            (
              (
                $id_cat_prs>0 and (empty($opt_prs_trf_srv_cat[$id_trf][$id_cat_prs]) or count(array_unique($opt_prs_trf_srv_cat[$id_trf][$id_cat_prs]))==1)
              )
              or
              (
                !$id_cat_prs and (empty($opt_prs_trf_srv[$id_dev_prs]) or count(array_unique($opt_prs_trf_srv[$id_dev_prs]))==1)
              )
            )
            and !$ptl and !isset($err_trf_srv_opt_prs[$id_dev_prs])
          ){
            if($id_cat_prs>0){$prx = $opt_prs_trf_srv_cat[$id_trf][$id_cat_prs][0]+$trf_db_hbr_opt_prs_cat[$id_trf][$id_cat_prs]/2;}
            else{$prx = $opt_prs_trf_srv[$id_dev_prs][0]+$trf_db_hbr_opt_prs[$id_dev_prs]/2;}
            if(count($bss[$id_trf])==1){$base = $txt_prg->base->$id_lgg.' '.$bss[$id_trf][0];}
            else{$base = $txt_prg->bases->$id_lgg.' '.$bss[$id_trf][0].'-'.$bss[$id_trf][count($bss[$id_trf])-1];}
?>
      <tr>
<?php
						if(!$clt_tmpl[$id_clt] or $flagMultiBss or $vue_sgl or $vue_tpl or $vue_qdp)
						{
?>
		    <td style="padding: 0px 5px;" class="fs6">
<?php
              if(number_format($prx,0)!=0){
                echo $base;
                if($ptl){echo '&#43;1';}
                echo ' :';
              }
?>
        </td>
<?php
					 }
?>
        <td style="padding: 0px 5px;" class="fs9"><?php echo number_format($prx,0,',',' '); ?></td>
        <td style="padding: 0px 5px;" class="fs6"><?php echo $prm_crr_nom[$dt_crc['crr']].$txt_prg->pers2->$id_lgg; ?></td>
      </tr>
<?php
          }
          elseif(isset($bss[$id_trf])){
            foreach($bss[$id_trf] as $i => $base){
              if(!isset($err_trf_srv_opt_prs[$id_dev_prs][$i])){
                if($id_cat_prs>0){
                  $prx = $opt_prs_trf_srv_cat[$id_trf][$id_cat_prs][$i]+$trf_db_hbr_opt_prs_cat[$id_trf][$id_cat_prs]/2;
                  if($ptl){$prx += $cst_db_hbr_opt_prs_cat[$id_trf][$id_cat_prs]/(2*$base);}
                  if($psg){$prx += ($cst_sg_hbr_opt_prs_cat[$id_trf][$id_cat_prs]-$cst_db_hbr_opt_prs_cat[$id_trf][$id_cat_prs]/2)/$base;}
                }
                else{
                  $prx = $opt_prs_trf_srv[$id_dev_prs][$i]+$trf_db_hbr_opt_prs[$id_dev_prs]/2;
                  if($ptl){$prx += $cst_db_hbr_opt_prs[$id_dev_prs]/(2*$base);}
                  if($psg){$prx += ($cst_sg_hbr_opt_prs[$id_dev_prs]-$cst_db_hbr_opt_prs[$id_dev_prs]/2)/$base;}
                }
?>
      <tr>
<?php
    						if(!$clt_tmpl[$id_clt] or $flagMultiBss or $vue_sgl or $vue_tpl or $vue_qdp)
    						{
?>
		    <td style="padding: 0px 5px;" class="fs6">
<?php
                  echo $txt_prg->base->$id_lgg.' '.$base;
                  if($ptl){echo '&#43;1';}
                  echo ' :';
?>
        </td>
<?php
					     }
?>
        <td style="padding: 0px 5px;" class="fs9"><?php echo number_format($prx,0,',',' '); ?></td>
        <td style="padding: 0px 5px;" class="fs6"><?php echo $prm_crr_nom[$dt_crc['crr']].$txt_prg->pers2->$id_lgg; ?></td>
      </tr>
<?php
              }
            }
          }
          if($vue_sgl and isset($hbr_id_opt_prs[$id_dev_prs])){
            if($id_cat_prs>0){$prx = $trf_sg_hbr_opt_prs_cat[$id_trf][$id_cat_prs]-$trf_db_hbr_opt_prs_cat[$id_trf][$id_cat_prs]/2;}
            else{$prx = $trf_sg_hbr_opt_prs[$id_dev_prs]-$trf_db_hbr_opt_prs[$id_dev_prs]/2;}
?>
      <tr>
        <td style="padding: 0px 5px;" class="fs6"><?php echo $txt_prg->sup_sgl->$id_lgg.' :'; ?></td>
        <td style="padding: 0px 5px;" class="fs9"><?php echo number_format($prx,0,',',' '); ?></td>
        <td style="padding: 0px 5px;" class="fs6"><?php echo $prm_crr_nom[$dt_crc['crr']].$txt_prg->pers2->$id_lgg; ?></td>
      </tr>
<?php
          }
          if($vue_tpl and isset($hbr_id_opt_prs[$id_dev_prs])){
            if($id_cat_prs>0){$prx = $trf_db_hbr_opt_prs_cat[$id_trf][$id_cat_prs]/2-$trf_tp_hbr_opt_prs_cat[$id_trf][$id_cat_prs]/3;}
            else{$prx = $trf_db_hbr_opt_prs[$id_dev_prs]/2-$trf_tp_hbr_opt_prs[$id_dev_prs]/3;}
?>
      <tr>
        <td style="padding: 0px 5px;" class="fs6"><?php echo $txt_prg->red_tpl->$id_lgg.' :' ?></td>
        <td style="padding: 0px 5px;" class="fs9"><?php echo number_format($prx,0,',',' '); ?></td>
        <td style="padding: 0px 5px;" class="fs6"><?php echo $prm_crr_nom[$dt_crc['crr']].$txt_prg->pers2->$id_lgg; ?></td>
      </tr>
<?php
          }
          if($vue_qdp and isset($hbr_id_opt_prs[$id_dev_prs])){
            if($id_cat_prs>0){$prx = $trf_db_hbr_opt_prs_cat[$id_trf][$id_cat_prs]/2-$trf_qd_hbr_opt_prs_cat[$id_trf][$id_cat_prs]/4;}
            else{$prx = $trf_db_hbr_opt_prs[$id_dev_prs]/2-$trf_qd_hbr_opt_prs[$id_dev_prs]/4;}
?>
      <tr>
        <td style="padding: 0px 5px;" class="fs6"><?php echo $txt_prg->red_qdp->$id_lgg.' :' ?></td>
        <td style="padding: 0px 5px;" class="fs9"><?php echo number_format($prx,0,',',' '); ?></td>
        <td style="padding: 0px 5px;" class="fs6"><?php echo $prm_crr_nom[$dt_crc['crr']].$txt_prg->pers2->$id_lgg; ?></td>
      </tr>
<?php
          }
?>
    </table>
  </div>
<?php
          if(isset($opt_srv_id_opt_prs[$id_dev_prs])){
            foreach($opt_srv_id_opt_prs[$id_dev_prs] as $j => $id_srv){
              if($id_srv>0){$rq_nom_srv = sel_quo("nom","cat_srv LEFT JOIN cat_srv_txt ON cat_srv.id = cat_srv_txt.id_srv AND cat_srv_txt.lgg=".$lgg_crc,"cat_srv.id",$id_srv);}
              else{$rq_nom_srv = sel_quo("nom","dev_srv","id",-$id_srv);}
              $dt_nom_srv = ftc_ass($rq_nom_srv);
?>
  <div style="page-break-inside: avoid">
    <span class="fs_mdl2" style="color:#<?php echo $col[$id_col]; ?>;">
<?php
              if(!empty($dt_nom_srv['titre'])){echo $dt_nom_srv['titre'];}
              else{echo $dt_nom_srv['nom'];}
?>
    </span>
    <table>
<?php
              if(isset($bss[$id_trf])){
                foreach($bss[$id_trf] as $i => $base){
                  if($id_cat_prs>0){
                    $prx = $trf_opt_srv_opt_prs_cat[$id_cat_prs][$j][$i];
                    $err = $err_trf_opt_srv_opt_cat[$id_cat_prs][$j][$i];
                  }
                  else{
                    $prx = $trf_opt_srv_opt_prs[$id_dev_prs][$j][$i];
                    $err = $err_trf_opt_srv_opt_prs[$id_dev_prs][$j][$i];
                  }
?>
      <tr>
<?php
    						  if(!$clt_tmpl[$id_clt] or $flagMultiBss or $vue_sgl or $vue_tpl or $vue_qdp)
    						  {
?>
		    <td style="padding: 0px 5px;" class="fs6">
<?php
                    echo $txt_prg->base->$id_lgg.' '.$base;
                    if($ptl){echo '&#43;1';}
                    echo ' :';
?>
        </td>
<?php
					         }
?>
        <td style="padding: 0px 5px;" class="fs9">
<?php
                  if($err){echo '<span class="color-red">'.$txt->err->opt_srv->$id_lng.'</span>';}
                  echo number_format($prx,0,',',' ');
?>
</td>
        <td style="padding: 0px 5px;" class="fs6"><?php echo $prm_crr_nom[$dt_crc['crr']].$txt_prg->pers2->$id_lgg; ?></td>
      </tr>
<?php
                }
              }
?>
    </table>
  </div>
<?php
            }
          }
          if(isset($hbr_id_opt_prs[$id_dev_prs])){
?>
  <br/>
  <div style="page-break-inside: avoid">
    <span class="fs_mdl2" style="color:#<?php echo $col[$id_col]; ?>;text-transform: uppercase;"><?php echo $txt_prg->hbr_sel->$id_lgg; ?></span>
    <table class="ts2">
      <tr>
        <td class="cs6"><?php echo $txt_prg->vll->$id_lgg; ?></td>
        <td class="cs6"><?php echo $txt_prg->ctg->$id_lgg; ?></td>
        <td class="cs6"><?php echo $txt_prg->hbr->$id_lgg; ?></td>
        <td class="cs6"><?php echo $txt_prg->chm->$id_lgg; ?></td>
      </tr>
<?php
            foreach($hbr_id_opt_prs[$id_dev_prs] as $i => $id_hbr){
?>
      <tr>
<?php
              if($id_hbr>0){
                $dt_hbr = ftc_ass(sel_quo("*","cat_hbr LEFT JOIN cat_hbr_txt ON cat_hbr.id = cat_hbr_txt.id_hbr AND lgg=".$lgg_crc,"cat_hbr.id",$id_hbr));
?>
        <td class="cs7"><?php echo stripslashes($vll[$dt_hbr['id_vll']]); ?></td>
        <td class="cs7"><?php echo $ctg_hbr[$id_lng][$dt_hbr['ctg']]; ?></td>
        <td class="cs7">
<?php
                if(empty($dt_hbr['titre'])){echo stripslashes($dt_hbr['nom']);}
                elseif(!empty($dt_hbr['web'])){echo '<a href="'.$dt_hbr['web'].'" target="_blank">'.stripslashes($dt_hbr['titre']).'</a>';}
                else{echo stripslashes($dt_hbr['titre']);}
?>
        </td>
        <td class="cs7">
<?php
                if($chm_id_opt_prs[$id_dev_prs][$i]!=0){
                  $dt_chm = ftc_ass(sel_quo("nom,titre","cat_hbr_chm LEFT JOIN cat_hbr_chm_txt ON cat_hbr_chm.id = cat_hbr_chm_txt.id_hbr_chm AND lgg=".$lgg_crc,"cat_hbr_chm.id",$chm_id_opt_prs[$id_dev_prs][$i]));
                  if(!empty($dt_chm['titre'])){echo stripslashes($dt_chm['titre']);}
                  else{echo stripslashes($dt_chm['nom']);}
                }
                else{echo $txt->err->chm->$id_lng;}
?>
        </td>
<?php
              }
              else{
?>
        <td class="cs7"><?php echo stripslashes($vll[$vll_hbr_opt_prs[$id_dev_prs][$i]]); ?></td>
        <td class="cs7"><?php echo $txt->err->hbr->$id_lng; ?></td>
<?php
              }
?>
      </tr>
<?php
            }
?>
    </table>
  </div>
<?php
            if(isset($opt_hbr_id_opt_prs[$id_dev_prs])){
?>
  <br/>
  <div style="page-break-inside: avoid">
    <span class="fs_mdl2" style="color:#<?php echo $col[$id_col]; ?>;text-transform: uppercase;"><?php echo $txt_prg->hbr_opt->$id_lgg; ?></span>
    <table class="ts2">
      <tr>
        <td class="cs6"><?php echo $txt_prg->vll->$id_lgg; ?></td>
        <td class="cs6"><?php echo $txt_prg->ctg->$id_lgg; ?></td>
        <td class="cs6"><?php echo $txt_prg->hbr->$id_lgg; ?></td>
        <td class="cs6"><?php echo $txt_prg->chm->$id_lgg; ?></td>
        <td class="cs6"><?php echo $txt_prg->sup->$id_lgg; ?></td>
      </tr>
<?php
              foreach($opt_hbr_id_opt_prs[$id_dev_prs] as $i => $id_hbr){
                if($id_cat_prs>0){
                  $prx = $trf_opt_hbr_db_opt_prs_cat[$id_cat_prs][$i]/2;
                  $prx_sg = $trf_opt_hbr_sg_opt_prs_cat[$id_cat_prs][$i];
                  $prx_tp = $trf_opt_hbr_tp_opt_prs_cat[$id_cat_prs][$i]/3;
                  $prx_qd = $trf_opt_hbr_qd_opt_prs_cat[$id_cat_prs][$i]/4;
                  $err_sg = $err_trf_sg_opt_hbr_opt_prs_cat[$id_cat_prs][$i];
                  $err_db = $err_trf_db_opt_hbr_opt_prs_cat[$id_cat_prs][$i];
                  $err_tp = $err_trf_tp_opt_hbr_opt_prs_cat[$id_cat_prs][$i];
                  $err_qd = $err_trf_qd_opt_hbr_opt_prs_cat[$id_cat_prs][$i];
                }
                else{
                  $prx = $trf_opt_hbr_db_opt_prs[$id_dev_prs][$i]/2;
                  $prx_sg = $trf_opt_hbr_sg_opt_prs[$id_dev_prs][$i];
                  $prx_tp = $trf_opt_hbr_tp_opt_prs[$id_dev_prs][$i]/3;
                  $prx_qd = $trf_opt_hbr_qd_opt_prs[$id_dev_prs][$i]/4;
                  $err_sg = $err_trf_sg_opt_hbr_opt_prs[$id_dev_prs][$i];
                  $err_db = $err_trf_db_opt_hbr_opt_prs[$id_dev_prs][$i];
                  $err_tp = $err_trf_tp_opt_hbr_opt_prs[$id_dev_prs][$i];
                  $err_qd = $err_trf_qd_opt_hbr_opt_prs[$id_dev_prs][$i];
                }
?>
      <tr>
<?php
                if($id_hbr>0){
                  $dt_hbr = ftc_ass(sel_quo("*","cat_hbr LEFT JOIN cat_hbr_txt ON cat_hbr.id = cat_hbr_txt.id_hbr AND lgg=".$lgg_crc,"cat_hbr.id",$id_hbr));
?>
        <td class="cs7"><?php echo stripslashes($vll[$dt_hbr['id_vll']]); ?></td>
        <td class="cs7"><?php echo stripslashes($ctg_hbr[$id_lng][$dt_hbr['ctg']]); ?></td>
        <td class="cs7">
<?php
                  if(empty($dt_hbr['titre'])){echo stripslashes($dt_hbr['nom']);}
                  elseif(!empty($dt_hbr['web'])){echo '<a href="'.$dt_hbr['web'].'" target="_blank">'.stripslashes($dt_hbr['titre']).'</a>';}
                  else{echo stripslashes($dt_hbr['titre']);}
?>
        </td>
        <td class="cs7">
<?php
                  if($opt_chm_id_opt_prs[$id_dev_prs][$i]!=0){
                    $dt_chm = ftc_ass(sel_quo("nom,titre","cat_hbr_chm LEFT JOIN cat_hbr_chm_txt ON cat_hbr_chm.id = cat_hbr_chm_txt.id_hbr_chm AND lgg=".$lgg_crc,"cat_hbr_chm.id",$opt_chm_id_opt_prs[$id_dev_prs][$i]));
                    if(!empty($dt_chm['titre'])){echo stripslashes($dt_chm['titre']);}
                    else{echo stripslashes($dt_chm['nom']);}
                  }
                  else{echo $txt->err->chm->$id_lng;}
?>
        </td>
<?php
                }
                else{
?>
        <td class="cs7"><?php echo stripslashes($vll[$opt_hbr_vll_opt_prs[$id_dev_prs][$i]]); ?></td>
        <td class="cs7"><?php echo $txt->err->hbr->$id_lng; ?></td>
        <td class="cs7"></td>
        <td class="cs7"></td>
<?php
                }
?>
        <td class="cs7">
<?php
                if($vue_sgl){
                  echo $txt_prg->sgl->$id_lgg.' : ';
                  if(!$err_sg){echo number_format($prx_sg,0,',',' ').' '.$prm_crr_nom[$dt_crc['crr']].$txt_prg->pers2->$id_lgg;}
                  else{echo $txt->err->trf->$id_lng;}
                  echo '<br/>';
                }
                if($vue_dbl){
                  echo $txt_prg->dbl->$id_lgg.' : ';
                  if(!$err_db){echo number_format($prx,0,',',' ').' '.$prm_crr_nom[$dt_crc['crr']].$txt_prg->pers2->$id_lgg;}
                  else{echo $txt->err->trf->$id_lng;}
                  echo '<br/>';
                }
                if($vue_tpl){
                  echo $txt_prg->tpl->$id_lgg.' : ';
                  if(!$err_tp){echo number_format($prx_tp,0,',',' ').' '.$prm_crr_nom[$dt_crc['crr']].$txt_prg->pers2->$id_lgg;}
                  else{echo $txt->err->trf->$id_lng;}
                  echo '<br/>';
                }
                if($vue_qdp){
                  echo $txt_prg->qdp->$id_lgg.' : ';
                  if(!$err_qd){echo number_format($prx_qd,0,',',' ').' '.$prm_crr_nom[$dt_crc['crr']].$txt_prg->pers2->$id_lgg;}
                  else{echo $txt->err->trf->$id_lng;}
                  echo '<br/>';
                }
?>
        </td>
      </tr>
<?php
              }
?>
    </table>
  </div>
<?php
            }
?>
  <br/>
<?php
          }
?>
  <br/>
<?php
        }
      }
    }
  if(!$id_trf){$flg_trf_mdl=false;}
  }
}
?>
</div>
<br/>
