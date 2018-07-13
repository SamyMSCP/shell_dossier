<?php
require_once("app.php");
Cli::cli_only();
//print_r(AutoTask::getFromId(1)[0]->executeSpot());
AutoTask::executeSpots();
AutoTask::executeRegular();
