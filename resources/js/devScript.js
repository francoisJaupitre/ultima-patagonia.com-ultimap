var upd = 0 //used by root
var flg_maj = true, id_lng, aut, id_dev_crc //encapsulate asap

(function()
{
  id_lng = parent.document.getElementById('id_lng').value
	id_dev_crc = document.getElementById('id_dev_crc').value
  document.getElementById('id_dev_crc').remove()
	cnf = document.getElementById('cnf').value
  document.getElementById('cnf').remove()
	aut = document.getElementById('aut').value
  document.getElementById('aut').remove()
  init()
  document.body.focus()
  const params = new URLSearchParams(document.location.search)
  const scrl = params.get('scrl');
  if(scrl != null)
  {
    const id_scrll_jrn = document.getElementById('id_scrll_jrn').value
    const id_scrll_mdl = document.getElementById('id_scrll_mdl').value
    scroll2(id_scrll_jrn, id_scrll_mdl)
  }
  /*document.body.onblur = () => {
    const fos = document.activeElement
    document.body.onfocus = () => {
      fos.focus()
      document.body.onfocus = null
    }
  }*/
  document.getElementById("newVersion").onclick = () => { newVersion() }
  if(document.getElementById("confirmation"))
    document.getElementById("confirmation").onclick = () => { prevConfirmation() }

})()

const mailFrn = async function(id_res_frn, res)
{
	if(id_res_frn == 0)
	{
		const obj = await getTxt("../resources/json/scriptText.json")
		window.parent.box("?", obj[`mailFrn${cnf}`][res][id_lng], ()=>{}, () => {
			return
		})
	}
	const xhr = new XMLHttpRequest
	xhr.open("POST", "../resources/php/mailFrn.php")
	xhr.setRequestHeader("Content-Type", "application/json")
	xhr.send(JSON.stringify({ id_dev_crc, id_res_frn, res }	))
	xhr.onreadystatechange = () => {
		if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
		{
			if(id_res_frn == 0)
			{
				const link = document.createElement('a')
				link.style.display = 'none'
				document.body.appendChild(link)
				if(res > 0)
          vue_crc('res')
				const rsp_mel = xhr.responseText.split("||")
				for(var i = 1; i < rsp_mel.length; i++)
				{
					const rsp_srv = rsp_mel[i].split("|")
					link.setAttribute('download', rsp_srv[1])
					link.setAttribute('href', rsp_srv[0])
	  			link.click()
          if(res > 0)
          {
            for(var j = 2; j < rsp_srv.length; j++)
            {
              vue_elem(`srv_res${rsp_srv[j]}`, rsp_srv[j])
              vue_elem(`srv_frn${rsp_srv[j]}`, rsp_srv[j])
            }
          }
				}
				document.body.removeChild(link)
        if(res > 0)
        {
          window.parent.act_frm(`crc_res_srv${id_dev_crc}`)
          window.parent.act_frm(`crc_res_frn${id_dev_crc}`)
          window.parent.act_frm('frn_ope')
        }
				alt(rsp_mel[0])
			}else{
        const rsp = JSON.parse(xhr.response)
        if(typeof rsp[0] !== 'undefined')
          alt(rsp[0])
        else{
          load('emailPopup')
          emailWriter(rsp, res)
        }
			}
		}
	}
}

const mailHbr = async function(id_res_hbr, id_res_chm, res)
{
	if(id_res_hbr == 0)
	{
		const obj = await getTxt("../resources/json/scriptText.json")
    if(res == 0)
      window.parent.box("?", obj[`mailHbr`][id_lng], ()=>{}, () => {
  			return
  		})
		else
      window.parent.box("?", obj[`mailHbr${res}`][cnf][id_lng], ()=>{}, () => {
  			return
  		})
	}
	const xhr = new XMLHttpRequest
	xhr.open("POST", "../resources/php/mailHbr.php")
	xhr.setRequestHeader("Content-Type", "application/json")
	xhr.send(JSON.stringify({ id_dev_crc, id_res_hbr, id_res_chm, res }	))
	xhr.onreadystatechange = () => {
		if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
		{
			if(id_res_hbr == 0)
			{
				const link = document.createElement('a')
				link.style.display = 'none'
				document.body.appendChild(link)
        if(res > 0)
				  vue_crc('res')
				const rsp_mel = xhr.responseText.split("||")
				for(var i = 1; i < rsp_mel.length; i++)
				{
          const rsp_hbr = rsp_mel[i].split("|")
					link.setAttribute('download', rsp_srv[1])
					link.setAttribute('href', rsp_srv[0])
	  			link.click()
          if(res > 0)
            for(var j = 2; j < rsp_hbr.length; j++)
              vue_elem(`hbr_res${rsp_hbr[j]}`, rsp_hbr[j])
				}
				document.body.removeChild(link)
        if(res > 0)
        {
          window.parent.act_frm(`crc_res_hbr${id_dev_crc}`)
          window.parent.act_frm('hbr_ope')
        }
        alt(rsp_mel[0])
			}else{
        const rsp = JSON.parse(xhr.response)
        if(typeof rsp[0] !== 'undefined')
          alt(rsp[0])
        else{
          load('emailPopup')
          emailWriter(rsp, res)
        }
			}
		}
	}
}

