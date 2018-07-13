</script>
<script type="text/javascript" charset="utf-8">

	store.registerModule('projets', {
		state: {
			lstTypeDocument: <?=json_encode($this->RequiredDocumentProjet)?>,
			lst: <?=json_encode($this->lstProjet)?>,
			lstObjectifs: <?=json_encode($this->lstObjectifs)?>,
			lstOrigine: <?=json_encode($this->lstOrigine)?>,
			selectedProject: {},
			fourchettes: <?=json_encode($this->fourchettes)?>,
			listObjectifChx: <?=json_encode(ObjectifsList::getAll())?>
		},
		mutations : {
			PROJECTS_SET_SELECTED: function(state, data) {
				state.selectedProject = JSON.parse(JSON.stringify(data));
				store.commit("TRANSACTIONS_SET_SELECTED_FOR_PROJECT", JSON.parse(JSON.stringify(store.getters.getTransactionForProject(data.id))));
			},
			<?php // TODO : Il faut trouver un moyen pour mettre a jour les a l'état 5 lorsqu'un Rec à été signé !  ?>
			PROJECTS_UPDATE_AUTRES_ELEMENTS : function(state, data) {
				state.lst = state.lst.map(function(elm) {
					if (elm.id == data.id)
					{
						elm.autres_elements = data.autres_elements;
					}
					return (elm);
				});
			},
			PROJECTS_UPDATE_STRATEGIE: function(state, data) {
				state.lst = state.lst.map(function(elm) {
					if (elm.id == data.id)
					{
						elm.strategie = data.strategie;
					}
					return (elm);
				});
			},
			PROJECTS_UPDATE_COMMENTAIRE: function(state, data) {
				state.lst = state.lst.map(function(elm) {
					if (elm.id == data.id)
					{
						elm.commentaire = data.commentaire;
					}
					return (elm);
				});
			},
			PROJECTS_UPDATE_NAME: function(state, data) {
				state.lst = state.lst.map(function(elm) {
					if (elm.id == data.id)
					{
						elm.nom = data.nom;
					}
					return (elm);
				});
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
			PROJECTS_UPDATE_OBJECTIF_LIST_1: function(state, data) {
				state.lst = state.lst.map(function(elm) {
					if (elm.id == data.id)
					{
						elm.id_objectifs_list_1 = data.id_objectifs_list_1;
					}
					return (elm);
				});
				state.selectedProject.id_objectifs_list_1 = data.id_objectifs_list_1;
			},
			PROJECTS_UPDATE_OBJECTIF_LIST_2: function(state, data) {
				state.lst = state.lst.map(function(elm) {
					if (elm.id == data.id)
					{
						elm.id_objectifs_list_2 = data.id_objectifs_list_2;
					}
					return (elm);
				});
				state.selectedProject.id_objectifs_list_2 = data.id_objectifs_list_2;
			},
			PROJECTS_UPDATE_OBJECTIF_LIST_3: function(state, data) {
				state.lst = state.lst.map(function(elm) {
					if (elm.id == data.id)
					{
						elm.id_objectifs_list_3 = data.id_objectifs_list_3;
					}
					return (elm);
				});
				state.selectedProject.id_objectifs_list_3 = data.id_objectifs_list_3;
			},
			PROJECTS_UPDATE: function(state, data) {
				state.lst = state.lst.map(function(elm) {
					if (elm.id == data.id)
						return (data);
					return (elm);
				});
				state.selectedProject = JSON.parse(JSON.stringify(data));
			}
		},
		actions: {
			PROJECTS_RELOAD_SELECTED: function(context, data) {
				// TODO : Recharger le Projet avec l'id passé en parametres.
				// Utilisé lorsqu'un rec est défini comme signé !
				return (new Promise(function(resolve, reject) {
					Vue.http.post('ajax_request.php', {
							req: 'RestProject',
							action: 'reloadOne',
							data: context.getters.getSelectedProject,
							token: "<?=$_SESSION['csrf'][0]?>"
						},
						{emulateJSON: true}).then(
							function (res) {
								context.commit("PROJECTS_UPDATE", res.body);
								resolve(res.body);
							},
							function (res) {
								if (typeof res.body.err != 'undefined')
									msgBox.show(res.body.err);
								else 
									msgBox.show("La génération du rec à échouée !");
								reject();
						}
					)
				}));
			},
			GENERATE_REC: function(context, data) {
				return (new Promise(function(resolve, reject) {
					Vue.http.post('ajax_request.php', {
							req: 'RestProject',
							action: 'generateRec',
							data: data,
							token: "<?=$_SESSION['csrf'][0]?>"
						},
						{emulateJSON: true}).then(
							function (res) {
								resolve(res.body);
								context.dispatch("DOCUMENTS_RELOAD");
							},
							function (res) {
								if (typeof res.body.err != 'undefined')
									msgBox.show(res.body.err);
								else 
									msgBox.show("La génération du rec à échouée !");
								reject();
						}
					)
				}));
			},
			PROJECT_SET_OBJECTIF_LIST: function(context, nbr) {
				return (new Promise(function(resolve, reject) {
					Vue.http.post('ajax_request.php', {
							req: 'RestProject',
							action: 'setObjectifsList' + nbr,
							data: context.state.selectedProject,
							token: "<?=$_SESSION['csrf'][0]?>"
						},
						{emulateJSON: true}).then(
							function (res) {
								context.commit("PROJECTS_UPDATE_OBJECTIF_LIST_" + nbr, res.body);
								resolve(res.body);
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
			PROJECT_SET_STATUS_1: function(context, data) {
				return (new Promise(function(resolve, reject) {
					Vue.http.post('ajax_request.php', {
							req: 'RestProject',
							action: 'setStatus1',
							data: data,
							token: "<?=$_SESSION['csrf'][0]?>"
						},
						{emulateJSON: true}).then(
							function (res) {
								context.commit("PROJECTS_UPDATE_STATUS", res.body);
								resolve(res.body);
								context.state.selectedProject.commentIsModify = false;
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
			PROJECT_SET_STATUS_2: function(context, data) {
				return (new Promise(function(resolve, reject) {
					Vue.http.post('ajax_request.php', {
							req: 'RestProject',
							action: 'setStatus2',
							data: data, 
							token: "<?=$_SESSION['csrf'][0]?>"
						},
						{emulateJSON: true}).then(
							function (res) {
								context.commit("PROJECTS_UPDATE_STATUS", res.body);
								resolve(res.body);
								context.state.selectedProject.commentIsModify = false;
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
			PROJECT_SET_STATUS_3: function(context, data) {
				return (new Promise(function(resolve, reject) {
					Vue.http.post('ajax_request.php', {
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
					Vue.http.post('ajax_request.php', {
							req: 'RestProject',
							action: 'setStatus4',
							data: data,
							token: "<?=$_SESSION['csrf'][0]?>"
						},
						{emulateJSON: true}).then(
							function (res) {
								context.commit("PROJECTS_UPDATE_STATUS", res.body);
								context.dispatch("DOCUMENTS_RELOAD", res.body);
								resolve(res.body);
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
			PROJECTS_UPDATE: function(context, data) {
			},
			PROJECTS_GET: function(context, data) {
			},
			PROJECTS_SAVE_AUTRES_ELEMENTS: function(context, data) {
				return (new Promise(function(resolve, reject) {
					Vue.http.post('ajax_request.php', {
							req: 'RestProject',
							action: 'updateAutresElements',
							data: data,
							token: "<?=$_SESSION['csrf'][0]?>"
						},
						{emulateJSON: true}).then(
							function (res) {
								context.commit("PROJECTS_UPDATE_AUTRES_ELEMENTS", data);
								resolve(res.body);
								context.state.selectedProject.autresElementsIsModify = false;
							},
							function (res) {
								if (typeof res.body.err != 'undefined')
									msgBox.show(res.body.err);
								else 
									msgBox.show("La strategie n'a pas pu etre mis a jours !");
								reject();
						}
					)
				}));
			},
			PROJECTS_SAVE_STRATEGIE: function(context, data) {
				return (new Promise(function(resolve, reject) {
					Vue.http.post('ajax_request.php', {
							req: 'RestProject',
							action: 'updateStrategie',
							data: data,
							token: "<?=$_SESSION['csrf'][0]?>"
						},
						{emulateJSON: true}).then(
							function (res) {
								context.commit("PROJECTS_UPDATE_STRATEGIE", data);
								resolve(res.body);
								context.state.selectedProject.strategieIsModify = false;
							},
							function (res) {
								if (typeof res.body.err != 'undefined')
									msgBox.show(res.body.err);
								else 
									msgBox.show("La strategie n'a pas pu etre mis a jours !");
								reject();
						}
					)
				}));
			},
			PROJECTS_SAVE_COMMENTAIRE: function(context, data) {
				return (new Promise(function(resolve, reject) {
					Vue.http.post('ajax_request.php', {
							req: 'RestProject',
							action: 'updateCommentaire',
							data: data,
							token: "<?=$_SESSION['csrf'][0]?>"
						},
						{emulateJSON: true}).then(
							function (res) {
								context.commit("PROJECTS_UPDATE_COMMENTAIRE", data);
								resolve(res.body);
								context.state.selectedProject.commentIsModify = false;
							},
							function (res) {
								if (typeof res.body.err != 'undefined')
									msgBox.show(res.body.err);
								else 
									msgBox.show("Le commentaire n'a pas pu etre mis a jours !");
								reject();
						}
					)
				}));
			},
			PROJECTS_SAVE_NAME: function(context, data) {
				return (new Promise(function(resolve, reject) {
					Vue.http.post('ajax_request.php', {
							req: 'RestProject',
							action: 'updateName',
							data: data,
							token: "<?=$_SESSION['csrf'][0]?>"
						},
						{emulateJSON: true}).then(
							function (res) {
								context.commit("PROJECTS_UPDATE_NAME", data);
								resolve(res.body);
								context.state.selectedProject.isModify = false;
							},
							function (res) {
								if (typeof res.body.err != 'undefined')
									msgBox.show(res.body.err);
								else 
									msgBox.show("Le nom n'a pas pu etre mis a jours !");
								reject();
						}
					)
				}));
			}
		},
		getters: {
			getProjetForBeneficiaire: function(state, getters) {
				return (function(id_benf) {
					return (state.lst.filter(function(elm) {
						return (elm.id_beneficiaire == id_benf);
					}));
				});
			},
			getProjectsForDh: function(state, getters) {
				return (function(id_dh) {
					return (state.lst);
				});
			},
			getSelectedProject: function (state, getters) {
				return (state.selectedProject);
			},
			getFourchettes: function (state, getters) {
				return (state.fourchettes);
			},
			getObjectifs: function (state, getters) {
				return (state.lstObjectifs);
			},
			getOrigine: function (state, getters) {
				return (state.lstOrigine);
			},
			getPersonnePhysiqueForSelectedProjet: function (state, getters) {
				var rt = getters.getPersonnePhysiqueForBeneficiaire(state.selectedProject.id_beneficiaire)
				if (typeof rt == 'undefined')
					return ;
				return (rt);
			},
			getProfilInvestisseurForSelectedProjet: function (state, getters) {
				var rt = [];
				var Pp = getters.getPersonnePhysiqueForBeneficiaire(state.selectedProject.id_beneficiaire)
				if (typeof Pp == 'undefined')
					return ;
				Pp.map(function(Pp) {
					if (typeof Pp.profilInvestisseur != 'undefined')
						rt.push(Pp.profilInvestisseur);
				});
				return (rt);
			},
			getSelectedProjectDocuments: function(state, getters) {
				return (getters.getDocumentsLinkEntity(5, state.selectedProject.id).sort(function(a, b) {
					return (b.date_creation - a.date_creation);
				}));
			},
			getSelectedProjectNotifications: function(state, getters) {
				var rt = [];
				rt.push({
					content: "Publication d’une question par Alain DUPONT",
					date: 1482755001,
					icon: null
				});
				rt.push({
					content: "Publication d’uneréponse par Claire PILLON",
					date: 1483791801,
					icon: null
				});
				rt.push({
					content: "Création du profil investisseur pour Isabelle DUPONT",
					date: 1485087801,
					icon: null
				});
				rt.push({
					content: "Publication d’une comparaison entre les SCPI du marché XX",
					date: 1485087802,
					icon: null
				});
				rt.push({
					content: "Publication d’une simulation de projet",
					date: 1485087803,
					icon: null
				});
				rt.push({
					content: "Envoi par courrier des certificats de propriétés",
					date: 1485087804,
					icon: null
				});
				rt.push({
					content: "Appel concernant le projet X",
					date: 1485087805,
					icon: null
				});
				rt.push({
					content: "Envoi par email des documents à remplir pour le projet X",
					date: 1485087806,
					icon: null
				});
				rt.push({
					content: "Création du profil investisseur pour Isabelle DUPONT",
					date: 1485087801,
					icon: null
				});
				rt.push({
					content: "Publication d’une comparaison entre les SCPI du marché XX",
					date: 1485087802,
					icon: null
				});
				rt.push({
					content: "Publication d’une simulation de projet",
					date: 1485087803,
					icon: null
				});
				rt.push({
					content: "Envoi par courrier des certificats de propriétés",
					date: 1485087804,
					icon: null
				});
				rt.push({
					content: "Appel concernant le projet X",
					date: 1485087805,
					icon: null
				});
				rt.push({
					content: "Envoi par email des documents à remplir pour le projet X",
					date: 1485087806,
					icon: null
				});
				rt.push({
					content: "Création du profil investisseur pour Isabelle DUPONT",
					date: 1485087801,
					icon: null
				});
				rt.push({
					content: "Publication d’une comparaison entre les SCPI du marché XX",
					date: 1485087802,
					icon: null
				});
				rt.push({
					content: "Publication d’une simulation de projet",
					date: 1485087803,
					icon: null
				});
				rt.push({
					content: "Envoi par courrier des certificats de propriétés",
					date: 1485087804,
					icon: null
				});
				rt.push({
					content: "Appel concernant le projet X",
					date: 1485087805,
					icon: null
				});
				rt.push({
					content: "Envoi par email des documents à remplir pour le projet X",
					date: 1485087806,
					icon: null
				});
				rt.push({
					content: "Création du profil investisseur pour Isabelle DUPONT",
					date: 1485087801,
					icon: null
				});
				rt.push({
					content: "Publication d’une comparaison entre les SCPI du marché XX",
					date: 1485087802,
					icon: null
				});
				rt.push({
					content: "Publication d’une simulation de projet",
					date: 1485087803,
					icon: null
				});
				rt.push({
					content: "Envoi par courrier des certificats de propriétés",
					date: 1485087804,
					icon: null
				});
				rt.push({
					content: "Appel concernant le projet X",
					date: 1485087805,
					icon: null
				});
				rt.push({
					content: "Envoi par email des documents à remplir pour le projet X",
					date: 1485087806,
					icon: null
				});
				/*
				getters.getPersonnePhysiqueForSelectedProjet.map(function(elm) {
					if (typeof elm.profilInvestisseur != 'undefined')
						rt.push({type: "profil", date: elm.profilInvestisseur.date_creation, data: elm});
				});
				getters.getSelectedProjectDocuments.map(function(elm) {
					var type = "document";
					if (elm.id_type_document == 7)
						type = "Comparaison";
					else if (elm.id_type_document == 8)
						type = "Simulation";
					else if (elm.id_type_document == 9)
						type = "REC";
					else if (elm.id_type_document == 10)
						type = "JUST ORIGINE FONDS";
					rt.push({type: type, date: elm.date_creation, data: elm});
				});
				*/
				rt.sort(function(a, b) {
					return (a.date - b.date);
				});
				return (rt);
			}
		}
	})
