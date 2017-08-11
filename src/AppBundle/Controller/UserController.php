<?php

namespace AppBundle\Controller;

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
     * @Rest\Put("/user/{userId}/enroll/{courseId}")
     *
     * @param int $userId
     * @param int $courseId
     *
     * @return User
     */
    public function enrollAction(int $userId, int $courseId)
    {
        $em = $this->getDoctrine()->getManager();
        $course = $em->getReference('AppBundle:Course', $courseId);
        /** @var User $user */
        $user = $em->getReference('AppBundle:User', $userId);

        if ($user->enroll($course)) {
            $em->persist($user);
            $em->flush();
        }

        return $user;
    }
}
