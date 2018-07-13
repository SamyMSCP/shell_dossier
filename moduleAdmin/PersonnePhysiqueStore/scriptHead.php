</script>
<script type="text/javascript" charset="utf-8">
	store.registerModule('personnePhysiqueStore', {
		state: {
			lstTypeDocument: <?=json_encode($this->RequiredDocumentPersonnePhysique)?>,
			lst:<?=json_encode($this->lstPp)?>,
			selectedPp: null,
			listQuestions: <?=json_encode($this->listQuestions)?>,
			listReponses: <?=json_encode($this->listReponses)?>,
			token: "<?=$_SESSION['csrf'][0]?>"
		},
		mutations : {
			SHOW_PROFIL: function(state, data) {
				state.selectedPp = data;
				$('#seeProfilModal').modal('show');
			},
			PERSONNE_PHYSIQUE_SHOW_ADD: function(state)
			{
				state.selectedPp  = {
				id: 0,
				civilite: "",
				nom_jeune_fille: "",
				nom: "",
				prenom: "",
				mail: "",
				telephone: "",
				indicatif_telephonique: "",
				telephone_fixe: "",
				indicatif_telephonique_fixe: "",
				date_naissance: 0,
				lieu_naissance: "",
				nationalite: "",
				etat_civil: "",
				us_person: "",
				politique: "",
				complementAdresse: "",
				numeroRue: "",
				voie: "",
				codePostal: "",
				ville: "",
				pays: "",
				paysNaissance: "",
				profession: ""};
				$('#modalPp').modal('show');
			}
		},
		actions: {
			PERSONNE_PHYSIQUE_ADD: function(context, data)
			{
				return (new Promise(function(resolve, reject) {
					Vue.http.post('ajax_request.php', {
						req: 'updatePp',
						subreq: 'add',
						data: data,
						token: context.getters.getToken
					}, {emulateJSON: true}).then(
						function (res)
						{
							context.commit('UPDATE_TOKEN', res.body.token)
							console.log(res.body);
							if (res == 'KO')
								reject();
							resolve(res);
						},
						function (res) {
							context.commit('UPDATE_TOKEN', res.body.token)
							reject();
						}
					)
				}));
			}
		},
		getters: {
			getListQuestions: function(state, getters) {
				return (state.listQuestions);
			},
			getListReponses: function(state, getters) {
				return (state.listReponses);
			},
			getSelectedPersonnePhysique: function (state, getters) {
				return (state.selectedPp);
			},
			getPersonnePhysiqueForDh: function(state, getters) {
				return (function(id_dh) {
					return (state.lst.filter(function(elm) {
						return (elm.id_dh == id_dh);
					}));
				});
			},
			getPersonnePhysique: function (state, getters) {
				return (function (id) {
					return (state.lst.find(function(elm) {
						return (elm.id == id);
					}));
				});
			}
		}
	})
