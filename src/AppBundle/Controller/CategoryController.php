<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    public function showAction($category)
    {
        return $this->render('category/show.html.twig', []);
    }

    public function listAction()
    {
        $rep = $this->getDoctrine()->getRepository(Category::class);
        $categories = $rep->findAll();
        return $this->render('category/list.html.twig', [
            'categories' => $categories
        ]);
    }

    public function editAction(Request $request, $id)
    {
        $rep = $this->getDoctrine()->getRepository(Category::class);
        $em = $this->getDoctrine()->getManager();
        $response = new Response();
        $category = $rep->findOneBy(['id' => $id]);
        $form = $this->createForm(CategoryType::class, $category);
        $form->get('parent')->setData($category->getParent());
        $form->get('name')->setData($category->getName());
        $form->get('save')->setData(['label' => 'Save Category']);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($category); // tells Doctrine you want to (eventually) save the Category (no queries yet)
            $em->flush(); // actually executes the queries (i.e. the INSERT query)
            $response->setContent('Saved category with id ' . $category->getId());
        }
        return $this->render('category/edit.html.twig', [
            'form' => $form->createView(),
            'response' => $response->getContent(),
        ]);
    }

    public function createAction(Request $request)
    {
        $rep = $this->getDoctrine()->getRepository(Category::class);
        $em = $this->getDoctrine()->getManager();
        $categories = $rep->findAll();
        $category = new Category();
        $response = new Response();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($category); // tells Doctrine you want to (eventually) save the Category (no queries yet)
            $em->flush(); // actually executes the queries (i.e. the INSERT query)
            $response->setContent('Saved new category with id ' . $category->getId());
            return $this->redirect($request->getUri());
        }

        return $this->render('category/create.html.twig', [
            'form' => $form->createView(),
            'response' => $response->getContent(),
            'categories' => $categories]);
    }

    public function removeAction($id)
    {
        $response = new Response();
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository(Category::class)->find($id);

        if (!$category) {
            throw $this->createNotFoundException(
                'No category found for id '.$id
            );
        }

        $em->remove($category);
        $em->flush();
        $response->setContent('Category with id ' . $id . ' was removed.');
        return $this->render('category/remove.html.twig', [
            'response' => $response->getContent()
        ]);
    }

}