const newVersion = async function()
{
  const obj = await getTxt("../resources/json/scriptText.json")
  window.parent.box("?", obj["vrs"][id_lng], () => {
    load('DEV newVersion')
    const xhr = new XMLHttpRequest
    xhr.open("POST", "../resources/php/newVersion.php")
    xhr.setRequestHeader("Content-Type", "application/json")
    xhr.send(JSON.stringify({ id_crc : id_dev_crc }))
    xhr.onreadystatechange = () => {
      if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
      {
        const rsp = JSON.parse(xhr.response)
        window.parent.opn_frm(`dev/ctr.php?id=${rsp}`)
				window.parent.act_frm('grp_crc')
				act_acc()
        unload('DEV newVersion')
      }
    }
  })
}

const prevSortElem = async function(elem, val, id, id_sup, id_cat_sup, id_sup2)
{
  if(cnf > 0)
  {
    const obj = await getTxt("../resources/json/scriptText.json")
    window.parent.box("?", obj["cnf"][id_lng], sortElem(elem, val, id, id_sup, id_cat_sup, id_sup2), () => {
      if(obj == 'mdl')
        vue_mdl('ttr', id)
      else if(obj == 'jrn')
        vue_jrn('ttr', id)
      else if(obj == 'prs')
        vue_prs('ttr', id)
      return;
    })
  }else
    sortElem(elem, val, id, id_sup, id_cat_sup, id_sup2)
}

const prevUpdateText = async function(elem, id, id_sup)
{
  const obj = await getTxt("../resources/json/scriptText.json")
  window.parent.box("?", obj[`act_txt_${elem}`][id_lng], () => {
    if(cnf > 0)
      window.parent.box("?", obj['cnf'][id_lng], () => {
        updateText(elem, id, id_sup)
      })
    else
      updateText(elem, id, id_sup)
  })
}

const prevUpdateRates = async function(elem, id, id_sup)
{
  if(elem != 'hbr_all' && elem != 'frn_all')
  {
    const obj = await getTxt("../resources/json/scriptText.json")
    window.parent.box("?", obj[`act_trf_${elem}`][id_lng], () => {
      if(cnf > 0)
        window.parent.box("?", obj['cnf'][id_lng], () => {
          updateRates(elem, id, id_sup)
        }, ()=>{
          return 0
        })
      else
        updateRates(elem, id, id_sup)
    }, ()=>{
      return 0
    })
  }else
    updateRates(elem, id, id_sup)
}

const prevUpdateElem = async function(elem, id)
{
  const obj = await getTxt("../resources/json/scriptText.json")
  window.parent.box("?", obj[`act_elem_${elem}`][id_lng], () => {
    if(cnf>0)
      window.parent.box("?", obj['cnf'][id_lng], () => {
        updateElem(elem, id)
      })
    else
      updateElem(elem, id)
  })
}

const defineHbr = async function(id_hbr_def)
{
  const obj = await getTxt("../resources/json/scriptText.json")
  window.parent.box("?", obj["hbr_def"][id_lng], () => {
    load('DEV defineHbr')
    const xhr = new XMLHttpRequest
    xhr.open("POST", "../resources/php/defineHbr.php")
    xhr.setRequestHeader("Content-Type", "application/json")
    xhr.send(JSON.stringify({ id_dev_crc, id_hbr_def }))
    xhr.onreadystatechange = () => {
      if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
      {
        const rsp = JSON.parse(xhr.response)
        sel_mdl('dt_prs')
        vue_crc('res')
        if(rsp[0].length > 0)
          alt(rsp[0])
        if(rsp[1].length > 0)
          alt(rsp[1])
        if(rsp[2].length > 0)
          alt(rsp[2])
        unload('DEV defineHbr')
      }
    }
  })
}

const confirmation = async function()
{
  const obj = await getTxt("../resources/json/scriptText.json")
  window.parent.box("?", obj["cnf_ok"][id_lng], () => {
    load('DEV confirmation')
    const xhr = new XMLHttpRequest
    xhr.open("POST", "../resources/php/confirmation.php")
    xhr.setRequestHeader("Content-Type", "application/json")
    xhr.send(JSON.stringify({ id_dev_crc }))
    xhr.onreadystatechange = () => {
      if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
      {
        window.parent.act_frm('tsk')
				window.parent.act_frm('tsk_grp')
				window.parent.act_frm('grp_crc')
        const rsp = JSON.parse(xhr.response)
				if(rsp[0] == '1')
					alt(rsp[1])
				document.location.replace(window.location.pathname+'?id='+id_dev_crc)
				const cbl_lst = parent.window.frames[0].document.getElementById('cbl').value
				if(cbl_lst == 'acc' || cbl_lst == 'pay' || cbl_lst == 'cnf' || cbl_lst == 'dev')
          parent.window.frames[0].vue_lst(cbl_lst)
        unload('DEV confirmation')
      }
    }
  })
}

const prevFusion = async function(val, id_dev_mdl)
{
  if(cnf > 0)
  {
    const obj = await getTxt("../resources/json/scriptText.json")
    window.parent.box("?", obj['cnf'][id_lng], () => {
      fusion(val, id_dev_mdl)
    })
  }else
    fusion(val, id_dev_mdl)
}

const prevChangeParent = async function(obj, id, id_sup, id_sup2)
{
  if(cnf > 0)
  {
    const obj = await getTxt("../resources/json/scriptText.json")
    window.parent.box("?", obj['cnf'][id_lng], () => {
      changeParent(obj, id, id_sup, id_sup2)
    })
  }else
    changeParent(obj, id, id_sup, id_sup2)
}

