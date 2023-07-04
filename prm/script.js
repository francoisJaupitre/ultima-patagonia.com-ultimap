//var cancel = false, timer,ld =/* ypos =*/ idpos = 0,flg_ld = {};

function auto_lst(cbl,obj,src,e){
	if(typeof e !== 'undefined' && (e.keyCode==13 || (e.keyCode>=37 && e.keyCode<=40))){mov_lst(obj,e);}
	else{fll_lst(cbl,obj,src);}
}

function mov_lst(obj,e){
	tch = e.keyCode;
	if(tch==13 && !do_lst(obj)){tch = 39;}
	if(tch==38){
		if($('#enter_'+obj).prev("li").length){
			$('#enter_'+obj).prev("li").attr("id","new_enter_"+obj);
			$('#enter_'+obj).removeAttr('style');
			$('#enter_'+obj).removeAttr('id');
			$('#new_enter_'+obj).attr("id","enter_"+obj);
			$('#enter_'+obj).attr("style","background-color: Chocolate");
			while($('#enter_'+obj).position().top - $('#enter_'+obj).parent().parent().scrollTop() - $('#enter_'+obj).parent().position().top < 0){$('#enter_'+obj).parent().parent().scrollTop($('#enter_'+obj).parent().parent().scrollTop()-1);}
		}
	}
	else if(tch==40){
		if($('#enter_'+obj).next("li").length){
			$('#enter_'+obj).next("li").attr("id","new_enter_"+obj);
			$('#enter_'+obj).removeAttr('style');
			$('#enter_'+obj).removeAttr('id');
			$('#new_enter_'+obj).attr("id","enter_"+obj);
			$('#enter_'+obj).attr("style","background-color: Chocolate");
			if(typeof $('#enter_'+obj).parents("li").parent().position() != 'undefined'){
				while($('#enter_'+obj).position().top - $('#enter_'+obj).parents("li").parent().parent().scrollTop() - $('#enter_'+obj).parents("li").parent().position().top + $('#enter_'+obj).outerHeight() > $('#enter_'+obj).parents("li").parent().parent().outerHeight()){$('#enter_'+obj).parents("li").parent().parent().scrollTop($('#enter_'+obj).parents("li").parent().parent().scrollTop()+1);}
			}
			else{
				while($('#enter_'+obj).position().top - $('#enter_'+obj).parent().parent().scrollTop() - $('#enter_'+obj).parent().position().top + $('#enter_'+obj).outerHeight() > $('#enter_'+obj).parent().parent().outerHeight()){$('#enter_'+obj).parent().parent().scrollTop($('#enter_'+obj).parent().parent().scrollTop()+1);}
			}
		}
	}
	else if(tch==39){
		if($('#enter_'+obj).find("li").length){
			$($('#enter_'+obj).find("li")[0]).attr("id","new_enter_"+obj);
			if($('#enter_'+obj).find("ul").css('display')=='none'){
				$('#enter_'+obj).find("span").click();
				$('#enter_'+obj).find("ul").addClass("open");
			}
			$('#enter_'+obj).removeAttr('style');
			$('#enter_'+obj).removeAttr('id');
			$('#new_enter_'+obj).attr("id","enter_"+obj);
			$('#enter_'+obj).attr("style","background-color: Chocolate");
			while($('#enter_'+obj).position().top - $('#enter_'+obj).parents("li").parent().parent().scrollTop() - $('#enter_'+obj).parents("li").parent().position().top + $('#enter_'+obj).outerHeight() > $('#enter_'+obj).parents("li").parent().parent().outerHeight()){$('#enter_'+obj).parents("li").parent().parent().scrollTop($('#enter_'+obj).parents("li").parent().parent().scrollTop()+1);}
		}
	}
	else if(tch==37){
		if($('#enter_'+obj).parents("li").length){
			$('#enter_'+obj).parents("li").attr("id","new_enter_"+obj);
			if($('#new_enter_'+obj).find("ul").css('display')=='block'){
				$('#new_enter_'+obj).find("span").click();
				$('#new_enter_'+obj).find("ul").removeClass("open");
			}
			$('#enter_'+obj).removeAttr('style');
			$('#enter_'+obj).removeAttr('id');
			$('#new_enter_'+obj).attr("id","enter_"+obj);
			$('#enter_'+obj).attr("style","background-color: Chocolate");
			while($('#enter_'+obj).position().top - $('#enter_'+obj).parent().parent().scrollTop() - $('#enter_'+obj).parent().position().top < 0){$('#enter_'+obj).parent().parent().scrollTop($('#enter_'+obj).parent().parent().scrollTop()-1);}
		}
	}
}

