var flg_maj = true, id_lng, id_cat, cbl_cat, aut, upd = 0;

function maj(tab,col,val,id,id_sup) {
	if(flg_maj) {upd++; console.log('upd '+upd); flg_maj = false;}
	if(window.XMLHttpRequest) {eval('xmlhttp_maj'+id+col+'=new XMLHttpRequest()');}
	else{eval('xmlhttp_maj'+id+col+'=new ActiveXObject("Microsoft.XMLHTTP")');}
	if(id_sup > 0) {load('CAT');}
	eval('xmlhttp_maj'+id+col).onreadystatechange=function() {
		if(eval('xmlhttp_maj'+id+col).readyState==4) {
			if(eval('xmlhttp_maj'+id+col).status==200) {
//ACTUALISE AFFICHAGE
				if(col=='nom') {
					act_tab();
					act_acc();
					window.parent.act_frm(cbl_cat);
					window.parent.act_frm('up_'+cbl_cat);
					if(tab=='cat_chm') {vue_elem('hbr_chm',id_sup);}
				}
				else if(col=='info') {act_acc();	window.parent.act_frm(cbl_cat); window.parent.act_frm('up_'+cbl_cat);}
				else if(col=='titre') {
					if(tab=='cat_crc_txt') {vue_elem('crc_web'+id,id_cat);}
					else if(tab=='cat_mdl_txt') {vue_elem('mdl_web'+id,id_cat);}
				//	else if(tab=='cat_jrn_txt') {window.parent.act_frm(cbl_cat);}
					act_acc();
				}
				else if(col=='mail') {
					if(tab=='cat_frn') {vue_elem('frn_mail',id);}
					if(tab=='cat_hbr') {vue_elem('hbr_mail',id);}
				}
				else if(col=='mail_frt') {vue_elem('hbr_frt_mail',id);}
				else if(col=='ord') {
					if(tab=='cat_crc_mdl') {vue_elem('crc_mdl',id_sup);}
					if(tab=='cat_mdl_jrn') {vue_elem('mdl_jrn',id_sup);}
					if(tab=='cat_jrn_vll') {vue_elem('jrn_vll',id_sup);act_acc();}
					if(tab=='cat_jrn_lieu') {vue_elem('jrn_lieu',id_sup);}
					if(tab=='cat_jrn_prs') {
						vue_elem('jrn_prs',id_sup);
						window.parent.act_frm('dt_jrn');
					}
					if(tab=='cat_prs_lieu') {
						vue_elem('prs_lieu',id_sup);
						window.parent.act_frm('prs');
					}
				}
				else if(col=='fus') {vue_elem('crc_mdl',id_sup);}
				else if(col=='opt') {
					if(tab=='cat_mdl_jrn') {
						vue_elem('mdl_jrn',id_sup);
						window.parent.act_frm('jrn_opt');
					}
					if(tab=='cat_jrn_prs') {
						vue_elem('jrn_prs',id_sup);
						window.parent.act_frm('prs_opt');
					//	window.parent.act_frm('dt_jrn');??
					}
					if(tab=='cat_prs_hbr') {vue_elem('prs_hbr',id_sup);}
				}
				else if(col=='ctg' || col=='id_ctg' || col=='id_vll' || col=='id_rgn' || col=='id_pays') {
					act_acc();
					window.parent.act_frm(cbl_cat);
					if(tab=='cat_srv') {
						act_frm('frn');
						act_frm('frn_srv');
					}
				}
				else if(col=='dt_max') {act_acc();}
				else if(col=='web_uid') {
					if(tab=='cat_crc_txt') {
						vue_elem('crc_txt',id_cat);
					//	web_pub('crc',val,id_cat); useful? missing: lng, lgg
					}
					else if(tab=='cat_mdl_txt') {
						vue_elem('mdl_txt',id_cat);
					//	web_pub('mdl',val,id_cat); useful? missing: lng, lgg
					}
					act_acc();
				}
				else if(col=='web_mdp') {
					if(tab=='cat_crc_txt') {vue_elem('crc_txt',id_cat);}
					else if(tab=='cat_mdl_txt') {vue_elem('mdl_txt',id_cat);}
				}
				else if(col=='nvtrf' || col=='lstrg' || col=='ferme') {act_acc();}
				else if(col=='sel_mdl_jrn') {
					if(tab=='cat_crc_mdl') {vue_elem('crc_mdl',id_cat);}
					else if(tab=='cat_mdl') {vue_elem('mdl_jrn',id_cat);}
				}
			/*	if(tab=='cat_crc_txt' && col=='titre') {vue_elem('crc_txt',id,col);}
				else if(tab=='cat_mdl_txt' && col=='titre') {vue_elem('mdl_txt',id,col);}
				else if(tab=='cat_jrn_txt' && col=='titre') {vue_elem('jrn_txt',id,col);}
				else*/ if(tab=="cat_prs") {
					if(col=="ctg") {vue_elem("prs_ctg",id);}
					else if(col=="jours") {vue_elem("prs",id,"jours");}
				}
				//else if(tab=='cat_prs_txt' && col=='titre') {vue_elem('prs_txt',id,col);}
				else if(tab=="cat_srv") {
					if(col=="id_vll") {vue_elem("srv_vll",id);}
					else if(col=="ctg") {vue_elem("srv_ctg",id);vue_elem("srv_lgg",id);}
					else if(col=="lgg") {vue_elem("srv_lgg",id);}
					else if(col=='vrl') {window.parent.act_frm('dt_srv'+id);}
				}
			//	else if(tab=='cat_srv_txt' && col=='titre') {vue_elem('srv_txt',id,col);}
				else if(tab=="cat_srv_trf") {
					if(id_sup > 0) {vue_elem('dt_srv',id_sup);}
					else if(col=="crr") {vue_elem("dt_srv_crr"+id,id);}
				}
				else if(tab=="cat_srv_trf_bss") {
					if(col=='id_frn') {
						vue_elem("dt_srv_frn"+id,id_sup);
						window.parent.act_frm('frn_srv');
					}
					else{
						vue_elem('srv_trf_bss',id,col);
						if(col=="trf_rck" || col=="trf_net") {vue_elem('dt_srv_com'+id,id);}
						else if(col=='bs_min') {vue_elem('srv_trf_bss',id,'bs_max');}
					}
				}
				else if(tab=="cat_srv_trf_ssn") {
					vue_elem('dt_srv',id_sup);
					if(col=='dt_min' || col=='dt_max') {window.parent.act_frm('frn_srv');}
				}
				else if(tab=="cat_hbr") {
					if(col=="id_vll") {
						vue_elem("hbr_vll",id);
						vue_elem("hbr_frn",id);
						if(val!=0) {
							act_frm('frn_hbr');
							if(window.XMLHttpRequest) {xhttp=new XMLHttpRequest();}
							else{xhttp=new ActiveXObject("Microsoft.XMLHTTP");}
							xhttp.open("GET","txt_js.xml",false); //remplazar por json
							xhttp.send();
							xmlDoc=xhttp.responseXML;
							x=xmlDoc.getElementsByTagName("act_map_vll");
							y=x[0].getElementsByTagName(id_lng);
							if(window.confirm(y[0].childNodes[0].nodeValue)) {
								maj_hbr_vll(id,val);
								if(aut) {
									var nom_vll = document.getElementById("nom_vll").value;
									vue_map_init(nom_vll);
								}
								else{vue_map_init_noevent();}
							}
						}
					}
					else if(col=="adresse" && val!='') {
						if(window.XMLHttpRequest) {xhttp=new XMLHttpRequest();}
						else{xhttp=new ActiveXObject("Microsoft.XMLHTTP");}
						xhttp.open("GET","txt_js.xml",false); //remplazar por json
						xhttp.send();
						xmlDoc=xhttp.responseXML;
						x=xmlDoc.getElementsByTagName("act_map");
						y=x[0].getElementsByTagName(id_lng);
						var nom_vll = document.getElementById("nom_vll").value;
						if(window.confirm(y[0].childNodes[0].nodeValue)) {vue_map_address(val+','+nom_vll);}
					}
					else if(col=="lat" || col=="lon") {
						vue_elem('hbr',id,col);
						if(id_sup==0) {vue_map();}
						window.parent.act_frm(cbl_cat);
					}
					else if(id_sup > 0) {vue();}
					else if(col=="id_frn") {vue_elem('hbr_frn',id);window.parent.act_frm('frn_hbr');}
					else if(col=="ctg") {vue_elem("hbr_ctg",id);}
					else if(col=="id_vll") {vue_elem("hbr_vll",id);}
					else if(col=="ctg_res") {vue_elem("hbr_ctg_res",id);}
					else if(col=="id_bnq") {vue_elem("hbr_bnq",id);}
					else if(col=='frs') {vue_elem('hbr',id,col);}
					else if(col=='vrl') {window.parent.act_frm('hbr_chm'+id);window.parent.act_frm('hbr_rgm'+id);}
				}
				else if(tab=='cat_hbr_txt') {
				//	if(col=='titre') {vue_elem('hbr_txt',id,col);}
					if(col=='web') {vue_elem('hbr_txt',id_sup);}
				}
				else if(tab=="cat_hbr_pay" && col=="ty_delai") {vue_elem("hbr_pay_ty_delai",id);}
				else if(tab=="cat_hbr_chm") {
					if(col=='rgm') {vue_elem('hbr_chm_rgm'+id,id_sup);vue_elem('hbr_rgm',id_sup);window.parent.act_frm('hbr');}
					else if(id_sup > 0) {vue_elem('hbr_chm',id_sup);}
				}
				else if(tab=="cat_hbr_chm_trf") {
					if(id_sup > 0) {vue_elem('hbr_chm',id_sup);}
					else if(col=="crr") {vue_elem("hbr_chm_crr"+id,id);}
					else{vue_elem('hbr_chm_trf',id,col);}
				}
				else if(tab=="cat_hbr_chm_trf_ssn") {vue_elem('hbr_chm',id_sup);}
				else if(tab=="cat_hbr_rgm" && id_sup > 0) {vue_elem('hbr_rgm',id_sup);}
				else if(tab=="cat_hbr_rgm_trf") {
					if(id_sup > 0) {vue_elem('hbr_rgm',id_sup);}
					else if(col=="crr") {vue_elem("hbr_rgm_crr"+id,id);}
					else{vue_elem('hbr_rgm_trf',id,col);}
				}
				else if(tab=="cat_hbr_rgm_trf_ssn") {vue_elem('hbr_rgm',id_sup);}
				else if(tab=="cat_clt") {
					if(col=="id_ctg") {vue_elem("clt_ctg",id);}
					else if(col=="crr") {vue_elem("clt_crr",id);}
				}
				else if(tab=="cat_frn") {
					if(col=="ctg_res") {vue_elem("frn_ctg_res",id);}
					else if(col=="id_bnq") {vue_elem("frn_bnq",id);}
					else if(col=='frs') {
						vue_elem('frn',id,col);
						window.parent.act_frm('crc_dev_res');
					}
				}
				else if(tab=="cat_frn_pay" && col=="ty_delai") {vue_elem("frn_pay_ty_delai",id);}
				else if(tab=="cat_vll" && (col=="nom" && val!='')) {
					if(window.XMLHttpRequest) {xhttp=new XMLHttpRequest();}
					else{xhttp=new ActiveXObject("Microsoft.XMLHTTP");}
					xhttp.open("GET","txt_js.xml",false); //remplazar por json
					xhttp.send();
					xmlDoc=xhttp.responseXML;
					x=xmlDoc.getElementsByTagName("act_map");
					y=x[0].getElementsByTagName(id_lng);
					var nom_pays = document.getElementById("nom_pays").value;
					if(window.confirm(y[0].childNodes[0].nodeValue)) {vue_map_address(val+','+nom_pays);}
				}
				else if(tab=="cat_lieu") {
					if(col=="nom" && val!='') {
						if(window.XMLHttpRequest) {xhttp=new XMLHttpRequest();}
						else{xhttp=new ActiveXObject("Microsoft.XMLHTTP");}
						xhttp.open("GET","txt_js.xml",false); //remplazar por json
						xhttp.send();
						xmlDoc=xhttp.responseXML;
						x=xmlDoc.getElementsByTagName("act_map");
						y=x[0].getElementsByTagName(id_lng);
						if(document.getElementById("nom_vll")) {val += ','+document.getElementById("nom_vll").value;}
						if(document.getElementById("nom_pays")) {val += ','+document.getElementById("nom_pays").value;}
						if(window.confirm(y[0].childNodes[0].nodeValue)) {vue_map_address(val);}
					}
					else if(col=="id_vll" && val!=0) {
						if(window.XMLHttpRequest) {xhttp=new XMLHttpRequest();}
						else{xhttp=new ActiveXObject("Microsoft.XMLHTTP");}
						xhttp.open("GET","txt_js.xml",false); //remplazar por json
						xhttp.send();
						xmlDoc=xhttp.responseXML;
						x=xmlDoc.getElementsByTagName("act_map_vll");
						y=x[0].getElementsByTagName(id_lng);
						if(window.confirm(y[0].childNodes[0].nodeValue)) {
							maj_lieu_vll(id,val);
							if(aut) {
								var nom_vll = document.getElementById("nom_vll").value;
								vue_map_init(nom_vll);
							}
							else{vue_map_init_noevent();}
						}
						vue_elem("lieu_vll",id);
					}
					else if(col=="lat" || col=="lon") {
						vue_elem('lieu',id,col);
						if(id_sup==0) {vue_map();}
					}
				}
				else if(tab=="cat_pic" && col=="id_rgn") {vue_elem("pic_rgn",id);}
				else if(tab=="cat_vll") {
					if(col=="id_rgn") {vue_elem("vll_rgn",id);}
					else if(col=="id_pays") {vue_elem("vll_pays",id);}
					else if(col=="lat" || col=="lon") {
						vue_elem('vll',id,col);
						if(id_sup==0) {vue_map();}
					}
				}
				else if(tab=="cat_bnq" && col=="id_pays") {vue_elem("bnq_pays",id);}
				else if(col=='pay') {
					if(tab=='dev_hbr_pay') {window.parent.act_frm('hbr_pay_pay');}
					else if(tab=='dev_srv_pay') {window.parent.act_frm('srv_pay_pay');}
				}

				if(eval('xmlhttp_maj'+id+col).responseText!=1) {alt(eval('xmlhttp_maj'+id+col).responseText);}
				if(document.getElementById("txtHint").innerHTML.includes("SAVE ERROR")) {document.getElementById("txtHint").innerHTML="";}
			}
			else if(eval('xmlhttp_maj'+id+col).status==408) {maj(tab,col,val,id,id_sup);}
			else{
				document.getElementById("txtHint").innerHTML="<span style='background: red;'>SAVE ERROR</span>";
				console.log(eval('xmlhttp_maj'+id+col).statusText);
				vue_elem(tab,id,col);
			}
			if(!flg_maj) {
				upd--;
				console.log('upd '+upd);
				flg_maj = true;
			}
			if(id_sup > 0) {unload('CAT');}
		}
	}
	eval('xmlhttp_maj'+id+col).open("POST","maj.php",true);
	eval('xmlhttp_maj'+id+col).setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	eval('xmlhttp_maj'+id+col).send("tab="+tab+"&col="+col+"&val="+encodeURIComponent(val)+"&id="+id+"&id_sup="+id_sup);
}

