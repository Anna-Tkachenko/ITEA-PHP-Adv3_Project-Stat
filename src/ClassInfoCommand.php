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
 * ./bin/console stat:class-info Author/ClassAuthorAnalyzer
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

        $class_info = $this->analyzer->analyze($name);

        if (!($class_info == null)) {
            $output->writeln(
                \sprintf(
                    'Class: %s' . \PHP_EOL .
                    'Properties: ' . \PHP_EOL . 'public: %d (%d static)' . \PHP_EOL .
                    'protected: %d (%d static)' . \PHP_EOL .
                    'private: %d (%d static)' . \PHP_EOL .

                    'Methods: ' . \PHP_EOL . 'public: %d (%d static)' . \PHP_EOL .
                    'protected: %d (%d static)' . \PHP_EOL .
                    'private: %d (%d static)'

                    ,$class_info['class-type'],
                    $class_info['public_prop'],
                    $class_info['public_static_prop'],
                    $class_info['protected_prop'],
                    $class_info['protected_static_prop'],
                    $class_info['private_prop'],
                    $class_info['private_static_prop'],
                    $class_info['public_methods'],
                    $class_info['public_static_methods'],
                    $class_info['protected_methods'],
                    $class_info['protected_static_methods'],
                    $class_info['private_methods'],
                    $class_info['private_static_methods']
                )
            );
        } else {
            $output->writeln(
                \sprintf('Undefined class name.')
            );
        }
    }
}
