var old_frm = new Array('acc'), navonLine = true;
window.addEventListener('online', function(e) {console.log('online');navonLine = true;});
window.addEventListener('offline', function(e) {console.log('offline');navonLine = false;});
window.onbeforeunload = function (evt) {
	var message = 'You are about to close Ultimap!';
	if(typeof evt == 'undefined'){evt = window.event;}
	if (evt){evt.returnValue = message;}
	return message;
}

function add(id_lng){
	$.ajax({url: 'add.php', type: 'post', data: {"id_lng":id_lng},
		success: function(){parent.window.location.reload();},
		error: function (request, status, error){
			add(id_lng);
			console.log('ADD ERROR: '+request.statusText);
		}
	});
}

function vue_frm(ref,scrl){
	hid_frm(ref);
	shw_frm(ref,scrl);
	$('.chk_tab').not($('#li_'+ref).parent().siblings()).prop('checked', false);

}

function hid_frm(ref){
	if(!ref || $("#"+ref).length){
		$(".frm").each( function() {
			$(this).hide();
		});
		$(".li_tab").each( function() {
			$(this).attr({class: "li_hid"});
		});
		$(".span_ttr").each( function() {
			$(this).attr({class: "li_hid"});
		});
	}
}

function shw_frm(ref,scrl){
	if($("#"+ref).length){
		if(ref=='acc'){old_frm.splice(0,old_frm.length,ref);}
		else{
			for(var i = 0; i < old_frm.length; i++){
				if(old_frm[i] === ref){
					old_frm.splice(i, 1);
					i--;
				}
			}
			old_frm.push(ref);
		}
		$("#"+ref).show();
		$("#"+ref).focus();
		if(typeof scrl != 'undefined'){
			var iframe = $("#"+ref)[0];
			if(typeof iframe.contentWindow.scrollprs === 'function'){iframe.contentWindow.scrollprs(scrl);}
		}
		$("#li_"+ref).attr({class: "li_tab"});
		if(ref.substr(4,3)=='dev'){
			if(ref.indexOf('id_lgg')==-1){var ref_id = ref.substr(4);}
			else{var ref_id = ref.substr(4,ref.indexOf('id_lgg')-4);}
			$("#ttr_"+ref_id).attr({class: "li_tab"});
		}
		else if(ref.substr(0,3)=='cmp' || ref.substr(0,3)=='fin' || ref.substr(0,3)=='ope'){
			var ref_id = ref.substr(0,3);
			$("#ttr_"+ref_id).attr({class: "li_tab"});
		}
		else if(ref.substr(0,3)=='cat'){
			var ref_id = ref.substr(0,9);
			$("#ttr_"+ref_id).attr({class: "li_tab"});
		}
	}
}

function opn_frm(link){
	if(link.indexOf('scrl')!=-1){var ref = escape(link.substr(0,link.indexOf('scrl')));}
	else{var ref = escape(link);}
	if($("#"+ref).length){
		if(link.indexOf('scrl') == -1) {vue_frm(ref);}
		else {vue_frm(ref,link.substr(link.indexOf('scrl')+5));}
	}
	else{ajt_frm(link);}
}

