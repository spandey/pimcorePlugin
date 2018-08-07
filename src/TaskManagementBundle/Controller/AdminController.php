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
	
	$TaskListingObj = new \TaskManagementBundle\Model\TaskManagement\Listing();
        $TaskListingObj->setCondition("id > ?", 91)->setLimit(2);
        $TaskListingData = $TaskListingObj->load(); 
        p_r($TaskListingData);
       
        
        
    }
     /**
     * @Route("/task_listing")
     */
    public function taskListing () {
       /* $logEntry = [
                'id'                => 1,
                'subject'               =>"hghghghfg",
                'description'           => "fefefdfd",
                'due_date'         => 2,
                'priority'          => "ddsdsdsd",
                'status'        => "ddddfff",
                'start_date'     => 3,
                'completion_date' => 4,
                'associated_element'         => "",
              
            ];

            $logEntries[] = $logEntry;
        

//        return $this->dataJson([
//            'p_totalCount' => 1,
//            'p_results'    => $logEntries,
//        ]);
        $this->_helper->json(array(
            "success" => true,
            'data' => $logEntries,
            'total' => 1,
            
        ));*/
       // echo "dddd_________";
        //die;
        $TaskListingObj = new \TaskManagementBundle\Model\TaskManagement\Listing();
        //$TaskListingObj->setCondition("id > ?", 91)->setLimit(2);
        $TaskListingData = $TaskListingObj->load(); 
//        $this->_helper->json(array(
//            "success" => true,
//            'data' => $TaskListingData,
//            'total' => 1,
//            
//        ));
        p_r($TaskListingData);
        
    }
    /**
     * @Route("/show_task_listing")
     */
    public function showAction(Request $request)
    {
        $start = $request->get('start',0);
        $limit = $request->get('limit',10);
        
        
        $TaskListingObj = new \TaskManagementBundle\Model\TaskManagement\Listing();
        $TaskListingObj->setOffset($start);
        $TaskListingObj->setLimit($limit);
        //$TaskListingObj->setCondition('column = 1 AND column2 = 2');
        $totalCount = $TaskListingObj->count();
        $TaskListingData = $TaskListingObj->load(); 
       
    
          $response =  \GuzzleHttp\json_encode(["success" => true,
            'data' => $TaskListingData,
            'total' => $totalCount]);

        return new Response($response);
    
        
    }
}
