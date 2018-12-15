<?php
/**
 * Created by PhpStorm.
 * User: tkachenko
 * Date: 12/12/18
 * Time: 9:36 PM
 */

namespace App;

use App\ClassInfo\ClassInfoAnalyzer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command for getting information about Class
 * (types and amount of properties and methods).
 *
 * Example of usage
 * ./bin/console stat:class-info App/Author/ClassAuthorAnalyzer
 *
 * @author Anna Tkachenko <tkachenko.anna835@gmail.com>
 */
final class ClassInfoCommand extends Command
{
    private $analyzer;

    /**
     * {@inheritdoc}
     */
    public function __construct(ClassInfoAnalyzer $analyzer, string $name = null)
    {
        $this->analyzer = $analyzer;

        parent::__construct($name);
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('stat:class-info')
            ->setDescription('Shows information about class properties and methods')
            ->addArgument(
                'class-name',
                InputArgument::REQUIRED,
                'Full name of needed class'
            )
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('class-name');

        $classInfoStorage = $this->analyzer->analyze($name);

        $content = '';

        $content .= 'Class: ';
        $classType = $classInfoStorage->getClassType();
        switch (true) {
            case $classType === $classInfoStorage::IS_ABSTRACT:
                $content .= "abstract\n";
                break;
            case $classType === $classInfoStorage::IS_FINAL:
                $content .= "final\n";
                break;
            default:
                $content .= "sample\n";
                break;
        }

        $content .= "Properties: \n";
        $content .= "\tpublic: " . $classInfoStorage->getPublicProp();
        if($classInfoStorage->getPublicStaticProp()){
            $content .= "(static: " . $classInfoStorage->getPublicStaticProp() . ")";
        }
        $content .= "\n\tprotected: " . $classInfoStorage->getProtectedProp();
        if($classInfoStorage->getProtectedStaticProp()){
            $content .= "(static: " . $classInfoStorage->getProtectedStaticProp() . ")";
        }
        $content .= "\n\tprivate: " . $classInfoStorage->getPrivateProp();
        if($classInfoStorage->getPublicStaticProp()){
            $content .= "(static: " . $classInfoStorage->getPrivateStaticProp() . ")";
        }

        $content .= "\nMethods: \n";
        $content .= "\tpublic: " . $classInfoStorage->getPublicMethods();
        if($classInfoStorage->getPublicStaticMethods()){
            $content .= "(static: " . $classInfoStorage->getPublicStaticMethods() . ")";
        }
        $content .= "\n\tprotected: " . $classInfoStorage->getProtectedMethods();
        if($classInfoStorage->getProtectedStaticMethods()){
            $content .= "(static: " . $classInfoStorage->getProtectedStaticMethods() . ")";
        }
        $content .= "\n\tprivate: " . $classInfoStorage->getPrivateMethods();
        if($classInfoStorage->getPublicStaticMethods()){
            $content .= "(static: " . $classInfoStorage->getPrivateStaticMethods() . ")";
        }

        $output->writeln($content);
    }

}
