<?php

namespace App\Controller;

use App\Entity\CircuitCategory;
use App\Form\CircuitCategoryType;
use App\Repository\CircuitCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/categorie")
 */
class BackOfficeCategoryController extends AbstractController
{
    /**
     * Displays the list of categories
     * 
     * @Route("/", name="admin_category_index", methods="GET")
     */
    public function index(CircuitCategoryRepository $circuitCategoryRepository): Response
    {
        return $this->render('/back/category/index.html.twig', ['circuit_categories' => $circuitCategoryRepository->findAll()]);
    }

    /**
     * Create a new category
     * 
     * @Route("/nouvelle", name="admin_category_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $circuitCategory = new CircuitCategory();
        $form = $this->createForm(CircuitCategoryType::class, $circuitCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($circuitCategory);
            $em->flush();
            $this->addFlash(
                'success',
                'La catégorie ' . $circuitCategory->getName() . ' a été créée!'
            );

            return $this->redirectToRoute('admin_category_index');
        }

        return $this->render('/back/category/new.html.twig', [
            'circuit_category' => $circuitCategory,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Show the category given by the id slug
     * 
     * @Route("/{id}", name="admin_category_show", methods="GET")
     */
    public function show(CircuitCategory $circuitCategory): Response
    {
        return $this->render('/back/category/show.html.twig', ['circuit_category' => $circuitCategory]);
    }

    /**
     * Edit the category given by the id slug
     * 
     * @Route("/{id}/editer", name="admin_category_edit", methods="GET|POST")
     */
    public function edit(Request $request, CircuitCategory $circuitCategory): Response
    {
        $form = $this->createForm(CircuitCategoryType::class, $circuitCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash(
                'success',
                'La catégorie ' . $circuitCategory->getName() . ' a été mise à jour!'
            );
            return $this->redirectToRoute('admin_category_index', ['id' => $circuitCategory->getId()]);
        }

        return $this->render('/back/category/edit.html.twig', [
            'circuit_category' => $circuitCategory,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Delete the category given by the id slug
     * 
     * @Route("/{id}", name="admin_category_delete", methods="DELETE")
     */
    public function delete(Request $request, CircuitCategory $circuitCategory): Response
    {
        if ($this->isCsrfTokenValid('delete'.$circuitCategory->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();

            foreach($circuitCategory->getCircuits() as $circuit) {
                $circuit->setCategory(null);
            }
            
            $em->remove($circuitCategory);
            $em->flush();
            $this->addFlash(
                'success',
                'La catégorie ' . $circuitCategory->getName() . ' a été supprimée!'
            );
        }

        return $this->redirectToRoute('admin_category_index');
    }
}
