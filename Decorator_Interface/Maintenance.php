<?php


class Maintenance extends Decorator
{
    public function __construct(IComponent $siteNow)
    {
        $this->site = $siteNow;
    }

    public function getSite()
    {
        $fmat = "<br>&nbsp;&nbsp; maintenance";
        return $this->site->getSite() .$fmat;
    }

    public function getPrice()
    {
        return 950 + $this->site->getPrice();
    }
}