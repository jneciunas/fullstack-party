<?php
/**
 * Created by PhpStorm.
 * User: Jokubas
 * Date: 2018-12-08
 * Time: 12:34
 */

namespace App\Security;

use Symfony\Component\Security\Core\User\UserInterface;


class MyOAuthUser implements UserInterface
{
    private $username;
    private $roles;
    private $access_token;
    public function __construct($username, array $roles)
    {
        $this->username = $username;
        $this->roles = $roles;
    }
    public function getRoles()
    {
        return $this->roles;
    }
    public function getPassword()
    {
        return '';
    }
    public function getSalt()
    {
        return null;
    }
    public function getUsername()
    {
        return $this->username;
    }
    public function getAccessToken()
    {
        return $this->access_token;
    }

    public function eraseCredentials()
    {
        // Do nothing.
    }
}