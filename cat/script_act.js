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

function web_pub(elem,uid,id,lgg,lng) {
	var link = url+lng;
	if(elem == 'crc') {link += '/circuit/';}
	else if(elem == 'mdl') {link += '/module/';}
	link += encodeURIComponent(uid)+"/?";
	var mapForm = document.createElement("form");
	mapForm.target = "edit"+uid;
	mapForm.method = "POST";
	$(".website").each(function() {
		if($(this).attr("id")== elem+'_txt_titre'+id) {
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
				updateData("cat_"+elem+"_txt","web_mdp",motdepasse,id);
			}
		}
		else if($(this).attr("id") == elem+'_txt_dsc'+lgg) {
			var mapInput = document.createElement("textarea");
			mapInput.name = "description";
			mapInput.value = $(this).html();
			mapForm.appendChild(mapInput);
		}
	});
	$.ajax({url: 'web_pub.php', type: 'post', data: {"id":id_cat,"obj":elem,"lgg":lgg},
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
			web_pub(elem,uid,id,lgg,lng)
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
