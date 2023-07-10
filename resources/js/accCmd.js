const addElem = async function(cbl,id_cat)
{
  const obj = await getTxt("../resources/json/scriptTxt.json")
  const nom = prompt(obj[`ajt_${cbl}`][id_lng])
  let grp, clt, rgn, vll, ctg
  if(nom == null || nom == '')
    return
  if(cbl == 'dev' && id_cat == 0)
    grp = document.getElementById('grp').value
  if( (cbl == 'dev' && id_cat == 0) || cbl == 'grp')
    clt = document.getElementById('clt').value
  if(cbl == 'mdl' || cbl == 'vll')
    rgn = document.getElementById('rgn').value
  if(cbl == 'jrn' || cbl == 'srv' || cbl == 'hbr' || cbl == 'frn' || cbl == 'lieu')
    vll = document.getElementById('vll').value
  if(cbl == 'prs' || cbl == 'srv' || cbl == 'hbr' || cbl == 'frn')
    ctg = document.getElementById('ctg').value
  load(`ACC ajt ${cbl}`)
  const xhr = new XMLHttpRequest
	xhr.open("POST","../resources/php/addElem.php")
	xhr.setRequestHeader("Content-Type", "application/json")
	xhr.send(JSON.stringify({ cbl, id_cat, nom, grp, clt, vll, ctg ,rgn }	))
  xhr.onreadystatechange = () => {
    if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
    {
      const rsp = JSON.parse(xhr.response)
      if(cbl == 'dev')
      {
        window.parent.act_frm('grp')
        window.parent.act_frm('clt')
        window.parent.opn_frm(`dev/ctr.php?id=${rsp[0]}`)
        window.parent.act_frm('cat_dev')
        window.parent.act_frm('grp_crc')
        window.parent.act_frm('grp_clt')
        window.parent.act_frm('clt_crc')
        if(id_cat>0)
        {
          vue_menu(cbl,'dev')
          vue_lst(cbl)
        }else
          vue_dev(cbl)
      }else if(cbl == 'grp')
      {
        window.parent.opn_frm(`grp/ctr.php?id=${rsp[0]}`)
        vue_grp('gr0',clt)
      }else{
        window.parent.opn_frm(`cat/ctr.php?cbl=${cbl}&id=${rsp[0]}`)
        vue_cat(cbl)
      }
      window.parent.act_frm(cbl)
      if(rsp[1] != '')
        alt(rsp[1])
      if(rsp[2] != '')
        alt(rsp[2])
      unload(`ACC ajt ${cbl}`)
    }
  }
}

const newVersion = async function(id_crc)
{
  const obj = await getTxt("../resources/json/scriptTxt.json")
  window.parent.box("?",obj["vrs"][id_lng], () => {
    load('ACC vrs');
    const xhr = new XMLHttpRequest
    xhr.open("POST","../resources/php/newVersion.php")
    xhr.setRequestHeader("Content-Type", "application/json")
    xhr.send(JSON.stringify({ id_crc }	))
    xhr.onreadystatechange = () => {
      if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
      {
        const rsp = JSON.parse(xhr.response)
        window.parent.opn_frm(`dev/ctr.php?id=${rsp}`)
        window.parent.act_frm('grp_crc')
        vue_dev('dev')
        unload('ACC vrs')
      }
    }
  })
}

