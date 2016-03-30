<?php

namespace SiteBundle\Security;

use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface
{
    private $username;
    private $password;
    private $salt;
    private $roles;

    public function __construct($username, $password, $salt, array $roles = [])
    {
        $this->username = $username;
        $this->password = $password;
        $this->salt = $salt;
        $this->roles = array_unique(array_merge(['ROLE_USER'], $roles));
    }

    public function promoteAdmin()
    {
        $this->roles = array_unique(array_merge($this->roles, ['ROLE_ADMIN']));
    }

    public function unpromoteAdmin()
    {
        if (false !== ($roleIndex = array_search('ROLE_ADMIN', $this->roles))) {
            unset($this->roles[$roleIndex]);
        }
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getSalt()
    {
        return $this->salt;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function eraseCredentials() {}
}
