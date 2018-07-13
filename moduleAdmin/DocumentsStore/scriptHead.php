</script>
<script type="text/javascript" charset="utf-8">


	store.registerModule('documents', {
		state: {
			allTypeDocuments: <?=json_encode($this->typeDocuments)?>,
			entity: <?=json_encode($this->entity)?>,
			lstDocuments: <?=json_encode($this->dhDocuments)?>,
			selectedLstDocument: [],
			selectedDocument: null,
			id_entity: 0,
			link_entity: 0,
			type_document: 0,
			changeSigned: false
		},
		mutations : {
			DOCUMENTS_SET_CONFIGURATION: function(state, data) {
				state.id_entity = data.id_entity;
				state.link_entity = data.link_entity;
				state.type_document = data.type_document;
				//console.log(state.id_entity, state.link_entity, state.type_document);
				state.selectedLstDocument = state.lstDocuments[state.id_entity][state.link_entity][state.type_document];
			},
			DOCUMENTS_UPDATE_ALL: function(state, data) {
				state.lstDocuments = data;
				state.selectedLstDocument = state.lstDocuments[state.id_entity][state.link_entity][state.type_document];
				var tmp;
				if (typeof state.selectedDocument != "undefined" && state.selectedDocument != null && typeof state.selectedDocument.id != "undefined")
					tmp = state.selectedLstDocument.find(function(elm) {
						return (elm.id == state.selectedDocument.id);
					});
				if (typeof tmp != 'undefined')
					state.selectedDocument = tmp;
			}
		},
		actions: {
			DOCUMENTS_SAVE_DATE_EXECUTION: function(context, data) {
				return (new Promise(function(resolve, reject) {
					Vue.http.post('ajax_request.php', {
							req: 'AjaxDocument',
							action: 'saveDateExecution',
							data: data,
							id_client: <?=intval($GLOBALS['GET']['client'])?>,
							token: "<?=$_SESSION['csrf'][0]?>"
						},
						{emulateJSON: true}
					)
					.then (
							function (res) {
								context.commit("DOCUMENTS_UPDATE_ALL", res.body)
								resolve();
							},
							function (res) {
								if (typeof res.body.err != 'undefined')
									msgBox.show(res.body.err);
								else 
									msgBox.show("Les document n'ont pas pu etre rechargés !");
								reject();
						}
					);
				}));
			},
			DOCUMENTS_CHANGE_SIGNED: function(context, data) {
				return (new Promise(function(resolve, reject) {
					Vue.http.post('ajax_request.php', {
							req: 'AjaxDocument',
							action: 'changeSignedDocument',
							data: data,
							id_client: <?=intval($GLOBALS['GET']['client'])?>,
							token: "<?=$_SESSION['csrf'][0]?>"
						},
						{emulateJSON: true}
					)
					.then (
							function (res) {
								context.commit("DOCUMENTS_UPDATE_ALL", res.body)
								resolve();
								if (data.id_type_document == 9)
									store.dispatch("PROJECTS_RELOAD_SELECTED", data);
							},
							function (res) {
								if (typeof res.body.err != 'undefined')
									msgBox.show(res.body.err);
								else 
									msgBox.show("Les document n'ont pas pu etre rechargés !");
								reject();
						}
					);
				}));
			},
			DOCUMENTS_CHANGE_VALIDATED: function(context, data) {
				return (new Promise(function(resolve, reject) {
					Vue.http.post('ajax_request.php', {
							req: 'AjaxDocument',
							action: 'changeValidatedDocument',
							data: {'id': data.id},
							id_client: <?=intval($GLOBALS['GET']['client'])?>,
							token: "<?=$_SESSION['csrf'][0]?>"
						},
						{emulateJSON: true}
					)
					.then (
						function (res) {
							context.commit("DOCUMENTS_UPDATE_ALL", res.body)
							if (data.id_type_document == 9)
								store.dispatch("PROJECTS_RELOAD_SELECTED", data);
							resolve();
						},
						function (res) {
							if (typeof res.body != 'undefined' && typeof res.body.err != 'undefined')
								msgBox.show(res.body.err);
							else 
								msgBox.show("Les document n'ont pas pu etre rechargés !");
							reject();
						}
					);
				}));
			},
			DOCUMENTS_RELOAD: function(context, data) {
				data = "";
				return (new Promise(function(resolve, reject) {
					Vue.http.post('ajax_request.php', {
							req: 'AjaxDocument',
							action: 'reload',
							data: data,
							id_client: <?=intval($GLOBALS['GET']['client'])?>,
							token: "<?=$_SESSION['csrf'][0]?>"
						},
						{emulateJSON: true}
					)
					.then (
							function (res) {
								context.commit("DOCUMENTS_UPDATE_ALL", res.body)
								resolve();
							},
							function (res) {
								if (typeof res.body != 'undefined' && typeof res.body.err != 'undefined')
									msgBox.show(res.body.err);
								else 
									msgBox.show("Les document n'ont pas pu etre rechargés !");
								reject();
						}
					);
				}));
			},
			DOCUMENTS_UPDATE_COMMENTAIRE: function(context, data) {
				console.log(data);
				return (new Promise(function(resolve, reject) {
					Vue.http.post('ajax_request.php', {
							req: 'AjaxDocument',
							action: 'updateCommentaire',
							data: data,
							id_client: <?=intval($GLOBALS['GET']['client'])?>,
							token: "<?=$_SESSION['csrf'][0]?>"
						},
						{emulateJSON: true}
					)
					.then (
							function (res) {
								context.commit("DOCUMENTS_UPDATE_ALL", res.body)
								context.state.selectedDocument = context.state.selectedLstDocument.find(function(elm) {
									return (elm.id == data.id);
								});
								msgBox.show("Le commentaire bien été enregistré !");
								resolve();
							},
							function (res) {
								if (typeof res.body.err != 'undefined')
									msgBox.show(res.body.err);
								else 
									msgBox.show("Le commentaire n'a pas pu etre enregistré !");
								reject();
						}
					);
				}));
			},
			DOCUMENTS_DELETE: function(context, data) {
				return (new Promise(function(resolve, reject) {
					Vue.http.post('ajax_request.php', {
							req: 'AjaxDocument',
							action: 'deleteDocument',
							data: data,
							id_client: <?=intval($GLOBALS['GET']['client'])?>,
							token: "<?=$_SESSION['csrf'][0]?>"
						},
						{emulateJSON: true}
					)
					.then (
							function (res) {
								context.commit("DOCUMENTS_UPDATE_ALL", res.body)
								if (context.state.selectedLstDocument.length)
									context.state.selectedDocument = context.state.selectedLstDocument[0];
								else
									context.state.selectedDocument = null;
								resolve();
							},
							function (res) {
								if (typeof res.body != 'undefined' && typeof res.body.err != 'undefined')
									msgBox.show(res.body.err);
								else 
									msgBox.show("Le document n'a pas pu etre supprimé!");
								reject();
						}
					);
				}));
			},
			DOCUMENTS_CREATE: function(context, inputId) {
				showLoading();
				var formData = new FormData();

				formData.append("document", document.getElementById(inputId).files[0]);
				var request = new XMLHttpRequest();
				formData.append("req", "AjaxDocument");
				formData.append("action", "sendFile");
				formData.append("data", "-");

				formData.append("idEntity", context.state.id_entity);
				formData.append("linkEntity", context.state.link_entity);
				formData.append("idTypeDocument", context.state.type_document);

				formData.append("id_client", <?=intval($GLOBALS['GET']['client'])?>);
				formData.append("token", "<?=$_SESSION['csrf'][0]?>");
				request.open("POST", "ajax_request.php");

				var res = "";
				request.onreadystatechange = function() {
					if (request.readyState == 4)
					{
						$("#loading").css("display", "none");
						res = JSON.parse(request.responseText);
						if (typeof res.doc != 'undefined')
							context.dispatch("DOCUMENTS_RELOAD", " ");
						else if (typeof res.err != 'undefined')
							msgBox.show(res.err);
						else
							msgBox.show("La réponse n'as pu etre interpretee !");
					}
						//console.log(request);

				};
				request.send(formData);
				//document.getElementById(inputId).value= "";
			}
		},
		getters: {
			getDocumentEntityNameById : function(state, getters) {
				return (
					function(id) {
						var rt = state.entity.filter(function(elm) {
								return (elm.id== id);
							})[0]
						if (typeof rt != "undefined")
							return (rt.name);
						return ("");
					}
				)
			},
			getTypeDocumentNameById : function(state, getters) {
				return (
					function(id) {
						var rt = state.allTypeDocuments.filter(function(elm) {
								return (elm.id== id);
							})[0]
						if (typeof rt != "undefined")
							return (rt.name);
						return ("");
					}
				)
			},
			getSelectedDocumentNeedSignature : function(state, getters) {
				return (function() {
					var tmp;
					if (typeof state.type_document != "undefined")
						tmp = state.allTypeDocuments.find(function (elm) {
							return (elm.id == state.type_document);
						});
						if (typeof tmp != "undefined")
							return (tmp.need_signature == 1);
					return (false);
				});
			},
			getDocumentEntityIdByName : function(state, getters) {
				return (
					function(name) {
						return (
							state.entity.filter(function(elm) {
								return (elm.name == name);
							})[0].id
						);
					}
				)
			},
			getDocumentsLinkEntity: function(state, getters) {
				return (
					function(id_entity, link_entity) {
						var rt = [];
						if (typeof state.lstDocuments[id_entity][link_entity] != 'undefined')
						{
							Object.keys(state.lstDocuments[id_entity][link_entity]).map(function(elm) {
								rt = rt.concat(state.lstDocuments[id_entity][link_entity][elm]);
							});
						}
						return (rt);
					}
				)
			},
			getHaveDocumentSigned: function(state, getters) {
				return (function(id_entity, link_entity, type_document) {
					var tmp = getters.getHaveDocument(id_entity, link_entity, type_document)
					return (tmp.some(function(elm) {
						return (
							elm.signed == 1 &&
							elm.date_execution <= <?=time()?> &&
							elm.date_expiration >= <?=time()?>
						);
					}));
				});
			},
			getHaveDocument: function(state, getters) {
				return (function(id_entity, link_entity, type_document) {
					if (
						typeof id_entity != "undefined"
						&& typeof state.lstDocuments[id_entity] != "undefined"
						&& typeof link_entity != "undefined"
						&& typeof state.lstDocuments[id_entity][link_entity] != "undefined"
						&& typeof type_document != "undefined"
						&& typeof state.lstDocuments[id_entity][link_entity][type_document] != "undefined"
					)
						return (state.lstDocuments[id_entity][link_entity][type_document]);
					return ([]);
				});
			},
			getSelectedLstDocument: function(state, getters) {
				return (state.selectedLstDocument);
			}
		}
	})
