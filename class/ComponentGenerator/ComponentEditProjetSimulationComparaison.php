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

class ComponentEditProjetSimulationComparaison extends ComponentGenerator {

	protected static $_dependances = [
		"ComponentListSituations" => ["noname" => []],
		"ComponentListProjet" => ["noname" => []],
	];
	protected static $_componentName = "component-edit-projet-simulation-comparaison";

	private function __construct() { }

	private function __destruct() { }

	// on pourra utiliser config pour redéfinir le component d'edition à utiliser dans un cas ou dans l'autre pour certains component
	protected static function getTemplate($class, $config) {
		$componentClassName = static::getClassName($class);
		$componentName = get_called_class();

		$rt = " <div class='$componentClassName $componentName component' style='margin-bottom: 120px;'>";
		if (SHOW_FRAME)
			$rt .= "<span class='debugMsg'>$componentClassName</span>";


		$rt .= "
			<div>
				<table class='tableSimulation'>
					<thead>
						<tr>
							<th>Date de publication</th>
							<th>Type de document</th>
							<th>Nom du document</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for='document in getLstDocument'>
							<td>
								{{ document.date_creation | tsDateStr }}
							</td>
							<td class='tableDocumentsProject' >

								<img v-if='document.id_type_document == 7' src='assets/DiagCircu-BleuClair.svg' alt='' />
								<img v-else-if='document.id_type_document == 8' src='assets/Comparaison-BleuClair.svg' alt='' />
								<div v-else style='display:inline-block;height:1px;width:32px;margin:0px 10px;'></div>
								{{ \$store.getters.getTypeDocumentNameById(document.id_type_document) | uc_first }}
							</td>
							<td>
								{{ document.filename }}
							</td>
							<td>
								<a class='tableDocumentsProject' target='_blank' :href='\"DownloadAdmin.php?idDocument=\" +  document.id + \"&download=1\"' download>
									Consulter le document
									<img src='assets/LoupeBleuClair.svg' alt='' />
								</a>
							</td>
						</tr>
					</tbody>
				</table>
				<div class='projectDocumentsActions'>
					<document-select 
						id_entity='5'
						:link_entity='selectedProjet.id.value'
						class='btn-mscpi selectSendDocument'
						v-if='selectedProjet.etat_du_projet.value == 1 || selectedProjet.etat_du_projet.value == 3 || selectedProjet.etat_du_projet.value == 4'
					>
						<option
							v-for='doc in \$store.state.projets.lstTypeDocument'
							:value='doc.id'
							v-if='
								doc.id != 10 &&
								(doc.id != 9 || selectedProjet.etat_du_projet.value == 4) &&
								(doc.id != 8 || selectedProjet.etat_du_projet.value != 4) &&
								(doc.id != 7 || selectedProjet.etat_du_projet.value != 4)
							'
						>
							{{ doc.name }}
						</option>
					</document-select>
					<div v-else style='color:red;'>
						L'etat du projet ne vous permet pas d'éditer ses documents
					</div>
				</div>
				<div>
					<h4>Commentaire du projet</h4>
					<ck-editor id='projectCommentaire' v-model='selectedProjet.commentaire.value' @change='setCommentaireIsChanged()'>
					</ck-editor>
				</div>
			</div>
		</div>
		";
		/*
									<div class='btn-mscpi selectSendDocument' v-if='typeof selectedProjet.commentIsModify != 'undefined' && selectedProject.commentIsModify == true' @click='\$store.dispatch('PROJECTS_SAVE_COMMENTAIRE', selectedProject)'>
										Enregistrer
									</div>
		*/
		
		$rt .= "</div> ";
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
						return ({ });
					},
					props: [ 'data' ],
					computed: {
						getLstDocument: function() {
							return (this.\$store.getters.getDocumentsLinkEntity(5, this.selectedProjet.id.value).sort(function(a, b) {
								return (b.date_creation - a.date_creation);
							}));
						},
						selectedProjet: function() {
							return (this.\$store.getters.getSelectedProjet2);
						},
					},
					template: '#$templateId'
				}
			);
		");
	}
}
