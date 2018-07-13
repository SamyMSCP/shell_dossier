<div id="alphaLine" class="alphaLine">
<?php
$date = NULL;
if (!empty($GLOBALS['GET']['id'])){
foreach ($this->data as $elem) {
  if (preg_match("/<\s*p[^>]*>([^<]*)<\s*\/\s*p\s*>/", $elem->content, $val)){
	  if (substr($elem->date_publication, 0, 4) != $date){
		  $date = substr($elem->date_publication, 0, 4);
		  echo '<div class="date"><span>' . $date . '</span></div>';
	  }
	  echo '<div class="evenement">
		  <a target="_blank" href="' . $elem->getUrl() . '">
		<h3><img src="' . $this->getPath() .  'img/actu.png" style="width: 40px; margin-right: 5px;">' . $elem->title . '</h3>
		<div class="text_content">' . $val[0] . '</div></a>
	  </div>';
	}
}
}
else{
foreach ($this->data as $elem) {
  if (preg_match("/<\s*p[^>]*>([^<]*)<\s*\/\s*p\s*>/", $elem->content, $val)){
	  if (substr($elem->date_publication, 0, 4) != $date){
		  $date = substr($elem->date_publication, 0, 4);
		  echo '<div class="date"><span>' . $date . '</span></div>';
	  }
	  echo '<div class="evenement">
		  <a target="_blank" href="' . $elem->getUrl() . '">
		<h3><img class="imgTimeLine" src="' . $this->getPath() .  'img/actu.png" style="">' . $elem->title . '</h3>
		<div class="text_content">' . $val[0] . '</div></a>
	  </div>';
	}
}
}
?>
</div>
