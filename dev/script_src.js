function src_jrn(id_dev_jrn,opt){
	var xhr = 'jrn'+id_dev_jrn;
	if(window.XMLHttpRequest){eval('xmlhttp_src_jrn'+xhr+'=new XMLHttpRequest()');}
	else{eval('xmlhttp_src_jrn'+xhr+'=new ActiveXObject("Microsoft.XMLHTTP")');}
	load('DEV src_jrn');
	eval('xmlhttp_src_jrn'+xhr).onreadystatechange=function(){
		if(eval('xmlhttp_src_jrn'+xhr).readyState==4){
			if(eval('xmlhttp_src_jrn'+xhr).status==200){
				if(eval('xmlhttp_src_jrn'+xhr).responseText != 0){
					eval('var arr_jrn'+xhr+'=xmlhttp_src_jrn'+xhr+'.responseText.split("|-|")');
					for(var i= 0; i < eval('arr_jrn'+xhr+'.length'); i++){
						eval('var arr_jrn2'+xhr+'=arr_jrn'+xhr+'[i].split("|")');
						ajt_hbr(eval('arr_jrn2'+xhr+'[0]'),eval('arr_jrn2'+xhr+'[1]'),eval('arr_jrn2'+xhr+'[2]'),eval('arr_jrn2'+xhr+'[3]'),eval('arr_jrn2'+xhr+'[4]'),eval('arr_jrn2'+xhr+'[5]'),1,eval('arr_jrn2'+xhr+'[6]'),eval('arr_jrn2'+xhr+'[7]'),eval('arr_jrn2'+xhr+'[8]'),eval('arr_jrn2'+xhr+'[9]'));
					}
				}
			}
			else if(eval('xmlhttp_src_jrn'+xhr).status==408){src_jrn(id_dev_jrn);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR SRC_JRN "+eval('xmlhttp_src_jrn'+xhr).statusText+" </span>";}
			unload('DEV src_jrn');
		}
	}
	eval('xmlhttp_src_jrn'+xhr).open("POST","../fct/src_jrn.php",true);
	eval('xmlhttp_src_jrn'+xhr).setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	eval('xmlhttp_src_jrn'+xhr).send("id_dev_jrn="+id_dev_jrn+"&opt="+opt);
}

function src_prs(id_cat_prs,ord_prs,id_dev_jrn,res_act,chk){ //ordonner cette fonction en retirant les actions non présentes dans opés
	var xhr = 'prs'+id_dev_jrn+'_'+ord_prs;
	if(window.XMLHttpRequest){xhttp=new XMLHttpRequest();}
	else{xhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	xhttp.open("GET","txt_js.xml",false); //remplazar por json
	xhttp.send();
	xmlDoc=xhttp.responseXML;
	x=xmlDoc.getElementsByTagName("src_prs");
	if(window.XMLHttpRequest){eval('xmlhttp_src_prs'+xhr+'=new XMLHttpRequest()');}
	else{eval('xmlhttp_src_prs'+xhr+'=new ActiveXObject("Microsoft.XMLHTTP")');}
	load('DEV src_prs');
	eval('xmlhttp_src_prs'+xhr).onreadystatechange=function(){
		if(eval('xmlhttp_src_prs'+xhr).readyState==4){
			if(eval('xmlhttp_src_prs'+xhr).status==200){
				if(eval('xmlhttp_src_prs'+xhr).responseText != 0){
					eval('var arr_prs'+xhr+'=xmlhttp_src_prs'+xhr+'.responseText.split("|")');
					if(res_act=='ajt_opt'){
						if(ord_prs>0){
							yy=x[0].getElementsByTagName(id_lng);
							y=x[1].getElementsByTagName(id_lng);
							if(window.confirm(y[0].childNodes[0].nodeValue+eval('arr_prs'+xhr+'.length')/2+yy[0].childNodes[0].nodeValue)){
								for(var i= 0; i < eval('arr_prs'+xhr+'.length'); i=i+2){ajt_prs(id_cat_prs,eval('arr_prs'+xhr+'[i]'),eval('arr_prs'+xhr+'[i+1]'),0);}
							}
						}
						else{
							//ajt_opt vue_dt_jrn
						}
					}
					else if(res_act=='sel_opt'){
						if(chk==0){
							yy=x[0].getElementsByTagName(id_lng);
							y=x[2].getElementsByTagName(id_lng);
							if(window.confirm(y[0].childNodes[0].nodeValue+eval('arr_prs'+xhr+'.length')/2+yy[0].childNodes[0].nodeValue)){
								for(var i= 0; i < eval('arr_prs'+xhr+'.length'); i=i+2){maj('dev_prs','opt','1',eval('arr_prs'+xhr+'[i]'),eval('arr_prs'+xhr+'[i+1]'));}
							}
						}
						else if(chk==1){
							yy=x[0].getElementsByTagName(id_lng);
							y=x[3].getElementsByTagName(id_lng);
							if(window.confirm(y[0].childNodes[0].nodeValue+eval('arr_prs'+xhr+'.length')/2+yy[0].childNodes[0].nodeValue)){
								for(var i= 0; i < eval('arr_prs'+xhr+'.length'); i=i+2){maj('dev_prs','opt','0',eval('arr_prs'+xhr+'[i]'),eval('arr_prs'+xhr+'[i+1]'));}
							}
						}
					}
					else if(res_act=='sup'){
						yy=x[0].getElementsByTagName(id_lng);
						y=x[4].getElementsByTagName(id_lng);
						if(window.confirm(y[0].childNodes[0].nodeValue+eval('arr_prs'+xhr+'.length')/2+yy[0].childNodes[0].nodeValue)){
							for(var i= 0; i < eval('arr_prs'+xhr+'.length'); i=i+2){sup('prs',eval('arr_prs'+xhr+'[i]'),eval('arr_prs'+xhr+'[i+1]'),1,id_cat_prs);}
						}
					}
					else{
						yy=x[0].getElementsByTagName(id_lng);
						y=x[5].getElementsByTagName(id_lng);
						if(window.confirm(y[0].childNodes[0].nodeValue+eval('arr_prs'+xhr+'.length')+yy[0].childNodes[0].nodeValue)){
							for(var i= 0; i < eval('arr_prs'+xhr+'.length'); i++){maj('dev_prs','res',res_act,eval('arr_prs'+xhr+'[i]'));}
						}
					}
				}
			}
			else if(eval('xmlhttp_src_prs'+xhr).status==408){src_prs(id_cat_prs,ord_prs,id_dev_jrn,res_act,chk);}
			else{document.getElementById("txtHint").innerHTML="<span style='background: red;'>ERREUR SRC_PRS "+eval('xmlhttp_src_prs'+xhr).statusText+" </span>";}
			unload('DEV src_prs');
		}
	}
	eval('xmlhttp_src_prs'+xhr).open("POST","../fct/src_prs.php",true);
	eval('xmlhttp_src_prs'+xhr).setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	eval('xmlhttp_src_prs'+xhr).send("id_cat_prs="+id_cat_prs+"&ord_prs="+ord_prs+"&id_dev_jrn="+id_dev_jrn+"&id_dev_crc="+id_dev_crc+"&chk="+chk+"&res_act="+res_act);
}
