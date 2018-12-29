<?php

namespace App\Controller;

use App\Entity\Circuit;
use App\Entity\CircuitProgram;
use App\Form\CircuitProgramType;
use App\Form\SearchByIDType;
use App\Repository\CircuitRepository;
use App\Repository\CircuitProgramRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/programmation")
 */
class BackOfficeCircuitProgramController extends AbstractController
{
    /**
     * List all the programs within the database.
     * 
     * @Route("/", name="admin_program_index", methods="GET")
     */
    public function index(CircuitProgramRepository $circuitProgramRepository): Response
    {
        return $this->render('/back/program/index.html.twig', [
            'circuit_programs_valids' => $circuitProgramRepository->findAllValidPrograms(),
            'circuit_programs_invalids' => $circuitProgramRepository->findAllInvalidPrograms() ]);
    }
    /**
     * Asks for the id of the circuit which the user wants to add a program.
     *
     * @Route("/nouveau", name="admin_program_find_circuit", methods="GET|POST")
     */
    public function findCircuitForProgram(Request $request, CircuitRepository $circuitRepo): Response
    {
        $form = $this->createForm(SearchbyIDType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $id = $form->getData()['id'];
            $circuit = $circuitRepo->find($id);
            if($circuit != null) {
                return $this->redirectToRoute('admin_program_new', [
                    'id' => $id
                ]);
            }
        }
        return $this->render('/back/program/find_circuit_for_new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Create a new program.
     * 
     * @Route("/nouveau/{id}", name="admin_program_new", methods="GET|POST", requirements={"id"="\d+"})
     */
    public function new(Circuit $circuit, Request $request): Response
    {
        $circuitProgram = new CircuitProgram();
        $circuitProgram->setCircuit($circuit);
        $form = $this->createForm(CircuitProgramType::class, $circuitProgram);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $circuitProgram->setCircuit($circuit);
            $em = $this->getDoctrine()->getManager();
            $em->persist($circuitProgram);
            $em->flush();
            $this->addFlash(
                'success',
                'La programmation du circuit ' . $circuitProgram->getCircuit() . ' a été créée!'
            );

            return $this->redirectToRoute('admin_program_index');
        }

        return $this->render('/back/program/new.html.twig', [
            'circuit_program' => $circuitProgram,
            'form' => $form->createView(),
        ]);
    }
    
    /**
     * Render the template to find a program.
     * 
     * @Route("/find", name="admin_program_find", methods="GET")
     */
    public function find() {
        return $this->render('back/program/find_by_id.html.twig');
    }

    /**
     * Show a program given by the id slug.
     * 
     * @Route("/{id}", name="admin_program_show", methods="GET")
     */
    public function show(CircuitProgram $circuitProgram): Response
    {
        return $this->render('/back/program/show.html.twig', ['circuit_program' => $circuitProgram]);
    }

    /**
     * Edit a program given by the id slug.
     * 
     * @Route("/{id}/edit", name="admin_program_edit", methods="GET|POST", requirements={"id"="\d+"})
     */
    public function edit(Request $request, CircuitProgram $circuitProgram): Response
    {
        $circuit = $circuitProgram->getCircuit();
        $form = $this->createForm(CircuitProgramType::class, $circuitProgram);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash(
                'success',
                'La programmation a été mise à jour!'
            );

            return $this->redirectToRoute('admin_program_index');
        }   

        return $this->render('/back/program/edit.html.twig', [
            'circuit_program' => $circuitProgram,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Delete a program given by the id slug.
     * 
     * @Route("/{id}", name="admin_program_delete", methods="DELETE", requirements={"id"="\d+"})
     */
    public function delete(Request $request, CircuitProgram $circuitProgram): Response
    {
        if ($this->isCsrfTokenValid('delete'.$circuitProgram->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($circuitProgram);
            $em->flush();
            $this->addFlash(
                'success',
                'La programmation a été supprimé!'
            );
        }

        return $this->redirectToRoute('admin_program_index');
    }
}
