const newVersion = async function(id_crc)
{
  const obj = await getTxt("../resources/json/scriptTxt.json")
  window.parent.box("?",obj["vrs"][id_lng], () => {
    load('DEV vrs')
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
				act_acc()
        unload('DEV vrs')
      }
    }
  })
}
