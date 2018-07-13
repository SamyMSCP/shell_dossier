
</script>
<script type="text/x-template" id="ListProjetTemplate">
	<div class="moduleContent" style="flex-direction: column;justify-content: space-around;">
		<table class="tableLstProject">
			<thead>
				<tr>
					<th>Date de création</th>
					<th>Bénéficiaire(s)</th>
					<th>Nom du projet</th>
					<th>État</th>
					<th>Actions</th>
				</tr>
			</thead>
				<tbody>
					<tr v-for="projet in lstProjets" class="canClick"  @click="showProject(projet)">
						<td>{{ projet.date_creation | tsDateStr  }}</td>
						<td>{{ projet.beneficiaireShortName }}</td>
						<td>{{ projet.nom }}</td>
						<td class="etatProjet">
							<div>
								<template v-if="projet.etat_du_projet == -1">
									<img src="<?=$this->getPath()?>img/EnCoursCreation-Orange.svg" alt="" />
									<div style="color:#ff9f1c">
										Projet en cours de création
									</div>
								</template>
								<template v-if="projet.etat_du_projet == 0">
									<img src="<?=$this->getPath()?>img/Proposition_BleuClair.png" alt="" />
									<div style="color:#1781e0">
										Projet créé
									</div>
								</template>
								<template v-if="projet.etat_du_projet >= 1 && projet.etat_du_projet <= 4">
									<img src="<?=$this->getPath()?>img/ProjetReflexionPlan de travail 1.svg" alt="" />
									<div style="color:#1781e0">
										Projet en cours de réflexion
									</div>
								</template>
								<template v-if="projet.etat_du_projet == 5 || projet.etat_du_projet == 6">
									<img src="<?=$this->getPath()?>img/EnCoursRealisation-Bleu.svg" alt="" />
									<div style="color:#1781e0">
										Projet en cours de réalisation
									</div>
								</template>
								<template v-if="projet.etat_du_projet == 7">
									<img src="<?=$this->getPath()?>img/Termine-Vert.svg" alt="" />
									<div style="color:#20BF55">
										Projet finalisé
									</div>
								</template>
							</div>
						</td>
						<td class="infoProjet">
							<span style="color:#1781e0;font-weight: 600;">
								Consulter le projet
							</span>
							<img src="<?=$this->getPath()?>img/LoupeBleuClair.svg" alt="" />
						</td>
					</tr>
				</tbody>
		</table>
	</div>
</script>


<script type="text/javascript" charset="utf-8">

	Vue.component(
		'listProjetComponent',
		{
			computed: {
				lstProjets: function() {
					return (this.$store.getters.getLstProjets);
				}
			},
			methods: {
				showProject: function(projet) {
					if (projet.etat_du_projet < 0)
						window.location.href='?p=InfoProjet&projet=' + projet.url
					else
					{
						this.$store.commit("PROJECT_SET_SELECTED", projet.id);
						$('.modalViewFrontProject').modal("show");
					}
				}
			},
			template: "#ListProjetTemplate"
		}
	);

