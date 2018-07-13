<?php
require_once("class/core/Ajax.php");
class AjaxOrder extends Ajax
{
    public function updateValue($data){
        if (Order::updateData($data))
            success(['data' => -"ok"]);
        else
            error("Il a tort. et le tort tue");
    }
}
