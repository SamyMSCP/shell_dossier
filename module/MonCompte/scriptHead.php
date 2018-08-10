</script>
<script type="text/javascript" charset="utf-8">

	<?php if (isProd() || 0) : ?>
	window.__insp = window.__insp || [];
	__insp.push(['wid', 462957643]);
	(function() {
	function ldinsp(){if(typeof window.__inspld != "undefined") return; window.__inspld = 1; var insp = document.createElement('script'); insp.type = 'text/javascript'; insp.async = true; insp.id = "inspsync"; insp.src = ('https:' == document.location.protocol ? 'https' : 'http') + '://cdn.inspectlet.com/inspectlet.js'; var x = document.getElementsByTagName('script')[0]; x.parentNode.insertBefore(insp, x); };
	setTimeout(ldinsp, 500); document.readyState != "complete" ? (window.attachEvent ? window.attachEvent('onload', ldinsp) : window.addEventListener('load', ldinsp, false)) : ldinsp();
	})();
	<?php endif; ?>

</script>
<script type="text/javascript" charset="utf-8">

function showModalTransaction(id_transaction) {
	console.log('Hihi' + id_transaction);
	store.dispatch("SET_SELECTED_TRANSACTION", id_transaction);
	$('#tableau-transaction-edit-modal').modal('show')
}
