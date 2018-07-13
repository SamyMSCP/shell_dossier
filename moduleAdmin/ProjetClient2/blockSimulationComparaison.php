<div v-if="onglet == 0">
	<table class="tableSimulation">
		<thead>
			<tr>
				<th>Date de publication</th>
				<th>Type de document</th>
				<th>Nom du document</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<tr v-for="document in getLstDocument">
				<td>
					{{ document.date_creation | tsDateStr }}
				</td>
				<td class="tableDocumentsProject" >

					<img v-if="document.id_type_document == 7" src="<?=$this->getPath()?>img/DiagCircu-BleuClair.svg" alt="" />
					<img v-else-if="document.id_type_document == 8" src="<?=$this->getPath()?>img/Comparaison-BleuClair.svg" alt="" />
					<div v-else style="display:inline-block;height:1px;width:32px;margin:0px 10px;"></div>
					{{ $store.getters.getTypeDocumentNameById(document.id_type_document) | uc_first }}
				</td>
				<td>
					{{ document.filename }}
				</td>
				<td>
					<a class="tableDocumentsProject" target="_blank" :href="'DownloadAdmin.php?idDocument=' +  document.id + '&download=1'" download>
						Consulter le document
						<img src="<?=$this->getPath()?>img/LoupeBleuClair.svg" alt="" />
					</a>
				</td>
			</tr>
		</tbody>
	</table>
	<div class="projectDocumentsActions">
		<document-select 
			id_entity="5"
			:link_entity="selectedProject.id"
			class="btn-mscpi selectSendDocument"
			v-if="selectedProject.etat_du_projet == 1 || selectedProject.etat_du_projet == 3 || selectedProject.etat_du_projet == 4"
		>
			<option
				v-for="doc in $store.state.projets.lstTypeDocument"
				:value="doc.id"
				v-if="
					doc.id != 10 &&
					(doc.id != 9 || selectedProject.etat_du_projet == 4) &&
					(doc.id != 8 || selectedProject.etat_du_projet != 4) &&
					(doc.id != 7 || selectedProject.etat_du_projet != 4)
				"
			>
				{{ doc.name }}
			</option>
		</document-select>
		<div v-else style="color:red;">
			L'etat du projet ne vous permet pas d'éditer ses documents
		</div>
	</div>
	<div>
		<h4>Commentaire du projet</h4>
		<ck-editor id="projectCommentaire" v-model="selectedProject.commentaire" @change="setCommentaireIsChanged()">
		</ck-editor>
		<div class="btn-mscpi selectSendDocument" v-if="typeof selectedProject.commentIsModify != 'undefined' && selectedProject.commentIsModify == true" @click="$store.dispatch('PROJECTS_SAVE_COMMENTAIRE', selectedProject)">
			Enregistrer
		</div>

	</div>
</div>

