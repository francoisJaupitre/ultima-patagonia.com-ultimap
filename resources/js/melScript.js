var id_lng

(function()
{
  id_lng = parent.document.getElementById('id_lng').value
  init()
})()

const addDev = async function(url)
{
  load('addDev')
  const xhr = new XMLHttpRequest
  xhr.open("POST","../resources/php/addDev.php")
  xhr.setRequestHeader("Content-Type", "application/json")
  xhr.send(JSON.stringify({ url }))
  xhr.onreadystatechange = () => {
    if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
    {
      const rsp = JSON.parse(xhr.response)
      window.parent.act_frm('grp')
      window.parent.act_frm('clt')
      for(let i = 0; i < rsp.length; i++)
        window.parent.opn_frm(`dev/ctr.php?id=${rsp[i]}`)
      parent.window.frames[0].vue_lst('dev')
      if(rsp[1].length > 0)
        alt(rsp[1])
      if(rsp[2].length > 0)
        alt(rsp[2])
      unload('addDev')
    }
  }
}
