let ld = 0, flg_ld = {}

const load = (xhr) => {
  let org = 0
	if(xhr)
    org = xhr.replace(/\s/g, "")
	if(typeof flg_ld[org] === 'undefined' || flg_ld[org] == true)
	{
		flg_ld[org] = false
		if(ld == 0)
		{
			document.getElementById('shadowing').style.display = 'block'
			if(xhr != 'emailPopup')
        disableScroll()
		}
		ld++
	}
}

let cancel = false, idpos = 0

const unload = (xhr,id) => {
  let org = 0
	if(xhr)
    org = xhr.replace(/\s/g, "")
	if(typeof flg_ld[org] === 'undefined' || flg_ld[org] == false)
	{
		if(org == 'scroll')
		{
			cancel = true
			idpos = id
		}
		else if(ld > 0)
      ld--
		if(org != 'scroll' && ld == 0)
		{
			document.getElementById('shadowing').style.display = 'none'
			if(xhr != 'emailPopup')
        enableScroll()
			if(cancel == true)
			{
				cancel = false
				document.body.animate({ scrollTop: document.getElementById(`vue_ttr_jrn_${idpos}`).offsetTop-10 }, 'slow')
				console.log(`unload ${org} vue_ttr_jrn_${idpos}`)
			}
		}
		flg_ld[org] = true
	}
}

const getTxt = async function(url)
{
  const storedTxt = localStorage.getItem(url)
  if(storedTxt)
    return JSON.parse(storedTxt)
  const res = await fetch(url)
  const txt = await res.text()
  localStorage.setItem(url, txt)
  return JSON.parse(txt)
}
