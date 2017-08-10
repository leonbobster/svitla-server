<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Course;
use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;

class UserController extends FOSRestController
{
    /**
     * @Rest\Get("/user/{id}")
     *
     * @param int|null $id
     *
     * @return array|View|null|object
     */
    public function getAction(int $id = null)
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:User');
        $result = $id
            ? $repository->find($id)
            : $repository->findAll();
        if ($result === null) {
            return new View("there are no courses exist", Response::HTTP_NOT_FOUND);
        }
        return $result;
    }

    /**
     * @Rest\Put("/user/{id}")
     *
     * @param Request $request
     * @param int     $id
     *
     * @return User
     */
    public function updateAction(Request $request, int $id)
    {
        $body = json_decode($request->getContent(), true);
        $courseId = $body['courses'][0]['id']; /* yes I know, it's too optimistic */
        /** @var Course $course */
        $course = $this->getDoctrine()
            ->getRepository('AppBundle:Course')
            ->find($courseId);
        /** @var User $user */
        $user = $this->getDoctrine()
            ->getRepository('AppBundle:User')
            ->find($id);
        if ($user->enroll($course)) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
        }
        return $user;
    }
}
