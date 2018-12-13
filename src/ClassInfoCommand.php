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


        $output->writeln(
            \sprintf(
                'Class: %s' . \PHP_EOL .
                'Properties: ' . \PHP_EOL . 'public: %d (%d static)' . \PHP_EOL .
                'protected: %d (%d static)' . \PHP_EOL .
                'private: %d (%d static)' . \PHP_EOL .

                'Methods: ' . \PHP_EOL . 'public: %d (%d static)' . \PHP_EOL .
                'protected: %d (%d static)' . \PHP_EOL .
                'private: %d (%d static)'

                ,$classInfoStorage->get('classType'),
                $classInfoStorage->get('publicProp'),
                $classInfoStorage->get('publicStaticProp'),
                $classInfoStorage->get('protectedProp'),
                $classInfoStorage->get('protectedStaticProp'),
                $classInfoStorage->get('privateProp'),
                $classInfoStorage->get('privateStaticProp'),
                $classInfoStorage->get('publicMethods'),
                $classInfoStorage->get('publicStaticMethods'),
                $classInfoStorage->get('protectedMethods'),
                $classInfoStorage->get('protectedStaticMethods'),
                $classInfoStorage->get('privateMethods'),
                $classInfoStorage->get('privateStaticMethods')
            )
        );
    }

}
