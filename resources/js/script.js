const addFrame = async function(link)
{
  let ref
	if(link.indexOf('scrl') == -1)
  {
    ref = escape(link)
  }else{
    ref = escape(link.substr(0,link.indexOf('scrl')))
  }
	let frm_num = 0, frm_lst = []
	if(ref.substr(0,3) == 'grp')
  {
		//chercher les devis et les afficher côte à côte.
	}
	if(ref.substr(4,3) == 'dev')
  {
		if(ref.indexOf('id_lgg') == -1)
    {
      var ref_id = ref.substr(4)
    }else{
      var ref_id = ref.substr(4,ref.indexOf('id_lgg')-4)
    }
    const frm = document.getElementsByClassName("frm")
    for (let i = 0; i < frm.length; i++)
    {
      let frm_id
			if(frm[i].id.indexOf('id_lgg')==-1)
      {
        frm_id = frm[i].id.substr(4)
			}else{
        frm_id = frm[i].id.substr(4,frm[i].id.indexOf('id_lgg')-4)
      }
			if(ref_id == frm_id)
      {
				frm_num++
				frm_lst.push(frm[i].id)
			}
		}
	}else if(ref.substr(0,3) == 'cmp' || ref.substr(0,3) == 'fin' || ref.substr(0,3) == 'ope')
  {
		var ref_id = ref.substr(0,3)
    const frm = document.getElementsByClassName("frm")
    for (let i = 0; i < frm.length; i++)
    {
      const frm_id = frm[i].id.substr(0,3)
      if(ref_id == frm_id)
      {
				frm_num++
				frm_lst.push(frm[i].id)
      }
	  }
	}else if(ref.substr(0,3) == 'cat')
  {
		var ref_id = ref.substr(0,9)
    const frm = document.getElementsByClassName("frm")
    for (let i = 0; i < frm.length; i++)
    {
			const frm_id = frm[i].id.substr(0,9)
			if(ref_id == frm_id)
      {
				frm_num++
				frm_lst.push(frm[i].id)
			}
		}
	}
	if(frm_num == 0)
  {
		const htm = `<img style='vertical-align: middle;' src='resources/gif/loader.gif' /> <span id='img_${ref}'><img style='vertical-align: middle;' src='prm/img/cls.png' /></span>`
		let li = document.createElement("li")
    li.classList.add("li_tab")
    li.id = `li_${ref}`
    li.onclick = () => {
      vue_frm(ref)
    }
    li.innerHTML = htm
    const ul_tab = document.getElementById("ul_tab")
    ul_tab.append(li)
    let img = document.getElementById(`img_${ref}`)
    img.onclick = () => {
      sup_frm_nobug(ref,event)
    }
	}else if(frm_num == 1)
  {
    const li_frm_lst0 = document.getElementById(`li_${frm_lst[0]}`)
		const nom = li_frm_lst0.innerHTML
		if(nom.substr(0,4) != '<img')
    {
      let nom1, nom2
			if(ref.substr(4,3) == 'dev')
      {
        nom1 = nom.substr(nom.indexOf(":")+2, nom.indexOf("<span id=")-nom.indexOf(":")-2)
				nom2 = nom.substr(0,nom.indexOf(":"))
			}else if(ref.substr(0,3) == 'cmp' || ref.substr(0,3) == 'fin' || ref.substr(0,3) == 'ope')
      {
				nom2 = nom.substr(nom.indexOf(":")+2, nom.indexOf("<span id=")-nom.indexOf(":")-2)
				nom1 = nom.substr(0,nom.indexOf(":"))
			}else if(ref.substr(0,3) == 'cat')
      {
				nom2 = nom.substr(nom.indexOf(":")+2, nom.indexOf("<span id=")-nom.indexOf(":")-2)
        const obj = await getTxt("resources/json/tabText.json")
        nom1 = obj[nom.substr(0,nom.indexOf(":"))]
			}
			let htm = `<input type='checkbox' id='chk_${ref_id}' class='chk_tab'/><label for='chk_${ref_id}'><span id='ttr_${ref_id}' class='span_ttr'><span id='img_${ref_id}'><img style='vertical-align: middle;' src='prm/img/sup.png' /></span> ${nom1}</span></label><ul id='ul_ttr${ref_id}' class='ul_tab'></ul>`
      let li = document.createElement("li")
      li.classList.add("li_ttr")
      li.id = `li_ttr${ref_id}`
      li.innerHTML = htm
      const ul_tab = document.getElementById("ul_tab")
      ul_tab.insertBefore(li,li_frm_lst0)
      let img2 = document.getElementById(`img_${ref_id}`)
      img2.onclick = () => {
        sup_frm_nobug(frm_lst[0],event)
        sup_frm_nobug(ref,event)
      }
			htm = nom2
      li_frm_lst0.remove()
			htm += `<span id='img_${frm_lst[0]}'><img style='vertical-align: middle;' src='prm/img/cls.png' /></span>`
			li = document.createElement("li")
      li.classList.add("li_hid")
      li.id = `li_${frm_lst[0]}`
      li.onclick = () => {
        vue_frm(frm_lst[0])
      }
      li.innerHTML = htm
      const ul_ttr = document.getElementById(`ul_ttr${ref_id}`)
      ul_ttr.append(li)
      let img = document.getElementById(`img_${frm_lst[0]}`)
      img.onclick = () => {
        sup_frm_nobug(frm_lst[0],event)
      }
			htm = `<img style='vertical-align: middle;' src='resources/gif/loader.gif' /> <span id='img_${ref}'><img style='vertical-align: middle;' src='prm/img/cls.png' /></span>`
      li = document.createElement("li")
      li.classList.add("li_tab")
      li.id = `li_${ref}`
      li.onclick = () => {
        vue_frm(ref)
      }
      li.innerHTML = htm
      ul_ttr.append(li)
      let img3 = document.getElementById(`img_${ref}`)
      img3.onclick = () => {
        sup_frm_nobug(ref,event)
      }
		}else{
      return
    }
	}else{
    const htm = `<img style='vertical-align: middle;' src='resources/gif/loader.gif' /> <span id='img_${ref}'><img style='vertical-align: middle;' src='prm/img/cls.png' /></span>`
    let li = document.createElement("li")
    li.classList.add("li_tab")
    li.id = `li_${ref}`
    li.onclick = () => {
      vue_frm(ref)
    }
    li.innerHTML = htm
    const ul_ttr = document.getElementById(`ul_ttr${ref_id}`)
    ul_ttr.append(li)
    let img = document.getElementById(`img_${ref}`)
    img.onclick = () => {
      sup_frm_nobug(ref,event)
    }
    img = document.getElementById(`img_${ref_id}`)
    img.addEventListener('click', event => {
      sup_frm_nobug(ref,event)
    })
	}
	hid_frm()
	let iframe = document.createElement("iframe")
  iframe.classList.add("frm")
  iframe.id = ref
  iframe.src = link
  document.getElementById("dt_frm").append(iframe)
	shw_frm(ref)
}