const closeRichText = async function(arr, id, goOn, getBack)
{
  const cbl = arr.split(',')
  var rich = new Array()
  for(let i = 0; i < cbl.length; i++)
  {
    if(cbl[0] == 'crc')
      rich = rich.concat(Array.from(document.getElementsByClassName("rich")))
    else if(cbl[0] == 'dt_crc')
      rich = rich.concat(Array.from(document.getElementsByClassName("rich_dt_crc")))
    else
      rich = rich.concat(Array.from(document.getElementsByClassName(`rich_${cbl[i]}${id}`)))
  }
  if(rich.length > 0 && richTxtCheck(rich) === false)
  {
    const obj = await getTxt("../resources/json/scriptText.json")
    window.parent.box("?", obj['chk_rch'][id_lng], () => {
      goOn()
    }, () => {
      getBack()
    })
  }else{
    goOn()
  }
}

const addGrp = async function(id_clt)
{
  const obj = await getTxt("../resources/json/scriptText.json")
  const nom = prompt(obj['ajt_grp'][id_lng])
  if(nom == null || nom == '')
    return
  load('DEV addGrp')
  const xhr = new XMLHttpRequest
  xhr.open("POST", "../resources/php/addGrp.php")
  xhr.setRequestHeader("Content-Type", "application/json")
  xhr.send(JSON.stringify({ nom, id_dev_crc, id_clt }))
  xhr.onreadystatechange = () => {
    if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
    {
      vue_elem('crc_grp',id_dev_crc,'id_grp')
      vue_elem('clt_crc',id_dev_crc,'id_grp')
      unload('DEV addGrp')
    }
  }
}

const addJrnNoSrv = async function(id_dev_mdl, ord_jrn)
{
	if(ord_jrn == 0)
  {
    const obj = await getTxt("../resources/json/scriptText.json")
    var nbj = prompt(obj['addJrnNoSrv'][id_lng])
    if( //IS NOT A POSITIVE INTEGER LESS THAN 30
      isNaN(nbj) || nbj < 0 || nbj > 30
      || (
        function(x)
        {
          return (x | 0) !== x
        }
      )(parseFloat(nbj))
    )
      return
    else
      document.getElementById(`ipt_sel_jrn_mdl${id_dev_mdl}`).disabled = true
  }else{
    var nbj = 0
  }
  load('DEV addJrnNoSrv')
  const xhr = new XMLHttpRequest
  xhr.open("POST", "../resources/php/addJrnNoSrv.php")
  xhr.setRequestHeader("Content-Type", "application/json")
  xhr.send(JSON.stringify({ id_dev_mdl, ord_jrn, nbj, id_dev_crc }))
  xhr.onreadystatechange = () => {
    if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
    {
      vue_mdl('dt', id_dev_mdl)
      if(ord_jrn == 0)
      {
        vue_mdl('end', id_dev_mdl)
        sel_mdl('ttr_jrn_apr', id_dev_mdl)
        sel_mdl('end_mdl_apr', id_dev_mdl)
        vue_crc('res')
        vue_crc('ttf')
      }
      const rsp = JSON.parse(xhr.response)
      if(rsp[0].length > 0 && rsp[0] != '1')
        alt(rsp[0])
      unload('DEV addJrnNoSrv')
    }
  }
}

const addBss = async function(cbl, id)
{
  const obj = await getTxt("../resources/json/scriptText.json")
  const base = prompt(obj['ajt_bss'][id_lng])
  if(base == null || base == '')
    return
  load('DEV addBss')
  const xhr = new XMLHttpRequest
  xhr.open("POST", "../resources/php/addBss.php")
  xhr.setRequestHeader("Content-Type", "application/json")
  xhr.send(JSON.stringify({ cbl, id, base, cnf }))
  xhr.onreadystatechange = () => {
    if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
    {
      if(xhr.response.length > 0)
      {
        const rsp = JSON.parse(xhr.response)
        alt(rsp[0])
      }
			if(cbl == 'mdl')
      {
        vue_mdl('ttr', id)
        vue_mdl('trf', id)
        sel_jrn('dt_prs', id)
      }else if(cbl == 'crc')
      {
        vue_crc('ttr')
        vue_crc('trf')
        sel_mdl('dt_prs')
      }
			vue_crc('res');
		}
	}
}

