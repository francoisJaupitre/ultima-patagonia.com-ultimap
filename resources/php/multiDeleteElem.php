<?php
$request = file_get_contents("php://input");
$data = json_decode($request, true);
if(isset($data['ids']) and isset($data['cbl']))
{
  $ids = $data['ids'];
  $cbl = $data['cbl'];
  include("../../prm/fct.php");
  include("../../prm/aut.php");
  $txt = simplexml_load_file('../../acc/txt.xml');
  switch($cbl)
  {
		case 'grp':
      $err = '';
      foreach($ids as $id)
      {
        $num_crc = sel_quo("id", "dev_crc", "id_grp", $id);
        $num_fin = sel_quo("id", "fin_bdg", "id_grp", $id);
        if(num_rows($num_crc) == 0 and num_rows($num_fin) == 0)
        {
          delete("grp_res", "id_grp", $id);
          delete("grp_pax", "id_grp", $id);
          delete("grp_dev", "id", $id);
        }else{
          $err = $txt->del_pls_grp->$id_lng;
        }
      }
      if($err != '')
      {
        echo json_encode($err);
      }
      break;
    case 'arc':
      foreach($ids as $id)
      {
        $rq_crc = sel_quo("id_grp", "dev_crc", "id", $id);
        if(num_rows($rq_crc))
        { //serveur bug erreur d'affichage (deja effacé)
          $rq_sel_mdl = sel_quo("id", "dev_mdl", "id_crc", $id);
          while($dt_sel_mdl = ftc_ass($rq_sel_mdl))
          {
            $id_mdl = $dt_sel_mdl['id'];
            delete("dev_mdl_pax", "id_mdl", $id_mdl);
            $rq_sel_rmn = sel_quo("id", "dev_mdl_rmn", "id_mdl", $id_mdl);
            while($dt_sel_rmn = ftc_ass($rq_sel_rmn))
            {
              delete("dev_mdl_rmn_pax", "id_rmn", $dt_sel_rmn['id']);
            }
            delete("dev_mdl_rmn", "id_mdl", $id_mdl);
            delete("dev_mdl_bss", "id_mdl", $id_mdl);
            delete("dev_mdl_rgn", "id_mdl", $id_mdl);
            $rq_sel_jrn = sel_quo("id", "dev_jrn", "id_mdl", $id_mdl);
            while($dt_sel_jrn = ftc_ass($rq_sel_jrn))
            {
              $id_jrn = $dt_sel_jrn['id'];
              $rq_sel_prs = sel_quo("id", "dev_prs", "id_jrn", $id_jrn);
              while($dt_sel_prs = ftc_ass($rq_sel_prs))
              {
                $id_prs = $dt_sel_prs['id'];
                $rq_sel_srv = sel_quo("id", "dev_srv", "id_prs", $id_prs);
                while($dt_sel_srv = ftc_ass($rq_sel_srv))
                {
                  $id_srv = $dt_sel_srv['id'];
                  delete("dev_srv_pay", "id_srv", $id_srv);
                  delete("dev_srv_trf", "id_srv", $id_srv);
                }
                delete("dev_srv", "id_prs", $id_prs);
                $rq_sel_hbr = sel_quo("id", "dev_hbr", "id_prs", $dt_sel_prs['id']);
                while($dt_sel_hbr = ftc_ass($rq_sel_hbr))
                {
                  delete("dev_hbr_pay", "id_hbr", $dt_sel_hbr['id']);
                }
                delete("dev_hbr", "id_prs", $id_prs);
              }
              delete("dev_prs", "id_jrn", $id_jrn);
            }
            delete("dev_jrn", "id_mdl", $id_mdl);
            delete("dev_mdl_bss", "id_mdl", $id_mdl);
          }
          delete("dev_mdl", "id_crc", $id);
          delete("dev_crc_pax", "id_crc", $id);
          $rq_sel_rmn = sel_quo("id", "dev_crc_rmn", "id_crc", $id);
          while($dt_sel_rmn = ftc_ass($rq_sel_rmn))
          {
            delete("dev_crc_rmn_pax", "id_rmn", $dt_sel_rmn['id']);
          }
          delete("dev_crc_rmn", "id_crc", $id);
          delete("dev_crc_bss", "id_crc", $id);
          delete("dev_vol", "id_crc", $id);
          $dt_crc = ftc_ass($rq_crc);
          $id_grp = $dt_crc['id_grp'];
          $rq_crc = sel_quo("id", "dev_crc", "id_grp", $id_grp);
          $rq_pax = sel_quo("id", "grp_pax", "id_grp", $id_grp);
          $rq_res = sel_quo("id", "grp_res", "id_grp", $id_grp);
          $rq_tsk = sel_quo("id", "grp_tsk", "id_grp", $id_grp);
          if(num_rows($rq_crc) == 0 and num_rows($rq_pax) == 0 and num_rows($rq_res) == 0 and num_rows($rq_tsk) == 0)
          {
            delete("grp_dev", "id", $id_grp);
          }
          delete("dev_crc", "id", $id);
        }
      }
      break;
  }
}
?>
