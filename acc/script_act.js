function maj_lng(val,id) {
	$.ajax({url: 'txt_js.xml', type: 'get', dataType: "xml",
		success: function(xmlDoc) {
			var x = xmlDoc.getElementsByTagName("maj_lng");
			var y = x[0].getElementsByTagName(id_lng);
			window.parent.box("?",y[0].childNodes[0].nodeValue,function() {maj('cfg_usr','lng',val,id);} );
		}
	});
}

function maj(tab,col,val,id,id_sup) {
	if(col == 'ty_mrq') {load('ACC maj ty_mrq');}
	$.ajax({url: 'maj.php', type: 'post', data: {"tab":tab,"col":col,"val":encodeURIComponent(val),"id":id,"id_sup":id_sup},
		success: function() {
			if(tab == 'cfg_crr') {
				if(col == 'taux' || col == 'tauxf') {vue_elem('crr',id,col);}
				else if(col == 'dcm') {vue_elem('crr',id,col);vue_elem('crr',id,'taux');vue_elem('crr',id,'tauxf');}
				else if(col == 'sup') {vue_acc('hom');}
			}
			else if(tab == 'grp_tsk') {
				if(col!='nom' && col!='commen') {vue_acc('tsk');}
				if(col!='commen') {window.parent.act_frm('tsk_grp');}
			}
			else if(tab == 'crm_ctc' && col=='dt_ctc') {vue_acc('crm');}
			else if(tab == 'crm_ech' && (col=='dt_ech' || col=='stat' || col=='dt_stat')) {vue_acc('crm');}
			else if(tab == 'cfg_ctg_clt') {
				if(col == 'ty_mrq') {vue_elem('cfg_ty_mrq'+id,id,col);}
				else if(col != 'nom') {vue_elem('ctg_clt',id,col);}
			}
			else if(tab == 'cfg_mrq') {
				vue_elem('mrq',id,col);
				if(col=='bs_min') {vue_elem('mrq',id,'bs_max');}
			}
			else if(tab== 'cfg_tsk' && col == 'ord') {vue_acc('cfg');}
			else if(tab == 'cfg_fin') {
				if(col == 'crr_cmp') {vue_elem('fin_crr_cmp1',id,col);}
				else{vue_elem('fin',id,col);}
				window.parent.act_frm('bln');
				window.parent.act_frm('trs');
			}
			else if(tab == 'cfg_usr') {
				if(col == 'lng') {parent.window.location.reload();}
				if(col == 'lgg') {vue_elem('cfg_lgg');}
			}
			else if(tab == 'fin_pst') {window.parent.act_frm('rsl');window.parent.act_frm('ecr');window.parent.act_frm('bln');}
			else if(tab == 'fin_css') {
				window.parent.act_frm('trs');window.parent.act_frm('ecr');window.parent.act_frm('bln');
				if(col == 'crr') {vue_elem('fin_crr_css'+id,id,col);}
			}
			else if(col=='css' || col=='rsl') {window.parent.act_frm('trs');} //indiquer tab(s)!
			else if(tab == 'dev_srv_pay' && col == 'fin') {$('#ajt_ecr_srv'+id).remove();}
			else if(tab == 'dev_hbr_pay' && col == 'fin') {$('#ajt_ecr_hbr'+id).remove();}
			if(col == 'ty_mrq') {unload('ACC maj ty_mrq');}
			else if(col=='nvtrf') {window.parent.act_frm('nvtrf');}
		},
		error: function (request, status, error) {
			maj(tab,col,val,id);
			$("#txtHint").html("<span style = 'background: red;'>ERROR</span>");console.log('SAVE ERROR: '+request.statusText);
		}
	});
}

