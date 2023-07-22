function ajt(obj,id,cbl,id_sup) {
	if(id_sup == 0) {id_sup = id_cat;}
	if(window.XMLHttpRequest) {xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load('ajt');
	xmlhttp.onreadystatechange=function() {
		if(xmlhttp.readyState==4) {
			if(xmlhttp.status==200) {
				if(document.getElementById(obj)) {vue_elem(obj,id_sup);}
				else{vue();}
				window.parent.act_frm(cbl);
				act_acc();
			}
			else if(xmlhttp.status==408) {ajt(obj,id,cbl,id_sup);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR AJT"+xmlhttp.statusText+" </span>";}
			unload('ajt');
		}
	}
	xmlhttp.open("POST","ajt.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("obj="+obj+"&id="+id+"&id_sup="+id_sup);
}

function ajt_lgg(obj,id_chm,id_lgg) {
	if(obj=='hbr_chm') {
		var id = id_chm;
		cbl = 'hbr_chm';
	}
	else{
		var id = id_cat;
		cbl = cbl_cat;
	}
	if(window.XMLHttpRequest) {xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load('ajt_lgg');
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4) {
			if(xmlhttp.status==200) {
				if(obj=='hbr_chm') {vue_elem('hbr_chm_txt'+id,id);}
				else{
					vue_elem(cbl+'_txt',id);
					window.parent.act_frm(cbl);
					act_acc();
				}
			}
			else if(xmlhttp.status==408) {ajt_lgg(obj,id_chm);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR AJT_LGG"+xmlhttp.statusText+" </span>";}
			unload('ajt_lgg');
		}
	}
	xmlhttp.open("POST","ajt_lgg.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("cbl="+cbl+"&id="+id+"&id_lgg="+id_lgg);
}

function ajt_mdl(id_mdl) {
	if(window.XMLHttpRequest) {xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load('CAT');
	xmlhttp.onreadystatechange=function() {
		if(xmlhttp.readyState==4) {
			if(xmlhttp.status==200) {
				vue_elem('crc_mdl',id_cat);
				vue_elem('crc_txt',id_cat);//for publishing on website
				window.parent.act_frm('up_crc');
			}
			else if(xmlhttp.status==408) {ajt_mdl(id_mdl);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR AJT_MDL"+xmlhttp.statusText+" </span>";}
			unload('CAT');
		}
	}
	xmlhttp.open("POST","ajt_mdl.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("id_crc="+id_cat+"&id_mdl="+id_mdl);
}

function ajt_jrn(id_jrn) {
	if(window.XMLHttpRequest) {xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load('CAT');
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4) {
			if(xmlhttp.status==200) {
				vue_elem('mdl_jrn',id_cat);
				window.parent.act_frm('up_mdl');
			}
			else if(xmlhttp.status==408) {ajt_jrn(id_jrn);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR AJT_JRN"+xmlhttp.statusText+" </span>";}
			unload('CAT');
		}
	}
	xmlhttp.open("POST","ajt_jrn.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("id_mdl="+id_cat+"&id_jrn="+id_jrn);
}

function ajt_jrn_opt(id_jrn,ord) {
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
			else if(xmlhttp.status==408) {ajt_jrn_opt(id_jrn,ord);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR AJT_JRN_OPT"+xmlhttp.statusText+" </span>";}
			unload('CAT');
		}
	}
	xmlhttp.open("POST","ajt_jrn_opt.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("id_mdl="+id_cat+"&id_jrn="+id_jrn+"&ord="+ord);
}

function ajt_srv(id_srv) {
	if(window.XMLHttpRequest) {xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load('CAT');
	xmlhttp.onreadystatechange=function() {
		if(xmlhttp.readyState==4) {
			if(xmlhttp.status==200) {
				vue_elem('prs_srv',id_cat);
				window.parent.act_frm('up_prs');
			}
			else if(xmlhttp.status==408) {ajt_srv(id_srv);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR AJT_SRV"+xmlhttp.statusText+" </span>";}
			unload('CAT');
		}
	}
	xmlhttp.open("POST","ajt_srv.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("id_prs="+id_cat+"&id_srv="+id_srv);
}

function ajt_srv_trf() {
	if(window.XMLHttpRequest) {xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load('CAT');
	xmlhttp.onreadystatechange=function() {
		if(xmlhttp.readyState==4) {
			if(xmlhttp.status==200) {vue_elem('dt_srv',id_cat);}
			else if(xmlhttp.status==408) {ajt_srv_trf();}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR AJT_SRV_TRF"+xmlhttp.statusText+" </span>";}
			unload('CAT');
		}
	}
	xmlhttp.open("POST","ajt_srv_trf.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("id_srv="+id_cat);
}

function ajt_srv_trf_ssn(id_srv_trf) {
	if(window.XMLHttpRequest) {xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load('CAT');
	xmlhttp.onreadystatechange=function() {
		if(xmlhttp.readyState==4) {
			if(xmlhttp.status==200) {vue_elem('dt_srv',id_cat);}
			else if(xmlhttp.status==408) {ajt_srv_trf_ssn(id_srv_trf);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR AJT_SRV_TRF_SSN"+xmlhttp.statusText+" </span>";}
			unload('CAT');
		}
	}
	xmlhttp.open("POST","ajt_srv_trf_ssn.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("id_srv_trf="+id_srv_trf+"&id_srv="+id_cat);
}

function ajt_srv_trf_bss(id_srv_trf) {
	if(window.XMLHttpRequest) {xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load('CAT');
	xmlhttp.onreadystatechange=function() {
		if(xmlhttp.readyState==4) {
			if(xmlhttp.status==200) {vue_elem('dt_srv',id_cat);}
			else if(xmlhttp.status==408) {ajt_srv_trf_bss(id_srv_trf);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR AJT_SRV_TRF_BSS"+xmlhttp.statusText+" </span>";}
			unload('CAT');
		}
	}
	xmlhttp.open("POST","ajt_srv_trf_bss.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("id_srv_trf="+id_srv_trf);
}

function ajt_hbr(id_vll,id_rgm,id_hbr,id_chm) {
	if(window.XMLHttpRequest) {xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load('CAT');
	xmlhttp.onreadystatechange=function() {
		if(xmlhttp.readyState==4) {
			if(xmlhttp.status==200) {
				vue_elem('prs_hbr',id_cat);
				window.parent.act_frm('up_prs');
			}
			else if(xmlhttp.status==408) {ajt_hbr(id_vll,id_rgm,id_hbr,id_chm);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR AJT_HBR"+xmlhttp.statusText+" </span>";}
			unload('CAT');
		}
	}
	xmlhttp.open("POST","ajt_hbr.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("id_prs="+id_cat+"&id_hbr="+id_hbr+"&id_chm="+id_chm+"&id_rgm="+id_rgm+"&id_vll="+id_vll);
}

function ajt_hbr_chm() {
	if(window.XMLHttpRequest) {xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load('CAT ajt_hbr_chm');
	xmlhttp.onreadystatechange=function() {
		if(xmlhttp.readyState==4) {
			if(xmlhttp.status==200) {
				vue_elem('hbr_chm',id_cat);
				window.parent.act_frm('hbr');
			}
			else if(xmlhttp.status==408) {ajt_hbr_chm();}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR AJT_HBR_CHM"+xmlhttp.statusText+" </span>";}
			unload('CAT ajt_hbr_chm');
		}
	}
	xmlhttp.open("POST","ajt_hbr_chm.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("id_hbr="+id_cat);
}

function ajt_hbr_chm_trf(id_hbr_chm) {
	if(window.XMLHttpRequest) {xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load('CAT');
	xmlhttp.onreadystatechange=function() {
		if(xmlhttp.readyState==4) {
			if(xmlhttp.status==200) {vue_elem('hbr_chm',id_cat);}
			else if(xmlhttp.status==408) {ajt_hbr_chm_trf(id_hbr_chm);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR AJT_HBR_CHM_TRF"+xmlhttp.statusText+" </span>";}
			unload('CAT');
		}
	}
	xmlhttp.open("POST","ajt_hbr_chm_trf.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("id_hbr_chm="+id_hbr_chm);
}

function ajt_hbr_chm_trf_ssn(id_hbr_chm_trf,id_hbr_chm) {
	if(window.XMLHttpRequest) {xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load('CAT');
	xmlhttp.onreadystatechange=function() {
		if(xmlhttp.readyState==4) {
			if(xmlhttp.status==200) {vue_elem('hbr_chm',id_cat);}
			else if(xmlhttp.status==408) {ajt_hbr_chm_trf_ssn(id_hbr_chm_trf,id_hbr_chm);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR AJT_HBR_CHM_TRF_SSN"+xmlhttp.statusText+" </span>";}
			unload('CAT');
		}
	}
	xmlhttp.open("POST","ajt_hbr_chm_trf_ssn.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("id_hbr_chm_trf="+id_hbr_chm_trf+"&id_hbr_chm="+id_hbr_chm);
}

function ajt_hbr_rgm(id_rgm) {
	if(window.XMLHttpRequest) {xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load('CAT');
	xmlhttp.onreadystatechange=function() {
		if(xmlhttp.readyState==4) {
			if(xmlhttp.status==200) {
				vue_elem('hbr_rgm',id_cat);
				window.parent.act_frm('hbr');
				if(xmlhttp.responseText!='0') {
					var arr_chm=xmlhttp.responseText.split("|");
					for(var i= 0; i < arr_chm.length; i++) {
						if(arr_chm[i]>0) {vue_elem('hbr_chm_rgm'+arr_chm[i],id_cat);}
					}
				}
			}
			else if(xmlhttp.status==408) {ajt_hbr_rgm(id_rgm);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR AJT_HBR_RGM"+xmlhttp.statusText+" </span>";}
			unload('CAT');
		}
	}
	xmlhttp.open("POST","ajt_hbr_rgm.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("id_hbr="+id_cat+"&id_rgm="+id_rgm);
}

function ajt_hbr_rgm_trf(id_hbr_rgm) {
	if(window.XMLHttpRequest) {xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load('CAT');
	xmlhttp.onreadystatechange=function() {
		if(xmlhttp.readyState==4) {
			if(xmlhttp.status==200) {vue_elem('hbr_rgm',id_cat);}
			else if(xmlhttp.status==408) {ajt_hbr_rgm_trf(id_hbr_rgm);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR AJT_HBR_RGM_TRF"+xmlhttp.statusText+" </span>";}
			unload('CAT');
		}
	}
	xmlhttp.open("POST","ajt_hbr_rgm_trf.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("id_hbr_rgm="+id_hbr_rgm);
}

function ajt_hbr_rgm_trf_ssn(id_hbr_rgm_trf,id_hbr_rgm) {
	if(window.XMLHttpRequest) {xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load('CAT');
	xmlhttp.onreadystatechange=function() {
		if(xmlhttp.readyState==4) {
			if(xmlhttp.status==200) {vue_elem('hbr_rgm',id_cat);}
			else if(xmlhttp.status==408) {ajt_hbr_rgm_trf_ssn(id_hbr_rgm_trf,id_hbr_rgm);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR AJT_HBR_RGM_TRF_SSN"+xmlhttp.statusText+" </span>";}
			unload('CAT');
		}
	}
	xmlhttp.open("POST","ajt_hbr_rgm_trf_ssn.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("id_hbr_rgm_trf="+id_hbr_rgm_trf+"&id_hbr_rgm="+id_hbr_rgm);
}

function ajt_hbr_pay() {
	if(window.XMLHttpRequest) {xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load('CAT');
	xmlhttp.onreadystatechange=function() {
		if(xmlhttp.readyState==4) {
			if(xmlhttp.status==200) {vue_elem('hbr_pay',id_cat);}
			else if(xmlhttp.status==408) {ajt_hbr_pay();}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR AJT_HBR_PAY"+xmlhttp.statusText+" </span>";}
			unload('CAT');
		}
	}
	xmlhttp.open("POST","ajt_hbr_pay.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("id_hbr="+id_cat);
}

function ajt_frn_pay() {
	if(window.XMLHttpRequest) {xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load('CAT');
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4) {
			if (xmlhttp.status==200) {vue_elem('frn_pay',id_cat);}
			else if(xmlhttp.status==408) {ajt_frn_pay();}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR AJT_FRN_PAY"+xmlhttp.statusText+" </span>";}
			unload('CAT');
		}
	}
	xmlhttp.open("POST","ajt_frn_pay.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("id_frn="+id_cat);
}
