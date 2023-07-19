var flg_dt_cat = flg_dt_dev = flg_dt_grp = rang = 1;

function vue_menu(cbl,sub) {
	load('ACC vue_menu');
	$.ajax({url: 'vue_menu.php', type: 'post', data: {"cbl":cbl,"sub":sub},
		success: function(responseText) {
			$("#vue_menu").html(responseText);
			$(".sub").hide();
			$(document).ready(function() {
				$("#main_dev").click(function() {
					var sub = $('#sub').val();
					if(sub != 'cnf') {$("#sub_cnf").stop(true,true).slideUp();}
					if(sub != 'grp') {$("#sub_grp").stop(true,true).slideUp();}
					if(sub != 'cat') {$("#sub_cat").stop(true,true).slideUp();}
					$("#sub_ope").stop(true,true).slideUp();
					$("#sub_cmp").stop(true,true).slideUp();
					$("#sub_fin").stop(true,true).slideUp();
					$("#sub_dev").stop(true,true).slideDown();
				});
				$("#main_cnf").click(function() {
					var sub = $('#sub').val();
					if(sub != 'dev') {$("#sub_dev").stop(true,true).slideUp();}
					if(sub != 'grp') {$("#sub_grp").stop(true,true).slideUp();}
					if(sub != 'cat') {$("#sub_cat").stop(true,true).slideUp();}
					$("#sub_ope").stop(true,true).slideUp();
					$("#sub_cmp").stop(true,true).slideUp();
					$("#sub_fin").stop(true,true).slideUp();
					$("#sub_cnf").stop(true,true).slideDown();
				});
				$("#main_grp").click(function() {
					var sub = $('#sub').val();
					if(sub != 'dev') {$("#sub_dev").stop(true,true).slideUp();}
					if(sub != 'cnf') {$("#sub_cnf").stop(true,true).slideUp();}
					if(sub != 'cat') {$("#sub_cat").stop(true,true).slideUp();}
					$("#sub_ope").stop(true,true).slideUp();
					$("#sub_cmp").stop(true,true).slideUp();
					$("#sub_fin").stop(true,true).slideUp();
					$("#sub_grp").stop(true,true).slideDown();
				});
				$("#main_cat").click(function() {
					var sub = $('#sub').val();
					if(sub != 'dev') {$("#sub_dev").stop(true,true).slideUp();}
					if(sub != 'cnf') {$("#sub_cnf").stop(true,true).slideUp();}
					if(sub != 'grp') {$("#sub_grp").stop(true,true).slideUp();}
					$("#sub_ope").stop(true,true).slideUp();
					$("#sub_cmp").stop(true,true).slideUp();
					$("#sub_fin").stop(true,true).slideUp();
					$("#sub_cat").stop(true,true).slideDown();
				});
				$("#main_ope").click(function() {
					var sub = $('#sub').val();
					if(sub != 'dev') {$("#sub_dev").stop(true,true).slideUp();}
					if(sub != 'cnf') {$("#sub_cnf").stop(true,true).slideUp();}
					if(sub != 'grp') {$("#sub_grp").stop(true,true).slideUp();}
					if(sub != 'cat') {$("#sub_cat").stop(true,true).slideUp();}
					$("#sub_cmp").stop(true,true).slideUp();
					$("#sub_fin").stop(true,true).slideUp();
					$("#sub_ope").stop(true,true).slideDown();
				});
				$("#main_cmp").click(function() {
					var sub = $('#sub').val();
					if(sub != 'dev') {$("#sub_dev").stop(true,true).slideUp();}
					if(sub != 'cnf') {$("#sub_cnf").stop(true,true).slideUp();}
					if(sub != 'grp') {$("#sub_grp").stop(true,true).slideUp();}
					if(sub != 'cat') {$("#sub_cat").stop(true,true).slideUp();}
					$("#sub_ope").stop(true,true).slideUp();
					$("#sub_fin").stop(true,true).slideUp();
					$("#sub_cmp").stop(true,true).slideDown();
				});
				$("#main_fin").click(function() {
					var sub = $('#sub').val();
					if(sub != 'dev') {$("#sub_dev").stop(true,true).slideUp();}
					if(sub != 'cnf') {$("#sub_cnf").stop(true,true).slideUp();}
					if(sub != 'grp') {$("#sub_grp").stop(true,true).slideUp();}
					if(sub != 'cat') {$("#sub_cat").stop(true,true).slideUp();}
					$("#sub_ope").stop(true,true).slideUp();
					$("#sub_cmp").stop(true,true).slideUp();
					$("#sub_fin").stop(true,true).slideDown();
				});
				if(sub == 'dev') {$("#sub_dev").css("display", "block");}
				if(sub == 'cnf') {$("#sub_cnf").css("display", "block");}
				if(sub == 'grp') {$("#sub_grp").css("display", "block");}
				if(sub == 'cat') {$("#sub_cat").css("display", "block");}
			});
			unload('ACC vue_menu');
			$("#txtHint").html("");
		},
		error: function (request, status, error) {
			vue_menu(cbl,sub);
			$("#txtHint").html("<span style='background: red;'>ERROR</span>");console.log('VUE_MENU ERROR: '+request.statusText);
		}
	});
}

