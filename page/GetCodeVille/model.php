<?php
if (!isset($_POST['code']) && !isset($_POST['commune']))
	success([]);
else if (isset($_POST['code']) && isset($_POST['commune']))
	success(CodeVille::getFromCodeCommune($_POST['code'], $_POST['commune']));
else if (isset($_POST['code']))
	success(CodeVille::getFromCode($_POST['code']));
else if (isset($_POST['commune']))
	success(CodeVille::getFromCommune($_POST['commune']));
