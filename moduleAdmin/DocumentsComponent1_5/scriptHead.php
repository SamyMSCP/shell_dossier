</script>
<script type="text/x-template" id="documentSelect">
	<select @change="sendDocument()" v-model="documentSend">
		<option value="0">Envoyer/Editer un document</option>
		<slot></slot>
	</select>
</script>
<script type="text/x-template" id="documentBtn">
	<button v-if="!isDiv" @click="showModal" :class="{isEmpty: !haveDoc(), notComplete: !haveDocSigned()}">
		<slot></slot>
	</button>
	<div v-else @click="showModal" v-bind:class="cssclass">
		<slot></slot>
	</div>
</script>
<script type="text/x-template" id="documentUpload">
	<div>
		<input type="file" id="fileNewDocument" accept=".pdf" @change="sendNewFile" style="display:none;"/>
		<img src="<?=$this->getPath()?>img/Plus-bleuclair-01.png" onclick="document.getElementById('fileNewDocument').click()" />
	</div>
</script>
<script type="text/x-template" id="documentModal">
	<div class="modal fade" id="bodyDocumentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modalBig" role="document" style="border-radius: 15px;">
			<div class="modal-content" style="background-color: #EBEBEB;border-radius: 15px;">
				<div class="modal-body">
					<button data-dismiss="modal" type="button" class="close pull-right" aria-label="Close">
						<img src="<?= $this->getPath() ?>img/Close-Jaune.svg" alt="" />
					</button>
					<h3>
						Documents -
						{{ $store.getters.getDocumentEntityNameById($store.state.documents.id_entity) }} nº {{ $store.state.documents.link_entity }} -
						{{ $store.getters.getTypeDocumentNameById($store.state.documents.type_document) }}
					</h3>
					<div class="traitOrange"></div>
					<div class="documentModal">
						<div class="documentList">
							<button class="btn-mscpi" :class="{'btn-gris': doc != $store.state.documents.selectedDocument}" v-for="doc in getSelectedLstDocument" @click="changeSelectedDocument(doc)">{{ doc.filename }}</button>
							<document-upload></document-upload>
						</div>

						<div class="documentDetail" v-if="selectedDocument != null">
							<div class="documentInformations">
								<div style="text-align: left;margin-left: 20px;">
									Date de création : {{ selectedDocument.date_creation | date }} <br />
									Date d'execution : 
									<div v-if="selectedDocument.id_universign == null" style="display: inline;position:relative;">
										<my-datepicker class="noBorder" id="dateExecutionDocument" v-model="selectedDocument.date_execution"></my-datepicker>
										<div class="outRight" v-if="selectedDocument.date_execution != originalDocument.date_execution">
											<div class="outContent" style="padding: 3px 5px;" @click="saveDateExecution()">
												<i class="fa fa-floppy-o" aria-hidden="true"></i>
											</div>
										</div>
									</div>
									<template v-else>
										{{ selectedDocument.date_execution | date }}
									</template>
									<br />
									Date d'expiration : {{ selectedDocument.date_expiration | date }}
								</div>
								<div style="text-align: left;margin-left: 20px;">
									Type de fichier : {{ selectedDocument.type }} <br />
									<span v-if="selectedDocument.id_universign != null">
										Id Universign: {{ selectedDocument.id_universign }} <br />
										url Universign: 
										<a :href="selectedDocument.url">
											{{ selectedDocument.url }}
										</a>
									</span>
									
								</div>
								<div v-if="$store.getters.getSelectedDocumentNeedSignature()">
									<div v-if="selectedDocument.signed == 1">
										<button :disabled="selectedDocument.id_universign != null" class="btn-mscpi" @click="setDocumentSigned(selectedDocument)">Ce document est signé</button>
									</div>
									<div v-else>
										<button :disabled="selectedDocument.id_universign != null" class="btn-mscpi btn-not-check" @click="setDocumentSigned(selectedDocument)">Ce document n'est pas signé</button>
									</div>
								</div>
								<div>
									<div>
										<button v-if="selectedDocument.validated_by != null" class="btn-mscpi">Ce document est validé</button>
										<button v-else @click="setDocumentValidated(selectedDocument)" class="btn-mscpi  btn-not-check">Ce document n'est pas validé</button>
									</div>
								</div>
							</div>
							<div class="documentCom">
								<?php
								/*
								<ck-editor id="documentCom" height="140px" v-model="selectedDocument.commentaire"></ck-editor>
								*/
								?>
								<textarea rows="8" cols="40" v-model="selectedDocument.commentaire"></textarea>
								<div class="align-btn-center">
									<button class="btn-mscpi" @click="saveCommentaire(selectedDocument)">ENREGISTRER</button>
								</div>
							</div>
							<div class="documentPreview">
								<iframe  class='embed-responsive-item' :src="'DownloadAdmin.php?idDocument=' + selectedDocument.id"></iframe>
							</div>
							<a style="text-align:center;" target="_blank":href="'DownloadAdmin.php?idDocument=' + selectedDocument.id + '&download=1' " download>Télécharger le document</a>
							<div class="align-btn-center">
								<button class="btn-mscpi btn-rouge" @click="setDelete(selectedDocument)">
									<i class="fa fa-times" aria-hidden="true"></i> SUPPRIMER
								</button>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</script>
