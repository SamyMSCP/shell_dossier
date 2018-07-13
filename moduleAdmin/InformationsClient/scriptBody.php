</script>
<script type="text/javascript" charset="utf-8">
var vueInstance = new Vue({
	el: ".vueCrmShow"
});

function changeDhToProspect() {
	var f = document.createElement("form");
	f.setAttribute('method',"post");
	f.setAttribute('action',"?p=<?=$GLOBALS['GET']['p']?>&client=<?=$GLOBALS['GET']['client']?>");
	f.setAttribute('accept-charset',"utf-8");

	var csrf = document.createElement("input");
	csrf.setAttribute('type',"hidden");
	csrf.setAttribute('name',"token");
	csrf.setAttribute('value', '<?=$_SESSION["csrf"][0]?>');
	f.appendChild(csrf);

	var id_client = document.createElement("input");
	id_client.setAttribute('type',"hidden");
	id_client.setAttribute('name',"id_client");
	id_client.setAttribute('value', <?=$GLOBALS['GET']['client']?>);
	f.appendChild(id_client);

	var action  = document.createElement("input");
	action.setAttribute('type',"hidden");
	action.setAttribute('name',"action");
	action.setAttribute('value', 'changeDhToProspect');
	f.appendChild(action);

	document.body.appendChild(f);
	f.submit();
}

function changeDhToOrigineContact() {
	var f = document.createElement("form");
	f.setAttribute('method',"post");
	f.setAttribute('action',"?p=<?=$GLOBALS['GET']['p']?>&client=<?=$GLOBALS['GET']['client']?>");
	f.setAttribute('accept-charset',"utf-8");

	var csrf = document.createElement("input");
	csrf.setAttribute('type',"hidden");
	csrf.setAttribute('name',"token");
	csrf.setAttribute('value', '<?=$_SESSION["csrf"][0]?>');
	f.appendChild(csrf);

	var id_client = document.createElement("input");
	id_client.setAttribute('type',"hidden");
	id_client.setAttribute('name',"id_client");
	id_client.setAttribute('value', <?=$GLOBALS['GET']['client']?>);
	f.appendChild(id_client);

	var action  = document.createElement("input");
	action.setAttribute('type',"hidden");
	action.setAttribute('name',"action");
	action.setAttribute('value', 'changeDhToOrigineContact');
	f.appendChild(action);

	document.body.appendChild(f);
	f.submit();
}

<?php
if ($this->collaborateur->type == "yoda" || $this->collaborateur->type == "prospecteur" || $this->collaborateur->type == "assistant" || $this->collaborateur->type == "backoffice" || $this->collaborateur->id_dh == $this->dh->conseiller)
{
	?>
	$('#changeConseiller').change(function() {
		$('#btnChangeConseiller').show();
	});
	$('#btnChangeConseiller').click(function() {
		var conseiller = $('#changeConseiller').val();
		var f = document.createElement("form");
		f.setAttribute('method',"post");
		f.setAttribute('action',"?p=<?=$GLOBALS['GET']['p']?>&client=<?=$GLOBALS['GET']['client']?>");
		f.setAttribute('accept-charset',"utf-8");

		var csrf = document.createElement("input");
		csrf.setAttribute('type',"hidden");
		csrf.setAttribute('name',"token");
		csrf.setAttribute('value', '<?=$_SESSION["csrf"][0]?>');
		f.appendChild(csrf);

		var id_client = document.createElement("input");
		id_client.setAttribute('type',"hidden");
		id_client.setAttribute('name',"id_client");
		id_client.setAttribute('value', <?=$GLOBALS['GET']['client']?>);
		f.appendChild(id_client);

		var id_conseiller  = document.createElement("input");
		id_conseiller.setAttribute('type',"hidden");
		id_conseiller.setAttribute('name',"id_conseiller");
		id_conseiller.setAttribute('value', conseiller);
		f.appendChild(id_conseiller);

		var action  = document.createElement("input");
		action.setAttribute('type',"hidden");
		action.setAttribute('name',"action");
		action.setAttribute('value', 'changeConseiller');
		f.appendChild(action);

		document.body.appendChild(f);
		f.submit();
	});
	<?php
}
?>

</script>
<script type="text/javascript" charset="utf-8">
