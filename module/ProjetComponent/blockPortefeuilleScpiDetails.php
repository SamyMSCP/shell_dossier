<div class="modalViewProjectBlockInfos" style="padding:10px;">
	<div class="modalViewProjectBlockOngletInner">
		<div class="modalViewProjectBlockOngletInner2">
			<div>
				<table class="tableLstProject">
					<thead>
						<tr>
							<th>Nom</th>
							<th >Société de gestion</th>
							<th>Type de propriété</th>
							<th>Nombre de parts</th>
							<th >Prix par parts en pleine propriété</th>
							<th >Clé de repartition si démembrement</th>
							<th>Durée de démembrement</th>
							<th>Montant d'investissement</th>
							<th >% part sur le montant d'investissement</th>
						</tr>
					</thead>
					<tbody>
						<template v-for="trans in selectedProject.transactions">
							<tr>
								<td>{{ trans.scpiName.replace("SCPI ", "") }} (<span v-if="trans.scpiTypeCapital == 'fixe'">CF</span>
									<span v-else>CV</span>)
								</td>
								<td>{{ trans.scpiSocieteGestionName }}</td>
								<td>
									<span v-if="trans.type_pro == 'Pleine propriété'">PP</span>
									<span v-else-if="trans.type_pro == 'Nue propriété'">NP</span>
									<span v-else-if="trans.type_pro == 'Usufruit'">US</span>
								</td>
								<td>{{trans.nbr_part}}</td>
								<td>{{trans.prix_part | euros }}</td>
								<td>
									<template v-if="trans.type_pro != 'Pleine propriété'">
										{{ trans.cle_repartition | pourcent }}
									</template>
									<template v-else>{{ 100 | pourcent }}</template>
								</td>
								<td v-if="trans.type_pro != 'Pleine propriété'">
									{{ (trans.dt != 0 ) ? trans.dt : "Viager" }}
								</td>
								<td v-else>-</td>
								<td>
									{{ getTransactionInvestissement(trans) | euros }}
								</td>
								<td style="color: #1781e0;">
									{{ getTransactionPourcentage(trans) | pourcent }}
								</td>
							</tr>
							<tr class="tablePropositionComm"  :class="{isModify: trans.isModify}">
								<td colspan="9">
									{{ trans.commentaire_projet }}
								</td>
							</tr>
						</template>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<div class="modalViewProjectBlockInfos" style="padding:10px;">

	<div class="modalViewProjectBlockOngletInner" style="display: flex;flex-direction: column;">
		<div class="modalViewProjectBlockOngletInner2 Inner2Title">
			<img src="<?=$this->getPath()?>img/DiagCircu-Blanc.svg" alt="" />
			<span>RÉPARTITION PAR SCPI</span>
			<img class="_tooltip_r" src="<?=$this->getPath()?>img/i-Blanc.svg" onmouseover="display_tooltip('Tooltip repartition', 'Tooltip Repartition Content', event)" onmouseout="disable_msg(event)" style="height: 26px;">
		</div>
		<div class="modalViewProjectBlockOngletInner2 Inner2Content">
			<chart-repartition-scpi :value="selectedProject.transactions" name="chartRepartitionScpiProject"></chart-repartition-scpi>
		</div>
	</div>
	
	<div class="modalViewProjectBlockOngletInner" style="display: flex;flex-direction: column;">
		<div class="modalViewProjectBlockOngletInner2 Inner2Title">
			<img src="<?=$this->getPath()?>img/DiagCircu-Blanc.svg" alt="" />
			<span>RÉPARTITION GÉOGRAPHIQUE</span>
			<img class="_tooltip_r" src="<?=$this->getPath()?>img/i-Blanc.svg" onmouseover="display_tooltip('Tooltip repartition geo', 'Tooltip Repartition Geo Content', event)" onmouseout="disable_msg(event)" style="height: 26px;">
		</div>
		<div class="modalViewProjectBlockOngletInner2 Inner2Content">
			<chart-repartition-geo :value="selectedProject.transactions" name="chartRepartitionGeoProject"></chart-repartition-geo>
		</div>
	</div>

	<div class="modalViewProjectBlockOngletInner" style="display: flex;flex-direction: column;">
		<div class="modalViewProjectBlockOngletInner2 Inner2Title">
			<img src="<?=$this->getPath()?>img/DiagCircu-Blanc.svg" alt="" />
			<span>RÉPARTITION PAR TYPE</span>
			<img class="_tooltip_r" src="<?=$this->getPath()?>img/i-Blanc.svg" onmouseover="display_tooltip('Tooltip repartition par type', 'Tooltip Repartition par type', event)" onmouseout="disable_msg(event)" style="height: 26px;">
		</div>
		<div class="modalViewProjectBlockOngletInner2 Inner2Content" style="display:flex;align-items:center;">
			<repartition-type :value="selectedProject.transactions" ></repartition-type>
		</div>
	</div>
</div>
