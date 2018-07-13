<form action="?<?php if (isset($GLOBALS['GET']['p'])) echo "p=" . $GLOBALS['GET']['p'];?>&haveData=1" method="post" enctype="multipart/form-data">
	Select image to upload:
	<input type="file" name="fileToUpload" id="fileToUpload">
	<input type="submit" value="Envoyer ce fichier" name="uploadCsv">
</form>
