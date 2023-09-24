var upd = 0 //used by root
var flg_maj = true, id_lng, cnf //encapsulate asap

(function()
{
  cnf = document.getElementById('cnf').value
  id_lng = parent.document.getElementById('id_lng').value
  act_tab()
  init()
})()

/* asynchronous functions above */

const mailFrn = (id_res_frn, id_dev_crc) => {
	const xhr = new XMLHttpRequest
	xhr.open("POST", "../resources/php/mailFrn.php")
	xhr.setRequestHeader("Content-Type", "application/json")
	xhr.send(JSON.stringify({ id_dev_crc, id_res_frn, res : 1 }))
	xhr.onreadystatechange = () => {
		if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
		{
      const rsp = JSON.parse(xhr.response)
      if(typeof rsp[0] !== 'undefined')
        alt(rsp[0])
      else{
        load('emailPopup')
        emailWriter(rsp)
      }
		}
	}
}

const mailHbr = (id_res_hbr, id_res_chm, id_dev_crc) => {
	const xhr = new XMLHttpRequest
	xhr.open("POST", "../resources/php/mailHbr.php")
	xhr.setRequestHeader("Content-Type", "application/json")
	xhr.send(JSON.stringify({ id_dev_crc, id_res_hbr, id_res_chm, res : 1 }))
	xhr.onreadystatechange = () => {
		if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
		{
      const rsp = JSON.parse(xhr.response)
      if(typeof rsp[0] !== 'undefined')
        alt(rsp[0])
      else{
        load('emailPopup')
        emailWriter(rsp)
      }
		}
	}
}

const emailWriter = (data) => {
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
		sendMail(devData)
	}
	const closeBtn = parent.window.document.getElementById("closeBtn")
	closeBtn.onclick = () => {
		closeEmail()
	}
}

const sendMail = (devData) => {
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
  emailRequest['res'] = 1
	const xhr = new XMLHttpRequest
	xhr.open("POST", "../resources/php/sendMail.php")
	xhr.setRequestHeader("Content-Type", "application/json")
	xhr.send(JSON.stringify(emailRequest))
	xhr.onreadystatechange = () => {
		if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
		{
			if(xhr.responseText.length > 0){
        alt(xhr.responseText)
        window.parent.document.getElementById("emailBox").childNodes[0].style.display = 'none'
      }
			else{
				closeEmail()
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
      //unload('emailPopup')
		}
	}
}

const closeEmail = () => {
	parent.window.document.getElementById("emailBox").remove()
	unload('emailPopup')
}

const searchHbr = (id_cat_hbr, id_cat_chm, id_hbr_vll, id_hbr_rgm, id_dev_hbr, id_dev_prs, res, id_dev_crc) => {
  load('OPE searchHbr')
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
        window.parent.box("?", rsp[0], () => {
          for(let i = 1; i < rsp.length; i++)
            updateData('dev_hbr', 'res', res, rsp[i])
        })
      }
      unload('OPE searchHbr')
    }
  }
}

