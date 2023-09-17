function ajt_mdl(id_cat_mdl,id_cat_crc,id_rgn){
	if(id_cat_crc>0){
		if(sup_cat('crc',id_dev_crc)==0){return;}
		flg_vue_ttr = true;
	}
	else{flg_vue_ttr = false;}
	var lgg = document.getElementById("lgg").value;
	if(window.XMLHttpRequest){xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load('DEV ajt_mdl');
	xmlhttp.onreadystatechange=function(){
		if(xmlhttp.readyState==4){
			if(xmlhttp.status==200){
				var rsp = xmlhttp.responseText.split("|"),div = document.createElement('div');
				div.id = "div_mdl"+rsp[0];
				var txt = "<div class='tbl_crc'><table width='100%'><tr id='vue_ttr_mdl_"+rsp[0]+"'";
				if(id_cat_mdl>0){
					txt += " class='up_mdl"+id_cat_mdl+"'";
					window.parent.act_frm('mdl_dev'+id_cat_mdl);
				}
				txt += "></tr><tr id='vue_trf_mdl_"+rsp[0]+"'></tr></table><div id='vue_dsc_rmn_dt_end_mdl_"+rsp[0]+"'><span id='vue_dsc_mdl_"+rsp[0]+"'></span><span id='vue_rmn_mdl_"+rsp[0]+"'></span><span id='vue_dt_mdl_"+rsp[0]+"' class='dboa'></span><div id='vue_end_mdl_"+rsp[0]+"' class='text-center'></div></div></div><br />";
				div.innerHTML = txt;
				div.style.display = 'none';
				document.getElementById("vue_dt_crc").appendChild(div);
				$.when(
					$.ajax({url:'vue_ttr_mdl.php',type:'POST',data:{id_dev_mdl:rsp[0],vue:1,id_dev_crc:id_dev_crc,cnf:cnf}}),
					$.ajax({url:'vue_trf_mdl.php',type:'POST',data:{id_dev_mdl:rsp[0],id_dev_crc:id_dev_crc,cnf:cnf}}),
					$.ajax({url:'vue_dsc_mdl.php',type:'POST',data:{id_dev_mdl:rsp[0],id_dev_crc:id_dev_crc,cnf:cnf}}),
					$.ajax({url:'vue_dt_mdl.php',type:'POST',data:{id_dev_mdl:rsp[0],vue:1,jrn_vue:0,id_dev_crc:id_dev_crc,cnf:cnf}}),
					$.ajax({url:'vue_end_mdl.php',type:'POST',data:{id_dev_mdl:rsp[0],vue:1,id_dev_crc:id_dev_crc,cnf:cnf}}),
				).then(function(a1,a2,a3,a4,a5){
					document.getElementById("vue_ttr_mdl_"+rsp[0]).innerHTML = a1[0];
					document.getElementById("vue_trf_mdl_"+rsp[0]).innerHTML = a2[0];
					document.getElementById("vue_dsc_mdl_"+rsp[0]).innerHTML = a3[0];
					document.getElementById("vue_dt_mdl_"+rsp[0]).innerHTML = a4[0];
					document.getElementById("vue_end_mdl_"+rsp[0]).innerHTML = a5[0];
					$("#div_mdl"+rsp[0]).stop(true,true).slideDown();
				});
				if(rsp[1].length>0){alt(rsp[1]);}
				if(rsp[2].length>0){alt(rsp[2]);}
				if(flg_vue_ttr){vue_crc('ttr');sel_mdl('ttr_mdl');}
				sel_mdl('end_mdl_avt',rsp[0]);vue_crc('ttf');vue_crc('end');vue_crc('res');
			}
			else if(xmlhttp.status==408){ajt_mdl(id_cat_mdl,id_cat_crc,id_rgn);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR AJT_MDL "+xmlhttp.statusText+" </span>";}
			unload('DEV ajt_mdl');
		}
	}
	xmlhttp.open("POST","ajt_mdl.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("id_cat_mdl="+id_cat_mdl+"&id_rgn="+id_rgn+"&id_dev_crc="+id_dev_crc+"&lgg="+lgg);
}

function ajt_jrn(id_cat_jrn,id_dev_mdl,ord_jrn,id_cat_mdl,id_sel_jrn){
	if(id_cat_mdl>0){
		vue_cmd('sel_jrn_rpl'+id_sel_jrn); //remplacer journee dans module devis : bug creer plusieurs fois! (quand id_cat_mdl > 0 ??)
		if(sup_cat('mdl',id_dev_mdl)==0){return;}
		flg_vue_ttr = true;
	}
	else{flg_vue_ttr = false;}
	var lgg = document.getElementById("lgg").value;
	if(window.XMLHttpRequest){xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load('DEV ajt_jrn');
	xmlhttp.onreadystatechange=function(){
		if(xmlhttp.readyState==4)
		{
			if(xmlhttp.status==200)
			{
				var rsp = xmlhttp.responseText.split("|");
				if(ord_jrn < 1)
				{
					var div = document.createElement('div');
					div.id = "div_jrn"+rsp[0];
					var txt = "<div";
					if(id_cat_jrn>-1)
					{
						txt += " class='tbl_jrn'";
					}
					txt += "><table id='vue_ttr_jrn_"+rsp[0]+"'"
					if(id_cat_jrn > 0)
					{
						txt += " class='up_jrn"+id_cat_jrn+"'";
						window.parent.act_frm('jrn_dev'+id_cat_jrn);
					}
					txt += " width='100%'";
					if(id_cat_jrn > -1)
					{
						txt += "></table><div id='vue_dsc_dt_end_jrn_"+rsp[0]+"'><table id='vue_dsc_jrn_"+rsp[0]+"' width='100%'></table>";
						txt += "<div id='vue_dt_jrn_"+rsp[0]+"' style='overflow-x: auto;'></div><div id='vue_end_jrn_"+rsp[0]+"' class='text-center'></div></div>";
					}
					if(aut)
					{
						txt += "<div id='rpl_opt_jrn"+rsp[0]+"' class='text-center'><table><tr><td id='rpl_jrn"+rsp[0]+"' class='ajt_jrn_rpl'></td><td id='opt_jrn"+rsp[0]+"' class='ajt_jrn_opt'></td></tr></table></div>";
					}
					txt += "</div>";
					div.innerHTML = txt;
					div.style.display = 'none';
					if(rsp[1] > 0)
					{
						var dt_mdl = document.getElementById("vue_dt_mdl_"+id_dev_mdl);
						dt_mdl.insertBefore(div,document.getElementById('div_jrn'+rsp[1]));
						dt_mdl.insertBefore(document.createElement("br"),document.getElementById('div_jrn'+rsp[1]));
					}else{
						document.getElementById("vue_dt_mdl_"+id_dev_mdl).appendChild(document.createElement("br"));
						document.getElementById("vue_dt_mdl_"+id_dev_mdl).appendChild(div);
					}
					vue_elem('opt_jrn'+rsp[0],0);
					vue_elem('rpl_jrn'+rsp[0],0);
					$.when(
						$.ajax({url:'vue_ttr_jrn.php',type:'POST',data:{id_dev_jrn:rsp[0],vue:1,id_dev_crc:id_dev_crc,cnf:cnf}}),
						$.ajax({url:'vue_dsc_jrn.php',type:'POST',data:{id_dev_jrn:rsp[0],id_dev_crc:id_dev_crc,cnf:cnf}}),
						$.ajax({url:'vue_dt_jrn.php',type:'POST',data:{id_dev_jrn:rsp[0],vue:1,id_dev_crc:id_dev_crc,cnf:cnf}}),
						$.ajax({url:'vue_end_jrn.php',type:'POST',data:{id_dev_jrn:rsp[0],vue:1,id_dev_crc:id_dev_crc,cnf:cnf}}),
					).then(function(a1,a2,a3,a4){
						document.getElementById("vue_ttr_jrn_"+rsp[0]).innerHTML = a1[0];
						document.getElementById("vue_dsc_jrn_"+rsp[0]).innerHTML = a2[0];
						document.getElementById("vue_dt_jrn_"+rsp[0]).innerHTML = a3[0];
						document.getElementById("vue_end_jrn_"+rsp[0]).innerHTML = a4[0];
						$("#div_jrn"+rsp[0]).stop(true,true).slideDown();
						src_jrn(rsp[0],1);
					});
					vue_jrn('ttr',rsp[0]);vue_jrn('dsc',rsp[0]);vue_jrn('dt',rsp[0]);vue_jrn('end',rsp[0]);sel_jrn('ttr_jrn_apr',id_dev_mdl,rsp[0]);vue_mdl('end',id_dev_mdl);vue_crc('res');sel_mdl('ttr_jrn_apr',id_dev_mdl);sel_mdl('end_mdl_apr',id_dev_mdl);vue_crc('ttf');
					$("#div_jrn"+rsp[0]).stop(true,true).slideDown();
				}
				else{
					var tab = document.createElement('table'),div = document.createElement('div'),div1 = document.createElement('div');
					tab.id = "vue_ttr_jrn_"+rsp[0];div.id = "vue_dsc_dt_end_jrn_"+rsp[0];div1.id = "rpl_opt_jrn"+id_sel_jrn;
					if(id_cat_jrn>0){
						tab.setAttribute('class','cat_jrn'+id_cat_jrn);
						window.parent.act_frm('jrn_dev'+id_cat_jrn);
					}
					tab.setAttribute('width','100%');div1.setAttribute('class','text-center');
					var inn = "<table id='vue_dsc_jrn_"+rsp[0]+"' width='100%'></table><div id='vue_dt_jrn_"+rsp[0]+"'";
					inn += " style='overflow-x: auto;'></div><div id='vue_end_jrn_"+rsp[0]+"' class='text-center'></div>";
					div.innerHTML = inn;
					var inn = "<table><tr><td id='rpl_jrn"+id_sel_jrn+"' class='ajt_jrn_rpl'></td><td id='opt_jrn"+id_sel_jrn+"'";
					inn += " class='ajt_jrn_opt'></td></tr></table>";
					div1.innerHTML = inn;
					tab.style.display = 'none';div.style.display = 'none';div1.style.display = 'none';
					document.getElementById('rpl_opt_jrn'+id_sel_jrn).remove();
					document.getElementById("div_jrn"+id_sel_jrn).getElementsByTagName('div')[0].appendChild(tab);
					document.getElementById("div_jrn"+id_sel_jrn).getElementsByTagName('div')[0].appendChild(div);
					document.getElementById("div_jrn"+id_sel_jrn).getElementsByTagName('div')[0].appendChild(div1);
					vue_elem('rpl_jrn'+id_sel_jrn,0);
					vue_elem('opt_jrn'+id_sel_jrn,0);
					$.when(
						$.ajax({url:'vue_ttr_jrn.php',type:'POST',data:{id_dev_jrn:rsp[0],vue:1,id_dev_crc:id_dev_crc,cnf:cnf}}),
						$.ajax({url:'vue_dsc_jrn.php',type:'POST',data:{id_dev_jrn:rsp[0],id_dev_crc:id_dev_crc,cnf:cnf}}),
						$.ajax({url:'vue_dt_jrn.php',type:'POST',data:{id_dev_jrn:rsp[0],vue:1,id_dev_crc:id_dev_crc,cnf:cnf}}),
						$.ajax({url:'vue_end_jrn.php',type:'POST',data:{id_dev_jrn:rsp[0],vue:1,id_dev_crc:id_dev_crc,cnf:cnf}}),
					).then(function(a1,a2,a3,a4){
						document.getElementById("vue_ttr_jrn_"+rsp[0]).innerHTML = a1[0];
						document.getElementById("vue_dsc_jrn_"+rsp[0]).innerHTML = a2[0];
						document.getElementById("vue_dt_jrn_"+rsp[0]).innerHTML = a3[0];
						document.getElementById("vue_end_jrn_"+rsp[0]).innerHTML = a4[0];
						$("#vue_ttr_jrn_"+rsp[0]).stop(true,true).slideDown();
						$("#vue_dsc_dt_end_jrn_"+rsp[0]).stop(true,true).slideDown();
						$("#rpl_opt_jrn"+id_sel_jrn).stop(true,true).slideDown();
						src_jrn(rsp[0],0);
					});
					vue_jrn('ttr',id_sel_jrn);
				}
				if(flg_vue_ttr){vue_mdl('ttr',id_dev_mdl);sel_jrn('ttr_jrn',id_dev_mdl);}
				if(rsp[2].length>0){alt(rsp[2]);}
				if(rsp[3].length>0){alt(rsp[3]);}
			}
			else if(xmlhttp.status==408){ajt_jrn(id_cat_jrn,id_dev_mdl,ord_jrn,id_cat_mdl,id_sel_jrn);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR AJT_JRN "+xmlhttp.statusText+" </span>";}
			unload('DEV ajt_jrn');
		}
	}
	xmlhttp.open("POST","ajt_jrn.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("id_cat_jrn="+id_cat_jrn+"&id_dev_mdl="+id_dev_mdl+"&ord_jrn="+ord_jrn+"&id_dev_crc="+id_dev_crc+"&lgg="+lgg);
}

function ajt_jrn_jrn_opt(id_dev_jrn){
	if(window.XMLHttpRequest){eval('xmlhttp_ajt_jrn_jrn_opt'+id_dev_jrn+'=new XMLHttpRequest()');}
	else{eval('xmlhttp_ajt_jrn_jrn_opt'+id_dev_jrn+'=new ActiveXObject("Microsoft.XMLHTTP")');}
	eval('xmlhttp_ajt_jrn_jrn_opt'+id_dev_jrn).onreadystatechange=function(){
		if(eval('xmlhttp_ajt_jrn_jrn_opt'+id_dev_jrn).readyState==4){
			if(eval('xmlhttp_ajt_jrn_jrn_opt'+id_dev_jrn).status==200){
				var span = document.createElement('span');
				span.id = "opt_jrn_jrn"+eval('xmlhttp_ajt_jrn_jrn_opt'+id_dev_jrn).responseText;
				span.setAttribute('class','ajt_jrn_opt');
				document.getElementById("div_jrn"+id_dev_jrn).parentNode.insertBefore(span, document.getElementById("div_jrn"+id_dev_jrn).nextSibling);
				vue_elem('opt_jrn_jrn'+eval('xmlhttp_ajt_jrn_jrn_opt'+id_dev_jrn).responseText);
			}
			else if(eval('xmlhttp_ajt_jrn_jrn_opt'+id_dev_jrn).status==408){ajt_jrn_jrn_opt(id_dev_jrn);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR AJT_JRN_JRN_OPT "+eval('xmlhttp_ajt_jrn_jrn_opt'+id_dev_jrn).statusText+" </span>";}
		}
	}
	eval('xmlhttp_ajt_jrn_jrn_opt'+id_dev_jrn).open("POST","ajt_jrn_jrn_opt.php",true);
	eval('xmlhttp_ajt_jrn_jrn_opt'+id_dev_jrn).setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	eval('xmlhttp_ajt_jrn_jrn_opt'+id_dev_jrn).send("id_dev_jrn="+id_dev_jrn);
}

function ajt_prs(id_cat_prs,id_dev_jrn,ord_prs,ctg_prs,id_cat_jrn,id_dev_mdl,id_ant_prs){
	if(id_cat_jrn>0){
		if(sup_cat('jrn',id_dev_jrn)==0){return;}
		flg_vue_ttr = true;
	}
	else{flg_vue_ttr = false;}
	var lgg = document.getElementById("lgg").value;
	if(window.XMLHttpRequest){eval('xmlhttp_ajt_prs'+id_dev_jrn+'=new XMLHttpRequest()');}
	else{eval('xmlhttp_ajt_prs'+id_dev_jrn+'=new ActiveXObject("Microsoft.XMLHTTP")');}
	load('DEV ajt_prs');
	eval('xmlhttp_ajt_prs'+id_dev_jrn).onreadystatechange=function(){
		if(eval('xmlhttp_ajt_prs'+id_dev_jrn).readyState==4){
			if(eval('xmlhttp_ajt_prs'+id_dev_jrn).status==200){
				var rsp = eval('xmlhttp_ajt_prs'+id_dev_jrn).responseText.split("|");
				if(ord_prs<1){
					var div = document.createElement('div');
					div.id = "div_prs"+rsp[0];
					div.setAttribute('class','prs_prs'+id_dev_jrn+'_'+rsp[2]+' sel_opt');
					txt = "<table width='100%'><tr id='vue_ttr_prs_"+rsp[0]+"' ";
					if(id_cat_prs>0){
						txt += "class='list_prs"+id_cat_prs+"'";
						window.parent.act_frm('prs_dev'+id_cat_prs);
					}
					txt +="></tr><tr id='vue_dsc_prs_"+rsp[0]+"'></tr></table><span id='vue_dt_prs_"+rsp[0]+"' class='up_srv up_hbr'></span><span id='vue_end_prs_"+rsp[0]+"'></span><div id='vue_trf_hbr_"+rsp[0]+"'></div>";
					div.innerHTML = txt;
					div.style.display = 'none';
					if(rsp[1]>0){
						var dt_jrn = document.getElementById("vue_dt_jrn_"+id_dev_jrn);
						if(dt_jrn.insertBefore(div,document.getElementById('div_prs'+rsp[1]))){ajt_prs_prs_opt(rsp[0]);}
						dt_jrn.insertBefore(document.createElement("br"),document.getElementById('div_prs'+rsp[1]));
						if(!flg_vue_ttr){sel_prs('ttr_prs',id_dev_jrn);}//remplacé par ttr_prs_after
					}
					else{
						document.getElementById("vue_dt_jrn_"+id_dev_jrn).appendChild(document.createElement("br"));
						if(document.getElementById("vue_dt_jrn_"+id_dev_jrn).appendChild(div)){ajt_prs_prs_opt(rsp[0]);}
					}
					if(flg_vue_ttr){vue_jrn('ttr',id_dev_jrn);sel_prs('ttr_prs',id_dev_jrn);}
					vue_prs('ttr',rsp[0]);vue_prs('dsc',rsp[0]);vue_prs('dt',rsp[0]);vue_prs('end',rsp[0]);vue_jrn('end',id_dev_jrn);vue_crc('res');
					$("#div_prs"+rsp[0]).stop(true,true).slideDown();
				}
				else if(document.getElementById("div_prs"+id_ant_prs)){
					if(flg_vue_ttr){vue_jrn('ttr',id_dev_jrn);}
					sel_prs('ttr_prs',id_dev_jrn);
					var div = document.createElement('div');
					div.id = "div_prs"+rsp[0];
					div.setAttribute('class','prs_prs'+id_dev_jrn+'_'+ord_prs);
					txt = "<table width='100%'><tr id='vue_ttr_prs_"+rsp[0]+"' ";
					if(id_cat_prs>0){
						txt += "class='list_prs"+id_cat_prs+"'";
						window.parent.act_frm('prs_dev'+id_cat_prs);
					}
					txt +="></tr><tr id='vue_dsc_prs_"+rsp[0]+"'></tr></table><span id='vue_dt_prs_"+rsp[0]+"' class='up_srv up_hbr'></span><span id='vue_end_prs_"+rsp[0]+"'></span><div id='vue_trf_hbr_"+rsp[0]+"'></div>";
					div.innerHTML = txt;
					div.style.display = 'none';
					document.getElementById("div_prs"+id_ant_prs).parentNode.insertBefore(div, document.getElementById("div_prs"+id_ant_prs).nextSibling);
					vue_prs('ttr',rsp[0]);vue_prs('dsc',rsp[0]);vue_prs('dt',rsp[0]);vue_prs('end',rsp[0]);
					vue_elem('opt_prs_prs'+id_dev_jrn+'_'+ord_prs,0);
					$("#div_prs"+rsp[0]).stop(true,true).slideDown();
				}
				else{vue_jrn('dt',id_dev_jrn);}
				if(rsp[3].length>0){alt(rsp[3]);}
				if(rsp[4].length>0){alt(rsp[4]);}
				src_jrn(id_dev_jrn,1);
			}
			else if(eval('xmlhttp_ajt_prs'+id_dev_jrn).status==408){ajt_prs(id_cat_prs,id_dev_jrn,ord_prs,ctg_prs,id_cat_jrn,id_dev_mdl,id_ant_prs);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR AJT_PRS "+eval('xmlhttp_ajt_prs'+id_dev_jrn).statusText+" </span>";}
			unload('DEV ajt_prs');
		}
	}
	eval('xmlhttp_ajt_prs'+id_dev_jrn).open("POST","ajt_prs.php",true);
	eval('xmlhttp_ajt_prs'+id_dev_jrn).setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	eval('xmlhttp_ajt_prs'+id_dev_jrn).send("id_cat_prs="+id_cat_prs+"&id_dev_jrn="+id_dev_jrn+"&ord_prs="+ord_prs+"&ctg_prs="+ctg_prs+"&lgg="+lgg+"&cnf="+cnf);
}

function ajt_prs_prs_opt(id_dev_prs){
	if(window.XMLHttpRequest){eval('xmlhttp_ajt_prs_prs_opt'+id_dev_prs+'=new XMLHttpRequest()');}
	else{eval('xmlhttp_ajt_prs_prs_opt'+id_dev_prs+'=new ActiveXObject("Microsoft.XMLHTTP")');}
	eval('xmlhttp_ajt_prs_prs_opt'+id_dev_prs).onreadystatechange=function(){
		if(eval('xmlhttp_ajt_prs_prs_opt'+id_dev_prs).readyState==4){
			if(eval('xmlhttp_ajt_prs_prs_opt'+id_dev_prs).status==200){
				var span = document.createElement('span');
				span.id = "opt_prs_prs"+eval('xmlhttp_ajt_prs_prs_opt'+id_dev_prs).responseText;
				span.setAttribute('class','ajt_prs_opt');
				document.getElementById("div_prs"+id_dev_prs).parentNode.insertBefore(span, document.getElementById("div_prs"+id_dev_prs).nextSibling);
				vue_elem('opt_prs_prs'+eval('xmlhttp_ajt_prs_prs_opt'+id_dev_prs).responseText);
			}
			else if(eval('xmlhttp_ajt_prs_prs_opt'+id_dev_prs).status==408){ajt_prs_prs_opt(id_dev_prs);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR AJT_PRS_PRS_OPT "+eval('xmlhttp_ajt_prs_prs_opt'+id_dev_prs).statusText+" </span>";}
		}
	}
	eval('xmlhttp_ajt_prs_prs_opt'+id_dev_prs).open("POST","ajt_prs_prs_opt.php",true);
	eval('xmlhttp_ajt_prs_prs_opt'+id_dev_prs).setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	eval('xmlhttp_ajt_prs_prs_opt'+id_dev_prs).send("id_dev_prs="+id_dev_prs);
}

function ajt_srv(id_cat_srv,id_dev_prs,vll_srv,ctg_srv){
	if(window.XMLHttpRequest){xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load('DEV ajt_srv');
	xmlhttp.onreadystatechange=function(){
		if(xmlhttp.readyState==4){
			if(xmlhttp.status==200){
				vue_elem('prs_ctg_prs'+id_dev_prs,id_dev_prs);
				vue_prs('dt',id_dev_prs);
				vue_crc('res');
				var rsp = xmlhttp.responseText.split("|");
				if(rsp[0].length>0){alt(rsp[0]);}
				if(id_cat_srv>0){
					if(rsp[1].length>0){alt(rsp[1]);}
					window.parent.act_frm('srv_dev'+id_cat_srv);
				}
			}
			else if(xmlhttp.status==408){ajt_srv(id_cat_srv,id_dev_prs,vll_srv,ctg_srv);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR AJT_SRV "+xmlhttp.statusText+" </span>";}
			unload('DEV ajt_srv');
		}
	}
	xmlhttp.open("POST","ajt_srv.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("id_cat_srv="+id_cat_srv+"&id_dev_prs="+id_dev_prs+"&vll_srv="+vll_srv+"&ctg_srv="+ctg_srv);
}

function ajt_hbr(id_cat_hbr,id_cat_chm,id_hbr_vll,id_hbr_rgm,id_dev_hbr,id_dev_prs,alrt,sel,res,dt_res,rva){
	if(id_dev_hbr=='0'){
		if(window.XMLHttpRequest){eval('xmlhttp_ajt_hbr'+id_dev_prs+'=new XMLHttpRequest()');}
		else{eval('xmlhttp_ajt_hbr'+id_dev_prs+'=new ActiveXObject("Microsoft.XMLHTTP")');}
		load('DEV ajt_hbr');
		eval('xmlhttp_ajt_hbr'+id_dev_prs).onreadystatechange=function(){
			if(eval('xmlhttp_ajt_hbr'+id_dev_prs).readyState==4){
				if(eval('xmlhttp_ajt_hbr'+id_dev_prs).status==200){
					vue_elem('prs_ctg_prs'+id_dev_prs,id_dev_prs);
					vue_prs('dt',id_dev_prs);
					vue_crc('res');
					var rsp = eval('xmlhttp_ajt_hbr'+id_dev_prs).responseText.split("|");
					if(rsp[0].length>0){alt(rsp[0]);}
					if(alrt == 1 && typeof rsp[1]!=='undefined' && rsp[1].length>0){alt(rsp[1]);}
					if(id_cat_hbr>0){window.parent.act_frm('hbr_dev'+id_cat_hbr);}
				}
				else if(eval('xmlhttp_ajt_hbr'+id_dev_prs).status==408){ajt_hbr(id_cat_hbr,id_cat_chm,id_hbr_vll,id_hbr_rgm,id_dev_hbr,id_dev_prs,alrt,sel,res,dt_res,rva);}
				else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR AJT_HBR "+eval('xmlhttp_ajt_hbr'+id_dev_prs).statusText+" </span>";}
				unload('DEV ajt_hbr');
			}
		}
		eval('xmlhttp_ajt_hbr'+id_dev_prs).open("POST","ajt_hbr.php",true);
		eval('xmlhttp_ajt_hbr'+id_dev_prs).setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		eval('xmlhttp_ajt_hbr'+id_dev_prs).send("id_cat_hbr="+id_cat_hbr+"&id_cat_chm="+id_cat_chm+"&id_hbr_vll="+id_hbr_vll+"&id_hbr_rgm="+id_hbr_rgm+"&id_dev_hbr="+id_dev_hbr+"&id_dev_prs="+id_dev_prs+"&sel="+sel+"&res="+res+"&dt_res="+dt_res+"&rva="+rva);
	}
	else{
		if(window.XMLHttpRequest){eval('xmlhttp_ajt_hbr_'+id_dev_hbr+'=new XMLHttpRequest()');}
		else{eval('xmlhttp_ajt_hbr_'+id_dev_hbr+'=new ActiveXObject("Microsoft.XMLHTTP")');}
		load('DEV ajt_hbr');
		eval('xmlhttp_ajt_hbr_'+id_dev_hbr).onreadystatechange=function(){
			if(eval('xmlhttp_ajt_hbr_'+id_dev_hbr).readyState==4){
				if(eval('xmlhttp_ajt_hbr_'+id_dev_hbr).status==200){
					if(id_cat_hbr==-2 || id_cat_chm==-2){vue_prs('ttr',id_dev_prs);vue_prs('dsc',id_dev_prs);}
					if(id_dev_prs>0){vue_prs('dt',id_dev_prs);vue_prs('end',id_dev_prs);}
					else{sel_srv('hbr',id_dev_hbr);}
					vue_crc('res');
					if(eval('xmlhttp_ajt_hbr_'+id_dev_hbr).responseText.length>0){
						var rsp = eval('xmlhttp_ajt_hbr_'+id_dev_hbr).responseText.split("|");
						if(rsp[0].length>0){alt(rsp[0]);}
						if(alrt == 1){if(rsp[1].length>0){alt(rsp[1]);}}
					}
					if(id_cat_hbr>0){window.parent.act_frm('hbr_dev'+id_cat_hbr);}
				}
				else if(eval('xmlhttp_ajt_hbr_'+id_dev_hbr).status==408){ajt_hbr(id_cat_hbr,id_cat_chm,id_hbr_vll,id_hbr_rgm,id_dev_hbr,id_dev_prs,alrt,sel,res,dt_res,rva);}
				else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR AJT_HBR "+eval('xmlhttp_ajt_hbr_'+id_dev_hbr).statusText+" </span>";}
				unload('DEV ajt_hbr');
			}
		}
		eval('xmlhttp_ajt_hbr_'+id_dev_hbr).open("POST","ajt_hbr.php",true);
		eval('xmlhttp_ajt_hbr_'+id_dev_hbr).setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		eval('xmlhttp_ajt_hbr_'+id_dev_hbr).send("id_cat_hbr="+id_cat_hbr+"&id_cat_chm="+id_cat_chm+"&id_hbr_vll="+id_hbr_vll+"&id_hbr_rgm="+id_hbr_rgm+"&id_dev_hbr="+id_dev_hbr+"&sel="+sel+"&res="+res+"&dt_res="+dt_res+"&rva="+rva);
	}
}

function ajt_pax(cbl,id,id_sup){
	if(cbl=='crc'){id_sup = id_dev_crc;}
	if(window.XMLHttpRequest){xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load('DEV ajt_pax');
	xmlhttp.onreadystatechange=function(){
		if(xmlhttp.readyState==4){
			if(xmlhttp.status==200){
				if(cbl=='mdl'){vue_mdl('pax',id_sup);}
				else if(cbl=='crc'){vue_crc('pax');}
			}
			else if(xmlhttp.status==408){ajt_pax(cbl,id,id_sup);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR AJT_PAX "+xmlhttp.statusText+" </span>";}
			unload('DEV ajt_pax');
		}
	}
	xmlhttp.open("POST","ajt_pax.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("cbl="+cbl+"&id="+id+"&id_sup="+id_sup);
}

function ajt_rmn_pax(cbl,id_rmn,id_pax){
	if(window.XMLHttpRequest){xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load('DEV ajt_rmn_pax');
	xmlhttp.onreadystatechange=function(){
		if(xmlhttp.readyState==4){
			if(xmlhttp.status==200){vue_elem(cbl+'_rmn_pax'+id_rmn+'_'+id_pax,xmlhttp.responseText);}
			else if(xmlhttp.status==408){ajt_rmn_pax(cbl,id_rmn,id_pax);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR AJT_RMN_PAX "+xmlhttp.statusText+" </span>";}
			unload('DEV ajt_rmn_pax');
		}
	}
	xmlhttp.open("POST","ajt_rmn_pax.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("cbl="+cbl+"&id_rmn="+id_rmn+"&id_pax="+id_pax);
}

function ajt_pay(cbl,id,id_sup){
	if(window.XMLHttpRequest){xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load('DEV ajt_pay');
	xmlhttp.onreadystatechange=function(){
		if(xmlhttp.readyState==4){
			if(xmlhttp.status==200){
				if(document.getElementById(cbl+'_pay_pay'+id)){vue_elem(cbl+'_pay_pay'+id,id);}
				else{vue_prs('dt',id_sup);}
				vue_crc('res');
				window.parent.act_frm(cbl+'_pay');
			}
			else if(xmlhttp.status==408){ajt_pay(cbl,id,id_sup);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR AJT_PAY "+xmlhttp.statusText+" </span>";}
			unload('DEV ajt_pay');
		}
	}
	xmlhttp.open("POST","../fct/ajt_pay.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("cbl="+cbl+"&id="+id);
}

function ajt_rgn(id_mdl,id_rgn){
	if(window.XMLHttpRequest){xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load('DEV ajt_rgn');
	xmlhttp.onreadystatechange=function(){
		if(xmlhttp.readyState==4){
			if(xmlhttp.status==200){
				vue_mdl('end',id_mdl);
			}
			else if(xmlhttp.status==408){ajt_rgn(id_mdl,id_rgn);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR AJT_RGN "+xmlhttp.statusText+" </span>";}
			unload('DEV ajt_rgn');
		}
	}
	xmlhttp.open("POST","ajt_rgn.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("id_mdl="+id_mdl+"&id_rgn="+id_rgn);
}

function ajt_cat_mdl(id){
	if(window.XMLHttpRequest){xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load('DEV ajt_cat_mdl');
	xmlhttp.onreadystatechange=function(){
		if(xmlhttp.readyState==4){
			if(xmlhttp.status==200){
				if(xmlhttp.responseText != ''){
					vue_crc('dt');
				//a remplacer par ponctuel $("#vue_ttr_mdl_"+id).addClass("cat_mdl"+xmlhttp.responseText);vue_mdl('ttr',id);vue_mdl('end',id);sel_jrn('ttr_jrn',id);
				//+ une alerte pour actualiser text du mdl (hors jrn)
				}
			}
			else if(xmlhttp.status==408){ajt_cat_mdl(id);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR AJT_CAT_MDL "+xmlhttp.statusText+" </span>";}
			unload('DEV ajt_cat_mdl');
		}
	}
	xmlhttp.open("POST","ajt_cat_mdl.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("id="+id);
}



function grd(obj,id,id_sup,id_cat_hbr){
	if(document.getElementById('nom_'+obj+id)){
		var nom = document.getElementById('nom_'+obj+id).value;
		if(obj=='hbr'){var nom_chm = document.getElementById('nom_chm'+id).value;}
	}
	else{var nom = '';}
	if(document.getElementById('lgg')){var lgg = document.getElementById("lgg").value;}
	if(document.getElementById('vll_prs0')){var id_vll = document.getElementById("vll_prs0").value;}
	if(document.getElementById('ctg_prs0')){var ctg = document.getElementById("ctg_prs0").value;}
	if(window.XMLHttpRequest){xhttp=new XMLHttpRequest();}
	else{xhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	xhttp.open("GET","txt_js.xml",false); //remplazar por json
	xhttp.send();
	xmlDoc=xhttp.responseXML;
	if(nom==''){
		x=xmlDoc.getElementsByTagName("grd_"+obj);
		y=x[0].getElementsByTagName(id_lng);
		var nom = prompt(y[0].childNodes[0].nodeValue);
		if(nom == null || nom == ''){return;}
	}
	if(window.XMLHttpRequest){xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load('DEV grd');
	xmlhttp.onreadystatechange=function(){
		if(xmlhttp.readyState==4){
			if(xmlhttp.status==200){
				if(xmlhttp.responseText!=0){
					if(obj=='crc'){vue_crc('ttr');vue_crc('end');sel_mdl('ttr_mdl');sel_mdl('end_mdl');sel_mdl('ttr_jrn');sel_mdl('end_jrn');sel_mdl('ttr_prs');sel_mdl('dt_prs',id);sel_mdl('end_prs');window.parent.act_frm('crc');}
					else if(obj=='mdl'){$("#vue_ttr_mdl_"+id).addClass('cat_mdl'+xmlhttp.responseText);vue_mdl('ttr',id);vue_mdl('end',id);sel_jrn('ttr_jrn',id);sel_jrn('end_jrn',id);sel_jrn('ttr_prs',id);sel_jrn('dt_prs',id);sel_jrn('end_prs',id);window.parent.act_frm('mdl');}
					else if(obj=='jrn'){$("#vue_ttr_jrn_"+id).addClass('cat_jrn'+xmlhttp.responseText);vue_jrn('ttr',id);vue_jrn('end',id);sel_prs('ttr_prs',id);sel_prs('dt_prs',id);sel_prs('end_prs',id);window.parent.act_frm('jrn');}
					else if(obj=='prs'){$("#vue_ttr_prs_"+id).addClass('cat_prs'+xmlhttp.responseText);vue_prs('ttr',id);vue_prs('dt',id);vue_prs('end',id);window.parent.act_frm('prs');}
					else if((obj=='srv' || obj=='chm') && id_sup>0){vue_prs('dt',id_sup);}
					else if(obj=='hbr' || obj=='chm'){vue_prs('dt',id_sup);vue_prs('end',id_sup);vue_crc('res');}
					if(obj!='chm'){window.parent.opn_frm('cat/ctr.php?cbl='+obj+'&id='+xmlhttp.responseText);}
					else{window.parent.act_frm("hbr_chm"+id_cat_hbr);}
					x=xmlDoc.getElementsByTagName("grd");
					y=x[0].getElementsByTagName(id_lng);
					alt(y[0].childNodes[0].nodeValue);
				}
				else{
					x=xmlDoc.getElementsByTagName("grd2");
					y=x[0].getElementsByTagName(id_lng);
					alt(y[0].childNodes[0].nodeValue);
				}
			}
			else if(xmlhttp.status==408){grd(obj,id,id_sup,id_cat_hbr);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR GRD "+xmlhttp.statusText+" </span>";}
			unload('DEV grd');
		}
	}
	xmlhttp.open("POST","grd.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("obj="+obj+"&id="+id+"&nom="+encodeURIComponent(nom)+"&id_cat_hbr="+id_cat_hbr+"&lgg="+lgg+"&id_vll="+id_vll+"&ctg="+ctg+"&nom_chm="+encodeURIComponent(nom_chm));
}
