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
    private $rootDir;
    private $rootNamespace;
    private $info_storage = [];

    public function __construct(string $rootDir, string $rootNamespace)
    {
        $this->rootDir = $rootDir;
        $this->rootNamespace = $rootNamespace;
    }

    /**
     * Analyzes class by name.
     *
     * @param string $name Full name of class.
     * @return array Information about class properties and methods.
     */
    public function analyze(string $name): array
    {
        $fullClassName = $this->rootNamespace
            . '\\'
            . \str_replace('/', '\\', $name);


        try {
            $reflection = new \ReflectionClass($fullClassName);
        } catch (\ReflectionException $e) {
        }

        if ($reflection->isAbstract()) {
            $this->info_storage['class-type'] = 'Abstract';
        } elseif ($reflection->isFinal()) {
            $this->info_storage['class-type'] = 'Final';
        } else {
            $this->info_storage['class-type'] = 'Sample';
        }

        $this->info_storage['public_prop'] = count($reflection->getProperties(\ReflectionProperty::IS_PUBLIC));

        $this->info_storage['protected_prop'] = count($reflection->getProperties(\ReflectionProperty::IS_PROTECTED));

        $this->info_storage['private_prop'] = count($reflection->getProperties(\ReflectionProperty::IS_PRIVATE));

        $this->info_storage['public_static_prop'] = 0;
        $this->info_storage['protected_static_prop'] = 0;
        $this->info_storage['private_static_prop'] = 0;

        $static_properties = $reflection->getProperties(\ReflectionProperty::IS_STATIC);

        foreach ($static_properties as $static_property) {
            if ($static_property->isPublic()) {
                $this->info_storage['public_static_prop']++;
            } elseif ($static_property->isProtected()) {
                $this->info_storage['protected_static_prop']++;
            } elseif ($static_property->isPrivate()) {
                $this->info_storage['private_static_prop']++;
            }
        }

        $this->info_storage['public_methods'] = count($reflection->getMethods(\ReflectionMethod::IS_PUBLIC));

        $this->info_storage['protected_methods'] = count($reflection->getMethods(\ReflectionMethod::IS_PROTECTED));

        $this->info_storage['private_methods'] = count($reflection->getMethods(\ReflectionMethod::IS_PRIVATE));

        $this->info_storage['public_static_methods'] = 0;
        $this->info_storage['protected_static_methods'] = 0;
        $this->info_storage['private_static_methods'] = 0;

        $static_methods = $reflection->getMethods(\ReflectionMethod::IS_STATIC);

        foreach ($static_methods as $static_method) {
            if ($static_method->isPublic()) {
                $this->info_storage['public_static_methods']++;
            } elseif ($static_method->isProtected()) {
                $this->info_storage['protected_static_methods']++;
            } elseif ($static_method->isPrivate()) {
                $this->info_storage['private_static_methods']++;
            }
        }

        return $this->info_storage;
    }
}
