<?php
	$this->datas = [];
	//dbg($this->dh->getActuality());
	//exit();
if (($actus = $this->dh->getActuality()))
{
	foreach ($actus as $value) {
		$this->datas[] = array(
			"type" => "actu",
			"title" => $value->title,
			"date" => $value->getDatePublication(),
			//"link" => "https://www.meilleurescpi.com/actualites/" . $value->token . "-" . $value->slug
			"link" => $value->getUrl()
		);
	}
}
if (($publ = $this->dh->getPublication()))
{
	foreach ($publ as $value) {
		//var_dump($value);
		//exit();
		$this->datas[] = array(
			"type" => "pub",
			"title" => $value->title,
			"date" => $value->getDatePublication(),
		//"link" => "https://www.meilleurescpi.com" .  $value->path
			"link" => $value->getUrl()
		);
	}
}
function sorting($a, $b) {
	return ($a['date'] < $b['date']);
}
usort($this->datas, "sorting");