function maj_hbr_vll(id_hbr,id_vll) {
	if(window.XMLHttpRequest) {xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load('CAT');
	xmlhttp.onreadystatechange=function() {
		if(xmlhttp.readyState==4) {
			if(xmlhttp.status==200) {vue();}
			else if(xmlhttp.status==408) {maj_hbr_vll(id_hbr,id_vll);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR MAJ_HBR_VLL "+xmlhttp.statusText+" </span>";}
			unload('CAT');
		}
	}
	xmlhttp.open("POST","maj_hbr_vll.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("id_hbr="+id_hbr+"&id_vll="+id_vll);
}

function maj_lieu_vll(id_lieu,id_vll) {
	if(window.XMLHttpRequest) {xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load('CAT');
	xmlhttp.onreadystatechange=function() {
		if(xmlhttp.readyState==4) {
			if(xmlhttp.status==200) {vue();}
			else if(xmlhttp.status==408) {maj_lieu_vll(id_lieu,id_vll);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR MAJ_lieu_VLL "+xmlhttp.statusText+" </span>";}
			unload('CAT');
		}
	}
	xmlhttp.open("POST","maj_lieu_vll.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("id_lieu="+id_lieu+"&id_vll="+id_vll);
}

function maj_vll_hbr(id_rgm,hbr_def,id_hbr,id_chm) {
	if(window.XMLHttpRequest) {xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	load('CAT');
	xmlhttp.onreadystatechange=function() {
		if(xmlhttp.readyState==4) {
			if(xmlhttp.status==200) {
				vue_elem('vll_hbr'+hbr_def+'_'+id_rgm,id_cat);
				window.parent.act_frm('mdl_trf');
				window.parent.act_frm('crc_trf');
			}
			else if(xmlhttp.status==408) {maj_vll_hbr(id_rgm,hbr_def,id_hbr,id_chm);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR MAJ_VLL_HBR "+xmlhttp.statusText+" </span>";}
			unload('CAT');
		}
	}
	xmlhttp.open("POST","maj_vll_hbr.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("id_vll="+id_cat+"&hbr_def="+hbr_def+"&id_rgm="+id_rgm+"&id_hbr="+id_hbr+"&id_chm="+id_chm);
}

function generateTable(data) {
  //console.log(data);
  var rows = data.split("\n");

  var table = $('<table />');

  for(var y in rows) {
    var cells = rows[y].split("\t");
    var row = $('<tr />');
    for(var x in cells) {
        row.append('<td>'+cells[x].replace(',','.').trim()+'</td>');
    }
    table.append(row);
	}
	$('#generatedTable').html(table);
}

function rotateTable(){
	var gTable = $('#generatedTable').html();
	var gRows = gTable.substring(18,gTable.length-21).split('</tr><tr>');
	var cells = new Array();
	for(var y in gRows) {
		cells[y] = gRows[y].substring(4,gRows[y].length-5).split("</td><td>");
	}
	var table = $('<table />');
	for(var x in cells[0]){
		var row = $('<tr />');
		for(var y in gRows) {
			row.append('<td>'+cells[y][x]+'</td>');
		}
		table.append(row);
	}
	$('#generatedTable').html(table);
}

function saveTable(){

	var gTable = $('#generatedTable').html();
	var gRows = gTable.substring(18,gTable.length-21).split('</tr><tr>');
	var cells = new Array();
	for(var y in gRows) {
		cells[y] = gRows[y].substring(4,gRows[y].length-5).split("</td><td>");
	}
	var gCols = $('.generatedCol:checkbox:checked').map(function() {
		return this.id;
	}).get();
	/*	var rows = new Array();
		for(var x in cells[0]){
			var row = new Array();
			for(var y in gRows) {
				row.push(cells[y][x]);
			}
			rows.push(row);
		}*/
	console.log(cells[0]);
	console.log(gCols);
	if(cells[0].length == gCols.length){
		insCols = gCols.join(',')+',id_trf';
		var gCells = new Array();
		for(var y in cells) {
			gCells[y] = '('+cells[y].join(',')+',%id_trf%)';
		}
		insVals = gCells.join(',');
		$.ajax({url: 'saveTable.php', type: 'post', data: {"id_srv":id_cat,"insCols":insCols,"insVals":insVals},
			success: function(){vue_elem('dt_srv',id_cat);},
			error: function (request, status, error){
				saveTable();
				console.log('SAVE TABLE ERROR: '+request.statusText);
			}
		});
	}
}

function web_ajt(obj,uid,id,lgg,lng) {
	if(uid.length == 0) {
		if(window.XMLHttpRequest) {xhttp=new XMLHttpRequest();}
		else {xhttp=new ActiveXObject("Microsoft.XMLHTTP");}
		xhttp.open("GET","txt_js.xml",false); //remplazar por json
		xhttp.send();
		xmlDoc=xhttp.responseXML;
		x=xmlDoc.getElementsByTagName("web");
		y=x[0].getElementsByTagName(id_lng);
		uid = prompt(y[0].childNodes[0].nodeValue,uid);
		if(uid == '') {return;}
		uid = uid.toLowerCase().replace(/\b[a-z]/g, function(letter) {
		    return letter.toUpperCase();
		});
		uid = uid.trim();
		uid = uid.replace(/[\/\. ,:_]+/g, "-");
		uid = uid.replace(/["']/g, "-");
		uid = uid.replace(/&/g, "-");
		uid = uid.replace(/-+/g, "-");
		uid = uid.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
		var link = url+lng;
		if(obj == 'crc') {link += '/circuit/';}
		else if(obj == 'mdl') {link += '/module/';}
		link += encodeURIComponent(uid);
		check_url(link, function(status) {
	    if(status === 200) {
				y=x[1].getElementsByTagName(id_lng);
	      alt(y[0].childNodes[0].nodeValue);
				return;
	    }
	    else if(status === 404) {maj("cat_"+obj+"_txt","web_uid",uid,id);}
		});
	}
	else{web_pub(obj,uid,id,lgg,lng);}
}

function web_pub(obj,uid,id,lgg,lng) {
	var link = url+lng;
	if(obj == 'crc') {link += '/circuit/';}
	else if(obj == 'mdl') {link += '/module/';}
	link += encodeURIComponent(uid)+"/?";
	var mapForm = document.createElement("form");
	mapForm.target = "edit"+uid;
	mapForm.method = "POST";
	$(".website").each(function() {
		if($(this).attr("id")== obj+'_txt_titre'+id) {
			var mapInput = document.createElement("input");
			mapInput.type = "text";
			mapInput.name = "title";
			mapInput.value = $(this).val();
			mapForm.appendChild(mapInput);
			if($("#mdp"+lgg).val().length>0) {link += $("#mdp"+lgg).val();}
			else{
				var motdepasse = pass();
				var mapInput = document.createElement("input");
				mapInput.type = "text";
				mapInput.name = "pass";
				mapInput.value = motdepasse;
				mapForm.appendChild(mapInput);
				var mdp = '';
				for(var i = 0; i < $(this).val().length; i++) {mdp += $(this).val()[i].charCodeAt(0).toString(2);}
				link += mdp;
				maj("cat_"+obj+"_txt","web_mdp",motdepasse,id);
			}
		}
		else if($(this).attr("id") == obj+'_txt_dsc'+lgg) {
			var mapInput = document.createElement("textarea");
			mapInput.name = "description";
			mapInput.value = $(this).html();
			mapForm.appendChild(mapInput);
		}
	});
	$.ajax({url: 'web_pub.php', type: 'post', data: {"id":id_cat,"obj":obj,"lgg":lgg},
 		success: function(responseText) {
			var div = document.createElement("div");
			div.innerHTML = responseText;
			mapForm.append(div);
			document.body.appendChild(mapForm);
			mapForm.action = url;
			mapForm.submit();
			mapForm.remove();
			window.focus(url);
		},
		error: function (request, status, error) {
			web_pub(obj,uid,id,lgg,lng)
			$("#txtHint").html("<span style = 'background: red;'>WEB PUB</span>");console.log('WEB PUB ERROR: '+request.statusText);
		}
	});
}

function check_url(url,cb) {
	jQuery.ajax({
		url: url,
		dataType: 'text',
		type: 'GET',
		complete: function(xhr) {
	    if(typeof cb === 'function') cb.apply(this, [xhr.status]);
		}
	});
}

function pass() {
	charset = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz~!@-$",
  retVal = "";
  for(var i = 0, n = charset.length; i < 255; ++i) {retVal += charset.charAt(Math.floor(Math.random() * n));}
  return retVal;
}

function init() { //à mettre dans catLoad.jd
	if(cbl_cat=='vll' || cbl_cat=='lieu' || cbl_cat=='hbr') {
		if(!aut) {loadScript_noevent();}
		else{loadScript();}
	}
	flg_rch = true;
	act_tab();
	$('.rich').css('pointer-events','auto');
	$('input[type=number]').on('wheel', function(e) {return false;});
	unload('CAT');
}

function act_tab() {
	upd++;
	if(window.XMLHttpRequest) {xmlhttp_act_tab=new XMLHttpRequest();}
	else{xmlhttp_act_tab=new ActiveXObject("Microsoft.XMLHTTP");}
	xmlhttp_act_tab.onreadystatechange=function() {
		if(xmlhttp_act_tab.readyState==4) {
			if(xmlhttp_act_tab.status==200) {window.parent.act_tab('cat/ctr.php?cbl='+cbl_cat+'&id='+id_cat,encodeURIComponent(xmlhttp_act_tab.responseText));upd--;}
			else if(xmlhttp_act_tab.status==408) {act_tab();upd--;}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR ACT_TAB"+xmlhttp_act_tab.statusText+" </span>";upd--;}
		}
	}
	xmlhttp_act_tab.open("POST","nom_tab.php",true);
	xmlhttp_act_tab.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp_act_tab.send("cbl="+cbl_cat+"&id="+id_cat);
}

function act_frm(cbl) {
	var elem = document.getElementsByClassName(cbl);
	for (var i = 0; i < elem.length; i++) {vue_elem(elem[i].id,id_cat);}
}

function act_acc() {
	var cbl_lst = parent.window.frames[0].document.getElementById('cbl').value;
	if(cbl_lst == 'acc' || cbl_lst == 'pay' || cbl_lst == cbl_cat) {parent.window.frames[0].vue_lst(cbl_lst);}
}
