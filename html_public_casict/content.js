
var old_div_id='';
function OnClickDiv(div_id)
{
	if (old_div_id!='' && old_div_id!=div_id)
	{
		document.all[old_div_id].style.display='none';
	}
	if(document.all[div_id].style.display=='none')
	{
		document.all[div_id].style.display='';
	}
	else
	{
		document.all[div_id].style.display='none';
	}
	old_div_id=div_id;
	return 0;
}
