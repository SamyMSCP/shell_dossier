<?php
/*      __  __        _  _  _                          */
/*     |  \/  |  ___ (_)| || |  ___  _   _  _ __  ___  */
/*     | |\/| | / _ \| || || | / _ \| | | || '__|/ _ \ */
/*     | |  | ||  __/| || || ||  __/| |_| || |  |  __/ */
/*     |_|  |_| \___||_||_||_| \___| \__,_||_|   \___| */
/*                        _                            */
/*      ___   ___  _ __  (_)    ___  ___   _ __ ___    */
/*     / __| / __|| '_ \ | |   / __|/ _ \ | '_ ` _ \   */
/*     \__ \| (__ | |_) || | _| (__| (_) || | | | | |  */
/*     |___/ \___|| .__/ |_|(_)\___|\___/ |_| |_| |_|  */
/*                |_|                                  */

class ComponentProjectTitle extends ComponentGenerator {

	protected static $_dependances = [];
	protected static $_componentName = "component-project-title";

	private function __construct() { }

	private function __destruct() {}

	// on pourra utiliser config pour redéfinir le component d'edition à utiliser dans un cas ou dans l'autre pour certains component
	protected static function getTemplate($class, $config) {
		$componentClassName = static::getClassName($class);
		$componentName = get_called_class();

		$rt = " <div class='$componentClassName $componentName component'>";
		if (SHOW_FRAME)
			$rt .= "<span class='debugMsg'>$componentClassName</span>";
		$rt .= "
			<h1>{{ getTitle }}</h1> ";

		$rt .= "</div>";
		return ($rt);
	}

	protected static function getComponent($class, $config) {
		$componentName = static::getComponentName($class);
		$templateId = static::getTemplateId($class);

		return ("
			Vue.component(
				'$componentName',
				{
					data: function() {
						return ({
							names: {
								1: 'Démarrer votre projet',
								2: 'Votre projet d’investissement',
								3: 'Votre situation personnelle',
								4: 'Votre situation financière',
								5: 'Votre situation fiscale',
								6: 'Votre patrimoine',
								7: 'Vos connaissances',
								8: 'Quiz',
								9: 'Nous vous remercions.'
							}
						});
					},
					computed: {
						getProjet: function() {
							return (this.\$store.getters.getSelectedProjet2.statut_parcour_client);
						},
						getTitle: function() {
							return ('Etape ' + this.getPosition + ' : ' + this.getName);
						},
						getName: function() {
							return (this.names[this.getPosition]);
							/*
							var statut = this.\$store.getters.getSelectedProjet2.statut_parcour_client.value
							return (this.\$store.state.mscpi.modules.StoreModuleProcessProjet.pages.find(function(elm) {
								return (statut == elm.name)
							}).title);
							*/
						},
						getPosition: function() {
							var statut = this.\$store.getters.getSelectedProjet2.statut_parcour_client.value
							if (
								statut == 'ProjetChoixBeneficiaire' ||
								statut == 'ProjetChoixObjectif' ||
								statut == 'ProjetMontant' ||
								statut == 'ProjetCredit' ||
								statut == 'ProjetOrigineFondsSelection' ||
								statut == 'ProjetOrigineFonds' ||
								statut == 'ProjetAccompagnementInvestissement'
							)
								return (2);

							else if (
								statut == 'JuridiqueVosInformations' ||
								statut == 'JuridiquePersonnePhysique1' ||
								statut == 'JuridiquePersonnePhysique1Complement' ||
								statut == 'JuridiquePersonnePhysique2' ||
								statut == 'JuridiquePersonnePhysique2Complement'
							)
								return (3);

							else if (
								statut == 'FinanciereRevenus' ||
								statut == 'FinanciereHabitation' ||
								statut == 'FinanciereCharges'
							)
								return (4);

							else if (
								statut == 'FiscaleDe' ||
								statut == 'FiscaleImpot' ||
								statut == 'FiscaleIsf'
							)
								return (5);

							else if (
								statut == 'PatrimoineSituation' ||
								statut == 'PatrimoineRepartition' ||
								statut == 'PatrimoineFuturePlacement'
							)
								return (6);
							else if (
								statut == 'ProfilInvestisseurRisque' ||
								statut == 'ProfilInvestisseurCompetences' ||
								statut == 'ProfilInvestisseurMarcheImmobiliers' ||
								statut == 'ProfilInvestisseurSupportPlacement' ||
								statut == 'ProfilInvestisseurPlacementDetenus' ||
								statut == 'ProfilInvestisseurModeGestion' ||
								statut == 'ProfilInvestisseurConnaissance' ||
								statut == 'ProfilInvestisseurSiJinvestis'
							)
								return (7);
							else if (
								statut == 'ProfilInvestisseurQuizScpi'
							)
								return (8);
							else if (
								statut == 'ProfilInvestisseurNote' ||
								statut == 'Fin'
							)
								return (9);
							return (1);
						},
					},
					props: [ 'data'],
					template: '#$templateId',
				}
			);
		");
	}

}
