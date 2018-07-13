<div class="containerPerso vueApp">
	<h1>CRÉATION DE VOTRE PROJET</h1>

	<component-project-progress-bar-noname v-if="$store.getters.getSelectedPageName != 'CheckProjet'"> </component-project-progress-bar-noname>

	<template v-if="$store.getters.getSelectedPageName == 'CheckProjet'">
		<component-projet-check-projet-noname
			:show="$store.getters.getSelectedProjet2.statut_parcour_client.value === 'ProjetCheckProjet'"
			:config='{hidePrevious: true}'
			blockname='ProjetCheckProjet'
		>
		</component-projet-check-projet-noname>
	</template>
	<template v-if="$store.getters.getSelectedPageName == 'CreationProjet'">
		<component-simple-block-mscpi-noname
			:show="$store.getters.getSelectedProjet2.statut_parcour_client.value === 'ProjetChoixBeneficiaire'"
			:config='{hidePrevious: true}'
			blockname='ProjetChoixBeneficiaire'
		>
			<component-projet-choixbeneficiaire-noname> </component-projet-choixbeneficiaire-noname>
		</component-simple-block-mscpi-noname >


		<component-simple-block-mscpi-noname 
			:show="$store.getters.getSelectedProjet2.statut_parcour_client.value === 'ProjetChoixObjectif'"
			blockname='ProjetChoixObjectif'
		>
			<component-projet-choixobjectif-noname> </component-projet-choixobjectif-noname>
		</component-simple-block-mscpi-noname >


		<component-simple-block-mscpi-noname
			:show="$store.getters.getSelectedProjet2.statut_parcour_client.value === 'ProjetMontant'"
			blockname='ProjetMontant'
		>
			<component-projet-montant-noname> </component-projet-montant-noname>
		</component-simple-block-mscpi-noname >

		<component-simple-block-mscpi-noname
			:show="$store.getters.getSelectedProjet2.statut_parcour_client.value === 'ProjetOrigineFonds'"
			blockname='ProjetOrigineFonds'
		>
			<component-projet-originefonds-noname> </component-projet-originefonds-noname>
		</component-simple-block-mscpi-noname >

		<component-simple-block-mscpi-noname
			:show="$store.getters.getSelectedProjet2.statut_parcour_client.value === 'ProjetAccompagnementInvestissement'"
			blockname='ProjetAccompagnementInvestissement'
		>
			<component-projet-accompagnementinvestissement-noname> </component-projet-accompagnementinvestissement-noname>
		</component-simple-block-mscpi-noname >


	</template>


	<template v-if="$store.getters.getSelectedPageName == 'SituationJuridique'">
		<component-simple-block-mscpi-noname
			:show="$store.getters.getSelectedProjet2.statut_parcour_client.value === 'JuridiqueVosInformations'"
			blockname='JuridiqueVosInformations'
		>
			<component-projet-juridiquevosinformations-noname> </component-projet-juridiquevosinformations-noname>
		</component-simple-block-mscpi-noname >


		<component-simple-block-mscpi-noname
			:show="$store.getters.getSelectedProjet2.statut_parcour_client.value === 'JuridiquePersonnePhysique1'"
			blockname='JuridiquePersonnePhysique1'
		>
			<component-projet-juridiquepersonnephysique1-noname> </component-projet-juridiquepersonnephysique1-noname>
		</component-simple-block-mscpi-noname>


		<component-simple-block-mscpi-noname
			:show="$store.getters.getSelectedProjet2.statut_parcour_client.value === 'JuridiquePersonnePhysique2'"
			blockname='JuridiquePersonnePhysique2'
		>
			<component-projet-juridiquepersonnephysique2-noname> </component-projet-juridiquepersonnephysique2-noname>
		</component-simple-block-mscpi-noname >
	</template>


	<template v-if="$store.getters.getSelectedPageName == 'SituationFinanciere'">
		<component-simple-block-mscpi-noname
			:show="$store.getters.getSelectedProjet2.statut_parcour_client.value === 'FinanciereRevenus'"
			blockname='FinanciereRevenus'
		>
			<component-projet-financiererevenus-noname> </component-projet-financiererevenus-noname>
		</component-simple-block-mscpi-noname >

		<component-simple-block-mscpi-noname
			:show="$store.getters.getSelectedProjet2.statut_parcour_client.value === 'FinanciereCharges'"
			blockname='FinanciereCharges'
		>
			<component-projet-financierecharges-noname> </component-projet-financierecharges-noname>
		</component-simple-block-mscpi-noname >
	</template>


	<template v-if="$store.getters.getSelectedPageName == 'SituationFiscale'">
		<component-simple-block-mscpi-noname
			:show="$store.getters.getSelectedProjet2.statut_parcour_client.value === 'FiscaleDe'"
			blockname='FiscaleDe'
		>
			<component-projet-fiscalede-noname> </component-projet-fiscalede-noname>
		</component-simple-block-mscpi-noname >


		<component-simple-block-mscpi-noname
			:show="$store.getters.getSelectedProjet2.statut_parcour_client.value === 'FiscaleImpot'"
			blockname='FiscaleImpot'
		>
			<component-projet-fiscaleimpot-noname> </component-projet-fiscaleimpot-noname>
		</component-simple-block-mscpi-noname >


		<component-simple-block-mscpi-noname
			:show="$store.getters.getSelectedProjet2.statut_parcour_client.value === 'FiscaleIsf'"
			blockname='FiscaleIsf'
		>
			<component-projet-fiscaleisf-noname> </component-projet-fiscaleisf-noname>
		</component-simple-block-mscpi-noname >
	</template>


	<template v-if="$store.getters.getSelectedPageName == 'SituationPatrimoniale'">
		<component-simple-block-mscpi-noname
			:show="$store.getters.getSelectedProjet2.statut_parcour_client.value === 'PatrimoineSituation'"
			blockname='PatrimoineSituation'
		>
			<component-projet-patrimoinesituation-noname> </component-projet-patrimoinesituation-noname>
		</component-simple-block-mscpi-noname >


		<component-simple-block-mscpi-noname
			:show="$store.getters.getSelectedProjet2.statut_parcour_client.value === 'PatrimoineRepartition'"
			blockname='PatrimoineRepartition'
		>
			<component-projet-patrimoinerepartition-noname> </component-projet-patrimoinerepartition-noname>
		</component-simple-block-mscpi-noname >


		<component-simple-block-mscpi-noname
			:show="$store.getters.getSelectedProjet2.statut_parcour_client.value === 'PatrimoineFuturePlacement'"
			blockname='PatrimoineFuturePlacement'
		>
			<component-projet-patrimoinefutureplacement-noname> </component-projet-patrimoinefutureplacement-noname>
		</component-simple-block-mscpi-noname >
	</template>

	<template v-if="$store.getters.getSelectedPageName == 'ProfilInvestisseur'">
		<component-simple-block-mscpi-noname
			:show="$store.getters.getSelectedProjet2.statut_parcour_client.value === 'ProfilInvestisseurRisque'"
			blockname='ProfilInvestisseurRisque'
		>
			<component-profil-investisseur-risque-noname> </component-profil-investisseur-risque-noname>
		</component-simple-block-mscpi-noname >


		<component-simple-block-mscpi-noname
			:show="$store.getters.getSelectedProjet2.statut_parcour_client.value === 'ProfilInvestisseurCompetences'"
			blockname='ProfilInvestisseurCompetences'
		>
			<component-profil-investisseur-competences-noname> </component-profil-investisseur-competences-noname>
		</component-simple-block-mscpi-noname >

		<component-simple-block-mscpi-noname
			:show="$store.getters.getSelectedProjet2.statut_parcour_client.value === 'ProfilInvestisseurMarcheImmobiliers'"
			blockname='ProfilInvestisseurMarcheImmobiliers'
		>
			<component-profil-investisseur-marche-immobiliers-noname> </component-profil-investisseur-marche-immobiliers-noname> 
		</component-simple-block-mscpi-noname >

		<component-simple-block-mscpi-noname
			:show="$store.getters.getSelectedProjet2.statut_parcour_client.value === 'ProfilInvestisseurSupportPlacement'"
			blockname='ProfilInvestisseurSupportPlacement'
		>
			<component-profil-investisseur-support-placement-noname> </component-profil-investisseur-support-placement-noname> 
		</component-simple-block-mscpi-noname >

		<component-simple-block-mscpi-noname
			:show="$store.getters.getSelectedProjet2.statut_parcour_client.value === 'ProfilInvestisseurPlacementDetenus'"
			blockname='ProfilInvestisseurPlacementDetenus'
		>
			<component-profil-investisseur-placement-detenus-noname> </component-profil-investisseur-placement-detenus-noname>
		</component-simple-block-mscpi-noname >



		<component-simple-block-mscpi-noname
			:show="$store.getters.getSelectedProjet2.statut_parcour_client.value === 'ProfilInvestisseurModeGestion'"
			blockname='ProfilInvestisseurModeGestion'
		>
			<component-profil-investisseur-mode-gestion-noname> </component-profil-investisseur-mode-gestion-noname> 
		</component-simple-block-mscpi-noname >

		<component-simple-block-mscpi-noname
			:show="$store.getters.getSelectedProjet2.statut_parcour_client.value === 'ProfilInvestisseurConnaissance'"
			blockname='ProfilInvestisseurConnaissance'
		>
			<component-profil-investisseur-connaissance-noname> </component-profil-investisseur-connaissance-noname> 
		</component-simple-block-mscpi-noname >

		<component-simple-block-mscpi-noname
			:show="$store.getters.getSelectedProjet2.statut_parcour_client.value === 'ProfilInvestisseurQuizScpi'"
			blockname='ProfilInvestisseurQuizScpi'
		>
			<component-profil-investisseur-quiz-scpi-noname> </component-profil-investisseur-quiz-scpi-noname> 
		</component-simple-block-mscpi-noname >

	</template>

	<template v-if="$store.getters.getSelectedPageName == 'ProfilInvestisseurNote'">
		<component-profil-investisseur-note-noname> </component-profil-investisseur-note-noname>
	</template>

	<?= ComponentModalStack::getHtmlTag("noname") ?>
</div>

<?= $this->ModuleComponentManager ?>


<?php
	if (ENABLE_DEVTOOLS)
		echo $this->DevTools;
?>
