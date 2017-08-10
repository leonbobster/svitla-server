<?php

namespace Tests\AppBundle\Repository;

use AppBundle\Repository\CourseRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use AppBundle\Entity\Course;
use DateTimeImmutable;

class CourseRepositoryTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        self::bootKernel();

        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        passthru(sprintf(
            'php %s/console doctrine:fixtures:load --no-interaction --quiet --env=test ',
            CONSOLE_PATH
        ));
    }

    public function testCountBy()
    {
        /** @var CourseRepository $repository */
        $repository = $this->em->getRepository(Course::class);

        $this->assertEquals(2, $repository->countBy([]), 'empty criteria');
        $this->assertEquals(
            1,
            $repository->countBy(['startsOn' => new DateTimeImmutable('2017-09-03')]),
            'by date'
        );
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();

        $this->em->close();
        $this->em = null; // avoid memory leaks
    }
}
