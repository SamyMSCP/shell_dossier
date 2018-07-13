</script>
<script type="text/javascript" charset="utf-8">

	store.registerModule('transactions', {
		state: {
			lstTypeDocument: <?=json_encode($this->RequiredDocumentTransaction)?>,
			lstMarcher: <?=json_encode($this->MarcherTransaction)?>,
			lstStatusTransaction: <?=json_encode($this->StatusTransaction)?>,
			lstTypePro: <?= json_encode($this->ProprieteTransaction) ?>,
			lst: <?=json_encode($this->AllTransaction)?>,
			selectedTransaction: null,
			precalcul: <?= json_encode($this->table)?>,
			selectedProjectTransactions: [],
			token: "<?= $_SESSION['csrf'][0] ?>"
		},
		getters: {
			Token: function(state, getters) {
				return (state.token);
			},
			getSelectedTransaction: function(state, getters) {
				if (state.selectedTransaction == null)
					state.selectedTransaction = state.lst[0];
				return (state.selectedTransaction);
			},
			getTransaction: function(state, getters) {
				return (function(id) {
					return (state.lst.find(function(elm) {
						return (elm.id == id);
					}));
				});
			},
			getTransactionsForDh: function(state, getters) {
				return (function(id_dh) {
					return (state.lst.filter(function(elm) {
						return (elm.id_donneur_ordre == id_dh);
					}));
				});
			},
			getTransactionsForDh_5_6: function(state, getters) {
				return (function(id_dh) {
					return (state.lst.filter(function(elm) {
						return (
							elm.id_donneur_ordre == id_dh &&
							(
								(elm.status_trans == "5-0" ||
								elm.status_trans == "6-0")
								|| !elm.doByMscpi
							)
						);
					}));
				});
			},
			getTransactionForProject: function(state, getters) {
				return (function(id_project) {
					return (state.lst.filter(function(elm) {
						return (elm.id_projet == id_project);
					}));
				});
			},
			getPrecalcul: function(state, getters) {
				return (state.precalcul);
			},
			getTransactionFromOtherStore: function(state, getters) {
				return (function (id) {
					var found = false;
					for (var i = 0; i < state.lst.length && !found; i++) {
						if (state.lst[i].id === id) {
							found = true;
							break;
						}
					}
					return ((found) ? state.lst[i] : null);
				});
			}
		},
		mutations : {
			TRANSACTIONS_UPDATE: function(state, data) {
				//if (typeof data.isModify != "undefined")
				//	data.isModify = false;
				state.selectedProjectTransactions = state.selectedProjectTransactions.map(function(elm) {
					if (elm.id == data.id)
						return (data);
					return (elm);
				});
				state.lst = state.lst.map(function(elm) {
					if (elm.id == data.id)
						return (data);
					return (elm);
				});
			},
			TRANSACTIONS_DELETE: function(state, data) {
				state.selectedProjectTransactions = state.selectedProjectTransactions.filter(function(elm) {
					return (elm.id != data.id && elm.id_transaction_achat != data.id);
				});
				state.lst = state.lst.filter(function(elm) {
					return (elm.id != data.id && elm.id_transaction_achat != data.id);
				});
			},
			TRANSACTIONS_SET_SELECTED_FOR_PROJECT: function (state, data) {
				state.selectedProjectTransactions = data;
			},
			TRANSACTIONS_CREATE: function (state, data) {
				var ins = data;
				//ins.isModify = true;
				state.selectedProjectTransactions.push(ins);
				state.lst.push(data);
			},
			TRANSACTIONS_READ: function (state, data) {
				state.selectedTransaction = data;
				if (state.selectedTransaction !== null)
				{
					if (state.selectedTransaction.date_bs === null)
						state.selectedTransaction.date_bs = 0;
				}
			},
			TRANSACTIONS_RELOAD_PRECALCUL: function (state, data) {
				state.precalcul = data;
			},
			changeSelect(state, data){
				// this.commit('TRANSACTION_UPDATE', data);
				// state.selectedTransaction = JSON.parse(JSON.stringify(this.getters.getTransactionFromOtherStore(data)));
				state.selectedTransaction = this.getters.getTransactionFromOtherStore(data);
				if (state.selectedTransaction !== null)
				{
					if (state.selectedTransaction.date_bs === null)
						state.selectedTransaction.date_bs = 0;
				}
				$("#modal_transactio").modal('show');
			}
		},
		actions: {
			TRANSACTIONS_CREATE: function (context, data) {
				return (new Promise(function(resolve, reject) {
					Vue.http.post('ajax_request.php', {
						req: 'RestTransaction',
						action: 'create',
						data: data,
						token: context.getters.Token
					},
					{emulateJSON: true}).then(
						function (res) {
							context.commit("TRANSACTIONS_CREATE", res.body);
							//context.dispatch("DOCUMENTS_RELOAD");
							context.dispatch("TRANSACTIONS_RELOAD_PRECALCUL");
							context.commit('UPDATE_TOKEN', res.body.token);
							resolve(res.body);
						},
						function (res) {
							if (typeof res.body.err != 'undefined')
								msgBox.show(res.body.err);
							else
								msgBox.show("La transaction n'a pas pu etre crée !");
							context.commit('UPDATE_TOKEN', res.body.token);
							reject();
						}
					)
				}));
			},
			TRANSACTIONS_READ: function(context, data) {
				return (new Promise(function(resolve, reject) {
					Vue.http.post('ajax_request.php', {
						req: 'RestTransaction',
						action: 'read',
						data: data,
						token: context.getters.Token
					},
					{emulateJSON: true}).then(
						function (res) {
							context.commit("TRANSACTIONS_READ", res.body.transaction);
							//context.dispatch("DOCUMENTS_RELOAD");
							context.commit('UPDATE_TOKEN', res.body.token);
							resolve(res.body);
						},
						function (res) {
							if (typeof res.body.err != 'undefined')
								msgBox.show(res.body.err);
							else
								msgBox.show("La transaction n'a pas pu etre crée !");
							context.commit('UPDATE_TOKEN', res.body.token);
							reject();
						}
					);
				}));
			},
			TRANSACTIONS_RELOAD_PRECALCUL: function(context, data) {
				if (typeof context.getters.getDh != 'undefined')
				return (new Promise(function(resolve, reject) {
					Vue.http.post('ajax_request.php', {
							req: 'RestTransaction',
							action: 'reloadPrecalcul',
							data: {id: context.getters.getDh.id },
							token: context.getters.Token
						},
						{emulateJSON: true}
					)
					.then (
						function (res) {
							context.commit("TRANSACTIONS_RELOAD_PRECALCUL", res.body.data);
							context.commit('UPDATE_TOKEN', res.body.token);
							resolve();
						},
						function (res) {
							if (typeof res.body.err != 'undefined')
								msgBox.show(res.body.err);
							else
								msgBox.show("Les données précalculées n'ont pas pu etre mise a jours !");
							context.commit('UPDATE_TOKEN', res.body.token);
							reject();
						}
					);
				}));
			},
			TRANSACTIONS_UPDATE: function(context, data) {
				//if (data.type == "V")
				//	msgBox.show("La modification de transaction de vente n'est pas encore implémentée!");
				var data_ = Object.assign({}, data);
				if (typeof data.docs != 'undefined')
					delete data_.docs;
				// et les benef
				if (typeof data.beneficiaire != 'undefined')
					delete data_.beneficiaire;

				return (new Promise(function(resolve, reject) {
					Vue.http.post('ajax_request.php', {
							req: 'RestTransaction',
							action: 'update_new',
							data: data_,
							token: context.getters.Token
						},
						{emulateJSON: true}
					)
					.then (
						function (res) {
							context.commit("TRANSACTIONS_UPDATE", res.body);
							context.dispatch("TRANSACTIONS_RELOAD_PRECALCUL");
							context.commit('UPDATE_TOKEN', res.body.token);
							resolve();
						},
						function (res) {
							//console.log(typeof res.body.err);
							if (typeof res.body.err != 'undefined')
								msgBox.show(res.body.err);
							else
								msgBox.show("La transaction n'a pas pu etre mise a jours !");
							context.commit('UPDATE_TOKEN', res.body.token);
							reject(res.body);
						}
					);
				}));
			},
			TRANSACTIONS_DELETE: function(context, data) {
				return (new Promise(function(resolve, reject) {
					Vue.http.post('ajax_request.php', {
							req: 'RestTransaction',
							action: 'delete',
							data: data,
							token: context.getters.Token
						},
						{emulateJSON: true}
					)
					.then (
						function (res) {
							context.commit("TRANSACTIONS_DELETE", res.body);
							context.dispatch("TRANSACTIONS_RELOAD_PRECALCUL");
							context.commit('UPDATE_TOKEN', res.body.token);
							resolve();
						},
						function (res) {
							if (typeof res.body.err != 'undefined')
								msgBox.show(res.body.err);
							else
								msgBox.show("La transaction n'a pas pu été supprimée");
							context.commit('UPDATE_TOKEN', res.body.token);
							reject();
						}
					);
				}));
			},
		},
	});
