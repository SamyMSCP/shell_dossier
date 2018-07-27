</script>
<script type="text/javascript" charset="utf-8">

store.registerModule('transactions', {
	state: {
		selectedTransaction: null,
		statusList: <?= json_encode($this->StatusTransaction) ?>,
		proprieteList: <?= json_encode($this->proprieteTransaction) ?>,
		marcheList: <?= json_encode($this->marcherTransaction) ?>,
		transactionsList: <?= json_encode($this->Transactions) ?>,
		transactionSell: {nbr_part_sell: 0, sell_scpi: 0, date_sell: '', prix_part_sell: 0},
		token: "<?= $_SESSION['csrf'][0]?>"
	},
	getters: {
		getMissingInfo: function(state, getters) {
			return (state.transactionsList.filter((el) => {return el.flagMissingInfo}))
		},
		getToken: function(state, getters) {
			return (state.token);
		},
		getTransactionsSCPIType: function(state, getters) {
			return (function(scpi, type_pro)
			{
				return (state.transactionsList.filter(function(elm) {
					if (elm.scpi == scpi && elm.type_pro == type_pro)
						return (true);
				}))
			})
		},
		getTransactionsSCPITypeNotCompleted: function(state, getters) {
			return (function(scpi, type_pro)
			{
				return (state.transactionsList.filter(function(elm){
					if (elm.scpi == scpi && elm.type_pro.toLowerCase().substr(0,1) == type_pro.toLowerCase().substr(0,1))
					{
						if (elm.doByMscpi && elm.status_trans_done != true)
							return true;
					}
				}))
			})
		},
		getTransactionsSCPITypeCompleted: function(state, getters) {
			return (function(scpi, type_pro)
			{
				return (state.transactionsList.filter(function(elm){
					if (elm.scpi == scpi && elm.type_pro.toLowerCase().substr(0,1) == type_pro.toLowerCase().substr(0,1))
					{
						if (!elm.doByMscpi || elm.status_trans_done == true)
							return true;
					}
				}))
			})
		},
		getStatusTitle: function(state, getters) {
			return (function(status)
			{
				if (status == "")
					return "";
				var statu_sup = status.substr(0,1);
				var statu_sub = status.substr(2,1);
				return state.statusList[statu_sup][statu_sub].title;
			})
		},
	},
	mutations : {
		CHANGE_SELECTED: function (state, data) {
			var tr = state.transactionsList.find((el) => { return parseInt(el.id) === data})
			$(".modal").modal('hide');
			setTimeout(() => {
				$("#modal_transactio").modal('show');
				setTimeout(() => {
					$('body').addClass("modal-open");
				}, 370);

			}, 370);
			state.selectedTransaction = tr;
		},
		TRANSACTIONS_READ: function(state, data) {
			if (data != null && typeof data.transaction != 'undefined')
				state.selectedTransaction = data.transaction;
		},
		UPDATE_TOKEN: function (state, token) {
			state.token = token;
		},
		TRANSACTIONS_ADD_DOCUMENT: function(state, data) {
			if (state.selectedTransaction != null)
				state.selectedTransaction.docs[data[0].id_type_document].push(data[0]);
		},
		TRANSACTIONS_READ_ALL: function(state, data) {
			if (data != null && typeof data.transactions != 'undefined')
				state.transactionsList = data.transactions;
		}
	},
	actions : {
		TRANSACTIONS_SELL: function(context, data) {
			return (new Promise(function(resolve, reject)
				{
					Vue.http.post('ajax_request_client.php', {
							req: 'RestTransaction',
							action: 'sell',
							data: data,
							token: context.getters.getToken
						},
						{emulateJSON: true}
					)
					.then (
						function(res) {
							context.dispatch('TRANSACTIONS_READ_ALL', {'data': "dataaaaaa"});
							context.dispatch('DH_RELOAD_PRECALCUL', {'data': "dataaaaaa"});
							resolve(res);
						},
						function(res){
							reject(res);
						}
					)
				}
			));
		},
		TRANSACTIONS_DELETE: function(context, data) {
			return (new Promise(function(resolve, reject)
				{
					Vue.http.post('ajax_request_client.php', {
							req: 'RestTransaction',
							action: 'delete',
							data: data,
							token: context.getters.getToken
						},
						{emulateJSON: true}
					)
					.then (
						function(res) {
							context.dispatch('TRANSACTIONS_READ_ALL', {'data': "dataaaaaa"});
							context.dispatch('DH_RELOAD_PRECALCUL', {'data': "dataaaaaa"});
							resolve(res);
						},
						function(res){
							reject(res);
						}
					)
				}
			));
		},
		TRANSACTIONS_READ: function(context, data) {
			return (new Promise(function(resolve, reject)
				{
					Vue.http.post('ajax_request_client.php', {
							req: 'RestTransaction',
							action: 'read',
							data: data,
							token: context.getters.getToken
						},
						{emulateJSON: true}
					)
					.then (
						function (res) {
							context.commit("TRANSACTIONS_READ", res.body);
							context.commit('UPDATE_TOKEN', res.body.token);
							resolve(res);
						},
						function (res) {
							if (typeof res.body.err != 'undefined')
								msgBox.show(res.body.err);
							else
								msgBox.show("Impossible de récupérer les informations");
							context.commit('UPDATE_TOKEN', res.body.token);
							reject(res);
						}
					)
				}
			));
		},
		TRANSACTIONS_READ_ALL: function(context, data) {
			return (new Promise(function(resolve, reject)
				{
					Vue.http.post('ajax_request_client.php', {
							req: 'RestTransaction',
							action: 'read_all',
							data: data,
							token: context.getters.getToken
						},
						{emulateJSON: true}
					)
					.then (
						function (res) {
							context.commit("TRANSACTIONS_READ_ALL", res.body);
							context.commit('UPDATE_TOKEN', res.body.token);
							resolve(res);
						},
						function (res) {
							if (typeof res.body.err != 'undefined')
								msgBox.show(res.body.err);
							else
								msgBox.show("Impossible de récupérer les informations");
							context.commit('UPDATE_TOKEN', res.body.token);
							reject(res);
						}
					)
				}
			));
		},
		TRANSACTIONS_CREATE: function(context, data) {
			console.log(data);
			return (new Promise(function(resolve, reject)
			{
				Vue.http.post('ajax_request_client.php', {
						req: 'RestTransaction',
						action: 'add',
						data: data,
						token: context.getters.getToken
					},
					{emulateJSON: true}
				)
				.then (
					function(res) {
						//context.commit("TRANSACTIONS_READ", res.body);
						context.commit("UPDATE_TOKEN", res.body.token);
						resolve(res);
					},
					function(res) {
						/*
						if (typeof res.body.err != 'undefined')
							msgBox.show(res.body.err);
						else
							msgBox.show("Impossible d'enregistrer les changements");
						*/
						context.commit('UPDATE_TOKEN', res.body.token);
						reject(res);
					}
				)
			}));
		},
		TRANSACTIONS_UPDATE: function(context, data) {
			return (new Promise(function(resolve, reject)
			{
				Vue.http.post('ajax_request_client.php', {
						req: 'RestTransaction',
						action: 'update',
						data: data,
						token: context.getters.getToken
					},
					{emulateJSON: true}
				)
				.then (
					function (res) {
						context.commit("TRANSACTIONS_READ", res.body);
						context.commit('UPDATE_TOKEN', res.body.token);
						context.dispatch('TRANSACTIONS_READ_ALL', {'data': "dataaaaaa"});
						context.dispatch('DH_RELOAD_PRECALCUL', {'data': "dataaaaaa"});
						resolve(res);
					},
					function (res) {
						if (typeof res.body.err != 'undefined')
							msgBox.show(res.body.err);
						else
							msgBox.show("Impossible d'enregistrer les changements");
						context.commit('UPDATE_TOKEN', res.body.token);
						reject(res);
					}
				)
			}));
		},
		TRANSACTIONS_GET_DOCUMENTS: function(context, data)
		{
			return (new Promise(function(resolve, reject)
			{
				Vue.http.post('ajax_request_client.php', {
						req: 'RestTransaction',
						action: 'read_doc',
						data: data,
						token: context.getters.getToken
					},
					{emulateJSON: true}
				)
				.then (
					function(res) {
						context.commit('UPDATE_TOKEN', res.body.token);
						resolve(res);	
					},
					function(res) {
						if (typeof res.body.err != 'undefined')
							msgBox.show(res.body.err);
						else
							msgBox.show("Impossible d'obtenir le document");
						context.commit('UPDATE_TOKEN', res.body.token);
						reject(res);
					}
				)
			}))
		},
		TRANSACTIONS_ADD_DOCUMENT: function(context, FD)
		{
			FD.append('req', 'RestTransaction');
			FD.append('action', 'add_doc');
			FD.append('token', context.getters.Token);
			return (new Promise(function(resolve,reject)
			{
				Vue.http.post('ajax_request_client.php', FD)
				.then (
					function(res) {
						if (typeof res.body.doc != 'undefined')
							context.commit('TRANSACTIONS_ADD_DOCUMENT', res.body.doc)
						context.commit('UPDATE_TOKEN', res.body.token);
						resolve(res);
					},
					function(res) {
						if (typeof res.body.err != 'undefined')
							msgBox.show(res.body.err);
						else
							msgBox.show("Impossible d'enregistrer le document");
						context.commit('UPDATE_TOKEN', res.body.token);
						reject(res);
					}
				)
			}));
		}
	}
});
