<?php
require_once('app.php');
Cli::cli_only();
Dh::sendCompterenduToConseiller();
Dh::sendCompterenduToAssistant();
