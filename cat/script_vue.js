function vue() {
	if(window.XMLHttpRequest) {xmlhttp_vue=new XMLHttpRequest();}
	else{xmlhttp_vue=new ActiveXObject("Microsoft.XMLHTTP");}
	load('CAT');
	xmlhttp_vue.onreadystatechange=function() {
		if(xmlhttp_vue.readyState==4) {
			if(xmlhttp_vue.status==200) {
				document.getElementById("vue").innerHTML=xmlhttp_vue.responseText;
				if(cbl_cat=='hbr' || cbl_cat=='vll' || cbl_cat=='lieu') {
					if(aut) {vue_map_init();}
					else{vue_map_init_noevent();}
				}
			}
			else if(xmlhttp_vue.status==408) {vue();}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR VUE "+xmlhttp_vue.statusText+" </span>";}
			unload('CAT');
		}
	}
	xmlhttp_vue.open("POST","vue.php",true);
	xmlhttp_vue.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp_vue.send("id="+id_cat+"&cbl="+cbl_cat);
}

function vue_elem(obj,id,col) {
	if(obj.substr(0,6)=='dt_srv' && obj.substr(6)>0) {
		if(obj.substr(6) == id_cat) {obj = 'dt_srv';}
		else{return;}
	}
	if(typeof col == 'undefined') {var xhr = id+obj;}
	else{var xhr = id+obj+col;}
	if(window.XMLHttpRequest) {eval('xmlhttp_vue_elem'+xhr+'=new XMLHttpRequest()');}
	else{eval('xmlhttp_vue_elem'+xhr+'=new ActiveXObject("Microsoft.XMLHTTP")');}
	if(document.getElementById(obj)) {load('CAT vue_elem '+xhr);}
	else if(document.getElementById(obj+'_'+col+id)) {
		var bck = document.getElementById(obj+'_'+col+id).style.backgroundColor;
		document.getElementById(obj+'_'+col+id).style.backgroundColor  = "lightgrey";
	}
	eval('xmlhttp_vue_elem'+xhr).onreadystatechange=function() {
		if(eval('typeof xmlhttp_vue_elem'+xhr) !== 'undefined' && eval('xmlhttp_vue_elem'+xhr).readyState==4) {
			if(eval('xmlhttp_vue_elem'+xhr).status==200) {
				if(document.getElementById(obj+'_'+col+id)) {
					var val = eval('xmlhttp_vue_elem'+xhr).responseText;
					document.getElementById(obj+'_'+col+id).value = val;
					document.getElementById(obj+'_'+col+id).style.backgroundColor = bck;
					if(obj.substr(0,3)=='hbr') {
						if(col.substr(-3)=='rck') {
							if(val!=0 && (document.getElementById(obj+'_'+col.substr(0,2)+'_net'+id).value==0 || document.getElementById(obj+'_'+col.substr(0,2)+'_net'+id).value-val > 0)) {document.getElementById(obj+'_'+col+id).style.backgroundColor ='red';document.getElementById(obj+'_'+col.substr(0,2)+'_net'+id).style.backgroundColor ='red';}else if(document.getElementById(obj+'_est'+id).checked) {document.getElementById(obj+'_'+col+id).style.backgroundColor ='gold';document.getElementById(obj+'_'+col.substr(0,2)+'_net'+id).style.backgroundColor ='gold';}else{document.getElementById(obj+'_'+col+id).style.backgroundColor ='white';document.getElementById(obj+'_'+col.substr(0,2)+'_net'+id).style.backgroundColor ='white';}
						}
						if(col.substr(-3)=='net') {
							if(document.getElementById(obj+'_'+col.substr(0,2)+'_rck'+id).value!=0 && (document.getElementById(obj+'_'+col+id).value==0 || document.getElementById(obj+'_'+col+id).value-document.getElementById(obj+'_'+col.substr(0,2)+'_rck'+id).value>0)) {document.getElementById(obj+'_'+col+id).style.backgroundColor ='red';document.getElementById(obj+'_'+col.substr(0,2)+'_rck'+id).style.backgroundColor ='red';}else if(document.getElementById(obj+'_est'+id).checked) {document.getElementById(obj+'_'+col+id).style.backgroundColor ='gold';document.getElementById(obj+'_'+col.substr(0,2)+'_rck'+id).style.backgroundColor ='gold';}else{document.getElementById(obj+'_'+col+id).style.backgroundColor ='white';document.getElementById(obj+'_'+col.substr(0,2)+'_rck'+id).style.backgroundColor ='white';}
						}
					}
				}
				else if(document.getElementById(obj)) {

					document.getElementById(obj).innerHTML = eval('xmlhttp_vue_elem'+xhr).responseText;
					if(obj.substr(4,3)=='txt') {
						flg_rch = true;
						$('.rich').css('pointer-events','auto');
					}
					else if(obj=='crc_rgn') {vue_cmd('sel_mdl');}
					else if(obj=='mdl_vll') {vue_cmd('sel_jrn');}
					else if(obj=='jrn_prs_vll_ctg') {
						var id0 = id + '';
						var ids = id0.split("_");
						if(ids[0]=='0' && ids[1]!='0') {vue_cmd('sel_vll');}
						else if(ids[0]!='0' && ids[1]=='0') {vue_cmd('sel_ctg');}
						else if(ids[0]!='0' && ids[1]!='0') {vue_cmd('sel_prs');}
					}
					else if(obj=='prs_vll_ctg') {
						var id0 = id + '';
						var ids = id0.split("_");
						if(ids[0]=='0' && ids[1]!='0') {vue_cmd('sel_vll');}
						else if(ids[0]!='0' && ids[1]=='0') {vue_cmd('sel_ctg');}
						else if(ids[0]!='0' && ids[1]!=='0' && ids[1]!=='1') {vue_cmd('sel_srv');}
						else if(ids[0]!='0' && ids[1]=='1' && ids.length > 3) {vue_cmd('sel_chm');}
						else if(ids[0]!='0' && ids[1]=='1' && ids.length > 2) {vue_cmd('sel_hbr');}
						else if(ids[0]!='0' && ids[1]=='1') {vue_cmd('sel_rgm');}
					}
					else if(obj.substr(0,7)=='pic_vll' && id>0){vue_cmd('sel_jrn');}
				}
			}
			else if(eval('xmlhttp_vue_elem'+xhr).status==408) {vue_elem(obj,id,col);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR VUE_ELEM "+eval('xmlhttp_vue_elem'+xhr).statusText+" </span>";}
			if(document.getElementById(obj)) {unload('CAT vue_elem '+xhr);}
		}
	}
	eval('xmlhttp_vue_elem'+xhr).open("POST","vue_elem.php",true);
	eval('xmlhttp_vue_elem'+xhr).setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	eval('xmlhttp_vue_elem'+xhr).send("id="+id+"&obj="+obj+"&col="+col);
}

function vue_fll(cbl,obj,src) {
	var xhr = obj;
	if(cbl=='crc' && obj=='mdl') {var id = document.getElementById('rgn').value;}
	else if((cbl=='mdl' || cbl=='pic') && obj=='jrn') {var id = document.getElementById('vll').value;}
	else if(document.getElementById(obj) && cbl!='prs' && cbl!='srv' && cbl!='hbr' && cbl!='lieu' && cbl!='clt' && cbl!='pic') {var id = document.getElementById(obj).value;}
	else{var id = id_cat;}
	if(cbl=='mdl_jrn_opt') {id = document.getElementById('jrn_opt_id'+obj.substr(7)).value;}
	else if(cbl=='jrn_prs_opt') {id = document.getElementById('prs_opt_id'+obj.substr(7)).value;}
	else if(cbl=='jrn_prs') {
		if(obj=='vll_prs') {id = id+"_"+document.getElementById('ctg_prs').value;}
		else if(obj=='ctg_prs') {id = document.getElementById('vll_prs').value+"_"+id_cat;}
		else if(obj=='prs') {id = document.getElementById('vll_prs').value+"_"+document.getElementById('ctg_prs').value;}
	}
	else if(cbl=='prs') {
		if(obj=='vll') {id = id+"_"+document.getElementById('ctg_srv').value;}
		else if(obj=='ctg_srv') {id = document.getElementById('vll').value+"_"+id_cat;}
		else if(obj=='srv') {id = document.getElementById('vll').value+"_"+document.getElementById('ctg_srv').value;}
		else if(obj=='rgm') {id = document.getElementById('vll').value+"_"+document.getElementById('rgm').value;}
		else if(obj=='hbr' || obj=='chm') {id = document.getElementById('vll').value+"_"+document.getElementById('rgm').value+"_"+document.getElementById('hbr').value;}
	}
	if(window.XMLHttpRequest) {eval('xmlhttp_vue_fll'+xhr+'=new XMLHttpRequest()');}
	else{eval('xmlhttp_vue_fll'+xhr+'=new ActiveXObject("Microsoft.XMLHTTP")');}
	eval('xmlhttp_vue_fll'+xhr).onreadystatechange=function() {
		if(eval('xmlhttp_vue_fll'+xhr).readyState==4) {
			if(eval('xmlhttp_vue_fll'+xhr).status==200) {
				if(document.getElementById("lst_"+obj)) {
					document.getElementById("lst_"+obj).innerHTML=eval('xmlhttp_vue_fll'+xhr).responseText;
					heightovery("lst_"+obj);
					heightmrgtp(document.getElementById("lst_"+obj).parentNode.id);
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

function loadScript() {
	var script = document.createElement("script");
	script.type = "text/javascript";
	script.src = "https://maps.googleapis.com/maps/api/js?key=AIzaSyBuXaGEpXzsBNlbuHyX-WCm7QkXtPj1LKs&callback=vue_map_init";
	document.body.appendChild(script);
}

function vue_map_init(dir) {
	lat = document.getElementById(cbl_cat+'_lat'+id_cat).value;
	lon = document.getElementById(cbl_cat+'_lon'+id_cat).value;
	var myLatLng = new google.maps.LatLng(lat,lon);
	var mapOptions = {zoom: 13, center: myLatLng, mapTypeId: google.maps.MapTypeId.ROADMAP}
	var map = new google.maps.Map(document.getElementById('map'), mapOptions);
	var marker = new google.maps.Marker({position: myLatLng, map: map, icon: '../prm/img/0-dot.png'});
	google.maps.event.addListener(map, "click", function(event) {
		var lat = event.latLng.lat();
		var lon = event.latLng.lng();
		maj("cat_"+cbl_cat,"lat",lat,id_cat);
		maj("cat_"+cbl_cat,"lon",lon,id_cat);
		vue_map_LatLng(marker,lat,lon);
	});
	if((cbl_cat=='vll' || cbl_cat=='lieu' || cbl_cat=='hbr') && lat==0 && lon==0) {
		if(typeof dir === 'undefined') {dir = document.getElementById("nom_"+cbl_cat).value;}
		if(document.getElementById("nom_vll")) {dir += ','+document.getElementById("nom_vll").value;}
		if(document.getElementById("nom_pays")) {dir += ','+document.getElementById("nom_pays").value;}
		vue_map_address(dir);
	}
}

function vue_map_address(dir) {
	var geocoder = new google.maps.Geocoder();
	alt(dir);
	geocoder.geocode({'address': dir},function(results, status) {
		if(status == google.maps.GeocoderStatus.OK) {
			var mapOptions = {zoom: 13, center: results[0].geometry.location, mapTypeId: google.maps.MapTypeId.ROADMAP}
			var map = new google.maps.Map(document.getElementById("map"), mapOptions);
			var marker = new google.maps.Marker({map: map, position: results[0].geometry.location, icon: '../prm/img/0-dot.png'});
			maj("cat_"+cbl_cat,"lat",results[0].geometry.location.lat(),id_cat);
			maj("cat_"+cbl_cat,"lon",results[0].geometry.location.lng(),id_cat);
			google.maps.event.addListener(map, "click", function(event) {
				var lat = event.latLng.lat();
				var lon = event.latLng.lng();
				maj("cat_"+cbl_cat,"lat",lat,id_cat);
				maj("cat_"+cbl_cat,"lon",lon,id_cat);
				vue_map_LatLng(marker,lat,lon);
			});
		}
		else{alt('Geocode was not successful for the following reason: ' + status);}
	});
}

function vue_map() {
	lat = document.getElementById(cbl_cat+'_lat'+id_cat).value;
	lon = document.getElementById(cbl_cat+'_lon'+id_cat).value;
	var myLatLng = new google.maps.LatLng(lat,lon);
	var mapOptions = {zoom: 13, center: myLatLng, mapTypeId: google.maps.MapTypeId.ROADMAP}
	var map = new google.maps.Map(document.getElementById('map'), mapOptions);
	var marker = new google.maps.Marker({position: myLatLng, map: map, icon: '../prm/img/0-dot.png'});
	google.maps.event.addListener(map, "click", function(event) {
		var lat = event.latLng.lat();
		var lon = event.latLng.lng();
		maj("cat_"+cbl_cat,"lat",lat,id_cat);
		maj("cat_"+cbl_cat,"lon",lon,id_cat);
		vue_map_LatLng(marker,lat,lon);
	});
}

function vue_map_LatLng(marker,lat,lon) {
	var myLatLng = new google.maps.LatLng(lat,lon);
	marker.setPosition(myLatLng);
	google.maps.event.addListener(map, "click", function(event) {
		var lat = event.latLng.lat();
		var lon = event.latLng.lng();
		var zoom = map.getZoom();
		maj("cat_"+cbl_cat,"lat",lat,id_cat);
		maj("cat_"+cbl_cat,"lon",lon,id_cat);
		vue_map_LatLng(marker,lat,lon);
	});
}

function loadScript_noevent() {
	var script = document.createElement("script");
	script.type = "text/javascript";
	script.src = "https://maps.googleapis.com/maps/api/js?key=AIzaSyBuXaGEpXzsBNlbuHyX-WCm7QkXtPj1LKs&callback=vue_map_init_noevent";
	document.body.appendChild(script);
}

function vue_map_init_noevent() {
	lat = document.getElementById(cbl_cat+'_lat'+id_cat).value;
	lon = document.getElementById(cbl_cat+'_lon'+id_cat).value;
	var myLatLng = new google.maps.LatLng(lat,lon);
	var mapOptions = {zoom: 13, center: myLatLng, mapTypeId: google.maps.MapTypeId.ROADMAP}
	var map = new google.maps.Map(document.getElementById('map'), mapOptions);
	var marker = new google.maps.Marker({position: myLatLng, map: map, icon: '../prm/img/0-dot.png'});
}
