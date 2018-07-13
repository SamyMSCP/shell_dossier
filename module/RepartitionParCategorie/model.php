<?php
	$this->data = array();
	$this->total = 0;
	/*
	$this->catName = array(
		"31"	=>	"Diversifiée",
		"33"	=>	"Murs de magasin",
		"34"	=>	"Plus value",
		"35"	=>	"Régionale",
		"36"	=>	"Scellier BBC",
		"37"	=>	"Malraux",
		"38"	=>	"Déficit Foncier",
		"39"	=>	"Scellier",
		"40"	=>	"Scellier BBC Intermédiaire",
		"41"	=>	"Duflot",
		"42"	=>	"Commerces",
		"43"	=>	"Specialisées",
		"45"	=>	"Pinel",
		"48"	=>	"Bureaux",
		"51"	=>	"Rénovation",
		"57"	=>	"Monuments Historiques"
	);
	*/
	//$this->catName = Scpi::$catName;
	$this->catName = CategoriesScpi::getAll();

	//var_dump($this->catName);
	//exit();
//	$this->color = array(
//		"Diversifiée" => "#0085A9",
//		"Murs de magasin" => "#014C7F",
//		"Plus value" => "#002640",
//		"Régionale" => "#006D7F",
//		"Malraux" => "#00C3E5",
//		"Déficit Foncier" => "#007F6C",
//		"Scellier" => "#007F6C",
//		"Scellier BBC" => "#007F6C",
//		"Duflot" => "#008A5E",
//		"Commerces" => "#0073B1",
//		"Specialisées" => "#009491",
//		"Pinel" => "#00402B",
//		"Bureaux" => "#01528A",
//		"Rénovation" => "#007F3F"
//	);

$this->color = array_reverse(array (
	"#eff8fe",
	"#bee2fc",
	"#8dcbfa",
	"#5db5f8",
	"#2c9ff5",
	"#0b87e4",
	"#086ab3",
));
	foreach ($this->table as $key => $elm) {
		if ($key == "precalcul")
			continue;
		if (empty($this->data[$this->catName[$elm['precalcul']['scpi']->category_id]]))
			$this->data[$this->catName[$elm['precalcul']['scpi']->category_id]] = 0;
		//echo $elm['precalcul']['scpi']->category_id . "\n";

		$this->data[$this->catName[$elm['precalcul']['scpi']->category_id]] += $elm['precalcul']['ventePotentielle'];
		$this->total += $elm['precalcul']['ventePotentielle'];
	}
	//exit();
?>
