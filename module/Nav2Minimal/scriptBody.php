</script>
<script type="text/javascript" charset="utf-8">

$(window).scroll(function() {
	if ($(document).width() < 540)
	{
		if ($(window).scrollTop() >= 123)
		{
			$('.navBarOut').css('position', 'fixed');
			$('.navBarOut').css('top', '-123px');
			$('.navBack').css('opacity', '1');
		}
		else
		{
			$('.navBarOut').css('position', 'absolute');
			$('.navBarOut').css('top', '0px');
			$('.navBack').css('opacity', ($(window).scrollTop() / 123));
		}
	}
	else
	{
		$('.navBarOut').css('position', 'fixed');
		$('.navBarOut').css('top', '0px');
		//$('navBack').css('opacity', '1');
	}
});

$(window).resize(function() {
	$('.navBarOut').css('position', 'fixed');
	$('.navBarOut').css('top', '0px');
});

function checkNavShadow() {
	if ($(window).scrollTop() > 100)
	{
		$(".navBack").addClass("navBarOutShadow");
		$(".navBarOut").addClass("navBarOutShadow");
	}
	else
	{
		$(".navBack").removeClass("navBarOutShadow");
		$(".navBarOut").removeClass("navBarOutShadow");
	}
}

$(window).on("scroll", checkNavShadow);
