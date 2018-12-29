<?php

namespace App\Controller;

use App\Entity\Step;
use App\Entity\Circuit;
use App\Form\CircuitType;
use App\Repository\StepRepository;
use App\Repository\CircuitRepository;
use App\Repository\CircuitProgramRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Circuit controller for the back office.
 * 
 * @Route("/admin/circuit")
 */
class BackOfficeCircuitController extends AbstractController
{
    /**
     * Get the list of all circuits within the database.
     * 
     * @Route("/", name="admin_circuit_index", methods="GET")
     */
    public function index(CircuitRepository $circuitRepository): Response
    {
        return $this->render('back/circuit/index.html.twig', ['circuits' => $circuitRepository->findAll()]);
    }

    /**
     * Create a new circuit.
     * 
     * @Route("/nouveau", name="admin_circuit_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $circuit = new Circuit();
        $form = $this->createForm(CircuitType::class, $circuit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($circuit);
            $em->flush();
            $this->addFlash(
                'success',
                'Le circuit ' . $circuit->getId() . ' a été créé!'
            );
            return $this->redirectToRoute('admin_circuit_index');
        }
        $circuit->orderSteps();
        $circuit->orderPrograms();
        return $this->render('back/circuit/new.html.twig', [
            'circuit' => $circuit,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Render the template to find circuit.
     * 
     * @Route("/trouver", name="admin_circuit_find", methods="GET|POST")
     */
    public function find(CircuitRepository $circuitRepo) {
        $circuitPrototype = new Circuit();

        $form = $this->createForm(FindCircuitType::class, $circuitPrototype);
        $form->handleRequest();

        if ($form->isSubmitted() && $form->isValid()) {
            $circuit;
        }

        return $this->render('back/circuit/find.html.twig', [

        ]);
    }

    /**
     * Show the circuit given by the id slug.
     * 
     * @Route("/{id}", name="admin_circuit_show", methods="GET", requirements={"id"="\d+"})
     */
    public function show(Circuit $circuit, CircuitProgramRepository $programRepo, StepRepository $stepRepo): Response
    {
        return $this->render('back/circuit/show.html.twig', [
            'circuit' => $circuit,
            'steps' => $stepRepo->findOrderedStepsByCircuit($circuit->getId()),
            'programs' => $programRepo->findValidProgramsByCircuit($circuit->getId()),
            ]);
    }

    /**
     * Edit the circuit given by the id slug.
     * 
     * @Route("/{id}/edit", name="admin_circuit_edit", methods="GET|POST", requirements={"id"="\d+"})
     */
    public function edit(Request $request, Circuit $circuit, CircuitProgramRepository $programRepo, StepRepository $stepRepo): Response
    {
        $form = $this->createForm(CircuitType::class, $circuit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash(
                'success',
                'Le circuit ' . $circuit->getId() . ' a été mis à jour!'
            );
            return $this->redirectToRoute('admin_circuit_index');
        }

        $circuit->orderSteps();
        $circuit->orderPrograms();
        return $this->render('back/circuit/edit.html.twig', [
            'circuit' => $circuit,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Delete the circuit given by the id slug.
     * 
     * @Route("/{id}", name="admin_circuit_delete", methods="DELETE", requirements={"id"="\d+"})
     */
    public function delete(Request $request, Circuit $circuit): Response
    {
        if ($this->isCsrfTokenValid('delete'.$circuit->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($circuit);
            $em->flush();
            $this->addFlash(
                'success',
                'Le circuit ' . $circuit->getId() . ' a été supprimé!'
            );
        }

        return $this->redirectToRoute('admin_circuit_index');
    }

    /**
     * Return the circuit given by the id slug in a JSON format
     * 
     * @Route("/json/")
     * @Route("/json/{id}", name="admin_circuit_json", methods="GET", requirements={"id"="\d+"})
     */
    public function returnJsonCircuit($id = 0, CircuitRepository $circuitRepo) {
        $circuit = $circuitRepo->find($id);
        if($circuit === null)  {
            return $this->json(['code' => '404', 'message' => 'Circuit not found'], 404);
        }
        return new JsonResponse($circuit);
    }
}