function ajt_frm(link){
	if(link.indexOf('scrl')!=-1){var ref = escape(link.substr(0,link.indexOf('scrl')));}
	else{var ref = escape(link);}
	var frm_num = 0;
	if(ref.substr(0,3)=='grp'){
		//chercher les devis et les afficher côte à côte.
	}
	if(ref.substr(4,3)=='dev'){
		if(ref.indexOf('id_lgg')==-1){var ref_id = ref.substr(4);}
		else{var ref_id = ref.substr(4,ref.indexOf('id_lgg')-4);}
		var frm_lst = [];
		$(".frm").each(function(){
			if($(this).attr("id").indexOf('id_lgg')==-1){var frm_id = $(this).attr("id").substr(4);}
			else{var frm_id = $(this).attr("id").substr(4,$(this).attr("id").indexOf('id_lgg')-4);}
			if(ref_id == frm_id){
				frm_num++;
				frm_lst.push($(this).attr("id"));
			}
		});
	}
	else if(ref.substr(0,3)=='cmp' || ref.substr(0,3)=='fin' || ref.substr(0,3)=='ope'){
		var ref_id = ref.substr(0,3);
		var frm_lst = [];
		$(".frm").each(function(){
			var frm_id = $(this).attr("id").substr(0,3);
			if(ref_id == frm_id){
				frm_num++;
				frm_lst.push($(this).attr("id"));
			}
		});
	}
	else if(ref.substr(0,3)=='cat'){
		var ref_id = ref.substr(0,9);
		var frm_lst = [];
		$(".frm").each(function(){
			var frm_id = $(this).attr("id").substr(0,9);
			if(ref_id == frm_id){
				frm_num++;
				frm_lst.push($(this).attr("id"));
			}
		});
	}
	if(frm_num == 0){
		var htm = "<img style='vertical-align: middle;' src='prm/img/loader.gif' /> <span id='img_"+ref+"'><img style='vertical-align: middle;' src='prm/img/cls.png' /></span>";
		var li = $('<li ></li>').addClass("li_tab").attr({id: "li_"+ref, onclick: "vue_frm('"+ref+"');"}).html(htm).appendTo('#ul_tab');
		$("#img_"+ref).attr({onclick: "sup_frm_nobug('"+ref+"',event);"});
	}
	else if(frm_num == 1){
		var nom = $("#li_"+frm_lst[0]).html();
		if(nom.substr(0,4)!='<img'){
			if(ref.substr(4,3)=='dev'){
				var nom1 = nom.substr(nom.indexOf(":")+2,nom.indexOf("<span id=")-nom.indexOf(":")-2);
				var nom2 = nom.substr(0,nom.indexOf(":"));
			}
			else if(ref.substr(0,3)=='cmp' || ref.substr(0,3)=='fin' || ref.substr(0,3)=='ope'){
				var nom2 = nom.substr(nom.indexOf(":")+2,nom.indexOf("<span id=")-nom.indexOf(":")-2);
				var nom1 = nom.substr(0,nom.indexOf(":"));
			}
			else if(ref.substr(0,3)=='cat'){
				var nom2 = nom.substr(nom.indexOf(":")+2,nom.indexOf("<span id=")-nom.indexOf(":")-2);
				if(window.XMLHttpRequest){xhttp=new XMLHttpRequest();}
				else{xhttp=new ActiveXObject("Microsoft.XMLHTTP");}
				xhttp.open("GET","txt_js.xml",false);
				xhttp.send();
				xmlDoc=xhttp.responseXML;
				x=xmlDoc.getElementsByTagName(nom.substr(0,nom.indexOf(":")));
				var nom1 = x[0].childNodes[0].nodeValue;
			}
			var htm = "<input type='checkbox' id='chk_"+ref_id+"' class='chk_tab'/><label for='chk_"+ref_id+"'><span id='ttr_"+ref_id+"' class='span_ttr'><span id='img_"+ref_id+"'><img style='vertical-align: middle;' src='prm/img/sup.png' /></span> "+nom1+"</span></label><ul id='ul_ttr"+ref_id+"' class='ul_tab'></ul>";
			var li = $('<li ></li>').addClass("li_ttr").attr({id: "li_ttr"+ref_id}).html(htm);
			$("#li_"+frm_lst[0]).before(li);
			$("#img_"+ref_id).attr({onclick: "sup_frm_nobug('"+frm_lst[0]+"',event);sup_frm_nobug('"+ref+"',event);"});
			var htm = nom2;
			$("#li_"+frm_lst[0]).remove();
			htm += "<span id='img_"+frm_lst[0]+"'><img style='vertical-align: middle;' src='prm/img/cls.png' /></span>";
			var li = $('<li ></li>').addClass("li_hid").attr({id: "li_"+frm_lst[0], onclick: "vue_frm('"+frm_lst[0]+"');"}).html(htm).appendTo('#ul_ttr'+ref_id);
			$("#img_"+frm_lst[0]).attr({onclick: "sup_frm_nobug('"+frm_lst[0]+"',event);"});
			var htm = "<img style='vertical-align: middle;' src='prm/img/loader.gif' /> <span id='img_"+ref+"'><img style='vertical-align: middle;' src='prm/img/cls.png' /></span>";
			var li = $('<li ></li>').addClass("li_tab").attr({id: "li_"+ref, onclick: "vue_frm('"+ref+"');"}).html(htm).appendTo('#ul_ttr'+ref_id);
			$("#img_"+ref).attr({onclick: "sup_frm_nobug('"+ref+"',event);"});
		}
		else{return;}
	}
	else{
		var htm = "<img style='vertical-align: middle;' src='prm/img/loader.gif' /> <span id='img_"+ref+"'><img style='vertical-align: middle;' src='prm/img/cls.png' /></span>";
		var li = $('<li ></li>').addClass("li_tab").attr({id: "li_"+ref, onclick: "vue_frm('"+ref+"');"}).html(htm).appendTo('#ul_ttr'+ref_id);
		$("#img_"+ref).attr({onclick: "sup_frm_nobug('"+ref+"',event);"});
		$("#img_"+ref_id).attr({onclick: $("#img_"+ref_id).attr("onclick")+"sup_frm_nobug('"+ref+"',event);"});
	}
	hid_frm();
	var iframe = $('<iframe ></iframe>').addClass("frm").attr({id: ref, src: link}).appendTo('#dt_frm');
	shw_frm(ref);
}

