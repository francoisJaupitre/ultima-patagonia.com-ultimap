var upd = 0 //used by root
var flg_maj = true, id_lng, cbl_cat, id_cat, aut, url //encapsulate asap

(function()
{
  id_lng = parent.document.getElementById('id_lng').value
  cbl_cat = document.getElementById('cbl_cat').value
  document.getElementById('cbl_cat').remove()
  id_cat = document.getElementById('id_cat').value
  document.getElementById('id_cat').remove()
  aut = document.getElementById('aut').value
  document.getElementById('aut').remove()
  url = document.getElementById('url').value
  document.getElementById('url').remove()
  init()
  if(document.getElementById("adDev"))
    document.getElementById("adDev").onclick = () => { addDev(id_cat) }
  if(document.getElementById("copElem"))
    document.getElementById("copElem").onclick = () => { copyElem(cbl_cat, id_cat) }
  if(document.getElementById("delElem"))
    document.getElementById("delElem").onclick = () => { deleteElem(cbl_cat, id_cat) }
  if(document.getElementById("lightCopElem"))
    document.getElementById("lightCopElem").onclick = () => { lightCopyElem(cbl_cat, id_cat) }
  const tdLgg = document.getElementsByClassName("remove-lgg")
  for(let item of tdLgg)
    item.onclick = () => {
      removeLgg(item.id)
    }
  const tdChm = document.getElementsByClassName("remove-chm-lgg")
  for(let item of tdChm)
    item.onclick = () => {
      console.log(item.id)
      removeChmLgg(item.id.split('_')[0], item.id.split('_')[1])
    }
})()

const copyElem = async function(cbl, id)
{
  const deflt = document.getElementById(`nom_${cbl}_${id}`).value+"(1)"
  const obj = await getTxt("../resources/json/scriptText.json")
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
			window.parent.act_frm(`up_${cbl}`)
      if(cbl == 'prs')
        window.parent.act_frm('ajt_prs_opt')
			unload('CAT copyElem')
		}
	}
}

const deleteElem = async function(cbl, id)
{
  const obj = await getTxt("../resources/json/scriptText.json")
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
  const obj = await getTxt("../resources/json/scriptText.json")
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

const lightCopyElem = async function(cbl, id)
{
  const deflt = document.getElementById(`nom_${cbl}_${id}`).value+"(1)"
  const obj = await getTxt("../resources/json/scriptText.json")
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
      //window.parent.act_frm(cbl)
      //window.parent.act_frm(`up_${cbl}`)
      if(cbl=='prs')
        window.parent.act_frm('ajt_prs_opt')
      unload('CAT lightCopyElem')
    }
  }
}

