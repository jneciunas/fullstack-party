<?php
/**
 * Created by PhpStorm.
 * User: Jokubas
 * Date: 2018-12-04
 * Time: 16:28
 */

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class Github extends Controller
{
    public function connect(ClientRegistry $clientRegistry){
        return $clientRegistry
            ->getClient('github') // key used in config/packages/knpu_oauth2_client.yaml
            ->redirect([
                'user:email' // the scopes you want to access
            ])
            ;
    }

    public function callback(Request $request, ClientRegistry $clientRegistry)
    {
        // ** if you want to *authenticate* the user, then
        // leave this method blank and create a Guard authenticator
        // (read below)
        return $this->redirectToRoute('index');
    }

}