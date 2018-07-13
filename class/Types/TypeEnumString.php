<?php
class TypeEnumString extends Type {

	protected static $_errorMsg = "Cette donnée n'est pas valide";

	protected static $_sqlColumn = "text";
	protected $_config = [];
	public function checkData() {
		if (isset($this->_config['notCheck'])  && $this->_config['notCheck'] === true )
			return (true);
		if (isset($this->_config['canEmpty'])  && $this->_config['canEmpty'] === true && empty($this->getRawValue()))
			return (true);
		$val = $this->get();
		if (in_array($val, $this->_config['datas']))
				return (parent::checkData());
		return (false);
	}

	protected static function beforeSet($val) {
		if ($val === null)
			return ("");
		return ($val);
	}

	public function getShowComponent() {
		return ("ComponentTypeEnumSelectShow");
	}

	public function getEditComponent() {
		return ("ComponentTypeEnumSelectEdit");
	}

}