<script type="text/javascript" charset="utf-8">

	Vue.component(
		'documentUpload',
		{
			data: function() {
				return (
					{
						myData: null,
						filename: null,
						isOpen: false
					}
				);
			},
			methods: {
				toggleOpen: function() {
					this.isOpen = !this.isOpen;
				},
				sendNewFile() {
					this.$store.dispatch("DOCUMENTS_CREATE", "fileNewDocument");
				}
			},
			template: "#documentUpload"
		}
	);
	Vue.component(
		'documentModal',
		{
			data: function() {
				return ({selected: null});
			},
			computed: {
				selectedDocument: function() {
					if (this.$store.state.documents.selectedDocument == null)
					{
						return (null);
					}
					this.selected = JSON.parse(JSON.stringify(this.$store.state.documents.selectedDocument));
					if (
						this.selected != null &&
						(
							typeof this.selected.commentaire != "string" ||
							this.selected.commentaire.length == 0
						)
					)
						this.selected.commentaire = "-";
					return (this.selected);
				},
				originalDocument: function() {
					var that = this;
					return this.$store.getters.getSelectedLstDocument.find(function(elm) {
						return (elm.id == that.selectedDocument.id);
					})
				},
				getSelectedLstDocument: function() {
					return (this.$store.getters.getSelectedLstDocument);
				}
			},
			template: "#documentModal",
			methods: {
				saveDateExecution: function() {
					this.$store.dispatch("DOCUMENTS_SAVE_DATE_EXECUTION", this.selectedDocument);
				},
				setDocumentSigned: function(doc) {
					var that = this;
					var message = "Voulez-vous vraiment définir ce document comme signé ?";
					if (doc.signed == 1)
						message = "Voulez-vous vraiment définir ce document comme non signé ?";
					msgBox.show(message ,[
						{
							text: "Oui",
							action: function() { 
								that.$store.dispatch("DOCUMENTS_CHANGE_SIGNED", doc).then(function() {
								});
							}
							},
							{
							text: "Non",
							action: function() {
								Vue.set(doc, "signed", !doc.signed);
							}
						},
					]);
				},
				setDocumentValidated: function(doc) {
					var that = this;
					var message = "Voulez-vous vraiment définir ce document comme validé ?";
					msgBox.show(message ,[
						{
							text: "Oui",
							action: function() { 
								that.$store.dispatch("DOCUMENTS_CHANGE_VALIDATED", doc);
							}
							},
							{
							text: "Non",
							action: function() {
								
							}
						},
					]);
				},
				setDelete: function(doc) {
					var that = this;
					msgBox.show("Voulez-vous vraiment supprimer ce document ?",[
						{
							text: "Oui",
							action: function() { 
								that.$store.dispatch("DOCUMENTS_DELETE", doc).then(function() {
								});
							}
						},
						{
							text: "Non",
							action: function() {  }
						},
					]);
				},
				changeSelectedDocument: function(doc) {
					//if (typeof doc.commentaire != "string" || doc.commentaire.length == 0)
						//doc.commentaire = "-";
					this.$store.state.documents.selectedDocument = doc;
				},
				saveCommentaire: function(doc) {
					console.log(doc);
					//this.$store.dispatch("DOCUMENTS_UPDATE_COMMENTAIRE", doc);
				}
			}
		}
	);

	Vue.component(
		'documentBtn',
		{
			props: [
				'id_entity',
				'link_entity',
				'type_document',
				'cssclass',
				'status',
				'isDiv'
			],
			template: "#documentBtn",
			methods: {
				haveDoc: function() {
					return (this.$store.getters.getHaveDocument(this.id_entity, this.link_entity, this.type_document).length);
				},
				haveDocSigned: function() {
					return (this.$store.getters.getHaveDocumentSigned(this.id_entity, this.link_entity, this.type_document));
				},
				showModal: function() {
					this.$store.commit("DOCUMENTS_SET_CONFIGURATION", {
						id_entity: this.id_entity,
						link_entity: this.link_entity,
						type_document: this.type_document
					})
					if (this.$store.state.documents.selectedLstDocument.length)
						this.$store.state.documents.selectedDocument = this.$store.state.documents.selectedLstDocument[0];
					else
						this.$store.state.documents.selectedDocument = this.$store.getters.getNewDocument;;
					$("#bodyDocumentModal").modal('show');
				}
			}
		}
	);

	Vue.component(
		'documentSelect',
		{
			props: [
				'id_entity',
				'link_entity'
			],
			data: function() {
				return ({documentSend: 0});
			},
			template: "#documentSelect",
			methods: {
				haveDoc: function() {
					return (this.$store.getters.getHaveDocument(this.id_entity, this.link_entity, this.type_document).length);
				},
				haveSignedDoc: function() {
					return (this.$store.getters.getHaveDocumentSigned(this.id_entity, this.link_entity, this.type_document).length);
				},
				showModal: function() {
					this.$store.commit("DOCUMENTS_SET_CONFIGURATION", {
						id_entity: this.id_entity,
						link_entity: this.link_entity,
						type_document: this.type_document
					})
					if (this.$store.state.documents.selectedLstDocument.length)
						this.$store.state.documents.selectedDocument = this.$store.state.documents.selectedLstDocument[0];
					else
						this.$store.state.documents.selectedDocument = this.$store.getters.getNewDocument;
					$("#bodyDocumentModal").modal('show');
				},
				sendDocument: function() {
					this.$store.commit("DOCUMENTS_SET_CONFIGURATION", {
						id_entity: this.id_entity,
						link_entity: this.link_entity,
						type_document: this.documentSend
					});
					if (this.$store.state.documents.selectedLstDocument.length)
						this.$store.state.documents.selectedDocument = this.$store.state.documents.selectedLstDocument[0];
					else
						this.$store.state.documents.selectedDocument = this.$store.getters.getNewDocument;;
					$("#bodyDocumentModal").modal('show');
					this.documentSend = 0;
				}
			}
		}
	);
