<?php

namespace AppBundle\Command;

use AppBundle\Entity\Course;
use AppBundle\Entity\Professor;
use AppBundle\Entity\User;
use Faker\Factory;
use Faker\ORM\Doctrine\Populator;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateFakeDataCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('app:generate-fake-data')
            // the short description shown while running "php bin/console list"
            ->setDescription('Generates data with Faker library.')
            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command allows you to generate a fake data ...');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $path = realpath(__DIR__ . '/../../../bin');

        passthru(sprintf('php %s/console doctrine:database:drop --force ', $path));
        passthru(sprintf('php %s/console doctrine:database:create ', $path));
        passthru(sprintf('php %s/console doctrine:schema:update --force ', $path));

        $em = $this->getContainer()->get('doctrine')->getManager();
        $generator = Factory::create();
        $populator = new Populator($generator, $em);
        $populator->addEntity(Professor::class, 50, [
            'name' => function () use ($generator) {
                return $generator->name;
            }
        ]);
        $pks = $populator->execute();

        $populator->addEntity(Course::class, 1000, [
            'title'     => function () {
                $titles = [
                    'Continuous mathematics',
                    'Design and analysis of algorithms',
                    'Digital systems',
                    'Discrete mathematics',
                    'Functional programming',
                    'Imperative programming',
                    'Introduction to formal proof',
                    'Linear algebra',
                    'Probability',
                    'Automata,logic and games',
                    'Advanced security',
                    'Categories, proofs and processes',
                    'Computational game theory',
                    'Computer animation',
                    'Concurrent algorithms and data structures',
                    'Database systems implementation',
                    'Advanced machine learning',
                    'Probabilistic model checking',
                    'Probability and computing',
                    'Quantum computer science',
                    'Program analysis',
                    'Theory of data and knowledge bases',
                ];
                return $titles[array_rand($titles)];
            },
            'professor' => function () use ($pks) {
                $professors = $pks['AppBundle\Entity\Professor'];
                return $professors[array_rand($professors)];
            },
            'cost'      => function () {
                return rand(100, 500);
            }
        ]);
        $populator->addEntity(User::class, 1, [
            'avatar' => 'https://api.adorable.io/avatars/64/abott@adorable.png'
        ]);

        $populator->execute();
    }
}
