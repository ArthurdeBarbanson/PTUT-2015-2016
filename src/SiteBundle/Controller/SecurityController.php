<?php
namespace SiteBundle\Controller;

use SiteBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Role\Role;

class SecurityController extends Controller
{
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render(
            'SiteBundle:Security:login.html.twig',
            [
                // last username entered by the user
                'last_username' => $lastUsername,
                'error' => $error,
            ]
        );
    }

    public function createUserAction()
    {
        $user = new User();
        $encoder = $this->get('security.password_encoder');
        $encoded = $encoder->encodePassword($user, 'Reynald');
        $user->setPassword($encoded);


        $user->setRoles(array('ROLE_ETUDIANT', 'ROLE_ADMIN', 'ROLE_ENTREPRISE'));
        $user->setIdEntreprise(2);
        $user->setUsername('Reynald');

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        $user = new User();
        $user->setRoles(array('ROLE_ETUDIANT', 'ROLE_ADMIN', 'ROLE_ENTREPRISE'));
        $user->setIdEntreprise(2);

        $user->setUsername('Arthur');
        $encoded = $encoder->encodePassword($user, 'Arthur');
        $user->setPassword($encoded);
        $em->persist($user);
        $em->flush();

        $user = new User();
        $user->setRoles(array('ROLE_ETUDIANT', 'ROLE_ADMIN', 'ROLE_ENTREPRISE'));
        $user->setIdEntreprise(2);
        $user->setUsername('Antoine');
        $encoded = $encoder->encodePassword($user, 'Antoine');
        $user->setPassword($encoded);
        $em->persist($user);
        $em->flush();

        $user = new User();
        $user->setRoles(array('ROLE_ETUDIANT', 'ROLE_ADMIN', 'ROLE_ENTREPRISE'));
        $user->setIdEntreprise(2);
        $user->setUsername('Guillaume');
        $encoded = $encoder->encodePassword($user, 'Guillaume');
        $user->setPassword($encoded);
        $em->persist($user);
        $em->flush();

    }
}