	
</script>
<script type="text/javascript" charset="utf-8">

$('#selectLog').on('change', function() {
	window.location = '?p=SeeLogs&idlog=' + $('#selectLog').val();
	//console.log($('#selectLog').val())
})