const saveToCat = async function(elem, id, id_sup, id_cat_hbr)
{
  let nom = '', nom_chm, lgg, id_vll, ctg
  if(document.getElementById(`nom_${elem}${id}`))
  {
		nom = document.getElementById(`nom_${elem}${id}`).value
		if(elem == 'hbr')
      nom_chm = document.getElementById(`nom_chm${id}`).value
	}
  if(nom == '')
  {
    const obj = await getTxt("../resources/json/scriptText.json")
    nom = prompt(obj[`grd_${elem}`][id_lng])
    if(nom == null || nom == '')
      return
  }
  if(document.getElementById('lgg'))
  {
    lgg = document.getElementById("lgg").value
  }
	if(document.getElementById('vll_prs0'))
  {
    id_vll = document.getElementById("vll_prs0").value
  }
	if(document.getElementById('ctg_prs0'))
  {
    ctg = document.getElementById("ctg_prs0").value
  }
  load('DEV saveToCat')
  const xhr = new XMLHttpRequest
  xhr.open("POST", "../resources/php/saveToCat.php")
  xhr.setRequestHeader("Content-Type", "application/json")
  xhr.send(JSON.stringify({ elem, id, nom, id_cat_hbr, lgg, id_vll, ctg, nom_chm }))
  xhr.onreadystatechange = () => {
    if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
    {
      if(xhr.response.length > 1)
      {
        const rsp = JSON.parse(xhr.response)
	      switch (elem) {
          case 'crc':
            vue_crc('ttr')
            vue_crc('end')
            sel_mdl('ttr_mdl')
            sel_mdl('end_mdl')
            sel_mdl('ttr_jrn')
            sel_mdl('end_jrn')
            sel_mdl('ttr_prs')
            sel_mdl('dt_prs', id)
            sel_mdl('end_prs')
            window.parent.act_frm('crc')
            break
          case 'mdl':
            document.getElementById(`vue_ttr_mdl_${id}`).classList.add(`cat_mdl${rsp[0]}`)
            vue_mdl('ttr', id)
            vue_mdl('end', id)
            sel_jrn('ttr_jrn', id)
            sel_jrn('end_jrn', id)
            sel_jrn('ttr_prs', id)
            sel_jrn('dt_prs', id)
            sel_jrn('end_prs', id)
            window.parent.act_frm('mdl')
            break
          case 'jrn':
            document.getElementById(`vue_ttr_jrn_${id}`).classList.add(`cat_jrn${rsp[0]}`)
            vue_jrn('ttr', id)
            vue_jrn('end', id)
            sel_prs('ttr_prs', id)
            sel_prs('dt_prs', id)
            sel_prs('end_prs', id)
            window.parent.act_frm('jrn')
            break
          case 'prs':
            document.getElementById(`vue_ttr_prs_${id}`).classList.add(`cat_prs${rsp[0]}`)
            vue_prs('ttr', id)
            vue_prs('dt', id)
            vue_prs('end', id)
            window.parent.act_frm('prs')
            break
          case 'srv':
            if(id_sup > 0)
              vue_prs('dt', id_sup)
            break
          case 'hbr':
          case 'chm':
            vue_prs('dt', id_sup)
            vue_prs('end', id_sup)
            vue_crc('res')
            break
        }
				if(elem != 'chm')
          window.parent.opn_frm(`cat/ctr.php?cbl=${elem}&id=${rsp[0]}`);
        else
          window.parent.act_frm(`hbr_chm${id_cat_hbr}`);
				alt(rsp[1]) //obj['grd'][id_lng]
			}else
        alt(rsp[0]) //obj['grd2'][id_lng]
    }
	}
}

/* asynchronous functions above */

const emailWriter = (data, res) => {
	const emailFrom = data['emailFrom']
	const emailTo = data['emailTo']
	const emailSubject = data['emailSubject']
	const txt = parent.window.document.createElement("textarea")
	txt.innerHTML = data['emailBody']
	const emailBody = txt.value
	const devData = { emailGRP : data['emailGRP'] }
	if(typeof data['emailLstSRV'] !== 'undefined')
	{
		devData['emailLstSRV'] = data['emailLstSRV']
		devData['emailFRN'] = data['emailFRN']
	}
	else if(typeof data['emailLstHBR'] !== 'undefined')
	{
		devData['emailLstHBR'] = data['emailLstHBR']
		devData['emailHBR'] = data['emailHBR']
	}
	const emailBox = parent.window.document.createElement("div")
	emailBox.id = "emailBox"
	emailBox.classList.add("emailPopup")
  emailBox.innerHTML += '<div id="shadowing"></div>'
	emailBox.innerHTML += '<div><button id="sendBtn">Send</button><button id="closeBtn">Close</button></div>'
	emailBox.innerHTML += `<div><label for="from">From: </label><input id="from" value="${emailFrom}" /></div>`
	emailBox.innerHTML += `<div><label for="subj">Subject: </label><input id="subj" value="${emailSubject}" /></div>`
	emailBox.innerHTML += `<div><label for="to">To: </label><input id="to" value="${emailTo}" /></div>`
	emailBox.innerHTML += `<div><label for="bcc">Bcc: </label><input id="bcc" value="" /></div>`
	emailBox.innerHTML += `</hr>`
	emailBox.innerHTML += `<div>
		<div id="ld_emailMessage" class="loader"><img style="position:relative;top:50%;transform: translateY(-50%)" src="/resources/gif/loader.gif"></div>
		<div id="emailMessage" class="ust rich" >${emailBody}</div>
		<div id="tool_emailMessage" class="tool"></div>
	</div>`
	parent.window.document.body.appendChild(emailBox)
	const emailMessage = parent.window.document.getElementById("emailMessage")
	emailMessage.style.pointerEvents = "auto"
	emailMessage.onclick = () => {
		window.parent.editMail()
	}
	const sendBtn = parent.window.document.getElementById("sendBtn")
	sendBtn.onclick = () => {
    window.parent.document.getElementById("emailBox").childNodes[0].style.display = 'block'
		sendMail(devData, res)
	}
	const closeBtn = parent.window.document.getElementById("closeBtn")
	closeBtn.onclick = () => {
		closeEmail()
	}
}

