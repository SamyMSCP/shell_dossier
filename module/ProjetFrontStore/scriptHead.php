</script>
<script type="text/javascript" charset="utf-8">

	store.registerModule('projets', {
		state: {
			lstTypeDocument: <?=json_encode($this->RequiredDocumentProjet)?>,
			lst: <?=json_encode($this->lstProjet)?>,
			lstObjectifs: <?=json_encode($this->lstObjectifs)?>,
			lstOrigine: <?=json_encode($this->lstOrigine)?>,
			selectedProject: null,
			fourchettes: <?=json_encode($this->fourchettes)?>,
			listObjectifChx: <?=json_encode(ObjectifsList::getAll())?>
		},
		mutations : {
			PROJECT_SET_SELECTED: function(state, data) {
				state.selectedProject = JSON.parse(JSON.stringify(state.lst.find(function (elm) {
					return (elm.id == data);
				})));
			},
			PROJECTS_UPDATE_DOCUMENTS: function(state, data) {
				state.lst = state.lst.map(function(elm) {
					if (elm.id == data.id)
						elm.documents = data.documents;
					return (elm);
				});
				state.selectedProject.documents = data.documents;
			},
			PROJECTS_UPDATE_STATUS: function(state, data) {
				state.lst = state.lst.map(function(elm) {
					if (elm.id == data.id)
					{
						elm.etat_du_projet = data.etat_du_projet;
					}
					return (elm);
				});
				state.selectedProject.etat_du_projet = data.etat_du_projet;
			},
		},
		actions: {
			PROJECT_CONTACT: function(context, data) {
				return (new Promise(function(resolve, reject) {
					Vue.http.post('ajax_request_client.php', {
							req: 'RestProject',
							action: 'contactProjet',
							data: data,
							token: "<?=$_SESSION['csrf'][0]?>"
						},
						{emulateJSON: true}).then(
							function (res) {
								resolve();
							},
							function (res) {
								if (typeof res.body.err != 'undefined')
									msgBox.show(res.body.err);
								else
									msgBox.show("La demande de contact à échouée !");
								reject();
						}
					)
				}));
				
			},
			PROJECT_SET_STATUS_3: function(context, data) {
				return (new Promise(function(resolve, reject) {
					Vue.http.post('ajax_request_client.php', {
							req: 'RestProject',
							action: 'setStatus3',
							data: data,
							token: "<?=$_SESSION['csrf'][0]?>"
						},
						{emulateJSON: true}).then(
							function (res) {
								context.commit("PROJECTS_UPDATE_STATUS", res.body);
								resolve(res.body);
								//context.state.selectedProject.commentIsModify = false;
							},
							function (res) {
								if (typeof res.body.err != 'undefined')
									msgBox.show(res.body.err);
								else
									msgBox.show("Le changement de status du projet n'a pas pu etre effectué !");
								reject();
						}
					)
				}));
			},
			PROJECT_SET_STATUS_4: function(context, data) {
				return (new Promise(function(resolve, reject) {
					Vue.http.post('ajax_request_client.php', {
							req: 'RestProject',
							action: 'setStatus4',
							data: data,
							token: "<?=$_SESSION['csrf'][0]?>"
						},
						{emulateJSON: true}).then(
							function (res) {
								context.commit("PROJECTS_UPDATE_STATUS", res.body);
								context.commit("PROJECTS_UPDATE_DOCUMENTS", res.body);
								resolve(res.body);
								//context.state.selectedProject.commentIsModify = false;
							},
							function (res) {
								if (typeof res.body.err != 'undefined')
									msgBox.show(res.body.err);
								else
									msgBox.show("Le changement de status du projet n'a pas pu etre effectué !");
								reject();
						}
					)
				}));
			},
		},
		getters: {
			getLstProjets: function(state, getters) {
				return (state.lst);
			},
			getSelectedProject: function(state, getters) {
				return (state.selectedProject);
			},
			getOrigine: function (state, getters) {
				return (state.lstOrigine);
			},
			getPersonnePhysiqueForSelectedProjet: function(state, getters)
			{
				if (state.selectedProject == null)
					return (null);
				return (state.selectedProject.Beneficiaire.personnes.map(function(Pp) {
					return (getters.getPersonnePhysique(Pp));
				}));
			}
		}
	});
