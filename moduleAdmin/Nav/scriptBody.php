</script>
<script type="text/javascript" charset="utf-8">
	document.getElementById("setSizeHiddenNotif").style.minWidth = document.getElementById("getSizeNotif").offsetWidth + "px"
	document.getElementById("setSizeHiddenMenu").style.minWidth = document.getElementById("getSizeName").offsetWidth + "px"
	document.getElementById("setSizeHiddenSearch").style.minWidth = document.getElementById("searchBar").offsetWidth + "px"

var TM;
$("#searchBar").keydown(function () {
	$("#setSizeHiddenSearch").empty();
	clearTimeout(TM);
	TM = setTimeout( function(){
		$.getJSON("admin_lkje5sjwjpzkhdl42mscpi.php?p=Ajax&pattern=" + $("#searchBar").val())
		.done(function( json ){
			$.each(json, function (i, item){
				$("#setSizeHiddenSearch").append('<li style="cursor: pointer;"><a href="admin_lkje5sjwjpzkhdl42mscpi.php?p=EditionClient&client=' + item.id + '">' + item.nom + " " + item.prenom + '</li>')
			});
		});
	}, 400);
});

$('#getSizeNotif').hover(function() {
	$(this).find('.dropdown-menu').stop(true, true).delay(50).fadeIn(200);
}, function() {
	$(this).find('.dropdown-menu').stop(true, true).delay(50).fadeOut(200);
});
