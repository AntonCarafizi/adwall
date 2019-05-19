<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function showAction($user)
    {
        return $this->render('user/show.html.twig', []);
    }

    public function listAction()
    {
        return $this->render('user/list.html.twig', []);
    }

    public function editAction($user)
    {
        return $this->render('user/edit.html.twig', []);
    }

    public function createAction()
    {
        return $this->render('user/create.html.twig', []);
    }

    public function removeAction($id)
    {
        $response = new Response();
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->find($id);

        if (!$user) {
            throw $this->createNotFoundException(
                'No user found for id '.$id
            );
        }

        $em->remove($user);
        $em->flush();
        $response->setContent('User with id ' . $id . ' was removed.');
        return $this->render('user/remove.html.twig', [
            'response' => $response->getContent()
        ]);
    }
}