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
     * @param Request  $request
     * @param int|null $id
     *
     * @return array|View|null|object
     */
    public function getAction(Request $request, int $id = null)
    {
        $result = $id
            ? $this->getOne($id)
            : $this->getAll($request);
        if ($result === null) {
            return new View("there are no courses exist", Response::HTTP_NOT_FOUND);
        }

        return $result;
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    private function getAll(Request $request): array
    {
        $order = $request->get('order');
        $limit = $request->get('limit');
        $offset = $request->get('offset');
        $criteria = [];

        /** @var CourseRepository $repository */
        $repository = $this->getDoctrine()->getRepository('AppBundle:Course');
        $items = $repository->findBy($criteria, $order, $limit, $offset);
        $total = $repository->countBy($criteria);

        return [
            'total' => $total,
            'items' => $items
        ];
    }

    /**
     * @param int $id
     *
     * @return null|object
     */
    private function getOne(int $id)
    {
        return $this->getDoctrine()
            ->getRepository('AppBundle:Course')
            ->find($id);
    }
}