const sendMail = (devData, res) => {
	const emailRequest = {
		from : parent.window.document.getElementById("from").value,
		to : parent.window.document.getElementById("to").value,
		subject : parent.window.document.getElementById("subj").value,
		message : `<html><body>${parent.window.document.getElementById("emailMessage").innerHTML}</body></html>`,
		bcc : parent.window.document.getElementById("bcc").value
	}
	if(typeof devData['emailLstSRV'] !== 'undefined')
	{
		emailRequest['lst_srv'] = devData['emailLstSRV']
		emailRequest['id_grp'] = devData['emailGRP']
		emailRequest['id_frn'] = devData['emailFRN']
	}
	else if(typeof devData['emailLstHBR'] !== 'undefined')
	{
		emailRequest['lst_hbr'] = devData['emailLstHBR']
		emailRequest['id_grp'] = devData['emailGRP']
		emailRequest['id_hbr'] = devData['emailHBR']
	}
  emailRequest['res'] = res
	const xhr = new XMLHttpRequest
	xhr.open("POST", "../resources/php/sendMail.php")
	xhr.setRequestHeader("Content-Type", "application/json")
	xhr.send(JSON.stringify(emailRequest))
	xhr.onreadystatechange = () => {
		if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
		{
			if(xhr.responseText.length > 0)
      {
				alt(xhr.responseText)
        window.parent.document.getElementById("emailBox").childNodes[0].style.display = 'none'
      }
			else{
				closeEmail()
        if(res > 0){
          vue_crc('res')
          if(typeof emailRequest['lst_srv'] !== 'undefined')
          {
            const rsp_srv = emailRequest['lst_srv'].split("|")
            for(var j = 0; j < rsp_srv.length; j++)
            {
              vue_elem(`srv_res${rsp_srv[j]}`, rsp_srv[j])
              vue_elem(`srv_frn${rsp_srv[j]}`, rsp_srv[j])
            }
            window.parent.act_frm(`frn_ope_frn${emailRequest['id_frn']}`)
            window.parent.act_frm(`frn_ope_srv${emailRequest['id_frn']}`)
            window.parent.act_frm('frn_ope')
          }
          else if(typeof emailRequest['lst_hbr'] !== 'undefined')
          {
            const rsp_hbr = emailRequest['lst_hbr'].split("|")
            for(var j = 0; j < rsp_hbr.length; j++)
            vue_elem(`hbr_res${rsp_hbr[j]}`, rsp_hbr[j])
            window.parent.act_frm(`cat_res_hbr${emailRequest['id_hbr']}`)
            window.parent.act_frm('hbr_ope')
          }
        }
			}
    //  unload('emailPopup')
    }
	}
}

const closeEmail = () => {
	parent.window.document.getElementById("emailBox").remove()
	unload('emailPopup')
}

const searchHbr = (id_cat_hbr, id_cat_chm, id_hbr_vll, id_hbr_rgm, id_dev_hbr, id_dev_prs, res) => {
  load('DEV searchHbr')
  const xhr = new XMLHttpRequest
  xhr.open("POST", "../resources/php/searchHbr.php")
  xhr.setRequestHeader("Content-Type", "application/json")
  xhr.send(JSON.stringify({ id_cat_hbr, id_cat_chm, id_hbr_vll, id_hbr_rgm, id_dev_hbr, id_dev_prs, id_dev_crc, cnf, res }))
  xhr.onreadystatechange = () => {
    if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
    {
      if(xhr.response != 0)
      {
        const rsp = JSON.parse(xhr.response)
        if(id_dev_prs != 0 && id_dev_hbr != 0)
        {
          if(res == 'opt' || res == 'sel')
          {
            window.parent.box("?", rsp[0], () => {
              for(let i = 1; i < rsp.length; i++)
                maj('dev_hbr', res, '1', rsp[i][0], rsp[i][1])
              vue_crc('res')
            })
          }
          else if(res == 'ajt')
          {
            window.parent.box("?", rsp[0], () => {
              for(let i = 1; i < rsp.length; i++)
                ajt_hbr(id_cat_hbr, id_cat_chm, id_hbr_vll, id_hbr_rgm, rsp[i], 0, 0)
            })
          }
          else if(res == 'sup')
          {
            window.parent.box("?", rsp[0], () => {
              for(let i = 1; i < rsp.length; i++)
                sup('hbr', rsp[i][0], rsp[i][1], 1, id_cat_hbr)
            })
          }
        }
        else if(id_dev_prs != 0 && id_dev_hbr == 0)
        {
          window.parent.box("?", rsp[0], () => {
            for(let i = 1; i < rsp.length; i++)
              ajt_hbr(id_cat_hbr, id_cat_chm, id_hbr_vll, id_hbr_rgm, 0, rsp[i], 0)
          })
        }
        else if(id_dev_prs == 0 && id_dev_hbr != 0)
        {
          window.parent.box("?", rsp[0], () => {
            for(let i = 1; i < rsp.length; i++)
            {
              maj('dev_hbr', 'res', res, rsp[i])
              vue_elem(`hbr_res${rsp[i]}`, rsp[i])
            }
            vue_crc('res')
          })
        }
        else if(id_dev_prs == 0 && id_dev_hbr == 0)
        {
          let ids = rsp
          if(res == 'updateRates')
          {
            window.parent.box("?", ids.shift(), () => {
              if(cnf>0)
              {
                window.parent.box("?", ids.shift(), () => {
                  prevUpdateRates('hbr_all', ids, 0)
                })
              }else{
                prevUpdateRates('hbr_all', ids, 0)
              }
            })
          }
          else if(res == 'sup')
          {
            window.parent.box("?", ids.shift(), () => {
              if(cnf > 0)
              {
                window.parent.box("?", ids.shift(), ()=>{
                  for(let i = 0; i < rsp.length; i++)
                  {
                    sup('hbr', rsp[i][0], rsp[i][1], 1, id_cat_hbr)
                  }
                })
              }
              else{
                for(let i = 0; i < rsp.length; i++)
                {
                  sup('hbr', rsp[i][0], rsp[i][1], 1, id_cat_hbr)
                }
              }
            })
          }
        }
      }
      unload('DEV searchHbr')
    }
  }
}