function vue_lst(cbl,cbl2) {
	if(cbl == $('#cbl').val() && cbl != 'acc' && cbl != 'pay' && cbl != 'cfg') {
		if(cbl == 'gr0' || cbl == 'gr1')
			vue_grp(cbl)
		else if(cbl != 'dev' && cbl != 'arc' && cbl != 'cnf' && cbl != 'fin')
			vue_cat(cbl)
		else
			vue_dev(cbl)
		return
	}
	load('ACC vue_lst')
	$.ajax({url: 'vue_lst.php', type: 'post', data: {"cbl":cbl},
		success: function(responseText) {
			window.scrollTo(0,0);
			$("#vue_lst").html(responseText);
			rang = 1;
			if(cbl == 'dev' || cbl == 'arc' || cbl == 'cnf' || cbl == 'fin') {flg_dt_dev = 1;}
			else if(cbl == 'crc' || cbl == 'mdl' || cbl == 'jrn' || cbl == 'prs' || cbl == 'srv' || cbl == 'hbr' || cbl == 'clt' || cbl == 'frn' || cbl == 'pic' || cbl == 'rgn' || cbl == 'vll' || cbl == 'lieu' || cbl == 'bnq') {flg_dt_cat = 1;}
			else if(cbl == 'gr0' || cbl == 'gr1') {flg_dt_grp = 1;}
			else if(cbl == 'acc' && typeof cbl2 !== "undefined") {vue_acc(cbl2);}
			else if(cbl == 'acc' && $("#"+cbl).length) {vue_acc($("#"+cbl).val());}
			unload('ACC vue_lst');
			$("#txtHint").html("")
			//vue_cat
			if(document.getElementById("addElem")) {
				const catElem = document.getElementById("addElem")
				catElem.onclick = () => { addElem(catElem.id) }
			}
			//vue_dev
			if(document.getElementById("addDev"))
				document.getElementById("addDev").onclick = () => { addElem('dev',0) }
			if(document.getElementById("archiveElems"))
				document.getElementById("archiveElems").onclick = () => { multiArchiveElem(cbl) }
			//vue_dev vue_grp
			if(document.getElementById("deleteElems"))
				document.getElementById("deleteElems").onclick = () => { multiDeleteElem(cbl) }
			//vue_grp
			if(document.getElementById("addGrp"))
				document.getElementById("addGrp").onclick = () => { addElem('grp',0) }
			const ulCmd = document.getElementsByClassName("ul-cmd")
			for(let item of ulCmd)
			{
				if(item.querySelector(".add-dev"))
					item.querySelector(".add-dev").onclick = () => { addElem('dev', item.id) } //vue_dt_cat
				if(item.querySelector(".copy-elem"))
					item.querySelector(".copy-elem").onclick = () => { copyElem(cbl, item.id) } //vue_dt_cat vue_dt_dev
				if(item.querySelector(".delete-elem"))
					item.querySelector(".delete-elem").onclick = () => { deleteElem(cbl, item.id) } //vue_dt_cat vue_dt_dev
				if(item.querySelector(".new-vrs"))
					item.querySelector(".new-vrs").onclick = () => { newVersion(item.id) } //vue_dt_dev
				if(item.querySelector(".archive-elem"))
					item.querySelector(".archive-elem").onclick = () => { archiveElem(cbl, item.id) } //vue_dt_dev
				if(item.querySelector(".cancel-confirmation"))
					item.querySelector(".cancel-confirmation").onclick = () => { cancelConfirmation(item.id) } //vue_dt_dev
			}
			const tdCmd = document.getElementsByClassName("delete-elem2")
			for(let item of tdCmd)
				item.onclick = () => { deleteElem(cbl, item.id) } //vue_dt_cat vue_dt_grp
		},
		error: function (request, status, error) {
			vue_lst(cbl);
			$("#txtHint").html("<span style='background: red;'>ERROR</span>");console.log('VUE_LST ERROR: '+request.statusText);
		}
	});
}

