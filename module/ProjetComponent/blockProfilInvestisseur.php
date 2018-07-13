<div v-if="onglet == 2" >
	<table class="tableLstProject">
		<thead>
			<tr>
				<th>Date de création</th>
				<th>Nom du bénéficiaire</th>
				<th>Type de profil</th>
				<th>Résultats</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<tr v-for="pp in $store.getters.getPersonnePhysiqueForSelectedProjet" v-if="selectedProject != null">
				<td>{{ pp.profilInvestisseur.date_creation | tsDateStr }}</td>
				<td>
					{{ (pp.civilite == "Monsieur") ? "M." : "Mme"}} {{ pp.prenom}} {{ pp.nom }}
				</td>
				<td>{{ pp.profilInvestisseur.details.niveau | uc_first }}</td>
				<td @click.stop="$store.commit('SHOW_PROFIL', pp)" style="cursor:pointer;color:#1781e0;text-decoration:underline;">Voir les réponses du profil investisseur</td>
				<td>
					<a :href="'?p=ResetProfil&Pp=' + pp.id">
						<button class="btn-mscpi btn-profil">
							METTRE À JOUR SON PROFIL
						</button>
					</a>
				</td>
			</tr>
			<?php
			/*
			<tr v-for="pp in $store.getters.getPersonnePhysiqueForSelectedProjet" v-if="typeof pp.profilInvestisseur != 'undefined'" >
			</tr>
			*/
			?>
		</tbody>
	</table>
</div>
