<?php
require 'app.php';

$cat = Apiv2::getRequestJsonCategories();
var_dump($cat);
