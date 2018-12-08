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

class Application  extends Controller
{
    function index(Security $security){
        var_dump($security->getUser());
        return $this->render('application/index.html.twig');
    }

    function list(){

    }
}