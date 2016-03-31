<?php
/**
 * Created by PhpStorm.
 * User: lp
 * Date: 31/03/2016
 * Time: 16:57
 */

namespace SiteBundle\Security;


use SiteBundle\Entity\User;
use SiteBundle\Repository\UserRepository;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function loadUserByUsername($username)
    {
        $userAccount = $this->userRepository->findByUsername($username);

        if (null === $userAccount) {

            throw new UsernameNotFoundException();
        }

        return $userAccount;
    }

    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class)
    {
        return ($class === User::class);
    }
}