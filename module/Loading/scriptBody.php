</script>
<script type="text/javascript" charset="utf-8">

	function showLoading() {
		$('#loading').css('display', '-webkit-flex');
		$('#loading').css('display', '-ms-flexbox;');
		$('#loading').css('display', 'flex');
	}


	$('form').on('submit', function() {
		showLoading();
	});
