setInterval(vue_map, 40000);

function init(){
	unload('mel');
	resize();
	resize2();
	if(typeof $("#unseen").val() != 'undefined'){window.parent.mel_unseen($("#unseen").val());}
}

var xhr_map = null;
function vue_map(){
	var li_sel = $(".li_sel").first().attr("id");
	if(typeof li_sel == 'undefined'){li_sel = 'li_0';}
	var li_map = 'li_0';
	$(".li_opn").each(function(){
		li_map += '|'+$(this).attr("id");
	});
	var sel_mel, sel_fol;
	var sel_box = $("#sel_box").val();
	var sel_uid = $("#sel_uid").val();
	xhr_map = $.ajax({url: 'vue_map.php', type: 'post', data: {"li_sel":li_sel,"li_map":encodeURI(li_map),"sel_box":sel_box,"sel_uid":sel_uid},
		success: function(responseText){
			if(responseText){$("#vue_map").html(responseText);} //evite le probleme d'affichage click recibiendo?
			sel_mel = $("#sel_mel").val();
			sel_fol = $("#sel_fol").val();
			sel_box = $("#sel_box").val();
			sel_uid = $("#sel_uid").val();
			if($("#src_mel").length != 0){
				if($("#src_mel").val().length >0){vue_src(id_mel,box,sel_uid);}
				else if(sel_mel.length!=0 && sel_box.length!=0){vue_dt_box(sel_mel,sel_box,sel_fol);}
			}
			window.parent.mel_unseen($("#unseen").val());
		}
	});
}

var xhr_src = null;
function vue_src(id_mel,box,sel_uid){
	$("#vue_dt_box").html('');
	xhr_map.abort();
	var src_mel = $("#src_mel").val();
	$("#src_mel").css('background-color','yellow');
	xhr_src = $.ajax({url: 'vue_src.php', type: 'post', data: {"src_mel":src_mel,"id_mel":id_mel,"box":box,"sel_uid":sel_uid},
		beforeSend : function(){
			if(xhr_src != null){xhr_src.abort();}
		},
		success: function(responseText){
			if(sel_uid != $("#sel_uid").val()){vue_lec(0,0,0);}
			var rt = responseText.split("||");
			$("#vue_dt_box").html(rt[0]);
			var unseen = rt[1].split("|");
			for(var i = 0; i < unseen.length; i++){
				if(unseen[i]>0){$("#seen"+unseen[i]).show();}
			}
			var flagged = rt[2].split("|");
			for(var i = 0; i < flagged.length; i++){
				if(flagged[i]>0){$("#flag"+flagged[i]).show();}
			}
			resize();
		}
	});
}

function vue_fold(id_mel,ul_id){
	if($('#'+id_mel+'_'+ul_id).is(":visible")) {
		$('#'+id_mel+'_'+ul_id).stop(true,true).slideUp();
		$('#span'+id_mel+'_'+ul_id).html('&#9658;');
		$(".span_map").removeClass("li_opn");
	}
	else{
		$('#'+id_mel+'_'+ul_id).stop(true,true).slideDown();
		$('#span'+id_mel+'_'+ul_id).html('&#9660;');
		$('#span'+id_mel+'_'+ul_id).addClass("li_opn");
	}
}

function vue_box(id_mel,box,fol){
	$("#vue_dt_box").html('');
	$("#sel_fol").val(fol);
	$("#sel_box").val(box);
	$(".li_map").css("background-color","");
	$(".li_map").removeClass("li_sel");
	$("#li_"+id_mel+'_'+fol).css("background-color","darkgray");
	$("#li_"+id_mel+'_'+fol).addClass("li_sel");
	$.ajax({url: 'vue_box.php', type: 'post', data: {"id_mel":id_mel,"box":box,"fol":fol},
		success: function(responseText){
			vue_lec(id_mel,box,0);
			var rt = responseText.split("||");
			$("#vue_box").html(rt[0]);
			var unseen = rt[1].split("|");
			for(var i = 0; i < unseen.length; i++){
				if(unseen[i]>0){$("#seen"+unseen[i]).show();}
			}
			var flagged = rt[2].split("|");
			for(var i = 0; i < flagged.length; i++){
				if(flagged[i]>0){$("#flag"+flagged[i]).show();}
			}
			resize();
			$(".nocache").each(function(){
				vue_body(id_mel,box,$(this).attr("id").substring(3));
			});
			if(document.getElementById("txtHint").innerHTML.includes("CONNECTION ERROR")){document.getElementById("txtHint").innerHTML="";}
		},
		error: function (request, status, error){
			vue_box(id_mel,box,fol);
			$("#txtHint").html("<span style='background: red;'>CONNECTION ERROR</span>");console.log('VUE_BOX ERROR: '+request.statusText);
		}
	});
}

