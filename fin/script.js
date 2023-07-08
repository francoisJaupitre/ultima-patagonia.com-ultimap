var flg_maj = true, flg_dt_ecr = rang = 1,upd = 0;

function maj(tab,col,val,id,id_sup) {
	var cbl = document.getElementById("cbl").value;
	if(flg_maj) {upd++;console.log('upd '+upd);flg_maj = false;}
	if(window.XMLHttpRequest) {eval('xmlhttp_maj'+id+col+'=new XMLHttpRequest()');}
	else{eval('xmlhttp_maj'+id+col+'=new ActiveXObject("Microsoft.XMLHTTP")');}
	if((tab!='fin_ecr' || col=='date') && col!='dsc') {load('FIN maj');}
	eval('xmlhttp_maj'+id+col).onreadystatechange=function() {
		if(eval('xmlhttp_maj'+id+col).readyState==4) {
			if(eval('xmlhttp_maj'+id+col).status==200) {
				if(tab=='fin_ecr' && col=='date') {vue('ecr');window.parent.act_frm('bln');window.parent.act_frm('rsl');window.parent.act_frm('trs');window.parent.act_frm('fin_grp');vue_end_ecr();}
				else if(tab=='fin_trs') {
					if(col=='dvs') {vue_elem('trs',id,col);vue_elem('trs_tx'+id,id);window.parent.act_frm('bln');window.parent.act_frm('trs');vue_end_ecr();}
					else if(col=='sld') {vue_elem('trs',id,col);vue_elem('trs_tx'+id,id);vue_elem('ecr_err'+id_sup,id_sup);window.parent.act_frm('bln');window.parent.act_frm('rsl');vue_end_ecr();}
					else if(col=='id_css') {vue_elem('ecr_trs_bdg'+id_sup);vue_elem('ecr_err'+id_sup,id_sup);window.parent.act_frm('bln');window.parent.act_frm('trs');vue_end_ecr();}
				}
				else if(tab=='fin_bdg'  && col!='dsc') {
					if(cbl=='ecr') {vue_end_ecr();}
					if(col=='prd' || col=='chg' || col=='dtt' || col=='crn') {vue_elem('bdg',id,col);vue_elem('ecr_err'+id_sup,id_sup);window.parent.act_frm('bln');window.parent.act_frm('rsl');window.parent.act_frm('fin_grp');}
					else if(col=='id_pst' || col=='mois') {vue_elem('ecr_trs_bdg'+id_sup);vue_elem('ecr_err'+id_sup,id_sup);window.parent.act_frm('bln');window.parent.act_frm('rsl');window.parent.act_frm('fin_grp');}
					else if(col=='id_grp') {window.parent.act_frm('fin_grp');}
				}
				else if(tab=='fin_pst') {
					if(cbl=='ecr') {vue_end_ecr();}
					else{vue(cbl);}
					if(cbl!='bln') {window.parent.act_frm('bln');}
					if(cbl!='rsl') {window.parent.act_frm('rsl');}
				}
				else if(tab=='fin_css') {vue('bln');window.parent.act_frm('trs');}
				else if(tab=='fin_inv') {vue('bln');}
				if(document.getElementById("txtHint").innerHTML.includes("SAVE ERROR")) {document.getElementById("txtHint").innerHTML="";}
			}
			else if(eval('xmlhttp_maj'+id+col).status==408) {maj(tab,col,val,id,id_sup);}
			else{
				document.getElementById("txtHint").innerHTML="<span style='background: red;'>SAVE ERROR</span>";
				console.log(eval('xmlhttp_maj'+id+col).statusText);
			}
			if(!flg_maj) {
				upd--;
				console.log('upd '+upd);
				flg_maj = true;
			}
			if((tab!='fin_ecr' || col=='date') && col!='dsc') {unload('FIN maj');}
		}
	}
	eval('xmlhttp_maj'+id+col).open("POST","maj.php",true);
	eval('xmlhttp_maj'+id+col).setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	eval('xmlhttp_maj'+id+col).send("tab="+tab+"&col="+col+"&val="+encodeURIComponent(val)+"&id="+id+"&id_sup="+id_sup);
}

