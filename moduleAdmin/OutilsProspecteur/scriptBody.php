</script>
<script type="text/javascript" charset="utf-8">

	function toggleKo() {
		msgBox.show("Souhaitez-vous vraiment changer le statut Ko pour ce donneur d'ordre ?", [
			{
				text: "oui",
				action: function() {
					$("#formToggleKo").submit();
				}
			},
			{
				text: "non",
				action: function() {
				}
			}
		]);
	}
