<table border="1" class="tableDh">
	<thead>
		<tr>
			<th style="cursor:pointer">Nom de la SCPI</th>
			<th style="cursor:pointer">Nombre de parts</th>
			<th style="cursor:pointer">Type de propriété</th>
			<th style="cursor:pointer">Montant d'investissement</th>
			<th style="cursor:pointer">Montant global de revente</th>
			<th style="cursor:pointer">+ ou - value</th>
			<th style="cursor:pointer">Actions</th>
		</tr>
	</thead>
	<tbody>
	<?php
	foreach ($this->dataPrint as $key => $elm) {
		if ($key == "precalcul")
			continue ;
		foreach ($elm as $key2 => $elm2)
		{
			if ($key2 == "precalcul")
				continue ;
			?>
			<tr onclick="$('.<?=$elm2['precalcul']['modal_link']?>').modal('show');">
				<td>
					<?=$elm2['precalcul']['scpi']->name?>
					<?php
						if ($elm2['precalcul']['haveDoByMscpi'])
						{
							?>
							<div class="doMscpi">
								<div></div>
							</div>
							<?php
						}
						if ($elm2['precalcul']['haveDoByOther'])
						{
							?>
							<div class="doOther"></div>
							<?php
						}
					?>
				</td>
				<td><?=$elm2['precalcul']['nbr_part']?></td>
				<td><?=$elm2['precalcul']['type_pro']?></td>
				<td>
					<?php
					if (!$elm['precalcul']['flagMissingInfo']) {
						echo number_format($elm2['precalcul']["MontantInvestissement"], 2, ",", " ") . " €";
					} else {
						echo "-";
					}
					?>
				</td>
				<td><?=number_format($elm2['precalcul']["ventePotentielle"], 2, ",", " ")?> €</td>
					<?php
					if (is_numeric($elm2['precalcul']["plusMoinValuePourcent"]) && !$elm2['precalcul']['flagMissingInfo'] && !strstr($elm2['precalcul']["type_pro"], "Usu")) {
						?>
						<td class="mobile_resp"><?php echo (number_format($elm2['precalcul']["plusMoinValuePourcent"], 2, ",", " ")); ?> %</td>
						<?php
					} else {
						?>
						<td class="mobile_resp">-</td>
						<?php
					}
					?>
					<td style="padding:1px" class="mobile_resp cursor_big" id="btn_opt">
					<?php
					/*
						<div class="reinvestirBtn"  data-toggle="modal" data-target=".modal_addnew<?=$elm2['precalcul']['modal_link']?>">Réinvestir</div>
						<?php
						if (!strstr($elm2['precalcul']['type_pro'], "Usu")) {
							?>
								<div class="vendreBtn" data-toggle="modal" data-target=".modal_del<?=$elm2['precalcul']['modal_link']?>">Vendre</div></td>
							<?php
						}
					*/
					?>
					</td>
			</tr>
			<?php
		}
	}
				if ($this->dataPrint['precalcul']['havePleine']) {
				?>
				<tr id="tbl_tt" class="Total">
					<td class='mobile_resp'></td>
					<td class='mobile_resp'></td>
					<td style="text-align:center;">Total Pleine Propriété :</td>
					<td class='mobile_resp'><?php
													if ($this->dataPrint['precalcul']['MontantInvestissementPleine'])
														echo number_format($this->dataPrint['precalcul']['MontantInvestissementPleine'], 2, ",", " ") . "  €";
													else
														echo "-";
													?></td>
					<td><?=number_format($this->dataPrint['precalcul']['ventePotentiellePleine'], 2, ",", " ")?> €</td>
					<?php if (is_numeric($this->dataPrint['precalcul']['plusMoinValuePourcentPleine']) && !$this->dataPrint['precalcul']['flagMissingInfoPleine']) { ?>
						<td class='mobile_resp'><?=number_format($this->dataPrint['precalcul']['plusMoinValuePourcentPleine'] , 2, ",", " ")?> %</td>
					<?php } else { ?>
						<td class='mobile_resp'>-</td>
					<?php } ?>
					<td class='mobile_resp'></td>
				</tr>
				<?php
				}
				if ($this->dataPrint['precalcul']['haveNue']) {
				?>
				<tr id="tbl_tt" class="Total">
					<td class='mobile_resp'></td>
					<td class='mobile_resp'></td>
					<td style="text-align:center;">Total Nue Propriété :</td>
					<td class='mobile_resp'><?=number_format($this->dataPrint['precalcul']['MontantInvestissementNue'], 2, ",", " ")?>  €</td>
					<td><?=number_format($this->dataPrint['precalcul']['ventePotentielleNue'], 2, ",", " ")?> €</td>
					<?php if (is_numeric($this->dataPrint['precalcul']['plusMoinValuePourcentNue']) && !$this->dataPrint['precalcul']['flagMissingInfoNue']) { ?>
						<td class='mobile_resp'><?=number_format($this->dataPrint['precalcul']['plusMoinValuePourcentNue'] , 2, ",", " ")?> %</td>
					<?php } else { ?>
						<td class='mobile_resp'>-</td>
					<?php } ?>
					<td class='mobile_resp'></td>
				</tr>
				<?php
				}
				if ($this->dataPrint['precalcul']['haveUsu']) {
				?>
				<tr id="tbl_tt" class="Total">
					<td class='mobile_resp'></td>
					<td class='mobile_resp'></td>
					<td style="text-align:center;">Total Usufruit: </td>
					<td class='mobile_resp'><?=number_format($this->dataPrint['precalcul']['MontantInvestissementUsu'], 2, ",", " ")?>  €</td>
					<td><?=number_format($this->dataPrint['precalcul']['ventePotentielleUsu'], 2, ",", " ")?> €</td>
					<td class='mobile_resp'></td>
					<td class='mobile_resp'></td>
				</tr>
				<?php
				}
				?>
				<tr id="tbl_tt" style="background-color: #01528A;">
					<th class='mobile_resp'></th>
					<th class='mobile_resp'></th>
					<th style="text-align:center;">Total : </th>
					<th class='mobile_resp'><?=number_format($this->dataPrint['precalcul']['MontantInvestissement'], 2, ",", " ")?>  €</th>
					<th><?=number_format($this->dataPrint['precalcul']['ventePotentielle'], 2, ",", " ")?> €</th>
					<?php if (is_numeric($this->dataPrint['precalcul']['plusMoinValuePourcent']) && !$this->dataPrint['precalcul']['flagMissingInfo']) { ?>
						<th class='mobile_resp'><?=number_format($this->dataPrint['precalcul']['plusMoinValuePourcent'] , 2, ",", " ")?> %</th>
					<?php } else { ?>
						<th class='mobile_resp'>-</th>
					<?php } ?>
					<th class='mobile_resp'></th>
				</tr>
	</tbody>
</table>
