<?php
$id_cat_srv = insert(
  'cat_srv',
  array('id_vll', 'ctg', 'lgg', 'nom', 'res', 'dt_cat', 'usr'),
  array($id_vll, $ctg, $lgg_ctg, $nom_srv, '1', date("Y-m-d"), $id_usr)
);
if($id_dev_srv > 0)
{
  upd_quo('dev_srv', array('id_cat', 'nom'), array($id_cat_srv, $nom_srv), $id_dev_srv);
}
?>
