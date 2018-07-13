<div class="_space_"></div>
<div class="title" id="el_9">
	<p style="font-family: 'Montserrat', sans-serif;">QUIZ SUR LES SCPI</p>
</div>
<div class="content_body form-horizontal mod_9">
		<table border="0" class="tableQuiz">
			<tbody>
				<tr>
					<td style="text-align: right;padding-right: 10px;">
						<span>
							Si j’investis 10 000 € dans une SCPI qui a un TDVM de 4,8%, quels sont mes revenus annuels ?
						</span>
					</td>
					<td class="tdRadio">
						<div class="radio">
							<label for="si_jinvesti-0">
								<input class="inputEightBlock" type="radio" name="si_jinvesti" id="si_jinvesti-0" value="5760"><span style="margin-right: 12px !important;"></span>
								5760 €
							</label>
						</div>
					</td>
					<td class="tdRadio">
						<div class="radio">
							<label for="si_jinvesti-1">
								<input class="inputEightBlock" type="radio" name="si_jinvesti" id="si_jinvesti-1" value="480"><span style="margin-right: 12px !important;"></span>
								480 €
							</label>
						</div>
					</td>
					<td class="tdRadio">
						<div class="radio">
							<label for="si_jinvesti-2">
								<input class="inputEightBlock" type="radio" name="si_jinvesti" id="si_jinvesti-2" value="10000"><span style="margin-right: 12px !important;"></span>
								10000 €
							</label>
						</div>
					</td>
				</tr>
			<?php
			foreach(ProfilInvestisseur::$_listQuestions as $key => $elm)
			{
				if (!$elm['online'])
					continue ;
				?>
				<tr>
					<td style="text-align: right;padding-right: 10px;">
						<span>
						
						<?=$elm['title']?>
						</span>
					</td>
					<?php
					foreach(ProfilInvestisseur::$_listReponses as $key1 => $elm1)
					{
						if (isset($elm['response'][$key1]))
						{
							?>
							<td class="tdRadio">
								<div class="radio">
									<label for="Quiz-<?=$key?>-<?=str_replace(" ", "_", $elm1)?>">
										<input class="inputEightBlock" type="radio" name="Quiz-<?=$key?>" id="Quiz-<?=$key?>-<?=str_replace(" ", "_", $elm1)?>" value="<?=$key1?>"><span></span>
										<?=ProfilInvestisseur::$_listPicto[$key1]?>
										<?=$elm1?>
									</label>
								</div>
							</td>
							<?php
						}
						else
						{
							?>
							<td></td>
							<?php
						}
					}
					?>
				</tr>
				<?php
			}
			?>
			</tbody>
		</table>
</div>