function fus(id) {
	if(window.XMLHttpRequest) {xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load('FIN fus');
	xmlhttp.onreadystatechange=function() {
		if(xmlhttp.readyState==4) {
			if(xmlhttp.status==200) {vue('ecr');}
			else if(xmlhttp.status==408) {fus(id);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR FUS "+xmlhttp.statusText+" </span>";}
			unload('FIN fus');
		}
	}
	xmlhttp.open("POST","fus.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("id="+id);
}

function ajt(obj,id_sup) {
	var dat = document.getElementById("dat_max").value;
	var nom_nat = document.getElementById('sel_nat').value;
	if(window.XMLHttpRequest) {xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load('FIN ajt');
	xmlhttp.onreadystatechange=function() {
		if(xmlhttp.readyState==4) {
			if(xmlhttp.status==200) {
				if(obj=='ecr') {vue('ecr');}
				else{vue_elem('ecr_trs_bdg'+id_sup);}
			}
			else if(xmlhttp.status==408) {ajt(obj,id_sup);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR AJT "+xmlhttp.statusText+" </span>";}
			unload('FIN ajt');
		}
	}
	xmlhttp.open("POST","ajt.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("obj="+obj+"&id_sup="+id_sup+"&dat="+dat+"&nom_nat="+encodeURIComponent(nom_nat));
}

function dup(id,obj) {
	if(window.XMLHttpRequest) {xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load('FIN dup');
	xmlhttp.onreadystatechange=function() {
		if(xmlhttp.readyState==4) {
			if(xmlhttp.status==200) {
				vue('ecr');
				window.parent.act_frm('bln');
				window.parent.act_frm('rsl');
				window.parent.act_frm('trs');
			}
			else if(xmlhttp.status==408) {dup(id,obj);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR DUP "+xmlhttp.statusText+" </span>";}
			unload('FIN dup');
		}
	}
	xmlhttp.open("POST","dup.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("id="+id+"&obj="+obj);
}

function sup(obj,id,id_sup) {
	if(window.XMLHttpRequest) {xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load('FIN sup');
	xmlhttp.onreadystatechange=function() {
		if(xmlhttp.readyState==4) {
			if(xmlhttp.status==200) {
				if(obj=='ecr') {vue('ecr');}
				else{vue_elem('ecr_trs_bdg'+id_sup);}
				vue_end_ecr();
				window.parent.act_frm('bln');
				window.parent.act_frm('rsl');
				window.parent.act_frm('trs');
				window.parent.act_frm('fin_grp');
			}
			else if(xmlhttp.status==408) {sup(obj,id,id_sup);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR SUP "+xmlhttp.statusText+" </span>";}
			unload('FIN sup');
		}
	}
	xmlhttp.open("POST","sup.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("obj="+obj+"&id="+id);
}

function act_tab() {
	var cbl = document.getElementById('cbl').value.split("_").pop();
	if(window.XMLHttpRequest) {xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	xmlhttp.onreadystatechange=function() {
		if(xmlhttp.readyState==4) {
			if(xmlhttp.status==200) {
				window.parent.act_tab('fin/ctr.php?cbl='+cbl,xmlhttp.responseText);
				if($(document).height() == $(window).height()) {vue_dt_ecr();}
				}
			else if(xmlhttp.status==408) {act_tab();}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR ACT_TAB "+xmlhttp.statusText+" </span>";}
		}
	}
	xmlhttp.open("POST","nom_tab.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("cbl="+cbl);
}

function vue(cbl) {
	var cbl = cbl.split("_").pop();
	if(document.getElementById("dat_max")) {var dat_max = document.getElementById("dat_max").value;}
	else{var dat_max = '';}
	if(document.getElementById("dat_min")) {var dat_min = document.getElementById("dat_min").value;}
	else{var dat_min = '';}
	var chkhor = document.getElementsByClassName('chkhor');
	if(typeof chkhor != 'undefined') {
		var chkhor2 = '';
			for(var i = 0; i < chkhor.length; i++) {chkhor2 += chkhor[i].value+"|";}
	}
	var chkver = document.getElementsByClassName('chkver');
	if(typeof chkver != 'undefined') {
		var chkver2 = '';
		for(var i = 0; i < chkver.length; i++) {chkver2 += chkver[i].value+"|";}

	}
	if(cbl=='ecr') {
		var nom_nat = document.getElementById('sel_nat').value;
		var id_css = document.getElementById('sel_css').value;
		var id_att = document.getElementById('sel_att').value;
		var id_pst = document.getElementById('sel_pst').value;
		var id_grp = document.getElementById('sel_cnf').value;
	}
	if(window.XMLHttpRequest) {eval('xmlhttp_vue'+cbl+'=new XMLHttpRequest()');}
	else{eval('xmlhttp_vue'+cbl+'=new ActiveXObject("Microsoft.XMLHTTP")');}
	load('FIN vue');
	eval('xmlhttp_vue'+cbl).onreadystatechange=function() {
		if(eval('xmlhttp_vue'+cbl).readyState==4) {
			if(eval('xmlhttp_vue'+cbl).status==200) {
				document.getElementById("vue_"+cbl).innerHTML=eval('xmlhttp_vue'+cbl).responseText;
				if(cbl=='ecr') {
					rang=1;
					flg_dt_ecr=1;
					vue_end_ecr();
					if($(document).height() == $(window).height()) {vue_dt_ecr();}
				}
			}
			else if(eval('xmlhttp_vue'+cbl).status==408) {vue(cbl);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR VUE "+eval('xmlhttp_vue'+cbl).statusText+" </span>";}
			unload('FIN vue');
		}
	}
	eval('xmlhttp_vue'+cbl).open("POST","vue.php",true);
	eval('xmlhttp_vue'+cbl).setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	eval('xmlhttp_vue'+cbl).send("cbl="+cbl+"&dat_max="+dat_max+"&dat_min="+dat_min+"&nom_nat="+encodeURIComponent(nom_nat)+"&id_css="+id_css+"&id_att="+id_att+"&id_pst="+id_pst+"&id_grp="+id_grp+"&chkhor="+chkhor2+"&chkver="+chkver2);
}

function vue_elem(obj,id,col) {
	if(typeof col == 'undefined') {var xhr = id+obj;}
	else{var xhr = id+obj+col;}
	if(window.XMLHttpRequest) {eval('xmlhttp_vue_elem'+xhr+'=new XMLHttpRequest()');}
	else{eval('xmlhttp_vue_elem'+xhr+'=new ActiveXObject("Microsoft.XMLHTTP")');}
	if(document.getElementById(obj)) {load('FIN vue_elem '+xhr);}
	if(document.getElementById(obj+'_'+col+id)) {
		var bck = document.getElementById(obj+'_'+col+id).style.backgroundColor;
		document.getElementById(obj+'_'+col+id).style.backgroundColor  = "lightgrey";
	}
	eval('xmlhttp_vue_elem'+xhr).onreadystatechange=function() {
		if(eval('typeof xmlhttp_vue_elem'+xhr) !== 'undefined' && eval('xmlhttp_vue_elem'+xhr).readyState==4) {
			if(eval('xmlhttp_vue_elem'+xhr).status==200) {
				if(document.getElementById(obj+'_'+col+id)) {
					document.getElementById(obj+'_'+col+id).value=eval('xmlhttp_vue_elem'+xhr).responseText;
					document.getElementById(obj+'_'+col+id).style.backgroundColor  = bck;
				}
				else if(document.getElementById(obj)) {document.getElementById(obj).innerHTML=eval('xmlhttp_vue_elem'+xhr).responseText;}
			}
			else if(eval('xmlhttp_vue_elem'+xhr).status==408) {vue_elem(obj,id,col);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR VUE_ELEM "+eval('xmlhttp_vue_elem'+xhr).statusText+" </span>";}
			if(document.getElementById(obj)) {unload('FIN vue_elem '+xhr);}
		}
	}
	eval('xmlhttp_vue_elem'+xhr).open("POST","vue_elem.php",true);
	eval('xmlhttp_vue_elem'+xhr).setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	eval('xmlhttp_vue_elem'+xhr).send("id="+id+"&obj="+obj+"&col="+col);
}

function vue_dt_ecr() {
	var cbl = document.getElementById("cbl").value;
	if(cbl=='ecr') {
		if(flg_dt_ecr==1) {
			flg_dt_ecr=0
			if(document.getElementById("dat_max")) {var dat_max = document.getElementById("dat_max").value;}
			if(document.getElementById("dat_min")) {var dat_min = document.getElementById("dat_min").value;}
			if(window.XMLHttpRequest) {xmlhttp_dt_ecr=new XMLHttpRequest();}
			else{xmlhttp_dt_ecr=new ActiveXObject("Microsoft.XMLHTTP");}
			load('FIN vue_dt_ecr');
			var nom_nat = document.getElementById('sel_nat').value;
			var id_css = document.getElementById('sel_css').value;
			var id_att = document.getElementById('sel_att').value;
			var id_pst = document.getElementById('sel_pst').value;
			var id_grp = document.getElementById('sel_cnf').value;
			rang++;
			xmlhttp_dt_ecr.onreadystatechange=function() {
				if(xmlhttp_dt_ecr.readyState==4) {
					if(xmlhttp_dt_ecr.status==200) {
						if(xmlhttp_dt_ecr.responseText!='0') {
							var arr_dt_ecr=xmlhttp_dt_ecr.responseText.split("|");
							for(var i= 0; i < arr_dt_ecr.length; i++) {
								if(arr_dt_ecr[i]!='') {
									var arr_dt_ecr_2 = arr_dt_ecr[i].split("$$");
									var tr_dt_ecr = document.createElement('tr');
									tr_dt_ecr.id = arr_dt_ecr_2[0];
									tr_dt_ecr.innerHTML = arr_dt_ecr_2[1];
									document.getElementById("tab_ecr").appendChild(tr_dt_ecr);
								}
							}
							flg_dt_ecr=1;
							if($(document).height() == $(window).height()) {vue_dt_ecr();}
						}
					}
					else if(xmlhttp_dt_ecr.status==408) {
						flg_dt_ecr=1;
						rang--;
						vue_dt_ecr();
					}
					else{
						flg_dt_ecr=1;
						rang--;
						document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR VUE_DT_ECR "+xmlhttp_dt_ecr.statusText+" </span>";
					}
					unload('FIN vue_dt_ecr');
				}
			}
			xmlhttp_dt_ecr.open("POST","vue_dt_ecr.php",true);
			xmlhttp_dt_ecr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xmlhttp_dt_ecr.send("rang="+rang+"&dat_max="+dat_max+"&dat_min="+dat_min+"&nom_nat="+encodeURIComponent(nom_nat)+"&id_css="+id_css+"&id_att="+id_att+"&id_pst="+id_pst+"&id_grp="+id_grp);
		}
	}
}

function vue_end_ecr() {
	if(document.getElementById("dat_max")) {var dat_max = document.getElementById("dat_max").value;}
	if(document.getElementById("dat_min")) {var dat_min = document.getElementById("dat_min").value;}
	if(window.XMLHttpRequest) {xmlhttp_fin_ecr=new XMLHttpRequest();}
	else{xmlhttp_fin_ecr=new ActiveXObject("Microsoft.XMLHTTP");}
	var nom_nat = document.getElementById('sel_nat').value;
	var id_pst = document.getElementById('sel_pst').value;
	var id_grp = document.getElementById('sel_cnf').value;
	xmlhttp_fin_ecr.onreadystatechange=function() {
		if(xmlhttp_fin_ecr.readyState==4) {
			if(xmlhttp_fin_ecr.status==200) {document.getElementById("end_ecr").innerHTML=xmlhttp_fin_ecr.responseText;}
		}
	}
	xmlhttp_fin_ecr.open("POST","vue_end_ecr.php",true);
	xmlhttp_fin_ecr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp_fin_ecr.send("dat_max="+dat_max+"&dat_min="+dat_min+"&nom_nat="+encodeURIComponent(nom_nat)+"&id_grp="+id_grp+"&id_pst="+id_pst);
}

function act_frm(cbl) {
	if(document.getElementById("cbl").value==cbl) {vue(cbl);}
}

function hide(ref) {
	$("."+ref).hide();
	$("#h"+ref).attr('value','');
	$("#s"+ref).attr('value','');
	$(".inv_"+ref).show();
//VUE_TRS
	var chkhor	 = [];
	var i = 0;
	$(".chkhor").each(function() {
	    chkhor[i++] = $(this).val();
	});
	if(jQuery.inArray("1", chkhor) == -1) {$("#chkver").hide();}
}

function show(ref) {
	$("."+ref).show();
	$("#h"+ref).attr('value','1');
	$("#s"+ref).attr('value','1');
	$(".inv_"+ref).hide();
//VUE_TRS
	var chkhor	 = [];
	var i = 0;
	$(".chkhor").each(function() {
	    chkhor[i++] = $(this).val();
	});
	if(jQuery.inArray("1", chkhor) !== -1) {$("#chkver").show();}
}

function init() {//à mettre dans finLoad.js
	$(window).scroll(function() {
		if($(window).scrollTop() + $(window).height() >= $(document).height()-20) {vue_dt_ecr();}
	});
	unload('FIN init');
	$('input[type=number]').on('wheel', function(e) {return false;});
}
