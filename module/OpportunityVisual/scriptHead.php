
</script>
<script type="text/x-template" id="moduleOpportunity">
	<?php require_once ('template/opportunity.php') ?>
</script>
<script>

	Vue.component("moduleOpportunity",
	{
		props: ['id', 'type', 'scpi', 'date', 'duree', 'keyNue', 'tot', 'parts', 'price-part', 'price-part-sec', 'partiel', 'state', 'color-state', 'is-ending'],
		template: '#moduleOpportunity',
		data: function (){
			return ({
				token: "<?=$_SESSION['csrf'][0]?>"
			})
		},
		methods: {
			sendInterest: function () {
				console.log(this.id);
				var self = this;
				Vue.http.post('ajax_request_client.php',{
					req: "OpportunitySet",
					action: "interrest",
					data: {
						id: self.id
					},
					token: self.token
				},
			{emulateJSON: true})
			.then(
				function (res){
					//OK
					msgBox.show("Votre conseiller a été informé de votre intérêt pour cette opportunite et vous recontactera dans les plus brefs delais.");
				},
				function (res) {
					//failure
					self.token = res.body.token;
					msgBox.show("Une erreur s'est produite. Essayer de rafraichir la page et de réessayer");
				});
			}
		}
	});
