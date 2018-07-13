</script>
<script type="text/x-template" id="portefeuille_reinvest_tpl">
	<?php require_once ('template/modale_reinvest.php') ?>
</script>
<script>
	Vue.component('modalReinvestScpi', {
		template: "#portefeuille_reinvest_tpl",
		methods: {
			addPart: function () {
				// this.
			},
			demandeContact: function (){
				var msg = "contact achat";
				$.ajax({
				url: "ajax_request_client.php",
				method: "POST",
				data: {
					"token": "<?=$_SESSION['csrf'][0]?>",
					"req": "AjaxContact",
					"data": { 'demande':msg,
						'id': 0
					},
					"dataType": "json"
				}
			}).done(function(res) {
				if (typeof res.response !== "undefined")
					swal({
						title: res.response,
						type: "info"
					});
				else
					swal({
						title: "Votre conseiller prendra contact avec vous prochainement.",
						type: "info"
					});
			}).fail(function(res) {
				swal({
					type: "error",
					title: "Une erreur s'est produite",
					text: "la demande de contact n'a pas pu aboutir. Veuillez nous en excuser."
				});
			});
			}
		}
	});