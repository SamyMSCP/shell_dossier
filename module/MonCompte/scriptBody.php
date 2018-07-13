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

var vueInstance = new Vue({
	el: "#vueCentreInteretApp",
	store: store
});
</script>
<script type="text/javascript" charset="utf-8">

$("#indicanum").css("display", "none");

function lock_img(){
	var cad = document.getElementById("cadenas");
	if (cad.src.indexOf("closed") != -1){
		cad.src = "<?=$this->getPath()?>img/Cadenas-open-BleuClair.svg";
		document.getElementById("tel").removeAttribute("readonly");
		document.getElementById("oldpass").removeAttribute("readonly");
		document.getElementById("pass").removeAttribute("readonly");
		document.getElementById("pass2").removeAttribute("readonly");
<?php if ($this->dh->type !== null): ?>
		document.getElementById("isf_yes").removeAttribute("disabled");
		document.getElementById("isf_no").removeAttribute("disabled");
<?php endif; ?>
		document.getElementById("button2id").style.display = "initial";
		$("#indicanum").css("display", "inherit");
	}
	else{
		cad.src = "<?=$this->getPath()?>img/Cadenas-closed-BleuClair.svg";
		document.getElementById("tel").setAttribute("readonly", "1");
		document.getElementById("oldpass").setAttribute("readonly", "1");
		document.getElementById("pass").setAttribute("readonly", "1");
		document.getElementById("pass2").setAttribute("readonly", "1");
<?php if ($this->dh->type !== null): ?>
		document.getElementById("isf_yes").setAttribute("disabled", "disabled");
		document.getElementById("isf_no").setAttribute("disabled", "disabled");
<?php endif; ?>
		document.getElementById("button2id").style.display = "none";
		$("#indicanum").css("display", "none");
	}
}
</script>
<script type="text/javascript">

    $(window).load(function(){
        $('#modal_push_tel').modal('show');
        $('.modal_push_tel').modal('show'); // isf
        $('.modal_push_info').modal('show');
        setTimeout(function(){
        	$('.modal_push_info').modal('hide');
        }, 10000);
    });
    var $xpass = 0;
    $("#pass").keyup(function (){
    	if ($('.success_1').css("display") != "none"){
    		$("#button2id").css("display", "initial");
    	}
    	else{
    		$("#button2id").css("display", "none");
    	}
    });
</script>
<script type="text/javascript" charset="utf-8">

	function checkNewMdp() {
		var rt = true;
	
		if(
			$('#passwordinput').val().length < 8 ||
			!$('#passwordinput').val().match(/([a-z])/g) ||
			!$('#passwordinput').val().match(/([A-Z])/g) ||
			!$('#passwordinput').val().match(/[0-9]/g)
		)
		{
			$('#passwordinput').addClass('notValid');
			rt = false;
		}
		else
			$('#passwordinput').removeClass('notValid');
	
		if(
			!rt ||
			$('#passwordinput').val() != $('#pass2').val()
		)
		{
			$('#pass2').addClass('notValid');
			rt = false;
		}
		else
			$('#pass2').removeClass('notValid');
		if (rt)
			$('.btn-change-pass').show();
		else
			$('.btn-change-pass').hide();
		return (rt);
	}
	$('#modalSetMdp input').on("keyup", checkNewMdp);
	
	$('#modalSetMdp input').on("keyup", function() { $('.instructionMdp').show(); });
		
	//checkNewMdp();
</script>