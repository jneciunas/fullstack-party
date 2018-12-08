<?php
/**
 * Created by PhpStorm.
 * User: Jokubas
 * Date: 2018-12-04
 * Time: 16:49
 */

namespace App\Security;

use Doctrine\ORM\EntityManagerInterface;
use KnpU\OAuth2ClientBundle\Client\Provider\GithubClient;
use KnpU\OAuth2ClientBundle\Security\Authenticator\SocialAuthenticator;
use KnpU\OAuth2ClientBundle\Client\Provider\FacebookClient;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Security;

class MyGithubAuthenticator extends SocialAuthenticator
{
    private $clientRegistry;
    private $em;
    private $security;

    public function __construct(ClientRegistry $clientRegistry, EntityManagerInterface $em, Security $security)
    {
        $this->clientRegistry = $clientRegistry;
        $this->em = $em;
        $this->security = $security;
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function supports(Request $request)
    {
        /*if ($this->security->getUser()) {
            return false;
        }*/

        return $request->attributes->get('_route') === 'github_callback';
    }

    /**
     * @param Request $request
     * @return \League\OAuth2\Client\Token\AccessToken|mixed
     */
    public function getCredentials(Request $request)
    {
        return $this->fetchAccessToken($this->getGithubClient());
    }

    /**
     * @param mixed $credentials
     * @param UserProviderInterface $userProvider
     * @return User|null|\Symfony\Component\Security\Core\User\UserInterface
     */

    public function getUser($credentials, UserProviderInterface $userProvider)
    {

        return $userProvider->loadUserByUsername($this->getGithubClient()->fetchUserFromToken($credentials)->getId());
    }

    /**
     * @return GithubClient
     */
    private function getGithubClient()
    {
        return $this->clientRegistry
            ->getClient('github');
    }

    /**
     * @param Request $request
     * @param TokenInterface $token
     * @param string $providerKey
     * @return null|Response
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return new Response('Success');
    }

    /**
     * @param Request $request
     * @param AuthenticationException $exception
     * @return null|Response
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $message = strtr($exception->getMessageKey(), $exception->getMessageData());

        return new Response($message, Response::HTTP_FORBIDDEN);
    }

    /**
     * @param Request $request
     * @param AuthenticationException|null $authException
     * @return RedirectResponse|Response
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        return new RedirectResponse(
            '/', // might be the site, where users choose their oauth provider
            Response::HTTP_TEMPORARY_REDIRECT
        );
    }

    /*public function supportsRememberMe()
    {
        return true;
    }*/
}