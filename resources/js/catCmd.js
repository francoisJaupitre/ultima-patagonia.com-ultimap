const copyElem = async function(cbl,id)
{
  const deflt = document.getElementById(`nom_${cbl}_${id}`).value+"(1)"
  const obj = await getTxt("../resources/json/cmdTxt.json")
  const nom = prompt(obj[`cop_${cbl}`][id_lng],deflt)
	if(nom == null || nom == '')
    return
	load('CAT copyElem')
  const xhr = new XMLHttpRequest
	xhr.open("POST","../resources/php/copyElem.php")
	xhr.setRequestHeader("Content-Type", "application/json")
	xhr.send(JSON.stringify({ cbl, id, nom }))
  xhr.onreadystatechange = () => {
    if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
    {
      const rsp = JSON.parse(xhr.response)
			window.parent.opn_frm(`cat/ctr.php?cbl=${cbl}&id=${rsp}`)
			act_acc()
			window.parent.act_frm(cbl)
			window.parent.act_frm(`up_${cbl}`)
      if(cbl=='prs')
        window.parent.act_frm('ajt_prs_opt')
			unload('CAT copyElem')
		}
	}
}

const deleteElem = async function(cbl,id)
{
  const obj = await getTxt("../resources/json/cmdTxt.json")
  window.parent.box("?",obj[`del_${cbl}`][id_lng], () => {
		load('CAT deleteElem');
    const xhr = new XMLHttpRequest
  	xhr.open("POST","../resources/php/deleteElem.php")
  	xhr.setRequestHeader("Content-Type", "application/json")
  	xhr.send(JSON.stringify({ cbl, id }	))
    xhr.onreadystatechange = () => {
      if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
      {
        if(xhr.response.length > 0)
          alt(JSON.parse(xhr.response))
        else{
          if(cbl == 'srv')
            window.parent.act_frm('frn_srv')
					else if(cbl == 'hbr')
            window.parent.act_frm('frn_hbr')
					window.parent.act_frm(`up_${cbl}${id}`)
					window.parent.act_frm(`up_${cbl}`)
					act_acc()
					window.parent.sup_frm(`catctrphpcbl${cbl}id${id}`)
				}
				unload('CAT deleteElem')
      }
    }
  })
}

const addDev = async function(id)
{
  const obj = await getTxt("../resources/json/cmdTxt.json")
  const nom = prompt(obj["ajt_dev"][id_lng])
  if(nom == null || nom == '')
    return
  load('addDev')
  const xhr = new XMLHttpRequest
  xhr.open("POST","../resources/php/addDev.php")
  xhr.setRequestHeader("Content-Type", "application/json")
  xhr.send(JSON.stringify({ id, nom }))
  xhr.onreadystatechange = () => {
    if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
    {
      const rsp = JSON.parse(xhr.response)
      window.parent.act_frm('grp')
      window.parent.act_frm('clt')
      window.parent.opn_frm(`dev/ctr.php?id=${rsp[0]}`)
      act_acc()
      if(rsp[1].length > 0)
        alt(rsp[1])
      if(rsp[2].length > 0)
        alt(rsp[2])
      unload('addDev')
    }
  }
}

const lightCopyElem = async function(cbl,id)
{
  const deflt = document.getElementById(`nom_${cbl}_${id}`).value+"(1)"
  const obj = await getTxt("../resources/json/cmdTxt.json")
  const nom = prompt(obj[`cop_${cbl}`][id_lng],deflt)
  if(nom == null || nom == '')
    return
  load('CAT lightCopyElem')
  const xhr = new XMLHttpRequest
  xhr.open("POST","../resources/php/lightCopyElem.php")
  xhr.setRequestHeader("Content-Type", "application/json")
  xhr.send(JSON.stringify({ cbl, id, nom }))
  xhr.onreadystatechange = () => {
    if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
    {
      const rsp = JSON.parse(xhr.response)
      window.parent.opn_frm(`cat/ctr.php?cbl=${cbl}&id=${rsp}`)
      act_acc()
      window.parent.act_frm(cbl)
      window.parent.act_frm(`up_${cbl}`)
      if(cbl=='prs')
        window.parent.act_frm('ajt_prs_opt')
      unload('CAT lightCopyElem')
    }
  }
}
