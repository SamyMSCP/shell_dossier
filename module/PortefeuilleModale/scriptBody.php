</script>
<script type="text/javascript">
	$("#add_scpi").on("shown.bs.modal", function () {
		$("body").addClass("modal-open");
	});
	$("#add_scpi").on("hidden.bs.modal", () => {
		$("body").removeClass("modal-open");
	});