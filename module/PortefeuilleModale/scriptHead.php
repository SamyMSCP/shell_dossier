</script>
<script type = "text/x-template" id="multi_action_template">
	<?php require_once("template/multi_action_modale_template.php"); ?>
</script>

<script type="text/javascript">
	/** Modale Multi Action
	 * <multi-action-modale></multi-action-modale>
	 * Ce component, permet de creer la modale coter portefeuille avec 4 actions
	 * - Investir dans une SCPI ou reinvestir
	 * - Ajouter une SCPI que je detiens Deja
	 * - Vendre des SCPI
	 * - Modifier mon portefeuille (Suppression)
	 */
	Vue.component("multiActionModale", {
		template: "#multi_action_template",
		data: function () {
			return {
				list_select: 0
			}
		},
		methods: {
			openAdd: function() {
				/**
				 * Hot Fix pour le scroll
				 */
				$(".modal").modal('hide');
				$("#add_scpi").modal('show');
				setTimeout(() => {
						$('body').addClass("modal-open");
					}, 370);
			},
			openEdit: function() {
				this.list_select = 0;
				$(".modal").modal('hide');
				$("#modale_list_transact").modal('show');
				setTimeout(() => {
					$('body').addClass("modal-open");
				}, 370);
			},
			openVente: function() {
				this.list_select = 1;
				$(".modal").modal('hide');
				$("#modale_vente").modal('show');
				// $("#modale_list_transact").modal('show');
				setTimeout(() => {
					$('body').addClass("modal-open");
				}, 370);
			},
			openReinvest: function() {
				this.list_select = 2;
				$(".modal").modal('hide');
				$("#modal_reinvest").modal('show');
				setTimeout(() => {
					$('body').addClass("modal-open");
				}, 370);
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