/*function ajt(cbl,id_cat) {
	$.ajax({url: '../resources/xml/scriptTxt.xml', type: 'get', dataType: "xml",
		success: function(xmlDoc) {
			var x = xmlDoc.getElementsByTagName("ajt_"+cbl);
			var y = x[0].getElementsByTagName(id_lng);
			var nom = prompt(y[0].childNodes[0].nodeValue);
			var grp, clt, rgn, vll, ctg;
			if (nom == null || nom == '') {return;}
			if(cbl == 'dev' && id_cat == 0) {grp = $('#grp').val();}
			if((cbl == 'dev' && id_cat == 0) || cbl == 'grp') {clt = $('#clt').val();}
			if(cbl == 'mdl' || cbl == 'vll') {rgn = $('#rgn').val();}
			if(cbl == 'jrn' || cbl == 'srv' || cbl == 'hbr' || cbl == 'frn' || cbl == 'lieu') {vll = $('#vll').val();}
			if(cbl == 'prs' || cbl == 'srv' || cbl == 'hbr' || cbl == 'frn') {ctg = $('#ctg').val();}
			load('ACC ajt '+cbl);
			$.ajax({url: 'ajt.php', type: 'post', data: {"cbl":cbl,"id_cat":id_cat,"nom":encodeURIComponent(nom),"grp":grp,"clt":clt,"vll":vll,"ctg":ctg,"rgn":rgn},
				success: function(responseText) {
					var rsp = responseText.split("|");
					if(cbl == 'dev') {
						window.parent.act_frm('grp');
						window.parent.act_frm('clt');
						window.parent.opn_frm('dev/ctr.php?id='+rsp[0]);
						window.parent.act_frm('cat_dev');
						window.parent.act_frm('grp_crc');
						window.parent.act_frm('grp_clt');
						window.parent.act_frm('clt_crc');
						if(id_cat>0) {
							vue_menu(cbl,'dev');
							vue_lst(cbl);
						}
						else{vue_dev(cbl);}
					}
					else if(cbl == 'grp') {
						window.parent.opn_frm('grp/ctr.php?id='+rsp[0]);
						vue_grp('gr0',clt);
					}
					else{
						window.parent.opn_frm('cat/ctr.php?cbl='+cbl+'&id='+rsp[0]);
						vue_cat(cbl);
					}
					window.parent.act_frm(cbl);
					if(rsp[1] != '') {alt(rsp[1]);}
					if(rsp[2] != '') {alt(rsp[2]);}
					unload('ACC ajt '+cbl);
				},
				error: function (request, status, error) {
					ajt(cbl,id_cat);
					$("#txtHint").html("<span style = 'background: red;'>ERROR</span>");console.log('AJT ERROR: '+request.statusText);
				}
			});
		}
	});
}*/

function vrs(id) {
	$.ajax({url: '../resources/xml/scriptTxt.xml', type: 'get', dataType: "xml",
		success: function(xmlDoc) {
			var x = xmlDoc.getElementsByTagName("vrs");
			var y = x[0].getElementsByTagName(id_lng);
			window.parent.box("?",y[0].childNodes[0].nodeValue,function() {
				load('ACC vrs');
				$.ajax({url: '../fct/vrs.php', type: 'post', data: {"id_dev_crc":id},
					success: function(responseText) {
						window.parent.opn_frm('dev/ctr.php?id='+responseText);
						window.parent.act_frm('grp_crc');
						vue_dev('dev');
						unload('ACC vrs');
					},
					error: function (request, status, error) {
						vrs(id);
						$("#txtHint").html("<span style = 'background: red;'>ERROR</span>");console.log('VRS ERROR: '+request.statusText);
					}
				});
			});
		}
	});
}

function cop(cbl,id) {
	$.ajax({url: '../resources/xml/scriptTxt.xml', type: 'get', dataType: "xml",
		success: function(xmlDoc) {
			var x = xmlDoc.getElementsByTagName("cop_"+cbl);
			var y = x[0].getElementsByTagName(id_lng);
			if(cbl == 'dev') {var nom = prompt(y[0].childNodes[0].nodeValue);}
			else{var nom = prompt(y[0].childNodes[0].nodeValue,$('#nom_'+cbl+'_'+id).html()+"(1)");}
			if(nom == null || nom == '') {return;}
			load('ACC cop');
			$.ajax({url: '../fct/cop.php', type: 'post', data: {"cbl":cbl,"id":id,"nom":encodeURIComponent(nom)},
				success: function(responseText) {
					if(cbl == 'dev') {
						window.parent.opn_frm('dev/ctr.php?id='+responseText);
						vue_menu(cbl,'dev');
						vue_lst(cbl);
					}
					else{
						window.parent.opn_frm('cat/ctr.php?cbl='+cbl+'&id='+responseText);
						vue_cat(cbl);
						window.parent.act_frm(cbl);
						window.parent.act_frm('up_'+cbl);
					}
					unload('ACC cop');
				},
				error: function (request, status, error) {
					cop(cbl,id);
					$("#txtHint").html("<span style = 'background: red;'>ERROR</span>");console.log('COP ERROR: '+request.statusText);
				}
			});
		}
	});
}

