<?php
include_once "IAbstract.php";

class westRegion extends IAbstract{
    protected function giveCost()
    {
        $solarSaving = 2;
        $this->valueNow = 210.54/$solarSaving;
        return $this->valueNow;
    }
    protected function giveCity()
    {
        return "Manjeet Yadav";
    }
}