function vue_acc(cbl) {
	load('ACC vue_acc');
	$.ajax({url: 'vue_acc.php', type: 'post', data: {"cbl":cbl},
		success: function(responseText) {
			window.scrollTo(0,0);
			$("#vue_acc").html(responseText);
			unload('ACC vue_acc');
			$("#txtHint").html("");
		},
		error: function (request, status, error) {
			vue_acc(cbl);
			$("#txtHint").html("<span style='background: red;'>ERROR</span>");console.log('VUE_ACC ERROR: '+request.statusText);
		}
	});
}

function vue_cat(cbl,obj,id) {
	var clt, rgn, vll, ctg, pays, flt, web;
	if(cbl == 'crc') {clt = $("#clt").val();}
	if(cbl == 'mdl' || cbl == 'pic' || cbl == 'vll') {rgn = $("#rgn").val();}
	if(cbl == 'jrn' || cbl == 'prs' || cbl == 'srv' || cbl == 'hbr' || cbl == 'frn' || cbl == 'lieu') {vll = $("#vll").val();}
	if(cbl == 'prs' || cbl == 'srv' || cbl == 'hbr' || cbl == 'frn') {ctg = $("#ctg").val();}
	if(cbl == 'bnq') {pays = $("#pays").val();}
	if(cbl == 'crc' || cbl == 'mdl' || cbl == 'jrn' || cbl == 'prs' || cbl == 'srv' || cbl == 'hbr' || cbl == 'clt' || cbl == 'frn' || cbl == 'rgn' || cbl == 'vll' || cbl == 'lieu' || cbl == 'bnq') {flt = $("#flt").val();}
	if(cbl == 'crc' || cbl == 'mdl') {
 		if($('#web').is(':checked')) {web = 1;}
		else {web = 0;}
	}
	if(id != "undefined") {
		if(obj == 'clt') {clt = id;}
		else if(obj == 'rgn') {rgn = id;}
		else if(obj == 'vll') {vll = id;}
		else if(obj == 'ctg') {ctg = id;}
		else if(obj == 'pays') {pays = id;}
	}
	load('ACC vue_cat');
	$.ajax({url: 'vue_cat.php', type: 'post', data: {"cbl":cbl,"id_clt":clt,"id_vll":vll,"id_ctg":ctg,"id_rgn":rgn,"id_pays":pays,"flt":flt,"web":web},
		success: function(responseText) {
			window.scrollTo(0,0);
			if($("#vue_"+cbl).length > 0)
				$("#vue_"+cbl).html(responseText)
			rang = 1;
			flg_dt_cat = 1;
			unload('ACC vue_cat');
			$("#txtHint").html("");
			//vue_cat
			if(document.getElementById("addElem")) {
				const catElem = document.getElementById("addElem")
				catElem.onclick = () => { addElem(catElem.id) }
			}
			const ulCmd = document.getElementsByClassName("ul-cmd")
			for(let item of ulCmd)
			{
				if(item.querySelector(".add-dev"))
					item.querySelector(".add-dev").onclick = () => { addElem('dev', item.id) } //vue_dt_cat
				if(item.querySelector(".copy-elem"))
					item.querySelector(".copy-elem").onclick = () => { copyElem(cbl, item.id) } //vue_dt_cat
				if(item.querySelector(".delete-elem"))
					item.querySelector(".delete-elem").onclick = () => { deleteElem(cbl, item.id) } //vue_dt_cat
			}
			const tdCmd = document.getElementsByClassName("delete-elem2")
			for(let item of tdCmd)
				item.onclick = () => { deleteElem(cbl, item.id) } //vue_dt_cat
		},
		error: function (request, status, error) {
			vue_cat(cbl,obj,id);
			$("#txtHint").html("<span style='background: red;'>ERROR</span>");console.log('VUE_CAT ERROR: '+request.statusText);
		}
	});
}

