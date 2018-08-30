	
</script>
<script type="text/javascript" charset="utf-8">

function setReadDoc(id_doc) {
	$.ajax({
		method: "POST",
		url: "?p=SetReadDoc",
		data: { token: "<?=$_SESSION['csrf'][0]?>", id_document: id_doc }
	}).done(function( msg ) {
	});
}