const searchSrv = (id_frn, id_dev_srv_ctg, id_dev_srv_vll, id_dev_srv) => {
  load('DEV searchSrv')
  const xhr = new XMLHttpRequest
  xhr.open("POST", "../resources/php/searchSrv.php")
  xhr.setRequestHeader("Content-Type", "application/json")
  xhr.send(JSON.stringify({ id_dev_srv_ctg, id_dev_srv_vll, id_dev_srv, id_dev_crc, id_frn, cnf }))
  xhr.onreadystatechange = () => {
    if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
    {
      if(xhr.response != 0)
      {
        const rsp = JSON.parse(xhr.response)
        if(id_dev_srv_vll > 0 && id_dev_srv > 0)
        {
          window.parent.box("?", rsp[0], () => {
            for(let i = 1; i < rsp.length; i++)
              maj('dev_srv', 'id_frn', id_frn, rsp[i])
          })
        }else{
          window.parent.box("?", rsp[0], () => {
            for(let i = 1; i < rsp.length; i++)
              maj('dev_srv', 'id_frn', 0, rsp[i])
          })
        }
      }
      unload('DEV searchSrv')
    }
  }
}

const searchFrn = (res, id_frn, id_dev_srv, id_dev_prs) => {
  load('DEV searchFrn')
  const xhr = new XMLHttpRequest
  xhr.open("POST", "../resources/php/searchFrn.php")
  xhr.setRequestHeader("Content-Type", "application/json")
  xhr.send(JSON.stringify({ id_frn, id_dev_srv, id_dev_crc, res, cnf }))
  xhr.onreadystatechange = () => {
    if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
    {
      if(res > -2 && res < 6 && id_dev_srv > 0)
      {
        if(res > -1 && xhr.response != 0)
        {
          const rsp = JSON.parse(xhr.response)
          window.parent.box("?", rsp[0], () => {
            for(let i = 1; i < rsp.length; i++)
            {
              maj('dev_srv', 'res', res, rsp[i])
              sel_srv('srv', rsp[i])
            }
          })
        }
        maj('dev_srv', 'res', res, id_dev_srv, id_dev_prs)
        vue_crc('res')
        window.parent.act_frm('frn_ope')
      }
      else if(res == 0 && id_dev_srv == 0 && xhr.response != 0)
      {
        const rsp = JSON.parse(xhr.response)
        let ids = rsp
        window.parent.box("?", ids.shift(), () => {
          if(cnf>0)
          {
            window.parent.box("?", ids.shift(), ()=>{
              prevUpdateRates('frn_all', rsp, 0)
            })
          }else{
            prevUpdateRates('frn_all', rsp, 0)
          }
        })
      }
      unload('DEV searchFrn')
    }
  }
}

const sortElem = (obj, val, id, id_sup, id_cat_sup, id_sup2) => {
  if(obj == 'mdl')
  {
    closeRichText('dsc_mdl, dt_mdl', id, () => {
      vue_mdl('ttr', id)
    })
  }else if(obj == 'jrn')
  {
    closeRichText('dt_mdl', id_sup, () => {
      vue_jrn('ttr', id)
    })
  }else if(obj == 'prs')
  {
    closeRichText('dt_jrn', id_sup, () => {
      vue_prs('ttr', id)
    })
  }else if(id_cat_sup > 0)
  {
		if(obj == 'mdl' && sup_cat('crc', id_sup) == 0)
    {
      vue_mdl('ttr', id)
      return
    }else if(obj == 'jrn' && sup_cat('mdl', id_sup) == 0)
    {
      vue_jrn('ttr', id)
      return
    }else if(obj == 'prs' && sup_cat('jrn', id_sup, id_sup2) == 0)
    {
      vue_prs('ttr', id)
      return
    }
	}
  load('DEV sortElem')
  const xhr = new XMLHttpRequest
  xhr.open("POST", "../resources/php/sortElem.php")
  xhr.setRequestHeader("Content-Type", "application/json")
  xhr.send(JSON.stringify({ obj, val, id, id_sup }))
  xhr.onreadystatechange = () => {
    if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
    {
      const rsp = JSON.parse(xhr.response)
      if(rsp[0] != 0)
      {
				if(obj == "mdl")
        {
					if(rsp[0] != 1)
          {
						const x = document.getElementsByClassName(`mdl_dev_srv${id}`)
            for(let i = 0; i < x.length; i++)
              vue_elem(x[i].id, x[i].id.substr(7))
						const y = document.getElementsByClassName(`mdl_dev_hbr${id}`)
            for(let i = 0; i < y.length; i++)
              vue_elem(y[i].id, y[i].id.substr(7))
						if(x.length > 0 || y.length > 0)
            {
              vue_crc('res')
            }
					}
					vue_crc('dt')
          prevUpdateRates('crc', id_sup)
				}else if(obj == "jrn")
        {
          if(rsp[0] != 1)
          {
						const x1 = document.getElementsByClassName(`jrn_dev_srv${id}`)
            for(i = 0; i < x1.length; i++)
              vue_elem(x1[i].id, x1[i].id.substr(7))
						const y1 = document.getElementsByClassName(`jrn_dev_hbr${id}`)
            for(i = 0; i < y1.length; i++)
              vue_elem(y1[i].id, y1[i].id.substr(7))
						const x2 = document.getElementById(`jrn_dev_srv${id}`)
						const y2 = document.getElementById(`jrn_dev_hbr${id}`)
						if(x1.length > 0 || y1.length > 0 || x2 || y2)
              vue_crc('res')
					}
					vue_mdl('dt', id_sup)
          prevUpdateRates('mdl', id_sup)
				}else if(obj == "prs")
          vue_jrn('dt', id_sup)
			}else{
				if(obj == "mdl")
          vue_mdl('ttr', id)
        else if(obj == "jrn")
          vue_jrn('ttr', id)
        else if(obj == "prs")
          vue_prs('ttr', id)
        alt(rsp[1])
			}
      unload('DEV sortElem')
    }
  }
}