function del(cbl,id) {
	$.ajax({url: '../resources/xml/scriptTxt.xml', type: 'get', dataType: "xml",
		success: function(xmlDoc) {
			var x = xmlDoc.getElementsByTagName("del_"+cbl);
			var y = x[0].getElementsByTagName(id_lng);
			window.parent.box("?",y[0].childNodes[0].nodeValue,function() {
				load('ACC del');
				$.ajax({url: '../fct/del.php', type: 'post', data: {"cbl":cbl,"id":id},
					success: function(responseText) {
						if(responseText.length == 0) {
							if(cbl == 'arc' || cbl == 'fin') {
								vue_lst(cbl);
								window.parent.sup_frm('dev_devid'+id);
								window.parent.sup_frm('trf_devid'+id);
								window.parent.sup_frm('prg_devid'+id);
								window.parent.sup_frm('rbk_devid'+id);
								window.parent.act_frm('grp');
								window.parent.act_frm('cat_dev');
								window.parent.act_frm('grp_crc');
								window.parent.act_frm('clt');
							}
							else if(cbl == 'grp') {
								vue_grp('gr0');
								window.parent.sup_frm('grpctrphpid'+id);
								window.parent.act_frm("grp_crc");
							}
							else{
								vue_cat(cbl);
								window.parent.sup_frm('catctrphpcbl'+cbl+'id'+id);
								window.parent.act_frm(cbl);
								window.parent.act_frm('up_'+cbl);
							}
						}
						else{alt(responseText);}
						unload('ACC del');
					},
					error: function (request, status, error) {
						unload('ACC del');
						del(cbl,id);
						$("#txtHint").html("<span style = 'background: red;'>ERROR</span>");console.log('DEL ERROR: '+request.statusText);
					}
				});
			});
		}
	});
}

function del_pls(cbl) {
	var chk = [],msg = '';
	$(".chk").each(function() {
		if($(this).is(":checked")) {chk.push($(this).attr("id"));}
	});
	if(chk.length == 0) {return;}
	$.ajax({url: '../resources/xml/scriptTxt.xml', type: 'get', dataType: "xml",
		success: function(xmlDoc) {
			var x = xmlDoc.getElementsByTagName("del_pls_"+cbl);
			var y = x[0].getElementsByTagName(id_lng);
			var x2 = xmlDoc.getElementsByTagName("del_pls_"+cbl+"2");
			var y2 = x2[0].getElementsByTagName(id_lng);
			window.parent.box("?",y[0].childNodes[0].nodeValue+chk.length+y2[0].childNodes[0].nodeValue,function() {
				load('ACC del_pls');
				$.ajax({url: 'del_pls.php', type: 'post', data: {"cbl":cbl,"ids":chk},
					success: function(responseText) {
						$.each(chk, function(key,id) {
							if(cbl=='arc') {
								window.parent.sup_frm('dev_devid'+id);
								window.parent.sup_frm('trf_devid'+id);
								window.parent.sup_frm('prg_devid'+id);
								window.parent.sup_frm('rbk_devid'+id);
							}
							else if(cbl=='grp') {window.parent.sup_frm('grpctrphpid'+id);}
						});
						if(cbl=='arc') {
							vue_lst(cbl);
							window.parent.act_frm('grp');
							window.parent.act_frm('cat_dev');
							window.parent.act_frm('grp_crc');
							window.parent.act_frm('clt');
						}
						else if(cbl=='grp') {
							vue_grp('gr0');
							window.parent.act_frm("grp_crc");
							if(responseText.length != 0) {alt(responseText);}
						}
						unload('ACC del_pls');
					},
					error: function (request, status, error) {
						unload('ACC del_pls');
						del_pls(cbl);
						$("#txtHint").html("<span style = 'background: red;'>ERROR</span>");console.log('DEL_PLS ERROR: '+request.statusText);
					}
				});
			});
		}
	});
}