var xhr_dt_box = null;
function vue_dt_box(id_mel,box,fol){
	$("#sel_fol").val(fol);
	$("#sel_box").val(box);
	$(".li_map").css("background-color","");
	$(".li_map").removeClass("li_sel");
	$("#li_"+id_mel+'_'+fol).css("background-color","darkgray");
	$("#li_"+id_mel+'_'+fol).addClass("li_sel");
	if($("#src_mel").val().length==0){$("#src_mel").css('background-color','gainsboro');}
	var sel_uid = $("#sel_uid").val();
	var src_mel = $("#src_mel").val();
	xhr_dt_box = $.ajax({url: 'vue_dt_box.php', type: 'post', data: {"id_mel":id_mel,"box":box,"fol":fol,"sel_uid":sel_uid,"src_mel":src_mel},
		success: function(responseText){
			var rt = responseText.split("||");
			$("#vue_dt_box").html(rt[0]);
			var unseen = rt[1].split("|");
			for(var i = 0; i < unseen.length; i++){
				if(unseen[i]>0){$("#seen"+unseen[i]).show();}
			}
			var flagged = rt[2].split("|");
			for(var i = 0; i < flagged.length; i++){
				if(flagged[i]>0){$("#flag"+flagged[i]).show();}
			}
			resize();
			$(".nocache").each(function(){
				vue_body(id_mel,box,$(this).attr("id").substring(3));
			});
			//if(document.getElementById("txtHint").innerHTML.includes("CONNECTION ERROR")){document.getElementById("txtHint").innerHTML="";}
		},
		//error: function (request, status, error){$("#txtHint").html("<span style='background: red;'>CONNECTION ERROR</span>");console.log('VUE_DT_BOX ERROR: '+request.statusText);}
	});
}

function resize(){
	var isResizing = false,
	lastDownX = 0;
	$(function(){
		var container = $('#container'),
		left = $('#vue_map'),
		right = $('#vue_mel'),
		handle = $('#drag');
		handle.on('mousedown', function (e){
			isResizing = true;
			lastDownX = e.clientX;
		});
		$(document).on('mousemove', function (e) {
			// we don't want to do anything if we aren't resizing.
			if (!isResizing) return;
			var offsetRight = container.width() - (e.clientX - container.offset().left);
			left.css('right', offsetRight);
			right.css('width', offsetRight);
		}).on('mouseup', function (e) {isResizing = false;});
	});
}

function vue_body(id_mel,box,uid){
	$.ajax({url: 'vue_body.php', type: 'post', data: {"id_mel":id_mel,"box":box,"uid":uid},
		success: function(responseText){
			$("#tb_"+uid).html(responseText);
			src_uf(id_mel,box);
			if(document.getElementById("txtHint").innerHTML.includes("CONNECTION ERROR")){document.getElementById("txtHint").innerHTML="";}
		},
		error: function (request, status, error){
			vue_body(id_mel,box,uid),
			$("#txtHint").html("<span style='background: red;'>CONNECTION ERROR</span>");console.log('VUE_BODY ERROR: '+request.statusText);
		}
	});
}


function src_uf(id_mel,box){
	$.ajax({url: 'src_uf.php', type: 'post', data: {"id_mel":id_mel,"box":box},
		success: function(responseText){
			var uid = responseText.split("||");
			var unseen = uid[0].split("|");
			for(var i = 0; i < unseen.length; i++){
				if(unseen[i]>0){$("#seen"+unseen[i]).show();}
			}
			var flagged = uid[1].split("|");
			for(var i = 0; i < flagged.length; i++){
				if(flagged[i]>0){$("#flag"+flagged[i]).show();}
			}
		},
		error: function (request, status, error){
			src_uf(id_mel,box);
			$("#txtHint").html("<span style='background: red;'>SRC_UF ERROR</span>");console.log('SRC_UF ERROR: '+request.statusText);
		}
	});
}

var newDev
function vue_lec(id_mel,box,uid){
	$("#vue_lec").html('');
	$(".tb_box").css("background-color","");
	$("#tb_"+uid).css("background-color","gainsboro");
	$("#sel_uid").val(uid);
	$.ajax({url: 'vue_lec.php', type: 'post', data: {"id_mel":id_mel,"box":box,"uid":uid},
		success: function(responseText){
			$("#vue_lec").html(responseText);
			$("#seen"+uid).hide();
			resize2();
			vue_body(id_mel,box,uid);
			newDev = document.getElementById("newDev")
			if(document.getElementById("adDev"))
				document.getElementById("adDev").onclick = () => { addDev(newDev) }
		},
		error: function (request, status, error){
			vue_lec(id_mel,box,uid);
			$("#txtHint").html("<span style='background: red;'>vue_lec ERROR</span>");console.log('vue_lec ERROR: '+request.statusText);
		}
	});
}

function resize2(){
	var isResizing2 = false,
	lastDownX2 = 0;
	$(function(){
		var container2 = $('#vue_mel'),
		left2 = $('#vue_box'),
		right2 = $('#vue_lec'),
		handle2 = $('#drag2');
		handle2.on('mousedown', function (e){
			isResizing2 = true;
			lastDownX2 = e.clientX;
		});
		$(document).on('mousemove', function (e) {
			// we don't want to do anything if we aren't resizing.
			if (!isResizing2) return;
			var offsetRight2 = container2.width() - (e.clientX - container2.offset().left);
			left2.css('right', offsetRight2);
			right2.css('width', offsetRight2);
		}).on('mouseup', function (e) {isResizing2 = false;});
	});
}

