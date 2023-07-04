function maj(tab,col,val,id){
	$.ajax({url: 'maj.php',type: 'post',data: {"tab":tab,"col":col,"val":encodeURIComponent(val),"id":id},
		/*success: function(){
			if($("#txtHint:contains('SAVE ERROR')")){$("#txtHint").html("");}
		},*/
		error: function (request,status,error){
			maj(col,val,id);
			/*$("#txtHint").html("<span style='background: red;'>SAVE ERROR</span>");*/console.log('SAVE ERROR: '+request.statusText);
		}
	});
}

function act_tab(obj,id,cbl,id_lgg){
	$.ajax({url: 'nom_tab.php',type: 'post',data: {"obj":obj,"id":id,"cbl":cbl},
	success: function(responseText){
		if(obj == 'trf'){window.parent.act_tab('fct/vue_trf.php?id='+id,responseText);}
		else if(obj == 'prg'){window.parent.act_tab('fct/vue_prg.php?cbl='+cbl+'&id='+id+'&id_lgg='+id_lgg,responseText);}
		else if(obj == 'rbk'){window.parent.act_tab('fct/vue_rbk.php?id='+id+'&id_lgg='+id_lgg,responseText);}
		},
		error: function (request,status,error){
			act_tab(obj,id,cbl,id_lgg);
			/*$("#txtHint").html("<span style='background: red;'>ACT_TAB ERROR</span>");*/console.log('ACT_TAB ERROR: '+request.statusText);
		}
	});
}

function vue_dt_prg(cbl,id,id_lgg){
	load('FCT vue_dt_prg');
	$.ajax({url: 'vue_dt_prg.php',type: 'post',data: {"cbl":cbl,"id":id,"id_lgg":id_lgg},
		success: function(responseText){
			$("#vue_dt_prg").html(responseText);
			unload('FCT vue_dt_prg');
		},
		error: function (request,status,error){
			vue_dt_prg(cbl,id,id_lgg);
			$("#txtHint").html("<span style='background: red;'>VUE_DT_PRG ERROR</span>");console.log('VUE_DT_PRG ERROR: '+request.statusText);
		}
	});
}

function ajt_vol(id_crc,id_v1,id_v2,obj,val){
	load('FCT ajt_vol');
	$.ajax({url: 'ajt_vol.php',type: 'post',data: {"id_crc":id_crc,"id_v1":id_v1,"id_v2":id_v2,"obj":obj,"val":val},
		success: function(responseText){
			if(id_v1==0 && id_v2==0){
				document.getElementById('totvol').onchange = undefined;
				$('#totvol').change(function(){maj('dev_vol','trf',this.value,responseText);});
			}
			else{
				document.getElementById('X'+id_v1+'_'+id_v2).onchange = undefined;
				document.getElementById('C'+id_v1+'_'+id_v2).onchange = undefined;
				$('#X'+id_v1+'_'+id_v2).change(function(){maj('dev_vol','trf',this.value,responseText);});
				$('#C'+id_v1+'_'+id_v2).change(function(){maj('dev_vol','cpp',this.value,responseText);});
				if(obj=='trf'){maj('dev_vol','cpp',$('#C'+id_v1+'_'+id_v2).val(),responseText);}
			}
			unload('FCT ajt_vol');
		},
		error: function (request,status,error){
			ajt_vol(id_crc,id_v1,id_v2,obj,val)
			$("#txtHint").html("<span style='background: red;'>AJT_VOL ERROR</span>");console.log('AJT_VOL ERROR: '+request.statusText);
		}
	});
}

function maj_html(cbl,id,id_lgg,val,id_ipt){
	load('FCT maj_html');
	$.ajax({url: 'ttr_html.php',type: 'post',data: {"cbl":cbl,"id":id,"id_lgg":id_lgg},
		success: function(responseText){
			$.ajax({url: 'maj_html.php',type: 'post',data: {"ttr":responseText,"val":val,"id":id_ipt}});
			unload('FCT maj_html');
		},
		error: function (request,status,error){
			maj_html(cbl,id,id_lgg,val,id_ipt);
			$("#txtHint").html("<span style='background: red;'>MAJ_HTML ERROR</span>");console.log('MAJ_HTML ERROR: '+request.statusText);
		}
	});
}

function pdf_prg(cbl,id,id_lgg){
	load('FCT pdf_prg');
	$.ajax({url: 'ttr_html.php',type: 'post',data: {"cbl":cbl,"id":id,"id_lgg":id_lgg},
		success: function(responseText){
			window.open('pdf_prg.php?ttr='+responseText);
			unload('FCT pdf_prg');},
		error: function (request,status,error){
			pdf_prg(cbl,id,id_lgg);
			$("#txtHint").html("<span style='background: red;'>PDF_PRG ERROR</span>");console.log('PDF_PRG ERROR: '+request.statusText);
		}
	});
}

