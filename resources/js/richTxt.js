const richTxtInit = (elem,tab,col,id) => {
	if(flg_rch)
	{
		const loader = document.getElementById(`ld_${elem}`)
		const ed = elem
		loader.style.display = 'block'
		tinymce.remove(`#${elem}`)
		tinymce.init({
			entity_encoding : "raw",
			forced_root_block : "",
			selector: `#${elem}`,
			inline: true,
			fixed_toolbar_container: `#tool_${elem}`,
			resize: true,
			plugins: "textcolor save paste",
			paste_auto_cleanup_on_paste : true,
			paste_word_valid_elements: "b,strong,i,em,u",
			paste_preprocess : (pl, o) => {
				o.content = stripTags(o.content, '<b><strong><i><em><u>')
			},
			toolbar: 'undo redo | bold italic underline | backcolor | save',
			toolbar_location: 'bottom',
			textcolor_rows: "3",
			textcolor_map: [
				"FFFF00", "Yellow",
				"7FFF00", "Light Green",
				"00FFFF", "Cyan",
				"FF00FF", "Magenta",
				"0000FF", "Blue",
				"FF0000", "Red",
				"00008B", "Dark Blue",
				"008B8B", "Dark Cyan",
				"008000", "Dark Green",
				"8B008B", "Dark Magenta",
				"A52100", "Dark Red",
				"808000", "Dark Yellow",
				"808080", "Dark Gray",
				"BFBFBF", "Light Gray",
				"000000", "Black",
				],
			save_enablewhendirty: false,
			menubar: false,
			save_onsavecallback: (elem) => {
				maj(tab,col,elem.getContent(),id)
				elem.getBody().style.backgroundColor = "#FFFFFF"
			},
			setup : (elem) => {
				elem.on('init', (e) => {
					loader.style.display = 'none'
					elem.execCommand('mceFocus', true, ed)
				})
				elem.on('change redo undo', (e) => { elem.getBody().style.backgroundColor = "#FFFF66" })
			},
		})
		$(`#${elem}`).css("resize","vertical")
	}
}

function richTxtCheck()
{
	if(typeof tinyMCE !== "undefined" && tinyMCE.activeEditor)
	{
		const rich = document.getElementsByClassName("rich")
		for(const i = 0; i < rich.length; i++)
		{
			if(tinyMCE.get(rich[i].id))
			{
				if(rich[i].style.backgroundColor != '' && rich[i].style.backgroundColor != 'rgb(255, 255, 255)')
					return false
			}
		}
	}
	return true
}

const stripTags = (str, allowed_tags) => {
	let allowed_array = []
  if(allowed_tags)
		allowed_array = allowed_tags.match(/([a-zA-Z0-9]+)/gi)
  str += ''
  const matches = str.match(/(<\/?[\S][^>]*>)/gi)
  for(const key in matches)
	{
    if(isNaN(key))
			continue
    const html = matches[key].toString()
    let allowed = false
		let i = -1
    for(const k in allowed_array)
		{
      const allowed_tag = allowed_array[k]
      if(i != 0)
				i = html.toLowerCase().indexOf('<'+allowed_tag+'>')
      if(i != 0)
				i = html.toLowerCase().indexOf('<'+allowed_tag+' ')
      if(i != 0)
				i = html.toLowerCase().indexOf('</'+allowed_tag)
      if(i == 0)
			{
				allowed = true
        break
      }
    }
    if(!allowed)
			str = str.split(html).join("")
  }
  return str
}