function arch(cbl,id) {
	$.ajax({url: 'txt_js.xml', type: 'get', dataType: "xml",
		success: function(xmlDoc) {
			var x = xmlDoc.getElementsByTagName("arch_"+cbl);
			var y = x[0].getElementsByTagName(id_lng);
			window.parent.box("?",y[0].childNodes[0].nodeValue,function() {
				load('ACC arch');
				$.ajax({url: 'arch.php', type: 'post', data: {"id":id},
					success: function(responseText) {
						if(responseText) {
							var x = xmlDoc.getElementsByTagName("arch2_"+cbl);
							var y = x[0].getElementsByTagName(id_lng);
							alt(y[0].childNodes[0].nodeValue+responseText);
						}
						else{
							vue_lst(cbl);
							window.parent.sup_frm('dev_devid'+id);
							window.parent.sup_frm('trf_devid'+id);
							window.parent.sup_frm('prg_devid'+id);
							window.parent.sup_frm('rbk_devid'+id);
							window.parent.act_frm('cat_dev');
							window.parent.act_frm('grp');
							window.parent.act_frm('grp_crc');
							window.parent.act_frm('clt');
						}
						unload('ACC arch');
					},
					error: function (request, status, error) {
						unload('ACC arch');
						arch(cbl,id);
						$("#txtHint").html("<span style = 'background: red;'>ERROR</span>");console.log('ARCH ERROR: '+request.statusText);
					}
				});
			});
		}
	});
}

function arch_pls(cbl) {
	var chk = [],msg = '';
	$(".chk").each(function() {
		if($(this).is(":checked")) {chk.push($(this).attr("id"));}
	});
	if(chk.length == 0) {return;}
	$.ajax({url: 'txt_js.xml', type: 'get', dataType: "xml",
		success: function(xmlDoc) {
			var x = xmlDoc.getElementsByTagName("arch_pls_"+cbl);
			var y = x[0].getElementsByTagName(id_lng);
			var x2 = xmlDoc.getElementsByTagName("arch_pls_"+cbl+"2");
			var y2 = x2[0].getElementsByTagName(id_lng);
			window.parent.box("?",y[0].childNodes[0].nodeValue+chk.length+y2[0].childNodes[0].nodeValue,function() {
				load('ACC arch_pls');
				$.ajax({url: 'arch_pls.php', type: 'post', data: {"ids":chk},
					success: function(responseText) {
						vue_lst(cbl);
						$.each(chk, function(key,id) {
							window.parent.sup_frm('dev_devid'+id);
							window.parent.sup_frm('trf_devid'+id);
							window.parent.sup_frm('prg_devid'+id);
							window.parent.sup_frm('rbk_devid'+id);
						});
						window.parent.act_frm('cat_dev');
						window.parent.act_frm('grp');
						window.parent.act_frm('grp_crc');
						window.parent.act_frm('clt');
						if(responseText) {
							var x = xmlDoc.getElementsByTagName("arch2_"+cbl);
							var y = x[0].getElementsByTagName(id_lng);
							alt(y[0].childNodes[0].nodeValue+responseText);
						}
						unload('ACC arch_pls');
					},
					error: function (request, status, error) {
						unload('ACC arch_pls');
						arch_pls(cbl);
						$("#txtHint").html("<span style = 'background: red;'>ERROR</span>");console.log('ARCH_PLS ERROR: '+request.statusText);
					}
				});
			});
		}
	});
}