const sortJrnByDate = (val, id_dev_jrn, id_sup) => {
  load('DEV sortJrnByDate')
  const xhr = new XMLHttpRequest
  xhr.open("POST", "../resources/php/sortJrnByDate.php")
  xhr.setRequestHeader("Content-Type", "application/json")
  xhr.send(JSON.stringify({ val, id_dev_jrn, id_dev_crc }))
  xhr.onreadystatechange = () => {
    if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
    {
      const x = document.getElementsByClassName(`jrn_dev_srv${id_dev_jrn}`)
      for(i = 0; i < x.length; i++)
        vue_elem(x[i].id, x[i].id.substr(7))
      const y = document.getElementsByClassName(`jrn_dev_hbr${id_dev_jrn}`)
      for(i = 0; i < y.length; i++)
        vue_elem(y[i].id, y[i].id.substr(7))
      if(x.length > 0 || y.length > 0)
        vue_crc('res')
      sel_mdl('ttr_jrn')
      prevUpdateRates('crc', id_dev_crc)
      unload('DEV sortJrnByDate')
    }
  }
}

const updateText = (obj, id, id_sup) => {
  load('DEV updateText')
  const lgg = document.getElementById("lgg").value
  const xhr = new XMLHttpRequest
  xhr.open("POST", "../resources/php/updateDevText.php")
  xhr.setRequestHeader("Content-Type", "application/json")
  xhr.send(JSON.stringify({ obj, id, lgg }))
  xhr.onreadystatechange = () => {
    if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
    {
      switch (obj) {
        case 'crc':
          vue_crc('ttr')
          vue_crc('ttf')
          vue_crc('dsc')
          sel_mdl('ttr_mdl')
          sel_mdl('dsc_mdl')
          sel_mdl('ttr_jrn')
          sel_mdl('dsc_jrn')
          sel_mdl('ttr_prs')
          sel_mdl('dsc_prs')
          sel_mdl('dt_prs')
          break
        case 'mdl':
          vue_mdl('ttr', id)
          vue_mdl('dsc', id)
          sel_jrn('ttr_jrn', id)
          sel_jrn('dsc_jrn', id)
          sel_jrn('ttr_prs', id)
          sel_jrn('dsc_prs', id)
          sel_jrn('dt_prs', id)
          break
        case 'jrn':
          vue_jrn('ttr', id)
          vue_jrn('dsc', id)
          sel_prs('ttr_prs', id)
          sel_prs('dsc_prs', id)
          sel_prs('dt_prs', id)
          break
        case 'prs':
          vue_prs('ttr', id)
          vue_prs('dsc', id)
          vue_prs('dt', id)
          break
        case 'srv':
        case 'hbr':
          vue_prs('dt', id_sup)
          break
      }
      const rsp = JSON.parse(xhr.response)
  		if(rsp[0].length > 0 && rsp[0] != 1)
      {
        alt(rsp[0])
      }
      unload('DEV updateText')
  	}
  }
}

const updateRates = (obj, id, id_sup) => {
  if(obj == 'hbr_all' || obj == 'frn_all')
  {
    var arr = id
		var id = arr.join('_')
  }else{
    load('DEV updateRates')
  }
  const xhr = new XMLHttpRequest
  xhr.open("POST", "../resources/php/updateDevRates.php")
  xhr.setRequestHeader("Content-Type", "application/json")
  xhr.send(JSON.stringify({ obj, id, id_sup }))
  xhr.onreadystatechange = () => {
    if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
    {
      switch (obj) {
        case 'crc':
          sel_mdl('dt_prs')
          break
        case 'mdl':
          sel_jrn('dt_prs', id)
          break
        case 'jrn':
          sel_prs('dt_prs', id)
          break
        case 'prs':
          vue_prs('prs', id)
          break
        case 'srv':
        case 'hbr':
          vue_prs('prs', id_sup)
          break
        case 'hbr_all':
          for(let i = 0; i < arr.length; i++)
            sel_srv('hbr', arr[i])
          break
        case 'srv_all':
          for(let i = 0; i < arr.length; i++)
            sel_srv('srv', arr[i])
          break
      }
      vue_crc('res')
      const rsp = JSON.parse(xhr.response)
  		if(rsp[0].length > 0 && rsp[0] != 1)
      {
        alt(rsp[0]);
      }
      if(obj != 'hbr_all' && obj != 'frn_all')
      {
        unload('DEV updateRates')
      }
    }
  }
}

