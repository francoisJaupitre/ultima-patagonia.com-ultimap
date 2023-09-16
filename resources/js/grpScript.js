var upd = 0 //used by root
var flg_maj = true, id_grp //encapsulate asap

(function()
{
  id_grp = document.getElementById('id_grp').value
  document.getElementById('id_grp').remove()
  const id_lng = parent.document.getElementById('id_lng').value
  const autDev = document.getElementById('autDev').value
  document.getElementById('autDev').remove()
  const autRes = document.getElementById('autRes').value
  document.getElementById('autRes').remove()

  const allow = () => {
    if((autDev || aurRes) && document.getElementById("adPax"))
    {
      document.getElementById("adPax").innerHTML ='<img src="../prm/img/ajt.png" />'
      document.getElementById("adPax").onclick = (id_grp) => { addPax(id_grp) }
      const trPax = document.getElementsByClassName("tr-pax")

      for(let item of trPax)
      {
        const id_pax = item.id.substring(5)
        const tdRemove = item.getElementsByClassName("remove-pax")[0]
        tdRemove.innerHTML = '<img src="../prm/img/sup.png" />'
        tdRemove.onclick = () => {
          removePax(id_pax)
        }
        const tdPrt = item.getElementsByClassName("prt-pax")[0]
        const chkPrt = tdPrt.querySelector('input')
        if(chkPrt.checked)
          chkPrt.onclick = () => {
            updateData('grp_pax', 'prt', '0', id_pax)
          }
        else
          chkPrt.onclick = () => {
            updateData('grp_pax', 'prt', '1', id_pax)
          }
      }
    }
  }

  const updateTab = () => {
  	const xhr = new XMLHttpRequest
    xhr.open("POST", "../resources/php/updateGrpTab.php")
    xhr.setRequestHeader("Content-Type", "application/json")
    xhr.send(JSON.stringify({ id_grp }))
    xhr.onreadystatechange = () => {
      if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
      {
        if(xhr.response.length > 0)
          window.parent.act_tab(`grp/ctr.php?id=${id_grp}`, JSON.parse(xhr.response))
      }
  	}
  }

  const addPax = () => {
    load('GRP addPax')
    const xhr = new XMLHttpRequest
    xhr.open("POST","../resources/php/addGrpPax.php")
    xhr.setRequestHeader("Content-Type", "application/json")
    xhr.send(JSON.stringify({ id_grp }))
    xhr.onreadystatechange = () => {
      if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
      {
        viewPax()
        window.parent.act_frm('pax')
        updateTab()
        unload('GRP addPax')
      }
    }
  }

  const removePax = (id_pax) => {
    load('GRP removePax')
    const xhr = new XMLHttpRequest
    xhr.open("POST","../resources/php/removeGrpPax.php")
    xhr.setRequestHeader("Content-Type", "application/json")
    xhr.send(JSON.stringify({ id_pax }))
    xhr.onreadystatechange = () => {
      if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
      {
        if(xhr.response.length == 0)
        {
          viewPax()
          window.parent.act_frm('pax')
          updateTab()
        }else{
          const rsp = JSON.parse(xhr.response)
          alt(rsp[0])
        }
        unload('GRP removePax')
      }
    }
  }

  const updateData = (tab, col, val, id) => {
    if(flg_maj)
    {
      upd++
      console.log('upd', upd)
      flg_maj = false
    }
    const xhr = new XMLHttpRequest
    xhr.open("POST", "../resources/php/updateGrpDB.php")
    xhr.setRequestHeader("Content-Type", "application/json")
    xhr.send(JSON.stringify({ tab, col, val, id }))
    xhr.onreadystatechange = () => {
      if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
      {
        switch(col)
        {
          case 'nomgrp':
            act_tab()
            window.parent.act_frm('grp')
            break
          case 'prt':
            act_tab()
            viewPax()
          case 'nom':
          case 'pre':
            window.parent.act_frm('pax')
            break
          case 'dob':
          case 'exp':
            vue_elem('pax', id, col)
            break
          case 'ncn':
            vue_elem(`pax_ncn${id}`, id_grp)
            break
          case 'date':
          case 'respon':
          case 'stat':
            vue_elem('tsk_grp')
            break
        }
        if(tab == 'grp_tsk')
          window.parent.act_frm('tsk')
      	if(!flg_maj)
        {
      		upd--
      		console.log('upd',upd)
      		flg_maj = true
      	}
      }
    }
  }
  const viewPax = () => {
    //load('GRP viewPax')
    const xhr = new XMLHttpRequest
    xhr.open("POST","vue_pax.php")
    xhr.setRequestHeader("Content-Type", "application/json")
    xhr.send(JSON.stringify({ id_grp }))
    xhr.onreadystatechange = () => {
      if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
      {
        document.getElementById('pax_grp').innerHTML = xhr.response
        allow()
        //unload('GRP viewPax')
      }
    }
  }

  updateTab()
  allow()
  unload('GRP')
})()