const insertWebsite = async function(elem,uid,id,lgg,lng)
{
	if(uid.length == 0)
  {
    const obj = await getTxt("../resources/json/scriptText.json")
		uid = prompt(obj["web0"][id_lng], uid)
		if(uid == '')
      return
		uid = uid.toLowerCase().replace(/\b[a-z]/g, function(letter)
    {
      return letter.toUpperCase()
		})
		uid = uid.trim().replace(/[\/\. ,:_]+/g, "-").replace(/["']/g, "-").replace(/&/g, "-").replace(/-+/g, "-").normalize("NFD").replace(/[\u0300-\u036f]/g, "")
		let link = url + lng
		if(elem == 'crc')
      link += '/circuit/'
		else if(elem == 'mdl')
      link += '/module/'
		link += encodeURIComponent(uid)
		check_url(link, function(status)
    {
	    if(status === 200)
      {
	      alt(obj["web1"][id_lng])
				return
	    }else if(status === 404)
        updateData(`cat_${elem}_txt`, "web_uid", uid, id)
		})
	}else
    web_pub(elem,uid,id,lgg,lng)
}

const duplicate = async function(cbl, id)
{
  const obj = await getTxt("../resources/json/scriptText.json")
  window.parent.box("?",obj[`dup_${cbl}`][id_lng], () => {
    load('CAT duplicate')
    const xhr = new XMLHttpRequest
    xhr.open("POST","../resources/php/duplicate.php")
    xhr.setRequestHeader("Content-Type", "application/json")
    xhr.send(JSON.stringify({ cbl, id }))
    xhr.onreadystatechange = () => {
      if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
      {
        if(cbl=='chm')
        {
          vue_elem('hbr_chm', id_cat)
        }else if(cbl=='trf')
        {
          vue_elem('dt_srv', id_cat)
        }
        unload('CAT duplicate')
      }
    }
  })
}

const removeLgg = async function(id)
{
  const obj = await getTxt("../resources/json/scriptText.json")
  window.parent.box("?", obj[`sup_lgg`][id_lng], () => {
    load('CAT removeLgg')
    const xhr = new XMLHttpRequest
    xhr.open("POST","../resources/php/removeLgg.php")
    xhr.setRequestHeader("Content-Type", "application/json")
    xhr.send(JSON.stringify({ cbl: cbl_cat, id }))
    xhr.onreadystatechange = () => {
      if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
      {
        vue_elem(`${cbl_cat}_txt`,id_cat)
        window.parent.act_frm(cbl_cat)
        act_acc()
        unload('CAT removeLgg')
      }
    }
  })
}

const removeSrvTrf = async function(id_srv_trf)
{
  const obj = await getTxt("../resources/json/scriptText.json")
  window.parent.box("?", obj[`sup_srv_trf`][id_lng], () => {
    load('CAT removeSrvTrf')
    const xhr = new XMLHttpRequest
    xhr.open("POST","../resources/php/removeSrvTrf.php")
    xhr.setRequestHeader("Content-Type", "application/json")
    xhr.send(JSON.stringify({ id_srv_trf }))
    xhr.onreadystatechange = () => {
      if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
      {
        vue_elem('dt_srv', id_cat)
				window.parent.act_frm('frn_srv')
        act_acc()
        unload('CAT removeSrvTrf')
      }
    }
  })
}

const removeSrvTrfSsn = async function(id_srv_trf_ssn, id_srv_trf)
{
  const obj = await getTxt("../resources/json/scriptText.json")
  window.parent.box("?", obj[`sup_srv_trf_ssn`][id_lng], () => {
    load('CAT removeSrvTrfSsn')
    const xhr = new XMLHttpRequest
    xhr.open("POST","../resources/php/removeSrvTrfSsn.php")
    xhr.setRequestHeader("Content-Type", "application/json")
    xhr.send(JSON.stringify({ id_srv_trf_ssn, id_srv_trf }))
    xhr.onreadystatechange = () => {
      if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
      {
        const rsp = JSON.parse(xhr.response)
        if(rsp == 1)
        {
          const tdSsn = document.getElementsByClassName(`td_ssn${id_srv_trf_ssn}`)
          for(let item of tdSsn)
            item.display = "none"
        }else{
          vue_elem('dt_srv',id_cat)
        }
        act_acc()
        unload('CAT removeSrvTrfSsn')
      }
    }
  })
}

const removeSrvTrfBss = async function(id_srv_trf_bss)
{
  const obj = await getTxt("../resources/json/scriptText.json")
  window.parent.box("?", obj[`sup_srv_trf_bss`][id_lng], () => {
    load('CAT removeSrvTrfBss')
    const xhr = new XMLHttpRequest
    xhr.open("POST","../resources/php/removeSrvTrfBss.php")
    xhr.setRequestHeader("Content-Type", "application/json")
    xhr.send(JSON.stringify({ id_srv_trf_bss }))
    xhr.onreadystatechange = () => {
      if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
      {
        vue_elem('dt_srv',id_cat)
        unload('CAT removeSrvTrfBss')
      }
    }
  })
}

const removeHbrChm = async function(id_hbr_chm)
{
  const obj = await getTxt("../resources/json/scriptText.json")
  window.parent.box("?", obj[`sup_hbr_chm`][id_lng], () => {
    load('CAT removeHbrChm')
    const xhr = new XMLHttpRequest
    xhr.open("POST","../resources/php/removeHbrChm.php")
    xhr.setRequestHeader("Content-Type", "application/json")
    xhr.send(JSON.stringify({ id_hbr_chm }))
    xhr.onreadystatechange = () => {
      if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
      {
        if(xhr.response.length > 0)
        {
          alt(JSON.parse(xhr.response))
        }else{
          vue_elem('hbr_chm',id_cat)
          vue_elem('hbr_rgm',id_cat)
          act_acc()
        }
        unload('CAT removeHbrChm')
      }
    }
  })
}

const removeHbrChmTrf = async function(id_hbr_chm_trf)
{
  const obj = await getTxt("../resources/json/scriptText.json")
  window.parent.box("?", obj[`sup_hbr_chm_trf`][id_lng], () => {
    load('CAT removeHbrChmTrf')
    const xhr = new XMLHttpRequest
    xhr.open("POST","../resources/php/removeHbrChmTrf.php")
    xhr.setRequestHeader("Content-Type", "application/json")
    xhr.send(JSON.stringify({ id_hbr_chm_trf }))
    xhr.onreadystatechange = () => {
      if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
      {
        vue_elem('hbr_chm', id_cat)
        act_acc()
        unload('CAT removeHbrChmTrf')
      }
    }
  })
}

const removeHbrChmTrfSsn = async function(id_hbr_chm_trf_ssn)
{
  const obj = await getTxt("../resources/json/scriptText.json")
  window.parent.box("?", obj[`sup_hbr_chm_trf_ssn`][id_lng], () => {
    load('CAT removeHbrChmTrfSsn')
    const xhr = new XMLHttpRequest
    xhr.open("POST","../resources/php/removeHbrChmTrfSsn.php")
    xhr.setRequestHeader("Content-Type", "application/json")
    xhr.send(JSON.stringify({ id_hbr_chm_trf_ssn }))
    xhr.onreadystatechange = () => {
      if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
      {
        vue_elem('hbr_chm', id_cat)
        act_acc()
        unload('CAT removeHbrChmTrfSsn')
      }
    }
  })
}

const removeHbrRgm = async function(id_hbr_chm)
{
  const obj = await getTxt("../resources/json/scriptText.json")
  window.parent.box("?", obj[`sup_hbr_rgm`][id_lng], () => {
    load('CAT removeHbrRgm')
    const xhr = new XMLHttpRequest
    xhr.open("POST","../resources/php/removeHbrRgm.php")
    xhr.setRequestHeader("Content-Type", "application/json")
    xhr.send(JSON.stringify({ id_hbr_rgm }))
    xhr.onreadystatechange = () => {
      if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
      {
        vue_elem('hbr_rgm',id_cat)
        window.parent.act_frm('hbr')
        if(xhr.response.length > 0)
        {
          const rsp = JSON.parse(xhr.response)
          for(let i = 0; i < rsp.length; i++)
            if(rsp[i] > 0)
            {
              vue_elem(`hbr_chm_rgm${rsp[i]}`, id_cat);
            }
        }
        unload('CAT removeHbrRgm')
      }
    }
  })
}

const removeHbrRgmTrf = async function(id_hbr_rgm_trf)
{
  const obj = await getTxt("../resources/json/scriptText.json")
  window.parent.box("?", obj[`sup_hbr_rgm_trf`][id_lng], () => {
    load('CAT removeHbrRgmTrf')
    const xhr = new XMLHttpRequest
    xhr.open("POST","../resources/php/removeHbrRgmTrf.php")
    xhr.setRequestHeader("Content-Type", "application/json")
    xhr.send(JSON.stringify({ id_hbr_rgm_trf }))
    xhr.onreadystatechange = () => {
      if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
      {
        vue_elem('hbr_rgm',id_cat)
        unload('CAT removeHbrRgmTrf')
      }
    }
  })
}

const removeHbrRgmTrfSsn = async function(id_hbr_rgm_trf_ssn)
{
  const obj = await getTxt("../resources/json/scriptText.json")
  window.parent.box("?", obj[`sup_hbr_rgm_trf`][id_lng], () => {
    load('CAT removeHbrRgmTrf')
    const xhr = new XMLHttpRequest
    xhr.open("POST","../resources/php/removeHbrRgmTrfSsn.php")
    xhr.setRequestHeader("Content-Type", "application/json")
    xhr.send(JSON.stringify({ id_hbr_rgm_trf_ssn }))
    xhr.onreadystatechange = () => {
      if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
      {
        vue_elem('hbr_rgm',id_cat)
        unload('CAT removeHbrRgmTrfSsn')
      }
    }
  })
}

/* asynchronous functions above */

const removeChmLgg = (id, id_chm) => {
  load('CAT removeChmLgg')
  const xhr = new XMLHttpRequest
  xhr.open("POST","../resources/php/removeLgg.php")
  xhr.setRequestHeader("Content-Type", "application/json")
  xhr.send(JSON.stringify({ cbl: 'hbr_chm', id }))
  xhr.onreadystatechange = () => {
    if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
    {
      vue_elem(`hbr_chm_txt${id_chm}`, id_chm)
      unload('CAT removeChmLgg')
    }
  }
}

const updateData = (tab, col, val, id, id_sup) => {
	if(flg_maj)
  {
    upd++
    console.log('upd', upd)
    flg_maj = false
  }
  if(id_sup > 0)
    load('CAT updateData')
  const xhr = new XMLHttpRequest
  xhr.open("POST","../resources/php/updateCatDB.php")
  xhr.setRequestHeader("Content-Type", "application/json")
  xhr.send(JSON.stringify({ tab, col, val, id, id_sup }))
  xhr.onreadystatechange = () => {
    if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
    {
      const rsp = JSON.parse(xhr.response)
      switch(col)
      {
        case 'nom':
          act_tab()
          if(tab == 'cat_chm')
            vue_elem('hbr_chm', id_sup)
        case 'info':
          act_acc()
          window.parent.act_frm(`list_${cbl_cat}`)
          window.parent.act_frm(`up_${cbl_cat}`)
          break
        case 'titre':
          if(tab == 'cat_crc_txt')
            vue_elem(`crc_web${id}`, id_cat)
          else if(tab == 'cat_mdl_txt')
            vue_elem(`mdl_web${id}`, id_cat)
          act_acc()
          break
        case 'mail':
          if(tab == 'cat_frn')
            vue_elem('frn_mail', id)
          else if(tab == 'cat_hbr')
            vue_elem('hbr_mail', id)
          break
        case 'mail_frt':
          vue_elem('hbr_frt_mail',id)
          break
        case 'ord':
          switch(tab) {
            case 'cat_crc_mdl':
              vue_elem('crc_mdl', id_sup)
              break
            case 'cat_mdl_jrn':
              vue_elem('mdl_jrn', id_sup)
              break
            case 'cat_jrn_vll':
              vue_elem('jrn_vll', id_sup)
              act_acc()
              break
            case 'cat_jrn_lieu':
              vue_elem('jrn_lieu', id_sup)
              break
            case 'cat_jrn_prs':
              vue_elem('jrn_prs', id_sup)
              window.parent.act_frm('dt_jrn')
              break
            case 'cat_prs_lieu':
              vue_elem('prs_lieu', id_sup)
              window.parent.act_frm('prs')
              break
          }
          break
        case 'fus':
          vue_elem('crc_mdl',id_sup)
          break
        case 'opt':
          switch(tab) {
            case 'cat_mdl_jrn':
              vue_elem('mdl_jrn', id_sup)
              window.parent.act_frm('jrn_opt')
              break
            case 'cat_jrn_prs':
              vue_elem('jrn_prs', id_sup)
              window.parent.act_frm('prs_opt')
              break
            case 'cat_prs_hbr':
              vue_elem('prs_hbr', id_sup)
              break
          }
          break
        case 'ctg':
        case 'id_ctg':
        case 'id_vll':
        case 'id_rgn':
        case 'id_pays':
          act_acc()
          window.parent.act_frm(cbl_cat)
          if(tab == 'cat_srv')
          {
            act_frm('frn')
            act_frm('frn_srv')
          }
          break
        case 'web_uid':
          act_acc()
        case 'web_mdp':
          if(tab == 'cat_crc_txt')
            vue_elem('crc_txt', id_cat)
          else if(tab == 'cat_mdl_txt')
            vue_elem('mdl_txt', id_cat)
          break
        case 'dt_max':
        case 'nvtrf':
        case 'lstrg':
        case 'ferme':
          act_acc()
          break
        case 'sel_mdl_jrn':
          if(tab == 'cat_crc_mdl')
            vue_elem('crc_mdl', id_cat)
          else if(tab == 'cat_mdl')
            vue_elem('mdl_jrn', id_cat)
          break
      }
      switch(tab)
      {
    		case 'cat_prs':
    			if(col == "ctg")
            vue_elem("prs_ctg", id)
    			else if(col == "jours")
            vue_elem("prs", id, "jours")
          break
    		case 'cat_srv':
    			if(col == "id_vll")
            vue_elem("srv_vll", id)
    			else if(col == "ctg")
          {
            vue_elem("srv_ctg", id)
            vue_elem("srv_lgg", id)
          }else if(col == "lgg")
            vue_elem("srv_lgg", id)
    			else if(col == 'vrl')
            window.parent.act_frm(`dt_srv${id}`)
          break
        case 'cat_srv_trf':
    			if(id_sup > 0)
            vue_elem('dt_srv', id_sup)
    			else if(col == "crr")
          {
            vue_elem(`dt_srv_crr${id}`, id)
            const tdTrf = document.getElementsByClassName(`ipt_srv_trf${id}`)
            for(let item of tdTrf)
                vue_elem('srv_trf_bss', item.id.substr(19), item.id.substr(12, 7))
          }
          break
        case 'cat_srv_trf_bss':
    			if(col == 'id_frn')
          {
    				vue_elem(`dt_srv_frn${id}`, id_sup)
    				window.parent.act_frm('frn_srv')
    			}else{
    				vue_elem('srv_trf_bss', id, col)
    				if(col == "trf_rck" || col == "trf_net")
              vue_elem(`dt_srv_com${id}`, id)
    				else if(col == 'bs_min')
              vue_elem('srv_trf_bss', id, 'bs_max')
    			}
          break
    		case 'cat_srv_trf_ssn':
    			vue_elem('dt_srv', id_sup)
    			if(col == 'dt_min' || col == 'dt_max')
            window.parent.act_frm('frn_srv')
          break
        case 'cat_hbr':
    			if(col == "id_vll")
          {
    				vue_elem("hbr_vll", id)
    				vue_elem("hbr_frn", id)
    				if(val > 0)
            {
    					act_frm('frn_hbr')
              window.parent.box("?",rsp[1], () => {
    						maj_hbr_vll(id,val)
    						//if(aut)
    							vue_map_init(document.getElementById("nom_vll").value)
    						/*else
                  vue_map_init_noevent()*/
    					})
    				}
    			}else if(col == "adresse" && val != '')
          {
            window.parent.box("?",rsp[1], () => {
              vue_map_address(`${val}, ${document.getElementById("nom_vll").value}`)
            })
    			}else if(col == "lat" || col == "lon")
          {
    				vue_elem('hbr', id, col)
    				if(id_sup == 0)
              vue_map()
    				window.parent.act_frm(cbl_cat)
    			}else if(id_sup > 0)
            vue()
    			else if(col == "id_frn")
          {
            vue_elem('hbr_frn', id)
            window.parent.act_frm('frn_hbr')
          }else if(col == "ctg")
            vue_elem("hbr_ctg", id)
    			else if(col == "id_vll")
            vue_elem("hbr_vll", id)
    			else if(col == "ctg_res")
            vue_elem("hbr_ctg_res", id)
    			else if(col == "id_bnq")
            vue_elem("hbr_bnq", id)
    			else if(col == 'frs')
            vue_elem('hbr', id, col)
    			else if(col == 'vrl')
          {
            window.parent.act_frm(`hbr_chm${id}`)
            window.parent.act_frm(`hbr_rgm${id}`)
          }
    			break
    		case 'cat_hbr_txt':
    			if(col == 'web')
            vue_elem('hbr_txt', id_sup)
    			break
        case 'cat_hbr_pay':
          if(col == "ty_delai")
            vue_elem("hbr_pay_ty_delai", id)
        	break
        case 'cat_hbr_chm':
    			if(col == 'rgm')
          {
            vue_elem(`hbr_chm_rgm${id}`, id_sup)
            vue_elem('hbr_rgm', id_sup)
            window.parent.act_frm('hbr')
          }else if(id_sup > 0)
            vue_elem('hbr_chm', id_sup)
            break
    		case 'cat_hbr_chm_trf':
        	if(id_sup > 0)
            vue_elem('hbr_chm', id_sup)
    			else if(col == "crr")
            vue_elem(`hbr_chm_crr${id}`, id)
    			else
            vue_elem('hbr_chm_trf', id, col)
          break
        case 'cat_hbr_chm_trf_ssn':
          vue_elem('hbr_chm', id_sup)
          break
        case 'cat_hbr_rgm':
          if(id_sup > 0)
            vue_elem('hbr_rgm', id_sup)
          break
        case 'cat_hbr_rgm_trf':
    			if(id_sup > 0)
            vue_elem('hbr_rgm', id_sup)
    			else if(col == "crr")
            vue_elem(`hbr_rgm_crr${id}`, id)
        	else
            vue_elem('hbr_rgm_trf', id, col)
          break
        case 'cat_hbr_rgm_trf_ssn':
          vue_elem('hbr_rgm', id_sup)
          break
        case 'cat_clt':
    			if(col == "id_ctg")
            vue_elem("clt_ctg", id)
    			else if(col == "crr")
            vue_elem("clt_crr", id)
          break
        case 'cat_frn':
    			if(col == "ctg_res")
            vue_elem("frn_ctg_res", id)
    			else if(col == "id_bnq")
            vue_elem("frn_bnq", id)
    			else if(col == 'frs')
          {
    				vue_elem('frn', id, col);
            window.parent.act_frm('hbr_frn')
    				window.parent.act_frm('crc_dev_res')
    			}
          break
        case 'cat_frn_pay':
          if(col == "ty_delai")
            vue_elem("frn_pay_ty_delai", id)
          break
        case 'cat_vll':
          if(col == "nom" && val != '')
          {
            window.parent.box("?",obj["act_map"][id_lng], () => {
              const nom_pays = document.getElementById("nom_pays").value
              vue_map_address(`${val}, ${nom_pays}`)
            })
    			}
          break
        case 'cat_lieu':
    			if(col == "nom" && val != '')
          {
            window.parent.box("?",rsp[1], () => {
              if(document.getElementById("nom_vll")) {val += ', '+document.getElementById("nom_vll").value;}
      				if(document.getElementById("nom_pays")) {val += ', '+document.getElementById("nom_pays").value;}
              vue_map_address(val)
            })
    			}else if(col == "id_vll" && val > 0)
          {
            window.parent.box("?",rsp[1], () => {
              maj_lieu_vll(id,val);
              //if(aut)
                vue_map_init(document.getElementById("nom_vll").value)
              /*else
                vue_map_init_noevent()*/
            })
    				vue_elem("lieu_vll", id)
    			}else if(col == "lat" || col == "lon")
          {
    				vue_elem('lieu', id, col)
    				if(id_sup == 0)
              vue_map()
    			}
          break
        case 'cat_pic':
          if(col == "id_rgn")
            vue_elem("pic_rgn", id)
          break
        case 'cat_vll':
    			if(col == "id_rgn")
            vue_elem("vll_rgn", id)
    			else if(col == "id_pays")
            vue_elem("vll_pays", id)
    			else if(col == "lat" || col == "lon")
          {
    				vue_elem('vll', id, col)
    				if(id_sup==0)
              vue_map()
    			}
          break
        case 'cat_bnq':
          if(col=="id_pays")
            vue_elem("bnq_pays", id)
          break
        case 'dev_hbr_pay':
          if(col == 'pay')
            window.parent.act_frm('hbr_pay_pay')
          break
        case 'dev_srv_pay':
          if(col == 'pay')
            window.parent.act_frm('srv_pay_pay')
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
        unload('CAT updateData')
    }
  }
}

const insertPrs = id_prs => {
	load('CAT insertPrs')
  const xhr = new XMLHttpRequest
  xhr.open("POST","../resources/php/insertPrs.php")
  xhr.setRequestHeader("Content-Type", "application/json")
  xhr.send(JSON.stringify({ id_jrn : id_cat, id_prs }))
  xhr.onreadystatechange = () => {
    if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
    {
      const rsp = JSON.parse(xhr.response)
      if(rsp == 1)
      {
        //vue_elem('jrn_prs',id_cat)
        window.parent.act_frm('list_jrn_prs')
      }else{
        alt(rsp)
			}
			unload('CAT insertPrs')
		}
	}
}

const insertOptionalPrs = (id_prs, ord) => {
  load('CAT insertOptionalPrs')
  const xhr = new XMLHttpRequest
  xhr.open("POST","../resources/php/insertOptionalPrs.php")
  xhr.setRequestHeader("Content-Type", "application/json")
  xhr.send(JSON.stringify({ id_jrn : id_cat, id_prs, ord }))
  xhr.onreadystatechange = () => {
    if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
    {
      const rsp = JSON.parse(xhr.response)
      if(rsp == 1)
      {
        vue_elem('jrn_prs', id_cat)
        window.parent.act_frm('up_jrn')
        window.parent.act_frm('ajt_prs_opt')
        window.parent.act_frm('prs_opt')
      }else{
        alt(rsp)
      }
      unload('CAT insertOptionalPrs')
    }
  }
}
