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

class Application  extends Controller
{
    function index(){
        return $this->render('application/index.html.twig');
    }
}