<?php

namespace AppBundle\Controller;

use AppBundle\Repository\CourseRepository;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;

class CourseController extends FOSRestController
{
    /**
     * @Rest\Get("/course/{id}")
     *
     * @param int $id
     *
     * @return array|View|null|object
     */
    public function getOneAction(int $id)
    {
        $result = $this->courseRepository()->find($id);
        if ($result === null) {
            return new View("there are no courses exist", Response::HTTP_NOT_FOUND);
        }

        return $result;
    }

    /**
     * @Rest\Get("/course")
     *
     * @param Request $request
     *
     * @return array
     */
    public function getAllAction(Request $request): array
    {
        $order = $request->get('order');
        $limit = $request->get('limit');
        $offset = $request->get('offset');
        $criteria = [];

        $qb = $this->courseRepository()->createQueryBuilder('course');
        $items = $qb->leftJoin('course.professor', 'professor')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->orderBy(key($order), $order[key($order)])
            ->getQuery()
            ->execute();

        $total = $this->courseRepository()->countBy($criteria);

        return [
            'total' => $total,
            'items' => $items
        ];
    }

    /**
     * @return CourseRepository
     */
    private function courseRepository()
    {
        return $this->getDoctrine()->getRepository('AppBundle:Course');
    }
}
