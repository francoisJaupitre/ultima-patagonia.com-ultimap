function sup(obj,id,cbl,id_sup) {
	if(window.XMLHttpRequest) {xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load('CAT');
	xmlhttp.onreadystatechange=function() {
		if(xmlhttp.readyState==4) {
			if(xmlhttp.status==200) {
				if(document.getElementById(obj)) {vue_elem(obj,id_sup);}
				else{vue();}
				window.parent.act_frm(cbl);
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

function sup_lgg(id,obj,id_chm) {
	if(cbl_cat=='hbr' && obj=='chm') {
		id_sup = id_chm;
		cbl = 'hbr_chm';
	}
	else{
		if(window.XMLHttpRequest) {xhttp=new XMLHttpRequest();}
		else{xhttp=new ActiveXObject("Microsoft.XMLHTTP");}
		xhttp.open("GET","txt_js.xml",false);
		xhttp.send();
		xmlDoc=xhttp.responseXML;
		x=xmlDoc.getElementsByTagName("sup_lgg");
		y=x[0].getElementsByTagName(id_lng);
		if(window.confirm(y[0].childNodes[0].nodeValue)==false) {return;}
		var id_sup = id_cat;
		cbl = cbl_cat;
	}
	if(window.XMLHttpRequest) {xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load('CAT');
	xmlhttp.onreadystatechange=function() {
		if(xmlhttp.readyState==4) {
			if(xmlhttp.status==200) {
				if(cbl=='hbr_chm') {vue_elem('hbr_chm_txt'+id_sup,id_sup);}
				else{
					vue_elem(cbl+'_txt',id_sup);
					window.parent.act_frm(cbl);
					act_acc();
				}
			}
			else if(xmlhttp.status==408) {sup_lgg(id,obj,id_chm);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR SUP_LGG"+xmlhttp.statusText+" </span>";}
			unload('CAT');
		}
	}
	xmlhttp.open("POST","sup_lgg.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("cbl="+cbl+"&id="+id);
}

function sup_mdl(id_crc_mdl,ord) {
	if(window.XMLHttpRequest) {xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load('CAT');
	xmlhttp.onreadystatechange=function() {
		if(xmlhttp.readyState==4) {
			if(xmlhttp.status==200) {
				vue_elem('crc_mdl',id_cat);
				vue_elem('crc_txt',id_cat);//for publishing on website
				window.parent.act_frm('crc');
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
				vue_elem('mdl_jrn',id_cat);
				window.parent.act_frm('up_crc');
				window.parent.act_frm('mdl');
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
				vue_elem('jrn_prs',id_cat);
			//	window.parent.act_frm('dt_jrn');??
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
			//	window.parent.act_frm('dt_jrn');??
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
				vue_elem('prs_srv',id_cat);
				window.parent.act_frm('up_prs');
				window.parent.act_frm('prs');
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

function sup_srv_trf(id_srv_trf) {
	if(window.XMLHttpRequest) {xhttp=new XMLHttpRequest();}
	else{xhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	xhttp.open("GET","txt_js.xml",false);
	xhttp.send();
	xmlDoc=xhttp.responseXML;
	x=xmlDoc.getElementsByTagName("sup_srv_trf");
	y=x[0].getElementsByTagName(id_lng);
	if(window.confirm(y[0].childNodes[0].nodeValue)==false) {return;}
	if(window.XMLHttpRequest) {xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load('CAT');
	xmlhttp.onreadystatechange=function() {
		if(xmlhttp.readyState==4) {
			if(xmlhttp.status==200) {
				vue_elem('dt_srv',id_cat);
				window.parent.act_frm('frn_srv');
			}
			else if(xmlhttp.status==408) {sup_srv_trf(id_srv_trf);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR SUP_SRV_TRF "+xmlhttp.statusText+" </span>";}
			unload('CAT');
		}
	}
	xmlhttp.open("POST","sup_srv_trf.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("id_srv_trf="+id_srv_trf);
}

function sup_srv_trf_ssn(id_srv_trf_ssn,id_srv_trf) {
	if(window.XMLHttpRequest) {xhttp=new XMLHttpRequest();}
	else{xhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	xhttp.open("GET","txt_js.xml",false);
	xhttp.send();
	xmlDoc=xhttp.responseXML;
	x=xmlDoc.getElementsByTagName("sup_srv_trf_ssn");
	y=x[0].getElementsByTagName(id_lng);
	if(window.confirm(y[0].childNodes[0].nodeValue)==false) {return;}
	if(window.XMLHttpRequest) {xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load('CAT');
	xmlhttp.onreadystatechange=function() {
		if(xmlhttp.readyState==4) {
			if(xmlhttp.status==200) {
				if(xmlhttp.responseText==1) {$('.td_ssn'+id_srv_trf_ssn).contents().hide();}
				else{vue_elem('dt_srv',id_cat);}
			}
			else if(xmlhttp.status==408) {sup_srv_trf_ssn(id_srv_trf_ssn,id_srv_trf);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR SUP_SRV_TRF_SSN "+xmlhttp.statusText+" </span>";}
			unload('CAT');
		}
	}
	xmlhttp.open("POST","sup_srv_trf_ssn.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("id_srv_trf_ssn="+id_srv_trf_ssn+"&id_srv_trf="+id_srv_trf);
}

function sup_srv_trf_bss(id_srv_trf_bss) {
	if(window.XMLHttpRequest) {xhttp=new XMLHttpRequest();}
	else{xhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	xhttp.open("GET","txt_js.xml",false);
	xhttp.send();
	xmlDoc=xhttp.responseXML;
	x=xmlDoc.getElementsByTagName("sup_srv_trf_bss");
	y=x[0].getElementsByTagName(id_lng);
	if(window.confirm(y[0].childNodes[0].nodeValue)==false) {return;}
	if(window.XMLHttpRequest) {xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load('CAT');
	xmlhttp.onreadystatechange=function() {
		if(xmlhttp.readyState==4) {
			if(xmlhttp.status==200) {vue_elem('dt_srv',id_cat);}
			else if(xmlhttp.status==408) {sup_srv_trf_bss(id_srv_trf_bss);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR SUP_SRV_TRF_BSS "+xmlhttp.statusText+" </span>";}
			unload('CAT');
		}
	}
	xmlhttp.open("POST","sup_srv_trf_bss.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("id_srv_trf_bss="+id_srv_trf_bss);
}

function sup_hbr(id_prs_hbr) {
	if(window.XMLHttpRequest) {xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load('CAT');
	xmlhttp.onreadystatechange=function() {
		if(xmlhttp.readyState==4) {
			if(xmlhttp.status==200) {
				vue_elem('prs_hbr',id_cat);
				window.parent.act_frm('prs');
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

function sup_hbr_chm(id_hbr_chm) {
	if(window.XMLHttpRequest) {xhttp=new XMLHttpRequest();}
	else{xhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	xhttp.open("GET","txt_js.xml",false);
	xhttp.send();
	xmlDoc=xhttp.responseXML;
	x=xmlDoc.getElementsByTagName("sup_hbr_chm");
	y=x[0].getElementsByTagName(id_lng);
	if(window.confirm(y[0].childNodes[0].nodeValue)==false) {return;}
	if(window.XMLHttpRequest) {xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load('CAT');
	xmlhttp.onreadystatechange=function() {
		if(xmlhttp.readyState==4) {
			if(xmlhttp.status==200) {
				if(xmlhttp.responseText!='') {alt(xmlhttp.responseText);}
				else{vue_elem('hbr_chm',id_cat);vue_elem('hbr_rgm',id_cat);act_acc();/*pour DATE MAXI*/}
			}
			else if(xmlhttp.status==408) {sup_hbr_chm(id_hbr_chm);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR SUP_HBR_CHM "+xmlhttp.statusText+" </span>";}
			unload('CAT');
		}
	}
	xmlhttp.open("POST","sup_hbr_chm.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("id_hbr_chm="+id_hbr_chm);
}

function sup_hbr_chm_trf(id_hbr_chm_trf) {
	if(window.XMLHttpRequest) {xhttp=new XMLHttpRequest();}
	else{xhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	xhttp.open("GET","txt_js.xml",false);
	xhttp.send();
	xmlDoc=xhttp.responseXML;
	x=xmlDoc.getElementsByTagName("sup_hbr_chm_trf");
	y=x[0].getElementsByTagName(id_lng);
	if(window.confirm(y[0].childNodes[0].nodeValue)==false) {return;}
	if (window.XMLHttpRequest) {xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load('CAT');
	xmlhttp.onreadystatechange=function() {
		if(xmlhttp.readyState==4) {
			if(xmlhttp.status==200) {vue_elem('hbr_chm',id_cat);act_acc();/*pour DATE MAXI*/}
			else if(xmlhttp.status==408) {sup_hbr_chm_trf(id_hbr_chm_trf);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR SUP_HBR_CHM_TRF "+xmlhttp.statusText+" </span>";}
			unload('CAT');
		}
	}
	xmlhttp.open("POST","sup_hbr_chm_trf.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("id_hbr_chm_trf="+id_hbr_chm_trf);
}

function sup_hbr_chm_trf_ssn(id_hbr_chm_trf_ssn) {
	if(window.XMLHttpRequest) {xhttp=new XMLHttpRequest();}
	else{xhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	xhttp.open("GET","txt_js.xml",false);
	xhttp.send();
	xmlDoc=xhttp.responseXML;
	x=xmlDoc.getElementsByTagName("sup_hbr_chm_trf_ssn");
	y=x[0].getElementsByTagName(id_lng);
	if(window.confirm(y[0].childNodes[0].nodeValue)==false) {return;}
	if(window.XMLHttpRequest) {xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load('CAT');
	xmlhttp.onreadystatechange=function() {
		if(xmlhttp.readyState==4) {
			if(xmlhttp.status==200) {vue_elem('hbr_chm',id_cat);act_acc();/*pour DATE MAXI*/}
			else if(xmlhttp.status==408) {sup_hbr_chm_trf_ssn(id_hbr_chm_trf_ssn);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR SUP_HBR_CHM_TRF_SSN "+xmlhttp.statusText+" </span>";}
			unload('CAT');
		}
	}
	xmlhttp.open("POST","sup_hbr_chm_trf_ssn.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("id_hbr_chm_trf_ssn="+id_hbr_chm_trf_ssn);
}

function sup_hbr_rgm(id_hbr_rgm) {
	if(window.XMLHttpRequest) {xhttp=new XMLHttpRequest();}
	else{xhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	xhttp.open("GET","txt_js.xml",false);
	xhttp.send();
	xmlDoc=xhttp.responseXML;
	x=xmlDoc.getElementsByTagName("sup_hbr_rgm");
	y=x[0].getElementsByTagName(id_lng);
	if(window.confirm(y[0].childNodes[0].nodeValue)==false) {return;}
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
			else if(xmlhttp.status==408) {sup_hbr_rgm(id_hbr_rgm);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR SUP_HBR_RGM "+xmlhttp.statusText+" </span>";}
			unload('CAT');
		}
	}
	xmlhttp.open("POST","sup_hbr_rgm.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("id_hbr_rgm="+id_hbr_rgm);
}

function sup_hbr_rgm_trf(id_hbr_rgm_trf) {
	if(window.XMLHttpRequest) {xhttp=new XMLHttpRequest();}
	else{xhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	xhttp.open("GET","txt_js.xml",false);
	xhttp.send();
	xmlDoc=xhttp.responseXML;
	x=xmlDoc.getElementsByTagName("sup_hbr_rgm_trf");
	y=x[0].getElementsByTagName(id_lng);
	if(window.confirm(y[0].childNodes[0].nodeValue)==false) {return;}
	if(window.XMLHttpRequest) {xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load('CAT');
	xmlhttp.onreadystatechange=function() {
		if(xmlhttp.readyState==4) {
			if(xmlhttp.status==200) {vue_elem('hbr_rgm',id_cat);}
			else if(xmlhttp.status==408) {sup_hbr_rgm_trf(id_hbr_rgm_trf);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR SUP_HBR_RGM_TRF "+xmlhttp.statusText+" </span>";}
			unload('CAT');
		}
	}
	xmlhttp.open("POST","sup_hbr_rgm_trf.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("id_hbr_rgm_trf="+id_hbr_rgm_trf);
}

function sup_hbr_rgm_trf_ssn(id_hbr_rgm_trf_ssn) {
	if(window.XMLHttpRequest) {xhttp=new XMLHttpRequest();}
	else{xhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	xhttp.open("GET","txt_js.xml",false);
	xhttp.send();
	xmlDoc=xhttp.responseXML;
	x=xmlDoc.getElementsByTagName("sup_hbr_rgm_trf_ssn");
	y=x[0].getElementsByTagName(id_lng);
	if(window.confirm(y[0].childNodes[0].nodeValue)==false) {return;}
	if(window.XMLHttpRequest) {xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load('CAT');
	xmlhttp.onreadystatechange=function() {
		if(xmlhttp.readyState==4) {
			if(xmlhttp.status==200) {vue_elem('hbr_rgm',id_cat);}
			else if(xmlhttp.status==408) {sup_hbr_rgm_trf_ssn(id_hbr_rgm_trf_ssn);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR SUP_HBR_RGM_TRF_SSN "+xmlhttp.statusText+" </span>";}
			unload('CAT');
		}
	}
	xmlhttp.open("POST","sup_hbr_rgm_trf_ssn.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("id_hbr_rgm_trf_ssn="+id_hbr_rgm_trf_ssn);
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

function del(cbl,id) {
	if(window.XMLHttpRequest) {xhttp=new XMLHttpRequest();}
	else {xhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	xhttp.open("GET","../fct/txt_js.xml",false);
	xhttp.send();
	xmlDoc=xhttp.responseXML;
	x=xmlDoc.getElementsByTagName("del_"+cbl);
	y=x[0].getElementsByTagName(id_lng);
	if(window.confirm(y[0].childNodes[0].nodeValue)==false) {return;}
	if(window.XMLHttpRequest) {xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load('CAT');
	xmlhttp.onreadystatechange=function() {
		if(xmlhttp.readyState==4) {
			if(xmlhttp.status==200) {
				if(xmlhttp.responseText=='') {
					if(cbl=='srv') {window.parent.act_frm('frn_srv');}
					else if(cbl=='hbr') {window.parent.act_frm('frn_hbr');}
					//window.parent.act_frm("cat_"+cbl+id); remplacer les class cat_ par up_
					//window.parent.act_frm("cat_"+cbl);
					window.parent.act_frm("up_"+cbl+id);
					window.parent.act_frm('up_'+cbl);
					act_acc();
					window.parent.sup_frm('catctrphpcbl'+cbl+'id'+id);
				}
				else{alt(xmlhttp.responseText);}
			}
			else if(xmlhttp.status==408) {del(cbl,id);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR DEL "+xmlhttp.statusText+" </span>";}
			unload('CAT');
		}
	}
	xmlhttp.open("POST","../fct/del.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("cbl="+cbl+"&id="+id);
}
