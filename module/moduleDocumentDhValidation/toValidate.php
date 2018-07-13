<h3>Merci de prendre connaissance et de valider ce document afin de pouvoir <br />continuer à utiliser votre compte.</h3>
<iframe style='width: 900px;height:500px;margin-bottom:20px;' class='embed-responsive-item' src='?p=DownloadDocument&idDocument=<?=$documents[0]->id?>'></iframe>
<form action='?p=<?=$GLOBALS['GET']['p']?>' method='POST' accept-charset='utf-8'>
	Je reconnais avoir pris connaissance et accepte : <input style="height: 15px;width: 15px;" type="checkbox" name="isValidate" id="" required /><br />
	<input type="hidden" name="idDocument" id="" value="<?=$documents[0]->id?>" />
	<input type="hidden" name="token" id="token" value="<?php echo $_SESSION['csrf'][0]; ?>"/>
	<div class="navValidateDoc">
		<input  type="submit" name="validateDocument_<?=$this->documentTypeName?>" id="" value="Valider" />
	</div>
</form>