function vue_dt_cat(cbl) {
	var clt, rgn, vll, ctg, pays, flt, web;
	if(cbl == 'crc') {clt = $("#clt").val();}
	if(cbl == 'mdl' || cbl == 'pic' || cbl == 'vll') {rgn = $("#rgn").val();}
	if(cbl == 'jrn' || cbl == 'prs' || cbl == 'srv' || cbl == 'hbr' || cbl == 'frn' || cbl == 'lieu') {vll = $("#vll").val();}
	if(cbl == 'prs' || cbl == 'srv' || cbl == 'hbr' || cbl == 'frn') {ctg = $("#ctg").val();}
	if(cbl == 'bnq') {pays = $("#pays").val();}
	if(cbl == 'crc' || cbl == 'mdl' || cbl == 'jrn' || cbl == 'prs' || cbl == 'srv' || cbl == 'hbr' || cbl == 'clt' || cbl == 'frn' || cbl == 'rgn' || cbl == 'vll' || cbl == 'lieu' || cbl == 'bnq') {flt = $("#flt").val();}
	if(cbl == 'crc' || cbl == 'mdl') {web = $("#web").val();}
	if(flg_dt_cat == 1) {
		flg_dt_cat = 0;
		rang++;
		load('ACC vue_dt_cat');
		$.ajax({url: 'vue_dt_cat.php', type: 'post', data: {"rang":rang,"cbl":cbl,"id_clt":clt,"id_vll":vll,"id_ctg":ctg,"id_rgn":rgn,"id_pays":pays,"flt":flt,"web":web},
			success: function(responseText) {
				if(responseText != '0') {
					var arr_dt_cat = responseText.split("|");
					$.each(arr_dt_cat, function(key,data) {
						if(data != '') {
							var dt_cat = data.split("$$");
							var tr_dt_cat = $('<tr></tr>').attr({id: dt_cat[0]}).html(dt_cat[1]).appendTo('#tab_cat');
						}
					});
					flg_dt_cat = 1;
				}
				unload('ACC vue_dt_cat');
				$("#txtHint").html("");
				const ulCmd = document.getElementsByClassName("ul-cmd")
				for(let item of ulCmd)
				{
					if(item.querySelector(".add-dev"))
						item.querySelector(".add-dev").onclick = () => { addElem('dev', item.id) } //vue_dt_cat
					if(item.querySelector(".copy-elem"))
						item.querySelector(".copy-elem").onclick = () => { copyElem(cbl, item.id) } //vue_dt_cat
					if(item.querySelector(".delete-elem"))
						item.querySelector(".delete-elem").onclick = () => { deleteElem(cbl, item.id) } //vue_dt_cat
				}
				const tdCmd = document.getElementsByClassName("delete-elem2")
				for(let item of tdCmd)
					item.onclick = () => { deleteElem(cbl, item.id) } //vue_dt_cat
			},
			error: function (request, status, error) {
				flg_dt_cat = 1;
				rang--;
				vue_dt_cat(cbl);
				$("#txtHint").html("<span style='background: red;'>ERROR</span>");console.log('VUE_DT_CAT ERROR: '+request.statusText);
			}
		});
	}
}

