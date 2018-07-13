var t = 0;
function ft_notif_stop($val){
	t = t + $val;
	console.log(t);
	if (t == 2)
	{
		$.ajax({
       		url : 'index.php?p=<?php echo $GLOBALS['GET']["p"];?>',
       		type : 'GET',
       		data : 'notiftime=' + <?php echo (strtotime("now") + (7 * 24 * 60 * 60));?>
    	});
	}
}
<?php
if (isset($GLOBALS['GET']['mod'])) {
?>
	window.addEventListener('load', function () {

		$(".<?=$GLOBALS['GET']['mod']?>").modal('show');
	});
<?php
}
?>
</script>
<script type="text/javascript" charset="utf-8">

function updateKey()
{
	vm_op_v.search_key = $("#adjustRatio").slider("value");
	vm_op_v.search_key_usu = 100 - $("#adjustRatio").slider("value");
}

$(function (){
	$("#adjustRatio").slider({
		orientation: "horizontal",
		range: "min",
		max: 100,
		value: 50,
		step: 5,
		slide: updateKey,
		change: updateKey,
	});
});
