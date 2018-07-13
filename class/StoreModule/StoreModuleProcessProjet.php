<?php
class StoreModuleProcessProjet extends StoreModule {

	public static function getVuexState() {
		$rt = [];
		$rt['Blocks'] = [
			"ProjetChoixBeneficiaire" => [
				"selectedBox" => -1,
				"montant" => ['canSet' => true, 'value' => null]
			]
		];
		$rt['pages'] = ProcedureCreationProjet::getSteps();
		return ($rt);
	}

	public static function getVuexActions() {
		$rt = "
			projet2SetConfigured: function(context, payload) {
				if (payload.id_beneficiaire.value != null)
					context.commit('set_selected_Beneficiaire2', context.getters.getBeneficiaire2ById(payload.id_beneficiaire.value));
				if (payload.id_situation_physique.value != null)
					context.commit('set_selected_SituationPhysique', context.getters.getSituationPhysiqueById(payload.id_situation_physique.value));

				var profil = store.getters.getProfilInvestisseur2ByProjet2Id(payload.id.value);
				if (profil !== null) {
					context.commit('set_selected_ProfilInvestisseur2', profil);
				}
				context.commit('set_selected_Projet2', payload);
			},
			projet2useExist: function(context, payload) {
				var fnd = context.getters.getProjet2ForSelectedDh.find(function(elm) {
					return (elm.statut_parcour_client.value != 'Fin');
				});
				context.dispatch('projet2SetConfigured', fnd);
			},
			projet2SetIncoherence: function(context, payload) {
				var that = this;
				var datas = {
					selectedDonneurDOrdre: context.getters.getSelectedDonneurDOrdre,
					projet: context.getters.getSelectedProjet2,
					situation: context.getters.getSelectedSituationPhysique,
					selectedPersonnePhysique: context.getters.getSelectedPersonnePhysique,
					selectedProfilInvestisseur: context.getters.getSelectedProfilInvestisseur2,
					formulaire: payload.datas,
					nbr_incoherence: payload.nbr_incoherence
				};
				return (new Promise(function(resolve, reject) {
					Vue.http.post('graph_api.php', {
							Receiver: 'ProcedureCreationProjet',
							Action: 'setIncoherence',
							Datas: datas
						},
						{emulateJSON: true}
					)
					.then (
							function (res) {
								context.commit('modal_stack_pop');
								context.dispatch('update_datas', res.body);
								resolve();
							},
							function (res) {
								if (
									typeof res.body.dispatch[0].payload.coherence_nbr != 'undefined' &&
									res.body.dispatch[0].payload.coherence_nbr != datas.nbr_incoherence
								)
									context.commit('modal_stack_pop');
								//console.log(res.body);
								context.dispatch('update_datas', res.body);
								reject();
						}
					);
				}));
			},
			projet2SetBlock: function (context, payload) {
				var that = this;
				var datas = {
					selectedDonneurDOrdre: context.getters.getSelectedDonneurDOrdre,
					projet: context.getters.getSelectedProjet2,
					situation: context.getters.getSelectedSituationPhysique,
					selectedPersonnePhysique: context.getters.getSelectedPersonnePhysique,
					selectedProfilInvestisseur: context.getters.getSelectedProfilInvestisseur2,
					formulaire: payload.datas,
					name: payload.name
				};
				return (new Promise(function(resolve, reject) {

					Vue.http.post('graph_api.php', {
							Receiver: 'ProcedureCreationProjet',
							Action: 'setBlock',
							Datas: datas
						},
						{emulateJSON: true}
					).then (
						function (res) {
							context.commit('modal_stack_pop');
							context.dispatch('update_datas', res.body);
							resolve();
						},
						function (res) {
							if (
								typeof res.body.dispatch[0] != 'undefined' &&
								res.body.dispatch[0].name == 'set_incoherence'
							)
							{
								context.commit('modal_stack_pop');
							}
							context.dispatch('update_datas', res.body);
							reject();
						}
					);
				}));
			},
			projet2PreviousStep: function (context, payload) {
				var that = this;
				var datas = { 
					selectedDonneurDOrdre: context.getters.getSelectedDonneurDOrdre,
					projet: context.getters.getSelectedProjet2,
					situation: context.getters.getSelectedSituationPhysique,
					selectedPersonnePhysique: context.getters.getSelectedPersonnePhysique,
					selectedProfilInvestisseur: context.getters.getSelectedProfilInvestisseur2,
					formulaire: payload
				};
				return (new Promise(function(resolve, reject) {
					Vue.http.post('graph_api.php', {
							Receiver: 'ProcedureCreationProjet',
							Action: 'previousStep',
							Datas: datas
						},
						{emulateJSON: true}
					)
					.then (
							function (res) {
								context.dispatch('update_datas', res.body);
								resolve(res.body);
							},
							function (res) {
								context.dispatch('update_datas', res.body);
							reject(res.body);
						}
					);
				}));
			},
			projet2NextStepPop: function (context, payload) {
				context.commit('modal_stack_pop');
				setTimeout(function() {
					context.dispatch('projet2NextStep', payload);
				}, 500);
			},
			projet2SetActual: function (context, payload) {
				var that = this;
				var datas = {
					selectedDonneurDOrdre: context.getters.getSelectedDonneurDOrdre,
					projet: context.getters.getSelectedProjet2,
					situation: context.getters.getSelectedSituationPhysique,
					selectedPersonnePhysique: context.getters.getSelectedPersonnePhysique,
					selectedProfilInvestisseur: context.getters.getSelectedProfilInvestisseur2,
					formulaire: payload
				};
				return (new Promise(function(resolve, reject) {
					Vue.http.post('graph_api.php', {
							Receiver: 'ProcedureCreationProjet',
							Action: 'setActual',
							Datas: datas
						},
						{emulateJSON: true}
					)
					.then (
							function (res) {
								context.dispatch('update_datas', res.body);
								resolve(res.body);
							},
							function (res) {
								context.dispatch('update_datas', res.body);
								reject(res.body);
						}
					);
				}));
			},
			projet2NextStep: function (context, payload) {
				var that = this;
				var datas = {
					selectedDonneurDOrdre: context.getters.getSelectedDonneurDOrdre,
					projet: context.getters.getSelectedProjet2,
					situation: context.getters.getSelectedSituationPhysique,
					selectedPersonnePhysique: context.getters.getSelectedPersonnePhysique,
					selectedProfilInvestisseur: context.getters.getSelectedProfilInvestisseur2,
					formulaire: payload
				};
				return (new Promise(function(resolve, reject) {
					Vue.http.post('graph_api.php', {
							Receiver: 'ProcedureCreationProjet',
							Action: 'nextStep',
							Datas: datas
						},
						{emulateJSON: true}
					)
					.then (
							function (res) {
								context.dispatch('update_datas', res.body);
								resolve(res.body);
							},
							function (res) {
								context.dispatch('update_datas', res.body);
								reject(res.body);
						}
					);
				}));
			},
		";
		return ($rt);
	}

	public static function getVuexMutations() {
		$rt = "
			projet2NextStep: function (state, payload) {
				//console.log('coucou');
			},
		";
		return ($rt);
	}

	public static function getVuexGetters() {
		$rt = "";
		return ($rt);
	}

	public static function getVuexWatchers() {
		return ([
			"getter" => "
				return ({
					'status': state.mscpi.datas.Projet2.selected.statut_parcour_client.value,
					'session': state.mscpi.global.session,
					'page': state.mscpi.global.pages,
					'dt': state.mscpi.modules.StoreModuleProcessProjet.pages
				});
			",
			"function" => "
				for (key in data.dt) {
					if (data.dt[key].name == data.status) {
						data.session.page = data.dt[key].page;
						document.title = data.page[data.dt[key].page].title;
					}
				}
			"
		]);
	}
}
