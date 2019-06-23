<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function indexAction(Request $request)
    {
        
        return $this->render('index.html.twig');
    }

    /**
     * @Route("/m", name="index_member")
     */
    public function indexMemberAction(Request $request)
    {
        
        return $this->render('index.html.twig');
    }

    /**
     * @Route("/a", name="index_admin")
     */
    public function indexAdminAction(Request $request)
    {
        
        return $this->render('index.html.twig');
    }
}