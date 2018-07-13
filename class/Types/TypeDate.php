<?php
class TypeDate extends Type {

	protected static $_dependances = [
		"ComponentTypeDateEdit" => ["noname" => []]
	];

	protected static $_sqlColumn = "bigint(20)";
	protected  $_config = [];
	protected static function isValid($val) {
		if (!$val instanceof DateTime)
			return (false);
		if (empty($val->getTimestamp()))
			return (false);
		return (true);
	}

	public function setNow() {
		$this->set(time());
	}

	protected static function beforeSet($val) {
		$rt = $val;
		if (is_string($val))
			$rt = DateTime::createFromFormat("d/m/Y", $val);
		if (is_int($val) || $rt === false) {
			$rt = new Datetime();
			$rt->setTimestamp(intval($val));
		}
		if ($rt instanceof DateTime)
			return ($rt);
		return (null);
	}

	protected static function prepareSet($val) {
		$rt = $val;
		if (is_int($val))
			return (intval($val));
		else if (is_string($val))
			$rt = DateTime::createFromFormat("d/m/Y", $val);
		if ($rt instanceof DateTime)
			return ($rt->getTimestamp());
	}


	protected static function prepareGet($val) {
		if ($val == null)
			return (null);
		$rt = new DateTime();
		$rt->setTimestamp(intval($val));
		return ($rt);
	}

	public function getForState($getError = false) {
		if (!$this->_entity->canGetValue($this->_config['column']))
			return ([]);
		$rt = [
			$this->_config['column'] =>  [
				"value" => $this->getRawValue(),
				"canSet" => $this->_entity->canSetValue($this->_config['column'])
			]
		];
		if (!$this->checkData() && $getError)
			$rt[$this->_config['column']]['error'] = $this->getError();
		return ($rt);
	}

	public function getShowComponent() {
		return ("ComponentTypeDateShow");
	}

	public function getEditComponent() {
		return ("ComponentTypeDateEdit");
	}

	public function setForGraphApi($data) {
		if (!$this->_entity->canSetValue($this->_config['column']))
			return (false);

		if (!is_array($data))
			return (false);

		$val = static::beforeSet($data[$this->_config['column']]['value']);
		$this->setNoControl($val);
		return ($this->checkData());
	}
}
