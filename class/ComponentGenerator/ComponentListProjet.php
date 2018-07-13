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

class ComponentListProjet extends ComponentGenerator {

	protected static $_dependances = [
		"ComponentEditProjet" => ["noname" => []],
	];
	protected static $_componentName = "component-list-projet";

	private function __construct() { }

	private function __destruct() { }

	// on pourra utiliser config pour redéfinir le component d'edition à utiliser dans un cas ou dans l'autre pour certains component
	protected static function getTemplate($class, $config) {
		$componentClassName = static::getClassName($class);
		$componentName = get_called_class();

		$rt = " <div class='$componentClassName $componentName component'>";
		if (SHOW_FRAME)
			$rt .= "<span class='debugMsg'>$componentClassName</span>";

		$rt .= "
			<div class='moduleContent' style='flex-direction: column;justify-content: space-around;'>
				<table class='tableLstProject'>
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
						<tr v-for='projet in data' class='canClick' @click='setProjet(projet)'>
							<td>{{ projet.date_creation.value | tsDateStr  }}</td>
							<td>{{ getBeneficiaireProjetShortName(projet) }}</td>
							<td>{{ projet.nom.value }}</td>
							<td class='etatProjet'>
								<div>
									<template v-if='projet.etat_du_projet.value == -1'>
										<img src='assets/EnCoursCreation-Orange.svg' alt='' />
										<div style='color:#ff9f1c'>
											Projet en cours de création
										</div>
									</template>
									<template v-if='projet.etat_du_projet.value == 0'>
										<img src='assets/Proposition_BleuClair.png' alt='' />
										<div style='color:#1781e0'>
											Projet créé
										</div>
									</template>
									<template v-if='projet.etat_du_projet.value >= 1 && projet.etat_du_projet.value <= 4'>
										<img src='assets/ProjetReflexionPlan de travail 1.svg' alt='' />
										<div style='color:#1781e0'>
											Projet en cours de réflexion
										</div>
									</template>
									<template v-if='projet.etat_du_projet.value == 5 || projet.etat_du_projet.value == 6'>
										<img src='assets/EnCoursRealisation-Bleu.svg' alt='' />
										<div style='color:#1781e0'>
											Projet en cours de réalisation
										</div>
									</template>
									<template v-if='projet.etat_du_projet.value == 7'>
										<img src='assets/Termine-Vert.svg' alt='' />
										<div style='color:#20BF55'>
											Projet finalisé
										</div>
									</template>
								</div>
							</td>
							<td class='infoProjet'>
								<span style='color:#1781e0;font-weight: 600;'>
									Consulter le projet
								</span>
								<img src='assets/LoupeBleuClair.svg' alt='' />
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		";
		
		$rt .= "</div> ";
		return ($rt);
	}
	protected static function getComponent($class, $config) {
		$componentName = static::getComponentName($class);
		$templateId = static::getTemplateId($class);

		$id_client = intval($GLOBALS['GET']['client']);
		return ("
			Vue.component(
				'$componentName',
				{
					props: [ 'data' ],
					methods: {
						beneficiaireShortName: function(ben) {
							if (ben.type_ben.value == 'Pm') {
								var pm =  this.\$store.getters.getBeneficiaire2_PersonneMorale(ben.id.value);
								if (pm === null)
									return ('--not defined--');
								return (pm[0].dn_sociale.value);
							}
							var ppList =  this.\$store.getters.getBeneficiaire2_PersonnePhysique(ben.id.value);
							var rt = '';
							var temoin = false;
							for (var key in ppList) {
								if (temoin)
									rt += ' & ';
								rt += ppList[key].shortName.value;
								temoin = true;
							}
							return (rt);
						},
						getBeneficiaireProjetShortName: function(elm) {
							var tmp = this.\$store.getters.getBeneficiaire2_ByProjet2_id_beneficiaire(elm.id.value);
							if (tmp == 'undefined' || tmp == null)
								return ('-')
							return (this.beneficiaireShortName(tmp[0]));
						},
						setProjet: function(elm) {
							if (elm.etat_du_projet.value == -1)
								window.location.href = '?p=PageCreationProjet&client=$id_client&projet=' + elm.id.value
							else {
								this.\$store.commit('set_selected_Projet2', elm);
								this.\$store.commit('modal_stack_push', {
									tag: 'component-edit-projet-noname'
								});
							}
						},
					},
					template: '#$templateId'
				}
			);
		");
	}
}
