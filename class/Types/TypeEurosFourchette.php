<?php
require_once("TypeEnumInt.php");
class TypeEurosFourchette extends TypeEnumInt {

	public function getEditComponent() {
		return ('ComponentTypeEnumSelectEdit');
		//return ('ComponentTypeEnumCheckboxEdit');
	}

}
