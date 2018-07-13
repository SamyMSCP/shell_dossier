</script>

<script type="text/x-template" id="seeProfil">
	<div class="modal fade" id="seeProfilModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modalBig" style="border-radius:12px;max-width: 1300px;">
			<div class="modal-content" style="background-color: #EBEBEB;border-radius: 15px;">
				<div class="modal-body" v-if="selectedPp">
	
					<div class="modalViewBeneficiaireBntClose" data-dismiss="modal" aria-label="Close">
						<img src="<?=$this->getPath()?>img/Close-Jaune.svg" alt="" />
					</div>

					<h3 style="font-weight: 600;">
						Résultat du profil investisseur de {{ (selectedPp.civilite == "Monsieur") ? "M." : "Mme"}} {{ selectedPp.prenom }} {{ selectedPp.nom }}
					</h3>
					<div class="traitOrange" style="margin:25px auto;"></div>

					<div class="profilQuestion">
						<div>TYPE DE PROFIL</div>
						<span><b>Note : </b>{{ selectedPp.profilInvestisseur.resultat_questionnaire }} / 20</span>
						<span><b>Profil : </b>{{ selectedPp.profilInvestisseur.details.profil }}</span>
						<span><b>Niveau : </b>{{ selectedPp.profilInvestisseur.details.niveau }}</span>
						<span><b>Description : </b>{{ selectedPp.profilInvestisseur.details.description }}</span>
					</div>

					<div class="profilQuestion">
						<div>QUEL NIVEAU DE RISQUE ACCEPTEZ-VOUS ?</div>
						<span v-if="selectedPp.profilInvestisseur.niveau_risque == 1">Aucune prise de risque</span>
						<span v-else-if="selectedPp.profilInvestisseur.niveau_risque == 2">Une prise de risque limitée</span>
						<span v-else-if="selectedPp.profilInvestisseur.niveau_risque == 3">Une prise de risque modérée</span>
						<span v-else-if="selectedPp.profilInvestisseur.niveau_risque == 4">Une prise de risque importante</span>
					</div>
					<div class="profilQuestion">
						<div>VOUS POSSÉDEZ DES COMPÉTENCES ET CONNAISSANCES PARTICULIÈRES DANS LE DOMAINE...</div>
						<span v-if="selectedPp.profilInvestisseur.competences_imobilieres == 1">...immobilier</span>
						<span v-if="selectedPp.profilInvestisseur.competences_financieres == 1">...financier</span>
					</div>
					<div class="profilQuestion">
						<div>VOTRE CONNAISSANCE DES MARCHÉS IMMOBILIERS EST...</div>
						<span v-if="selectedPp.profilInvestisseur.connaissance_marche_imbobilier == 1">Inexistante</span>
						<span v-else-if="selectedPp.profilInvestisseur.connaissance_marche_imbobilier == 2">Faible</span>
						<span v-else-if="selectedPp.profilInvestisseur.connaissance_marche_imbobilier == 3">Moyenne</span>
						<span v-else-if="selectedPp.profilInvestisseur.connaissance_marche_imbobilier == 4">Elevée</span>
					</div>
					<div class="profilQuestion">
						<div>INDIQUEZ LES TYPES DE PLACEMENT POUR LESQUELS VOUS ESTIMEZ AVOIR UNE CONNAISSANCE ET/OU UNE EXPÉRIENCE SUFFISANTE</div>
						<span v-if="selectedPp.profilInvestisseur.connaissance_placement_actions == 1">Actions</span>
						<span v-if="selectedPp.profilInvestisseur.connaissance_placement_assurance_vie == 1">Assurance vie</span>
						<span v-if="selectedPp.profilInvestisseur.connaissance_placement_obligations == 1">Obligations</span>
						<span v-if="selectedPp.profilInvestisseur.connaissance_placement_opcvm == 1">OPCVM</span>
						<span v-if="selectedPp.profilInvestisseur.connaissance_placement_scpi == 1">SCPI</span>
						<span v-if="selectedPp.profilInvestisseur.connaissance_placement_opci == 1">OPCI</span>
						<span v-if="selectedPp.profilInvestisseur.connaissance_placement_fcpi_fip_fcpr == 1">FCPI / FIP / FCPR</span>
						<span v-if="selectedPp.profilInvestisseur.connaissance_placement_crowdfunding == 1">Crowdfunding</span>
					</div>
					<div class="profilQuestion">
						<div>QUEL EST, SELON VOUS, VOTRE NIVEAU DE CONNAISSANCE DU FONCTIONNEMENT D’UNE SCPI ?</div>
						<span v-if="selectedPp.profilInvestisseur.connaissance_scpi == 1">Aucune connaissance</span>
						<span v-else-if="selectedPp.profilInvestisseur.connaissance_scpi == 2">Niveau moyen</span>
						<span v-else-if="selectedPp.profilInvestisseur.connaissance_scpi == 3">Niveau a améliorer</span>
					</div>
					<div class="profilQuestion">
						<div>INDIQUEZ LES SUPPORTS DE PLACEMENT DONT VOUS DISPOSEZ</div>
						<span v-if="selectedPp.profilInvestisseur.dispose_actions == 1">Actions</span>
						<span v-if="selectedPp.profilInvestisseur.dispose_fcpi_fip_fcpr == 1">FCPI / FIP / FCPR</span>
						<span v-if="selectedPp.profilInvestisseur.dispose_opcvm == 1">OPCVM</span>
						<span v-if="selectedPp.profilInvestisseur.dispose_assurance_vie == 1">Assurance vie</span>
						<span v-if="selectedPp.profilInvestisseur.dispose_obligations == 1">Obligations</span>
						<span v-if="selectedPp.profilInvestisseur.dispose_scpi == 1">SCPI</span>
						<span v-if="selectedPp.profilInvestisseur.dispose_opci == 1">OPCI</span>
						<span v-if="selectedPp.profilInvestisseur.dispose_liquidite == 1">Liquidités</span>
						<span v-if="selectedPp.profilInvestisseur.dispose_pea == 1">PEA</span>
						<span v-if="selectedPp.profilInvestisseur.dispose_immobilier_direct == 1">Immobilier direct</span>
						<span v-if="selectedPp.profilInvestisseur.dispose_crowdfunding == 1">Crowdfunding</span>
					</div>

					<div class="profilQuestion">
						<div>PRÉCISEZ LEUR MODE DE GESTION</div>
						<span v-if="selectedPp.profilInvestisseur.gestion_directe == 1">Directe</span>
						<span v-if="selectedPp.profilInvestisseur.gestion_conseiller == 1">Conseillée</span>
						<span v-if="selectedPp.profilInvestisseur.gestion_sous_mandat == 1">Sous mandat</span>
					</div>
					<div class="profilQuestion">
						<div>QUIZZ SUR LES SCPI</div>
						<table border="0" class="tableSeeProfil">
							<tr>
								<th>
									Si j’investis 10 000 € dans une SCPI qui a un TDVM de 4,8%. Quels sont mes revenus annuels ?
								</th>
								<td v-if="selectedPp.profilInvestisseur.si_jinvesti_10000 == '5760'" class="profilFail">5760 €</td>
								<td v-else-if="selectedPp.profilInvestisseur.si_jinvesti_10000 == '480'" class="profilGood">480 €</td>
								<td v-else-if="selectedPp.profilInvestisseur.si_jinvesti_10000 == '10000'" class="profilFail">10000 €</td>
							</tr>
							<tr v-for="(question, key) in $store.getters.getListQuestions">
								<th >
									{{ question.title }}
								</th>
								<td v-for="(reponse, key2) in question.response" v-if="selectedPp.profilInvestisseur.profArray[key] == key2" :class="{profilGood: reponse, profilFail: !reponse}">
									{{ $store.getters.getListReponses[key2] }}
								</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</script>

<script type="text/javascript" charset="utf-8">
	Vue.component(
		'seeProfil',
		{
			computed: {
				selectedPp: function() {
					return (this.$store.getters.getSelectedPersonnePhysique);
				}
			},
			template: '#seeProfil'
		}
	);
