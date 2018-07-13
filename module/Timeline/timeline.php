<?php
$date = NULL;

foreach ($this->data as $key =>$elem) 
{
	?>
	<div class="TimelineElm<?php if (in_array($elem->id, $this->favoris)) echo " haveFavorite";?>" id_article="<?=$elem->id?>">
		<?php
		if (preg_match("/<\s*p[^>]*>([^<]*)<\s*\/\s*p\s*>/", $elem->content, $val)){
			if ($elem->getDatePublication()->format("d/m/Y") != $date)
			{
			  $date = $elem->getDatePublication()->format("d/m/Y");
			  //echo '<div class="date"><span>' . $date . '</span></div>';
			}
		}
		else
		{
			$val = array("");
		}
		?>
		<div class="TimelineElmIn" onclick="window.open('<?=$elem->getUrl()?>')">
			<div class="TimelineElmTitle">
				<img src="<?=$this->getPath()?>img/Actus-Bleu-MS.svg" alt="" />
				<div>
					<h3><a href="<?=$elem->getUrl()?>" target="_blank"><?=$elem->title?></a></h3>
					<?php
						//$date = Datetime::createFromFormat("Y-m-d H:i:s",$elem->date_publication)->format("d/m/Y");
						$date = $elem->getDatePublication()->format("d/m/Y");
					?>
					<span>Publié le <?=$date?></span>
				</div>
				<?php
				/*
				<img id_article="<?=$elem->id?>" onclick="removeFavorite(this);" class="imgLogo isFavorite" src="<?=$this->getPath() . "img/Favoris_BleuMS-Positif.png"?>" alt="" />
				<img id_article="<?=$elem->id?>" onclick="addNewFavorite(this);" class="imgLogo isNotFavorite" src="<?=$this->getPath() . "img/Favoris_Bleu-MS.png"?>" alt="" />
				*/
				?>
				<i id_article="<?=$elem->id?>" onclick="event.stopPropagation();removeFavorite(this);" class="imgLogo isFavorite fa fa-star"></i>
				<i id_article="<?=$elem->id?>" onclick="event.stopPropagation();addNewFavorite(this);" class="imgLogo isNotFavorite fa fa-star-o"></i>
				
			</div>
			<div class="TimelineElmContent">
				<p><?=$val[0]?></p>
			</div>
			<div class="flecheLeft">
				<svg width="50" height="30">
					<circle cx="32" cy="15" r="7" fill="#ff9f1c" stroke-width="4" stroke="white"></circle>
					<path d="M 0,6 L 10,15 L 0,24 " style="fill:#ebebeb;"></path>
				</svg>
			</div>
			<div class="flecheRight">
				<svg width="50" height="30">
					<circle cx="18" cy="15" r="7" fill="#ff9f1c" stroke-width="4" stroke="white"></circle>
					<path d="M 50,6 L 40,15 L 50,24 " style="fill:#ebebeb;"></path>
				</svg>
			</div>
		</div>
	</div>
	<?php
}


/*
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
  if (preg_match("/<\s*premoveFavorite(this);" class="imgLogo isFavorite fa fa-star"></i>
				<i id_article="<?=$elem->id?>" onclick="addNewFavorite(this);" class="imgLogo isNotFavorite fa fa-star-o"></i>
				
			</div>
			<div class="TimelineElmContent">
				<p><?=$val[0]?></p>
			</div>
			<div class="flecheLeft">
				<svg width="50" height="30">
					<circle cx="32" cy="15" r="7" fill="#ff9f1c" stroke-width="4" stroke="white"></circle>
					<path d="M 0,6 L 10,15 L 0,24 " style="fill:#ebebeb;"></path>
				</svg>
			</div>
			<div class="flecheRight">
				<svg width="50" height="30">
					<circle cx="18" cy="15" r="7" fill="#ff9f1c" stroke-width="4" stroke="white"></circle>
					<path d="M 50,6 L 40,15 L 50,24 " style="fill:#ebebeb;"></path>
				</svg>
			</div>
		</div>
	</div>
	<?php
}


/*
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
  if (preg_match("/<\s*premoveFavorite(this);" class="imgLogo isFavorite fa fa-star"></i>
				<i id_article="<?=$elem->id?>" onclick="addNewFavorite(this);" class="imgLogo isNotFavorite fa fa-star-o"></i>
				
			</div>
			<div class="TimelineElmContent">
				<p><?=$val[0]?></p>
			</div>
			<div class="flecheLeft">
				<svg width="50" height="30">
					<circle cx="32" cy="15" r="7" fill="#ff9f1c" stroke-width="4" stroke="white"></circle>
					<path d="M 0,6 L 10,15 L 0,24 " style="fill:#ebebeb;"></path>
				</svg>
			</div>
			<div class="flecheRight">
				<svg width="50" height="30">
					<circle cx="18" cy="15" r="7" fill="#ff9f1c" stroke-width="4" stroke="white"></circle>
					<path d="M 50,6 L 40,15 L 50,24 " style="fill:#ebebeb;"></path>
				</svg>
			</div>
		</div>
	</div>
	<?php
}


/*
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
*/
