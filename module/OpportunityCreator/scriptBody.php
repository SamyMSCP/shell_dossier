</script>
<script>
function changeRatioKey(el)
{
	if (el.id == "crnp")
		document.getElementById("cru").value = 100 - el.value;
	else if (el.id == "cru")
		document.getElementById("crnp").value = 100 - el.value;
		update_montGlobal();
}

function update_montGlobal()
{
	document.getElementById("mtn-global-invest").value = document.getElementById("nb-part").value * document.getElementById("price-part").value;
	update_montantUsufruit();
	update_montantnuPropri();
}


function update_montantUsufruit()
{
	document.getElementById("mtn-usufruit").value = document.getElementById("mtn-global-invest").value * (document.getElementById("cru").value / 100);
}

function update_montantnuPropri()
{
	document.getElementById("mtn-nupropriete").value = document.getElementById("mtn-global-invest").value * (document.getElementById("crnp").value / 100);
}
