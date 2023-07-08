const addElem = async function(cbl,id_cat) {
  const obj = await getTxt("../resources/json/scriptTxt.json")
  const nom = prompt(obj["ajt_"+cbl][id_lng])
  let grp, clt, rgn, vll, ctg
  if(nom == null || nom == '') { return }
  if(cbl == 'dev' && id_cat == 0) { grp = document.getElementById('grp').value }
  if( (cbl == 'dev' && id_cat == 0) || cbl == 'grp') { clt = document.getElementById('clt').value }
  if(cbl == 'mdl' || cbl == 'vll') { rgn = document.getElementById('rgn').value }
  if(cbl == 'jrn' || cbl == 'srv' || cbl == 'hbr' || cbl == 'frn' || cbl == 'lieu') { vll = document.getElementById('vll').value }
  if(cbl == 'prs' || cbl == 'srv' || cbl == 'hbr' || cbl == 'frn') { ctg = document.getElementById('ctg').value }
  load('ACC ajt '+cbl);
  const xhr = new XMLHttpRequest
	xhr.open("POST","../resources/php/accAddElem.php")
	xhr.setRequestHeader("Content-Type", "application/json")
	xhr.send(JSON.stringify({ cbl, id_cat, nom, grp, clt, vll, ctg ,rgn }	))
  xhr.onreadystatechange = () => {
    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
      const rsp = JSON.parse(xhr.response)
      if(cbl == 'dev') {
        window.parent.act_frm('grp')
        window.parent.act_frm('clt')
        window.parent.opn_frm('dev/ctr.php?id='+rsp[0])
        window.parent.act_frm('cat_dev')
        window.parent.act_frm('grp_crc')
        window.parent.act_frm('grp_clt')
        window.parent.act_frm('clt_crc')
        if(id_cat>0) {
          vue_menu(cbl,'dev')
          vue_lst(cbl)
        }
        else { vue_dev(cbl) }
      }
      else if(cbl == 'grp') {
        window.parent.opn_frm('grp/ctr.php?id='+rsp[0])
        vue_grp('gr0',clt)
      }
      else {
        window.parent.opn_frm('cat/ctr.php?cbl='+cbl+'&id='+rsp[0])
        vue_cat(cbl)
      }
      window.parent.act_frm(cbl)
      if(rsp[1] != '') { alt(rsp[1]) }
      if(rsp[2] != '') { alt(rsp[2]) }
      unload('ACC ajt '+cbl)
    }
  }
}

const newVersion = async function(id_crc) {
  const obj = await getTxt("../resources/json/scriptTxt.json")
  window.parent.box("?",obj["vrs"][id_lng], () => {
    load('ACC vrs');
    const xhr = new XMLHttpRequest
    xhr.open("POST","../resources/php/devNewVersion.php")
    xhr.setRequestHeader("Content-Type", "application/json")
    xhr.send(JSON.stringify({ id_crc }	))
    xhr.onreadystatechange = () => {
      if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
        const rsp = JSON.parse(xhr.response)
        window.parent.opn_frm('dev/ctr.php?id='+rsp)
        window.parent.act_frm('grp_crc')
        vue_dev('dev')
        unload('ACC vrs')
      }
    }
  })
}