function annul(id) {
	$.ajax({url: 'txt_js.xml', type: 'get', dataType: "xml",
		success: function(xmlDoc) {
			var x = xmlDoc.getElementsByTagName("annuler");
			var y = x[0].getElementsByTagName(id_lng);
			window.parent.box("?",y[0].childNodes[0].nodeValue,function() {
				load('ACC annul');
				$.ajax({url: 'annul.php', type: 'post', data: {"id":id},
					success: function(responseText) {
						vue_lst('cnf');
						window.parent.sup_frm('dev_devid'+id);
						window.parent.act_frm('cat_dev');
						window.parent.act_frm('grp');
						window.parent.act_frm('grp_crc');
						window.parent.act_frm('clt');
						unload('ACC annul');
					},
					error: function (request, status, error) {
						annul(id);
						$("#txtHint").html("<span style = 'background: red;'>ERROR</span>");console.log('ANNUL ERROR: '+request.statusText);
					}
				});
			});
		}
	});
}

function rest(cbl,id) {
	load('ACC rest');
	$.ajax({url: 'rest.php', type: 'post', data: {"id":id},
		success: function(responseText) {
			$("#grp").val(0);
			vue_lst(cbl);
			window.parent.sup_frm('dev_devid'+id);
			window.parent.act_frm('cat_dev');
			window.parent.act_frm('grp');
			window.parent.act_frm('grp_crc');
			window.parent.act_frm('clt');
			unload('ACC rest');
		},
		error: function (request, status, error) {
			rest(cbl,id);
			$("#txtHint").html("<span style = 'background: red;'>ERROR</span>");console.log('REST ERROR: '+request.statusText);
		}
	});
}

function ajt_tsk() {
	$.ajax({url: 'ajt_tsk.php', type: 'post',
		success: function() {vue_acc('tsk');},
		error: function (request, status, error) {
			ajt_tsk();
			$("#txtHint").html("<span style = 'background: red;'>ERROR</span>");console.log('AJT_TSK ERROR: '+request.statusText);
		}
	});
}

function ajt_ecr(cbl,id) {
	$.ajax({url: 'ajt_ecr.php', type: 'post', data: {"cbl":cbl,"id":id},
		success: function() {
			$('#ajt_ecr_'+cbl+id).remove();
			window.parent.act_frm('ecr');
			window.parent.act_frm('fin_grp');
			window.parent.act_frm('bln');
		},
		error: function (request, status, error) {
			ajt_ecr(cbl,id);
			$("#txtHint").html("<span style = 'background: red;'>ERROR</span>");console.log('AJT_ECR ERROR: '+request.statusText);
		}
	});
}

function ajt_ctc() {
	$.ajax({url: '../fct/ajt_ctc.php', type: 'post',
		success: function() {vue_acc('crm');},
		error: function (request, status, error) {
			ajt_ctc();
			$("#txtHint").html("<span style = 'background: red;'>ERROR</span>");console.log('AJT_CTC ERROR: '+request.statusText);
		}
	});
}

function ajt_ech(id_ctc) {
	$.ajax({url: 'ajt_ech.php', type: 'post', data: {"id_ctc":id_ctc},
		success: function() {vue_acc('crm');},
		error: function (request, status, error) {
			ajt_ech(id_ctc);
			$("#txtHint").html("<span style = 'background: red;'>ERROR</span>");console.log('ajt_ech ERROR: '+request.statusText);
		}
	});
}

function ajt_cfg(obj,id) {
	$.ajax({url: 'ajt_cfg.php', type: 'post', data: {"obj":obj,"id":id},
		success: function() {
			if(obj == 'crr') {vue_acc('hom');}
			else{
				vue_acc('cfg');
				window.parent.act_frm('ecr');
				if(obj=='pst') {window.parent.act_frm('rsl');}
				else if(obj=='css') {window.parent.act_frm('trs');}
				window.parent.act_frm('bln');
			}
			window.parent.act_frm(obj);
		},
		error: function (request, status, error) {
			ajt_cfg(obj,id);
			$("#txtHint").html("<span style = 'background: red;'>ERROR</span>");console.log('AJT_CFG ERROR: '+request.statusText);
		}
	});
}

