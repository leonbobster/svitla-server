<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Course;

class LoadCourseData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $course = new Course(
            null,
            'PHP',
            160,
            '',
            new \DateTimeImmutable('2017-09-01')
        );

        $manager->persist($course);

        $course = new Course(
            null,
            'Java',
            180,
            '',
            new \DateTimeImmutable('2017-09-03')
        );

        $manager->persist($course);

        $manager->flush();
    }
}
