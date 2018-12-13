<?php
/**
 * Created by PhpStorm.
 * User: tkachenko
 * Date: 12/13/18
 * Time: 3:21 PM
 */

namespace App\ClassInfo;


class ClassInfoStorage
{
    private $classType;
    private $publicProp;
    private $publicStaticProp;
    private $protectedProp;
    private $protectedStaticProp;
    private $privateProp;
    private $privateStaticProp;
    private $publicMethods;
    private $publicStaticMethods;
    private $protectedMethods;
    private $protectedStaticMethods;
    private $privateMethods;
    private $privateStaticMethods;

    public function set(string $name,  $value)
    {
        $this->$name = $value;
    }

    public function setStaticProp(string $name)
    {
        $this->$name++;
    }

    public function get(string $name)
    {
        return $this->$name;
    }
}