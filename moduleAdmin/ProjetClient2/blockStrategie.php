<div v-if="onglet == 5">
	<h4> Stratégie d'investissement du projet </h4>
	<ck-editor v-if="selectedProject.etat_du_projet == 1 || selectedProject.etat_du_projet == 3" id="projectStrategie" v-model="selectedProject.strategie" @change="setStrategieIsChanged()">
	</ck-editor>
	<div v-else-if="selectedProject.etat_du_projet > 1" v-html="selectedProject.strategie"> </div>
	<div v-else style="color:red;">
		L'etat du projet ne vous permet pas d'éditer ses documents
	</div>
	<div class="btn-mscpi selectSendDocument" v-if="typeof selectedProject.strategieIsModify != 'undefined' && selectedProject.strategieIsModify == true" @click="$store.dispatch('PROJECTS_SAVE_STRATEGIE', selectedProject)">
		Enregistrer
	</div>

	<h4>Autres éléments ayant déterminé le conseil</h4>
	<ck-editor v-if="selectedProject.etat_du_projet == 1 || selectedProject.etat_du_projet == 3" id="projectAutresElements" v-model="selectedProject.autres_elements" @change="setAutresElementsIsChanged()">
	</ck-editor>
	<div v-else-if="selectedProject.etat_du_projet > 1" v-html="selectedProject.autres_elements"> </div>
	<div v-else style="color:red;">
		L'etat du projet ne vous permet pas d'éditer ses documents
	</div>
	<div class="btn-mscpi selectSendDocument" v-if="typeof selectedProject.autresElementsIsModify != 'undefined' && selectedProject.autresElementsIsModify == true" @click="$store.dispatch('PROJECTS_SAVE_AUTRES_ELEMENTS', selectedProject)">
		Enregistrer
	</div>
</div>