const searchSrv = (id_frn, param, id_dev_srv, id_dev_crc) => {
  params = JSON.parse(param)
  if(typeof params['res'] != 'undefined' && (params['res'] < -1 || params['res'] > 5))
  {
    updateData('dev_srv', 'res', params['res'], id_dev_srv, 0, id_dev_crc)
    return
  }
  load('OPE searchSrv')
  const xhr = new XMLHttpRequest
  xhr.open("POST", "../resources/php/searchSrv.php")
  xhr.setRequestHeader("Content-Type", "application/json")
  xhr.send(JSON.stringify({ id_frn, param, id_dev_srv, id_dev_crc, cnf }))
  xhr.onreadystatechange = () => {
    if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
    {
      if(typeof params['res'] == 'undefined')
        updateData('dev_srv', 'id_frn', id_frn, id_dev_srv)
      else
        updateData('dev_srv', 'res', params['res'], id_dev_srv, 0, id_dev_crc)
      function doFirst(resp)
      {
        return new Promise((resolve) => {
          if(resp != 0)
          {
            const rsp = JSON.parse(resp)
            if(typeof params['res'] != 'undefined')
            {
              window.parent.box("?", rsp[0], () => {
                for(let i = 1; i < rsp.length; i++)
                  updateData('dev_srv', 'res', params['res'], rsp[i])
                resolve()
              }, () => {
                resolve()
              })
            }else if(params['vll'] > 0 && params['ctg'] > 0)
            {
              window.parent.box("?", rsp[0], () => {
                for(let i = 1; i < rsp.length; i++)
                  updateData('dev_srv', 'id_frn', id_frn, rsp[i])
                resolve()
              }, () => {
                resolve()
              })
            }else{
              window.parent.box("?", rsp[0], () => {
                for(let i = 1; i < rsp.length; i++)
                  updateData('dev_srv', 'id_frn', 0, rsp[i])
                resolve()
              }, () => {
                resolve()
              })
            }
          }else{
            resolve()
          }
        })
      }
      doFirst(xhr.response).then(() => {
        window.parent.act_frm(`crc_dev_srv${id_dev_crc}`)
        window.parent.act_frm('frn_ope');
        unload('OPE searchSrv')
      })
    }
  }
}

const updateData = (tab, col, val, id, id_sup, id_dev_crc) => {
  if(flg_maj)
  {
    upd++
    console.log('upd', upd)
    flg_maj = false
  }
  if(id_sup > 0)
    load('OPE updateData')
  const xhr = new XMLHttpRequest
  xhr.open("POST", "../resources/php/updateOpeDB.php")
  xhr.setRequestHeader("Content-Type", "application/json")
  xhr.send(JSON.stringify({ tab, col, val, id }))
  xhr.onreadystatechange = () => {
    if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
    {
      const rsp = JSON.parse(xhr.response)
      switch(col)
      {
        case 'info':
        case 'heure':
          if(rsp[0] == 1)
          {
            const x = document.getElementsByClassName(`prs_res_srv${id}`)
  					for(let i = 0; i < x.length; i++)
            {
              vue_elem(x[i].id, x[i].id.substr(7))
            }
  					const y = document.getElementsByClassName(`prs_res_hbr${id}`)
  					for(let i=0; i < y.length; i++)
            {
              vue_elem(y[i].id, y[i].id.substr(7))
            }
  					window.parent.act_frm(`prs_dev_srv${id}`)
  					window.parent.act_frm(`prs_dev_hbr${id}`)
  					window.parent.act_frm('frn_ope')
  					window.parent.act_frm('hbr_ope')
          }
          break
        case 'id_frn':
          vue_elem(`frn_srv${id}`, id)
          vue_elem(`res_srv${id}`, id)
          vue_elem(`cmd_srv${id}`, id)
          window.parent.act_frm(`srv_dev_frn${id}`)
          window.parent.act_frm(`srv_dev_srv${id}`)
          //window.parent.act_frm(`crc_dev_srv${id_dev_crc}`)
          //window.parent.act_frm('frn_ope')
          break
        case 'res':
          if(tab == 'dev_srv')
          {
  					if(val == '-1')
              dsp('srv', id, id_dev_crc)
  					vue_elem(`res_srv${id}`, id)
  					vue_elem(`frn_srv${id}`, id)
  					window.parent.act_frm(`srv_dev_frn${id}`)
  					window.parent.act_frm(`srv_dev_srv${id}`)
  				}
  				else if(tab == 'dev_hbr')
          {
  					vue_elem(`res_hbr${id}`, id)
  					window.parent.act_frm(`hbr_dev_hbr${id}`)
  					window.parent.act_frm(`crc_dev_hbr${id_dev_crc}`)
  					window.parent.act_frm('hbr_ope')
					}
        break
      }
      if(rsp[0] != 1)
        alt(rsp[0])
    	if(!flg_maj)
      {
    		upd--
    		console.log('upd',upd)
    		flg_maj = true
    	}
    	if(id_sup > 0)
        unload('OPE updateData')
    }
  }
}
