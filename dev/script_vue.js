function vue_crc(cbl) {
	if(cbl=='res') {
		if($("#chk_res").is(':checked') || $("#chk_res").length==0) {var res_vue=1;}
		else{var res_vue=0;}
	}
	else if(cbl=='rmn' || cbl=='pax') {
		if($("#chk_pax_crc").is(':checked')) {var pax_vue=1;}
		else{var pax_vue=0;}
	}
	else if(cbl=='dt') {
		var mdl_vue = '';
		var vuemdl = document.getElementsByClassName("vue_mdl");
		for(var i = 0; i < vuemdl.length; i++) {
			if(vuemdl[i].checked) {mdl_vue += vuemdl[i].id+'|';}
		}
		var jrn_vue = '';
		var vuejrn = document.getElementsByClassName("vue_jrn");
		for(var i = 0; i < vuejrn.length; i++) {
			if(vuejrn[i].checked) {jrn_vue += vuejrn[i].id+'|';}
		}
	}
	if(window.XMLHttpRequest) {var result=eval('xmlhttp_crc'+cbl+'=new XMLHttpRequest()');}
	else{var result=eval('xmlhttp_crc'+cbl+'=new ActiveXObject("Microsoft.XMLHTTP")');}
	load('DEV vue_'+cbl+'_crc');
	eval('xmlhttp_crc'+cbl).onreadystatechange=function() {
		if(eval('xmlhttp_crc'+cbl).readyState==4) {
			if(eval('xmlhttp_crc'+cbl).status==200) {document.getElementById("vue_"+cbl+"_crc").innerHTML=eval('xmlhttp_crc'+cbl).responseText;}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR vue_"+cbl+"_crc "+eval('xmlhttp_crc'+cbl).statusText+" </span>";}
			unload('DEV vue_'+cbl+'_crc');
		}
	}
	eval('xmlhttp_crc'+cbl).open("POST","vue_"+cbl+"_crc.php",true);
	eval('xmlhttp_crc'+cbl).setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	eval('xmlhttp_crc'+cbl).send("id_dev_crc="+id_dev_crc+"&mdl_vue="+mdl_vue+"&jrn_vue="+jrn_vue+"&res_vue="+res_vue+"&pax_vue="+pax_vue+"&cnf="+cnf);
}

function chk_res() {
	if($("#chk_res").is(':checked')) {
		load('DEV chk_res');
		$.when($.ajax({url:'vue_res_crc.php',type:'POST',data:{id_dev_crc:id_dev_crc,res_vue:1,cnf:cnf}})).then(function(a1) {
			document.getElementById("vue_res_crc").innerHTML = a1;
			$("#vue_res_crc").stop(true,true).slideDown();
			unload('DEV chk_res');
		});
	}
	else{$("#vue_res_crc").stop(true,true).slideUp();}
}

function chk_pax(id) {
	if(id=='') {
		var cbl = 'crc';
		var uid = id_dev_crc;
	}
	else{
		var cbl='mdl';
		var uid = id;
		id = '_'+id;
	}
	if($("#chk_pax_"+cbl+id).is(':checked')) {
		load('DEV chk_pax_'+cbl+id);
		$.when($.ajax({url:'vue_pax_'+cbl+'.php',type:'POST',data:{id:uid,pax_vue:1,cnf:cnf}})).then(function(a1) {
			$("#vue_pax_"+cbl+id).html(a1);
			$("#vue_pax_"+cbl+id).stop(true,true).slideDown();
			$('input[type=number]').on('wheel', function(e) {return false;});
			unload('DEV chk_pax_'+cbl+id);
		});
	}
	else{$("#vue_pax_"+cbl+id).stop(true,true).slideUp();}
}

