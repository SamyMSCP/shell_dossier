<div class="cpos">
		<form class="form-signin mg-btm" method="post" action="index.php">
		<input type="hidden" name="token" id="token" value="<?php echo $_SESSION['csrf'][0]; ?>"/>
	<img class="logoImg" src="img/logo-meilleurescpi.png" alt="logo MeilleureSCPI.com">
	<div class="main">
		<h3 style="text-align: center; color: #01528A; font-weight: bold; margin-bottom: 25px;">Votre compte client est en maintenance</h3>
			<div class="row formIn">
				<div class="col-xs-2" style="text-align:right;">
					<img src="img/Cadenas-closed-BleuMS.svg" style="margin-top: 0px; margin-left: -16px; width: 30px;">
				</div>
				<div class="input-group col-xs-10">
					<p>Suite à une maintenance technique, le compte client est inaccessible, merci de réessayer ultérieurement.</p>
				</div>
			</div>
	</div>
      </form>
</div>
