</script>
<script type="text/javascript">
$( document ).ready(function() {
if ($.cookie('agreed_cookie') == undefined)
	$('#cookie_banner').show();

$("#cookie_banner button").click( function(){
	$.cookie('agreed_cookie', 'OK', { expires: 395 });
	$('#cookie_banner').hide();
});
});
