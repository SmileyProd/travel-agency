<?php

namespace App\Controller;

use App\Entity\Step;
use App\Entity\Circuit;
use App\Form\StepType;
use App\Form\SearchByIDType;
use App\Repository\StepRepository;
use App\Repository\CircuitRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Step controller for the back office.
 *
 * @Route("/admin/etape")
 */
class BackOfficeStepController extends AbstractController
{
    /**
     * Get the list of all the steps within the database.
     * 
     * @Route("/", name="admin_step_index", methods="GET")
     */
    public function index(StepRepository $stepRepository): Response
    {
        return $this->render('back/step/index.html.twig', ['steps' => $stepRepository->findAll()]);
    }

    /**
     * Asks for the id of the circuit which the user wants to add a step.
     *
     * @Route("/nouveau", name="admin_step_find_circuit", methods="GET|POST")
     */
    public function findCircuitForStep(Request $request, CircuitRepository $circuitRepo): Response
    {
        $form = $this->createForm(SearchbyIDType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $id = $form->getData()['id'];
            $circuit = $circuitRepo->find($id);
            if($circuit != null) {
                return $this->redirectToRoute('admin_step_new', [
                    'id' => $id
                ]);
            }
        }
        return $this->render('/back/step/find_circuit_for_new.html.twig', [
            'form' => $form->createView()
        ]);
    }
    
    /** 
     * Create a new step.
     * 
     * The id slug gives the id of the circuit which the user wants to add a step.
     * 
     * @Route("/nouveau/{id}", name="admin_step_new", methods="GET|POST")
     */
    public function new(Circuit $circuit, Request $request): Response
    {
        $step = new Step();
        $step->setCircuit($circuit);
        
        $form = $this->createForm(StepType::class, $step);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $orderedSteps = $this->getDoctrine()->getRepository(Step::class)->findOrderedStepsByCircuit($circuit->getId());
            
            $circuit->updateStepsAndCities($orderedSteps, $step, 'insert');
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($step);
            $em->flush();

            return $this->redirectToRoute('admin_step_index');
        }

        return $this->render('back/step/new.html.twig', [
            'step' => $step,
            'form' => $form->createView(),
        ]);
    }
    
    /**
     * Render the template to find a step.
     * 
     * @Route("/find", name="admin_step_find", methods="GET")
     */
    public function find() {
        return $this->render('back/step/find.html.twig');
    }

    /**
     * Show the step given by the id slug.
     * 
     * @Route("/{id}", name="admin_step_show", methods="GET")
     */
    public function show(Step $step): Response
    {
        return $this->render('back/step/show.html.twig', ['step' => $step]);
    }

    /**
     * Edit the step given by the id slug.
     * 
     * Also edit the circuit that contains this step if the duration changed.
     * 
     * @Route("/{id}/edit", name="admin_step_edit", methods="GET|POST")
     */
    public function edit(Request $request, Step $step, ObjectManager $manager): Response
    {
        $circuit = $step->getCircuit();
        
        $form = $this->createForm(StepType::class, $step);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $orderedSteps = $this->getDoctrine()->getRepository(Step::class)->findOrderedStepsByCircuit($circuit->getId());
            
            $circuit->updateStepsAndCities($orderedSteps, $step, 'edit');

            $manager->flush();
        
            return $this->redirectToRoute('admin_step_index');
        }

        return $this->render('back/step/edit.html.twig', [
            'step' => $step,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Delete the step given by the id slug.
     * 
     * @Route("/{id}", name="admin_step_delete", methods="DELETE")
     */
    public function delete(Request $request, Step $step): Response
    {
        if ($this->isCsrfTokenValid('delete'.$step->getId(), $request->request->get('_token'))) {
            $circuit = $step->getCircuit();

            $orderedSteps = $this->getDoctrine()->getRepository(Step::class)->findOrderedStepsByCircuit($circuit->getId());
            
            $circuit->updateStepsAndCities($orderedSteps, $step, 'delete');
            
            $em = $this->getDoctrine()->getManager();
            $em->remove($step);

            $em->flush();
        }

        return $this->redirectToRoute('admin_step_index');
    }
}
