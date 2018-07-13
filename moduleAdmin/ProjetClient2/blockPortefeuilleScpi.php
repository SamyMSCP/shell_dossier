<div v-if="onglet == 1">
	<table class="tableSimulation">
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
			<tr v-for="trans in $store.state.transactions.selectedProjectTransactions">
				<td>
					{{ $store.getters.getScpi(trans.id_scpi).name.replace("SCPI ", "") }} (<span v-if="$store.getters.getScpi(trans.id_scpi).TypeCapital == 'fixe'">CF</span>
					<span v-else>CV</span>)
					</td>
				<td>{{ $store.getters.getScpi(trans.id_scpi).typeStr }}</td>
				<td>
					<img class="categorie_picto" :src="'<?=$this->getPath()?>img/PictoScpi/' + $store.getters.getScpi(trans.id_scpi).category_id + '.png'" alt="" />
				</td>
				<td style="white-space: pre-wrap;">
					<span v-if="typeof trans.expand == 'undefined'" >{{ $store.getters.getScpi(trans.id_scpi).strategie.substring(0, 200) }}</span>
					<span v-else >{{ $store.getters.getScpi(trans.id_scpi).strategie }}</span>
					<span @click="expandTrans(trans)" class="expandable" v-if="$store.getters.getScpi(trans.id_scpi).strategie.length > 200 && typeof trans.expand == 'undefined'">...</span>
				</td>
				<td>{{ trans.commentaire_projet }}</td>
				<td class="propositionInvestTotal">
					{{ getTransactionInvestissement(trans) | euros }} ({{ getTransactionPourcentage(trans) | pourcent }})
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
					{{ getTotalInvestissement | euros }} (100 %)
				</td>
			</tr>
		</tbody>
	</table>
	<div class="align-btn-center">
		<button
			class="btn-mscpi btn-orange"
			@click.stop="setSeeDetails()"
			v-if="selectedProject.etat_du_projet == 1 || selectedProject.etat_du_projet == 3"
		>
			VOIR LES DÉTAILS DE LA PROPOSITION
		</button>
		<div v-else style="color:red;">
			L'etat du projet ne vous permet pas d'éditer ses transactions
		</div>
	</div>
</div>
