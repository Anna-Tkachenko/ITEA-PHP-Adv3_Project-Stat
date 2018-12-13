<?php
/**
 * Created by PhpStorm.
 * User: tkachenko
 * Date: 12/12/18
 * Time: 9:36 PM
 */

namespace App\ClassInfo;

use Symfony\Component\Finder\Finder;

/**
 * Analyzer that provides information about classes properties and methods.
 *
 * @author Anna Tkachenko <tkachenko.anna835@gmail.com>
 */
final class ClassInfoAnalyzer
{
    private $classInfoStorage;

    public function __construct(object $classInfoStorage)
    {
        $this->classInfoStorage = $classInfoStorage;
    }

    /**
     * Analyzes class by name.
     *
     * @param string $name Full name of class.
     * @return object Object of ClassInfoStorage with information about class properties and methods.
     */
    public function analyze(string $name): object
    {
        $fullClassName = str_replace('/', '\\', $name);

        try {
            $reflection = new \ReflectionClass($fullClassName);
        } catch (\ReflectionException $e) {
        }

        if ($reflection->isAbstract()) {
            $this->classInfoStorage->set('classType', 'Abstract');
        } elseif ($reflection->isFinal()) {
            $this->classInfoStorage->set('classType', 'Final');
        } else {
            $this->classInfoStorage->set('classType', 'Sample');;
        }

        $this->classInfoStorage->set('publicProp', count($reflection->getProperties(\ReflectionProperty::IS_PUBLIC)));
        $this->classInfoStorage->set('protectedProp', count($reflection->getProperties(\ReflectionProperty::IS_PROTECTED)));
        $this->classInfoStorage->set('privateProp', count($reflection->getProperties(\ReflectionProperty::IS_PRIVATE)));

        $static_properties = $reflection->getProperties(\ReflectionProperty::IS_STATIC);

        foreach ($static_properties as $static_property) {
            if ($static_property->isPublic()) {
                $this->classInfoStorage->setStaticProp('publicStaticProp');
            } elseif ($static_property->isProtected()) {
                $this->classInfoStorage->setStaticProp('protectedStaticProp');
            } elseif ($static_property->isPrivate()) {
                $this->classInfoStorage->setStaticProp('privateStaticProp');
            }
        }

        $this->classInfoStorage->set('publicMethods', count($reflection->getMethods(\ReflectionMethod::IS_PUBLIC)));
        $this->classInfoStorage->set('protectedMethods', count($reflection->getMethods(\ReflectionMethod::IS_PROTECTED)));
        $this->classInfoStorage->set('privateMethods', count($reflection->getMethods(\ReflectionMethod::IS_PRIVATE)));

        $static_methods = $reflection->getMethods(\ReflectionMethod::IS_STATIC);

        foreach ($static_methods as $static_method) {
            if ($static_method->isPublic()) {
                $this->classInfoStorage->setStaticProp('publicStaticMethods');
            } elseif ($static_method->isProtected()) {
                $this->classInfoStorage->setStaticProp('protectedStaticMethods');
            } elseif ($static_method->isPrivate()) {
                $this->classInfoStorage->setStaticProp('privateStaticMethods');
            }
        }

       return $this->classInfoStorage;
    }
}