function resizeIframe(obj){
	obj.style.height = obj.contentWindow.document.documentElement.scrollHeight + 'px';
	$(obj).contents().find('img').css({'max-width': '-moz-available'});
	$(obj).contents().find('img').dblclick(function(){
		window.open($(this).attr('src'));
	});
}

function opn(link){
	var windowSize = "width=" + window.innerWidth + ",height=" + window.innerHeight + ",scrollbars=no";
	window.open(link, 'popup', windowSize).focus();
}

function flag(id_mel,box,uid){
	if($("#flag_dt").is(":visible")){var act = 1;}
	else{var act = 0;}
	var sel_fol = $("#sel_fol").val();
	$.ajax({url: 'flag.php', type: 'post', data: {"id_mel":id_mel,"box":box,"uid":uid,"act":act},
		success: function(responseText){
			if(act == 1){
				$("#flag"+uid).hide();
				$("#flag_dt").hide();
			}
			else{
				$("#flag"+uid).show();
				$("#flag_dt").show();
			}
		},
		error: function (request, status, error){
			flag(id_mel,box,uid);
			$("#txtHint").html("<span style='background: red;'>FLAG ERROR</span>");console.log('FLAG ERROR: '+request.statusText);
		}
	});
}

function del(id_mel,box,uid){
	var sel_fol = $("#sel_fol").val();
	$("#sel_uid").val(0);
	$.ajax({url: 'del.php', type: 'post', data: {"id_mel":id_mel,"box":box,"uid":uid},
		success: function(responseText){
			vue_lec(id_mel,box,0);
			if($("#src_mel").val().length >0){vue_src(id_mel,box,0);}
			else if(sel_mel.length!=0 && sel_box.length!=0){
				vue_dt_box(id_mel,box,sel_fol);
				vue_lec(id_mel,box,0);
			}
			vue_map();
		},
		error: function (request, status, error){
			del(id_mel,box,uid);
			$("#txtHint").html("<span style='background: red;'>DEL ERROR</span>");console.log('DEL ERROR: '+request.statusText);
		}
	});
}

function mov(id_mel,box,uid,fol){
	var sel_fol = $("#sel_fol").val();
	$("#sel_uid").val(0);
	$.ajax({url: 'mov.php', type: 'post', data: {"id_mel":id_mel,"box":box,"uid":uid,"fol":fol},
		success: function(responseText){
			vue_lec(id_mel,box,0);
			if($("#src_mel").val().length >0){vue_src(id_mel,box,0);}
			else if(sel_mel.length!=0 && sel_box.length!=0){
				vue_dt_box(id_mel,box,sel_fol);
				vue_lec(id_mel,box,0);
			}
			vue_map();
		},
		error: function (request, status, error){
			mov(id_mel,box,uid,fol);
			$("#txtHint").html("<span style='background: red;'>MOV ERROR</span>");console.log('MOV ERROR: '+request.statusText);
		}
	});
}

function cop(id_mel,box,uid,id_mel2,box2){
	$.ajax({url: 'cop.php', type: 'post', data: {"id_mel":id_mel,"box":box,"uid":uid,"id_mel2":id_mel2,"box2":box2},
		success: function(responseText){
			if(responseText=='1'){vue_map();}
			else{alert('ERROR!');}
		},
		error: function (request, status, error){
			cop(id_mel,box,uid,id_mel2,box2);
			$("#txtHint").html("<span style='background: red;'>COP ERROR</span>");console.log('COP ERROR: '+request.statusText);
		}
	});
}

function ajt_ctc(url) {
	$.ajax({url: '../fct/ajt_ctc.php', type: 'post', data: {"url":url},
		success: function() {
			parent.window.frames[0].vue_menu('acc');
			parent.window.frames[0].vue_lst('acc','crm');
			parent.window.vue_frm('acc');
		},
		error: function (request, status, error) {
			ajt_ctc(url);
			$("#txtHint").html("<span style = 'background: red;'>ERROR</span>");console.log('AJT_CTC ERROR: '+request.statusText);
		}
	});
}

/*function ajt_dev(url){
	if (window.XMLHttpRequest){xmlhttp=new XMLHttpRequest();}
	else{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4){
			if(xmlhttp.status==200){
				var rsp = xmlhttp.responseText.split("||");
				window.parent.act_frm('grp');
				window.parent.act_frm('clt');
				var ids = rsp[0].split("|");
				$.each(ids, function($key,id) {
					window.parent.opn_frm('dev/ctr.php?id='+id);
				});
				parent.window.frames[0].vue_lst('dev');
				if(rsp[1]!=''){alt(rsp[1]);}
				if(rsp[2]!=''){alt(rsp[2]);}
			}
			else if(xmlhttp.status==408){ajt_dev(url);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR AJT_DEV "+xmlhttp.statusText+" </span>";}
			unload('ajt_dev');
		}
	}
	xmlhttp.open("POST","../fct/ajt_dev.php",true);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlhttp.send("url="+url);
}*/
