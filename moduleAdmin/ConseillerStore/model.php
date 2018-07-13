<?php

$this->consel = Dh::getConseillers();
//$consel = Dh::getConseillers();
//$this->consel = [];
foreach ($this->consel as $index => $el) {
	$this->consel[$index]->login = ft_decrypt_crypt_information($el->login);
}