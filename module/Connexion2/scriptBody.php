</script>
<script type="text/javascript">
$( window ).load(function() {
	$("#connectme_a").click(function(ev){
		toggleFooter(1,1);
		ev.preventDefault();
		$('#forgottenpwd').fadeToggle("fast", function(){
			$('#forgottenpwd .connex_error').fadeOut();
			$('#connectme').fadeToggle("fast");
		});
	});
	$(".forgottenpwd__a").click(function(ev){
		ev.preventDefault();
		toggleFooter(0,1);
		$('#connectme').fadeToggle("fast", function(){
			$('#connectme .connex_error').fadeOut();
			$('#forgottenpwd').fadeToggle("fast");
		});
	});
	$("#verifycode_a").click(function(ev){
		ev.preventDefault();
		$("#verifycode form").append('<input type="hidden" name="renew" value="1" />');
		$("#verifycode form").submit();
	})
	$("#cancel_changepwd_a").click(function(ev){
		ev.preventDefault();
		toggleFooter(1,1);
		$('#changepwd').fadeToggle("fast", function(){
			$('#changepwd .connex_error').fadeOut();
			$('#connectme').fadeToggle("fast");
		});
	});
	$("#cancel_verifycode_a").click(function(ev){
		ev.preventDefault();
		toggleFooter(0,1);
		$('#verifycode').fadeToggle("fast", function(){
			$('#verifycode .connex_error').fadeOut();
			$('#connectme').fadeToggle("fast");
		});
	});
	function pwdIsValid( elt )
	{
		if (elt.value != "")
		{
			if (elt.validity.patternMismatch)
			{
				elt.style.borderColor = "#EF6228";
				elt.setCustomValidity("Le mot de passe doit comporter 8 à 42 caractères, une majuscule, une minuscule et un chiffre.");
			}
			else
			{
				elt.style.borderColor = "#20BF55";
				elt.setCustomValidity("");
			}
		}
		else
			elt.style.borderColor = "#CCC";
	}
	function toggleFooter( visible, fade)
	{
		if (!visible)
		{
			if (fade)
				$('.connex_footer').fadeOut();
			else
				$('.connex_footer').hide();
			$('.connex_body').css('border-bottom-left-radius','3px');
			$('.connex_body').css('border-bottom-right-radius','3px');
		}
		else
		{
			if (fade)
				$('.connex_footer').fadeIn();
			else
				$('.connex_footer').hide();
			$('.connex_body').css('border-bottom-left-radius','0');
			$('.connex_body').css('border-bottom-right-radius','0');
		}
	}
	$('#form_changepwd').on('submit', function(ev){
		if (!$('#newpwd')[0].checkValidity() || !$('#confirmnewpwd')[0].checkValidity())
			return false;
		if ($('#newpwd').val() !== $('#confirmnewpwd').val())
		{
			$('#confirmnewpwd')[0].setCustomValidity('Les mots de passe doivent être identiques.');
			$('#newpwd')[0].setCustomValidity('Les mots de passe doivent être identiques.');
			$('#newpwd').css('border-color','#EF6228');
			$('#confirmnewpwd').css('border-color','#EF6228');
			return false;
		}
		else
		{
			$('#confirmnewpwd')[0].setCustomValidity("");
			$('#newpwd')[0].setCustomValidity("");
			$('#newpwd').css('border-color: #20BF55');
			$('#confirmnewpwd').css('border-color: #20BF55');
		}
	});
	$('#login_lostpwd').on('change', function()	{
		if (this.value != "")
			this.style.borderColor = (!this.checkValidity()) ? "#EF6228" : "#20BF55";
		else
			this.style.borderColor = "#CCC";
	});
	<?php if ($this->code) : ?>
		$('#verifycode').show();
		$('#code').on('change', function() {
			if (this.value != "")
				this.style.borderColor = (!this.checkValidity()) ? "#EF6228" : "#20BF55";
			else
				this.style.borderColor = "#CCC";
		});
	<?php elseif (isset($this->reset) || isset($this->err['changepwd'])) : ?>
		$('#changepwd').show();
		toggleFooter(0,0);
		$('#newpwd').on('input', function() { pwdIsValid(this) });
		$('#confirmnewpwd').on('input', function()	{ pwdIsValid(this) });
	<?php elseif (isset($this->err["forgottenpwd"])) : ?>
		$('#forgottenpwd').show();
	<?php else : ?>
		$('#connectme').show();
	<?php	if (isset($this->msg)) { ?>
			$('.connex_msg').show();
	<?php } ?>
	if ($(location).attr('hash') == "#mot-de-passe-oublie")
		$("#forgottenpwd_a").click();
	<?php
	endif ;
	if (!empty($this->err))
	{
		foreach ($this->err as $key => $value)
			echo '$("#',$key,' .connex_error").show();', PHP_EOL;
	}
	?>
});