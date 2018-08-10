</script>
<script>
	function lisibilite_nombre(nbr)
	{
		var nombre = ''+nbr;
		var retour = '';
		var count=0;
		for(var i=nombre.length-1 ; i >= 0; i--) {
			if(count!=0 && count % 3 == 0)
				retour = nombre[i]+' '+retour ;
			else
				retour = nombre[i] + retour ;
			count++;
		}
		return retour;
	}
	function display_msg($i){
		var event = window.event;
		document.getElementById("msg_help").setAttribute("style", "background: rgba(255,255,255,1);position: absolute; left: " + event.pageX + "px; top: " + (event.pageY + 20) +"px; display: initial;");
		document.getElementById("msg_help").children[0].innerHTML = values[$i].label;
		document.getElementById("m_more").innerHTML = lisibilite_nombre(parseFloat(values[$i].value).toFixed(2)) + " € <br />" + values[$i].pourcent + " %";
	}


var repartitionScpiVue = new Vue({
	el: "#repartitionScpiVue",
	store: store
})
