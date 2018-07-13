</script>
<script type="text/javascript" charset="utf-8">
store.registerModule('situationJuridique',{
	state: {
		lst: <?=json_encode($this->SituationJuridique)?>,
		selected: {},
		regime_mat: <?=json_encode(SituationJuridique::$_regimeMatrimonial)?>,
		_new: {}
	},
	mutations: {
		NEW_SITUATION_JURIDIQUE: function(state, data) {
			var nelm = JSON.parse(JSON.stringify(data));
			nelm.id = 0;
			nelm.date_situation = new Date().getTime() / 1000;
			nelm.date_fin_situation = nelm.date_situation + <?=TIME_SITUATION_VALID?>;
			state._new = nelm;
			state.selected = state._new;
		},
		SAVE_NEW_SITUATION_JURIDIQUE: function(state, data) {
			state.lst.push(data);
			return (data);
		}
	},
	actions: {
		SET_DEFAULT_SITUATION_JURIDIQUE_BY_ID_SITUATION: function(context, id_situation) {
			var last = context.getters.getSituationJuridiqueByIdSituation(id_situation);
			if (last.length > 0)
			{
				if (typeof context.state._new.id_situation != 'undefined' && context.state._new.id_situation != id_situation)
					context.state._new = {};
				if (typeof context.state.selected.id_situation == 'undefined' || context.state._new.id_situation != id_situation)
					context.state.selected = last[0];
			}
			else
				context.commit("NEW_SITUATION_JURIDIQUE", {
					id_situation: id_situation,
					creatorShortName: "",
					haveChild: "",
					regime_mat: "",
					nbr_enfant_charge: "",
					nbr_pers_charge: "",
				});
		},
		SAVE_NEW_SITUATION_JURIDIQUE: function(context, data) {
			return (new Promise(function(resolve, reject) {
				Vue.http.post('ajax_request.php', {
						req: 'RestSituation',
						action: 'insert_situation_juridique',
						data: context.state._new,
						token: "<?=$_SESSION['csrf'][0]?>"
					},
					{emulateJSON: true}).then(
						function (res) {
							var ndata = context.commit("SAVE_NEW_SITUATION_JURIDIQUE", res.body);
							context.state._new = {};
							context.dispatch('SET_DEFAULT_SITUATION_JURIDIQUE_BY_ID_SITUATION', context.rootState.beneficiaire.selectedBeneficiaire.id_situation);
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
		getSituationJuridique: function(state, getters) {
			return (function(id) {
				return (state.lst.find(function(elm) {
					return (elm.id == id);
				}));
			});
		},
		getSituationJuridiqueForPp: function(state, getters) {
			return (function(Pp) {
				return (getters.getSituationJuridiqueByIdSituation(Pp.id_situation));
			});
		},
		getSituationJuridiqueByIdSituation: function(state, getters) {
			return (function(id_situation) {
				return (state.lst.filter(function(elm) {
					return (elm.id_situation == id_situation);
				})
				//);
				.sort(function (a, b) {
					return (b.date_situation - a.date_situation);
				}));
			});
		},
		getSituationJuridiqueSelectedIsValid: function(state, getters)
		{
			return (
				typeof state.selected.id_situation != "undefined" &&
				state.selected.id_situation != 0 &&
				state.selected.id == 0 &&
				state.selected.nbr_enfant_charge >= 0 &&
				isNumber(state.selected.nbr_enfant_charge) &&
				state.selected.nbr_pers_charge >= 0 &&
				isNumber(state.selected.nbr_pers_charge) &&
				typeof state.regime_mat[state.selected.regime_mat] != 'undefined' &&
				state.selected.haveChild !== null
			);
		}
	}
});
