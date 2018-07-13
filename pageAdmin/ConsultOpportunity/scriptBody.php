</script>

<script type="text/javascript" charset="utf-8">
	var vm_op_v = new Vue({
		el: ".vueApp_opportunity",
		data: function() {
			return ({
				filterkeyword: "",
				search_scpi: "",
				search_key: 50,
				search_key_usu: 50,
				search_duree: 0,
				search_price: 0,
				search_parts: 0,
				search_key_en: false,
				show_creator: false,
				oplist: [
					<?php
						$all_op = Opportunity::getFromId($GLOBALS['GET']['op']);
						$all_op = array_reverse($all_op);
						foreach ($all_op as $op)
						{
							if ($op->validated == 0 || $op->state > 1)
								continue;
							$type = (intval($op->type) == 1) ? "Nue Propriété" : "Usufruit";
							$all_scpi = ScpiList::getAll();
							$scpi = "";
							foreach ($all_scpi as $tmp_scpi)
								$scpi = ($tmp_scpi->id == $op->id_scpi) ? $tmp_scpi->name : $scpi;//GET SCPI NAME
							$scpi = str_replace("SCPI ", "", $scpi);

							$id = $op->id;
							$date = date("d/m/Y", strtotime($op->date));
							$duree = $op->time_demembrement;
							$key = (($op->type == 0)/*si nue*/ ? ($op->key_nue) : (100.0 - $op->key_nue)/* Calcul pour obtenir la clef usu */);//NUE || USU
							$parts = $op->nb_part;
							$price_part = number_format($op->price_per_part, 2, ",", " ");
							$tot = $op->nb_part * $op->price_per_part * ($key / 100.0);
							$tot = number_format($tot, 2, ",", " ");

							$partiel = ($op->partial_subscrib == 0) ? "OUI" : "NON";
							$state = $op->state;
							$imp = "";
							switch ($state)
							{
								case 0:
									$state = "Ouverte";
									$c_state = "text-success";
									break;
								case 1:
									$state = "Opportunité à saisir";
									$c_state = "text-primary";
									$imp = "bg-danger";
									break;
								default:
									$state = "Fermée";
									$c_state = "text-danger";
							}
							?>
							{
								id: "<?=$id?>",
								type: "<?=$type?>",
								scpi: "<?=$scpi?>",
								date: "<?=$date?>",
								duree: "<?=$duree?>",
								key: "<?=$key?>",
								tot: "<?=$tot?>",
								parts: "<?=$parts?>",
								price_part: "<?=$price_part?>",
								partiel: "<?=$partiel?>",
								state: "<?=$state?>",
								colorState: "<?=$c_state?>",
								isEnding: "<?=$imp?>",
								show: true,
							},
					<?php
						}
					?>
				],
			});
		},
		methods: {
			filter: function (){
				var key = this.filterkeyword.toLowerCase();
				var data = this.oplist;
				if (key == "")
				{
					for (var i = 0; i < data.length; i++)
						data[i].show = true;
					return;
				}
				for (var i = 0; i < data.length; i++)
				{
					var to_cmp = data[i].scpi.toLowerCase();
					if (to_cmp.indexOf(key) != -1)
						data[i].show = true;
					else
						data[i].show = false;
				}
			},
			ct: function(t, p, pr, ku, knp) {
				var key = 0;
				if (t == "Usufruit")
				key = knp;
				else
				key = ku;
				return (p * pr * key);
			}
		},
		computed: {
		},
	});