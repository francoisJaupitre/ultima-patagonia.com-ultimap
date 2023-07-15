const searchHbr = async function(id_cat_hbr,id_cat_chm,id_hbr_vll,id_hbr_rgm,id_dev_hbr,id_dev_prs,res, id_dev_crc)
{
  const obj = await getTxt("../resources/json/scriptTxt.json")
  load('OPE searchHbr')
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
        if(window.confirm(obj["src_hbr6"][id_lng]+` ${rsp.length} `+obj["src_hbr7"][id_lng]))
        {
          for(let i = 0; i < rsp.length; i++)
            maj('dev_hbr','res',res,rsp[i])
        }
      }
      unload('OPE searchHbr')
    }
  }
}

const searchSrv = async function(id_frn,id_dev_srv_ctg,id_dev_srv_vll,id_dev_srv,id_dev_crc)
{
  const obj = await getTxt("../resources/json/scriptTxt.json")
  load('OPE searchSrv')
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
      unload('OPE searchSrv')
    }
  }
}

const searchFrn = async function(res,id_frn,id_dev_srv,id_dev_crc)
{
  const obj = await getTxt("../resources/json/scriptTxt.json")
  load('OPE searchFrn')
  const xhr = new XMLHttpRequest
  xhr.open("POST","../resources/php/searchFrn.php")
  xhr.setRequestHeader("Content-Type", "application/json")
  xhr.send(JSON.stringify({ id_frn, id_dev_srv, id_dev_crc, res }))
  xhr.onreadystatechange = () => {
    if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
    {
      if(xhr.response != 0)
      {
        const rsp = JSON.parse(xhr.response)
        if(window.confirm(obj["src_frn1"][id_lng]+` ${rsp.length} `+obj["src_frn2"][id_lng]))
        {
          for(let i = 0; i < rsp.length; i++)
            maj('dev_srv','res',res,rsp[i])
        }
        window.parent.act_frm('frn_ope')
      }
      unload('OPE searchFrn')
    }
  }
}