function act_tab(link,nom){
	var ref = escape(link);
	if($("#li_"+ref).length){
		nom = decodeURIComponent(nom);
		if($("#li_"+ref).parent().parent().hasClass("li_ttr")){
			if(ref.substr(4,3)=='dev'){
				if(ref.indexOf('id_lgg')==-1){var ref_id = ref.substr(4);}
				else{var ref_id = ref.substr(4,ref.indexOf('id_lgg')-4);}
				nom = nom.substr(0,nom.indexOf(":"));
			}
			else if(ref.substr(0,3)=='cmp' || ref.substr(0,3)=='fin' || ref.substr(0,3)=='ope'){
				var ref_id = ref.substr(0,3);
				nom = nom.substr(nom.indexOf(":")+2);
			}
			else if(ref.substr(0,3)=='cat'){
				var ref_id = ref.substr(0,9);
				nom = nom.substr(nom.indexOf(":")+2);
			}
		}
		$("#li_"+ref).html(nom+" <span id='img_"+ref+"'><img style='vertical-align: middle;' src='prm/img/cls.png' /></span>");
		$("#img_"+ref).attr({onclick: "sup_frm('"+ref+"',event);"});
	/*	$("#li_hid"+ref_id).html(nom+" <span><img src='prm/img/cls.png' /></span>");*/
	}
}

function sup_frm_nobug(link,event){
	var ref = escape(link);
	if($("#"+ref).length){close(ref);}
	event.stopPropagation();
}

function sup_frm(link,event){
	var ref = escape(link);
	if($("#"+ref).length){
		var iframe = $("#"+ref)[0];
		if(navonLine){
			if(checkIframe){
				if(typeof iframe.contentWindow.richTxtInit === 'function' && !iframe.contentWindow.richTxtInit()){return;}
				if(typeof iframe.contentWindow.upd != 'undefined' && iframe.contentWindow.upd>0){setTimeout(function(){sup_frm(ref,event);return;},50);}
				else{setTimeout(close(ref),50);return;}
			}
			else{
				alert("fermer avec erreur");
				close(ref);
			}
		}
		else{
			var msg = "Richtext not saved will be lost if you close now!<br/>If you got a red message, you should wait for being online and make a new change on the same field to update it.<br/>Close anyway?";
			box("You are offline!",msg,function(){close(ref);},function(){if(typeof iframe.contentWindow.upd != 'undefined'){iframe.contentWindow.upd = 0;}});
		}
	}
	if(typeof event !== 'undefined') {event.stopPropagation();}
}

