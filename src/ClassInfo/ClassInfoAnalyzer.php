<?php
/**
 * Created by PhpStorm.
 * User: tkachenko
 * Date: 12/12/18
 * Time: 9:36 PM
 */

namespace App\ClassInfo;

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
            throw new \LogicException(
                \sprintf("Invalid class name '%s' ", $name)
            );
        }

        $this->analyzeClassType($reflection);
        $this->analyzeClassProps($reflection);
        $this->analyzeClassMethods($reflection);

        return $this->classInfoStorage;
    }

    private function analyzeClassType(\ReflectionClass $reflection)
    {
        if ($reflection->isAbstract()) {
            $this->classInfoStorage->set('classType', 1);
        } elseif ($reflection->isFinal()) {
            $this->classInfoStorage->set('classType', 2);
        } else {
            $this->classInfoStorage->set('classType', 3);;
        }
    }

    private function analyzeClassProps(\ReflectionClass $reflection)
    {
        $this->analyzePublicProps($reflection);
        $this->analyzeProtectedProps($reflection);
        $this->analyzePrivateProps($reflection);
        $this->analyzeStaticProps($reflection);
    }

    private function analyzeClassMethods(\ReflectionClass $reflection)
    {
        $this->analyzePublicMethods($reflection);
        $this->analyzeProtectedMethods($reflection);
        $this->analyzePrivateMethods($reflection);
        $this->analyzeStaticMethods($reflection);
    }

    private function analyzePublicProps(\ReflectionClass $reflection){
        $num = count($reflection->getProperties(\ReflectionProperty::IS_PUBLIC));
        $this->classInfoStorage->set('publicProp', $num);
    }

    private function analyzeProtectedProps(\ReflectionClass $reflection){
        $num = count($reflection->getProperties(\ReflectionProperty::IS_PROTECTED));
        $this->classInfoStorage->set('protectedProp', $num);
    }

    private function analyzePrivateProps(\ReflectionClass $reflection){
        $num = count($reflection->getProperties(\ReflectionProperty::IS_PRIVATE));
        $this->classInfoStorage->set('privateProp', $num);
    }

    private function analyzeStaticProps(\ReflectionClass $reflection)
    {
        $this->analyzePublicStaticProps($reflection);
        $this->analyzeProtectedStaticProps($reflection);
        $this->analyzePrivateStaticProps($reflection);
    }

    private function analyzePublicStaticProps(\ReflectionClass $reflection)
    {
        $num = count($reflection->getProperties(\ReflectionProperty::IS_PUBLIC | \ReflectionProperty::IS_STATIC));
        $this->classInfoStorage->set('publicStaticProp', $num);
    }

    private function analyzeProtectedStaticProps(\ReflectionClass $reflection)
    {
        $num = count($reflection->getProperties(\ReflectionProperty::IS_PROTECTED | \ReflectionProperty::IS_STATIC));
        $this->classInfoStorage->set('protectedStaticProp', $num);
    }

    private function analyzePrivateStaticProps(\ReflectionClass $reflection)
    {
        $num = count($reflection->getProperties(\ReflectionProperty::IS_PRIVATE | \ReflectionProperty::IS_STATIC));
        $this->classInfoStorage->set('privateStaticProp', $num);
    }

    private function analyzePublicMethods(\ReflectionClass $reflection){
        $num = count($reflection->getMethods(\ReflectionMethod::IS_PUBLIC));
        $this->classInfoStorage->set('publicMethods', $num);
    }

    private function analyzeProtectedMethods(\ReflectionClass $reflection){
        $num = count($reflection->getMethods(\ReflectionMethod::IS_PROTECTED));
        $this->classInfoStorage->set('protectedMethods', $num);
    }

    private function analyzePrivateMethods(\ReflectionClass $reflection){
        $num = count($reflection->getMethods(\ReflectionMethod::IS_PRIVATE));
        $this->classInfoStorage->set('privateMethods', $num);
    }

    private function analyzeStaticMethods(\ReflectionClass $reflection)
    {
        $this->analyzePublicStaticMethods($reflection);
        $this->analyzeProtectedStaticMethods($reflection);
        $this->analyzePrivateStaticMethods($reflection);
    }

    private function analyzePublicStaticMethods(\ReflectionClass $reflection)
    {
        $num = count($reflection->getMethods(\ReflectionMethod::IS_PUBLIC | \ReflectionMethod::IS_STATIC));
        $this->classInfoStorage->set('publicStaticMethods', $num);
    }

    private function analyzeProtectedStaticMethods(\ReflectionClass $reflection)
    {
        $num = count($reflection->getMethods(\ReflectionMethod::IS_PROTECTED | \ReflectionMethod::IS_STATIC));
        $this->classInfoStorage->set('protectedStaticMethods', $num);
    }

    private function analyzePrivateStaticMethods(\ReflectionClass $reflection)
    {
        $num = count($reflection->getMethods(\ReflectionMethod::IS_PRIVATE | \ReflectionMethod::IS_STATIC));
        $this->classInfoStorage->set('privateStaticMethods', $num);
    }
}
