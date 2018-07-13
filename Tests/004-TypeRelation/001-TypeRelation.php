<?php

if (!test("Importation de la classe", class_exists("TypeRelation"), "La classe TypeRelation ne semble pas exister"))
	return (false);

$type = new Type($table, []);
if (!test("Instanciation de la clasee", $type instanceof Type, "Instanciation de la class"))
	return (false);

return (true);