function vue_map(dir){
	var lst = document.getElementById('lst_map').value.split("|");
	$.each(lst,function(key,id_prs){
		var latlon = document.getElementById('latlon'+id_prs).value.split("|");
		if(latlon.length > 1){
			var mapOptions = {mapTypeId: google.maps.MapTypeId.ROADMAP}
			var map = new google.maps.Map(document.getElementById('map'+id_prs),mapOptions);
			var directionsService = new google.maps.DirectionsService();
			var waypts = [];
			for(var i = 1; i < latlon.length - 1; i++){waypts.push({location: latlon[i],stopover: false});}
			var request = {
					origin: latlon[0],
					waypoints: waypts,
					destination: latlon[latlon.length - 1],
					provideRouteAlternatives: true,
					avoidTolls: true,
					travelMode: google.maps.DirectionsTravelMode.DRIVING,
					unitSystem: google.maps.UnitSystem.METRIC
			};

			directionsService.route(request,function(response,status){
				if(status  ==  google.maps.DirectionsStatus.OK){vue_dt_map(dir,id_prs,response);}
				else{
					console.log('essai1: '+status+' id:'+id_prs);
					setTimeout( function () {
						var mapOptions = {mapTypeId: google.maps.MapTypeId.ROADMAP}
						var map = new google.maps.Map(document.getElementById('map'+id_prs),mapOptions);
						var directionsService = new google.maps.DirectionsService();
						var waypts = [];
						for(var i = 1; i < latlon.length - 1; i++){waypts.push({location: latlon[i],stopover: false});}
						var request = {
								origin: latlon[0],
								waypoints: waypts,
								destination: latlon[latlon.length - 1],
								provideRouteAlternatives: true,
								avoidTolls: true,
								travelMode: google.maps.DirectionsTravelMode.DRIVING,
								unitSystem: google.maps.UnitSystem.METRIC
						};
						directionsService.route(request,function(response,status){
							if(status  ==  google.maps.DirectionsStatus.OK){vue_dt_map(dir,id_prs,response);}
							else{alert('Could not display track due to: '+status+' / origin:'+request['origin']+' waypoints:'+request['waypoints']+' destination:'+request['destination']);}
						});

					}, 10000 );
				}
			});
		}
	});
}

function vue_dt_map(dir,id_prs,response){
	var
		col1 = ['blue','green','purple','gray','orange','red','white','black','brown','yellow'],
		col2 = ['yellow','blue','green','orange','purple','red'],
		alphas = String.fromCharCode(...[...Array('Z'.charCodeAt(0) - 'A'.charCodeAt(0) + 1).keys()].map(i => i + 'A'.charCodeAt(0)));
		len = (response.routes.length),
		lnk = "https://maps.googleapis.com/maps/api/staticmap?size=650x400",
		n = 0,
		htm = "";
	for(var i = 0; i < len; i++){
		if(n > 9){n = 0;}
		lnk += "&path=color:"+col1[n]+"|enc:"+response.routes[i].overview_polyline;
		var mt = parseFloat(response.routes[i].legs[0].distance.value);
		if(mt > 0){
			var s = parseFloat(response.routes[i].legs[0].duration.value);
			var h = Math.floor(s / 3600);
			s -= h*3600;
			var mi = Math.floor(s / 60); //Get remaining minutes
			if(h > 0){var dur = h + "h" + ("0" + mi).slice(-2);}
			else{var dur = mi + " min.";}
			if(i == 0){htm = '<span style="text-decoration: underline">Temps de parcours:</span><br />';}
			if(len > 1){htm += '<span style="color: '+col1[n]+'">Route '+(i + 1)+': </span>';}
			htm += (mt / 1000).toFixed(0)+' km. / '+dur+'<br />';
		}
		n++;
		//console.log( JSON.stringify(response.routes[i].overview_polyline));
	}
	if(htm.length){
		$('#rsm' + id_prs).append(htm); //puis majhtml pour export rbk a pdf
		htm = htm.substring(0, htm.length - 6);
		$.ajax({url: 'sav_rsm.php',type: 'post',data: {"html":encodeURIComponent(htm),"id":id_prs}});
	}
	var ia = n = 0;
	var lat = document.getElementById('lat'+id_prs).value.split("|");
	var lon = document.getElementById('lon'+id_prs).value.split("|");
	var len = (lat.length);
	for(var i = 0; i < len; i++){
		if(n > 5){n = 0;}
		if(ia > 25){ia = 0;}
		lnk += '&markers=color:'+col2[n]+'|label:'+alphas[ia]+'|';
		lnk += parseFloat(lat[i]).toFixed(3)+','+parseFloat(lon[i]).toFixed(3);
		ia++;
		n++;
	}
	lnk += "&mode=driving&key="+googleAPIKey;
//	console.log(lnk);
	$.ajax({url: 'sav_map.php',type: 'post',data: {"url":encodeURIComponent(lnk),"id":id_prs},
		success: function(){
			$("#img"+id_prs).attr('src',"../tmp/"+dir+'/map_rbk_prs'+id_prs+'.jpeg');
			//puis majhtml pour export rbk a pdf
		}
	});
}
