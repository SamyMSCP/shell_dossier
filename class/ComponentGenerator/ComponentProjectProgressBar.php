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

class ComponentProjectProgressBar extends ComponentGenerator {

	protected static $_dependances = [];
	protected static $_componentName = "component-project-progress-bar";

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
			<div class='bar'>
				<div>
					<div :style='{width:getBarWidth + \"%\"}'></div>
				</div>
			</div>
			<div class='block'>
				<div :class='{okay: getPosition > 1, current: getPosition === 1, notOkay: getPosition < 1 }'>
					<div class='circle'> 1 </div>
					<div class='text'>
						Démarrer votre projet
					</div>
				</div>
				<div :class='{okay: getPosition > 2, current: getPosition === 2, notOkay: getPosition < 2 }'>
					<div class='circle'> 2 </div>
					<div class='text'>
						Votre projet d’investissement
					</div>
				</div>
				<div :class='{okay: getPosition > 3, current: getPosition === 3, notOkay: getPosition < 3 }'>
					<div class='circle'> 3 </div>
					<div class='text'>
						Votre situation personnelle
					</div>
				</div>
				<div :class='{okay: getPosition > 4, current: getPosition === 4, notOkay: getPosition < 4 }'>
					<div class='circle'> 4 </div>
					<div class='text'>
						Votre situation financière
					</div>
				</div>
				<div :class='{okay: getPosition > 5, current: getPosition === 5, notOkay: getPosition < 5 }'>
					<div class='circle'> 5 </div>
					<div class='text'>
						Votre situation fiscale
					</div>
				</div>

				<div :class='{okay: getPosition > 6, current: getPosition === 6, notOkay: getPosition < 6 }'>
					<div class='circle'> 6 </div>
					<div class='text'>
						Votre patrimoine
					</div>
				</div>

				<div :class='{okay: getPosition > 7, current: getPosition === 7, notOkay: getPosition < 7 }'>
					<div class='circle'> 7 </div>
					<div class='text'>
						Vos connaissances
					</div>
				</div>

				<div :class='{okay: getPosition > 8, current: getPosition === 8, notOkay: getPosition < 8 }'>
					<div class='circle'> 8 </div>
					<div class='text'>
						Quiz
					</div>
				</div>
			</div>
		";

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
					computed: {
						getProjet: function() {
							return (this.\$store.getters.getSelectedProjet2.statut_parcour_client);
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
								statut == 'ProfilInvestisseurCompetencesFinance' ||
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
						getBarWidth() {
							return (((this.getPosition - 1) / 7) * 100);
						}
					},
					props: [ 'data'],
					template: '#$templateId',
				}
			);
		");
	}

}
