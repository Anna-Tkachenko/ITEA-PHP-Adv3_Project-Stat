<?php
/**
 * Created by PhpStorm.
 * User: tkachenko
 * Date: 12/13/18
 * Time: 3:21 PM
 */

namespace App\ClassInfo;


class ClassInfoModel
{
    public CONST IS_ABSTRACT  = 1;
    public CONST IS_FINAL = 2;
    public CONST IS_SAMPLE = 3;

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
        if(property_exists(ClassInfoModel::class,$name)){
            $this->$name = $value;
        } else {
            throw new \LogicException(
                \sprintf("Property '%s' does not exists in class %s", $name, self::class)
            );
        }

    }

    public function setIncrementStaticProp(string $name)
    {
        $this->$name++;
    }

    public function get(string $name)
    {
        return $this->$name;
    }

    public function getClassType()
    {
        return $this->classType;
    }

    public function getPublicProp()
    {
        return $this->publicProp;
    }

    public function getPublicStaticProp()
    {
        return $this->publicStaticProp;
    }

    public function getProtectedProp()
    {
        return $this->protectedProp;
    }

    public function getProtectedStaticProp()
    {
        return $this->protectedStaticProp;
    }

    public function getPrivateProp()
    {
        return $this->privateProp;
    }

    public function getPrivateStaticProp()
    {
        return $this->privateStaticProp;
    }

    public function getPublicMethods()
    {
        return $this->publicMethods;
    }

    public function getPublicStaticMethods()
    {
        return $this->publicStaticMethods;
    }

    public function getProtectedMethods()
    {
        return $this->protectedMethods;
    }

    public function getProtectedStaticMethods()
    {
        return $this->protectedStaticMethods;
    }

    public function getPrivateMethods()
    {
        return $this->privateMethods;
    }

    public function getPrivateStaticMethods()
    {
        return $this->privateStaticMethods;
    }
}