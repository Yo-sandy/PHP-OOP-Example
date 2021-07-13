<?php
include_once "nortRegion.php";
include_once "westRegion.php";

class Client {
    public function  __construct(){
        $north = new northRegion();
        $west = new westRegion();
        $this->showInterface($north);
        $this->showInterface($west);
    }
    private function showInterface(IAbstract $region){
        echo $region->displayShow() . "<br/>";
    }
}
$worker = new  Client();