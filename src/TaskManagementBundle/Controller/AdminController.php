<?php

/* 
 * TaskManagementBundle
 * 
 */

namespace TaskManagementBundle\Controller;

use Pimcore\Controller\FrontendController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use TaskManagementBundle\Model;
use \Pimcore\Model\DataObject;

/* 
 * Task Backend Controller
 * 
 * @method SaveTask(Request $request)
 * @method indexAction(Request $request)
 * 
 */
class AdminController extends FrontendController
{
    
    /**
     * @Route("/task_management__admin_index")
     */
    public function indexAction(Request $request) {}
    
    /**
     * @Route("/save_task")
     */
    public function SaveTask(Request $request)
    {
        $Description =$_POST['description'];
        $DueDate = date('Y-m-d H:i:s', strtotime($_POST['due_date']));
        $Priority =  $_POST['priority'];
        $Status = $_POST['status']; 
        $StartDate = date('Y-m-d H:i:s', strtotime($_POST['start_date']));
        $CompletionDate =  date('Y-m-d H:i:s', strtotime($_POST['completion_date']));
        $AssociatedElement =  $_POST['associated_element'];
        $Subject = $_POST['subject'];
     
        $TaskManagmentObj = new Model\TaskManagement();
        $TaskManagmentObj->setDescription($Description);
        $TaskManagmentObj->setDue_date($DueDate);
        $TaskManagmentObj->setPriority($Priority);
        $TaskManagmentObj->setStatus($Status);
        $TaskManagmentObj->setStart_date($StartDate);
        $TaskManagmentObj->setCompletion_date($CompletionDate);
        $TaskManagmentObj->setAssociated_element($AssociatedElement);
        $TaskManagmentObj->setSubject($Subject);
        $TaskManagmentObj->save();
        die;
       
        
        
    }
}
