const mailFrn = async function(id_res_frn)
{
	if(id_res_frn == 0)
	{
		const obj = await getTxt("../resources/json/scriptTxt.json")
		if(window.confirm(obj["mailFrn"][cnf][id_lng]) == false)
			return
	}
	const xhr = new XMLHttpRequest
	xhr.open("POST","../resources/php/mailFrn.php")
	xhr.setRequestHeader("Content-Type", "application/json")
	xhr.send(JSON.stringify({ id_dev_crc, id_res_frn }	))
	xhr.onreadystatechange = () => {
		if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
		{
			if(id_res_frn == 0)
			{
				const link = document.createElement('a')
				link.style.display = 'none'
				document.body.appendChild(link)
				vue_crc('res')
				const rsp_mel = xhr.responseText.split("||")
				for(var i = 1; i < rsp_mel.length; i++)
				{
					const rsp_srv = rsp_mel[i].split("|")
					link.setAttribute('download', rsp_srv[1])
					link.setAttribute('href', rsp_srv[0])
	  			link.click()
					for(var j = 2; j < rsp_srv.length; j++)
					{
						vue_elem(`srv_res${rsp_srv[j]}`, rsp_srv[j])
						vue_elem(`srv_frn${rsp_srv[j]}`, rsp_srv[j])
					}
				}
				document.body.removeChild(link)
				window.parent.act_frm(`crc_res_srv${id_dev_crc}`)
				window.parent.act_frm(`crc_res_frn${id_dev_crc}`)
				window.parent.act_frm('frn_ope')
				alt(rsp_mel[0])
			}else{
				load('emailPopup')
				emailWriter(JSON.parse(xhr.response))
			}
		}
	}
}

const mailHbr = async function(id_res_hbr,id_res_chm)
{
	if(id_res_hbr == 0)
	{
		const obj = await getTxt("../resources/json/scriptTxt.json")
		if(window.confirm(obj["mailHbr"][cnf][id_lng]) == false)
			return
	}
	const xhr = new XMLHttpRequest
	xhr.open("POST","../resources/php/mailHbr.php")
	xhr.setRequestHeader("Content-Type", "application/json")
	xhr.send(JSON.stringify({ id_dev_crc, id_res_hbr, id_res_chm }	))
	xhr.onreadystatechange = () => {
		if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
		{
			if(id_res_hbr == 0)
			{
				const link = document.createElement('a')
				link.style.display = 'none'
				document.body.appendChild(link)
				vue_crc('res')
				const rsp_mel = xhr.responseText.split("||")
				for(var i = 1; i < rsp_mel.length; i++)
				{
					const rsp_hbr = rsp_mel[i].split("|")
					link.setAttribute('download', rsp_srv[1])
					link.setAttribute('href', rsp_srv[0])
	  			link.click()
					for(var j = 2; j < rsp_hbr.length; j++)
						vue_elem(`hbr_res${rsp_hbr[j]}`, rsp_hbr[j])
				}
				document.body.removeChild(link)
				window.parent.act_frm(`crc_res_hbr${id_dev_crc}`)
				window.parent.act_frm('hbr_ope')
				alt(rsp_mel[0])
			}else{
				load('emailPopup')
				emailWriter(JSON.parse(xhr.response))
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
	const xhr = new XMLHttpRequest
	xhr.open("POST","../resources/php/sendMail.php")
	xhr.setRequestHeader("Content-Type", "application/json")
	xhr.send(JSON.stringify(emailRequest))
	xhr.onreadystatechange = () => {
		if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
		{
			if(xhr.responseText.length > 0)
				alt(xhr.responseText)
			else{
				closeEmail()
				vue_crc('res')
				if(typeof emailRequest['lst_srv'] !== 'undefined')
				{
					const rsp_srv = emailRequest['lst_srv'].split("|")
					for(var j = 2; j < rsp_srv.length; j++)
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
					for(var j = 2; j < rsp_hbr.length; j++)
						vue_elem(`hbr_res${rsp_hbr[j]}`, rsp_hbr[j])
					window.parent.act_frm(`cat_res_hbr${emailRequest['id_hbr']}`)
					window.parent.act_frm('hbr_ope')
				}
			}
		}
		unload('emailPopup')
	}
}

const closeEmail = () => {
	parent.window.document.getElementById("emailBox").remove()
	unload('emailPopup')
}
