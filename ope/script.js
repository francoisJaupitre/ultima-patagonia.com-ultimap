var rang = 1,upd = 0;
var flg_maj = flg_dt_ope = true;

function maj(tab,col,val,id,id_sup,id_dev_crc){
	if(flg_maj){upd++;console.log('upd '+upd);flg_maj = false;}
	if (window.XMLHttpRequest){eval('xmlhttp_maj'+id+col+'=new XMLHttpRequest()');}
	else{eval('xmlhttp_maj'+id+col+'=new ActiveXObject("Microsoft.XMLHTTP")');}
	if(id_sup>0){load('OPE maj');}
	eval('xmlhttp_maj'+id+col).onreadystatechange=function(){
		if (eval('xmlhttp_maj'+id+col).readyState==4){
			if(eval('xmlhttp_maj'+id+col).status==200){
				 if((col=='info' || col=='heure') && eval('xmlhttp_maj'+id+col).responseText!=1){
					var x=document.getElementsByClassName("prs_res_srv"+id);
					for(i=0;i<x.length;i++){vue_elem(x[i].id,x[i].id.substr(7));}
					var y=document.getElementsByClassName("prs_res_hbr"+id);
					for(i=0;i<y.length;i++){vue_elem(y[i].id,y[i].id.substr(7));}
					window.parent.act_frm('prs_dev_srv'+id);
					window.parent.act_frm('prs_dev_hbr'+id);
					window.parent.act_frm('frn_ope');
					window.parent.act_frm('hbr_ope');
				}
				else if(col=='id_frn'){
					vue_elem('frn_srv'+id,id);
					vue_elem('res_srv'+id,id);
					vue_elem('cmd_srv'+id,id);
					window.parent.act_frm('srv_dev_frn'+id);
					window.parent.act_frm('srv_dev_srv'+id);
					window.parent.act_frm('crc_dev_srv'+id_dev_crc);
					window.parent.act_frm('frn_ope');
				}
				else if(col=='res' && tab=='dev_srv'){
					if(val=='-1'){dsp('srv',id,id_dev_crc);}
					vue_elem('res_srv'+id,id);
					vue_elem('frn_srv'+id,id);
					window.parent.act_frm('crc_dev_srv'+id_dev_crc);
					window.parent.act_frm('srv_dev_frn'+id);
					window.parent.act_frm('srv_dev_srv'+id);
				}
				else if(col=='res' && tab=='dev_hbr'){
					vue_elem('res_hbr'+id,id);
					window.parent.act_frm('hbr_dev_hbr'+id);
					window.parent.act_frm('crc_dev_hbr'+id_dev_crc);
					window.parent.act_frm('hbr_ope');
					}
				if(document.getElementById("txtHint").innerHTML.includes("SAVE ERROR")){document.getElementById("txtHint").innerHTML="";}
			}
			else if(eval('xmlhttp_maj'+id+col).status==408){maj(tab,col,val,id);}
			else{
				document.getElementById("txtHint").innerHTML="<span style='background: red;'>SAVE ERROR</span>";
				console.log(eval('xmlhttp_maj'+id+col).statusText);
			}
			if(!flg_maj){
				upd--;
				console.log('upd '+upd);
				flg_maj = true;
			}
			if(id_sup>0){unload('OPE maj');}
		}
	}
	eval('xmlhttp_maj'+id+col).open("POST","maj.php",true);
	eval('xmlhttp_maj'+id+col).setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	eval('xmlhttp_maj'+id+col).send("tab="+tab+"&col="+col+"&val="+encodeURIComponent(val)+"&id="+id);
}

function vue(){
	var cnf = document.getElementById('cnf').value;
	var dt_jrn = document.getElementById('dt_jrn').value;
	var id_grp = document.getElementById('sel_grp').value;
	var id_prs = document.getElementById('sel_prs').value;
	var id_vll = document.getElementById('sel_vll').value;
	var id_ctg = document.getElementById('sel_ctg').value;
	var id_srv = document.getElementById('sel_srv').value;
	var id_hbr = document.getElementById('sel_hbr').value;
	var id_frn = document.getElementById('sel_frn').value;
	var id_res = document.getElementById('sel_res').value;
	load('OPE vue');
	$.ajax({url:'vue.php', type:'POST', data:{cnf:cnf, id_grp:id_grp, dt_jrn:dt_jrn, id_prs:id_prs, id_vll:id_vll, id_ctg:id_ctg, id_srv:id_srv, id_hbr:id_hbr, id_frn:id_frn, id_res:id_res},
		success: function(responseText){
			$("#vue").html(responseText);
			rang = 1;
			flg_dt_ope = true;
			if(document.getElementById("txtHint").innerHTML.includes("VUE ERROR")){document.getElementById("txtHint").innerHTML="";}
			unload('OPE vue');
		},
		error: function (request, status, error){
			vue();
			document.getElementById("txtHint").innerHTML="<span style='background: red;'>VUE ERROR</span>";console.log('VUE ERROR: '+request.statusText);
		}
	});
}

