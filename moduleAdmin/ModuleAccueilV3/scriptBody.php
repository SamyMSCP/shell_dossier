	
</script>
<script type="text/javascript" charset="utf-8">

var savetimer = null;
var userList = {};

function getFromInput() {
	return (new Promise(function(resolve, reject) { 
		var input = $("#searchInput").val();
		//if (input.length < 3)
			//return (reject());
		if (savetimer != null)
			clearTimeout(savetimer);
		//if (checkAdresse(code, commune, codeList))
			//return (reject());
		if (typeof userList[String(input).toLowerCase()] != "undefined")
		{
			var id = userList[String(input).toLowerCase()];
			window.open("?p=EditionClient&client=" + id, '_blank');
			$("#searchInput").val("");
			$("#searchInput").blur();
		}
		savetimer = setTimeout(function() {
			$.ajax({
				method: "POST",
				url: "ajax_request.php",
				data: { 
					req: "UserFinder",
					data: input,
					token: "<?=$_SESSION['csrf'][0]?>"
				}
			}).done(function( msg ) {
				
				var datas = msg;
				$('#userList').html('');
				userList = {};
				for (key in datas)
				{
					//if (key != 'token')
					//	break;
					if (typeof datas[key]['shortName'] != "undefined")
					{
						userList["[" + datas[key]['id'] + "] " + datas[key]['shortName'].toLowerCase()] = datas[key].id;
						$('#userList').append("<option value='[" + datas[key].id + "] " + datas[key]['shortName'] + "'/>");
					}
				}
				resolve();
			});
			savetimer = null;
		}, 300);
	}));
}


function checkInput(e) {
	var code = e.keyCode || e.which;
	if (code == 27 && $("#searchInput").is(":focus"))
	{
		$("#searchInput").val("");
		$("#searchInput").blur();
	}
	if ($("#searchInput").val() == "" && !$("#searchInput").is(":focus"))
	{
		$('#beforeInput').slideDown();
		$('#userList').html('');
		userList = {};
	}
	else
	{
		$('#beforeInput').slideUp("fast");
		getFromInput();
	}
}



$( document ).ready(function() {
	$("#searchInput").on("blur", checkInput);
	$("#searchInput").on("focus", checkInput);
	$("#searchInput").on("input", checkInput);

/*
	$(document).on("keyup", function(e){
		var code = e.keyCode || e.which;
		if (code == 27 && $("#searchInput").is(":focus"))
		{
			$("#searchInput").val("");
			$("#searchInput").blur();
		}
		else if (!$("#searchInput").is(":focus") || $("#searchInput").val() == "")
		{
			$("#searchInput").focus();
			if ($("#searchInput").val() == "")
				$("#searchInput").val(String.fromCharCode(code));
		}
	});
	*/
});