function close(ref){
	var frm_num = 0;
	if($("#li_"+ref).parent().parent().hasClass("li_ttr")){
		if(ref.substr(4,3)=='dev'){
			if(ref.indexOf('id_lgg')==-1){var ref_id = ref.substr(4);}
			else{var ref_id = ref.substr(4,ref.indexOf('id_lgg')-4);}
			var frm_lst = [];
			$(".frm").each(function(){
				if(ref != $(this).attr("id")){
					if($(this).attr("id").indexOf('id_lgg')==-1){var frm_id = $(this).attr("id").substr(4);}
					else{var frm_id = $(this).attr("id").substr(4,$(this).attr("id").indexOf('id_lgg')-4);}
					if(ref_id == frm_id){
						frm_num++;
						frm_lst.push($(this).attr("id"));
					}
				}
			});
		}
		else if(ref.substr(0,3)=='cmp' || ref.substr(0,3)=='fin' || ref.substr(0,3)=='ope'){
			var ref_id = ref.substr(0,3);
			var frm_lst = [];
			$(".frm").each(function(){
				if(ref != $(this).attr("id")){
					var frm_id = $(this).attr("id").substr(0,3);
					if(ref_id == frm_id){
						frm_num++;
						frm_lst.push($(this).attr("id"));
					}
				}
			});
		}
		else if(ref.substr(0,3)=='cat'){
			var ref_id = ref.substr(0,9);
			var frm_lst = [];
			$(".frm").each(function(){
				if(ref != $(this).attr("id")){
					var frm_id = $(this).attr("id").substr(0,9);
					if(ref_id == frm_id){
						frm_num++;
						frm_lst.push($(this).attr("id"));
					}
				}
			});
		}
	}
	if(frm_num == 1){
		var nom1 = $("#li_"+frm_lst[0]).html();
		var nom2 = $("#ttr_"+ref_id).html();
		var pos = nom2.indexOf('</span>');
		var len = nom2.length;
		if(ref.substr(4,3)=='dev'){
			var htm = nom1.substr(0,nom1.indexOf('<span id='))+': '+nom2.substr(pos,len);
		}
		else if(ref.substr(0,3)=='cmp' || ref.substr(0,3)=='fin' || ref.substr(0,3)=='ope'){
			var htm = nom2.substr(pos)+' '+nom1.substr(0,nom1.indexOf('<span id='));
		}
		else if(ref.substr(0,3)=='cat'){
			if(window.XMLHttpRequest){xhttp=new XMLHttpRequest();}
			else{xhttp=new ActiveXObject("Microsoft.XMLHTTP");}
			xhttp.open("GET","txt_js.xml",false);
			xhttp.send();
			xmlDoc=xhttp.responseXML;
			x=xmlDoc.getElementsByTagName(nom2.substr(pos+8,len-8));
			var htm = x[0].childNodes[0].nodeValue+': '+nom1.substr(0,nom1.indexOf('<span id='));
		}
		var previd = $("#li_ttr"+ref_id).prev().attr('id');
		$("#li_"+frm_lst[0]).remove();
		$("#li_ttr"+ref_id).remove();
/*		$("#li_hid"+ref_id).remove();*/
		htm += "<span id='img_"+frm_lst[0]+"'><img style='vertical-align: middle;' src='prm/img/cls.png' /></span>";
		var li = $('<li ></li>').addClass("li_hid").attr({id: "li_"+frm_lst[0], onclick: "vue_frm('"+frm_lst[0]+"');"}).html(htm);
		$("#"+previd).after(li);
		$("#img_"+frm_lst[0]).attr({onclick: "sup_frm_nobug('"+frm_lst[0]+"',event);"});
	}
	if($("#li_"+ref).length){$("#li_"+ref).remove();}
	if($("#"+ref).length){
		$("#"+ref).remove();
		for(var i = 0; i < old_frm.length; i++){
			if(old_frm[i] === ref){
				old_frm.splice(i, 1);
				i--;
			}
		}
		shw_frm(old_frm[old_frm.length-1]);
	}
}

