<form class="upload_form" action="?<?php if (isset($GLOBALS['GET']['p'])) echo "p=" . $GLOBALS['GET']['p'];?>&haveData=1" method="post" enctype="multipart/form-data">
	Choisissez le Separateur pour le Csv : 
	<select name="separateur">
		<option value="," selected>,</option>
		<option value=";">;</option>
	</select>
	<br />
	<br />
	Choisissez le Csv SCPI a Importer :
	<input type="file" name="fileToUpload" id="fileToUpload" style="display: inline;">
	<br />
	<br />
	<input type="hidden" name="token" id="token" value="<?php echo $_SESSION['csrf'][0]; ?>"/>
	<input type="submit" value="Envoyer ce fichier" name="uploadCsv">
</form>
