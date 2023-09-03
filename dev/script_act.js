var flg_maj = true, upd = 0;

function maj(tab,col,val,id,id_sup){
	if(flg_maj){upd++;console.log('upd '+upd);flg_maj = false;}
	if(id_sup>0){load('DEV maj');}
	eval('var xmlhttp_maj'+id+col+'=new XMLHttpRequest()');
	eval('xmlhttp_maj'+id+col).addEventListener("load",()=>{
		if(eval('xmlhttp_maj'+id+col).status==200){
			if(tab=='grp_dev' && col=='id_clt'){window.parent.act_frm('grp_clt');vue_elem('crc_ty_mrq',id,col);vue_elem('crc',id,'com');vue_elem('crc',id,'mrq_hbr');vue_elem('crc',id,'frs');vue_elem('crc_crr',id,col);vue_elem('clt_crc',id,col);act_acc();vue_crc('trf');sel_mdl('trf_mdl');sel_mdl('dt_jrn',0,0);}
			else if(tab=='dev_crc'){
				if(col=='groupe'){act_tab();act_acc();window.parent.act_frm('grp_crc');}
				else if(col=='version'){act_tab();act_acc();vue_elem('crc',id,col);window.parent.act_frm('grp_crc');}
				else if(col=='titre'){act_acc();}
				else if(col=='id_grp'){window.parent.act_frm('grp_crc');window.parent.act_frm('grp_clt');window.parent.act_frm('clt_crc');vue_elem('crc_ty_mrq',id,col);vue_elem('crc_com',id);vue_elem('crc_mrq_hbr',id);/*vue_elem('crc',id,'com');*/vue_elem('crc',id,'frs');vue_elem('crc_crr',id,col);vue_elem('crc_grp',id,col);vue_elem('clt_crc',id,col);act_acc();vue_crc('trf');sel_mdl('trf_mdl');}
				else if(col=='lgg'){vue_elem('crc_lgg',id,col);prevUpdateText('crc',id);}
				else if(col=='ty_mrq'){vue_elem('crc_ty_mrq',id);vue_elem('crc_com',id);vue_elem('crc_mrq_hbr',id);sel_mdl('trf_mdl');sel_mdl('dt_prs');}
				else if(col=='com' || col=='mrq_hbr' || col=='frs'){vue_elem('crc',id,col);sel_mdl('dt_prs');}
				else if(col=='crr'){vue_elem('crc_crr',id,col);sel_mdl('dt_prs');}
				else if(col=='vue_sgl' || col=='vue_dbl' || col=='vue_tpl' || col=='vue_qdp' || col=='psg'){vue_crc('trf');sel_mdl('dt_prs');vue_crc('res');}
				else if(col=='ptl'){vue_crc('trf');prevUpdateRates('crc',id);sel_mdl('dt_prs');vue_crc('res');}
				else if(col=='sgl' || col=='dbl_mat' || col=='dbl_twn' || col=='tpl_mat' || col=='tpl_twn' || col=='qdp'){vue_elem('crc',id,col);vue_elem('crc_err_rmn',id_dev_crc);vue_crc('res');sel_mdl('dt_prs');window.parent.act_frm('crc_res_hbr'+id_dev_crc);window.parent.act_frm('hbr_ope');}
			}
			else if(tab=='dev_crc_bss'){
				if(col=='vue'){vue_crc('pax');vue_crc('res');vue_crc('trf');sel_mdl('dt_prs');window.parent.act_frm('crc_res_srv'+id_dev_crc);window.parent.act_frm('frn_ope');}
				else if(col=='mrq'){vue_elem('crc_bss',id,col);sel_mdl('dt_prs');}
			}
			else if(tab=='dev_crc_rmn_pax' && col=='room'){vue_elem('crc_pax_room'+id,id);}
			else if(tab=='dev_mdl'){
				if(col=='titre'){vue_elem('mdl',id,col);}
				else if(col=='trf'){
					if(val==0){
						sel_jrn('dt_prs',id);$('#vue_rmn_mdl_'+id).next('br').remove();
						document.getElementById('vue_rmn_mdl_'+id).remove();
					}
					else{
						var span = document.createElement('span');
						span.id = "vue_rmn_mdl_"+id;
						var dsc_rmn_dt_end_mdl = document.getElementById("vue_dsc_rmn_dt_end_mdl_"+id);
						if(dsc_rmn_dt_end_mdl.insertBefore(span,document.getElementById("vue_dt_mdl_"+id))){vue_mdl('rmn',id);}
						dsc_rmn_dt_end_mdl.insertBefore(document.createElement("br"),document.getElementById("vue_dt_mdl_"+id));
					}
					vue_mdl('ttr',id);vue_mdl('trf',id);//vue_mdl('pax',id);
				}
				else if(col=='vue_sgl' || col=='vue_dbl' || col=='vue_tpl' || col=='vue_qdp' || col=='psg'){vue_mdl('trf',id);sel_jrn('dt_prs',id);vue_crc('res');}
				else if(col=='ptl'){vue_mdl('trf',id);prevUpdateRates('mdl',id);sel_jrn('dt_prs',id);vue_crc('res');}
				else if(col=='col'){vue_mdl('ttr',id);vue_mdl('dsc',id);sel_jrn('ttr_jrn',id);sel_jrn('dsc_jrn',id);}
				else if(col=='com' || col=='mrq_hbr'){vue_elem('mdl',id,col);sel_mdl('dt_prs');}
				else if(col=='sgl' || col=='dbl_mat' || col=='dbl_twn' || col=='tpl_mat' || col=='tpl_twn' || col=='qdp'){vue_elem('mdl',id,col);vue_elem('mdl_err_rmn'+id,id);vue_crc('res');sel_jrn('dt_prs',id);window.parent.act_frm('mdl_res_hbr'+id);window.parent.act_frm('hbr_ope');}
			}
			else if(tab=='dev_mdl_bss'){
				if(col=='vue'){vue_mdl('pax',id_sup);vue_crc('res');vue_mdl('trf',id_sup);sel_jrn('dt_prs',id_sup);window.parent.act_frm('mdl_res_srv'+id_sup);window.parent.act_frm('frn_ope');}
				else if(col=='mrq'){vue_elem('mdl_bss',id,col);sel_mdl('dt_prs');}
			}
			else if(tab=='dev_mdl_rmn_pax' && col=='room'){vue_elem('mdl_pax_room'+id,id);}
			else if(tab=='dev_jrn'){
				if(col=='titre'){vue_elem('jrn',id,col);}
				else if(col=='opt'){vue_mdl('dt',id_sup);vue_crc('res');}
				else if(col=='id_pic'){vue_jrn('dsc',id);}
			}
			else if(tab=='dev_prs'){
				if(col=='titre'){vue_elem('prs',id,col);}
				else if(col=='ctg'){vue_elem('prs_ctg_prs'+id,id);vue_prs('end',id);}
				else if(col=='opt'){vue_jrn('dt',id_sup);vue_crc('res');}
				else if(col=='res'){
					if(val==1){anl_opt(id);}
					vue_elem('prs_res'+id,id);vue_prs('dt',id);vue_crc('res');
				}
				else if(col=='id_rmn'){vue_elem('prs_rmn'+id,id);}
				else if((col=='info' || col=='heure') && eval('xmlhttp_maj'+id+col).responseText!=1){
					var x=document.getElementsByClassName("prs_dev_srv"+id);for(i=0;i<x.length;i++){vue_elem(x[i].id,x[i].id.substr(7));}
					var y=document.getElementsByClassName("prs_dev_hbr"+id);for(i=0;i<y.length;i++){vue_elem(y[i].id,y[i].id.substr(7));}
					if(x.length>0 || y.length>0){vue_crc('res');}
					window.parent.act_frm('prs_res_hbr'+id);
					window.parent.act_frm('prs_res_srv'+id);
					window.parent.act_frm('hbr_ope');
					window.parent.act_frm('frn_ope');
				}
			}
			else if(tab=='dev_srv'){
				if(col=='id_vll'){vue_elem('srv_vll'+id,id);vue_elem('srv_frn'+id,id);vue_crc('res');}
				else if(col=='ctg'){vue_elem('srv_ctg'+id,id);vue_elem('srv_frn'+id,id);vue_crc('res');}
				else if(col=='crr'){vue_elem('srv_crr'+id,id);vue_crc('res');}
				else if(col=='id_frn'){
					vue_elem('srv_frn'+id,id);
					vue_elem('srv_res'+id,id);
					vue_crc('res');
					window.parent.act_frm('srv_res_frn'+id);
					window.parent.act_frm('srv_res_srv'+id);
					window.parent.act_frm('frn_ope');
				}
				else if(col=='res'){
					if(val=='-1'){dsp('srv',id);}
					vue_elem('srv_res'+id,id);
					vue_elem('srv_frn'+id,id);
					window.parent.act_frm('srv_res_frn'+id);
					window.parent.act_frm('srv_res_srv'+id);
				}
				else if(col=='dt_min' || col=='dt_max'){vue_prs('dt',id_sup);}
				else if(col=='frs'){vue_elem('srv',id,col);vue_crc('res');}
			}
			else if(tab=='dev_srv_trf'){
				if(col=='trf_rck' || col=='trf_net'){vue_elem('srv_trf',id,col);vue_crc('res');}
				else if(col=='est'){vue_prs('dt',id_sup);}
			}
			else if(tab=='dev_srv_pay'){vue_crc('res');window.parent.act_frm('srv_pay');
				if(col=='crr'){vue_elem('srv_pay_crr'+id,id);}
				else if(col=='pay'){vue_elem('srv_pay_pay'+id_sup,id_sup);}
				else{vue_elem('srv_pay',id,col);}
			}
			else if(tab=='dev_hbr'){
				if(col=='db_rck_chm' || col=='db_rck_rgm' || col=='db_net_chm' || col=='db_net_rgm' || col=='sg_rck_chm' || col=='sg_rck_rgm' || col=='sg_net_chm' || col=='sg_net_rgm' || col=='tp_rck_chm' || col=='tp_rck_rgm' || col=='tp_net_chm' || col=='tp_net_rgm' || col=='qd_rck_chm' || col=='qd_rck_rgm' || col=='qd_net_chm' || col=='qd_net_rgm'){vue_elem('hbr',id,col);vue_crc('res');}
				else if(col=='id_vll'){vue_elem('hbr_vll'+id,id);vue_crc('res');}
				else if(col=='rgm'){vue_elem('hbr_rgm'+id,id);vue_crc('res');}
				else if(col=='crr_chm'){vue_elem('chm_crr'+id,id);vue_crc('res');}
				else if(col=='crr_rgm'){vue_elem('rgm_crr'+id,id);vue_crc('res');}
				else if(col=='res'){vue_elem('hbr_res'+id,id);vue_crc('res');window.parent.act_frm('dev_res_hbr'+id);window.parent.act_frm('hbr_ope');}
				else if(col=='dt_min_chm' || col=='dt_max_chm' || col=='dt_min_rgm' || col=='dt_max_rgm'){vue_prs('dt',id_sup);}
				else if(col=='sel'){vue_prs('dt',id_sup);window.parent.act_frm('dev_res_hbr'+id);window.parent.act_frm('hbr_ope');vue_crc('res');}
				else if(id_sup>0){vue_prs('dt',id_sup);vue_crc('res');}
				else if(col=='frs'){vue_elem('hbr',id,col);vue_crc('res');}
			}
			else if(tab=='dev_hbr_pay'){vue_crc('res');window.parent.act_frm('hbr_pay');
				if(col=='crr'){vue_elem('hbr_pay_crr'+id,id);}
				else if(col=='pay'){vue_elem('hbr_pay_pay'+id_sup,id_sup);}
				else{vue_elem('hbr_pay',id,col);}
			}
			if(document.getElementById("txtHint").innerHTML.includes("SAVE ERROR")){document.getElementById("txtHint").innerHTML="";}
		}
		else if(eval('xmlhttp_maj'+id+col).status==408){maj(tab,col,val,id,id_sup);}
		else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>SAVE ERROR</span>";console.log('MAJ ERROR: '+eval('xmlhttp_maj'+id+col).statusText);}
		if(!flg_maj){upd--;console.log('upd '+upd);flg_maj = true;}
		if(id_sup>0){unload('DEV maj');}
	})
	eval('xmlhttp_maj'+id+col).open("POST","maj.php",true);
	eval('xmlhttp_maj'+id+col).setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	eval('xmlhttp_maj'+id+col).send("tab="+tab+"&col="+col+"&val="+encodeURIComponent(val)+"&id="+id+"&id_sup="+id_sup);
}

