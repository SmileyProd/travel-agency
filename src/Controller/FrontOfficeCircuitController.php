<?php

namespace App\Controller;

use App\Entity\Circuit;
use App\Repository\StepRepository;
use App\Repository\CircuitRepository;
use App\Repository\CircuitProgramRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Circuit controller for the front office.
 */
class FrontOfficeCircuitController extends AbstractController
{
    /**
     * Show circuits.
     * 
     * @Route("/nos-circuits", name="front_circuits", methods="GET")
     */
    public function indexCircuits(CircuitRepository $circuitRepo) {
        $circuits = $circuitRepo->findAll();
        return $this->render('front/circuits.html.twig', [
            'circuits' => $circuits
        ]);
    }


    /**
     * Show all the programs.
     * 
     * @Route("/nos-programmes", name="front_programs", methods="GET")
     */
    public function indexPrograms(CircuitProgramRepository $circuitProgramRepo)
    {
        $circuitsPrograms = $circuitProgramRepo->findAllValidProgramsOrderedByDate();

        return $this->render('front/circuit_programs.html.twig', [
            'circuitsPrograms' => $circuitsPrograms,
        ]);
    }

    /**
     * Finds and displays a circuit entity.
     *
     * @Route("/circuit/{id}", name="front_circuit_show", methods="GET", requirements={"id" = "\d+"})
     */
    public function showCircuit(Circuit $circuit = null, CircuitRepository $circuitRepo, StepRepository $stepRepo, CircuitProgramRepository $programRepo)
    {        
        if($circuit == null) {
            throw $this->createNotFoundException('The circuit does not exist');
        }

        $validPrograms = $programRepo->findValidProgramsByCircuit($circuit->getId());
        
        if($validPrograms == null and !$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw $this->createNotFoundException('The circuit does not exist');
        }
        
        return $this->render('front/circuit_show.html.twig', [
            'circuit' => $circuit,
            'steps' => $stepRepo->findOrderedStepsByCircuit($circuit->getId()),
            'programs' => $validPrograms,
        ]);
    }

    /**
     * Displays the list of the circuits liked
     * 
     * @Route("/panier", name="front_shopping_cart", methods="GET")
     */
    public function showCircuitLiked(CircuitRepository $circuitRepo) {
        $likes = $this->get('session')->get('likes');
        $circuits = [];
        if($likes !== null) {
            foreach($likes as $like) {
                $circuits[] = $circuitRepo->find($like);
            }
        }
        return $this->render('front/shopping_cart.html.twig', [
            'circuits' => $circuits,
        ]);
    }

    /**
     * Handle the like or dislike of a circuit.
     * 
     * @Route("/like/{id}", name="front_handle_like", methods="GET", requirements={"id"="\d+"})
     */
     public function handleLike(Circuit $circuit = null) {
        $id = $circuit->getId();
        if($circuit === null) {
            return $this->json(['code' => 404, 'message' => 'Circuit not found'], 404);
        }

        if(($likes = $this->get('session')->get('likes')) == null) {
            $likes = array();
        }

        if (!in_array($id, $likes)) {
            $likes[] = $id;
        }

        else {
            $likes = array_diff($likes, array($id));
        }

        $this->get('session')->set('likes', $likes);
        return $this->json(['code' => 200, 'message' => 'likes handled'], 200);
     }
}
