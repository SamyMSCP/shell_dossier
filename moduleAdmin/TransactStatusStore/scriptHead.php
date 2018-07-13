</script>
<script type="text/x-template" id="list-transact-template" >
<?php include('template/list_transact.php'); ?>
</script>

<script type="text/javascript" charset="utf-8">

	store.registerModule('transactstatestore', {
		state: {
			lstStatusTransaction: <?=json_encode($this->StatusTransaction)?>,
			lstTransaction: [],
//			lstTransacWithSt: <?//= json_encode($this->TransStGroup)?>//,
			lstStListText: <?= json_encode($this->lstStValueText)?>,
			sort: {
				name_alpha: 0,
				part_num: 0,
				vol_num: 0,
				date_num: 0,
				date_enr_num: 0
			},
			volume: {
				parts: 0,
				volume: 0
			},
			token: "<?= $_SESSION['csrf'][0] ?>"
		},
		mutations: {
			sort_alpha(state) {
				var lst = state.lstTransaction;
				var tmp = lst;
				var s = state.sort.name_alpha;

				tmp = tmp.sort(function (a, b) {
					return (a.nom.toLowerCase() > b.nom.toLowerCase()) ? -1 : ((b.nom.toLowerCase() > a.nom.toLowerCase()) ? 1 : 0);
				});
				if (s === 1) {
					tmp = tmp.reverse(tmp);
					s = 2;
				}
				else
					s = 1;
				state.lstTransaction.lst = tmp;
				this.commit('reset_sort');
				state.sort.name_alpha = s;
			},
			sort_part(state) {
				var lst = state.lstTransaction;
				var tmp = lst;
				var s = state.sort.part_num;
				tmp = tmp.sort(function (a, b) {
					return (parseInt(a.nbr_part) > parseInt(b.nbr_part)) ? -1 : ((parseInt(b.nbr_part) > parseInt(a.nbr_part)) ? 1 : 0);
				});
				if (s === 1) {
					tmp = tmp.reverse(tmp);
					s = 2;
				}
				else
					s = 1;
				state.lstTransaction.lst = tmp;

				this.commit('reset_sort');
				state.sort.part_num = s;
			},
			sort_volume(state) {
				var lst = state.lstTransaction;
				var tmp = lst;
				var s = state.sort.vol_num;
				tmp = tmp.sort(function (a, b) {

					return (parseInt(a.nbr_part) * parseInt(a.prix_part) >parseInt(b.nbr_part) * parseInt(b.prix_part)) ? -1 : ((parseInt(b.nbr_part) * parseInt(b.prix_part) > parseInt(a.nbr_part) * parseInt(a.prix_part)) ? 1 : 0);
				});
				if (s === 1) {
					tmp = tmp.reverse(tmp);
					s = 2;
				}
				else
					s = 1;
				state.lstTransaction.lst = tmp;

				this.commit('reset_sort');
				state.sort.vol_num = s;
			},
			sort_date(state) {
				var lst = state.lstTransaction;
				var tmp = lst;
				var s = state.sort.date_num;
				tmp = tmp.sort(function (a, b) {
					return (parseInt(a.date_edit_trans) > parseInt(b.date_edit_trans)) ? -1 : ((parseInt(b.date_edit_trans) > parseInt(a.date_edit_trans)) ? 1 : 0);
				});
				if (s === 1) {
					tmp = tmp.reverse(tmp);
					s = 2;
				}
				else
					s = 1;
				state.lstTransaction.lst = tmp;

				this.commit('reset_sort');
				state.sort.date_num = s;
			},
			sort_date_enr(state) {
				var lst = state.lstTransaction;
				var tmp = lst;
				var s = state.sort.date_enr_num;
				tmp = tmp.sort(function (a, b) {
					return (parseInt(a.enr_date) > parseInt(b.enr_date)) ? -1 : ((parseInt(b.enr_date) > parseInt(a.enr_date)) ? 1 : 0);
				});
				if (s === 1) {
					tmp = tmp.reverse(tmp);
					s = 2;
				}
				else
					s = 1;
				state.lstTransaction.lst = tmp;

				this.commit('reset_sort');
				state.sort.date_enr_num = s;
			},
			reset_sort(state) {
				state.sort.name_alpha = 0;
				state.sort.part_num = 0;
				state.sort.date_num = 0;
				state.sort.date_enr_num = 0;
				state.sort.vol_num = 0;
			},
			CHANGE_LIST_FROM_AJAX: function (state, data) {
				state.lstTransaction = (data.transactions);
				let self = this;
				state.lstTransaction = (data.transactions).filter(function(el) {
					if (el.prenom === "Salaheddine")
						console.warn((el.prenom).toLowerCase() + " " + (el.nom).toLowerCase());
//					console.log((((el.prenom).toLowerCase() + " " + (el.nom).toLowerCase()).indexOf(data.who.toLowerCase())));
					return ((data.socgest === self.getters.getScpi(el.id_scpi).societeDeGestion.name || data.socgest === '') && (((el.prenom).toLowerCase() + " " + (el.nom).toLowerCase()).indexOf(data.who.toLowerCase()) !== -1 || data.who === ""));
				});
//				state.lstTransaction = (state.lstTransaction).filter(function(el) {
////					console.log(((el.prenom).toLowerCase() + " " + (el.nom).toLowerCase()).indexOf(data.who));
//					return (((el.prenom).toLowerCase() + " " + (el.nom).toLowerCase()).indexOf(data.who.toLowerCase()) !== -1 || data.who === "");
//				});
				data.volume.parts = 0;
				data.volume.volume = 0;
				for (var i = 0; i < state.lstTransaction.length ; i++) {
					data.volume.parts += parseInt(state.lstTransaction[i].nbr_part);
					data.volume.volume += parseFloat(state.lstTransaction[i].nbr_part * state.lstTransaction[i].price_part);
				}
				state.volume = data.volume;
//				console.log(data)
			}
		},

		getters: {
			getTransactionFromAll: function (state, getters) {
				return (function (id) {
					var found = false;
					for (var i = 0; i < state.lstTransaction.length && !found; i++) {
						if (state.lstTransaction[i].id === id) {
							found = true;
							break;
						}
					}
					return ((found) ? state.lstTransaction[i] : null);
				});
			},
			getFromStatus: function (state, getters) {
				return (function (status) {
					let tmp = status.split(/-/g);
					let major = parseInt(tmp[0]);
					let minor = parseInt(tmp[1]);

					list = state.lstTransaction.filter(function (el) {
						if (typeof major === "NaN")
							return (true);
						if ((major === parseInt(el.status_sup)) && (minor === 0 || parseInt(el.status_sub)))
							return (true);
						return (false);
					});
					return (list);
				});
			},
			getFromConseiller: function(state, getters) {
				return (function() {
					var cons = [];
					state.lstTransaction.forEach((el) => {
						el.status_sup = parseInt(el.status_sup);
						// console.log("status: ", typeof el.status_sup, el.status_sup);
						is_set = cons.find((c) => {return (c.id === el.conseiller)})
						if (typeof is_set !== "undefined") {
							if (el.status_sup >= 5)
								is_set.volume_complete += el.nbr_part * el.prix_part;
							else
								is_set.volume_incomplete += el.nbr_part * el.prix_part;
						}
						else {
							if (el.status_sup >= 5)
								cons.push({id: el.conseiller, volume_complete: el.nbr_part * el.prix_part, volume_incomplete: 0.0});
							else
								cons.push({id: el.conseiller, volume_complete: 0.0, volume_incomplete: el.nbr_part * el.prix_part});
						}
					});
					return (cons);
				});
			},
			getAllFromConseillers: function(state, getters) {
				return function () {
					var x = getters.getFromConseiller();
					var consel = getters.getConseiller;
					x.forEach((el) => {
						el.conseiller = consel.find((t) => { return (t.id_dh === el.id)});
					});
					return (x);
				}
			},
			calculateTotauxConseillers: function(state, getters) {
				var all = getters.getAllFromConseillers();

				var ret = { waiting: 0, finished: 0 };
				all.forEach((cons) => {
					ret.waiting += cons.volume_incomplete;
					ret.finished += cons.volume_complete;
				});
				return (ret);
			}
		}
	});

	Vue.component(
		'TransactViewerElement',
		{
			template: "#list-transact-template",
			props: ['list', 'socgest', 'date', 'namesearch', 'sort', 'date_selector'],
			data: function () {
				return ({});
			},
			methods: {
				updateTransacChild: function (el) {
					store.commit('', el.id);
				},
				isInInterval: function (el) {
					return (true);
//						let order_mod = (this.date_selector.indexOf("mod") !== -1);
//						let order_enr = (this.date_selector.indexOf("enr") !== -1);
//						let d_start = (parseInt(moment(this.date.start, "DD-MM-YYYY").subtract(1, 'days').format("X")));
//						let d_end = parseInt(moment(this.date.end, "DD-MM-YYYY").add(2, 'days').format("X"));
//						if (!order_mod && !order_enr) {
//							order_enr = true;
//							order_mod = true;
//						}
//						let i = {mod: false, enr: false};
//						if ((d_start < (el.date_edit_trans)) && ((el.date_edit_trans) < d_end))
//							i.mod = true;
//						if ((d_start < (el.enr_date)) && ((el.enr_date) < d_end))
//							i.enr = true;
////						console.log("Checking var: " + moment.unix(el.date_edit_trans).format("DD-MM-YYYY") + " - " + moment.unix(el.enr_date).format("DD-MM-YYYY"), i);
//						if (order_enr && order_mod)
//							return (i.mod || i.enr);
//						if (order_enr)
//							return (i.enr);
//						if (order_mod)
//							return (i.mod);
//						return (false);
				},
				isName: function (el) {
					if (this.namesearch === "")
						return (true);
					try {
						let fname = el.nom.toLowerCase();
						let lname = el.prenom.toLowerCase();
						return (fname.indexOf(this.namesearch.toLowerCase()) > -1 || lname.indexOf(this.namesearch.toLowerCase()) > -1)
					}
					catch (e) {
						return (false);
					}
				},
			},
			computed: {
				getTransactData: function () {
					let l = this.list;
					let count = 0;
					let price = 0;

					for (let i = 0; i < l.length; i++)
					{
						if (this.isInInterval(l[i])) {
							count += parseInt(l[i].nbr_part);
							price += parseFloat(l[i].nbr_part * l[i].prix_part);
						}
					}
					return ({nb_part: count, price: price.toLocaleString("fr", {style: "currency", currency: "EUR"})});
				},
				getParts: function () {
					let parts = 0;
					for (let i = 0; i < this.list.length ; i++)
					{
						parts += parseInt(this.list[i].nbr_part);
					}
					return (parts);
				},
				getVolume: function () {
					let volume = 0;
					for (var i = 0; i < this.list.length ; i++)
					{
						volume += parseInt(this.list[i].nbr_part) * parseFloat(this.list[i].prix_part);
					}
					return (volume).toLocaleString("fr", {style: "currency", currency: "EUR"});
				}
			},
			filters: {
				moment: function (date) {
					return moment.unix(date).format('DD/MM/Y - HH:mm:ss');
				},
				to_now: function (date) {
					return moment.unix(date).locale("fr").fromNow();
				}
			}
		}
	);