function sel_mdl(cbl,id_ref_mdl,vue_jrn) {
	if(window.XMLHttpRequest) {eval('xmlhttp_sel_mdl'+cbl+'=new XMLHttpRequest()');}
	else{eval('xmlhttp_sel_mdl'+cbl+'=new ActiveXObject("Microsoft.XMLHTTP")');}
	load('DEV sel_mdl');
	eval('xmlhttp_sel_mdl'+cbl).onreadystatechange=function() {
		if(eval('xmlhttp_sel_mdl'+cbl).readyState==4) {
			if(eval('xmlhttp_sel_mdl'+cbl).status==200) {
				if(eval('xmlhttp_sel_mdl'+cbl).responseText != 0) {
					eval('var arr_mdl'+cbl+'=xmlhttp_sel_mdl'+cbl+'.responseText.split("|")');
					for(var i= 0; i < eval('arr_mdl'+cbl+'.length'); i++) {
						if(cbl=='ttr_mdl' || cbl=='ttr_mdl_apr' || cbl=='ttr_mdl_avt') {vue_mdl('ttr',eval('arr_mdl'+cbl+'[i]'));}
						else if(cbl=='trf_mdl') {vue_mdl('trf',eval('arr_mdl'+cbl+'[i]'));}
						else if(cbl=='dsc_mdl') {vue_mdl('dsc',eval('arr_mdl'+cbl+'[i]'));}
						else if(cbl=='dt_mdl' || cbl=='dt_mdl_apr' || cbl=='dt_mdl_avt') {vue_mdl('dt',eval('arr_mdl'+cbl+'[i]'));}
						else if(cbl=='end_mdl' || cbl=='end_mdl_apr') {vue_mdl('end',eval('arr_mdl'+cbl+'[i]'));}
						else if(cbl=='end_mdl_avt') {vue_mdl('end',eval('arr_mdl'+cbl+'[i]'));sel_jrn('ttr_jrn_avt2',eval('arr_mdl'+cbl+'[i]'));}
						else if(cbl=='vue_mdl_true') {
							if(!$("#chk_mdl"+eval('arr_mdl'+cbl+'[i]')).is(':checked')) {$("#chk_mdl"+eval('arr_mdl'+cbl+'[i]')).prop('checked',true);chk_mdl(eval('arr_mdl'+cbl+'[i]'));}
						}
						else if(cbl=='vue_mdl_false') {
							if($("#chk_mdl"+eval('arr_mdl'+cbl+'[i]')).is(':checked')) {$("#chk_mdl"+eval('arr_mdl'+cbl+'[i]')).prop('checked',false);chk_mdl(eval('arr_mdl'+cbl+'[i]'));}
						}
						else{sel_jrn(cbl,eval('arr_mdl'+cbl+'[i]'),0,vue_jrn);}
					}
				}
			}
			else if(eval('xmlhttp_sel_mdl'+cbl).status==408) {sel_mdl(cbl,id_ref_mdl,vue_jrn);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR SEL_MDL "+eval('xmlhttp_sel_mdl'+cbl).statusText+" </span>";}
			unload('DEV sel_mdl');
		}
	}
	eval('xmlhttp_sel_mdl'+cbl).open("POST","sel_mdl.php",true);
	eval('xmlhttp_sel_mdl'+cbl).setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	eval('xmlhttp_sel_mdl'+cbl).send("id_dev_crc="+id_dev_crc+"&cbl="+cbl+"&id_ref_mdl="+id_ref_mdl);
}

function chk_mdl(id_dev_mdl) {
	load('DEV chk_mdl');
	var jrn_vue = '',vuejrn = document.getElementsByClassName("vue_jrn");
	for (var i = 0; i < vuejrn.length; i++) {
		if(vuejrn[i].checked) {jrn_vue += vuejrn[i].id+'|';}
	}
	if($("#chk_mdl"+id_dev_mdl).is(':checked')) {
		$.when(
			$.ajax({url:'vue_dsc_mdl.php',type:'POST',data:{id_dev_mdl:id_dev_mdl,id_dev_crc:id_dev_crc,cnf:cnf}}),
			$.ajax({url:'vue_dt_mdl.php',type:'POST',data:{id_dev_mdl:id_dev_mdl,vue:1,jrn_vue:jrn_vue,id_dev_crc:id_dev_crc,cnf:cnf}}),
			$.ajax({url:'vue_end_mdl.php',type:'POST',data:{id_dev_mdl:id_dev_mdl,vue:1,id_dev_crc:id_dev_crc,cnf:cnf}}),
		).then(function(a1,a2,a3) {
			document.getElementById("vue_dsc_mdl_"+id_dev_mdl).innerHTML = a1[0];
			document.getElementById("vue_dt_mdl_"+id_dev_mdl).innerHTML = a2[0];
			document.getElementById("vue_end_mdl_"+id_dev_mdl).innerHTML = a3[0];
			$("#vue_dsc_rmn_dt_end_mdl_"+id_dev_mdl).hide();
			$("#vue_dsc_rmn_dt_end_mdl_"+id_dev_mdl).stop(true,true).slideDown();
			$('input[type=number]').on('wheel', function(e) {return false;});
		});
		$("#vue_dt_mdl_"+id_dev_mdl).removeClass();
		unload('DEV chk_mdl');
	}
	else{
		$("#vue_dsc_rmn_dt_end_mdl_"+id_dev_mdl).stop(true,true).slideUp();
		$.when(
			$.ajax({url:'vue_dt_mdl.php',type:'POST',data:{id_dev_mdl:id_dev_mdl,vue:0,jrn_vue:jrn_vue,id_dev_crc:id_dev_crc,cnf:cnf}}),
			$.ajax({url:'vue_end_mdl.php',type:'POST',data:{id_dev_mdl:id_dev_mdl,vue:0,id_dev_crc:id_dev_crc,cnf:cnf}}),
		).then(function(a1,a2) {
			document.getElementById("vue_dsc_mdl_"+id_dev_mdl).innerHTML = '';
			document.getElementById("vue_dt_mdl_"+id_dev_mdl).innerHTML = a1[0];
			document.getElementById("vue_end_mdl_"+id_dev_mdl).innerHTML = a2[0];
			$("#vue_dsc_rmn_dt_end_mdl_"+id_dev_mdl).stop(true,true).slideDown();
		});
		$("#vue_dt_mdl_"+id_dev_mdl).addClass('cat_jrn');
		unload('DEV chk_mdl');
	}

}

function vue_mdl(cbl,id_dev_mdl,id_dev_jrn) {
	if($("#chk_mdl"+id_dev_mdl).is(':checked') || $("#chk_mdl"+id_dev_mdl).length==0) {var vue=1;}
	else{var vue=0;}
	if(cbl=='rmn' || cbl=='pax') {
		if($("#chk_pax_mdl_"+id_dev_mdl).is(':checked')) {var pax_vue=1;}
		else{var pax_vue=0;}
	}
	else if(cbl=='dt') {
		var jrn_vue = '',vuejrn = document.getElementsByClassName("vue_jrn");
		for (var i = 0; i < vuejrn.length; i++) {
			if(vuejrn[i].checked) {jrn_vue += vuejrn[i].id+'|';}
		}
	}
	if(window.XMLHttpRequest) {eval('xmlhttp_'+cbl+'_mdl'+id_dev_mdl+'=new XMLHttpRequest()');}
	else{eval('xmlhttp_'+cbl+'_mdl'+id_dev_mdl+'=new ActiveXObject("Microsoft.XMLHTTP")');}
	if(vue==0 && cbl=='dsc') {
		if(document.getElementById("vue_dsc_mdl_"+id_dev_mdl)) {document.getElementById("vue_dsc_mdl_"+id_dev_mdl).innerHTML="";}
		return;
	}
	if(!(id_dev_jrn>0)) {load('DEV vue_'+cbl+'_mdl');}
	eval('xmlhttp_'+cbl+'_mdl'+id_dev_mdl).onreadystatechange=function() {
		if(eval('typeof xmlhttp_'+cbl+'_mdl'+id_dev_mdl) !== 'undefined' && eval('xmlhttp_'+cbl+'_mdl'+id_dev_mdl).readyState==4) {
			if(eval('xmlhttp_'+cbl+'_mdl'+id_dev_mdl).status==200) {
				if(document.getElementById("vue_"+cbl+"_mdl_"+id_dev_mdl)) {
					document.getElementById("vue_"+cbl+"_mdl_"+id_dev_mdl).innerHTML=eval('xmlhttp_'+cbl+'_mdl'+id_dev_mdl).responseText;$('input[type=number]').on('wheel', function(e) {return false;});}
				if(cbl=='dt' && id_dev_jrn>0) {//scroll depuis vue_res
					if(!$("#chk_jrn"+id_dev_jrn).is(':checked')) {$("#chk_jrn"+id_dev_jrn).prop('checked',true);vue_jrn('dsc',id_dev_jrn,1);vue_jrn('dt',id_dev_jrn,1);vue_jrn('end',id_dev_jrn,1);}
					$('html,body').animate({scrollTop: $("#vue_ttr_jrn_"+id_dev_jrn).offset().top-10},'slow');console.log('vue_mdl');
				}
			}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR vue_"+cbl+"_mdl "+eval('xmlhttp_'+cbl+'_mdl'+id_dev_mdl).statusText+" </span>";}
			if(!(id_dev_jrn>0)) {unload('DEV vue_'+cbl+'_mdl');}
		}
	}
	eval('xmlhttp_'+cbl+'_mdl'+id_dev_mdl).open("POST","vue_"+cbl+"_mdl.php",true);
	eval('xmlhttp_'+cbl+'_mdl'+id_dev_mdl).setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	eval('xmlhttp_'+cbl+'_mdl'+id_dev_mdl).send("id_dev_mdl="+id_dev_mdl+"&vue="+vue+"&jrn_vue="+jrn_vue+"&id_dev_crc="+id_dev_crc+"&cnf="+cnf+"&pax_vue="+pax_vue);
}

function sel_jrn(cbl,id_dev_mdl,id_ref_jrn,vue) {
	if($("#chk_mdl"+id_dev_mdl).is(':checked')) {
		if(window.XMLHttpRequest) {eval('xmlhttp_sel_jrn'+id_dev_mdl+cbl+'=new XMLHttpRequest()');}
		else{eval('xmlhttp_sel_jrn'+id_dev_mdl+cbl+'=new ActiveXObject("Microsoft.XMLHTTP")');}
		load('DEV sel_jrn_'+id_dev_mdl);
		eval('xmlhttp_sel_jrn'+id_dev_mdl+cbl).onreadystatechange=function() {
			if(eval('xmlhttp_sel_jrn'+id_dev_mdl+cbl).readyState==4) {
				if(eval('xmlhttp_sel_jrn'+id_dev_mdl+cbl).status==200) {
					if(eval('xmlhttp_sel_jrn'+id_dev_mdl+cbl).responseText != 0) {
						eval('var arr_jrn'+id_dev_mdl+cbl+'=xmlhttp_sel_jrn'+id_dev_mdl+cbl+'.responseText.split("|")');
						for(var i= 0; i < eval('arr_jrn'+id_dev_mdl+cbl+'.length'); i++) {
							if(cbl=='ttr_jrn' || cbl=='ttr_jrn_avt1' || cbl=='ttr_jrn_avt2' || cbl=='ttr_jrn_lst') {vue_jrn('ttr',eval('arr_jrn'+id_dev_mdl+cbl+'[i]'));}
							else if(cbl=='dt_jrn' || cbl=='dt_jrn_avt1' || cbl=='dt_jrn_apr1') {
							  if(typeof vue == 'undefined' ^ !$("#chk_jrn"+eval('arr_jrn'+id_dev_mdl+cbl+'[i]')).is(':checked')) {vue_jrn('dt',eval('arr_jrn'+id_dev_mdl+cbl+'[i]'));}
							}
							else if(cbl=='dsc_jrn') {vue_jrn('dsc',eval('arr_jrn'+id_dev_mdl+cbl+'[i]'));}
							else if(cbl=='end_jrn' || cbl=='end_jrn_avt1' || cbl=='end_jrn_apr1') {vue_jrn('end',eval('arr_jrn'+id_dev_mdl+cbl+'[i]'));}
							else if(cbl=='ttr_jrn_apr' || cbl=='ttr_jrn_apr1') {
								vue_jrn('ttr',eval('arr_jrn'+id_dev_mdl+cbl+'[i]'));
								if($('#div_jrn'+eval('arr_jrn'+id_dev_mdl+cbl+'[i]')).next().hasClass('ajt_jrn_opt')) {
									$('#div_jrn'+eval('arr_jrn'+id_dev_mdl+cbl+'[i]')).next().stop(true,true).slideUp();
									ajt_jrn_jrn_opt(eval('arr_jrn'+id_dev_mdl+cbl+'[i]'));
								}
								var cl0 = $('#div_jrn'+eval('arr_jrn'+id_dev_mdl+cbl+'[i]')).attr('class');
								if(typeof cl0 != 'undefined') {
									var id0 = cl0.split('_');
									var id1 = id0[2]-1;
									var cl1 = id0[0]+'_'+id0[1]+'_'+id1;
									$('#div_jrn'+eval('arr_jrn'+id_dev_mdl+cbl+'[i]')).removeClass(cl0).addClass(cl1);
								}
							}
							else if(cbl=='opt_jrn') {vue_elem('opt_jrn'+eval('arr_jrn'+id_dev_mdl+cbl+'[i]'),0);}
							else if(cbl=='opt_jrn_apr') {vue_elem('opt_jrn'+eval('arr_jrn'+id_dev_mdl+cbl+'[i]'),0);}
							else if(cbl=='vue_jrn_true') {
								if(!$("#chk_jrn"+eval('arr_jrn'+id_dev_mdl+cbl+'[i]')).is(':checked')) {$("#chk_jrn"+eval('arr_jrn'+id_dev_mdl+cbl+'[i]')).prop('checked',true);chk_jrn(eval('arr_jrn'+id_dev_mdl+cbl+'[i]'));}
							}
							else if(cbl=='vue_jrn_false') {
								if($("#chk_jrn"+eval('arr_jrn'+id_dev_mdl+cbl+'[i]')).is(':checked')) {$("#chk_jrn"+eval('arr_jrn'+id_dev_mdl+cbl+'[i]')).prop('checked',false);chk_jrn(eval('arr_jrn'+id_dev_mdl+cbl+'[i]'));}
							}
							else if($("#chk_jrn"+eval('arr_jrn'+id_dev_mdl+cbl+'[i]')).is(':checked')) {sel_prs(cbl,eval('arr_jrn'+id_dev_mdl+cbl+'[i]'));}
							else{vue_jrn('dt',eval('arr_jrn'+id_dev_mdl+cbl+'[i]'));}
						}
					}
				}
				else if(eval('xmlhttp_sel_jrn'+id_dev_mdl).status==408) {sel_jrn(cbl,id_dev_mdl,id_ref_jrn);}
				else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR SEL_JRN "+eval('xmlhttp_sel_jrn'+id_dev_mdl).statusText+" </span>";}
				unload('DEV sel_jrn_'+id_dev_mdl);
			}
		}
		eval('xmlhttp_sel_jrn'+id_dev_mdl+cbl).open("POST","sel_jrn.php",true);
		eval('xmlhttp_sel_jrn'+id_dev_mdl+cbl).setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		eval('xmlhttp_sel_jrn'+id_dev_mdl+cbl).send("id_dev_mdl="+id_dev_mdl+"&cbl="+cbl+"&id_ref_jrn="+id_ref_jrn+"&vue="+vue);
	}
	else if(cbl=='ttr_jrn') {vue_mdl('dt',id_dev_mdl);}
}

function chk_jrn(id_dev_jrn) {
	load('DEV chk_jrn');
	if($("#chk_jrn"+id_dev_jrn).is(':checked')) {
		$.when(
			$.ajax({url:'vue_dsc_jrn.php',type:'POST',data:{id_dev_jrn:id_dev_jrn,id_dev_crc:id_dev_crc,cnf:cnf}}),
			$.ajax({url:'vue_dt_jrn.php',type:'POST',timeout:5000,data:{id_dev_jrn:id_dev_jrn,vue:1,id_dev_crc:id_dev_crc,cnf:cnf}}),//timeout evite error 500 avec sel_jrn
			$.ajax({url:'vue_end_jrn.php',type:'POST',timeout:5000,data:{id_dev_jrn:id_dev_jrn,vue:1,id_dev_crc:id_dev_crc,cnf:cnf}}),//timeout evite error 500 avec sel_jrn
		).then(function(a1,a2,a3) {
			document.getElementById("vue_dsc_jrn_"+id_dev_jrn).innerHTML = a1[0];
			document.getElementById("vue_dt_jrn_"+id_dev_jrn).innerHTML = a2[0];
			document.getElementById("vue_end_jrn_"+id_dev_jrn).innerHTML = a3[0];
			$("#vue_dsc_dt_end_jrn_"+id_dev_jrn).hide();
			$("#vue_dsc_dt_end_jrn_"+id_dev_jrn).stop(true,true).slideDown();
		});
		$("#vue_dt_jrn_"+id_dev_jrn).removeClass();

		unload('DEV chk_jrn');
	}
	else{
		$("#vue_dsc_dt_end_jrn_"+id_dev_jrn).stop(true,true).slideUp();
		$.when(
			$.ajax({url:'vue_dt_jrn.php',type:'POST',data:{id_dev_jrn:id_dev_jrn,vue:0,id_dev_crc:id_dev_crc,cnf:cnf}}),
			$.ajax({url:'vue_end_jrn.php',type:'POST',data:{id_dev_jrn:id_dev_jrn,vue:0,id_dev_crc:id_dev_crc,cnf:cnf}}),
		).then(function(a1,a2) {
			if(document.getElementById("vue_dsc_jrn_"+id_dev_jrn)) {document.getElementById("vue_dsc_jrn_"+id_dev_jrn).innerHTML = '';}
			if(document.getElementById("vue_dt_jrn_"+id_dev_jrn)) {document.getElementById("vue_dt_jrn_"+id_dev_jrn).innerHTML = a1[0];}
			if(document.getElementById("vue_end_jrn_"+id_dev_jrn)) {document.getElementById("vue_end_jrn_"+id_dev_jrn).innerHTML = a2[0];}
			$("#vue_dsc_dt_end_jrn_"+id_dev_jrn).stop(true,true).slideDown();
		});
		$("#vue_dt_jrn_"+id_dev_jrn).addClass('cat_prs');
		unload('DEV chk_jrn');
	}
}

function vue_jrn(cbl,id_dev_jrn,scrl) {
	if(scrl == 're') {document.getElementById('txtHint').innerHTML = '';}
	if(document.getElementById("vue_"+cbl+"_jrn_"+id_dev_jrn)) {
		if(eval('typeof xmlhttp_'+cbl+'_jrn'+id_dev_jrn)!== 'undefined') {
			eval('xmlhttp_'+cbl+'_jrn'+id_dev_jrn).abort();
			if(scrl!=1) {unload('DEV vue_'+cbl+'_jrn');}
		}
		if($("#chk_jrn"+id_dev_jrn).is(':checked') || $("#chk_jrn"+id_dev_jrn).length==0) {var vue=1;}
		else{var vue=0;}
		if(window.XMLHttpRequest) {eval('xmlhttp_'+cbl+'_jrn'+id_dev_jrn+'=new XMLHttpRequest()');}
		else{eval('xmlhttp_'+cbl+'_jrn'+id_dev_jrn+'=new ActiveXObject("Microsoft.XMLHTTP")');}
		if(vue==0 && cbl=='dsc') {
			if(document.getElementById("vue_"+cbl+"_jrn_"+id_dev_jrn)) {document.getElementById("vue_"+cbl+"_jrn_"+id_dev_jrn).innerHTML="";}
			return;
		}
		if(scrl!=1) {load('DEV vue_'+cbl+'_jrn');}
		eval('xmlhttp_'+cbl+'_jrn'+id_dev_jrn).onreadystatechange=function() {
			if(eval('typeof xmlhttp_'+cbl+'_jrn'+id_dev_jrn) !== 'undefined' && eval('xmlhttp_'+cbl+'_jrn'+id_dev_jrn).readyState==4) {
				if(eval('xmlhttp_'+cbl+'_jrn'+id_dev_jrn).status==200) {
					if(document.getElementById("vue_"+cbl+"_jrn_"+id_dev_jrn)) {document.getElementById("vue_"+cbl+"_jrn_"+id_dev_jrn).innerHTML=eval('xmlhttp_'+cbl+'_jrn'+id_dev_jrn).responseText;$('input[type=number]').on('wheel', function(e) {return false;});}
					if(scrl!=1) {unload('DEV vue_'+cbl+'_jrn');}
				}
				else if(eval('xmlhttp_'+cbl+'_jrn'+id_dev_jrn).status==408) {vue_jrn(cbl,id_dev_jrn,scrl);if(scrl!=1) {unload('DEV vue_'+cbl+'_jrn');}}
				else if(eval('xmlhttp_'+cbl+'_jrn'+id_dev_jrn).status) {
					document.getElementById("txtHint").innerHTML = '<span style="background: red;">ERREUR VUE_JRN '+eval("xmlhttp_"+cbl+"_jrn"+id_dev_jrn).statusText+' <br />';
					document.getElementById("txtHint").innerHTML += '<button onclick="vue_jrn(\''+cbl+'\','+id_dev_jrn+',\'re\');">REESSAYER</button></span>';
				}
			}
			else if(eval('typeof xmlhttp_'+cbl+'_jrn'+id_dev_jrn) === 'undefined') {
				if(scrl!=1) {unload('DEV vue_'+cbl+'_jrn');}
				return;
			}
			if(scrl==1 && cbl=='dt') {unload('DEV scroll2');}
		}
		eval('xmlhttp_'+cbl+'_jrn'+id_dev_jrn).open("POST","vue_"+cbl+"_jrn.php",true);
		eval('xmlhttp_'+cbl+'_jrn'+id_dev_jrn).setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		eval('xmlhttp_'+cbl+'_jrn'+id_dev_jrn).send("id_dev_jrn="+id_dev_jrn+"&vue="+vue+"&id_dev_crc="+id_dev_crc+"&cnf="+cnf);
	}
}

function sel_prs(cbl,id_dev_jrn,id_ref_prs) {
	if($("#chk_jrn"+id_dev_jrn).is(':checked')) {
		if(window.XMLHttpRequest) {eval('xmlhttp_sel_prs'+id_dev_jrn+cbl+'=new XMLHttpRequest()');}
		else{eval('xmlhttp_sel_prs'+id_dev_jrn+cbl+'=new ActiveXObject("Microsoft.XMLHTTP")');}
		load('DEV sel_prs');
		eval('xmlhttp_sel_prs'+id_dev_jrn+cbl).onreadystatechange=function() {
			if(eval('xmlhttp_sel_prs'+id_dev_jrn+cbl).readyState==4) {
				if(eval('xmlhttp_sel_prs'+id_dev_jrn+cbl).status==200) {
					if(eval('xmlhttp_sel_prs'+id_dev_jrn+cbl).responseText != 0) {
						eval('var arr_prs'+id_dev_jrn+cbl+'=xmlhttp_sel_prs'+id_dev_jrn+cbl+'.responseText.split("|")');
						for(var i= 0; i < eval('arr_prs'+id_dev_jrn+cbl+'.length'); i++) {
							if(cbl=='ttr_prs') {vue_prs('ttr',eval('arr_prs'+id_dev_jrn+cbl+'[i]'));}
							else if(cbl=='dsc_prs') {vue_prs('dsc',eval('arr_prs'+id_dev_jrn+cbl+'[i]'));}
							else if(cbl=='end_prs') {vue_prs('end',eval('arr_prs'+id_dev_jrn+cbl+'[i]'));}
							else if(cbl=='ttr_prs_apr') {
								vue_prs('ttr',eval('arr_prs'+id_dev_jrn+cbl+'[i]'));
								if($('#div_prs'+eval('arr_prs'+id_dev_jrn+cbl+'[i]')).next().hasClass('ajt_prs_opt')) {
									$('#div_prs'+eval('arr_prs'+id_dev_jrn+cbl+'[i]')).next().stop(true,true).slideUp();
									ajt_prs_prs_opt(eval('arr_prs'+id_dev_jrn+cbl+'[i]'));
								}
								var cl0 = $('#div_prs'+eval('arr_prs'+id_dev_jrn+cbl+'[i]')).attr('class');
								if(typeof cl0 != 'undefined') {
									var id0 = cl0.split('_');
									var id1 = id0[2]-1;
									var cl1 = id0[0]+'_'+id0[1]+'_'+id1;
									$('#div_prs'+eval('arr_prs'+id_dev_jrn+cbl+'[i]')).removeClass(cl0).addClass(cl1);
								}
							}
							else{vue_prs('dt',eval('arr_prs'+id_dev_jrn+cbl+'[i]'));}
						}
					}
				}
				else if(eval('xmlhttp_sel_prs'+id_dev_jrn+cbl).status==408) {sel_prs(cbl,id_dev_jrn,id_ref_prs);}
				else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR SEL_PRS "+eval('xmlhttp_sel_prs'+id_dev_jrn+cbl).statusText+" </span>";}
				unload('DEV sel_prs');
			}
		}
		eval('xmlhttp_sel_prs'+id_dev_jrn+cbl).open("POST","sel_prs.php",true);
		eval('xmlhttp_sel_prs'+id_dev_jrn+cbl).setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		eval('xmlhttp_sel_prs'+id_dev_jrn+cbl).send("id_dev_jrn="+id_dev_jrn+"&cbl="+cbl+"&id_ref_prs="+id_ref_prs);
	}
	else{vue_jrn('dt',id_dev_jrn);}
}

function vue_prs(cbl,id_dev_prs) {
	if($("#vue_"+cbl+"_prs_"+id_dev_prs).length > 0) {
		load('DEV vue_'+cbl+'_prs');
		var req = $.ajax({url: 'vue_'+cbl+'_prs.php', type: 'post', data: {"id_dev_prs":id_dev_prs,"id_dev_crc":id_dev_crc,"cnf":cnf},
		  success: function(responseText) {
				$("#vue_"+cbl+"_prs_"+id_dev_prs).html(responseText);
				unload('DEV vue_'+cbl+'_prs');
			},
			error: function(request, textStatus, errorThrown) {
				unload('DEV vue_'+cbl+'_prs');
				if(request.readyState == 4) {
					$("#txtHint").html("<span style='background: red;'>VUE_PRS ERROR 1</span>");
					console.log('VUE_PRS HTTP error: '+request.status+'/'+request.statusText+'/ vue_prs('+cbl+','+id_dev_prs+')');
				}
				else if(request.readyState == 0) {
					$("#txtHint").html("<span style='background: red;'>VUE_PRS ERROR 2</span>");
					console.log('VUE_PRS Network error: '+request.status+'/'+request.statusText+'/'+request.textStatus+'/'+request.errorThrown);
				}
				else{
					$("#txtHint").html("<span style='background: red;'>VUE_PRS ERROR 3</span>");
					console.log('VUE_PRS something weird is happening: '+request.status+'/'+request.statusText+'/'+request.textStatus+'/'+request.errorThrown);
				}
				req && req.abort();
				vue_prs(cbl,id_dev_prs);
			}
		});
	}
	else{sel_srv('jrn',id_dev_prs);}
}

function sel_srv(cbl,id) {
	if(window.XMLHttpRequest) {eval('xmlhttp_sel_'+cbl+'_'+id+'=new XMLHttpRequest()');}
	else{eval('xmlhttp_sel_'+cbl+'_'+id+'=new ActiveXObject("Microsoft.XMLHTTP")');}
	load('DEV sel_srv');
	eval('xmlhttp_sel_'+cbl+'_'+id).onreadystatechange=function() {
		if(eval('xmlhttp_sel_'+cbl+'_'+id).readyState==4) {
			if(eval('xmlhttp_sel_'+cbl+'_'+id).status==200) {
				if(cbl=='jrn') {vue_jrn('dt',eval('xmlhttp_sel_'+cbl+'_'+id).responseText);}
				else{vue_prs('dt',eval('xmlhttp_sel_'+cbl+'_'+id).responseText);}
			}
			else if(eval('xmlhttp_sel_'+cbl+'_'+id).status==408) {sel_srv(cbl,id);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR SEL_srv "+eval('xmlhttp_sel_'+cbl+'_'+id).statusText+" </span>";}
			unload('DEV sel_srv');
		}
	}
	eval('xmlhttp_sel_'+cbl+'_'+id).open("POST","sel_srv.php",true);
	eval('xmlhttp_sel_'+cbl+'_'+id).setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	eval('xmlhttp_sel_'+cbl+'_'+id).send("cbl="+cbl+"&id="+id);
}

function vue_elem(obj,id,col) {
	if(obj.substr(0,11)=='vue_ttr_crc') {vue_crc('ttr');return;}
	else if(obj.substr(0,11)=='vue_res_crc') {vue_crc('res');return;}
	else if(obj.substr(0,11)=='vue_pax_crc') {vue_crc('pax');return;}
	else if(obj.substr(0,11)=='vue_ttr_mdl') {vue_mdl('ttr',obj.substr(12));return;}
	else if(obj.substr(0,10)=='vue_dt_mdl') {vue_mdl('dt',obj.substr(11));return;}
	else if(obj.substr(0,11)=='vue_pax_mdl') {vue_mdl('pax',obj.substr(12));return;}
	else if(obj.substr(0,11)=='vue_ttr_jrn') {vue_jrn('ttr',obj.substr(12));return;}
	else if(obj.substr(0,10)=='vue_dt_jrn') {vue_jrn('dt',obj.substr(11));return;}
	else if(obj.substr(0,11)=='vue_ttr_prs') {vue_prs('ttr',obj.substr(12));return;}
	else if(obj.substr(0,10)=='vue_dt_prs') {vue_prs('dt',obj.substr(11));return;}
	else if(obj.substr(0,11)=='vue_trf_hbr') {
		if($("#"+obj).html() != '') {vue_trf_hbr(obj.substr(12),0,0);return;}
	}
	else if(obj.substr(0,7)=='srv_trf') {vue_elem('com_srv_trf'+id,id);}
	else if(obj=='hbr') {
		if(col.substr(0,10)=='db_rck_chm' || col.substr(0,10)=='db_net_chm') {vue_elem('com_db_chm'+id,id);}
		else if(col.substr(0,10)=='sg_rck_chm' || col.substr(0,10)=='sg_net_chm') {vue_elem('com_sg_chm'+id,id);}
		else if(col.substr(0,10)=='tp_rck_chm' || col.substr(0,10)=='tp_net_chm') {vue_elem('com_tp_chm'+id,id);}
		else if(col.substr(0,10)=='qd_rck_chm' || col.substr(0,10)=='qd_net_chm') {vue_elem('com_qd_chm'+id,id);}
		else if(col.substr(0,10)=='db_rck_rgm' || col.substr(0,10)=='db_net_rgm') {vue_elem('com_db_rgm'+id,id);}
		else if(col.substr(0,10)=='sg_rck_rgm' || col.substr(0,10)=='sg_net_rgm') {vue_elem('com_sg_rgm'+id,id);}
		else if(col.substr(0,10)=='tp_rck_rgm' || col.substr(0,10)=='tp_net_rgm') {vue_elem('com_tp_rgm'+id,id);}
		else if(col.substr(0,10)=='qd_rck_rgm' || col.substr(0,10)=='qd_net_rgm') {vue_elem('com_qd_rgm'+id,id);}
	}
	var idx = id;
	if(typeof id != 'undefined' && typeof id === 'string') {idx = id.replace("-","_");}
	if(typeof col == 'undefined') {var xhr = obj+idx;}
	else if(typeof id === 'string') {var xhr = obj+idx+col;}
	else{var xhr = obj+col;}
	if($("#"+obj).length > 0) {load('DEV vue_elem '+xhr);}
	var req = $.ajax({url: 'vue_elem.php', type: 'post', data: {"id":id,"obj":obj,"col":col,"id_dev_crc":id_dev_crc,"cnf":cnf},
	  success: function(responseText) {
	    if($("#"+obj+'_'+col+idx).length > 0) {
	      $("#"+obj+'_'+col+idx).val(responseText);
	      $("#"+obj+'_'+col+idx).css("background-color",bck);
	    }
	    else if($("#"+obj).length > 0) {
	      $("#"+obj).html(responseText);
	      if(obj.substr(0,7)=='crc_rgn') {vue_cmd('sel_mdl'+obj.substr(7));}
	      else if(obj.substr(0,7)=='mdl_vll') {vue_cmd('sel_jrn_mdl'+obj.substr(7));}
	      else if(obj.substr(0,11)=='jrn_vll_ctg') {
	        var id0 = id + '';
	        var ids = id0.split("_");
	        if(ids[0]=='0' && ids[1]!='0') {vue_cmd('sel_vll_jrn'+obj.substr(11));}
	        else if(ids[0]!='0' && ids[1]=='0') {vue_cmd('sel_ctg_prs_jrn'+obj.substr(11));}
	        else if(ids[0]!='0' && ids[1]!='0') {vue_cmd('sel_prs'+obj.substr(11));}
	      }
				else if(obj.substr(0,11)=='vll_jrn_rpl') {vue_cmd('sel_jrn_rpl'+obj.substr(11));}
	      else if(obj.substr(0,11)=='prs_vll_ctg') {
	        var id0 = id + '';
	        var ids = id0.split("_");
	        if(ids[0]=='0' && ids[1]!='0') {vue_cmd('sel_vll_prs'+obj.substr(11));}
	        else if(ids[0]!='0' && ids[1]=='0') {vue_cmd('sel_ctg_srv_prs'+obj.substr(11));}
	        else if(ids[0]!='0' && ids[1]!=='0' && ids[1]!=='1') {vue_cmd('sel_srv_prs'+obj.substr(11));}
	        else if(ids[0]!='0' && ids[1]=='1' && ids[3] != 0) {vue_cmd('sel_chm_prs'+obj.substr(11));}
	        else if(ids[0]!='0' && ids[1]=='1' && ids[2] != 0) {vue_cmd('sel_hbr_prs'+obj.substr(11));}
	        else if(ids[0]!='0' && ids[1]=='1') {vue_cmd('sel_rgm_prs'+obj.substr(11));}
	      }
	      else if(obj.substr(0,7)=='hbr_chm' && id!='-1') {vue_cmd('sel_chm_hbr'+obj.substr(7));}
	      else if(obj.substr(0,7)=='prs_hbr') {vue_cmd('sel_chm_hbr_opt'+obj.substr(7));}
	      unload('DEV vue_elem '+xhr);
	    }
	    else if($("."+obj+idx+col).length > 0) {
				$("."+obj+idx+col).prop('title',responseText);
				$("."+obj+idx+col).unbind('mouseover');
				$("."+obj+idx+col).css('cursor','help');
			}
	  },
		error: function(request, textStatus, errorThrown) {
			if($("#"+obj).length > 0) {unload('DEV vue_elem '+xhr);}
      if(request.readyState == 4) {
				$("#txtHint").html("<span style='background: red;'>VUE_ELEM ERROR 1</span>");
				console.log('VUE_ELEM HTTP error: '+request.status+'/'+request.statusText+'/'+request.textStatus+'/'+request.errorThrown);
			}
      else if(request.readyState == 0) {
				$("#txtHint").html("<span style='background: red;'>VUE_ELEM ERROR 2</span>");
				console.log('VUE_ELEM Network error: '+request.status+'/'+request.statusText+'/'+request.textStatus+'/'+request.errorThrown);
			}
      else{
				$("#txtHint").html("<span style='background: red;'>VUE_ELEM ERROR 3</span>");
				console.log('VUE_ELEM something weird is happening: '+request.status+'/'+request.statusText+'/'+request.textStatus+'/'+request.errorThrown);
      }
			req && req.abort();
			vue_elem(obj,id,col);
    }
	});
}

function vue_fll(cbl,obj,src) {
	var xhr = obj;
	if(obj.substr(0,3)=='mdl' && obj.substr(0,7)!='mdl_pax') {
		if(cbl=='crc') {var id = document.getElementById('rgn_crc'+obj.substr(3)).value;}
		else if(cbl=='mdl') {var id = document.getElementById('vll_mdl'+obj.substr(7)).value;}
	}
	else if(obj.substr(0,3)=='jrn') {
		if(cbl=='jrn_mdl') {var id = document.getElementById('vll_mdl'+obj.substr(7)).value;}
		else if(cbl=='jrn') {var id = document.getElementById('vll_jrn'+obj.substr(7)).value+'_'+document.getElementById('ctg_jrn'+obj.substr(7)).value;}
		else if(cbl=='jrn_rpl') {var id = document.getElementById('jrn_rpl_id_cat'+obj.substr(7)).value;}
		else if(cbl=='jrn_opt') {var id = document.getElementById('jrn_opt_id_cat'+obj.substr(7)).value;}
	}
	else if(obj.substr(0,3)=='prs') {
		if(cbl=='jrn') {var id = document.getElementById('vll_jrn'+obj.substr(3)).value+'_'+document.getElementById('ctg_jrn'+obj.substr(3)).value;}
		else if(cbl=='prs') {
			if(document.getElementById('vll_prs'+obj.substr(7))) {var id = document.getElementById('vll_prs'+obj.substr(7)).value+'_'+document.getElementById('ctg_prs'+obj.substr(7)).value;}
			if(document.getElementById('rgm_prs'+obj.substr(7))) {id = id+'_'+document.getElementById('rgm_prs'+obj.substr(7)).value;}
			else{id = id+'_0';}
			if(document.getElementById('hbr_prs'+obj.substr(7))) {id = id+'_'+document.getElementById('hbr_prs'+obj.substr(7)).value;}
			else{id = id+'_0';}
		}
		else if(cbl=='prs_prs_opt') {var id = document.getElementById('prs_opt_id_cat'+obj.substr(11)).value;}
	}
	else if(obj.substr(0,3)=='hbr') {
		if(obj.substr(4,3)=='vll') {var id = document.getElementById('vll_hbr'+obj.substr(7)).value;}
		else if(obj.substr(4,3)=='rgm') {var id = document.getElementById('rgm_hbr'+obj.substr(7)).value;}
		else if(obj.substr(4,3)=='hbr' || obj.substr(4,3)=='chm') {var id = document.getElementById('uid_hbr'+obj.substr(7)).value;}
		else if(cbl=='hbr_opt') {
			var id = document.getElementById('vll_hbr_opt'+obj.substr(11)).value+'_'+document.getElementById('rgm_hbr_opt'+obj.substr(11)).value;
			if(document.getElementById('hbr_hbr_opt'+obj.substr(11))) {id = id+'_'+document.getElementById('hbr_hbr_opt'+obj.substr(11)).value;}
			else{id = id+'_0';}
		}
	}
	else if(obj.substr(0,3)=='srv') {
		if(obj.substr(4,3)=='vll') {var id = document.getElementById('vll_srv'+obj.substr(7)).value;}
		else if(obj.substr(4,3)=='ctg') {var id = document.getElementById('ctg_srv'+obj.substr(7)).value;}
	}
	else{var id = id_dev_crc;}
	if(window.XMLHttpRequest) {eval('xmlhttp_vue_fll'+xhr+'=new XMLHttpRequest()');}
	else{eval('xmlhttp_vue_fll'+xhr+'=new ActiveXObject("Microsoft.XMLHTTP")');}
	eval('xmlhttp_vue_fll'+xhr).onreadystatechange=function() {
		if(eval('xmlhttp_vue_fll'+xhr).readyState==4) {
			if(eval('xmlhttp_vue_fll'+xhr).status==200) {
				if(document.getElementById("lst_"+obj)) {
					document.getElementById("lst_"+obj).innerHTML=eval('xmlhttp_vue_fll'+xhr).responseText;
					heightovery("lst_"+obj);
					var parid = document.getElementById("lst_"+obj).parentNode.id;
					if($("#"+parid).hasClass("wsn")) {heightmrgtp(parid);}
					else if($("#"+parid).hasClass("mw200")) {heightscrll(parid);}
				}
			}
			else if(eval('xmlhttp_vue_fll'+xhr).status==408) {vue_fll(cbl,obj,src);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR VUE_FLL "+eval('xmlhttp_vue_fll'+xhr).statusText+" </span>";}
		}
	}
	eval('xmlhttp_vue_fll'+xhr).open("POST","vue_fll.php",true);
	eval('xmlhttp_vue_fll'+xhr).setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	eval('xmlhttp_vue_fll'+xhr).send("cbl="+cbl+"&obj="+obj+"&src="+encodeURIComponent(src)+"&id="+id);
}

function chk_vue_trf_hbr(id_dev_prs,scrl,id_hbr) {
	if(document.getElementById("vue_trf_hbr_"+id_dev_prs).innerHTML!='') {vue_trf_hbr(id_dev_prs,scrl,id_hbr);}
}

function vue_trf_hbr(id_dev_prs,scrl,id_hbr) {
	if($('#vue_trf_hbr_'+id_dev_prs).length && $('#uid_prs_hbr'+id_dev_prs).length) {
		load('DEV_TRF_HBR');
		if(id_hbr==0) {id_hbr = document.getElementById('uid_prs_hbr'+id_dev_prs).value;}
		var id_vll = document.getElementById('uid_prs_vll'+id_dev_prs).value;
		var id_rgm = document.getElementById('uid_prs_rgm'+id_dev_prs).value;
		if(window.XMLHttpRequest) {eval('xmlhttp_vue_trf_hbr'+id_dev_prs+'=new XMLHttpRequest()');}
		else{eval('xmlhttp_vue_trf_hbr'+id_dev_prs+'=new ActiveXObject("Microsoft.XMLHTTP")');}
		eval('xmlhttp_vue_trf_hbr'+id_dev_prs).onreadystatechange=function() {
			if(eval('xmlhttp_vue_trf_hbr'+id_dev_prs).readyState==4) {
				if(eval('xmlhttp_vue_trf_hbr'+id_dev_prs).status==200) {
					unload('DEV_TRF_HBR');
					$("vue_trf_hbr_"+id_dev_prs).addClass("hbr");
					document.getElementById("vue_trf_hbr_"+id_dev_prs).innerHTML=eval('xmlhttp_vue_trf_hbr'+id_dev_prs).responseText;
					vue_map(id_dev_prs);
					if(scrl) {$('html,body').animate({scrollTop: $('#vue_trf_hbr_'+id_dev_prs).offset().top},'slow');console.log('vue_trf_hbr');}
				}
				else if(eval('xmlhttp_vue_trf_hbr'+id_dev_prs).status==408) {vue_trf_hbr(id_dev_prs,scrl,id_hbr);}
				else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR VUE_TRF_HBR "+eval('xmlhttp_vue_trf_hbr'+id_dev_prs).statusText+"</span>";}
			}
		}
		eval('xmlhttp_vue_trf_hbr'+id_dev_prs).open("POST","vue_trf_hbr.php",true);
		eval('xmlhttp_vue_trf_hbr'+id_dev_prs).setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		eval('xmlhttp_vue_trf_hbr'+id_dev_prs).send("id_dev_prs="+id_dev_prs+"&id_hbr="+id_hbr+"&id_vll="+id_vll+"&id_rgm="+id_rgm);
	}
}

function vue_map(id_dev_prs) {
	lat = document.getElementById('lat'+id_dev_prs).value.split("|");
	lon = document.getElementById('lon'+id_dev_prs).value.split("|");
	nom = document.getElementById('nom'+id_dev_prs).value.split("|");
	var myLatlng = new google.maps.LatLng(lat[0],lon[0]);
	var mapOptions = {zoom: 13, center: myLatlng, mapTypeId: google.maps.MapTypeId.ROADMAP}
	var map = new google.maps.Map(document.getElementById('map'+id_dev_prs), mapOptions);
	var marker = new google.maps.Marker({position: myLatlng, map: map, title: nom[0], icon: '../prm/img/0-dot.png'});
	var len = (lat.length)-1;
	if(len > 1) {
		var dir_icon = '../prm/img/'
		var latlng = new Array();
		for(var i= 1; i < len; i++) {
			var myLatlng = new google.maps.LatLng(lat[i],lon[i]);
			latlng[i-1] = myLatlng;
			var j = i;
			while(j>7) {j = j-8;}
			var marker = new google.maps.Marker({map: map, position: myLatlng, title: nom[i], icon: dir_icon+j+'-dot.png'});
		}
		var latlngbounds = new google.maps.LatLngBounds();
		for(var i = 0; i < latlng.length; i++) {latlngbounds.extend(latlng[i]);}
		map.fitBounds(latlngbounds);
	}
}

function scrollup() {
	$('html,body').animate({scrollTop: $("#div_crc").offset().top},'slow');console.log('scrollup');
}

function scrollprs(id_prs) {
	load('DEV scrollprs');
	$.ajax({url: 'scrollprs.php', type: 'post', data: {"id_prs":id_prs},
		success: function(responseText) {
			var rsp = responseText.split("|");
			scroll2(rsp[0],rsp[1])
			unload('DEV scrollprs');
		},
		error: function (request, status, error) {
			scrollprs(id_prs);
			$("#txtHint").html("<span style = 'background: red;'>SCROLLPRS ERROR</span>");console.log('SCROLLPRS ERROR: '+request.statusText);
		}
	});
}

function scroll2(id_jrn,id_mdl) {
	if($("#vue_ttr_jrn_"+id_jrn).offset()!=null) {
		$('html,body').animate({scrollTop: $("#vue_ttr_jrn_"+id_jrn).offset().top-10},'slow');
		if(!$("#chk_jrn"+id_jrn).is(':checked')) {
			load('DEV scroll2');
			mdf_vue('jrn','','',id_jrn);
		}
	}
	else if($("#vue_ttr_mdl_"+id_mdl).offset()!=null) {
		load('DEV scroll2');
		mdf_vue('mdl','mdl',id_jrn,id_mdl);
	}
}

function mdf_vue(obj,cbl,val,id) {
	if(obj=='crc') {sel_mdl('vue_'+cbl+'_'+val);}
	else if(obj=='mdl') {
		if(cbl=='mdl') {
			if(!$("#chk_mdl"+id).is(':checked')) {$("#chk_mdl"+id).prop('checked',true);vue_mdl('dsc',id);vue_mdl('dt',id,val);vue_mdl('end',id);}
		}
		else{sel_jrn('vue_'+cbl+'_'+val,id);}
	}
	else if(obj=='jrn') {
		if(!$("#chk_jrn"+id).is(':checked')) {$("#chk_jrn"+id).prop('checked',true);vue_jrn('dsc',id,1);vue_jrn('dt',id,1);vue_jrn('end',id,1);}
	}
}
