var ld = 0, flg_ld = {}

const load = (xhr) => {
  let org = 0
	if(xhr) {org = xhr.replace(/\s/g, "")}
	if(typeof flg_ld[org] === 'undefined' || flg_ld[org] == true)
	{
		flg_ld[org] = false
		if(ld == 0)
		{
			document.getElementById('shadowing').style.display = 'block'
			if(xhr != 'emailPopup') {disableScroll()}
		}
		ld++
	}
}

let cancel = false, idpos = 0

const unload = (xhr,id) => {
  let org = 0
	if(xhr) {org = xhr.replace(/\s/g, "")}
	if(typeof flg_ld[org] === 'undefined' || flg_ld[org] == false)
	{
		if(org=='scroll')
		{
			cancel = true
			idpos = id
		}
		else if(ld>0) {ld--}
		if(org != 'scroll' && ld == 0)
		{
			document.getElementById('shadowing').style.display = 'none'
			if(xhr != 'emailPopup') {enableScroll()}
			if(cancel == true)
			{
				cancel = false
				$('html,body').animate( {scrollTop: $("#vue_ttr_jrn_"+idpos).offset().top-10}, 'slow' )
				console.log(org+" unload #vue_ttr_jrn_"+idpos)
			}
		}
		flg_ld[org] = true
	}
}
