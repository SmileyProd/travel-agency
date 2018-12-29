<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

class LoadUserData extends Fixture implements ContainerAwareInterface
{

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
    
    public function load(ObjectManager $manager)
    {
        // Get our userManager, you must implement `ContainerAwareInterface`
        $userManager = $this->container->get('fos_user.user_manager');

        // Create our user and set details
        $user = $userManager->createUser();
        $user->setUsername('Admin');
        $user->setEmail('email@domain.com');
        $user->setPlainPassword('admin');
        //$user->setPassword('3NCRYPT3D-V3R51ON');
        $user->setEnabled(true);
        $user->setRoles(array('ROLE_ADMIN'));

        // Update the user
        $userManager->updateUser($user, true);

        // Create our user and set details
        $user = $userManager->createUser();
        $user->setUsername('Superadmin');
        $user->setEmail('email3@domain.com');
        $user->setPlainPassword('superadmin');
        //$user->setPassword('3NCRYPT3D-V3R51ON');
        $user->setEnabled(true);
        $user->setRoles(array('ROLE_SUPER_ADMIN'));

        // Update the user
        $userManager->updateUser($user, true);

        $user = $userManager->createUser();
        $user->setUsername('Lambda');
        $user->setEmail('email2@domain.com');
        $user->setPlainPassword('lambda');
        //$user->setPassword('3NCRYPT3D-V3R51ON');
        $user->setEnabled(true);
        $user->setRoles(array('ROLE_USER'));

        // Update the user
        $userManager->updateUser($user, true);
    }
}

// ("nom d'utilisateur", "mot de passe")

// ("admin", "admin")
// ("superadmin", "superadmin")
// ('lambda", "lambda")