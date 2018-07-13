</script>
<script type = "text/x-template" id="modal-list-transac-template">
<?php require_once("template/modale_list_transac.php"); ?>
</script>

<script type="text/javascript">

	Vue.component("modaleListTransaction", {
		template: "#modal-list-transac-template",
		props: {
			listSelect: {
				default: 0,
				type: Number
			},
			action: {
				default: 0,
				type: Number
			}
		},
		data: function () {
			return {
			}
		},
		methods: {
		},
		computed: {
			getUsuList: function () {
				return $store.state.transactions.transactionsList.filter((el) => {
					return (el.type_pro === "Usufruit")
				});
			},
			getNueList: function () {
				return $store.state.transactions.transactionsList.filter((el) => {
					return (el.type_pro === "Nue propriété")
				});
			},
			getPleineList: function () {
				return $store.state.transactions.transactionsList.filter((el) => {
					return (el.type_pro === "Pleine propriété")
				});
			},
			getTitle: function () {
				switch  (this.listSelect){
					case 0:
						return "modifier ou supprimer une SCPI";
					case 1:
						return "Vendre des parts de SCPI";
					case 2:
						return "Investir dans une SCPI ou reinvestir"
				}
			}
		},
		filters: {
			money: function (data) {
				return parseFloat(data).toLocaleString("fr", {style: "currency", currency: "EUR"})
			},
			percent: function (data) {
				return parseFloat(data).toLocaleString("fr", {style: "percent", minimumFractionDigits: 1});
			}
		}}
	);