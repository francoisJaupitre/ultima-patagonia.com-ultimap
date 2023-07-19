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
	else{addFrame(link);}
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
	if($("#"+ref).length){closeFrame(ref);}
	event.stopPropagation();
}

function sup_frm(link,event){
	var ref = escape(link);
	if($("#"+ref).length){
		var iframe = $("#"+ref)[0];
		if(navonLine){
			if(checkIframe){
				if(typeof iframe.contentWindow.richTxtCheck === 'function'
					&& !iframe.contentWindow.richTxtCheck()
					&& !box("?","Some richtext has not been saved. Continue closure?",function(){closeFrame(ref)})
				){
					return;
				/*	"chk_frm": {
				    "fr": "TEXTE(S) NON SAUVEGARDE(S)!&#xA;Quitter sans sauver?",
				    "es": "TEXTO(S) SIN GUARDAR!&#xA;Cerrar sin guardar?"
				  }				*/
				}
				if(typeof iframe.contentWindow.upd != 'undefined' && iframe.contentWindow.upd>0){setTimeout(function(){sup_frm(ref,event);return;},50);}
				else{setTimeout(closeFrame(ref),50);return;}
			}
			else{
				alert("fermer avec erreur");
				closeFrame(ref);
			}
		}
		else{
			var msg = "Richtext not saved will be lost if you close now!<br/>If you got a red message, you should wait for being online and make a new change on the same field to update it.<br/>Close anyway?";
			box("You are offline!",msg,function(){closeFrame(ref);},function(){if(typeof iframe.contentWindow.upd != 'undefined'){iframe.contentWindow.upd = 0;}});
		}
	}
	if(typeof event !== 'undefined') {event.stopPropagation();}
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

var editMail = () => {
	const emailMessage = document.getElementById("emailMessage")
	const loader = document.getElementById(`ld_${emailMessage.id}`)
	loader.style.display='block'
	tinymce.remove(`#${emailMessage.id}`)
	tinymce.init({
		entity_encoding : "raw",
		forced_root_block : "",
		selector: `#${emailMessage.id}`,
		inline: true,
		fixed_toolbar_container: `#tool_${emailMessage.id}`,
		resize: true,
		plugins: "textcolor paste",
		paste_auto_cleanup_on_paste : true,
		paste_word_valid_elements: "b,strong,i,em,u",
		paste_preprocess : (pl, o) => { o.content = stripTags( o.content,'<b><strong><i><em><u>') },
		toolbar: 'undo redo | bold italic underline | backcolor',
		toolbar_location: 'bottom',
		textcolor_rows: "3",
		textcolor_map: [
			"FFFF00", "Yellow",
			"7FFF00", "Light Green",
			"00FFFF", "Cyan",
			"FF00FF", "Magenta",
			"0000FF", "Blue",
			"FF0000", "Red",
			"00008B", "Dark Blue",
			"008B8B", "Dark Cyan",
			"008000", "Dark Green",
			"8B008B", "Dark Magenta",
			"A52100", "Dark Red",
			"808000", "Dark Yellow",
			"808080", "Dark Gray",
			"BFBFBF", "Light Gray",
			"000000", "Black",
		],
		menubar: false,
		setup : (elem) => {
			elem.on('init', (e) => {
				loader.style.display = 'none'
				elem.execCommand('mceFocus', true, emailMessage.id)
			})
		},
	})
	emailMessage.onclick = null
}
