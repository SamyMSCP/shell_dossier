<?php

define("ACCESS_OWNER", "ACCESS_OWNER");

function ACCESS_OWNER($instance) {
	if (empty(DonneurDOrdre::getCurrent()) || empty($instance->getDh()))
		return (false);
	return (DonneurDOrdre::getCurrent()->getId() === $instance->getDh()->getId());
}

define("ACCESS_SERVER", "ACCESS_SERVER");
function ACCESS_SERVER($instance) { return (php_sapi_name() == "cli"); }

define("ACCESS_ALL_LOCAL", "ACCESS_ALL_LOCAL");
function ACCESS_ALL_LOCAL($instance) { return (true); return (isLocal()); }

define("ACCESS_ALL_PREPROD", "ACCESS_ALL_PREPROD");
function ACCESS_ALL_PREPROD($instance) { return (isPreprod()); }

define("ACCESS_ALL_NOPROD", "ACCESS_ALL_NOPROD");
function ACCESS_ALL_NOPROD($instance) { return (!isProd()); }

define("ACCESS_PUBLIC", "ACCESS_PUBLIC");
function ACCESS_PUBLIC($instance) { return (true); }

define("ACCESS_EMPTY", "ACCESS_EMPTY");
function ACCESS_EMPTY($instance) { return (empty($instance->getId())); }

define("ACCESS_TEST", "ACCESS_TEST");
function ACCESS_TEST($instance) { return ($instance->getId() % 2); }
