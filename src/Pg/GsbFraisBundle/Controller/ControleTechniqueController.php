<?php
namespace Pg\GsbFraisBundle\Controller;
require_once("include/fct.inc.php");
//require_once ("include/class.pdogsb.inc.php");
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
//use PdoGsb;
class ControleTechniqueController extends Controller
{
    public function indexAction()
    {
         if($km >"200000")
         	{$etat = "0";}
         else
         	if($controle=="false")
         		{$etat = "0";}
         	else
         		if ($date < "10")
         			{$etat = "0";}
         		else
         			$etat="1";

    }
    
    
}
