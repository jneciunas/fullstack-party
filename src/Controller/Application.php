<?php
/**
 * Created by PhpStorm.
 * User: Jokubas
 * Date: 2018-11-29
 * Time: 16:36
 */

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Security;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Component\HttpFoundation\Session\Session;

class Application  extends Controller
{
    function index(Security $security){
        return $this->render('application/index.html.twig');
    }

    function list(ClientRegistry $clientRegistry, Security $security){
        $session = new Session();
        $credentials = $session->get('createntials');
        print_r($credentials);
        $token = $credentials->getToken();
        print_r($token);

        return $this->render('application/list.html.twig');
    }
}