<?php
require_once("app.php");
HistoriqueStats::createNew(StatClients::regenerateCacheStats());