function vue_dt_res(){
	if(flg_dt_ope){
		flg_dt_ope=false;
		if (window.XMLHttpRequest){xmlhttp=new XMLHttpRequest();}
		else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
		load('OPE vue_dt_res');
		var cnf = document.getElementById('cnf').value;
		var dt_jrn = document.getElementById('dt_jrn').value;
		var id_grp = document.getElementById('sel_grp').value;
		var id_prs = document.getElementById('sel_prs').value;
		var id_vll = document.getElementById('sel_vll').value;
		var id_ctg = document.getElementById('sel_ctg').value;
		var id_srv = document.getElementById('sel_srv').value;
		var id_hbr = document.getElementById('sel_hbr').value;
		var id_frn = document.getElementById('sel_frn').value;
		var id_res = document.getElementById('sel_res').value;
		rang++;
		xmlhttp.onreadystatechange=function(){
			if(xmlhttp.readyState==4){
				if(xmlhttp.status==200){
					if(xmlhttp.responseText!='0'){
						var arr_dt_res=xmlhttp.responseText.split("|");
						for(var i= 0; i < arr_dt_res.length; i++){
							if(arr_dt_res[i]!=''){
								var arr_dt_res_2 = arr_dt_res[i].split("$$");
								var tr_dt_res = document.createElement('tr');
								tr_dt_res.id = arr_dt_res_2[0];
								tr_dt_res.innerHTML = arr_dt_res_2[1];
								document.getElementById("tab_res").appendChild(tr_dt_res);
							}
						}
						flg_dt_ope=true;
					}
				else{unload('OPE vue_dt_res');}
				}
				else if(xmlhttp.status==408){
					flg_dt_ope=true;
					rang--;
					vue_dt_res();
				}
				else{
					flg_dt_ope=true;
					rang--;
					document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR VUE_DT_RES "+xmlhttp.statusText+" </span>";
				}
				unload('OPE vue_dt_res');
			}
		}
		xmlhttp.open("POST","vue_dt_res.php",true);
		xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xmlhttp.send("rang="+rang+"&cnf="+cnf+"&id_grp="+id_grp+"&dt_jrn="+dt_jrn+"&id_prs="+id_prs+"&id_vll="+id_vll+"&id_ctg="+id_ctg+"&id_srv="+id_srv+"&id_hbr="+id_hbr+"&id_frn="+id_frn+"&id_res="+id_res);
	}
}

function vue_elem(obj,id,col){
	if(typeof col == 'undefined'){var xhr = id+obj;}
	else{var xhr = id+obj+col;}
	if(window.XMLHttpRequest){eval('xmlhttp_vue_elem'+xhr+'=new XMLHttpRequest()');}
	else{eval('xmlhttp_vue_elem'+xhr+'=new ActiveXObject("Microsoft.XMLHTTP")');}
	if(document.getElementById(obj)){load('OPE vue_elem '+xhr);}
	else if(document.getElementById(obj+'_'+col+id)){
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
			if(document.getElementById(obj)){unload('OPE vue_elem '+xhr);}
		}
	}
	eval('xmlhttp_vue_elem'+xhr).open("POST","vue_elem.php",true);
	eval('xmlhttp_vue_elem'+xhr).setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	eval('xmlhttp_vue_elem'+xhr).send("id="+id+"&obj="+obj+"&col="+col);
}

function vue_fll(cbl,obj,src){
	var xhr = obj;
	if(document.getElementById(obj)){var id = document.getElementById(obj).value;}
	if(window.XMLHttpRequest){eval('xmlhttp_vue_fll'+xhr+'=new XMLHttpRequest()');}
	else{eval('xmlhttp_vue_fll'+xhr+'=new ActiveXObject("Microsoft.XMLHTTP")');}
	eval('xmlhttp_vue_fll'+xhr).onreadystatechange=function(){
		if(eval('xmlhttp_vue_fll'+xhr).readyState==4){
			if(eval('xmlhttp_vue_fll'+xhr).status==200){
				if(document.getElementById("lst_"+obj)){
					document.getElementById("lst_"+obj).innerHTML = eval('xmlhttp_vue_fll'+xhr).responseText;
					heightovery("lst_"+obj);
					//heightmrgtp(document.getElementById("lst_"+obj).parentNode.id);
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

function act_frm(cbl){
	var elem = document.getElementsByClassName(cbl);
	for(var i = 0; i < elem.length; i++) {vue_elem(elem[i].id,0);}
}

function dsp(cbl,id,id_dev_crc){
	if(window.XMLHttpRequest){xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load('OPE dsp');
	xmlhttp.onreadystatechange=function(){
		if(xmlhttp.readyState==4){
			if(xmlhttp.status==200){
				vue_elem('res_srv'+id,id);
				var elem = document.getElementsByClassName('frn_ope_frn'+xmlhttp.responseText);
				for(var i = 0; i < elem.length; i++) {vue_elem(elem[i].id,0);}
				vue_elem('cmd_srv'+id,id);
				window.parent.act_frm('crc_dev_srv'+id_dev_crc);
				window.parent.act_frm('frn_dev_frn'+xmlhttp.responseText);
				window.parent.act_frm('srv_dev_srv'+id);
				window.parent.act_frm('frn_ope');
				window.parent.act_frm('frn_dsp');
			}
			else if(xmlhttp.status==408){dsp(cbl,id,id_dev_crc);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR DSP "+xmlhttp.statusText+" </span>";}
			unload('OPE dsp');
		}
	}
	xmlhttp.open("POST","../fct/dsp.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("cbl="+cbl+"&id="+id);
}

function init(){ //a mettre dans accLoad
	$(window).scroll(function(){
		if(Math.round(($(window).scrollTop() + $(window).innerHeight() - $(document).height())/10)==0){vue_dt_res();}
	});
	unload('OPE init');
	$('input[type=number]').on('wheel', function(e){return false;});
}

function act_tab(){
	var cnf = document.getElementById('cnf').value;
	if(window.XMLHttpRequest){xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	xmlhttp.onreadystatechange=function(){
		if(xmlhttp.readyState==4){
			if(xmlhttp.status==200){
				window.parent.act_tab('ope/ctr.php?cnf='+cnf,xmlhttp.responseText);
				if($(document).height() == $(window).height()){vue_dt_res();}
				}
			else if(xmlhttp.status==408){act_tab();}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR ACT_TAB "+xmlhttp.statusText+" </span>";}
		}
	}
	xmlhttp.open("POST","nom_tab.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("cnf="+cnf);
}
