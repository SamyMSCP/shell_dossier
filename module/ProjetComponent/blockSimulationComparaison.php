<?php
// TODO : il faut encore remplacer le lien de téléchargement par le bon puis vérifier que la version admin n'autorise effectivement que les utilisateur de type collaborateur...

//<div v-if="onglet == 0 && getPreparedDocument.length > 0">
?>
<div v-if="onglet == 0 && selectedProject.etat_du_projet == 2 || selectedProject.etat_du_projet > 3">
	<table class="tableLstProject">
		<thead>
			<tr>
				<th>Date de publication</th>
				<th>Type de document</th>
				<th>Nom du document</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<tr v-for="document in getPreparedDocument">
				<td>
					{{ document.date_creation | tsDateStr }}
				</td>
				<td class="etatProjet" >
					<div style="color:#1781e0">
						<img v-if="document.id_type_document == 7" src="<?=$this->getPath()?>img/DiagCircu-BleuClair.svg" alt="" />
						<img v-else-if="document.id_type_document == 8" src="<?=$this->getPath()?>img/Comparaison-BleuClair.svg" alt="" />
						<div v-else style="display:inline-block;height:1px;width:32px;margin:0px 10px;"></div>
						<div>
							{{ document.type_document | uc_first}}
						</div>
					</div>
				</td>
				<td>
					{{ document.filename }}
				</td>
				<td class="infoProjet">
					<a target="_blank" :href="'Download.php?idDocument=' +  document.id + '&download=1'" download>
						<span style="color:#1781e0;font-weight: 600;">
							Consulter le document
						</span>
						<img src="<?=$this->getPath()?>img/LoupeBleuClair.svg" alt="" />
					</a>
				</td>
			</tr>
			<?php
			/*
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
					<a class="tableDocumentsProject" target="_blank" :href="'DownloadAdmin.php?idDocument=' +  document.id " download>
						Consulter le document
						<img src="<?=$this->getPath()?>img/LoupeBleuClair.svg" alt="" />
					</a>
				</td>
			</tr>
			*/
			?>
		</tbody>
	</table>
</div>
<div v-else-if="onglet == 0">
	Votre conseiller n'a pas encore soumis de Proposition/Simulation pour ce projet
</div>
