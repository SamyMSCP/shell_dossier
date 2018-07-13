</script>
<script type="text/javascript" charset="utf-8">
store.registerModule('situationFiscale',{
	state: {
		lst: <?=json_encode($this->SituationFiscale)?>,
		idActualImpot: <?=json_encode(Valeur_impot::getActual()->id)?>,
		impot: <?=json_encode(Valeur_impot::getForStore())?>,
		idActualImpotFortune: <?=json_encode(Valeur_impot_fortune::getActual()->id)?>,
		impotFortune: <?=json_encode(Valeur_impot_fortune::getForStore())?>,
		selected: {},
		_new: {}
	},
	mutations: {
		NEW_SITUATION_FISCALE: function(state, data) {
			var nelm = JSON.parse(JSON.stringify(data));
			nelm.id = 0;
			nelm.date_situation = new Date().getTime() / 1000;
			nelm.date_fin_situation = nelm.date_situation + <?=TIME_SITUATION_VALID?>;
			state._new = nelm;
			state.selected = state._new;
		},
		SAVE_NEW_SITUATION_FISCALE: function(state, data) {
			state.lst.push(data);
			return (data);
		}
	},
	actions: {
		SET_DEFAULT_SITUATION_FISCALE_BY_ID_SITUATION: function(context, id_situation) {
			var last = context.getters.getSituationFiscaleByIdSituation(id_situation);
			if (last.length > 0)
			{
				if (typeof context.state._new.id_situation != 'undefined' && context.state._new.id_situation != id_situation)
					context.state._new = {};
				if (typeof context.state.selected.id_situation == 'undefined' || context.state._new.id_situation != id_situation)
					context.state.selected = last[0];
			}
			else
				context.commit("NEW_SITUATION_FISCALE", {
					id_situation: id_situation,
					creatorShortName: "",
					residence_france: "",
					nbr_parts_fiscales: "",
					pays: "France",
					id_impot: context.state.idActualImpot,
					id_tranche_impot: "",
					id_impot_fortune: context.state.idActualImpotFortune,
					id_tranche_impot_fortune: "",
					impot_annee_precedente: "",
					haveImpot: "",
					haveImpotFortune: "",
				});
		},
		SAVE_NEW_SITUATION_FISCALE: function(context, data) {
			return (new Promise(function(resolve, reject) {
				Vue.http.post('ajax_request.php', {
						req: 'RestSituation',
						action: 'insert_situation_fiscale',
						data: context.state._new,
						token: "<?=$_SESSION['csrf'][0]?>"
					},
					{emulateJSON: true}).then(
						function (res) {
							var ndata = context.commit("SAVE_NEW_SITUATION_FISCALE", res.body);
							context.state._new = {};
							context.dispatch('SET_DEFAULT_SITUATION_FISCALE_BY_ID_SITUATION', context.rootState.beneficiaire.selectedBeneficiaire.id_situation);
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
		getSituationFiscale: function(state, getters) {
			return (function(id) {
				return (state.lst.find(function(elm) {
					return (elm.id == id);
				}));
			});
		},
		getSituationFiscaleForPp: function(state, getters) {
			return (function(Pp) {
				return (getters.getSituationFiscaleByIdSituation(Pp.id_situation));
			});
		},
		getSituationFiscaleByIdSituation: function(state, getters) {
			return (function(id_situation) {
				return (state.lst.filter(function(elm) {
					return (elm.id_situation == id_situation);
				})
				.sort(function (a, b) {
					return (b.date_situation - a.date_situation);
				}));
			});
		},
		getImpot: function(state, getters) {
			return (function(idImpot) {
				return (state.impot[idImpot]);
			});
		},
		getImpotFortune: function(state, getters) {
			return (function(idImpotFortune) {
				return (state.impotFortune[idImpotFortune]);
			});
		},
		getSituationFiscaleSelectedIsValid: function(state, getters)
		{
			return (
				typeof state.selected.id_situation != "undefined" &&
				state.selected.id_situation != 0 &&
				state.selected.residence_france.length > 0 &&
				state.selected.haveImpot.length > 0 &&
				state.selected.haveImpotFortune.length > 0 &&
				(
					state.selected.haveImpot == 0 || 
					(
						isNumber(state.selected.id_tranche_impot) &&
						isNumber(state.selected.impot_annee_precedente) &&
						isNumber(state.selected.nbr_parts_fiscales) &&
						state.selected.nbr_parts_fiscales >= 1
					)
				) &&
				(
					state.selected.haveImpotFortune == 0 || isNumber(state.selected.id_tranche_impot_fortune)
				)
			);
		}
	}
});
