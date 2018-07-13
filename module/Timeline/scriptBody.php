</script>
<script>

var allActu = [];


function searchArticleById(id) {
	for (var i = 0; i < allActu.length; i++)
	{
		if (id == $(allActu[i]).attr("id_article"))
			return ($(allActu[i]));
	}
}

function searchVisibleArticleById(id) {
	var leftBlock = $('.blockTimelineLeft').children();
	for (var i = 0; i < leftBlock.length; i++)
	{
		if (id == $(leftBlock[i]).attr("id_article"))
			return ($(leftBlock[i]));
	}
	var rightBlock = $('.blockTimelineRight').children();
	for (var i = 0; i < rightBlock.length; i++)
	{
		if (id == $(rightBlock[i]).attr("id_article"))
			return ($(rightBlock[i]));
	}
}

function searchFavoriteArticleById(id) {
	var Block = $('.ContentFavorite').children();
	for (var i = 0; i < Block.length; i++)
	{
		if (id == $(Block[i]).attr("id_article"))
			return ($(Block[i]));
	}
}

function addFavorite(Favorite) {
	$("#favoriteempty").css("display", "none");
	var nelm = $(".TimelineElmFavoriteProto").clone();
	nelm.removeClass("TimelineElmFavoriteProto");
	nelm.attr("id_article", Favorite.attr('id_article'));
	nelm.find(".imgLogo").attr("id_article", Favorite.attr('id_article'));
	nelm.find("h3").html(Favorite.find(".TimelineElmTitle h3").html());
	nelm.find("span").html(Favorite.find(".TimelineElmTitle span").html());
	//nelm.attr("onclick","coucou");
	
	$('.moduleDernieresActuFavoris .moduleContent').append(nelm);
}

function removeOldFavorite(element) {
	element.remove();
}

function removeFavorite(element) {
	$.ajax({ url : 'index.php?p=SetFavorite&action=remove&id=' + $(element).attr("id_article"), type : 'POST', data : 'token=<?=$_SESSION['csrf'][0]?>',
		success : function(code_html, statut){ // code_html contient le HTML renvoyé
			if( code_html === "OK")
			{
				var article = searchVisibleArticleById($(element).attr("id_article"));
				article.removeClass("haveFavorite");
				article = searchArticleById($(element).attr("id_article"));
				article.removeClass("haveFavorite");
				article = searchFavoriteArticleById($(element).attr("id_article"));
				removeOldFavorite(article);
				if ($('.ContentFavorite').children().length == 1)
					$("#favoriteempty").css("display", "initial");
			}
			else
			{
				console.log("Demandes pour retirer trop rapide");
			}
		}
	});
}

function addNewFavorite(element) {
	$.ajax({ url : 'index.php?p=SetFavorite&action=add&id=' + $(element).attr("id_article"), type : 'POST', data : 'token=<?=$_SESSION['csrf'][0]?>',
		success : function(code_html, statut){ // code_html contient le HTML renvoyé
			if( code_html === "OK")
			{
				var article = searchVisibleArticleById($(element).attr("id_article"));
				addFavorite(article);
				article.addClass("haveFavorite");
				article = searchArticleById($(element).attr("id_article"));
				article.addClass("haveFavorite");
			}
			else
			{
				console.log("De mande d'ajout trop rapide");
			}
		}
	});
}

function placeElement() {
	var lastInsertColumn = "left";
	var leftSize = 0;
	var rightSize = 0;
	var lastTop = 0;
	var listElementLeft = $('.blockTimelineLeft');
	var listElementRight = $('.blockTimelineRight');
	listElementLeft.empty();
	listElementRight.empty();
	if ($( document ).width() > 1000)
	{
		listElementRight.show();
		for (var i = 0; i < allActu.length; i++)
		{
			var tmp = $(allActu[i]).clone();
			if($(allActu[i]).hasClass("haveFavorite"))
				addFavorite($(allActu[i]));
			if (leftSize <= rightSize)
			{
				listElementLeft.append(tmp);
				leftSize += tmp.height();
				if (tmp.position().top < lastTop + 20)
					tmp.css("margin-top", "30px");
				lastTop = leftSize;
			}
			else
			{
				listElementRight.append(tmp);
				rightSize += tmp.height();
				if (tmp.position().top <= lastTop + 20)
					tmp.css("margin-top", "30px");
				lastTop = rightSize;
			}
		}
	}
	else
	{
		listElementRight.hide();
		for (var i = 0; i < allActu.length; i++)
		{
			var tmp = $(allActu[i]).clone();
			if($(allActu[i]).hasClass("haveFavorite"))
				addFavorite($(allActu[i]));
			listElementLeft.append(tmp);
		}
	}
}

function initListActu() {
	var listElement = $('.dataTimeline').children();
	for (var i = 0; i < listElement.length + 1; i++)
	{
		if (i < listElement.length)
			allActu.push(listElement[i]);
		else
			$('.dataTimeline').empty();
	}
}

initListActu();

$(document).ready(function() {
	placeElement();
});

$( window ).resize(function() {
	placeElement();
});

function sortSelect(selElem, id_page) {
    var tmpAry = new Array();
    for (var i=0;i<selElem.options.length;i++) {
        tmpAry[i] = new Array();
        tmpAry[i][0] = selElem.options[i].text;
        tmpAry[i][1] = selElem.options[i].value;
    }
    tmpAry.sort();
    while (selElem.options.length > 0) {
        selElem.options[0] = null;
    }
    var index = 0;
    for (var i=0;i<tmpAry.length;i++) {
        if (tmpAry[i][0] == "TOUTES LES SCPI"){
            var op = new Option(tmpAry[i][0], tmpAry[i][1]);
            selElem.options[index++] = op;
            break;
        }
    }
    for (var i=0;i<tmpAry.length;i++) {
        if (tmpAry[i][0] != "TOUTES LES SCPI"){
            var op = new Option(tmpAry[i][0], tmpAry[i][1]);
            selElem.options[index] = op;
			if (selElem.options[index].value == id_page)
				selElem.options[index].selected = true;
			index++;
        }
    }
    return;
}
sortSelect(document.getElementById('scpialllist'), <?php echo (empty($GLOBALS['GET']['id']) ? 0 : $GLOBALS['GET']['id']); ?>);
