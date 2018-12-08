<?php
/**
 * Created by PhpStorm.
 * User: Jokubas
 * Date: 2018-12-08
 * Time: 12:32
 */

namespace App\Security;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Component\HttpFoundation\Session\Session;


class MyOAuthUserProvider implements UserProviderInterface
{
    private $roles;
    private $clientRegistry;

    public function __construct(array $roles = ['ROLE_USER', 'ROLE_OAUTH_USER'], ClientRegistry $clientRegistry)
    {
        $this->clientRegistry = $clientRegistry;
        $this->roles = $roles;
    }
    public function loadUserByUsername($username)
    {
        $session = new Session();
        $credentials = $session->get('createntials');
        $oauth_user = $this->getGithubClient()->fetchUserFromToken($credentials);
        $id = $oauth_user->getId();
        if ($username!=$id){
            throw new Exception('Missmaching user ids');
        }

        $user = new MyOAuthUser($username, $this->roles);

        return $user;
    }
    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof MyOAuthUser) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }
        return $this->loadUserByUsername($user->getUsername());
    }
    public function supportsClass($class)
    {
        return MyOAuthUser::class === $class;
    }

    /**
     * @return GithubClient
     */
    private function getGithubClient()
    {
        return $this->clientRegistry
            ->getClient('github');
    }
}