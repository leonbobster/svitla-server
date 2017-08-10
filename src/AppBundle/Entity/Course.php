<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CourseRepository")
 * @ORM\Table(name="course")
 */
class Course
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    private $cost;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="Professor")
     * @ORM\JoinColumn(name="professor_id", referencedColumnName="id")
     */
    private $professor;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $startsOn;

    /**
     * Course constructor.
     *
     * @param int|null               $id
     * @param string|null            $title
     * @param float|null             $cost
     * @param string|null            $description
     * @param DateTimeImmutable|null $startsOn
     * @param Professor|null         $professor
     */
    public function __construct(
        int $id = null,
        string $title = null,
        float $cost = null,
        string $description = null,
        DateTimeImmutable $startsOn = null,
        Professor $professor = null
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->cost = $cost;
        $this->description = $description;
        $this->startsOn = $startsOn;
        $this->professor = $professor;
    }
}