const copyElem = async function(cbl,id)
{
  const obj = await getTxt("../resources/json/scriptTxt.json")
  let nom
	if(cbl == 'dev' || cbl == 'arc' || cbl == 'cnf' || cbl == 'fin')
    nom = prompt(obj[`cop_${cbl}`][id_lng])
  else{
    const deflt = document.getElementById(`nom_${cbl}_${id}`).innerText+"(1)"
    nom = prompt(obj[`cop_${cbl}`][id_lng],deflt)
  }
	if(nom == null || nom == '')
    return
	load('ACC cop')
  const xhr = new XMLHttpRequest
	xhr.open("POST","../resources/php/copyElem.php")
	xhr.setRequestHeader("Content-Type", "application/json")
	xhr.send(JSON.stringify({ cbl, id, nom }))
  xhr.onreadystatechange = () => {
    if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
    {
      const rsp = JSON.parse(xhr.response)
			if(cbl == 'dev')
      {
				window.parent.opn_frm(`dev/ctr.php?id=${rsp}`)
				vue_menu(cbl,'dev')
				vue_lst(cbl)
			}else{
				window.parent.opn_frm(`cat/ctr.php?cbl=${cbl}&id=${rsp}`)
				vue_cat(cbl)
				window.parent.act_frm(cbl)
				window.parent.act_frm(`up_${cbl}`)
        window.parent.act_frm('ajt_prs_opt')
			}
			unload('ACC cop')
		}
	}
}

const deleteElem = async function(cbl,id)
{
  const obj = await getTxt("../resources/json/scriptTxt.json")
  window.parent.box("?",obj[`del_${cbl}`][id_lng], () => {
		load('ACC del');
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
          if(cbl == 'arc' || cbl == 'fin')
          {
            vue_lst(cbl)
						window.parent.sup_frm(`dev_devid${id}`)
						window.parent.sup_frm(`trf_devid${id}`)
						window.parent.sup_frm(`prg_devid${id}`)
						window.parent.sup_frm(`rbk_devid${id}`)
						window.parent.act_frm('grp')
						window.parent.act_frm('cat_dev')
						window.parent.act_frm('grp_crc')
						window.parent.act_frm('clt')
					}
					else if(cbl == 'gr0')
          {
						vue_grp('gr0')
						window.parent.sup_frm(`grpctrphpid${id}`)
						window.parent.act_frm("grp_crc")
					}else{
						vue_cat(cbl)
						window.parent.sup_frm(`catctrphpcbl${cbl}id${id}`)
						window.parent.act_frm(cbl)
						window.parent.act_frm(`up_${cbl}`)
					}
				}
				unload('ACC del')
      }
    }
  })
}

const multiDeleteElem = async function(cbl)
{
  let ids = []
  const chk = document.getElementsByClassName("chk")
  for (let i = 0; i < chk.length; i++)
  {
    if(chk[i].checked)
      ids.push(chk[i].id)
  }
	if(ids.length == 0)
    return
  const obj = await getTxt("../resources/json/scriptTxt.json")
  window.parent.box("?",obj[`del_pls_${cbl}`][id_lng]+` ${ids.length} `+obj[`del_pls_${cbl}2`][id_lng], () => {
    load('ACC del_pls')
    const xhr = new XMLHttpRequest
  	xhr.open("POST","../resources/php/multiDeleteElem.php")
  	xhr.setRequestHeader("Content-Type", "application/json")
  	xhr.send(JSON.stringify({ cbl, ids }	))
    xhr.onreadystatechange = () => {
      if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
      {
        if(xhr.response.length > 0)
          alt(JSON.parse(xhr.response))
        ids.forEach((key,id) => {
          if(cbl == 'arc')
          {
            window.parent.sup_frm(`dev_devid${id}`)
            window.parent.sup_frm(`trf_devid${id}`)
            window.parent.sup_frm(`prg_devid${id}`)
            window.parent.sup_frm(`rbk_devid${id}`)
          }
          else if(cbl=='grp')
            window.parent.sup_frm(`grpctrphpid${id}`)
        })
        if(cbl=='arc')
        {
          vue_lst(cbl)
          window.parent.act_frm('grp')
          window.parent.act_frm('cat_dev')
          window.parent.act_frm('grp_crc')
          window.parent.act_frm('clt')
        }
        else if(cbl=='grp')
        {
          vue_grp('gr0')
          window.parent.act_frm("grp_crc")
        }
        unload('ACC del_pls')
      }
    }
  })
}
