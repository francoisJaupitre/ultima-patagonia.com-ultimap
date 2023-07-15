const newVersion = async function(id_crc)
{
  const obj = await getTxt("../resources/json/scriptTxt.json")
  window.parent.box("?",obj["vrs"][id_lng], () => {
    load('DEV newVersion')
    const xhr = new XMLHttpRequest
    xhr.open("POST","../resources/php/newVersion.php")
    xhr.setRequestHeader("Content-Type", "application/json")
    xhr.send(JSON.stringify({ id_crc }))
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

const searchHbr = async function(id_cat_hbr,id_cat_chm,id_hbr_vll,id_hbr_rgm,id_dev_hbr,id_dev_prs,res)
{
  const obj = await getTxt("../resources/json/scriptTxt.json")
  load('DEV searchHbr')
  const xhr = new XMLHttpRequest
  xhr.open("POST","../resources/php/searchHbr.php")
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
            if(window.confirm(obj["src_hbr2"][id_lng]+` ${rsp.length} `+obj["src_hbr0"][id_lng]))
            {
              for(let i = 0; i < rsp.length; i++)
                maj('dev_hbr', res, '1', rsp[i][0], rsp[i][1])
              vue_crc('res')
            }
          }
          else if(res == 'ajt')
          {
            if(window.confirm(obj["src_hbr1"][id_lng]+` ${rsp.length} `+obj["src_hbr0"][id_lng]))
            {
              for(let i = 0; i < rsp.length; i++)
                ajt_hbr(id_cat_hbr, id_cat_chm, id_hbr_vll, id_hbr_rgm, rsp[i], 0, 0)
            }
          }
          else if(res == 'sup')
          {
            if(window.confirm(obj["src_hbr3"][id_lng]+` ${rsp.length} `+obj["src_hbr0"][id_lng]))
            {
              for(let i = 0; i < rsp.length; i++)
                sup('hbr', rsp[i][0], rsp[i][1], 1, id_cat_hbr)
            }
          }
        }
        else if(id_dev_prs != 0 && id_dev_hbr == 0) //ajt_opt
        {
          if(window.confirm(obj["src_hbr5"][id_lng]+` ${rsp.length} `+obj["src_hbr4"][id_lng]))
          {
            for(let i = 0; i < rsp.length; i++)
              ajt_hbr(id_cat_hbr, id_cat_chm, id_hbr_vll, id_hbr_rgm, 0, rsp[i], 0)
          }
        }
        else if(id_dev_prs == 0 && id_dev_hbr != 0) //maj_res
        {
          if(window.confirm(obj["src_hbr6"][id_lng]+` ${rsp.length} `+obj["src_hbr4"][id_lng]))
          {
            for(let i = 0; i < rsp.length; i++)
            {
              maj('dev_hbr', 'res', res, rsp[i])
              vue_elem(`hbr_res${rsp[i]}`, rsp[i])
            }
            vue_crc('res')
          }
        }
        else if(id_dev_prs == 0 && id_dev_hbr == 0)
        {
          if(res == 'act_trf')
          {
            if(window.confirm(obj["src_hbr8"][id_lng]+` ${rsp.length} `+obj["src_hbr9"][id_lng]))
            {
              if(cnf>0)
              {
                if(window.confirm(obj["cnf"][id_lng]) == false)
                  return 0
              }
              act_trf('hbr_all', rsp, 0)
            }
          }
          else if(res == 'sup')
          {
            if(window.confirm(obj["src_hbr10"][id_lng]+` ${rsp.length} `+obj["src_hbr11"][id_lng]))
            {
              if(cnf > 0)
              {
                if(window.confirm(obj["cnf"][id_lng]) == false)
                  return 0
              }
              for(let i = 0; i < rsp.length; i++)
              {
                eval('var arr_hbr2'+xhr+'=arr_hbr'+xhr+'[i].split("_")')
                sup('hbr', rsp[i][0], rsp[i][1], 1, id_cat_hbr)
              }
            }
          }
        }
      }
      unload('DEV searchHbr')
    }
  }
}

const searchSrv = async function(id_frn,id_dev_srv_ctg,id_dev_srv_vll,id_dev_srv)
{
  const obj = await getTxt("../resources/json/scriptTxt.json")
  load('DEV searchSrv')
  const xhr = new XMLHttpRequest
  xhr.open("POST","../resources/php/searchSrv.php")
  xhr.setRequestHeader("Content-Type", "application/json")
  xhr.send(JSON.stringify({ id_dev_srv_ctg, id_dev_srv_vll, id_dev_srv, id_dev_crc, id_frn }))
  xhr.onreadystatechange = () => {
    if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
    {
      if(xhr.response != 0)
      {
        const rsp = JSON.parse(xhr.response)
        if(id_dev_srv_vll > 0 && id_dev_srv > 0)
        {
          if(window.confirm(obj["src_srv1"][id_lng]+` ${rsp.length} `+obj["src_srv0"][id_lng]))
          {
            for(let i = 0; i < rsp.length; i++)
              maj('dev_srv','id_frn',id_frn,rsp[i])
          }
        }
        else if(window.confirm(obj["src_srv2"][id_lng]+` ${rsp.length} `+obj["src_srv0"][id_lng]))
        {
          for(let i = 0; i < rsp.length; i++)
            maj('dev_srv','id_frn',0,rsp[i])
        }
      }
      unload('DEV searchSrv')
    }
  }
}

const searchFrn = async function(res,id_frn,id_dev_srv,id_dev_prs)
{
  const obj = await getTxt("../resources/json/scriptTxt.json")
  load('DEV searchFrn')
  const xhr = new XMLHttpRequest
  xhr.open("POST","../resources/php/searchFrn.php")
  xhr.setRequestHeader("Content-Type", "application/json")
  xhr.send(JSON.stringify({ id_frn, id_dev_srv, id_dev_crc, res, cnf }))
  xhr.onreadystatechange = () => {
    if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
    {
      if(xhr.response != 0)
      {
        const rsp = JSON.parse(xhr.response)
        if(res > -2 && res < 6 && id_dev_srv > 0)
        {
          if(res > -1)
          {
            if(window.confirm(obj["src_frn1"][id_lng]+` ${rsp.length} `+obj["src_frn0"][id_lng]))
            {
              for(let i = 0; i < rsp.length; i++)
              {
                maj('dev_srv','res',res,rsp[i])
                sel_srv('srv',rsp[i])
              }
            }
          }
          maj('dev_srv','res',res,id_dev_srv,id_dev_prs)
          vue_crc('res')
          window.parent.act_frm('frn_ope')
        }
        else if(res==0 && id_dev_srv==0)
        {
          if(window.confirm(obj["src_frn3"][id_lng]+` ${rsp.length} `+obj["src_frn4"][id_lng]))
          {
            if(cnf>0)
            {
              if(window.confirm(obj["cnf"][id_lng])==false)
                return 0
            }
            act_trf('frn_all',arr_srv,0)
          }
        }
      }
      unload('DEV searchFrn')
    }
  }
}
