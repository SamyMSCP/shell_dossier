<div class="ListeDeroulante" onclick="closeListeDeroulante()">
</div>
<div class="ListeDeroulanteContent">
	<h3>Liste des documents</h3>
	<ul>
		<li> asdfsdaf</li>
	</ul>
	<hr />
	<h3>Envoyer un nouveau document</h3>
	<form action="?p=<?=$GLOBALS['GET']['p']?>&client=<?=$GLOBALS['GET']['client']?>" method="post" accept-charset="utf-8"  enctype="multipart/form-data">
		<input type="hidden" name="token" id="token" value="<?php echo $_SESSION['csrf'][0]; ?>"/>
		<input type="hidden" class="idClient" name="idClient" id="" value="" />
		<input type="hidden"class="idEntity" name="idEntity" id="" value="" />
		<input type="hidden" class="linkEntity" name="linkEntity" id="" value="" />
		<input type="hidden" class="idTypeDocument" name="idTypeDocument" id="" value="" />
		<input type="file" name="fichier" id="fileToUpload">
		<input type="submit" value="Envoyer le document" name="submit">
	</form>
</div>
