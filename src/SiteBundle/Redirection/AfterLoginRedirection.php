<?php
/**
 * Created by PhpStorm.
 * User: antoine
 * Date: 16/04/2016
 * Time: 11:06
 */
namespace SiteBundle\Redirection;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

class AfterLoginRedirection implements AuthenticationSuccessHandlerInterface
{
    /**
     * @var \Symfony\Component\Routing\RouterInterface
     */
    private $router;

    /**
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * @param Request $request
     * @param TokenInterface $token
     * @return RedirectResponse
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        // On récupère la liste des rôles d'un utilisateur
        $roles = $token->getRoles();
        $rolesTab = array_map(function ($role) {
            return $role->getRole();
        }, $roles);
        // S'il s'agit d'un admin ou d'un super admin on le redirige vers le backoffice
        if (in_array('ROLE_ADMIN', $rolesTab, true))
            $redirection = new RedirectResponse($this->router->generate('acceuil_responsable'));
        //TODO changer la page d'accueil de l'admin
        elseif (in_array('ROLE_ETUDIANT', $rolesTab, true))
            $redirection = new RedirectResponse($this->router->generate('site_accueilEtudiant'));
        elseif (in_array('ROLE_ENTREPRISE', $rolesTab, true))
            $redirection = new RedirectResponse($this->router->generate('site_accueilEntreprise'));
        else
            $redirection = new RedirectResponse($this->router->generate('site_homepage'));
        return $redirection;
    }
}