function fll_lst(cbl,obj,src){
    clearTimeout(timer);
    timer = setTimeout(function () {
      vue_fll(cbl,obj,src);
    }, 16);
}

function do_lst(obj){
	if(document.getElementById('enter_'+obj)){
		if(document.getElementById('enter_'+obj).click()){return true;}
		else{return false;}
	}
}
/*
function load(xhr,unld){
	if(xhr) {var org = xhr.replace(/\s/g, "");}
	else{var org = 0;}
	if(unld == true){
		flg_ld[org] = true;
		return;
	}
	if(typeof flg_ld[org] === 'undefined' || flg_ld[org] == true){
		flg_ld[org] = false;
		if(ld==0){
			document.getElementById('shadowing').style.display='block';
			disableScroll();
		}
		ld++;
	}
}

function unload(xhr,id){
	if(xhr) {var org = xhr.replace(/\s/g, "");}
	else{var org = 0;}
	console.log(xhr,id,org)
	if(typeof flg_ld[org] === 'undefined' || flg_ld[org] == false){
		if(org=='scroll'){
			cancel = true;
			idpos = id;
		}
		else if(ld>0){
			ld--;
		}
		if(org != 'scroll' && ld == 0){
			document.getElementById('shadowing').style.display = 'none';
			enableScroll();
			if(cancel == true){
				cancel = false;
				$('html,body').animate({scrollTop: $("#vue_ttr_jrn_"+idpos).offset().top-10},'slow');
				console.log(org+" unload #vue_ttr_jrn_"+idpos);
			}
		}
		flg_ld[org] = true;
		load(xhr,true);
	}
}*/

function vue_cmd(id){
	if($("#"+id).css('display') == 'block'){$("#"+id).stop(true,true).slideUp();}
	else{
		$("#"+id).css('margin-top',0);
		var cmds = document.getElementsByClassName('cmd');
		for(var i = 0; i < cmds.length; i++){
			if(cmds[i].id != $("#"+id).attr('id')){$("#"+cmds[i].id).css('visibility','hidden');}
			else{$("#"+id).css('visibility','visible');}
		}
		var cmds2 = document.getElementsByClassName('cmd2');
		for(var i = 0; i < cmds2.length; i++){
			if(cmds2[i].id != $("#"+id).attr('id')){$("#"+cmds2[i].id).css('visibility','hidden');}
			else{$("#"+id).css('visibility','visible');}
		}
		$("#"+id).stop(true,true).slideDown();
		if(document.getElementById("ipt_"+id)){
			document.getElementById("ipt_"+id).focus();
			$("#"+id).click(function(){$("#ipt_"+id).focus();});
			}
		if(document.getElementById(id)){
			if(document.getElementById(id).children.length>1){
				var c = document.getElementById(id).children;
				if(document.getElementById(c[1].id)){heightovery(c[1].id);}
			}
		}
		if($("#"+id).hasClass("wsn")){
			heightmrgtp(id);
			setTimeout(function(){
				$("#"+id).hover(function(){
					$(this).mouseleave(function(){
						$(this).stop(true,true).slideUp();
						$(this).off();
					});
				});
			},100);
		}
		else if($("#"+id).hasClass("mw200")){heightscrll(id);}

		setTimeout(function(){
			var cmds = document.getElementsByClassName('cmd');
			for(var i = 0; i < cmds.length; i++){
				if(cmds[i].id != $("#"+id).attr('id')){
					if(cmds[i].style.display = 'none'){
						cmds[i].style.marginTop = '0px';
						cmds[i].style.right = 'auto';
						if(cmds[i].children.length>1){
							c = document.getElementById(cmds[i].id).children;
							c[1].style.height = "auto";
							c[1].style.overflowY= "auto";
						}
					}
				}
			}
		},400);
	}
}

function heightovery(id){
	if(document.getElementById(id).scrollHeight>200){
		document.getElementById(id).style.height = "200px";
		document.getElementById(id).style.overflowY= "scroll";
	}
	else{
		document.getElementById(id).style.height = "auto";
		document.getElementById(id).style.overflowY = "auto";
	}
}

