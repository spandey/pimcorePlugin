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
    
   /**
     * @Route("/show_task_listing")
     */
    public function showAction(Request $request)
    {
        $start = $request->get('start');
        $limit = $request->get('limit');
        
        $TaskListingObj = new \TaskManagementBundle\Model\TaskManagement\Listing();
        $TaskListingObj->setOffset($start);
        $TaskListingObj->setLimit($limit);
        
        $subject = $request->get('subject');
        $flag = false;
        if($subject != ""){
            $TaskListingObj->setCondition('subject = ?',$subject, 'or');
            $flag =true;
        }
        $fromDate = $request->get('fromDate');
        $fromTime =  $request->get('fromTime');
       
        
        if ($fromDate != "" && $fromTime =! "") {
             $fromDateTime = $this->parseDateTime($fromDate,$fromTime);
            if ($flag == true){
                $TaskListingObj->addConditionParam('start_date < ?',$fromDateTime,'AND');
            }
            else {
                $TaskListingObj->setCondition('start_date < ?',$fromDateTime,'AND');
                $flag =true;
            }
//            $qb->andWhere('timestamp > :fromDate');
//            $qb->setParameter('fromDate', $fromDate, Type::DATETIME);
        }
        $toDate = $request->get('toDate');
        $toTime =  $request->get('toTime');
        $toDateTime = $this->parseDateTime($toDate,$toTime);
        if ($toDate != "" && $toTime =! "") {
            if ($flag == true){
                $TaskListingObj->addConditionParam('due_date > ?',$toDateTime,'AND');
            }
            else {
                $TaskListingObj->setCondition('due_date > ?',$toDateTime,'AND');
                $flag =true;
            }

        }
        $status = $request->get('status');
        if($status != ""){
            if ($flag == true){
                $TaskListingObj->addConditionParam('status = ?',$status,'OR');
            }
            else {
                $TaskListingObj->setCondition('status = ?',$status,'OR');
                $flag =true;
            }
            
        }
        $priority  =  $request->get('priority');
        if($priority != ""){
            if ($flag == true){
                $TaskListingObj->addConditionParam('priority = ?',$priority,'OR');
            }
            else {
                $TaskListingObj->setCondition('priority = ?',$priority,'OR');
                $flag =true;
            }
        }
                
        $totalCount = $TaskListingObj->count();
        $TaskListingData = $TaskListingObj->load(); 
       
    
          $response =  \GuzzleHttp\json_encode(["success" => true,
            'data' => $TaskListingData,
            'total' => $totalCount]);

        return new Response($response);
    
        
    }
       
    /** 
     * Update Task Detail for specific id
     * 
     * 
     * @Route("/update_task")
     * 
    */
    public function UpdateTask() {
        $id= $_POST['id'];
        $Description =$_POST['description'];
        $DueDate = date('Y-m-d H:i:s', strtotime($_POST['due_date']));
        $Priority =  $_POST['priority'];
        $Status = $_POST['status']; 
        $StartDate = date('Y-m-d H:i:s', strtotime($_POST['start_date']));
        $CompletionDate =  date('Y-m-d H:i:s', strtotime($_POST['completion_date']));
        $AssociatedElement =  $_POST['associated_element'];
        $Subject = $_POST['subject'];
        
        //$TaskManagmentObj = new Model\TaskManagement();
        die;
    }
    
    
    /**
     * Task Detail for specific id
     * 
     * @Route("/edit_task")
     * @return array task detail
     * 
    */
    public function EditTask() {
        $id= $_GET['id'];
        $TaskListingObj = new \TaskManagementBundle\Model\TaskManagement\Listing();
        $TaskListingObj->setCondition("id = ?", $id)->setLimit(1);
        $TaskDetail = $TaskListingObj->load(); 
       
        $response = \GuzzleHttp\json_encode([
            'success'=>$TaskDetail
        ]);
        
        return new Response($response);
        die;
    }
    /**
     * @param string|null $date
     * @param string|null $time
     *
     * @return \DateTime|null
     */
    private function parseDateTime($date = null, $time = null)
    {
        
       $dateTime = date('Y-m-d H:i:s', strtotime($date." ".$time));
//p_r($dateTime);
//die;
        return $dateTime;
    }
    
    
}
