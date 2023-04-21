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

function ajt_dev(id) {
	if (window.XMLHttpRequest) {xhttp=new XMLHttpRequest();}
	else {xhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	xhttp.open("GET","../fct/txt_js.xml",false);
	xhttp.send();
	xmlDoc=xhttp.responseXML;
	x=xmlDoc.getElementsByTagName("ajt_dev");
	y=x[0].getElementsByTagName(id_lng);
	var nom = prompt(y[0].childNodes[0].nodeValue);
	if (nom == null || nom == '') {return;}
	load('ajt_dev');
	var grp=clt=0;
	if (window.XMLHttpRequest) {xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4) {
			if(xmlhttp.status==200) {
				var rsp = xmlhttp.responseText.split("||");
				window.parent.act_frm('grp');
				window.parent.act_frm('clt');
				window.parent.opn_frm('dev/ctr.php?id='+rsp[0]);
				act_acc();
				if(rsp[1]!='') {alt(rsp[1]);}
				if(rsp[2]!='') {alt(rsp[2]);}
			}
			else if(xmlhttp.status==408) {ajt_dev(id);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR AJT_DEV "+xmlhttp.statusText+" </span>";}
			unload('ajt_dev');
		}
	}
	xmlhttp.open("POST","../fct/ajt_dev.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("id_cat="+id+"&nom="+encodeURIComponent(nom));
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

function ajt_prs(id_prs) {
	if(window.XMLHttpRequest) {xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load('CAT');
	xmlhttp.onreadystatechange=function() {
		if(xmlhttp.readyState==4) {
			if(xmlhttp.status==200) {
				if(xmlhttp.responseText!=0) {
					vue_elem('jrn_prs',id_cat);
					window.parent.act_frm('up_jrn');
					//window.parent.act_frm('dt_jrn');??
				}
				else{
					if(window.XMLHttpRequest) {xhttp=new XMLHttpRequest();}
					else{xhttp=new ActiveXObject("Microsoft.XMLHTTP");}
					xhttp.open("GET","txt_js.xml",false);
					xhttp.send();
					xmlDoc=xhttp.responseXML;
					x=xmlDoc.getElementsByTagName("ajt_prs");
					y=x[0].getElementsByTagName(id_lng);
					alt(y[0].childNodes[0].nodeValue);
				}
			}
			else if(xmlhttp.status==408) {ajt_prs(id_prs);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR AJT_PRS"+xmlhttp.statusText+" </span>";}
			unload('CAT');
		}
	}
	xmlhttp.open("POST","ajt_prs.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("id_jrn="+id_cat+"&id_prs="+id_prs);
}

function ajt_prs_opt(id_prs,ord) {
	if(window.XMLHttpRequest) {xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load('CAT ajt_prs_opt');
	xmlhttp.onreadystatechange=function() {
		if(xmlhttp.readyState==4) {
			if(xmlhttp.status==200) {
				if(xmlhttp.responseText!=0) {
					vue_elem('jrn_prs',id_cat);
					//	window.parent.act_frm('dt_jrn');??
					window.parent.act_frm('up_jrn');
					window.parent.act_frm('ajt_prs_opt');
					window.parent.act_frm('prs_opt')
				}
				else{
					if(window.XMLHttpRequest) {xhttp=new XMLHttpRequest();}
					else{xhttp=new ActiveXObject("Microsoft.XMLHTTP");}
					xhttp.open("GET","txt_js.xml",false);
					xhttp.send();
					xmlDoc=xhttp.responseXML;
					x=xmlDoc.getElementsByTagName("ajt_prs");
					y=x[0].getElementsByTagName(id_lng);
					alt(y[0].childNodes[0].nodeValue);
				}
			}
			else if(xmlhttp.status==408) {ajt_prs_opt(id_prs,ord);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR AJT_PRS_OPT"+xmlhttp.statusText+" </span>";}
			unload('CAT ajt_prs_opt');
		}
	}
	xmlhttp.open("POST","ajt_prs_opt.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("id_jrn="+id_cat+"&id_prs="+id_prs+"&ord="+ord);
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

function dup(cbl,id) {
	if(window.XMLHttpRequest) {xhttp=new XMLHttpRequest();}
	else{xhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	xhttp.open("GET","txt_js.xml",false);
	xhttp.send();
	xmlDoc=xhttp.responseXML;
	x=xmlDoc.getElementsByTagName("dup_"+cbl);
	y=x[0].getElementsByTagName(id_lng);
	if(window.confirm(y[0].childNodes[0].nodeValue)==false) {return;}
	if(window.XMLHttpRequest) {xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load('CAT');
	xmlhttp.onreadystatechange=function() {
		if(xmlhttp.readyState==4) {
			if(xmlhttp.status==200) {
				if(cbl=='chm') {vue_elem('hbr_chm',id_cat);/*window.parent.act_frm('hbr');*/}
				else if(cbl=='trf') {vue_elem('dt_srv',id_cat);}
			}
			else if(xmlhttp.status==408) {dup(cbl,id);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR DUP "+xmlhttp.statusText+" </span>";}
			unload('CAT');
		}
	}
	xmlhttp.open("POST","dup.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("cbl="+cbl+"&id="+id);
}

function cop(cbl,id) {
	var nom = document.getElementById('nom_'+cbl+'_'+id).value;
	if(window.XMLHttpRequest) {xhttp=new XMLHttpRequest();}
	else {xhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	xhttp.open("GET","../fct/txt_js.xml",false);
	xhttp.send();
	xmlDoc=xhttp.responseXML;
	x=xmlDoc.getElementsByTagName("cop_"+cbl);
	y=x[0].getElementsByTagName(id_lng);
	var nom = prompt(y[0].childNodes[0].nodeValue,nom+"(1)");
	if(nom == null || nom == '') {return;}
	if(window.XMLHttpRequest) {xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load('CAT');
	xmlhttp.onreadystatechange=function() {
		if(xmlhttp.readyState==4) {
			if(xmlhttp.status==200) {
				window.parent.opn_frm('cat/ctr.php?cbl='+cbl+'&id='+xmlhttp.responseText);
				act_acc();
				window.parent.act_frm(cbl);
				window.parent.act_frm('up_'+cbl);
				window.parent.act_frm('ajt_prs_opt');
			}
			else if(xmlhttp.status==408) {cop(cbl,id);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR COP"+xmlhttp.statusText+" </span>";}
			unload('CAT');
		}
	}
	xmlhttp.open("POST","../fct/cop.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("cbl="+cbl+"&id="+id+"&nom="+encodeURIComponent(nom));
}

function cop2(cbl,id) {
	var nom = document.getElementById('nom_'+cbl+'_'+id).value;
	if(window.XMLHttpRequest) {xhttp=new XMLHttpRequest();}
	else {xhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	xhttp.open("GET","../fct/txt_js.xml",false);
	xhttp.send();
	xmlDoc=xhttp.responseXML;
	x=xmlDoc.getElementsByTagName("cop_"+cbl);
	y=x[0].getElementsByTagName(id_lng);
	var nom = prompt(y[0].childNodes[0].nodeValue,nom+"(1)");
	if(nom == null || nom == '') {return;}
	if(window.XMLHttpRequest) {xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load('CAT');
	xmlhttp.onreadystatechange=function() {
		if(xmlhttp.readyState==4) {
			if(xmlhttp.status==200) {
				window.parent.opn_frm('cat/ctr.php?cbl='+cbl+'&id='+xmlhttp.responseText);
				act_acc();
				window.parent.act_frm(cbl);
				if(cbl=='prs') {window.parent.act_frm('ajt_prs_opt');}
			}
			else if(xmlhttp.status==408) {cop2(cbl,id);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR COP2"+xmlhttp.statusText+" </span>";}
			unload('CAT');
		}
	}
	xmlhttp.open("POST","../fct/cop2.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("cbl="+cbl+"&id="+id+"&nom="+encodeURIComponent(nom));
}
