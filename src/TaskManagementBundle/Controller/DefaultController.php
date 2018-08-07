<?php

namespace TaskManagementBundle\Controller;

use Pimcore\Controller\FrontendController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use TaskManagementBundle\Model;
use Pimcore\Bundle\AdminBundle\HttpFoundation\JsonResponse;
use Pimcore\Bundle\AdminBundle\Security\User\TokenStorageUserResolver;
use Pimcore\Bundle\AdminBundle\Security\User\User as UserProxy;


class DefaultController extends FrontendController
{
    /**
     * @Route("/task_management")
     */
    public function indexAction(Request $request)
    {
        return new Response('Task saved successfully');
    }
    /**
     * @Route("/task_listing")
     */
    public function taskListing () {
        $logEntry = [
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
            
        ));
        
    }
     /**
     * Returns a JsonResponse that uses the admin serializer
     *
     * @param mixed $data    The response data
     * @param int $status    The status code to use for the Response
     * @param array $headers Array of extra headers to add
     * @param array $context Context to pass to serializer when using serializer component
     * @param bool $useAdminSerializer
     *
     * @return JsonResponse
     */
//    public function dataJson($data, $status = 200, $headers = [], $context = [], bool $useAdminSerializer = true)
//    {
//        $json = $this->encodeJson($data, $context, JsonResponse::DEFAULT_ENCODING_OPTIONS, $useAdminSerializer);
//
//        return new JsonResponse($json, $status, $headers, true);
//    }
//        
    
}
