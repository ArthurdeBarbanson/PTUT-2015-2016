<?php
/**
 * Created by PhpStorm.
 * User: lp
 * Date: 31/03/2016
 * Time: 17:04
 */

namespace SiteBundle\Repository;


use SiteBundle\Entity\User;

interface UserRepository
{
    public function findByUsername($username);
    public function save(User $userAccount);
    public function isUsernameInUse($username);
}
