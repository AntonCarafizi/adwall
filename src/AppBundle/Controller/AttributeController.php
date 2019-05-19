<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Attribute;
use AppBundle\Form\AttributeType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AttributeController extends Controller
{
    public function showAction($attribute)
    {
        return $this->render('attribute/show.html.twig', []);
    }

    public function listAction()
    {
        $rep = $this->getDoctrine()->getRepository(Attribute::class);
        $attrs = $rep->findAll();
        return $this->render('attribute/list.html.twig', [
            'attributes' => $attrs
        ]);
    }

    public function editAction(Request $request, $id)
    {
        $rep = $this->getDoctrine()->getRepository(Attribute::class);
        $em = $this->getDoctrine()->getManager();
        $response = new Response();
        $attr = $rep->findOneBy(['id' => $id]);
        $form = $this->createForm(AttributeType::class, $attr);
        $form->get('category')->setData($attr->getCategory());
        $form->get('name')->setData($attr->getName());
        $form->get('save')->setData(['label' => 'Save Attribute']);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($attr); // tells Doctrine you want to (eventually) save the Category (no queries yet)
            $em->flush(); // actually executes the queries (i.e. the INSERT query)
            $response->setContent('Saved attribute with id ' . $attr->getId());
        }
        return $this->render('attribute/edit.html.twig', [
            'form' => $form->createView(),
            'response' => $response->getContent(),
        ]);
    }

    public function createAction(Request $request)
    {
        $rep = $this->getDoctrine()->getRepository(Attribute::class);
        $em = $this->getDoctrine()->getManager();
        $attrs = $rep->findAll();
        $attr = new Attribute();
        $response = new Response();
        $form = $this->createForm(AttributeType::class, $attr);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($attr); // tells Doctrine you want to (eventually) save the Category (no queries yet)
            $em->flush(); // actually executes the queries (i.e. the INSERT query)
            $response->setContent('Saved new attribute with id ' . $attr->getId());
            return $this->redirect($request->getUri());
        }

        return $this->render('attribute/create.html.twig', [
            'form' => $form->createView(),
            'response' => $response->getContent(),
            'attrs' => $attrs]);
    }

    public function removeAction($id)
    {
        $response = new Response();
        $em = $this->getDoctrine()->getManager();
        $attr = $em->getRepository(Attribute::class)->find($id);

        if (!$attr) {
            throw $this->createNotFoundException(
                'No attribute found for id '.$id
            );
        }

        $em->remove($attr);
        $em->flush();
        $response->setContent('Attribute with id ' . $id . ' was removed.');
        return $this->render('attribute/remove.html.twig', [
            'response' => $response->getContent()
        ]);
    }
}