function vue_dev(cbl,obj,id) {
	var grp, clt;
	grp = $("#grp").val();
	clt = $("#clt").val();
	if(id != "undefined") {
		if(obj == 'grp') {
			grp = id;
			clt = 0;
		}
		else if(obj == 'clt') {
			clt = id;
			grp = 0;
		}
	}
	load('ACC vue_dev');
	$.ajax({url: 'vue_dev.php', type: 'post', data: {"cbl":cbl,"id_grp":grp,"id_clt":clt},
		success: function(responseText) {
			window.scrollTo(0,0);
			if($("#vue_"+cbl).length > 0) {$("#vue_"+cbl).html(responseText);}
			rang = 1;
			flg_dt_dev = 1;
			unload('ACC vue_dev');
			$("#txtHint").html("");
			//vue_dev
			if(document.getElementById("addDev"))
				document.getElementById("addDev").onclick = () => { addElem('dev',0) }
			if(document.getElementById("archiveElems"))
				document.getElementById("archiveElems").onclick = () => { multiArchiveElem(cbl) }
			//vue_dev
			if(document.getElementById("deleteElems"))
				document.getElementById("deleteElems").onclick = () => { multiDeleteElem(cbl) }
			const ulCmd = document.getElementsByClassName("ul-cmd")
			for(let item of ulCmd)
			{
				if(item.getElementsByClassName("copy-dev")[0])
					item.querySelector(".copy-elem").onclick = () => { copyElem(cbl, item.id) } //vue_dt_dev
				if(item.querySelector(".delete-elem"))
					item.querySelector(".delete-elem").onclick = () => { deleteElem(cbl, item.id) } //vue_dt_dev
				if(item.querySelector(".new-vrs"))
					item.querySelector(".new-vrs").onclick = () => { newVersion(item.id) } //vue_dt_dev
				if(item.querySelector(".archive-elem"))
					item.querySelector(".archive-elem").onclick = () => { archiveElem(cbl, item.id) }
				if(item.querySelector(".cancel-confirmation"))
					item.querySelector(".cancel-confirmation").onclick = () => { cancelConfirmation(item.id) } //vue_dt_dev
			}
		},
		error: function (request, status, error) {
			vue_dev(cbl,obj,id);
			$("#txtHint").html("<span style='background: red;'>ERROR</span>");console.log('VUE_DEV ERROR: '+request.statusText);
		}
	});
}

