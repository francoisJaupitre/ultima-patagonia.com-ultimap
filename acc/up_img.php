<?php
include("../prm/fct.php");
include("../prm/aut.php");
$id_rgn = $_POST["rgn"];
if(isset($_FILES['file']) AND $_FILES['file']['error'] == 0){
	//if($_FILES['file']['size'] <= 1000000){
		$image = preg_replace("/[^a-zA-Z0-9.]/", "",$_FILES["file"]["name"]);
		$inf = pathinfo($_FILES["file"]["name"]);
        $ext = $inf['extension'];
        $arr_ext = array('jpg', 'jpeg', 'gif', 'png');
        if (in_array(strtolower($ext), $arr_ext)){
			$uploadedfile = $_FILES['file']['tmp_name'];
			//echo filesize($_FILES['file']['tmp_name'])/1024;
			if(strtolower($ext) == "jpg" || strtolower($ext) == "jpeg" ){$src = imagecreatefromjpeg($uploadedfile);}
			else if(strtolower($ext) == "png"){$src = imagecreatefrompng($uploadedfile);}
			else{$src = imagecreatefromgif($uploadedfile);}
			list($width,$height) = getimagesize($uploadedfile);
			$newwidth = 300;
			$newheight = ($height/$width)*$newwidth;
			$tmp = imagecreatetruecolor($newwidth,$newheight);
			imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
			$filename = '../pic/'.$dir.'/'.$image;
			while(file_exists($filename)){
				$filename = '../pic/'.$dir.'/'.basename($image,'.'.$ext).'(1).'.$ext;
				$image = basename($image,".".$ext).'(1).'.$ext;
			}
			imagejpeg($tmp,$filename,100);
			imagedestroy($src);
			imagedestroy($tmp);
			$id_pic = insert("cat_pic",array("pic","id_rgn",'dt_cat','usr'),array($image,$id_rgn,date("Y-m-d"),$id_usr));
			echo $id_pic;
		}
	//}
}
?>
