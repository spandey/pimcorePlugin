<?php

namespace TaskManagementBundle\Controller;

use Pimcore\Controller\FrontendController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use TaskManagementBundle\Model;


class DefaultController extends FrontendController
{
    /**
     * @Route("/task_management")
     */
    public function indexAction(Request $request)
    {
        p_r($_POST);
        
        $Description =$_POST['description'];
        $Priority =  $_POST['priority'];
        $Status =  $_POST['status'];
        $Start_date =  $_POST['start_date'];
        $Completion_date =  $_POST['completion_date'];
        $Associated_element =  $_POST['associated_element'];
        $Subject = $_POST['subject'];
     
        
        $TaskManagmentObj = new Model\TaskManagement();
        $TaskManagmentObj->setId(2);
        $TaskManagmentObj->setDescription($Description);
        $TaskManagmentObj->setPriority($Priority);
        $TaskManagmentObj->setStatus($Status);
        $TaskManagmentObj->setSubject($Subject);
        $TaskManagmentObj->save();
        
        return new Response('Hello world from task_management');
    }
}
