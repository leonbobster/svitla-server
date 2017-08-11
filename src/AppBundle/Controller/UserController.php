<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;

class UserController extends FOSRestController
{
    /**
     * @Rest\Get("/user/{id}")
     *
     * @param int $id
     *
     * @return View|null|object
     */
    public function getOneAction(int $id)
    {
        $result = $this->userRepository()->find($id);
        if ($result === null) {
            return new View("there are no courses exist", Response::HTTP_NOT_FOUND);
        }
        return $result;
    }

    /**
     * @Rest\Get("/user")
     *
     * @return array|View|null|object
     */
    public function getAllAction()
    {
        $result = $this->userRepository()->findAll();
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

    /**
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    private function userRepository()
    {
        return $this->getDoctrine()->getRepository('AppBundle:User');
    }
}
