<?php
include("../prm/fct.php");
include("../prm/aut.php");
if(isset($_POST['url'])) {
  $url = explode('&',rawurldecode($_POST['url']));
  foreach($url as $u) {$data[substr($u,0,strpos($u,'='))] = substr($u,strpos($u,'=')+1);}
  $id_ctc = insert("crm_ctc",array("nom","mail","tel","canal","dt_ctc"),array($data['name'],$data['email'],$data['phone'],$data['channel'],date("Y-m-d")));
  insert("crm_ech",array("id_ctc","periode","duree","nombre","commen","respon","dt_ech","dt_stat"),array($id_ctc,$data['dates'],$data['duration'],$data['participants'],$data['comment'],$id_usr,date("Y-m-d"),date("Y-m-d")));
}
else{
  $id_ctc = insert("crm_ctc","dt_ctc",date("Y-m-d"));
  insert("crm_ech",array("id_ctc","respon","dt_ech","dt_stat"),array($id_ctc,$id_usr,date("Y-m-d"),date("Y-m-d")));
}
?>