function est(cbl,val,id,id_dev_prs){
	if(window.XMLHttpRequest){xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load('DEV est');
	xmlhttp.onreadystatechange=function(){
		if(xmlhttp.readyState==4){
			if(xmlhttp.status==200){vue_prs('dt',id_dev_prs);}
			else if(xmlhttp.status==408){est(cbl,val,id,id_dev_prs);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR EST "+xmlhttp.statusText+" </span>";}
			unload('DEV est');
		}
	}
	xmlhttp.open("POST","est.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("cbl="+cbl+"&val="+val+"&id="+id);
}

function dsp(cbl,id){
	if(window.XMLHttpRequest){xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load('DEV dsp');
	xmlhttp.onreadystatechange=function(){
		if(xmlhttp.readyState==4){
			if(xmlhttp.status==200){
				vue_elem('srv_res'+id,id);
				var elem = document.getElementsByClassName('frn_dev_frn'+xmlhttp.responseText);
				for(var i = 0; i < elem.length; i++) {vue_elem(elem[i].id,0);}
				vue_crc('res');
				window.parent.act_frm('frn_ope_frn'+xmlhttp.responseText);
				window.parent.act_frm('srv_res_srv'+id);
				window.parent.act_frm('frn_ope');
				window.parent.act_frm('frn_dsp');
				}
			else if(xmlhttp.status==408){dsp(cbl,id);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR DSP "+xmlhttp.statusText+" </span>";}
			unload('DEV dsp');
		}
	}
	xmlhttp.open("POST","../fct/dsp.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("cbl="+cbl+"&id="+id);
}

function anl_opt(id_prs){
	$.ajax({url: 'anl_opt.php', type: 'post', data: {"id_prs":id_prs},
		success: function(responseText){
			if(responseText > 0){
				vue_elem('prs_res'+responseText,responseText);
				vue_prs('dt',responseText);
				vue_crc('res');
			}
		},
		error: function (request, status, error){
			anl_opt(id_prs);
			$("#txtHint").html("<span style = 'background: red;'>ANL_OPT ERROR</span>");console.log('ANL_OPT ERROR: '+request.statusText);
		}
	});
}

function init(){//à mettre dans devLoad.js
	flg_rch = true;
	act_tab();
	$('.rich').css('pointer-events','auto');
	$('input[type=number]').on('wheel', function(e){return false;});
	unload('DEV');
}

function act_tab(){
	upd++;
	if(window.XMLHttpRequest){xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	xmlhttp.onreadystatechange=function(){
		if(xmlhttp.readyState==4){
			if(xmlhttp.status==200){
				window.parent.act_tab('dev/ctr.php?id='+id_dev_crc,xmlhttp.responseText);
				upd--;
ajt_cat_mdl(id_dev_crc); //ajt_cat_mdl a deplacer au moment d'ajouter ou supprimer des journees : $id_dev_crc->$id_dev_mdl.
			}
			else if(xmlhttp.status==408){act_tab();upd--;}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR ACT_TAB "+xmlhttp.statusText+" </span>";upd--;}
		}
	}
	xmlhttp.open("POST","nom_tab.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("id_dev_crc="+id_dev_crc);
}

function act_frm(cbl){
	var elem = document.getElementsByClassName(cbl);
	if(elem.length > 0 && (cbl.substr(0,11)=='cat_dev_hbr' || cbl.substr(0,11)=='frn_dev_srv')){vue_crc('res');}
	for(var i = 0; i < elem.length; i++) {vue_elem(elem[i].id,id_dev_crc);}
	var elem2 = document.getElementsByClassName(cbl+'_fll');
	for(var i = 0; i < elem2.length; i++) {
		var str = elem2[i].onkeyup.toString().substring(35);
		str = 'vue_fll('+str.substring(0,str.length - 20)+'"'+elem2[i].value.toString()+'")';
		eval(str);
	}
}

function act_acc(){
	if(cnf==0){var cbl= 'dev';}
	else if(cnf==1){var cbl= 'cnf';}
	else if(cnf==2){var cbl= 'fin';}
	else if(cnf==-1){var cbl= 'arc';}
	var cbl_lst = parent.window.frames[0].document.getElementById('cbl').value;
	if(cbl_lst == 'acc' || cbl_lst == 'pay' || cbl_lst == cbl){parent.window.frames[0].vue_lst(cbl_lst);}
}