function act_frm(cbl){
	$(".frm").each( function() {
		var iframe = $(this)[0];
		if(iframe.contentWindow.act_frm){iframe.contentWindow.act_frm(cbl);}
	});
}

function toggleFullScreen(){
	if((document.fullScreenElement && document.fullScreenElement !== null) || (!document.mozFullScreen && !document.webkitIsFullScreen)){
		if(document.documentElement.requestFullScreen){document.documentElement.requestFullScreen();}
		else if(document.documentElement.mozRequestFullScreen){document.documentElement.mozRequestFullScreen();}
		else if(document.documentElement.webkitRequestFullScreen){document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);}
	}
	else{
		if(document.cancelFullScreen){document.cancelFullScreen();}
		else if(document.mozCancelFullScreen){document.mozCancelFullScreen();}
		else if(document.webkitCancelFullScreen){document.webkitCancelFullScreen();}

	}
}

function lstn_fs(){
	document.addEventListener('webkitfullscreenchange', chg_fs, false);
  document.addEventListener('mozfullscreenchange', chg_fs, false);
  document.addEventListener('fullscreenchange', chg_fs, false);
}

function chg_fs(){
	if((document.fullScreenElement && document.fullScreenElement !== null) || (!document.mozFullScreen && !document.webkitIsFullScreen)){
		$("#li_fs").css("color", "black");
		$("#li_fs").css("background-color", "white");
	}
	else{
		$("#li_fs").css("color", "white");
		$("#li_fs").css("background-color", "black");
	}
}

function logout(){
	window.onbeforeunload = null;
	$.ajax({url: 'logout.php', type: 'post'});
}

function escape(link){
	var ref = link.replace('?','');
	ref = ref.replace('.','');
	ref = ref.replace('/','');
	ref = ref.replace(/&|=/g,'');
	ref = ref.replace(/&|=/g,'');
	ref = ref.replace('fctvue_trfphp','trf_dev');
	ref = ref.replace('devctrphp','dev_dev');
	ref = ref.replace('fctvue_prgphpcbl','prg_');
	ref = ref.replace('fctvue_rbkphp','rbk_dev');
	ref = ref.replace('ctrphp','');
	return ref;
}

function box(ttl,msg,y,n) {
	$('<div></div>').appendTo('body')
		.html('<div><h5>'+msg+'</h5></div>')
		.dialog({
			modal: true, title: ttl, zIndex: 10000, autoOpen: true,
			width: 'auto', resizable: false,
  		buttons: {
      	Yes: function(){$(this).dialog("close"); y(); return true;},
    		No: function(){$(this).dialog("close");	if ($.isFunction(n)){n();}; return false;}
			},
  		close: function (event, ui) {$(this).remove();}
		});
}

function checkIframe( ifr ) {
    var key = ( +new Date ) + "" + Math.random();
    try {
        var global = ifr.contentWindow;
        global[key] = "asd";
        return global[key] === "asd";
    }
    catch( e ) {
        return false;
    }
}

var alrttr;
function mel_unseen(unseen){
	clearInterval(alrttr);
	if(unseen==0){
		var txt='';
		document.title = 'U.L.T.I.M.A.P'
	}
	else{var txt='<span>'+unseen+'</span>';
	 	alrttr = setInterval(function(){
			document.title = unseen+' nouveau(x) mail(s)';
			setTimeout(function(){document.title = 'U.L.T.I.M.A.P'},2000);
		}, 4000);
	}
	$("#unseen").html(txt);
}
