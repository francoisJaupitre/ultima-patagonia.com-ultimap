var id_lng
var cnf, aut, id_dev_crc // encapsuler ci-dessous asap

(function()
{
  id_lng = parent.document.getElementById('id_lng').value
	id_dev_crc = document.getElementById('id_dev_crc').value
	cnf = document.getElementById('cnf').value
	aut = document.getElementById('aut').value
  init()
  document.body.focus()
  const params = new URLSearchParams(document.location.search)
  const scrl = params.get('scrl');
  if(scrl != null)
  {
    const id_scrll_jrn = document.getElementById('id_scrll_jrn').value
    const id_scrll_mdl = document.getElementById('id_scrll_mdl').value
    scroll2(id_scrll_jrn,id_scrll_mdl)
  }
  /*document.body.onblur = () => {
    const fos = document.activeElement
    document.body.onfocus = () => {
      fos.focus()
      document.body.onfocus = null
    }
  }*/
  document.getElementById("newVersion").onclick = () => { newVersion(id_dev_crc) }
})()
