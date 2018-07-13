</script>
<script type="text/javascript" charset="utf-8">

function showListeDeroulante(ids, items, e) {
	console.log(items);
	var event = window.event || e;
	var cible = $(".ListeDeroulanteContent ul");
	cible.empty();
	for (var item in items)
	{
		var nli = $('<li>').html("<span>" + items[item]['filename'] + "</span> : " + items[item]['dateCreation']);
		nli.attr('onclick', "window.open('" + items[item]["link"] + "', 'Download')");
		cible.append(nli);
	}
	$(".ListeDeroulanteContent").css({left: event.clientX + "px", top: event.clientY + "px"});
	$(".ListeDeroulanteContent").find(".idClient").val(ids.idClient);
	$(".ListeDeroulanteContent").find(".idEntity").val(ids.idEntity);
	$(".ListeDeroulanteContent").find(".linkEntity").val(ids.linkEntity);
	$(".ListeDeroulanteContent").find(".idTypeDocument").val(ids.idTypeDocument);
	$(".ListeDeroulante").show();
	$(".ListeDeroulanteContent").show();
}

function closeListeDeroulante() {
	$(".ListeDeroulante").hide();
	$(".ListeDeroulanteContent").hide();
}