function vue_dt_dev(cbl) {
	var grp = $("#grp").val();
	var clt = $("#clt").val();
	if(flg_dt_dev == 1) {
		flg_dt_dev = 0;
		rang++;
		load('ACC vue_dt_dev');
		$.ajax({url: 'vue_dt_dev.php', type: 'post', data: {"rang":rang,"cbl":cbl,"id_grp":grp,"id_clt":clt},
			success: function(responseText) {
				if(responseText != '0') {
					var arr_dt_dev = responseText.split("|");
					$.each(arr_dt_dev, function(key,data) {
						if(data != '') {
							var dt_dev = data.split("$$");
							var tr_dt_dev = $('<tr></tr>').attr({id: dt_dev[0]}).html(dt_dev[1]).appendTo('#tab_dev');
						}
					});
					flg_dt_dev = 1;
				}
				unload('ACC vue_dt_dev');
				$("#txtHint").html("");
				const ulCmd = document.getElementsByClassName("ul-cmd")
				for(let item of ulCmd)
				{
					if(item.querySelector(".copy-elem"))
						item.querySelector(".copy-elem").onclick = () => { copyElem(cbl, item.id) } //vue_dt_dev
					if(item.querySelector(".delete-elem"))
						item.querySelector(".delete-elem").onclick = () => { deleteElem(cbl, item.id) } //vue_dt_dev
					if(item.querySelector(".new-vrs"))
						item.querySelector(".new-vrs").onclick = () => { newVersion(item.id) } //vue_dt_dev
					if(item.querySelector(".archive-elem"))
						item.querySelector(".archive-elem").onclick = () => { archiveElem(cbl, item.id) }
					if(item.querySelector(".cancel-confirmation"))
						item.querySelector(".cancel-confirmation").onclick = () => { cancelConfirmation(item.id) } //vue_dt_dev
				}
			},
			error: function (request, status, error) {
				flg_dt_dev = 1;
				rang--;
				vue_dt_dev(cbl);
				$("#txtHint").html("<span style='background: red;'>ERROR</span>");console.log('VUE_DT_DEV ERROR: '+request.statusText);
			}
		});
	}
}

function vue_grp(cbl,clt) {
	if(typeof clt == "undefined" || clt == "undefined") {var clt = $("#clt").val();}
	load('ACC vue_grp');
	$.ajax({url: 'vue_grp.php', type: 'post', data: {"cbl":cbl,"id_clt":clt},
		success: function(responseText) {
			window.scrollTo(0,0);
			if($("#vue_"+cbl).length > 0) {$("#vue_"+cbl).html(responseText);}
			rang = 1;
			flg_dt_grp = 1;
			unload('ACC vue_grp');
			$("#txtHint").html("");
			//vue_grp
			if(document.getElementById("addGrp"))
				document.getElementById("addGrp").onclick = () => { addElem('grp',0) }
			//vue_grp
			if(document.getElementById("deleteElems"))
				document.getElementById("deleteElems").onclick = () => { multiDeleteElem(cbl) }
			const tdCmd = document.getElementsByClassName("delete-elem2")
			for(let item of tdCmd)
				item.onclick = () => { deleteElem(cbl, item.id) } //vue_dt_grp
		},
		error: function (request, status, error) {
			vue_grp(cbl,clt);
			$("#txtHint").html("<span style='background: red;'>ERROR</span>");console.log('VUE_GRP ERROR: '+request.statusText);
		}
	});
}

function vue_dt_grp(cbl) {
	var clt = $("#clt").val();
	if(flg_dt_grp == 1) {
		flg_dt_grp = 0;
		rang++;
		load('ACC vue_dt_grp');
		$.ajax({url: 'vue_dt_grp.php', type: 'post', data: {"rang":rang,"cbl":cbl,"id_clt":clt},
			success: function(responseText) {
				if(responseText != '0') {
					var arr_dt_grp = responseText.split("|");
					$.each(arr_dt_grp, function(key,data) {
						if(data != '') {
							var dt_grp = data.split("$$");
							var tr_dt_grp = $('<tr></tr>').attr({id: dt_grp[0]}).html(dt_grp[1]).appendTo('#tab_grp');
						}
					});
					flg_dt_grp = 1;
				}
				unload('ACC vue_dt_grp');
				$("#txtHint").html("");
				const tdCmd = document.getElementsByClassName("delete-elem2")
				for(let item of tdCmd)
					item.onclick = () => { deleteElem(cbl, item.id) } //vue_dt_grp
			},
			error: function (request, status, error) {
				flg_dt_grp = 1;
				rang--;
				vue_dt_grp(cbl);
				$("#txtHint").html("<span style='background: red;'>ERROR</span>");console.log('VUE_DT_GRP ERROR: '+request.statusText);
			}
		});
	}
}

