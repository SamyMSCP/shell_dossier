</script>
<script type="text/javascript" charset="utf-8">

	store.registerModule('beneficiaire', {
		state: {
			lstTypeDocument: <?=json_encode($this->RequiredDocumentBeneficiaire)?>,
			lst: <?=json_encode($this->lstBeneficiaire)?>,
			selectedBeneficiaire: {},
			token: "<?=$_SESSION['csrf'][0]?>"
		},
		getters: {
			getBeneficiaire: function(state, getters) {
				return (function(id) {
					return (state.lst.find(function(elm) {
						return (elm.id_benf == id);
					}));
				});
			},
			getBeneficiaireForDh: function(state, getters) {
				return (function(id_dh) {
					return (state.lst.filter(function(elm) {
						return (elm.id_dh == id_dh);
					}));
				});
			},
			getPersonnePhysiqueForBeneficiaire: function (state, getters) {
				return (function (id_ben) {
					var rt = [];
					var ben = state.lst.find(function(elm) {
						return (elm.id_benf == id_ben);
					});
					if (typeof ben == 'undefined')
						return ;
					ben.personnes.map(function(elm) {
						rt.push(getters.getPersonnePhysique(elm));
					});
					return (rt);
				});
			},
			getToken: function(state, getters) {
				return (state.token);
			}
		},
		mutations : {
			BENEFICIAIRE_SET_SELECTED: function(state, data) {
				if (data != 0)
					state.selectedBeneficiaire = JSON.parse(JSON.stringify(data));
				else
					state.selectedBeneficiaire = 0;
			},
			BENEFICIAIRE_ADD: function(state, data)
			{
				store.dispatch('BENEFICAIRE_ADD', data)
				.then(function() {
					$('#modalBenefAdd').modal('hide');
				},function(err) {
					console.log(err);
					msgBox.show("Les modifications n'ont pu etre enregistrées.");
				})
			},
			UPDATE_TOKEN: function (state, token) {
				state.token = token;
			}
		},
		actions : {
			BENEFICIAIRE_SHOW_ADD: function (context) {
				$('#modalBenefAdd').modal('show');
			},
			BENEFICAIRE_ADD: function(context, data) {
				return (new Promise(function(resolve, reject) {
					Vue.http.post('ajax_request.php', {
						req: 'Beneficiaire',
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
			},
		}
	})
