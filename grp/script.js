var flg_maj = true, flg_shd = false, id_grp, upd = 0;

function maj(tab,col,val,id){
	if(flg_maj){upd++;console.log('upd '+upd);flg_maj = false;}
	if(window.XMLHttpRequest){eval('xmlhttp_maj'+id+col+'=new XMLHttpRequest()');}
	else{eval('xmlhttp_maj'+id+col+'=new ActiveXObject("Microsoft.XMLHTTP")');}
	eval('xmlhttp_maj'+id+col).onreadystatechange=function(){
		if(eval('xmlhttp_maj'+id+col).readyState==4){
			if(eval('xmlhttp_maj'+id+col).status==200){
				if(col=='nomgrp'){act_tab();window.parent.act_frm('grp');}
				else if(col=='nom' || col=='pre'){window.parent.act_frm('pax');}
				else if(col=='dob' || col=='exp'){vue_elem('pax',id,col);}
				else if(col=='ncn'){vue_elem('pax_ncn'+id,id_grp);}
				else if(col=='prt'){vue_elem('pax_grp');window.parent.act_frm('pax');act_tab();}
				else if(tab=='grp_tsk'){
					window.parent.act_frm('tsk');
					if(col=='date' || col=='respon' || col=='stat'){vue_elem('tsk_grp');}
				}
			}
			else if(eval('xmlhttp_maj'+id+col).status==408){maj(tab,col,val,id);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>SAVE ERROR</span>";console.log(eval('xmlhttp_maj'+id+col).statusText);}
			if(!flg_maj){upd--;console.log('upd '+upd);flg_maj = true;}
		}
	}
	eval('xmlhttp_maj'+id+col).open("POST","maj.php",true);
	eval('xmlhttp_maj'+id+col).setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	eval('xmlhttp_maj'+id+col).send("tab="+tab+"&col="+col+"&val="+encodeURIComponent(val)+"&id="+id);
}

function act_tab(){
	if(window.XMLHttpRequest){xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	xmlhttp.onreadystatechange=function(){
		if(xmlhttp.readyState==4){
			if(xmlhttp.status==200){window.parent.act_tab('grp/ctr.php?id='+id_grp,xmlhttp.responseText);}
			else if(xmlhttp.status==408){act_tab();}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR ACT_TAB "+xmlhttp.statusText+" </span>";}
		}
	}
	xmlhttp.open("POST","nom_tab.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("id_grp="+id_grp);
}

function act_frm(cbl){
	var elem = document.getElementsByClassName(cbl);
	for(var i = 0; i < elem.length; i++){vue_elem(elem[i].id,id_grp);}
}

function ajt_pax(){
	if(window.XMLHttpRequest){xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load("GRP AJT PAX");
	xmlhttp.onreadystatechange=function(){
		if(xmlhttp.readyState==4){
			if(xmlhttp.status==200){vue_elem('pax_grp');window.parent.act_frm('pax');act_tab();}
			else if(xmlhttp.status==408){ajt_pax();}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR AJT_PAX "+xmlhttp.statusText+" </span>";}
			unload("GRP AJT PAX");
		}
	}
	xmlhttp.open("POST","ajt_pax.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("id_grp="+id_grp);
}

function ajt_tsk(){
	if(window.XMLHttpRequest){xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load("GRP AJT TSK");
	xmlhttp.onreadystatechange=function(){
		if(xmlhttp.readyState==4){
			if(xmlhttp.status==200){vue_elem('tsk_grp');window.parent.act_frm('tsk');}
			else if(xmlhttp.status==408){ajt_tsk();}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR AJT_TSK "+xmlhttp.statusText+" </span>";}
			unload("GRP AJT TSK");
		}
	}
	xmlhttp.open("POST","ajt_tsk.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("id_grp="+id_grp);
}

function ajt_fac(){
	if(window.XMLHttpRequest){xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load("GRP AJT FAC");
	xmlhttp.onreadystatechange=function(){
		if(xmlhttp.readyState==4){
			if(xmlhttp.status==200){vue_elem('fac_grp');}
			else if(xmlhttp.status==408){ajt_fac();}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR AJT_FAC "+xmlhttp.statusText+" </span>";}
			unload("GRP AJT FAC");
		}
	}
	xmlhttp.open("POST","ajt_fac.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("id_grp="+id_grp);
}

function sup_pax(id){
	if(window.XMLHttpRequest){xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load("GRP SUP PAX");
	xmlhttp.onreadystatechange=function(){
		if(xmlhttp.readyState==4){
			if(xmlhttp.status==200){
				if(xmlhttp.responseText==''){vue_elem('pax_grp');window.parent.act_frm('pax');act_tab();}
				else{alt(xmlhttp.responseText);}
			}
			else if(xmlhttp.statu ==408){sup_pax(id);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR SUP_PAX "+xmlhttp.statusText+" </span>";}
			unload("GRP SUP PAX");
		}
	}
	xmlhttp.open("POST","sup_pax.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("id="+id);
}

function sup_tsk(id){
	if(window.XMLHttpRequest){xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load("GRP SUP TSK");
	xmlhttp.onreadystatechange=function(){
		if(xmlhttp.readyState==4){
			if(xmlhttp.status==200){vue_elem('tsk_grp');window.parent.act_frm('tsk');}
			else if(xmlhttp.status==408){sup_tsk(id);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR SUP_TSK "+xmlhttp.statusText+" </span>";}
			unload("GRP SUP TSK");
		}
	}
	xmlhttp.open("POST","sup_tsk.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("id="+id);
}

function sup_fac(id){
	if(window.XMLHttpRequest){xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load("GRP SUP FAC");
	xmlhttp.onreadystatechange=function(){
		if(xmlhttp.readyState==4){
			if(xmlhttp.status==200){vue_elem('fac_grp');}
			else if(xmlhttp.status==408){sup_fac(id);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR SUP_FAC "+xmlhttp.statusText+" </span>";}
			unload("GRP SUP FAC");
		}
	}
	xmlhttp.open("POST","sup_fac.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("id="+id);
}

function sup_res(id_crc,id,obj){
	if(window.XMLHttpRequest){xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load("GRP SUP RES");
	xmlhttp.onreadystatechange=function(){
		if(xmlhttp.readyState==4){
			if(xmlhttp.status==200){
				if(obj=='hbr'){vue_elem('res_hbr');window.parent.act_frm('res_hbr');window.parent.act_frm('cat_dev_hbr'+id);}
				else if(obj=='frn'){vue_elem('res_frn');window.parent.act_frm('res_frn');window.parent.act_frm('frn_dev_srv'+id);}
			}
			else if(xmlhttp.status==408){sup_res(id_crc,id,obj)}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR SUP_RES "+xmlhttp.statusText+" </span>";}
			unload("GRP SUP RES");
		}
	}
	xmlhttp.open("POST","sup_res.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("id_crc="+id_crc+"&id="+id+"&obj="+obj);
}

function vue_elem(obj,id,col){
	if(typeof id == 'undefined'){id = id_grp;}
	if(typeof col == 'undefined'){var xhr = id+obj;}
	else if(typeof id === 'string'){
		id = id.replace("-","_");
		var xhr = id+obj+col;
	}
	else{var xhr = obj+col;}
	if(window.XMLHttpRequest){eval('xmlhttp_vue_elem'+xhr+'=new XMLHttpRequest()');}
	else{eval('xmlhttp_vue_elem'+xhr+'=new ActiveXObject("Microsoft.XMLHTTP")');}
	if(document.getElementById(obj)){load('GRP vue_elem '+xhr);}
	else if(document.getElementById(obj+'_'+col+id)){
		var bck = document.getElementById(obj+'_'+col+id).style.backgroundColor;
		document.getElementById(obj+'_'+col+id).style.backgroundColor  = "lightgrey";
	}
	eval('xmlhttp_vue_elem'+xhr).onreadystatechange=function(){
		if(eval('typeof xmlhttp_vue_elem'+xhr) !== 'undefined' && eval('xmlhttp_vue_elem'+xhr).readyState==4){
			if(eval('xmlhttp_vue_elem'+xhr).status==200){
				if(document.getElementById(obj+'_'+col+id)){
					document.getElementById(obj+'_'+col+id).value = eval('xmlhttp_vue_elem'+xhr).responseText;
					document.getElementById(obj+'_'+col+id).style.backgroundColor  = bck;
				}
				else if(document.getElementById(obj)){document.getElementById(obj).innerHTML=eval('xmlhttp_vue_elem'+xhr).responseText;}
			}
			else if(eval('xmlhttp_vue_elem'+xhr).status==408){vue_elem(obj,id,col);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR VUE_ELEM "+eval('xmlhttp_vue_elem'+xhr).statusText+" </span>";}
			if(document.getElementById(obj)){unload('GRP vue_elem '+xhr);}
		}
	}
	eval('xmlhttp_vue_elem'+xhr).open("POST","vue_elem.php",true);
	eval('xmlhttp_vue_elem'+xhr).setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	eval('xmlhttp_vue_elem'+xhr).send("id="+id+"&obj="+obj+"&col="+col);
}

function vue_fll(cbl,obj,src){
	var xhr = obj,id=id_grp;
	if(window.XMLHttpRequest){eval('xmlhttp_vue_fll'+xhr+'=new XMLHttpRequest()');}
	else{eval('xmlhttp_vue_fll'+xhr+'=new ActiveXObject("Microsoft.XMLHTTP")');}
	eval('xmlhttp_vue_fll'+xhr).onreadystatechange=function(){
		if(eval('xmlhttp_vue_fll'+xhr).readyState==4){
			if(eval('xmlhttp_vue_fll'+xhr).status==200){
				if(document.getElementById("lst_"+obj)){
					document.getElementById("lst_"+obj).innerHTML=eval('xmlhttp_vue_fll'+xhr).responseText;
					heightovery("lst_"+obj);
					heightmrgtp(document.getElementById("lst_"+obj).parentNode.id);
				}
			}
			else if(eval('xmlhttp_vue_fll'+xhr).status==408){vue_fll(cbl,obj,src);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR VUE_FLL "+eval('xmlhttp_vue_fll'+xhr).statusText+" </span>";}
		}
	}
	eval('xmlhttp_vue_fll'+xhr).open("POST","vue_fll.php",true);
	eval('xmlhttp_vue_fll'+xhr).setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	eval('xmlhttp_vue_fll'+xhr).send("cbl="+cbl+"&obj="+obj+"&src="+encodeURIComponent(src)+"&id="+id);
}

function src_pax(id_pax){
	if(flg_shd){
		$(".shd_pax").css({ opacity: 1 });
		$(".shd_crc").css({ opacity: 1 });
		flg_shd = false;
	}
	else{
		$.ajax({url: 'src_pax.php', type: 'post', data: {"id_pax":id_pax},
			success: function(responseText){
				if(responseText != '0'){
					flg_shd = true;
					$(".shd_pax").css({ opacity: 0.5 });
					$("#shd_pax"+id_pax).css({ opacity: 1 });
					$(".shd_crc").css({ opacity: 0.5 });
					var arr_crc = responseText.split("|");
					$.each(arr_crc, function(key,id_dev){
						$("#shd_crc"+id_dev).css({ opacity: 1 });
					});
				}
			},
			error: function (request, status, error){
				src_pax(id_pax);
				$("#txtHint").html("<span style='background: red;'>SRC_PAX ERROR</span>");console.log('SRC_PAX ERROR: '+request.statusText);
			}
		});
	}
}
