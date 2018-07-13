</script>
<script type="text/javascript" charset="utf-8">
function init_DonneurDOrdreClient() {
}

var vueInstanceDhDocument = new Vue({
	el: "#vueDhDocument",
	store: store
});

var dataDh = {
	<?php
	$first2 = true;
	foreach ($this->RequiredDocumentDh as $key1 => $elm1)
	{
		if (!$first2)
			echo ",
";
		?>
"<?=$elm1->id?>":{
		<?php
		$first3 = true;
		foreach ($this->dh->getDocuments($elm1->id) as $key2 => $elm2)
		{
			if (!$first3)
				echo ", ";
			?>
			"<?=$elm2->id?>":{
				"filename":"<?=$elm2->getFilename()?>",
				"dateExecution":"<?=$elm2->getDateExecution()->format("d/m/Y")?>",
				"dateCreation":"<?=$elm2->getDateCreation()->format("d/m/Y")?>",
				"link":"?p=DownloadDocument&idDocument=<?=$elm2->id?>",
				"id":"<?=$elm2->id?>"
			}
			<?php
			$first3 = false;
		}
		?>}<?php
		$first2 = false;
	}
	?>
}

<?php
if ($this->canChangeMail)
{
	?>
	function delockChangeMail() {
		$('.delocker').hide();
		$('.btnChangeMail > button').show();
	}


	$('.delocker').on("click", delockChangeMail);
	$('.btnChangeMail').show();

	$('#btnChangeMail').on("click", function() {
		var noContinue = false;
		if ($('#oldMail').val() != "<?=$this->dh->getLogin()?>")
		{
			$('.avertissementMessage2').show();
			noContinue = true;
			$('#oldMail').css("border-color", "red");
		}
		else
		{
			$('.avertissementMessage2').hide();
			$('#oldMail').css("border-color", "green");
		}
		if ($('#newMail').val() != $('#newMailConfirmation').val())
		{
			$('.avertissementMessage1').show();
			$('#newMail').css("border-color", "red");
			noContinue = true;
		}
		else
		{
			$('.avertissementMessage1').hide();
			$('#newMail').css("border-color", "green");
		}
		if (!$('#newMail').val().match(/(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/)){
			$('.avertissementMessage3').show();
			noContinue = true;
			$('#newMailConfirmation').css("border-color", "red");
			$('#newMail').css("border-color", "red");
		}
		else
		{
			$('.avertissementMessage3').hide();
			if (!noContinue)
			{
				$('#newMailConfirmation').css("border-color", "green");
				$('#newMail').css("border-color", "green");
			}
		}
		if (noContinue)
			return ;
		$("#changeMailDh").submit();
	});
	<?php
	}
?>
