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