function vue_elem(obj,id,col) {
	if($("#"+obj+'_'+col+id).length > 0) {
		var bck = $("#"+obj+'_'+col+id).css("background-color");
		$("#"+obj+'_'+col+id).css("background-color","lightgrey");
	}
	else if($("#"+obj).length > 0) {load('ACC vue_elem '+obj);}
	$.ajax({url: 'vue_elem.php', type: 'post', data: {"id":id,"obj":obj,"col":col},
		success: function(responseText) {
			if($("#"+obj+'_'+col+id).length > 0) {
				$("#"+obj+'_'+col+id).val(responseText);
				$("#"+obj+'_'+col+id).css("background-color",bck);
			}
			else if($("#"+obj).length > 0) {
				$("#"+obj).html(responseText);
				unload('ACC vue_elem '+obj);
			}
			$("#txtHint").html("");
		},
		error: function (request, status, error) {
			vue_elem(obj,id,col);
			$("#txtHint").html("<span style='background: red;'>ERROR</span>");console.log('VUE_ELEM ERROR: '+request.statusText);
		}
	});
}

var xhr_fll = null;
function vue_fll(cbl,obj,src) {
	if($("#"+obj).length > 0) {var id = $("#"+obj).val();}
	//if(typeof xhr !== "undefined") {xhr.abort();}
	xhr_fll = $.ajax({url: 'vue_fll.php', type: 'post', data: {"cbl":cbl,"obj":obj,"src":encodeURIComponent(src),"id":id},
		beforeSend : function() {
			if(xhr_fll != null) {xhr_fll.abort();}
		},
		success: function(responseText) {
			if($("#lst_"+obj).length > 0) {
				$("#lst_"+obj).html(responseText);
				heightovery("lst_"+obj);
			}
			$("#txtHint").html("");
		},
		error: function(request, textStatus, errorThrown) {
      if(request.readyState == 4) {
				$("#txtHint").html("<span style='background: red;'>ERROR</span>");
				console.log('VUE_FLL HTTP error: '+request.status+'/'+request.statusText+'/'+request.textStatus+'/'+request.errorThrown);
			}
    /*  else if(request.readyState == 0) {
				$("#txtHint").html("<span style='background: red;'>ERROR</span>");
				console.log('VUE_FLL Network error: '+request.status+'/'+request.statusText+'/'+request.textStatus+'/'+request.errorThrown);
			}*/
      else if(request.readyState != 0) {
				$("#txtHint").html("<span style='background: red;'>ERROR</span>");
				console.log('VUE_FLL something weird is happening: '+request.status+'/'+request.statusText+'/'+request.textStatus+'/'+request.errorThrown);
      }
    }
	});
}

function init() { //a mettre dans accLoad
	vue_menu('acc',0);
	vue_lst('acc');
	$(window).scroll(function() {
		if(Math.round(($(window).scrollTop() + $(window).innerHeight() - $(document).height()) / 10) == 0) {
			var cbl = $("#cbl").val();
			if(cbl == 'crc' || cbl == 'mdl' || cbl == 'jrn' || cbl == 'prs' || cbl == 'srv' || cbl == 'hbr' || cbl == 'clt' || cbl == 'frn' || cbl == 'pic' || cbl == 'rgn' || cbl == 'vll' || cbl == 'lieu' || cbl == 'bnq') {vue_dt_cat(cbl);}
			else if(cbl == 'dev' || cbl == 'arc' || cbl == 'cnf' || cbl == 'fin') {vue_dt_dev(cbl);}
			else if(cbl == 'gr0' || cbl == 'gr1') {vue_dt_grp(cbl);}
		}
	});
	$('input[type=number]').on('wheel', function(e) {return false;});
}
