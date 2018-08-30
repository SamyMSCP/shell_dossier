</script>
<script type="text/javascript" charset="utf-8">


var tmpNewTransaction = {
	id: 0,
	id_scpi: null,
	scpi: null,
	id_beneficiaire: null,
	id_cons: null,
	fait_par_mscpi: false,
	marche: null,
	type_pro: null,
	cle_repartition: null,
	demembrement: null,
	nbr_part: null,
	doByMscpi: 0,
	prix_part: null,
	enr_date: null,
	MontantInvestissement: null,
	societe: null,
	info_trans: null,
	montant_emprunt: null,
	type_emprunt: null,
	duree_emprunt: null,
	date_debut_emprunt: null,
	taux_emprunt: null,
	mensualite_emprunt: null
};

store.registerModule('transactions', {
	state: {
		selectedTransactionIntermediaire: null,
		selectedTransaction: JSON.parse(JSON.stringify(tmpNewTransaction)),
		statusList: <?= json_encode($this->StatusTransaction) ?>,
		proprieteList: <?= json_encode($this->proprieteTransaction) ?>,
		marcheList: <?= json_encode($this->marcherTransaction) ?>,
		lst: <?= json_encode($this->Transactions) ?>,
		error: { },
		token: "<?= $_SESSION['csrf'][0]?>"
	},
	getters: {
		getSelectedTransactionIntermediaire: function(state, getters) {
			return (state.selectedTransactionIntermediaire);
		},
		getSelectedTransaction: function(state, getters) {
			return (state.selectedTransaction);
		},
		getToken: function(state, getters) {
			return (state.token);
		},
		getTransactionError: function(state, getters) {
			return (state.error);
		},
		getAllTransactions: function(state, getters) {
			return (state.lst);
		},
		getTransactionPotentielles: function(state, getters) {
			return (state.lst.filter(function(elm) {
				return (elm.doByMscpi && elm.status_trans[0] != 5 && elm.status_trans[2] != 6)
			}));
		},
		getTransactionPotentiellesPleine: function(state, getters) {
			return (getters.getTransactionPotentielles.filter(function(elm) {
				return(elm.type_pro == "Pleine propriété");
			}));
		},
		getTransactionPotentiellesNue: function(state, getters) {
			return (getters.getTransactionPotentielles.filter(function(elm) {
				return(elm.type_pro == "Nue propriété");
			}));
		},
		getTransactionPotentiellesUsu: function(state, getters) {
			return (getters.getTransactionPotentielles.filter(function(elm) {
				return(elm.type_pro == "Usufruit");
			}));
		},
		getTransactionPleine: function(state, getters) {
			return (getters.getAllTransactions.filter(function(elm) {
				return(elm.type_pro == "Pleine propriété");
			}));
		},
		getTransactionNue: function(state, getters) {
			return (getters.getAllTransactions.filter(function(elm) {
				return(elm.type_pro == "Nue propriété");
			}));
		},
		getTransactionUsu: function(state, getters) {
			return (getters.getAllTransactions.filter(function(elm) {
				return(elm.type_pro == "Usufruit");
			}));
		},
		getTransaction5_6: function(state, getters) {
			return (state.lst.filter(function(elm) {
				return (!elm.doByMscpi || (elm.status_trans[0] == 5 || elm.status_trans[2] == 6))
			}));
		},
		getTransactionById: function(state, getters) {
			return (function(id) {
				return (state.lst.find(function(elm) {
					return (elm.id == id);
				}));
			})
		},
	},
	mutations : {
		INSERT_TRANSACTION: function(state, data) {
			state.lst.push(data);
		},
		UPDATE_TRANSACTION: function(state, data) {
			state.lst = state.lst.map(function(elm) {
				if (elm.id == data.id)
					return (data);
				return (elm);
			});
		},
		UPDATE_SELECTED_TRANSACTION: function(state, payload) {
			state.selectedTransaction = JSON.parse(JSON.stringify(payload));
			return (true);
		}
	},
	actions : {
		SAVE_SELECTED_TRANSACTION: function(context, payload) {
			return (context.dispatch("SAVE_TRANSACTION", context.state.selectedTransaction));
		},
		SAVE_TRANSACTION: function(context, payload) {
			return (new Promise(function(resolve, reject) {
				Vue.http.post('ajax_request_client.php',
				{
					req: 'TransactionFrontStore',
					action: 'save_transaction',
					data: payload,
					token: "<?=$_SESSION['csrf'][0]?>"
				},
				{emulateJSON: true})
				.then(
					function (res) {
						if (typeof res.body.datas != 'undefined') {
							if (payload.id == 0) {
								context.commit("INSERT_TRANSACTION", res.body.datas);
								context.commit("UPDATE_SELECTED_TRANSACTION", res.body.datas);
								context.dispatch("DH_RELOAD_PRECALCUL");
							} else {
								context.commit("UPDATE_TRANSACTION", res.body.datas);
								context.commit("UPDATE_SELECTED_TRANSACTION", res.body.datas);
								context.dispatch("DH_RELOAD_PRECALCUL");
							}
						}
						context.state.error = {};
						resolve(res.body);
					},
					function (res) {
						if( typeof res.body.err.datas == "object") {
							context.state.error = res.body.err.datas;

						}
						reject(res.body);
					}
				)
			}))
			return (true);
		},
		DELETE_TRANSACTION: function(context, payload) {
			return (new Promise(function(resolve, reject) {
				Vue.http.post('ajax_request_client.php',
					{
						req: 'TransactionFrontStore',
						action: 'delete_transaction',
						data: payload,
						token: "<?=$_SESSION['csrf'][0]?>"
					},
					{emulateJSON: true})
					.then(
						function (res) {
							if (typeof res.body != 'undefined') {
								if (payload.id == 0) {

									context.dispatch("DH_RELOAD_PRECALCUL");
								} else {

									context.dispatch("DH_RELOAD_PRECALCUL");
								}
							}
							context.state.error = {};
							resolve(res.body);
						},
						function (res) {
							if( typeof res.body.err.datas == "object") {
								context.state.error = res.body.err.datas;
							}
							reject(res.body);
						}
					)
			}))
			return (true);
		},

		SET_NEW_SELECTED_TRANSACTION: function(context, payload) {
			context.state.selectedTransaction = JSON.parse(JSON.stringify(tmpNewTransaction));
			context.state.error = {};
			return (true);
		},
		SET_SELECTED_TRANSACTION: function(context, payload) {
			var tmp = context.getters.getTransactionById(payload);
			if (typeof tmp == 'undefined') {
				return (false);
			}
			context.state.selectedTransaction = JSON.parse(JSON.stringify(tmp));
			context.state.error = {};
			return (true);
		},

		CONTACT_CONSEILLER_REINVEST: function (context, payload) {
			return (new Promise(function(resolve, reject) {
				Vue.http.post('ajax_request_client.php',
					{
						req: 'AjaxContact',
						action: 'reinvest_transaction',
						data: { 'demande':"contact achat",
							'id': 0
						},
						token: "<?=$_SESSION['csrf'][0]?>"
					},
					{emulateJSON: true})
					.then(
						function(res) {
							resolve(res.body)
						},
						function(res) {
						   reject(res.body)
						}
					)
			}))
			return (true);
		},
		CONTACT_CONSEILLER_VENTE: function (context, payload) {
			return (new Promise(function(resolve, reject) {
				Vue.http.post('ajax_request_client.php',
					{
						req: 'AjaxContact',
						action: 'reinvest_transaction',
						data: { 'demande':"contact vente",
							'id': 0
						},
						token: "<?=$_SESSION['csrf'][0]?>"
					},
					{emulateJSON: true})
					.then(
						function(res) {
							resolve(res.body)
						},
						function(res) {
							reject(res.body)
						}
					)
			}))
			return (true);
		}
	}
});