const closeFrame = async function(ref)
{
  let frm_num = 0, frm_lst = []
	if(document.getElementById(`li_${ref}`).parentNode.parentNode.classList[0] == "li_ttr")
  {
    if(ref.substr(4,3) == 'dev')
    {
      if(ref.indexOf('id_lgg') == -1)
      {
        var ref_id = ref.substr(4)
      }else{
        var ref_id = ref.substr(4, ref.indexOf('id_lgg')-4)
      }
      const frm = document.getElementsByClassName("frm")
      for (let i = 0; i < frm.length; i++)
      {
        if(ref != frm[i].id)
        {
          let frm_id
          if(frm[i].id.indexOf('id_lgg')==-1)
          {
            frm_id = frm[i].id.substr(4)
          }else{
            frm_id = frm[i].id.substr(4,frm[i].id.indexOf('id_lgg')-4)
          }
          if(ref_id == frm_id)
          {
            frm_num++
            frm_lst.push(frm[i].id)
          }
        }
      }
    }else if(ref.substr(0,3)=='cmp' || ref.substr(0,3)=='fin' || ref.substr(0,3)=='ope')
    {
  		var ref_id = ref.substr(0,3)
      const frm = document.getElementsByClassName("frm")
      for (let i = 0; i < frm.length; i++)
      {
        if(ref != frm[i].id)
        {
          const frm_id = frm[i].id.substr(0,3)
          if(ref_id == frm_id)
          {
    				frm_num++
    				frm_lst.push(frm[i].id)
          }
        }
  	  }
  	}else if(ref.substr(0,3) == 'cat')
    {
  		var ref_id = ref.substr(0,9)
      const frm = document.getElementsByClassName("frm")
      for (let i = 0; i < frm.length; i++)
      {
        if(ref != frm[i].id)
        {
    			const frm_id = frm[i].id.substr(0,9)
    			if(ref_id == frm_id)
          {
    				frm_num++
    				frm_lst.push(frm[i].id)
          }
        }
  		}
  	}
	}
	if(frm_num == 1)
  {
    const nom1 = document.getElementById(`li_${frm_lst[0]}`).innerHTML
    const nom2 = document.getElementById(`ttr_${ref_id}`).innerHTML
		const pos = nom2.indexOf('</span>')
		const len = nom2.length
    let htm
		if(ref.substr(4,3) == 'dev')
    {
			htm = nom1.substr(0,nom1.indexOf('<span id='))+': '+nom2.substr(pos,len)
		}else if(ref.substr(0,3) == 'cmp' || ref.substr(0,3) == 'fin' || ref.substr(0,3) == 'ope')
    {
			htm = nom2.substr(pos)+' '+nom1.substr(0,nom1.indexOf('<span id='))
		}else if(ref.substr(0,3) == 'cat')
    {
      const obj = await getTxt("resources/json/tabText.json")
      htm = obj[nom2.substr(pos+8,len-8)]+': '+nom1.substr(0,nom1.indexOf('<span id='))
		}
    console.log(`li_ttr${ref_id}`,document.getElementById(`li_ttr${ref_id}`).id)
    console.log(`li_ttr${ref_id}`,document.getElementById(`li_ttr${ref_id}`))
		const prevId = document.getElementById(`li_ttr${ref_id}`).previousSibling
		document.getElementById(`li_${frm_lst[0]}`).remove()
		document.getElementById(`li_ttr${ref_id}`).remove()
		htm += `<span id='img_${frm_lst[0]}'><img style='vertical-align: middle;' src='prm/img/cls.png' /></span>`
		let li = document.createElement("li")
    li.classList.add("li_hid")
    li.id = `li_${frm_lst[0]}`
    li.onclick = () => {
      vue_frm(frm_lst[0])
    }
    li.innerHTML = htm
    const ul_tab = document.getElementById("ul_tab")
    prevId.after(li)
    document.getElementById(`img_${frm_lst[0]}`).onclick = () => {
      sup_frm_nobug(frm_lst[0], event)
    }
	}
  else{
    const li_tab = document.getElementsByClassName("li_tab")
    for (let i = 0; i < li_tab.length; i++)
    {
      document.getElementById(li_tab[i].id).classList.add("li_hid")
    }
  }
	if(document.getElementById(`li_${ref}`))
  {
    document.getElementById(`li_${ref}`).remove()
  }
	if(document.getElementById(ref)){
		document.getElementById(ref).remove();
		for(let i = 0; i < old_frm.length; i++){
			if(old_frm[i] === ref){
				old_frm.splice(i, 1)
				i--
			}
		}
		shw_frm(old_frm[old_frm.length-1])
	}
}
