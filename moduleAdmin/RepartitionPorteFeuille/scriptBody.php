	window.RepartitionPorteFeuille = Morris.Donut ({
		element: 'money',
		resize: true,
		data: [
		<?php
		$temoin = 0;
		foreach ($this->table as $key => $elm) {
			if ($key === "precalcul")
				continue ;
			if ($temoin == 1)
				echo " , ";
				echo " { value : " . number_format(100 * $elm['precalcul']['ventePotentielle'] / $this->table['precalcul']['ventePotentielle'], 2, '.', '') . ", label : \"" . $key  .  "\" } ";
			$temoin = 1;
		}
			?>
		]
	})
	</script>
	<script>
	var values = [
		<?php
		$temoin = 0;
		foreach ($this->table as $key => $elm) {
			if ($key === "precalcul")
				continue ;
			if ($temoin == 1)
				echo " , ";
			echo " { pourcent : '" . htmlspecialchars(number_format(100 * ($elm['precalcul']["ventePotentielle"] / $this->table['precalcul']['ventePotentielle']), 1, ',', ' ')) . "', value : " . number_format($elm['precalcul']['ventePotentielle'], 2, '.', '') . ", label : \"" . $key  .  "\" } ";
			$temoin = 1;
		}
			?>
		]


	var setRepPortefeuilleMsg = function () {
		var ptr = document.getElementsByTagName("path");
		var $i = 0;
		var $len = (ptr.length / 2);
		var $val;
		while ($len > $i) {
			$val = ($i * 2) + 1;
			ptr[$val].setAttribute("onmouseover", "display_msg(" + $i + ")");
			ptr[$val].setAttribute("onmouseout", "disable_msg()"); 
			$i += 1;
		}
	}

	function display_msg($i){
		var event = window.event;
		document.getElementById("msg_help").setAttribute("style", "background: rgba(255,255,255,1);position: absolute; left: " + event.pageX + "px; top: " + (event.pageY + 20) +"px; display: initial;");
		document.getElementById("msg_help").children[0].innerHTML = values[$i].label;
		document.getElementById("m_more").innerHTML = lisibilite_nombre(parseFloat(values[$i].value).toFixed(2)) + " € <br />" + values[$i].pourcent + " %";
	}

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

	var RepartitionPorteFeuilleredraw = function () {
		RepartitionPorteFeuille.redraw();
		var ref = $("#money");
		if (ref.width() < 435)
			ref.css("height", ref.width() + "px");
		else
			ref.css("height", "435px");
		$("#euro").offset({top: (ref.offset().top + (ref.height() / 2)) - 20});
		setTimeout(function(){
			setRepPortefeuilleMsg();
		}, 100);
	};

	window.onresize =  function () {
		RepartitionPorteFeuilleredraw();
	}

	setTimeout(function(){
		RepartitionPorteFeuilleredraw();
	}, 100);

	RepartitionPorteFeuilleredraw();