function ajt_mrq(id_ctg_clt) {
	$.ajax({url: 'ajt_mrq.php', type: 'post', data: {"id_ctg_clt":id_ctg_clt},
		success: function() {vue_acc('cfg');},
		error: function (request, status, error) {
			ajt_mrq(id_ctg_clt)
			$("#txtHint").html("<span style = 'background: red;'>ERROR</span>");console.log('AJT_MRQ ERROR: '+request.statusText);
		}
	});
}

function sup_tsk(id) {
	$.ajax({url: 'sup_tsk.php', type: 'post', data: {"id":id},
		success: function(responseText) {
			if(responseText.length>0) {alt(responseText);}
			else{
				vue_acc('tsk');
				window.parent.act_frm('tsk_grp');
			}
		},
		error: function (request, status, error) {
			sup_tsk(id);
			$("#txtHint").html("<span style = 'background: red;'>ERROR</span>");console.log('SUP_TSK ERROR: '+request.statusText);
		}
	});
}

function sup_cfg(obj,id) {
	$.ajax({url: 'sup_cfg.php', type: 'post', data: {"obj":obj,"id":id},
		success: function(responseText) {
			if(responseText.length>0) {alt(responseText);}
			else{
				if(obj == 'crr') {vue_acc('hom');}
				else{
					vue_acc('cfg');
					window.parent.act_frm('ecr');
					if(obj=='pst') {window.parent.act_frm('rsl');}
					else if(obj=='css') {window.parent.act_frm('trs');}
					window.parent.act_frm('bln');
				}
				window.parent.act_frm(obj);
			}
		},
		error: function (request, status, error) {
			sup_cfg(obj,id);
			$("#txtHint").html("<span style = 'background: red;'>ERROR</span>");console.log('SUP_CFG ERROR: '+request.statusText);
		}
	});
}

function sup_mrq(id) {
	$.ajax({url: 'sup_mrq.php', type: 'post', data: {"id":id},
		success: function(responseText) {vue_acc('cfg');},
		error: function (request, status, error) {
			sup_mrq(id);
			$("#txtHint").html("<span style = 'background: red;'>ERROR</span>");console.log('SUP_MRQ ERROR: '+request.statusText);
		}
	});
}

function sup_ctc(id) {
	$.ajax({url: 'sup_ctc.php', type: 'post', data: {"id":id},
		success: function(responseText) {vue_acc('crm');},
		error: function (request, status, error) {
			sup_ctc(id);
			$("#txtHint").html("<span style = 'background: red;'>ERROR</span>");console.log('SUP_ctc ERROR: '+request.statusText);
		}
	});
}

function sup_ech(id) {
	$.ajax({url: 'sup_ech.php', type: 'post', data: {"id":id},
		success: function(responseText) {vue_acc('crm');},
		error: function (request, status, error) {
			sup_ech(id);
			$("#txtHint").html("<span style = 'background: red;'>ERROR</span>");console.log('SUP_ech ERROR: '+request.statusText);
		}
	});
}

function up_img() {
	load('ACC up_img')
	var fileInput = document.querySelector('#file');
	var xhr = new XMLHttpRequest();
	xhr.open('POST','up_img.php');
    xhr.onload = function() {
		vue_cat('pic');
		window.parent.opn_frm('cat/ctr.php?cbl=pic&id='+xhr.responseText);
		unload('ACC up_img');
	};
	var form = new FormData();
  form.append('file',fileInput.files[0]);
	form.append('rgn',$('#rgn').val());
  xhr.send(form);
}

function act_frm(cbl) {
	$("."+cbl).each(function() {
		vue_elem($(this).attr("id"),0);
	});
}
/* old
function maj_xml(val) {
	load('ACC maj xml');
	$.ajax({url: 'maj_xml.php', type: 'post', data: {"val":val},
		success: function(responseText) {unload('ACC maj xml');},
		error: function (request, status, error) {
			maj_xml(val);
			$("#txtHint").html("<span style = 'background: red;'>ERROR</span>");console.log('MAJ_XML ERROR: '+request.statusText);
		}
	});
}
*/