function heightmrgtp(id){
	var rect = document.getElementById(id).getBoundingClientRect();
	if(rect.right > $(window).width()){document.getElementById(id).style.right = '0';}
	var hght = document.getElementById(id).scrollHeight;
	setTimeout(function(){
		if(document.getElementById(id)){
			rect = document.getElementById(id).getBoundingClientRect();
			if($("#"+id).is(':hover') === false && rect.bottom > $(window).height() && rect.top > hght){
				hght += 25;
				document.getElementById(id).style.marginTop = '-'+hght+'px';
			}
		}
	},400);
}

function heightscrll(id){
	setTimeout(function(){
		if(document.getElementById(id)){
			var hght = document.getElementById(id).scrollHeight, rect = document.getElementById(id).getBoundingClientRect();
			var px = rect.bottom - $(window).height();
			if(px > 0 && rect.top > hght){window.scrollBy(0,px);}
		}
	},400);
}

function vue_cmd_ul(id,id_sup){
	if(!$("#"+id).hasClass('open') && $("#"+id).css('display')=='block'){$("#"+id).attr("style", "display:none");}
	else{
		$("."+id_sup).each(function(i,obj){
			if(!$(obj).hasClass('open')){$(obj).attr("style", "display:none");}
		});
		$("#"+id).attr("style", "display:block");
	}
}

$(document).on("keydown", function (e) {
    if (e.which === 8 && !$(e.target).is("input, textarea") && !$(e.target).hasClass('rich')) {
        e.preventDefault();
    }
});

// Prevent the backspace key from navigating back.
$(document).unbind('keydown').bind('keydown', function (event) {
    if (event.keyCode === 8) {
        var doPrevent = true;
        var types = ["text", "password", "file", "search", "email", "number", "date", "color", "datetime", "datetime-local", "month", "range", "search", "tel", "time", "url", "week"];
        var d = $(event.srcElement || event.target);
        var disabled = d.prop("readonly") || d.prop("disabled");
        if (!disabled) {
            if (d[0].isContentEditable) {
                doPrevent = false;
            } else if (d.is("input")) {
                var type = d.attr("type");
                if (type) {
                    type = type.toLowerCase();
                }
                if (types.indexOf(type) > -1) {
                    doPrevent = false;
                }
            } else if (d.is("textarea")) {
                doPrevent = false;
            }
        }
        if (doPrevent) {
            event.preventDefault();
            return false;
        }
    }
});

// left: 37, up: 38, right: 39, down: 40,
// spacebar: 32, pageup: 33, pagedown: 34, end: 35, home: 36
var keys = {37: 1, 38: 1, 39: 1, 40: 1};

function preventDefault(e) {
  e = e || window.event;
  if (e.preventDefault)
      e.preventDefault();
  e.returnValue = false;
}

function preventDefaultForScrollKeys(e) {
    if (keys[e.keyCode]) {
        preventDefault(e);
        return false;
    }
}

function disableScroll() {
  if (window.addEventListener) // older FF
      window.addEventListener('DOMMouseScroll', preventDefault, false);
  document.addEventListener('wheel', preventDefault, {passive: false}); // Disable scrolling in Chrome
  window.onwheel = preventDefault; // modern standard
  window.onmousewheel = document.onmousewheel = preventDefault; // older browsers, IE
  window.ontouchmove  = preventDefault; // mobile
  document.onkeydown  = preventDefaultForScrollKeys;
}

function enableScroll() {
    if (window.removeEventListener)
        window.removeEventListener('DOMMouseScroll', preventDefault, false);
    document.removeEventListener('wheel', preventDefault, {passive: false}); // Enable scrolling in Chrome
    window.onmousewheel = document.onmousewheel = null;
    window.onwheel = null;
    window.ontouchmove = null;
    document.onkeydown = null;
}

function alt(msg){
	var sh = $('#alert')[0].scrollHeight;
	$('<div></div>').appendTo('#alert')
		.html("<table><tr><td style='width:100%'>"+msg.replace(/\n/g,"<br>")+"</td><td style='vertical-align: bottom;' onclick='$(this).parent().parent().parent().parent().hide();cls_alt();'><img src='../prm/img/sup.png'></td></tr><tr><td colspan='2'><hr/><td/></tr></table>");
	$('#alert').slideDown();
	var th = 0;
	$("#alert").children().each(function(){
	    th = th + $(this).outerHeight(true);
	});
	if(th<150){$("#alert").css('height', th + "px");}
	else{$("#alert").css('height',"150px");}
	if(sh>150){$('#alert').scrollTop(sh);}
}

function cls_alt(){
	if($("#alert").width()<10){$('#alert').hide();}
}
