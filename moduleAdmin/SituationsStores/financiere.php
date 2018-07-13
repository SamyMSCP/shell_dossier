</script>
<script type="text/javascript" charset="utf-8">
store.registerModule('situationFinanciere',{
	state: {
		lst: <?=json_encode($this->SituationFinanciere)?>,
		selected: {},
		_new: {}
	},
	mutations: {
		NEW_SITUATION_FINANCIERE: function(state, data) {
			var nelm = JSON.parse(JSON.stringify(data));
			nelm.id = 0;
			nelm.date_situation = new Date().getTime() / 1000;
			nelm.date_fin_situation = nelm.date_situation + <?=TIME_SITUATION_VALID?>;
			state._new = nelm;
			state.selected = state._new;
		},
		SAVE_NEW_SITUATION_FINANCIERE: function(state, data) {
			state.lst.push(data);
			return (data);
		}
	},
	actions: {
		SET_DEFAULT_SITUATION_FINANCIERE_BY_ID_SITUATION: function(context, id_situation) {
			var last = context.getters.getSituationFinanciereByIdSituation(id_situation);
			if (last.length > 0)
			{
				if (typeof context.state._new.id_situation != 'undefined' && context.state._new.id_situation != id_situation)
					context.state._new = {};
				if (typeof context.state.selected.id_situation == 'undefined' || context.state._new.id_situation != id_situation)
					context.state.selected = last[0];
			}
			else
				context.commit("NEW_SITUATION_FINANCIERE", {
					id_situation: id_situation,
					creatorShortName: "",
					revenu_professionnels: "",
					revenu_immobiliers: "",
					revenu_mobiliers: "",
					revenu_autres: "",
					remboursement_mensuel: "",
					duree_remboursement_restante: "",
					residance_montant: "",
					residance_duree: "",
					consommation_montant: "",
					consommation_duree: "",
					locatif_montant: "",
					locatif_duree: "",
					scpi_montant: "",
					scpi_duree: "",
					autres_remboursement_montant: "",
					autres_remboursement_duree: "",
					nature_revenu_autres: "",
					loyer_montant: "",
					autres_charges: "",
					habitation: ""
				});
		},
		SAVE_NEW_SITUATION_FINANCIERE: function(context, data) {
			return (new Promise(function(resolve, reject) {
				Vue.http.post('ajax_request.php', {
						req: 'RestSituation',
						action: 'insert_situation_financiere',
						data: context.state._new,
						token: "<?=$_SESSION['csrf'][0]?>"
					},
					{emulateJSON: true}).then(
						function (res) {
							var ndata = context.commit("SAVE_NEW_SITUATION_FINANCIERE", res.body);
							context.state._new = {};
							context.dispatch('SET_DEFAULT_SITUATION_FINANCIERE_BY_ID_SITUATION', context.rootState.beneficiaire.selectedBeneficiaire.id_situation);
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
		getSituationFinanciere: function(state, getters) {
			return (function(id) {
				return (state.lst.find(function(elm) {
					return (elm.id == id);
				}));
			});
		},
		getSituationFinanciereForPp: function(state, getters) {
			return (function(Pp) {
				return (getters.getSituationFinanciereByIdSituation(Pp.id_situation));
			});
		},
		getSituationFinanciereByIdSituation: function(state, getters) {
			return (function(id_situation) {
				return (state.lst.filter(function(elm) {
					return (elm.id_situation == id_situation);
				})
				.sort(function (a, b) {
					return (b.date_situation - a.date_situation);
				}));
			});
		},
		getSituationFinanciereSelectedIsValid: function(state, getters)
		{
			return (
				typeof state.selected.id_situation != "undefined" &&
				state.selected.id_situation != 0 &&
				state.selected.id == 0 &&

				isNumber(state.selected.revenu_professionnels) &&
				isNumber(state.selected.revenu_immobiliers) &&
				isNumber(state.selected.revenu_mobiliers) &&
				isNumber(state.selected.revenu_autres) &&
				isNumber(state.selected.habitation) &&

				(state.selected.habitation != 1 || isNumber(state.selected.duree_remboursement_restante)) &&
				(state.selected.habitation != 1 || isNumber(state.selected.remboursement_mensuel)) &&
				(state.selected.habitation != 2 || isNumber(state.selected.loyer_montant)) &&
				isNumber(state.selected.residance_duree) &&
				isNumber(state.selected.residance_montant) &&
				isNumber(state.selected.locatif_duree) &&
				isNumber(state.selected.locatif_montant) &&
				isNumber(state.selected.scpi_duree) &&
				isNumber(state.selected.scpi_montant) &&
				isNumber(state.selected.consommation_duree) &&
				isNumber(state.selected.consommation_montant) &&
				isNumber(state.selected.autres_remboursement_duree) &&
				isNumber(state.selected.autres_remboursement_montant) &&
				isNumber(state.selected.autres_charges) &&

				(state.selected.nature_revenu_autres.length >= 2 ||  state.selected.revenu_autres <= 0) &&

				(state.selected.habitation != 1 || !myXor(state.selected.duree_remboursement_restante, state.selected.remboursement_mensuel)) &&
				!(state.selected.habitation == 2 && state.selected.loyer_montant  == 0) &&
				!myXor(state.selected.residance_duree, state.selected.residance_montant) &&
				!myXor(state.selected.locatif_duree, state.selected.locatif_montant) &&
				!myXor(state.selected.scpi_duree, state.selected.scpi_montant) &&
				!myXor(state.selected.consommation_duree, state.selected.consommation_montant) &&
				!myXor(state.selected.autres_remboursement_duree, state.selected.autres_remboursement_montant)
			);
		}
	}
});
