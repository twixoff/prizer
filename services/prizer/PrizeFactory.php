<?php

namespace app\services\prizer;

class PrizeFactory
{
    public static function factory($type): BasePrize
    {
        $class = 'app\\services\\prizer\\'.ucfirst($type).'Prize';
        return new $class();
    }

}