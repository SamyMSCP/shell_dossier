</script>
<script type="text-x/template" id="template-order-stats">
	<?php include ("template_order_stats.php"); ?>
</script>
<script>
	Vue.component(
		'orderStats', {
			data: function () {
				return ({
					hist: <?= json_encode($this->orderlist) ?>
				});
			},
			methods: {
			},
			template: "#template-order-stats",
			store: store
		}
	);



	store.registerModule('order_historic', {
		state: {
			hist: <?= json_encode($this->orderlist) ?>
		},
		getters: {
			getVolByDay: function (state, getters) {
				return function (date) {
                    ret = {buy: 0, sell: 0};
					for (var t in state.hist) {
						var el = state.hist[t];
						if (typeof el[date] !== 'undefined')
						{
							ret.buy += el[date].buy;
							ret.sell += el[date].sell;
						}

					}
					return (ret);
				}
			},
			getMaxDate: function (state, getters) {
				return function() {
					var max = moment.unix(state.hist.max);
					return (max);
				}
			},
			getVolumeByDayAndId: function (state, getters) {
				return function (date, id) {
					var all = state.hist;
					ret = {buy: 0, sell: 0};
					try {
						ret.buy = state.hist["scpi_" + id][date].buy;
						ret.sell = state.hist["scpi_" + id][date].sell;
					}
					catch (e) {
						return ({buy: 0, sell: 0});
					}
					return (ret);
				}
			}
		}
	});
</script>