const updateElem = (obj, id) => {
  load('DEV updateElem')
  const lgg = document.getElementById("lgg").value
  const xhr = new XMLHttpRequest
  xhr.open("POST", "../resources/php/updateDevElem.php")
  xhr.setRequestHeader("Content-Type", "application/json")
  xhr.send(JSON.stringify({ obj, id, lgg }))
  xhr.onreadystatechange = () => {
    if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
    {
      vue_crc('res');
      switch (obj) {
        case 'crc':
          vue_crc('ttf')
          vue_crc('dt')
          break
        case 'mdl':
          vue_crc('ttf')
          vue_mdl('dt', id)
          sel_mdl('end_mdl_apr', id)
          sel_mdl('ttr_jrn_apr', id)
          break
        case 'jrn':
          vue_jrn('dt', id)
          break
        case 'prs':
          vue_prs('dt', id)
          break
      }
      const rsp = JSON.parse(xhr.response)
      if(rsp[0].length > 0)
      {
        alt(rsp[0])
      }
      if(rsp[1].length > 0)
      {
        alt(rsp[1])
      }
      unload('DEV updateElem')
    }
  }
}

const prevConfirmation = () => {
  closeRichText('crc', '', () =>
  {
    load('DEV prevConfirmation')
    const xhr = new XMLHttpRequest
    xhr.open("POST", "../resources/php/prevConfirmation.php")
    xhr.setRequestHeader("Content-Type", "application/json")
    xhr.send(JSON.stringify({ id_dev_crc }))
    xhr.onreadystatechange = () => {
      if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
      {
        const rsp = JSON.parse(xhr.response)
        if(rsp[0] == 0)
        {
          confirmation()
        }else{
          let msg = rsp[0]
          if(rsp.length > 1)
          {
            for(let i = 1; i < rsp.length; i++)
            {
              if(i > 1){
                msg += ', '
              }
              msg += rsp[i]
            }
          }
          alt(msg)
        }
        unload('DEV prevConfirmation')
      }
    }
  })
}

const fusion = (val, id_dev_mdl) => {
  load('DEV fusion')
  const xhr = new XMLHttpRequest
  xhr.open("POST", "../resources/php/fusion.php")
  xhr.setRequestHeader("Content-Type", "application/json")
  xhr.send(JSON.stringify({ val, id_dev_mdl, id_dev_crc }))
  xhr.onreadystatechange = () => {
    if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
    {
      vue_crc('ttf')
      sel_jrn('ttr_jrn_lst', id_dev_mdl)
      sel_mdl('opt_jrn_apr', id_dev_mdl)
      vue_mdl('end', id_dev_mdl)
      sel_mdl('ttr_jrn_apr', id_dev_mdl)
      sel_mdl('end_mdl_apr', id_dev_mdl)
      if(xhr.response.length > 0)
      {
        const rsp = JSON.parse(xhr.response)
        alt(rsp[0])
      }
      unload('DEV fusion')
    }
  }
}

const changeParent = (obj, id, id_sup, id_sup2) => {
  load('DEV changeParent')
  const xhr = new XMLHttpRequest
  xhr.open("POST", "../resources/php/changeParent.php")
  xhr.setRequestHeader("Content-Type", "application/json")
  xhr.send(JSON.stringify({ obj, id }))
  xhr.onreadystatechange = () => {
    if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
    {
      if(xhr.response.length > 0)
      {
        const rsp = JSON.parse(xhr.response)
        if(rsp[0] == '1')
        {
          vue_mdl('ttr', id_sup)
          vue_mdl('dt', id_sup)
          vue_mdl('end', id_sup)
          sel_mdl('ttr_mdl_avt', id_sup)
          sel_mdl('dt_mdl_avt', id_sup)
          sel_mdl('end_mdl_avt', id_sup)
        }else if(rsp[0] == '2')
        {
          vue_mdl('ttr', id_sup)
          vue_mdl('dt', id_sup)
          vue_mdl('end', id_sup)
          sel_mdl('ttr_mdl_apr', id_sup)
          sel_mdl('dt_mdl_apr', id_sup)
          sel_mdl('end_mdl_apr', id_sup)
        }else if(rsp[0] == '3')
        {
          vue_jrn('ttr', id_sup)
          vue_jrn('dt', id_sup)
          vue_jrn('end', id_sup)
          sel_jrn('ttr_jrn_avt1', id_sup2, id_sup)
          sel_jrn('dt_jrn_avt1', id_sup2, id_sup)
          sel_jrn('end_jrn_avt1', id_sup2, id_sup)
        }else if(rsp[0] == '4')
        {
          vue_jrn('ttr', id_sup)
          vue_jrn('dt', id_sup)
          vue_jrn('end', id_sup)
          sel_jrn('ttr_jrn_apr1', id_sup2, id_sup)
          sel_jrn('dt_jrn_apr1', id_sup2, id_sup)
          sel_jrn('end_jrn_apr1', id_sup2, id_sup)
        }else if(rsp[0].length > 0)
        {
          alt(rsp[0])
        }
      }
      unload('DEV changeParent')
    }
  }
}

const addRmn = (cbl, id) => {
  load('DEV addRmn')
  const xhr = new XMLHttpRequest
  xhr.open("POST", "../resources/php/addRmn.php")
  xhr.setRequestHeader("Content-Type", "application/json")
  xhr.send(JSON.stringify({ cbl, id }))
  xhr.onreadystatechange = () => {
    if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
    {
      if(xhr.response.length > 0)
      {
        const rsp = JSON.parse(xhr.response)
        alt(rsp[0])
      }else if(cbl == 'mdl')
      {
        vue_mdl('ttr', id)
        vue_mdl('rmn', id)
        sel_jrn('end_prs', id)
      }else if(cbl == 'crc')
      {
        vue_crc('ttr')
        vue_crc('rmn')
        sel_mdl('end_prs')
      }
      unload('DEV addRmn')
    }
  }
}
