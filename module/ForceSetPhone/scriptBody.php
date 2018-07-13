</script>
<script type="text/javascript" charset="utf-8">
	$('#phoneRenseignement').modal('show');

<?php
if (
	$_SESSION['setPhoneStep'] == 1 ||
	$_SESSION['setPhoneStep'] == 4
)
{
	?>
	function forCheckFormValide() {
		var rt = true;

		if (!$('#num').val().match(/^[0-9 +-]{10,}$/))
		{
			$('#num').addClass('notValid');
			rt = false;
		}
		else
			$('#num').removeClass('notValid');
		return (rt);
	}

	function checkFormValide() {
		//activeScroll = false;
		if (forCheckFormValide())
		{
			$('#sendForm').show();
			// affiche le bouton;
		}
		else
		{
			$('#sendForm').hide();
			// on masque le bouton;
		}
	}
	$('#phoneRenseignement input').on("keyup", checkFormValide);

	checkFormValide();
	<?php
}
else if (
	$_SESSION['setPhoneStep'] == 2 ||
	$_SESSION['setPhoneStep'] == 5
)
{
	?>
	function forCheckFormValide2() {
		var rt = true;
		if (
			$('#code').val().length != 6 ||
			Number($('#code').val()) < 100000
		)
		{
			$('#code').addClass('notValid');
			rt = false;
		}
		else
			$('#code').removeClass('notValid');
		return (rt);
	}

	function checkFormValide2() {
		//activeScroll = false;
		if (forCheckFormValide2())
		{
			$('#sendForm').show();
			// affiche le bouton;
		}
		else
		{
			$('#sendForm').hide();
			// on masque le bouton;
		}
	}
	$('#phoneRenseignement input').on("keyup", checkFormValide2);

	checkFormValide2();
	function resetPhone() {
		console.log("reset");

	var f = document.createElement("form");
	f.setAttribute('method', "post");
	f.setAttribute('action', "?p=<?=$GLOBALS['GET']['p']?>");
	
	var i = document.createElement("input"); //input element, text
	i.setAttribute('type', "hidden");
	i.setAttribute('name', "action");
	i.setAttribute('value', "resetPhone");
	
	var s = document.createElement("input"); //input element, Submit button
	s.setAttribute('type',"hidden");
	s.setAttribute('name',"token");
	s.setAttribute('value',"<?=$_SESSION['csrf'][0]?>");
	
	f.appendChild(i);
	f.appendChild(s);
	
	//and some more input elements here
	//and dont forget to add a submit button
	
	document.getElementsByTagName('body')[0].appendChild(f);
	f.submit();
	}
	<?php
}
?>

	function sendForm(e) {
		$('#formSetPhone').submit();
	}
