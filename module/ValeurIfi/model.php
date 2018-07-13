<?php
$data = $this->dh->getCacheArrayTable();

// Tri des clés du tableau (nom SCPI) par ordre alphabétique
ksort($data, SORT_NATURAL);
