const mailFrn = (id_res_frn, id_dev_crc) => {
	const xhr = new XMLHttpRequest
	xhr.open("POST","../resources/php/mailFrn.php")
	xhr.setRequestHeader("Content-Type", "application/json")
	xhr.send(JSON.stringify({ id_dev_crc, id_res_frn }))
	xhr.onreadystatechange = () => {
		if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
		{
			load('emailPopup')
			emailWriter(JSON.parse(xhr.response))
		}
	}
}

const mailHbr = (id_res_hbr, id_res_chm, id_dev_crc) => {
	const xhr = new XMLHttpRequest
	xhr.open("POST","../resources/php/mailHbr.php")
	xhr.setRequestHeader("Content-Type", "application/json")
	xhr.send(JSON.stringify({ id_dev_crc, id_res_hbr, id_res_chm }))
	xhr.onreadystatechange = () => {
		if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
		{
			load('emailPopup')
			emailWriter(JSON.parse(xhr.response))
		}
	}
}

const emailWriter = (data) => {
	const emailFrom = data['emailFrom']
	const emailTo = data['emailTo']
	const emailSubject = data['emailSubject']
	const txt = document.createElement("textarea")
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
	const emailBox = document.createElement("div")
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
	document.body.appendChild(emailBox)
	const emailMessage = document.getElementById("emailMessage")
	emailMessage.style.pointerEvents = "auto"
	emailMessage.onclick = () => {
		const loader = document.getElementById(`ld_${emailMessage.id}`)
		loader.style.display = 'block'
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
					loader.style.display='none'
					elem.execCommand('mceFocus', true, emailMessage.id)
				})
			},
		})
		emailMessage.onclick=null
	}
	const sendBtn = document.getElementById("sendBtn")
	sendBtn.onclick = ()=>{ sendMail(devData) }
	const closeBtn = document.getElementById("closeBtn")
	closeBtn.onclick = ()=>{ closeEmail() }
}

const sendMail = (devData) => {
	const emailRequest = {
		from : document.getElementById("from").value,
		to : document.getElementById("to").value,
		subject : document.getElementById("subj").value,
		message : `<html><body>${emailMessage.innerHTML}</body></html>`,
		bcc : document.getElementById("bcc").value
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
		if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
		{
			if(xhr.responseText.length > 0)
				alt(xhr.responseText)
			else{
				closeEmail()
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
	document.getElementById("emailBox").remove()
	unload('emailPopup')
}
