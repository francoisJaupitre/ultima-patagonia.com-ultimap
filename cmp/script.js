var flg_maj = true, flg_dt_fac = rang = 1,upd = 0;

function maj(tab,col,val,id,id_sup){
	if(flg_maj){upd++;console.log('upd '+upd);flg_maj = false;}
	if(window.XMLHttpRequest){eval('xmlhttp_maj'+id+col+'=new XMLHttpRequest()');}
	else{eval('xmlhttp_maj'+id+col+'=new ActiveXObject("Microsoft.XMLHTTP")');}
	if((tab!='cmp_fac' || col=='date') && col!='dsc'){load('CMP maj');}
	eval('xmlhttp_maj'+id+col).onreadystatechange=function(){
		if(eval('xmlhttp_maj'+id+col).readyState==4){
			if(eval('xmlhttp_maj'+id+col).status==200){
				if(tab=='cmp_fac'){
					if(col=='date'){vue('fac');window.parent.act_frm('clc');window.parent.act_frm('rsm');}
					else if(col=='vnt'){
						if(val==0){$(".fac_cpt"+id).prop("disabled", true);}
						else{$(".fac_cpt"+id).prop("disabled", false);}
						window.parent.act_frm('clc');window.parent.act_frm('rsm');
					}
				}
				else if(tab=='cmp_itm'){
					if(col=='dvs'){vue_elem('itm_tx'+id,id);vue_elem('fac_err'+id_sup,id_sup);vue_elem('itm',id,col);}
					else if(col=='id_crr'){vue_elem('itm_tx'+id,id);vue_elem('fac_err'+id_sup,id_sup);}
					else if(col=='sld'){vue_elem('itm_tx'+id,id);vue_elem('fac_err'+id_sup,id_sup);vue_elem('itm',id,col);window.parent.act_frm('clc');vue_elem('fac_sum'+id_sup,id_sup);}
					else if(col =='id_itm'){window.parent.act_frm('clc');}
					else if(col=='cpt'){vue_elem('itm',id,col);vue_elem('fac_vnt'+id_sup,id_sup);window.parent.act_frm('clc');window.parent.act_frm('rsm');}
					else if(col=='id_grp'){vue_elem('fac_err'+id_sup,id_sup);window.parent.act_frm('clc');}
				}
				else if(tab=='cmp_clc'){
					if(col=='dvs'){vue_elem('clc',id,col);vue_elem('clc_tx'+id,id);}
					else if(col=='id_crr'){vue_elem('clc_tx'+id,id);}
					else if(col=='sld' || col=='prx'){window.parent.act_frm('clc');}//ne modifier que le groupe en cours.
				}
				if(document.getElementById("txtHint").innerHTML.includes("SAVE ERROR")){document.getElementById("txtHint").innerHTML="";}
			}
			else if(eval('xmlhttp_maj'+id+col).status==408){maj(tab,col,val,id,id_sup);}
			else{
				document.getElementById("txtHint").innerHTML="<span style='background: red;'>SAVE ERROR</span>";
				console.log(eval('xmlhttp_maj'+id+col).statusText);
			}
			if(!flg_maj){
				upd--;
				console.log('upd '+upd);
				flg_maj = true;
			}
			if((tab!='cmp_fac' || col=='date') && col!='dsc'){unload('CMP maj');}
		}
	}
	eval('xmlhttp_maj'+id+col).open("POST","maj.php",true);
	eval('xmlhttp_maj'+id+col).setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	eval('xmlhttp_maj'+id+col).send("tab="+tab+"&col="+col+"&val="+encodeURIComponent(val)+"&id="+id+"&id_sup="+id_sup);
}

