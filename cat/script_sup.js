function sup(obj,id,cbl,id_sup) {
	if(window.XMLHttpRequest) {xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load('CAT');
	xmlhttp.onreadystatechange=function() {
		if(xmlhttp.readyState==4) {
			if(xmlhttp.status==200) {
				if(document.getElementById(obj)) {vue_elem(obj,id_sup);}
				//else{vue();}
				window.parent.act_frm(`lst_${obj}`)
				act_acc();
				if(xmlhttp.responseText!='') {alt(xmlhttp.responseText);}
			}
			else if(xmlhttp.status==408) {sup(obj,id,cbl,id_sup);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR SUP "+xmlhttp.statusText+" </span>";}
			unload('CAT');
		}
	}
	xmlhttp.open("POST","sup.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("obj="+obj+"&id="+id);
}

function sup_mdl(id_crc_mdl,ord) {
	if(window.XMLHttpRequest) {xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load('CAT');
	xmlhttp.onreadystatechange=function() {
		if(xmlhttp.readyState==4) {
			if(xmlhttp.status==200) {
				window.parent.act_frm('list_crc_mdl')
				//vue_elem('crc_mdl',id_cat);
				vue_elem('crc_txt',id_cat);//for publishing on website
			}
			else if(xmlhttp.status==408) {sup_mdl(id_crc_mdl,ord);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR SUP_MDL "+xmlhttp.statusText+" </span>";}
			unload('CAT');
		}
	}
	xmlhttp.open("POST","sup_mdl.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("id_crc="+id_cat+"&id_crc_mdl="+id_crc_mdl+"&ord="+ord);
}

function sup_jrn(id_mdl_jrn,ord) {
	if(window.XMLHttpRequest) {xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load('CAT');
	xmlhttp.onreadystatechange=function() {
		if(xmlhttp.readyState==4) {
			if(xmlhttp.status==200) {
				window.parent.act_frm('list_mdl_jrn')
				//vue_elem('mdl_jrn',id_cat);
			}
			else if(xmlhttp.status==408) {sup_jrn(id_mdl_jrn,ord);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR SUP_JRN "+xmlhttp.statusText+" </span>";}
			unload('CAT');
		}
	}
	xmlhttp.open("POST","sup_jrn.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("id_mdl="+id_cat+"&id_mdl_jrn="+id_mdl_jrn+"&ord="+ord);
}

function sup_jrn_opt(id_mdl_jrn,ord) {
	if(window.XMLHttpRequest) {xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load('CAT');
	xmlhttp.onreadystatechange=function() {
		if(xmlhttp.readyState==4) {
			if(xmlhttp.status==200) {
				vue_elem('mdl_jrn',id_cat);
				window.parent.act_frm('up_mdl');
				window.parent.act_frm('ajt_jrn_opt');
				window.parent.act_frm('ajt_jrn_rpl');
			}
			else if(xmlhttp.status==408) {sup_jrn_opt(id_mdl_jrn,ord);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR SUP_JRN_OPT"+xmlhttp.statusText+" </span>";}
			unload('CAT');
		}
	}
	xmlhttp.open("POST","sup_jrn_opt.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("id_mdl="+id_cat+"&id_mdl_jrn="+id_mdl_jrn+"&ord="+ord);
}

function sup_prs(id_jrn_prs,ord) {
	if(window.XMLHttpRequest) {xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load('CAT');
	xmlhttp.onreadystatechange=function() {
		if(xmlhttp.readyState==4) {
			if(xmlhttp.status==200) {
				//vue_elem('jrn_prs',id_cat);
				window.parent.act_frm('list_jrn_prs');
			}
			else if(xmlhttp.status==408) {sup_prs(id_jrn_prs,ord);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR SUP_PRS "+xmlhttp.statusText+" </span>";}
			unload('CAT');
		}
	}
	xmlhttp.open("POST","sup_prs.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("id_jrn="+id_cat+"&id_jrn_prs="+id_jrn_prs+"&ord="+ord);
}

function sup_prs_opt(id_jrn_prs,ord) {
	if(window.XMLHttpRequest) {xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load('CAT');
	xmlhttp.onreadystatechange=function() {
		if(xmlhttp.readyState==4) {
			if(xmlhttp.status==200) {
				vue_elem('jrn_prs',id_cat);
				window.parent.act_frm('up_jrn');
				window.parent.act_frm('ajt_prs_opt');
				window.parent.act_frm('prs_opt');
			}
			else if(xmlhttp.status==408) {sup_prs_opt(id_jrn_prs,ord);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR SUP_PRS_OPT"+xmlhttp.statusText+" </span>";}
			unload('CAT');
		}
	}
	xmlhttp.open("POST","sup_prs_opt.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("id_jrn="+id_cat+"&id_jrn_prs="+id_jrn_prs+"&ord="+ord);
}

function sup_srv(id_prs_srv) {
	if(window.XMLHttpRequest) {xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load('CAT');
	xmlhttp.onreadystatechange=function() {
		if(xmlhttp.readyState==4) {
			if(xmlhttp.status==200) {
				//vue_elem('prs_srv',id_cat);
				window.parent.act_frm('list_prs_srv');
			}
			else if(xmlhttp.status==408) {sup_srv(id_prs_srv);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR SUP_SRV "+xmlhttp.statusText+" </span>";}
			unload('CAT');
		}
	}
	xmlhttp.open("POST","sup_srv.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("id_prs_srv="+id_prs_srv);
}

function sup_hbr(id_prs_hbr) {
	if(window.XMLHttpRequest) {xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load('CAT');
	xmlhttp.onreadystatechange=function() {
		if(xmlhttp.readyState==4) {
			if(xmlhttp.status==200) {
				//vue_elem('prs_hbr',id_cat);
				window.parent.act_frm('list_hbr');
			}
			else if(xmlhttp.status==408) {sup_hbr(id_prs_hbr);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR SUP_HBR "+xmlhttp.statusText+" </span>";}
			unload('CAT');
		}
	}
	xmlhttp.open("POST","sup_hbr.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("id_prs_hbr="+id_prs_hbr);
}

function sup_dsp(id) {
	if(window.XMLHttpRequest) {xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load('CAT');
	xmlhttp.onreadystatechange=function() {
		if(xmlhttp.readyState==4) {
			if(xmlhttp.status==200) {vue_elem('frn_dsp',id_cat);window.parent.act_frm('dsp_frn');}
			else if(xmlhttp.status==408) {sup_dsp(id);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR SUP_DSP "+xmlhttp.statusText+" </span>";}
			unload('CAT');
		}
	}
	xmlhttp.open("POST","sup_dsp.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("id="+id);
}
