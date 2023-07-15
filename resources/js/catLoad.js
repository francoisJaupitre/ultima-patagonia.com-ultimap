var id_lng, cbl_cat, id_cat, aut, url

(function()
{
  id_lng = parent.document.getElementById('id_lng').value
  cbl_cat = document.getElementById('cbl_cat').value
  id_cat = document.getElementById('id_cat').value
  aut = document.getElementById('aut').value
  url = document.getElementById("url").value
  init()
  if(document.getElementById("adDev"))
    document.getElementById("adDev").onclick = () => { addDev(id_cat) }
  if(document.getElementById("copElem"))
    document.getElementById("copElem").onclick = () => { copyElem(cbl_cat, id_cat) }
  if(document.getElementById("delElem"))
    document.getElementById("delElem").onclick = () => { deleteElem(cbl_cat, id_cat) }
  if(document.getElementById("lightCopElem"))
    document.getElementById("lightCopElem").onclick = () => { lightCopyElem(cbl_cat, id_cat) }
})()
