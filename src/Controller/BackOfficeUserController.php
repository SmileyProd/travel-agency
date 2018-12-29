<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/user")
 */
class BackOfficeUserController extends AbstractController
{
    /**
     * Displays the list of user
     * 
     * @Route("/", name="admin_user_index", methods="GET")
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('/back/user/index.html.twig', ['users' => $userRepository->findAll()]);
    }

    /**
     * Show the user given by the id slug
     * 
     * @Route("/{id}", name="admin_user_show", methods="GET")
     */
    public function show(User $user): Response
    {
        return $this->render('/back/user/show.html.twig', ['user' => $user]);
    }

    /**
     * Delete the user given by the id slug
     * 
     * @Route("/{id}", name="admin_user_delete", methods="DELETE")
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();
        }

        return $this->redirectToRoute('admin_user_index');
    }
}
