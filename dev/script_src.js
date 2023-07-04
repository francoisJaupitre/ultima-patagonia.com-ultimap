function src_jrn(id_dev_jrn,opt){
	var xhr = 'jrn'+id_dev_jrn;
	if(window.XMLHttpRequest){eval('xmlhttp_src_jrn'+xhr+'=new XMLHttpRequest()');}
	else{eval('xmlhttp_src_jrn'+xhr+'=new ActiveXObject("Microsoft.XMLHTTP")');}
	load('DEV src_jrn');
	eval('xmlhttp_src_jrn'+xhr).onreadystatechange=function(){
		if(eval('xmlhttp_src_jrn'+xhr).readyState==4){
			if(eval('xmlhttp_src_jrn'+xhr).status==200){
				if(eval('xmlhttp_src_jrn'+xhr).responseText != 0){
					eval('var arr_jrn'+xhr+'=xmlhttp_src_jrn'+xhr+'.responseText.split("|-|")');
					for(var i= 0; i < eval('arr_jrn'+xhr+'.length'); i++){
						eval('var arr_jrn2'+xhr+'=arr_jrn'+xhr+'[i].split("|")');
						ajt_hbr(eval('arr_jrn2'+xhr+'[0]'),eval('arr_jrn2'+xhr+'[1]'),eval('arr_jrn2'+xhr+'[2]'),eval('arr_jrn2'+xhr+'[3]'),eval('arr_jrn2'+xhr+'[4]'),eval('arr_jrn2'+xhr+'[5]'),1,eval('arr_jrn2'+xhr+'[6]'),eval('arr_jrn2'+xhr+'[7]'),eval('arr_jrn2'+xhr+'[8]'),eval('arr_jrn2'+xhr+'[9]'));
					}
				}
			}
			else if(eval('xmlhttp_src_jrn'+xhr).status==408){src_jrn(id_dev_jrn);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR SRC_JRN "+eval('xmlhttp_src_jrn'+xhr).statusText+" </span>";}
			unload('DEV src_jrn');
		}
	}
	eval('xmlhttp_src_jrn'+xhr).open("POST","../fct/src_jrn.php",true);
	eval('xmlhttp_src_jrn'+xhr).setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	eval('xmlhttp_src_jrn'+xhr).send("id_dev_jrn="+id_dev_jrn+"&opt="+opt);
}

function src_prs(id_cat_prs,ord_prs,id_dev_jrn,res_act,chk){ //ordonner cette fonction en retirant les actions non présentes dans opés
	var xhr = 'prs'+id_dev_jrn+'_'+ord_prs;
	if(window.XMLHttpRequest){xhttp=new XMLHttpRequest();}
	else{xhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	xhttp.open("GET","txt_js.xml",false);
	xhttp.send();
	xmlDoc=xhttp.responseXML;
	x=xmlDoc.getElementsByTagName("src_prs");
	if(window.XMLHttpRequest){eval('xmlhttp_src_prs'+xhr+'=new XMLHttpRequest()');}
	else{eval('xmlhttp_src_prs'+xhr+'=new ActiveXObject("Microsoft.XMLHTTP")');}
	load('DEV src_prs');
	eval('xmlhttp_src_prs'+xhr).onreadystatechange=function(){
		if(eval('xmlhttp_src_prs'+xhr).readyState==4){
			if(eval('xmlhttp_src_prs'+xhr).status==200){
				if(eval('xmlhttp_src_prs'+xhr).responseText != 0){
					eval('var arr_prs'+xhr+'=xmlhttp_src_prs'+xhr+'.responseText.split("|")');
					if(res_act=='ajt_opt'){
						if(ord_prs>0){
							yy=x[0].getElementsByTagName(id_lng);
							y=x[1].getElementsByTagName(id_lng);
							if(window.confirm(y[0].childNodes[0].nodeValue+eval('arr_prs'+xhr+'.length')/2+yy[0].childNodes[0].nodeValue)){
								for(var i= 0; i < eval('arr_prs'+xhr+'.length'); i=i+2){ajt_prs(id_cat_prs,eval('arr_prs'+xhr+'[i]'),eval('arr_prs'+xhr+'[i+1]'),0);}
							}
						}
						else{
							//ajt_opt vue_dt_jrn
						}
					}
					else if(res_act=='sel_opt'){
						if(chk==0){
							yy=x[0].getElementsByTagName(id_lng);
							y=x[2].getElementsByTagName(id_lng);
							if(window.confirm(y[0].childNodes[0].nodeValue+eval('arr_prs'+xhr+'.length')/2+yy[0].childNodes[0].nodeValue)){
								for(var i= 0; i < eval('arr_prs'+xhr+'.length'); i=i+2){maj('dev_prs','opt','1',eval('arr_prs'+xhr+'[i]'),eval('arr_prs'+xhr+'[i+1]'));}
							}
						}
						else if(chk==1){
							yy=x[0].getElementsByTagName(id_lng);
							y=x[3].getElementsByTagName(id_lng);
							if(window.confirm(y[0].childNodes[0].nodeValue+eval('arr_prs'+xhr+'.length')/2+yy[0].childNodes[0].nodeValue)){
								for(var i= 0; i < eval('arr_prs'+xhr+'.length'); i=i+2){maj('dev_prs','opt','0',eval('arr_prs'+xhr+'[i]'),eval('arr_prs'+xhr+'[i+1]'));}
							}
						}
					}
					else if(res_act=='sup'){
						yy=x[0].getElementsByTagName(id_lng);
						y=x[4].getElementsByTagName(id_lng);
						if(window.confirm(y[0].childNodes[0].nodeValue+eval('arr_prs'+xhr+'.length')/2+yy[0].childNodes[0].nodeValue)){
							for(var i= 0; i < eval('arr_prs'+xhr+'.length'); i=i+2){sup('prs',eval('arr_prs'+xhr+'[i]'),eval('arr_prs'+xhr+'[i+1]'),1,id_cat_prs);}
						}
					}
					else{
						yy=x[0].getElementsByTagName(id_lng);
						y=x[5].getElementsByTagName(id_lng);
						if(window.confirm(y[0].childNodes[0].nodeValue+eval('arr_prs'+xhr+'.length')+yy[0].childNodes[0].nodeValue)){
							for(var i= 0; i < eval('arr_prs'+xhr+'.length'); i++){maj('dev_prs','res',res_act,eval('arr_prs'+xhr+'[i]'));}
						}
					}
				}
			}
			else if(eval('xmlhttp_src_prs'+xhr).status==408){src_prs(id_cat_prs,ord_prs,id_dev_jrn,res_act,chk);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR SRC_PRS "+eval('xmlhttp_src_prs'+xhr).statusText+" </span>";}
			unload('DEV src_prs');
		}
	}
	eval('xmlhttp_src_prs'+xhr).open("POST","../fct/src_prs.php",true);
	eval('xmlhttp_src_prs'+xhr).setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	eval('xmlhttp_src_prs'+xhr).send("id_cat_prs="+id_cat_prs+"&ord_prs="+ord_prs+"&id_dev_jrn="+id_dev_jrn+"&id_dev_crc="+id_dev_crc+"&chk="+chk+"&res_act="+res_act);
}

function src_hbr(id_cat_hbr,id_cat_chm,id_hbr_vll,id_hbr_rgm,id_dev_hbr,id_dev_prs,res_act){
	if(id_dev_hbr!=0){var xhr = 'hbr'+id_dev_hbr;}
	else{var xhr = 'prs'+id_dev_prs;}
	if(window.XMLHttpRequest){xhttp=new XMLHttpRequest();}
	else{xhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	xhttp.open("GET","../resources/xml/scriptTxt.xml",false);
	xhttp.send();
	xmlDoc=xhttp.responseXML;
	x=xmlDoc.getElementsByTagName("src_hbr");
	if(window.XMLHttpRequest){eval('xmlhttp_src_hbr'+xhr+'=new XMLHttpRequest()');}
	else{eval('xmlhttp_src_hbr'+xhr+'=new ActiveXObject("Microsoft.XMLHTTP")');}
	load('DEV src_hbr');
	eval('xmlhttp_src_hbr'+xhr).onreadystatechange=function(){
		if(eval('xmlhttp_src_hbr'+xhr).readyState==4){
			if(eval('xmlhttp_src_hbr'+xhr).status==200){
				if(eval('xmlhttp_src_hbr'+xhr).responseText != 0){
					if(id_dev_prs!=0 && id_dev_hbr!=0){
						eval('var arr_hbr'+xhr+'=xmlhttp_src_hbr'+xhr+'.responseText.split("|")');
						if(res_act=='opt' || res_act=='sel'){
							yy=x[0].getElementsByTagName(id_lng);
							y=x[2].getElementsByTagName(id_lng);
							if(window.confirm(y[0].childNodes[0].nodeValue+eval('arr_hbr'+xhr+'.length')+yy[0].childNodes[0].nodeValue)){
								for(var i= 0; i < eval('arr_hbr'+xhr+'.length'); i++){
									eval('var arr_hbr2'+xhr+'=arr_hbr'+xhr+'[i].split("_")');
									if(res_act=='opt'){maj('dev_hbr','opt','1',eval('arr_hbr2'+xhr+'[0]'),eval('arr_hbr2'+xhr+'[1]'));}
									else{maj('dev_hbr','sel','1',eval('arr_hbr2'+xhr+'[0]'),eval('arr_hbr2'+xhr+'[1]'));}
								}
								vue_crc('res');
							}
						}
						else if(res_act=='ajt'){
							yy=x[0].getElementsByTagName(id_lng);
							y=x[1].getElementsByTagName(id_lng);
							if(window.confirm(y[0].childNodes[0].nodeValue+eval('arr_hbr'+xhr+'.length')+yy[0].childNodes[0].nodeValue)){
								for(var i= 0; i < eval('arr_hbr'+xhr+'.length'); i++){ajt_hbr(id_cat_hbr,id_cat_chm,id_hbr_vll,id_hbr_rgm,eval('arr_hbr'+xhr+'[i]'),0,0);}
							}
						}
						else if(res_act=='sup'){
							yy=x[0].getElementsByTagName(id_lng);
							y=x[3].getElementsByTagName(id_lng);
							if(window.confirm(y[0].childNodes[0].nodeValue+eval('arr_hbr'+xhr+'.length')+yy[0].childNodes[0].nodeValue)){
								for(var i= 0; i < eval('arr_hbr'+xhr+'.length'); i++){
									eval('var arr_hbr2'+xhr+'=arr_hbr'+xhr+'[i].split("_")');
									sup('hbr',eval('arr_hbr2'+xhr+'[0]'),eval('arr_hbr2'+xhr+'[1]'),1,id_cat_hbr);
								}
							}
						}
					}
					else if(id_dev_prs!=0 && id_dev_hbr==0){ //ajt_opt
						eval('var arr_prs'+xhr+'=xmlhttp_src_hbr'+xhr+'.responseText.split("|")');
						yy=x[4].getElementsByTagName(id_lng);
						y=x[5].getElementsByTagName(id_lng);
						if(window.confirm(y[0].childNodes[0].nodeValue+eval('arr_prs'+xhr+'.length')+yy[0].childNodes[0].nodeValue)){
							for(var i= 0; i < eval('arr_prs'+xhr+'.length'); i++){ajt_hbr(id_cat_hbr,id_cat_chm,id_hbr_vll,id_hbr_rgm,0,eval('arr_prs'+xhr+'[i]'),0);}
						}
					}
					else if(id_dev_prs==0 && id_dev_hbr!=0){ //maj_res
						eval('var arr_hbr'+xhr+'=xmlhttp_src_hbr'+xhr+'.responseText.split("|")');
						yy=x[4].getElementsByTagName(id_lng);
						y=x[6].getElementsByTagName(id_lng);
						if(window.confirm(y[0].childNodes[0].nodeValue+eval('arr_hbr'+xhr+'.length')+yy[0].childNodes[0].nodeValue)){
							for(var i= 0; i < eval('arr_hbr'+xhr+'.length'); i++){
								maj('dev_hbr','res',res_act,eval('arr_hbr'+xhr+'[i]'));
								vue_elem('hbr_res'+eval('arr_hbr'+xhr+'[i]'),eval('arr_hbr'+xhr+'[i]'));
							}
							vue_crc('res');
						}
					}
					else if(id_dev_prs==0 && id_dev_hbr==0){
						eval('var arr_hbr'+xhr+'=xmlhttp_src_hbr'+xhr+'.responseText.split("|")');
						if(res_act == 'act_trf') {
							yy=x[9].getElementsByTagName(id_lng);
							y=x[8].getElementsByTagName(id_lng);
							if(window.confirm(y[0].childNodes[0].nodeValue+eval('arr_hbr'+xhr+'.length')+yy[0].childNodes[0].nodeValue)){
								if(cnf>0){
									xx=xmlDoc.getElementsByTagName("cnf");
									yy=xx[0].getElementsByTagName(id_lng);
									if(window.confirm(yy[0].childNodes[0].nodeValue)==false){return 0;}
								}
								act_trf('hbr_all',eval('arr_hbr'+xhr),0);
							}
						}
						else if(res_act == 'sup') {
							yy=x[11].getElementsByTagName(id_lng);
							y=x[10].getElementsByTagName(id_lng);
							if(window.confirm(y[0].childNodes[0].nodeValue+eval('arr_hbr'+xhr+'.length')+yy[0].childNodes[0].nodeValue)){
								if(cnf>0){
									xx=xmlDoc.getElementsByTagName("cnf");
									yy=xx[0].getElementsByTagName(id_lng);
									if(window.confirm(yy[0].childNodes[0].nodeValue)==false){return 0;}
								}
								for(var i= 0; i < eval('arr_hbr'+xhr+'.length'); i++){
									eval('var arr_hbr2'+xhr+'=arr_hbr'+xhr+'[i].split("_")');
									sup('hbr',eval('arr_hbr2'+xhr+'[0]'),eval('arr_hbr2'+xhr+'[1]'),1,id_cat_hbr);
								}
							}
						}
					}
				}
			}
			else if(eval('xmlhttp_src_hbr'+xhr).status==408){src_hbr(id_cat_hbr,id_cat_chm,id_hbr_vll,id_hbr_rgm,id_dev_hbr,id_dev_prs,res_act);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR SRC_HBR "+eval('xmlhttp_src_hbr'+xhr).statusText+" </span>";}
			unload('DEV src_hbr');
		}
	}
	eval('xmlhttp_src_hbr'+xhr).open("POST","../fct/src_hbr.php",true);
	eval('xmlhttp_src_hbr'+xhr).setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	eval('xmlhttp_src_hbr'+xhr).send("id_cat_hbr="+id_cat_hbr+"&id_cat_chm="+id_cat_chm+"&id_hbr_vll="+id_hbr_vll+"&id_hbr_rgm="+id_hbr_rgm+"&id_dev_hbr="+id_dev_hbr+"&id_dev_prs="+id_dev_prs+"&id_dev_crc="+id_dev_crc+"&cnf="+cnf+"&res="+res_act);
}

function src_srv(id_frn,id_dev_srv_ctg,id_dev_srv_vll,id_dev_srv){
	if(window.XMLHttpRequest){xhttp=new XMLHttpRequest();}
	else{xhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	xhttp.open("GET","../resources/xml/scriptTxt.xml",false);
	xhttp.send();
	xmlDoc=xhttp.responseXML;
	x=xmlDoc.getElementsByTagName("src_srv");
	if(window.XMLHttpRequest){xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load('DEV');
	xmlhttp.onreadystatechange=function(){
		if(xmlhttp.readyState==4){
			if(xmlhttp.status==200){
				if(xmlhttp.responseText != 0){
					var arr_srv=xmlhttp.responseText.split("|");
					yy=x[0].getElementsByTagName(id_lng);
					y=x[1].getElementsByTagName(id_lng);
					z=x[2].getElementsByTagName(id_lng);
					if(id_dev_srv_vll > 0 && id_dev_srv > 0){
						if(window.confirm(y[0].childNodes[0].nodeValue+arr_srv.length+yy[0].childNodes[0].nodeValue)){
							for(var i= 0; i < arr_srv.length; i++){maj('dev_srv','id_frn',id_frn,arr_srv[i]);}
						}
					}
					else if(window.confirm(z[0].childNodes[0].nodeValue+arr_srv.length+yy[0].childNodes[0].nodeValue)){
						for(var i= 0; i < arr_srv.length; i++){maj('dev_srv','id_frn',0,arr_srv[i]);}
					}
				}
			}
			else if(xmlhttp.status==408){src_srv(id_frn,id_dev_srv_ctg,id_dev_srv_vll,id_dev_srv);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR SRC_SRV "+xmlhttp.statusText+" </span>";}
			unload('DEV');
		}
	}
	xmlhttp.open("POST","../fct/src_srv.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("id_dev_srv_ctg="+id_dev_srv_ctg+"&id_dev_srv_vll="+id_dev_srv_vll+"&id_dev_srv="+id_dev_srv+"&id_dev_crc="+id_dev_crc+"&id_frn="+id_frn);
}

function src_frn(res,id_frn,id_dev_srv,id_dev_prs){
	if(id_frn!=0){
		if(window.XMLHttpRequest){xhttp=new XMLHttpRequest();}
		else{xhttp=new ActiveXObject("Microsoft.XMLHTTP");}
		xhttp.open("GET","../resources/xml/scriptTxt.xml",false);
		xhttp.send();
		xmlDoc=xhttp.responseXML;
		x=xmlDoc.getElementsByTagName("src_frn");
		if(window.XMLHttpRequest){xmlhttp=new XMLHttpRequest();}
		else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
		load('DEV');
		xmlhttp.onreadystatechange=function(){
			if(xmlhttp.readyState==4){
				if(xmlhttp.status==200){
					if(res>-2 && res<6 && id_dev_srv>0){
						if(res>-1 && xmlhttp.responseText != 0){
							var arr_srv = xmlhttp.responseText.split("|");
							yy = x[0].getElementsByTagName(id_lng);
							y = x[1].getElementsByTagName(id_lng);
							if(window.confirm(y[0].childNodes[0].nodeValue+arr_srv.length+yy[0].childNodes[0].nodeValue)){
								for(var i = 0; i < arr_srv.length; i++){
									maj('dev_srv','res',res,arr_srv[i]);
									sel_srv('srv',arr_srv[i]);
								}
							}
						}
						maj('dev_srv','res',res,id_dev_srv,id_dev_prs);
						vue_crc('res');
						window.parent.act_frm('frn_ope');
					}
					else if(res==0 && id_dev_srv==0 && xmlhttp.responseText != 0){
						var arr_srv=xmlhttp.responseText.split("|");
						yy=x[2].getElementsByTagName(id_lng);
						y=x[3].getElementsByTagName(id_lng);
						if(window.confirm(y[0].childNodes[0].nodeValue+arr_srv.length+yy[0].childNodes[0].nodeValue)){
							if(cnf>0){
								xx=xmlDoc.getElementsByTagName("cnf");
								yy=xx[0].getElementsByTagName(id_lng);
								if(window.confirm(yy[0].childNodes[0].nodeValue)==false){return 0;}
							}
							act_trf('frn_all',arr_srv,0);
						}
					}
				}
				else if(xmlhttp.status==408){src_frn(res,id_frn,id_dev_srv);}
				else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR SRC_FRN "+xmlhttp.statusText+" </span>";}
				unload('DEV');
			}
		}
		xmlhttp.open("POST","../fct/src_frn.php",true);
		xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xmlhttp.send("id_frn="+id_frn+"&id_dev_srv="+id_dev_srv+"&id_dev_crc="+id_dev_crc+"&res="+res+"&cnf="+cnf);
	}
}
