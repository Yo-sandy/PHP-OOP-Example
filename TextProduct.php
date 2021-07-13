<?php
    include_once "Product.php";

class TextProduct implements Product
{

    public function getProperties()
    {
       return "this is Text Product ";
    }
}