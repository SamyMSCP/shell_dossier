</script>
<script type="text/javascript" charset="utf-8">
/*

*/


store.registerModule('situationPatrimoniale',{
	state: {
		lst: <?=json_encode($this->SituationPatrimoniale)?>,
		selected: {},
		_new: {}
	},
	mutations: {
		NEW_SITUATION_PATRIMONIALE: function(state, data) {
			var nelm = JSON.parse(JSON.stringify(data));
			nelm.id = 0;
			nelm.date_situation = new Date().getTime() / 1000;
			nelm.date_fin_situation = nelm.date_situation + <?=TIME_SITUATION_VALID?>;
			state._new = nelm;
			state.selected = state._new;
		},
		SAVE_NEW_SITUATION_PATRIMONIALE: function(state, data) {
			state.lst.push(data);
			return (data);
		}
	},
	actions: {
		SET_DEFAULT_SITUATION_PATRIMONIALE_BY_ID_SITUATION: function(context, id_situation) {
			var last = context.getters.getSituationPatrimonialeByIdSituation(id_situation);
			if (last.length > 0)
			{
				if (typeof context.state._new.id_situation != 'undefined' && context.state._new.id_situation != id_situation)
					context.state._new = {};
				if (typeof context.state.selected.id_situation == 'undefined' || context.state._new.id_situation != id_situation)
					context.state.selected = last[0];
			}
			else
				context.commit("NEW_SITUATION_PATRIMONIALE", {
					id_situation: id_situation,
					creatorShortName: "",
					fourchette_montant_patrimoine: "",
					repartition_residence_principale: "",
					repartition_assurance_vie: "",
					repartition_PEA: "",
					repartition_PEL: "",
					repartition_residence_secondaire: "",
					repartition_immobilier_locatif: "",
					repartition_scpi: "",
					repartition_autres: "",
					futur_placement: "",
				});
		},
		SAVE_NEW_SITUATION_PATRIMONIALE: function(context, data) {
			return (new Promise(function(resolve, reject) {
				Vue.http.post('ajax_request.php', {
						req: 'RestSituation',
						action: 'insert_situation_patrimoniale',
						data: context.state._new,
						token: "<?=$_SESSION['csrf'][0]?>"
					},
					{emulateJSON: true}).then(
						function (res) {
							var ndata = context.commit("SAVE_NEW_SITUATION_PATRIMONIALE", res.body);
							context.state._new = {};
							context.dispatch('SET_DEFAULT_SITUATION_PATRIMONIALE_BY_ID_SITUATION', context.rootState.beneficiaire.selectedBeneficiaire.id_situation);
						},
						function (res) {
							if (typeof res.body.err != 'undefined')
								msgBox.show(res.body.err);
							else 
								msgBox.show("La situation n'a pas pu etre insérée !");
							reject();
						}
					)
				}
			));
		}
	},
	getters: {
		getSituationPatrimoniale: function(state, getters) {
			return (function(id) {
				return (state.lst.find(function(elm) {
					return (elm.id == id);
				}));
			});
		},
		getSituationPatrimonialeForPp: function(state, getters) {
			return (function(Pp) {
				return (getters.getSituationPatrimonialeByIdSituation(Pp.id_situation));
			});
		},
		getSituationPatrimonialeByIdSituation: function(state, getters) {
			return (function(id_situation) {
				return (state.lst.filter(function(elm) {
					return (elm.id_situation == id_situation);
				})
				.sort(function (a, b) {
					return (b.date_situation - a.date_situation);
				}));
			});
		},
		getSituationPatrimonialeSelectedIsValid: function(state, getters)
		{
			return (
				typeof state.selected.id_situation != "undefined" &&
				state.selected.id_situation != 0 &&
				state.selected.id == 0 &&

				isNumber(state.selected.fourchette_montant_patrimoine) &&
				isNumber(state.selected.repartition_residence_secondaire) &&
				isNumber(state.selected.repartition_immobilier_locatif) &&
				isNumber(state.selected.repartition_scpi) &&
				isNumber(state.selected.repartition_autres) &&
				isNumber(state.selected.futur_placement) &&
				isNumber(state.selected.repartition_residence_principale) &&
				isNumber(state.selected.repartition_assurance_vie) &&
				isNumber(state.selected.repartition_PEA) &&
				isNumber(state.selected.repartition_PEL) &&

				state.selected.fourchette_montant_patrimoine >= 0 &&
				state.selected.repartition_residence_secondaire >= 0 &&
				state.selected.repartition_immobilier_locatif >= 0 &&
				state.selected.repartition_scpi >= 0 &&
				state.selected.repartition_autres >= 0 &&
				state.selected.repartition_residence_principale >= 0 &&
				state.selected.repartition_assurance_vie >= 0 &&
				state.selected.repartition_PEA >= 0 &&
				state.selected.repartition_PEL >= 0 &&
				state.selected.futur_placement >= 1 &&
				state.selected.futur_placement <= 3
			);
		}
	}
});
