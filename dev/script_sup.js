function sup(obj,id,id_sup,ok,id_cat,id_cat_sup,id_sup2,opt,id_sel_ant_obj){
	if(ok!=1){
		if(window.XMLHttpRequest){xhttp=new XMLHttpRequest();}
		else{xhttp=new ActiveXObject("Microsoft.XMLHTTP");}
		xhttp.open("GET","txt_js.xml",false); //remplazar por json
		xhttp.send();
		xmlDoc=xhttp.responseXML;
		x=xmlDoc.getElementsByTagName("sup_"+obj);
		y=x[0].getElementsByTagName(id_lng);
		if(window.confirm(y[0].childNodes[0].nodeValue)==false){return;}
	}
	if(id_cat_sup>0){
		if(obj=='mdl' && sup_cat('crc',id_sup)==0){return;}
		else if(obj=='jrn' && opt==1 && sup_cat('mdl',id_sup)==0){return;}
		else if(obj=='prs' && opt==1 && sup_cat('jrn',id_sup)==0){return;}
		else if(obj=='srv' && sup_cat('prs',id_sup)==0){return;}
		else if(obj=='hbr' && sup_cat('prs',id_sup)==0){return;}
	}
	if(obj == 'hbr' && ok == 0)
		searchHbr(id_cat,id_sup2,0,0,id,id_sup,'sup')
	var xhr = obj+id;
	if(window.XMLHttpRequest){eval('xmlhttp_sup'+xhr+'=new XMLHttpRequest()');}
	else{eval('xmlhttp_sup'+xhr+'=new ActiveXObject("Microsoft.XMLHTTP")');}
	load('DEV sup');
	eval('xmlhttp_sup'+xhr).onreadystatechange=function(){
		if(eval('xmlhttp_sup'+xhr).readyState==4){
			if(eval('xmlhttp_sup'+xhr).status==200){
				if(obj=='mdl'){
					if(eval('xmlhttp_sup'+xhr).responseText!=-1){
						$("#div_mdl"+id).stop(true,true).slideUp();
						if(eval('xmlhttp_sup'+xhr).responseText!=0){
							sel_mdl('end_mdl_avt',eval('xmlhttp_sup'+xhr).responseText);
							vue_mdl('ttr',eval('xmlhttp_sup'+xhr).responseText);
							vue_mdl('end',eval('xmlhttp_sup'+xhr).responseText);
							sel_jrn('ttr_jrn',eval('xmlhttp_sup'+xhr).responseText);
							sel_mdl('ttr_jrn_apr',eval('xmlhttp_sup'+xhr).responseText);
							sel_mdl('ttr_mdl_apr',eval('xmlhttp_sup'+xhr).responseText);
							sel_mdl('end_mdl_apr',eval('xmlhttp_sup'+xhr).responseText);
						}
						vue_crc('ttf');
						vue_crc('res');
						vue_crc('res');
						window.parent.act_frm('hbr_ope');
						window.parent.act_frm('frn_ope');
						document.getElementById('div_mdl'+id).remove();
						if(id_cat>0){window.parent.act_frm('mdl_dev'+id_cat);}
					}
					else{
						var x = xmlDoc.getElementsByTagName("sup_res");
						var y = x[0].getElementsByTagName(id_lng);
						alt(y[0].childNodes[0].nodeValue);
					}
				}
				else if(obj=='jrn'){
					if(eval('xmlhttp_sup'+xhr).responseText!=-1){
						var rsp = eval('xmlhttp_sup'+xhr).responseText.split("|");
						if(document.getElementById('div_jrn'+id)){
							if($('#div_jrn'+id).prev().is('br')){$('#div_jrn'+id).prev().remove();}
						/*	if($('#div_jrn'+id).hasClass()){
								var cl = $('#div_jrn'+id).attr("class").split(" ");
								$('#div_jrn'+id).stop(true,true).slideUp();
								if($('.'+cl[0]).length == 1){document.getElementById('opt_'+cl[0]).remove();} // bug quand on efface 2 prestations d'affilé
								else{vue_elem('opt_'+cl[0],0);}
								if(cl[1]=='sel_opt'){
									$("."+cl[0]).each(function(){$(this).remove();});
									if(document.getElementById('opt_'+cl[0])){document.getElementById('opt_'+cl[0]).remove();}
								}
								else{document.getElementById('div_jrn'+id).remove();}
							}
							else{*/document.getElementById('div_jrn'+id).remove();//} les options sont dans 'div_jrn'+id
						}
						else if(document.getElementById('div_mdl'+id_sup)){vue_mdl('dt',id_sup);}
						vue_crc('res');vue_mdl('end',id_sup);sel_mdl('ttr_jrn_apr',id_sup);sel_mdl('end_mdl_apr',id_sup);vue_crc('ttf');
						window.parent.act_frm('hbr_ope');
						window.parent.act_frm('frn_ope');
						if(rsp[0]>0){sel_jrn('ttr_jrn_apr',id_sup,rsp[0]);} // manque ? sel_jrn('opt_jrn_apr',id_sup) & sel_mdl('opt_jrn_apr',id_sup)
						if(id_cat>0){window.parent.act_frm('jrn_dev'+id_cat);}
					}
					else{
						var x = xmlDoc.getElementsByTagName("sup_res");
						var y = x[0].getElementsByTagName(id_lng);
						alt(y[0].childNodes[0].nodeValue);
					}


				/*	if(eval('xmlhttp_sup'+xhr).responseText!=-1){
						if(opt==1){
							$('#div_jrn'+id).stop(true,true).slideUp();
							if(eval('xmlhttp_sup'+xhr).responseText!=0){
								sel_jrn('ttr_jrn_apr',id_sup,eval('xmlhttp_sup'+xhr).responseText);
								vue_jrn('ttr',eval('xmlhttp_sup'+xhr).responseText);
							}
							vue_mdl('ttr',id_sup);vue_mdl('end',id_sup);
							sel_mdl('ttr_jrn_apr',id_sup);sel_mdl('opt_jrn_apr',id_sup);sel_mdl('end_mdl_apr',id_sup);
							vue_crc('ttf');vue_crc('res');
							$('#div_jrn'+id).prev('br').remove();
							document.getElementById('div_jrn'+id).remove();
							window.parent.act_frm('hbr_ope');
							window.parent.act_frm('frn_ope');
						}
						else{
							vue_jrn('ttr',id_sel_ant_obj);
							vue_elem('opt_jrn'+id_sel_ant_obj,0);
							$('#vue_ttr_jrn_'+id).stop(true,true).slideUp();
							$('#vue_dsc_dt_end_jrn_'+id).stop(true,true).slideUp();
							document.getElementById('vue_ttr_jrn_'+id).remove();
							document.getElementById('vue_dsc_dt_end_jrn_'+id).remove();
						}
						if(id_cat>0){window.parent.act_frm('jrn_dev'+id_cat);}
					}
					else{
						var x = xmlDoc.getElementsByTagName("sup_res");
						var y = x[0].getElementsByTagName(id_lng);
						alt(y[0].childNodes[0].nodeValue);
					}*/
				}
				else if(obj=='prs'){
					if(eval('xmlhttp_sup'+xhr).responseText!=-1){
						var rsp = eval('xmlhttp_sup'+xhr).responseText.split("|");
						if(document.getElementById('div_prs'+id)){
							var cl = $('#div_prs'+id).attr("class").split(" ");
							if($('#div_prs'+id).prev().is('br')){$('#div_prs'+id).prev().remove();}
							$('#div_prs'+id).stop(true,true).slideUp();
							if($('.'+cl[0]).length == 1){document.getElementById('opt_'+cl[0]).remove();} // bug quand on efface 2 prestations d'affilé
							else{vue_elem('opt_'+cl[0],0);}
							if(cl[1]=='sel_opt'){
								$("."+cl[0]).each(function(){$(this).remove();});
								if(document.getElementById('opt_'+cl[0])){document.getElementById('opt_'+cl[0]).remove();}
							}
							else{document.getElementById('div_prs'+id).remove();}
						}
						else if(document.getElementById('div_jrn'+id_sup)){vue_jrn('dt',id_sup);}
						vue_crc('res');
						window.parent.act_frm('hbr_ope');
						window.parent.act_frm('frn_ope');
						if(rsp[0]>0){sel_prs('ttr_prs_apr',id_sup,rsp[0]);}
						if(id_cat>0){window.parent.act_frm('prs_dev'+id_cat);}
					}
					else{
						var x = xmlDoc.getElementsByTagName("sup_res");
						var y = x[0].getElementsByTagName(id_lng);
						alt(y[0].childNodes[0].nodeValue);
					}
				}
				else if(obj=='srv'){
					vue_elem('prs_ctg_prs'+id_sup,id_sup);
					vue_prs('dt',id_sup);
					vue_crc('res');
					if(id_cat>0){window.parent.act_frm('srv_dev'+id_cat);}
				}
				else if(obj=='hbr'){
					vue_elem('prs_ctg_prs'+id_sup,id_sup);
					vue_prs('dt',id_sup);
					vue_crc('res');
					window.parent.act_frm('hbr_ope');
					if(id_cat>0){window.parent.act_frm('hbr_dev'+id_cat);}
				}
			}
			else if(eval('xmlhttp_sup'+xhr).status==408){sup(obj,id,id_sup,ok,id_cat,id_cat_sup,id_sup2,opt);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR SUP "+eval('xmlhttp_sup'+xhr).statusText+" </span>";}
			unload('DEV sup');
		}
	}
	eval('xmlhttp_sup'+xhr).open("POST","sup.php",true);
	eval('xmlhttp_sup'+xhr).setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	eval('xmlhttp_sup'+xhr).send("obj="+obj+"&id="+id+"&id_sup="+id_sup);
}

function sup_bss(cbl,id){
	if (window.XMLHttpRequest){xhttp=new XMLHttpRequest();}
	else {xhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	xhttp.open("GET","txt_js.xml",false); //remplazar por json
	xhttp.send();
	xmlDoc=xhttp.responseXML;
	x=xmlDoc.getElementsByTagName("sup_bss");
	y=x[0].getElementsByTagName(id_lng);
	var bss = prompt(y[0].childNodes[0].nodeValue);
	if(bss == null || bss==''){return;}
	y=x[1].getElementsByTagName(id_lng);
	if(window.confirm(y[0].childNodes[0].nodeValue+bss)==false){return;}
	if(window.XMLHttpRequest){xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load('DEV');
	xmlhttp.onreadystatechange=function(){
		if(xmlhttp.readyState==4){
			if(xmlhttp.status==200){
				if(cbl=='mdl'){vue_mdl('ttr',id);vue_mdl('trf',id);sel_jrn('dt_prs',id);}
				else if(cbl=='crc'){vue_crc('ttr');vue_crc('trf');sel_mdl('dt_prs');}
				vue_crc('res');
			}
			else if(xmlhttp.status==408){sup_bss(cbl,id);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR SUP_BSS "+xmlhttp.statusText+" </span>";}
			unload('DEV');
		}
	}
	xmlhttp.open("POST","sup_bss.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("cbl="+cbl+"&id="+id+"&base="+bss);
}

function sup_pax(cbl,id,id_sup){
	if(window.XMLHttpRequest){xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load('DEV');
	xmlhttp.onreadystatechange=function(){
		if(xmlhttp.readyState==4){
			if(xmlhttp.status==200){
				if(cbl=='mdl'){vue_mdl('pax',id_sup);}
				else if(cbl=='crc'){vue_crc('pax');}
			}
			else if(xmlhttp.status==408){sup_pax(cbl,id,id_sup);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR SUP_PAX "+xmlhttp.statusText+" </span>";}
			unload('DEV');
		}
	}
	xmlhttp.open("POST","sup_pax.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("cbl="+cbl+"&id="+id);
}

function sup_rmn(cbl,id,nr){
	if(window.XMLHttpRequest){xhttp=new XMLHttpRequest();}
	else{xhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	xhttp.open("GET","txt_js.xml",false); //remplazar por json
	xhttp.send();
	xmlDoc=xhttp.responseXML;
	x=xmlDoc.getElementsByTagName("sup_rmn");
	y=x[0].getElementsByTagName(id_lng);
	if(window.confirm(y[0].childNodes[0].nodeValue+nr)==false){return;}
	if(window.XMLHttpRequest){xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load('DEV');
	xmlhttp.onreadystatechange=function(){
		if(xmlhttp.readyState==4){
			if(xmlhttp.status==200){
				if(cbl=='mdl'){vue_mdl('ttr',id);vue_mdl('rmn',id);sel_jrn('end_prs',id);}
				else if(cbl=='crc'){vue_crc('ttr');vue_crc('rmn');sel_mdl('end_prs');}
			}
			else if(xmlhttp.status==408){sup_rmn(cbl,id);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR SUP_RMN "+xmlhttp.statusText+" </span>";}
			unload('DEV');
		}
	}
	xmlhttp.open("POST","sup_rmn.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("cbl="+cbl+"&id="+id+"&nr="+nr);
}

function sup_rmn_pax(cbl,id_rmn,id_pax){
	if(window.XMLHttpRequest){xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load('DEV sup_rmn_pax');
	xmlhttp.onreadystatechange=function(){
		if(xmlhttp.readyState==4){
			if(xmlhttp.status==200){vue_elem(cbl+'_rmn_pax'+id_rmn+'_'+id_pax,xmlhttp.responseText);}
			else if(xmlhttp.status==408){sup_rmn_pax(cbl,id_rmn,id_pax);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR SUP_RMN_PAX "+xmlhttp.statusText+" </span>";}
			unload('DEV sup_rmn_pax');
		}
	}
	xmlhttp.open("POST","sup_rmn_pax.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("cbl="+cbl+"&id_rmn="+id_rmn+"&id_pax="+id_pax);
}

function ask_sup_cat(cbl,id,id_cat,id_sup,id_sup2,id_sup3){
	if(cbl=='prs'){
		if(sup_cat('jrn',id_sup,id_sup2,id_sup3)==0){$("#trfopt_prs"+id).prop('checked',true);return;}
		maj('dev_prs','opt','0',id,id_sup);
	}
	else if(cbl=='jrn'){
		if(sup_cat('mdl',id_sup,id_sup2)==0){$("#trfopt_jrn"+id).prop('checked',false);return;}
		maj('dev_jrn','opt','0',id,id_sup);
	}
}

function sup_cat(obj,id,id_sup,id_sup2,id_sup3){
	if (window.XMLHttpRequest){xhttp=new XMLHttpRequest();}
	else {xhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	xhttp.open("GET","txt_js.xml",false); //remplazar por json
	xhttp.send();
	xmlDoc=xhttp.responseXML;
	x=xmlDoc.getElementsByTagName("sup_cat_"+obj);
	y=x[0].getElementsByTagName(id_lng);
	if(window.confirm(y[0].childNodes[0].nodeValue)==false){return 0;}
	if(window.XMLHttpRequest){xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	xmlhttp.onreadystatechange=function(){
		if(xmlhttp.readyState==4){
			if(xmlhttp.status==200){
				if(obj=='crc'){vue_crc('ttr');vue_crc('end');sel_mdl('ttr_mdl',id);}
				else if(obj=='mdl'){$("#vue_ttr_mdl_"+id).removeClass();vue_crc('ttr');vue_crc('end');vue_mdl('ttr',id);vue_mdl('end',id);sel_jrn('ttr_jrn',id);sel_jrn('opt_jrn',id);}
				else if(obj=='jrn'){$("#vue_ttr_jrn_"+id).removeClass();vue_crc('ttr');vue_crc('end');vue_mdl('ttr',id_sup);vue_mdl('end',id_sup);vue_jrn('ttr',id);vue_jrn('end',id);sel_prs('ttr_prs',id);}
				else if(obj=='prs'){$("#vue_ttr_prs_"+id).removeClass();vue_crc('ttr');vue_crc('end');vue_mdl('ttr',id_sup2);vue_mdl('end',id_sup2);vue_jrn('ttr',id_sup);vue_jrn('end',id_sup);vue_prs('ttr',id);vue_prs('dt',id);vue_prs('end',id);}
				else if(obj=='hbr' || obj=='srv'){vue_crc('ttr');vue_crc('end');vue_mdl('ttr',id_sup3);vue_mdl('end',id_sup3);vue_jrn('ttr',id_sup2);vue_jrn('end',id_sup2);vue_prs('ttr',id_sup);vue_prs('end',id_sup);sel_srv(obj,id);}
			}
			else if(xmlhttp.status==408){sup_cat(obj,id,id_sup,id_sup2,id_sup3);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR SUP_CAT "+xmlhttp.statusText+" </span>";}
		}
	}
	xmlhttp.open("POST","sup_cat.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("obj="+obj+"&id="+id);
}

function sup_pay(cbl,id,id_sup){
	if(window.XMLHttpRequest){xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load('DEV');
	xmlhttp.onreadystatechange=function(){
		if(xmlhttp.readyState==4){
			if(xmlhttp.status==200){
				vue_elem(cbl+'_pay_pay'+id_sup,id_sup);
				vue_crc('res');
				window.parent.act_frm(cbl+'_pay');
			}
			else if(xmlhttp.status==408){sup_pay(cbl,id,id_sup);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR SUP_PAY "+xmlhttp.statusText+" </span>";}
			unload('DEV');
		}
	}
	xmlhttp.open("POST","../fct/sup_pay.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("cbl="+cbl+"&id="+id);
}
