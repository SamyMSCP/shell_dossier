<?php
require_once("class/core/Page.php");
class Index2 extends Page
{
	public $title = "Mon Compte SCPI";

	private $_backgrounds = [['img' => 'cc-homepage-scpi.jpg', 'desc' => "Suivez la performance de votre portefeuille SCPI.<br />Gratuit, accessible à tous."]];

	private $_elt = null;

	protected function getImage()
	{
		return $this->getPath() . 'img/' . $this->_backgrounds[$this->_elt]['img'];
	}

	protected function getDesc()
	{
		return $this->_backgrounds[$this->_elt]['desc'];
	}

	protected function setBackground()
	{
		$this->_elt = mt_rand(0, count($this->_backgrounds) - 1);
	}
}