<?php

//$this->orderlist = OrderScrapList::getAllForStore();
$tmp = OrderScrapList::getAllForStore();
$this->orderlist = [];
foreach ($tmp as $el)
{
    $el->changed = false;
    $this->orderlist[] = $el;
}