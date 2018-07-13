</script>
<script type="text/javascript" charset="utf-8">
	
	function mergeObject(rcvs, ndts) {
		//var rt = {};
		for (key in rcvs)
		{
			if (typeof ndts[key] == 'undefined')
				;//rcvs[key] = rcvs[key]
			else if (typeof ndts[key] == 'object')
				mergeObject(rcvs[key], ndts[key]);
			else
				rcvs[key] = ndts[key];
		}
	}

	function mergeEntity(rcvs, ndts) {
		// On gere ce qu'il y a dans lst
		if (typeof ndts['lst'] != 'undefined' || typeof rcvs['lst'] != 'undefined')
		{
			for (lst in ndts['lst']) {
				var ndt = ndts['lst'][lst];
				var temoin = false;
				var rcv = rcvs['lst'].map(function(elm) {
					if  (elm.id.value == ndt.id.value) {
						temoin = true;
						return (ndt);
					}
					return (elm);
				});
				if (!temoin)
					rcvs['lst'].push(ndt);
				else
					rcvs['lst'] = rcv;
			}
		}

		// On gere le selected
		if (ndts['selected'].id.value == 0)
		{
			var rcv = rcvs['lst'].find(function(elm) {
				return (elm.id.value == ndts['selected'].id.value);
			});
			if (typeof rcv != 'undefined')
				rcvs['selected'] = JSON.parse(JSON.stringify(rcv));
		}
		else
		{
			rcvs['selected'] = ndts['selected'];
			if (rcvs['selected']['id']['value'] == -1)
				rcvs['selected']['id']['value'] = 0;
		}
	}

</script>
<?= ComponentManager::getScriptHead() ?>
<?php
//exit();
?>
<script type="text/javascript" charset="utf-8">
