<?php
//<div v-if="onglet == 1 && selectedProject.transactions.length > 0">
?>
<div v-if="onglet == 1 && selectedProject.etat_du_projet == 2 || selectedProject.etat_du_projet > 3">
	<table class="tableLstProject">
		<thead>
			<tr>
				<th>Nom</th>
				<th>Type</th>
				<th>Catégorie</th>
				<th>Stratégie de la SCPI</th>
				<th>Conseils de MeilleureSCPI.com</th>
				<th>Proposition d'investissement</th>
			</tr>
		</thead>
		<tbody>
			<tr v-for="trans in selectedProject.transactions">
				<td>{{ trans.scpiName.replace("SCPI ", "") }} (<span v-if="trans.scpiTypeCapital == 'fixe'">CF</span>
					<span v-else>CV</span>)
				</td>
				<td>{{ trans.scpiType }}</td>
				<td><img class="categorie_picto" :src="'<?=$this->getPath()?>img/PictoScpi/' + trans.scpiCategory + '.png'" alt="" /></td>
				<td style="white-space: pre-wrap;font-size:12px;">
					<span v-if="typeof trans.expand == 'undefined'" >{{ trans.scpiStrategie.substring(0, 200) }}</span>
					<span v-else >{{ trans.scpiStrategie }}</span>
					<span @click="expandTrans(trans)" class="expandable" v-if="trans.scpiStrategie.length > 200 && typeof trans.expand == 'undefined'">...</span>
				</td>
				<td style="white-space: pre-wrap;font-size:12px;">{{ trans.commentaire_projet }}</td>
				<td class="propositionInvestTotal">
					<b>
						{{ getTransactionInvestissement(trans) | euros }}
					</b>
					 ({{ getTransactionPourcentage(trans) | pourcent }})
				</td>
			</tr>
			<tr class="propositionTotal">
				<td colspan="5" >
					<div>
						<div class="precision">
							CV : Capital Variable<br />CF : Capital Fixe
						</div>
						<div>
							MONTANT TOTAL DU PROJET
						</div>
					</div>
				</td>
				<td class="propositionInvestTotal">
					{{ getTotalInvestissement() | euros }} (100 %)
				</td>
			</tr>
		</tbody>
	</table>
	<div class="align-btn-center">
		<button class="btn-mscpi btn-orange" @click.stop="setSeeDetails()">
			VOIR LES DÉTAILS DE LA PROPOSITION
		</button>
	</div>
</div>
<div v-else-if="onglet == 1">
	Votre conseiller n'a pas encore soumis de Transactions pour ce projet
</div>