function ajt(obj,id_sup){
	var dat = document.getElementById("dat_max").value;
	var nom_rai = document.getElementById('sel_rai').value;
	var nom_imp = document.getElementById('sel_imp').value;
	var id_vnt = document.getElementById('sel_vnt').value;
	var id_ctr = document.getElementById('sel_ctr').value;
	var id_itm = document.getElementById('sel_itm').value;
	var id_grp = document.getElementById('sel_cnf').value;
	if(window.XMLHttpRequest){xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load('CMP ajt');
	xmlhttp.onreadystatechange=function(){
		if(xmlhttp.readyState==4){
			if(xmlhttp.status==200){
				if(obj=='fac'){vue('fac');}
				else{vue_elem('fac_itm'+id_sup);}
			}
			else if(xmlhttp.status==408){ajt(obj,id_sup);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR AJT "+xmlhttp.statusText+" </span>";}
			unload('CMP ajt');
		}
	}
	xmlhttp.open("POST","ajt.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("obj="+obj+"&id_sup="+id_sup+"&dat="+dat+"&nom_rai="+encodeURIComponent(nom_rai)+"&nom_imp="+encodeURIComponent(nom_imp)+"&id_vnt="+id_vnt+"&id_ctr="+id_ctr+"&id_itm="+id_itm+"&id_grp="+id_grp);
}

function sup(obj,id,id_sup){
	if(window.XMLHttpRequest){xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load('CMP sup');
	xmlhttp.onreadystatechange=function(){
		if(xmlhttp.readyState==4){
			if(xmlhttp.status==200){
				if(obj=='fac'){vue('fac');}
				else{vue_elem('fac_itm'+id_sup);}
				window.parent.act_frm('clc');
				window.parent.act_frm('rsm');
			}
			else if(xmlhttp.status==408){sup(obj,id,id_sup);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR SUP "+xmlhttp.statusText+" </span>";}
			unload('CMP sup');
		}
	}
	xmlhttp.open("POST","sup.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("obj="+obj+"&id="+id);
}

function act_tab(){
	var cbl = document.getElementById('cbl').value;
	if(window.XMLHttpRequest){xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	xmlhttp.onreadystatechange=function(){
		if(xmlhttp.readyState==4){
			if(xmlhttp.status==200){
				window.parent.act_tab('cmp/ctr.php?cbl='+cbl,xmlhttp.responseText);
				if($(document).height() == $(window).height()){vue_dt_fac();}
				}
			else if(xmlhttp.status==408){act_tab();}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR ACT_TAB "+xmlhttp.statusText+" </span>";}
		}
	}
	xmlhttp.open("POST","nom_tab.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("cbl="+cbl);
}

function vue(cbl){
	if(document.getElementById("dat_max")){var dat_max = document.getElementById("dat_max").value;}
	else{var dat_max = '';}
	if(document.getElementById("dat_min")){var dat_min = document.getElementById("dat_min").value;}
	else{var dat_min = '';}
	if(cbl=='fac'){
		var nom_rai = document.getElementById('sel_rai').value;
		var nom_imp = document.getElementById('sel_imp').value;
		var id_vnt = document.getElementById('sel_vnt').value;
		var id_ctr = document.getElementById('sel_ctr').value;
		var id_itm = document.getElementById('sel_itm').value;
		var id_grp = document.getElementById('sel_cnf').value;
	}
	if(window.XMLHttpRequest){eval('xmlhttp_vue'+cbl+'=new XMLHttpRequest()');}
	else{eval('xmlhttp_vue'+cbl+'=new ActiveXObject("Microsoft.XMLHTTP")');}
	load('CMP vue');
	eval('xmlhttp_vue'+cbl).onreadystatechange=function(){
		if(eval('xmlhttp_vue'+cbl).readyState==4){
			if(eval('xmlhttp_vue'+cbl).status==200){
				document.getElementById("vue_"+cbl).innerHTML=eval('xmlhttp_vue'+cbl).responseText;
				if(cbl=='fac'){
					rang=1;
					flg_dt_fac=1;
					if($(document).height() == $(window).height()){vue_dt_fac();}
				}
			}
			else if(eval('xmlhttp_vue'+cbl).status==408){vue(cbl);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR VUE "+eval('xmlhttp_vue'+cbl).statusText+" </span>";}
			unload('CMP vue');
		}
	}
	eval('xmlhttp_vue'+cbl).open("POST","vue.php",true);
	eval('xmlhttp_vue'+cbl).setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	eval('xmlhttp_vue'+cbl).send("cbl="+cbl+"&dat_max="+dat_max+"&dat_min="+dat_min+"&nom_rai="+encodeURIComponent(nom_rai)+"&nom_imp="+encodeURIComponent(nom_imp)+"&id_vnt="+id_vnt+"&id_ctr="+id_ctr+"&id_itm="+id_itm+"&id_grp="+id_grp);
}

function vue_elem(obj,id,col){
	if(typeof col == 'undefined'){var xhr = id+obj;}
	else{var xhr = id+obj+col;}
	if(window.XMLHttpRequest){eval('xmlhttp_vue_elem'+xhr+'=new XMLHttpRequest()');}
	else{eval('xmlhttp_vue_elem'+xhr+'=new ActiveXObject("Microsoft.XMLHTTP")');}
	if(document.getElementById(obj)){load('CMP vue_elem '+xhr);}
	if(document.getElementById(obj+'_'+col+id)){
		var bck = document.getElementById(obj+'_'+col+id).style.backgroundColor;
		document.getElementById(obj+'_'+col+id).style.backgroundColor  = "lightgrey";
	}
	eval('xmlhttp_vue_elem'+xhr).onreadystatechange=function(){
		if(eval('typeof xmlhttp_vue_elem'+xhr) !== 'undefined' && eval('xmlhttp_vue_elem'+xhr).readyState==4){
			if(eval('xmlhttp_vue_elem'+xhr).status==200){
				if(document.getElementById(obj+'_'+col+id)){
					document.getElementById(obj+'_'+col+id).value=eval('xmlhttp_vue_elem'+xhr).responseText;
					document.getElementById(obj+'_'+col+id).style.backgroundColor  = bck;
				}
				else if(document.getElementById(obj)){document.getElementById(obj).innerHTML=eval('xmlhttp_vue_elem'+xhr).responseText;}
			}
			else if(eval('xmlhttp_vue_elem'+xhr).status==408){vue_elem(obj,id,col);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR VUE_ELEM "+eval('xmlhttp_vue_elem'+xhr).statusText+" </span>";}
			if(document.getElementById(obj)){unload('CMP vue_elem '+xhr);}
		}
	}
	eval('xmlhttp_vue_elem'+xhr).open("POST","vue_elem.php",true);
	eval('xmlhttp_vue_elem'+xhr).setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	eval('xmlhttp_vue_elem'+xhr).send("id="+id+"&obj="+obj+"&col="+col);
}

function vue_dt_fac(){
	var cbl = document.getElementById("cbl").value;
	if(cbl=='fac'){
		if(flg_dt_fac==1){
			flg_dt_fac=0
			if(document.getElementById("dat_max")){var dat_max = document.getElementById("dat_max").value;}
			if(document.getElementById("dat_min")){var dat_min = document.getElementById("dat_min").value;}
			if(window.XMLHttpRequest){xmlhttp_dt_fac=new XMLHttpRequest();}
			else{xmlhttp_dt_fac=new ActiveXObject("Microsoft.XMLHTTP");}
			load('vue_dt_fac');
			var nom_rai = document.getElementById('sel_rai').value;
			var nom_imp = document.getElementById('sel_imp').value;
			var id_vnt = document.getElementById('sel_vnt').value;
			var id_ctr = document.getElementById('sel_ctr').value;
			var id_itm = document.getElementById('sel_itm').value;
			var id_grp = document.getElementById('sel_cnf').value;
			rang++;
			xmlhttp_dt_fac.onreadystatechange=function(){
				if(xmlhttp_dt_fac.readyState==4){
					if(xmlhttp_dt_fac.status==200){
						if(xmlhttp_dt_fac.responseText!='0'){
							var arr_dt_fac=xmlhttp_dt_fac.responseText.split("|");
							for(var i= 0; i < arr_dt_fac.length; i++){
								if(arr_dt_fac[i]!=''){
									var arr_dt_fac_2 = arr_dt_fac[i].split("$$");
									var tr_dt_fac = document.createElement('tr');
									tr_dt_fac.id = arr_dt_fac_2[0];
									tr_dt_fac.innerHTML = arr_dt_fac_2[1];
									document.getElementById("tab_fac").appendChild(tr_dt_fac);
								}
							}
							flg_dt_fac=1;
							if($(document).height() == $(window).height()){vue_dt_fac();}
						}
					}
					else if(xmlhttp_dt_fac.status==408){
						flg_dt_fac=1;
						rang--;
						vue_dt_fac();
					}
					else{
						flg_dt_fac=1;
						rang--;
						document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR VUE_DT_FAC "+xmlhttp_dt_fac.statusText+" </span>";
					}
					unload('vue_dt_fac');
				}
			}
			xmlhttp_dt_fac.open("POST","vue_dt_fac.php",true);
			xmlhttp_dt_fac.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xmlhttp_dt_fac.send("rang="+rang+"&dat_max="+dat_max+"&dat_min="+dat_min+"&nom_rai="+encodeURIComponent(nom_rai)+"&nom_imp="+encodeURIComponent(nom_imp)+"&id_vnt="+id_vnt+"&id_ctr="+id_ctr+"&id_itm="+id_itm+"&id_grp="+id_grp);
		}
	}
}

function act_frm(cbl){
	if(document.getElementById("cbl").value==cbl){vue(cbl);}
}

function hide(ref){
	if(document.getElementById('h'+ref).checked){$("."+ref).show();}
	else{
		$("."+ref).hide();
		$("#s"+ref).attr('checked', false);
		$(".inv_"+ref).show();
	}
}

function show(ref){
	$("."+ref).show();
	$("#h"+ref).attr('checked', true);
	$(".inv_"+ref).hide();
}

function init(){//à mettre dans cmpLoad.js
	$(window).scroll(function(){
		if($(window).scrollTop() + $(window).height() >= $(document).height()-20){vue_dt_fac();}
	});
	unload('CMP init');
	$('input[type=number]').on('wheel', function(e){return false;});
}
