</script>
<script type="text/javascript">
	$(document).ready(function() {
		$(document).on('hidden.bs.modal', '.modal', function () {
		    $('.modal:visible').length && $(document.body).addClass('modal-open');
		});
	});
</script>
<script type="text/javascript" charset="utf-8">