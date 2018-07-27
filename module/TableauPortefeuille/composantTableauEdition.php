</script>
<script type="text/x-template" id="tableau-transaction-edit">
	<?php require_once("composantTableauEditionTemplate.php"); ?>
</script>
<script type="text/javascript">
	Vue.component('tableau-transaction-edit',
		{
			data : function(){
				return {
					debug:false,
					plusdetaille:false
				}
			},
			computed: {
				selectedTransaction: function() {
					return (this.$store.getters.getSelectedTransaction);
				},


				getError: function() {
					return (this.$store.getters.getTransactionError);
				},
				isSell: function() {
					return (this.selectedTransaction.type_transaction == "V");
				}
			},
			methods: {
				toogleDebug: function() {
					this.debug = !this.debug;
				},
				close: function() {
					$('#tableau-transaction-edit-modal').modal('hide')
				},
				save: function() {
					this.$store.dispatch("SAVE_TRANSACTION", this.selectedTransaction).then(
						function(data) {
                            msgBox.show("La transaction a été enregistrée");
							$('#tableau-transaction-edit-modal').modal('hide');
						},
						function(data) {
							if (typeof data.err.notif != 'undefined' && data.err.notif.length >= 1)
							for (var key in data.err.notif) {
								msgBox.show(data.err.notif[key]);
							}
						},
					);
				},
				delTr: function()
				{
					this.$store.dispatch("DELETE_TRANSACTION", this.selectedTransaction);
					$('#tableau-transaction-edit-modal').modal('hide');
				},
				showModifier: function() {
					switchModal('#tableau-transaction-edit-modal', '#tableau-transaction-modifier-modal');
				},
				showDetaille: function () {
				   this.plusdetaille = !this.plusdetaille;
				}
			},
			template: "#tableau-transaction-edit"
		});
