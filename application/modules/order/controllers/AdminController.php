<?php

/**
 * Order_AdminController
 *
 * @author Andrzej Wilczyński <and.wilczynski@gmail.com>
 */
class Order_AdminController extends MF_Controller_Action {
    
    public function listOrderAction() {
        if($dashboardTime = $this->_helper->user->get('dashboard_time')) {
            if(isset($dashboardTime['new_orders'])) {
                $dashboardTime['new_orders'] = time();
                $this->_helper->user->set('dashboard_time', $dashboardTime);
            }
        }
    }
    public function orderDiscountAction() {
    }
    
    public function listOrderDataAction() {
        $table = Doctrine_Core::getTable('Order_Model_Doctrine_Order');
        $dataTables = Default_DataTables_Factory::factory(array(
            'request' => $this->getRequest(), 
            'table' => $table, 
            'class' => 'Order_DataTables_Order', 
            'columns' => array('or.id', 'CONCAT_WS(" ", u.first_name, u.last_name)', 'or.total_cost', 'or.created_at'),
            'searchFields' => array('CONCAT_WS(" ", u.first_name, u.last_name)', 'dt.name', 'pt.name')
        ));
        
        $results = $dataTables->getResult();
        
        $rows = array();
        foreach($results as $result) {
            $row = array();
            
            if ($result['OrderStatus']['name'] == 'nowe'):
                $row['DT_RowClass'] = 'info';
            endif;

            $row[] = $result['id'];
            $row[] = $result['Delivery']['DeliveryAddress']['name'];
            $row[] = $result['total_cost'];
            $row[] = $result['created_at'];
            $row[] = $result['Delivery']['DeliveryType']['name'];
            $row[] = $result['Payment']['PaymentType']['name'];
            $row[] = $result['OrderStatus']['name'];
            if ($result['Payment']['invoice']):
                $row[] = '<span class="icon16 icomoon-icon-checkbox-2"></span>';
            else:
                $row[] = '<span class="icon16 icomoon-icon-checkbox-unchecked-2"></span>';
            endif;

            $options = '<a href="' . $this->view->adminUrl('edit-order', 'order', array('id' => $result['id'])) . '" title ="' . $this->view->translate('Edit') . '"><span class="icon24 entypo-icon-settings"></span></a>&nbsp;&nbsp;';     
            $row[] = $options;
            $rows[] = $row;
        }

        $response = array(
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => $dataTables->getDisplayTotal(),
            "iTotalDisplayRecords" => $dataTables->getTotal(),
            "aaData" => $rows
        );
        $this->_helper->json($response);
    }
    
    public function editOrderAction() {
        $orderService = $this->_service->getService('Order_Service_Order');
        $orderStatusService = $this->_service->getService('Order_Service_OrderStatus');
        
        $translator = $this->_service->get('translate');
        
        if(!$order = $orderService->getOrder((int) $this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Order not found');
        }
        
        $form = $orderService->getOrderForm($order);
      
        $form->setAction($this->view->adminUrl('edit-order', 'order'));
//        foreach($order as $k=>$r):
//            
//            echo $k."    ".$r."<br />";
//        endforeach;
//        foreach($order['Delivery']['DeliveryAddress'] as $key=>$res):
//            echo $key."   ".$res."<br />";
//            endforeach;
//           
//        exit;
        $form->getElement('order_status_id')->setMultiOptions($orderStatusService->getTargetOrderStatusSelectOptions(false));
       
        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getPost())) {
                try {                                   
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                   
                    $values = $form->getValues();  
                    
                    $orderService->saveOrderFromArray($values); 

                    $this->view->messages()->add($translator->translate('Item has been updated'), 'success');
                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-order', 'order'));
                } catch(Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
        }    
       
        $this->view->assign('form', $form);
        
        $this->view->assign('order', $order);
    }
    
    public function listOrderItemDataAction() {
        $table = Doctrine_Core::getTable('Order_Model_Doctrine_Item');
      //  $dimensionService = $this->_service->getService('Product_Service_Dimension');
        $dataTables = Default_DataTables_Factory::factory(array(
            'request' => $this->getRequest(), 
            'table' => $table, 
            'class' => 'Order_DataTables_Item', 
            'columns' => array('pro.name'),
            'searchFields' => array('pro.name')
        ));
        
        $results = $dataTables->getResult();
////        echo $results;
//        foreach($results as $k=>$r):
//           
//            foreacH($r['dimension']['Dimensions'] as $key=>$val):
//            echo $key."   ".$val."<br />";
//            endforeach;
//            foreach($r as $k2=>$r2):
//                echo $k2."   ".$r2."<br />";
//            endforeach;
//        endforeach;
////        
//// exit;
        $rows = array();
        foreach($results as $result) {
           //  endforeach;
            $row = array();
        //    $dimension = $dimensionService->getDimension($result['dimension']);
            $row[] = $result['Product']['Translation'][$this->language]['name'];
            if($result['Product']['promotion'])
                $row[] = $result['Product']['promotion_price'];
            else
                $row[] = $result['Product']['price'];
            $row[] = $result['number'];
            $row[] = $result['discount_amount'];;
          //  $row[] = $dimension->getHeight()."cm x ".$dimension->getWidth()." cm";
            $rows[] = $row;
        }

        $response = array(
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => $dataTables->getDisplayTotal(),
            "iTotalDisplayRecords" => $results->count(),
            "aaData" => $rows
        );
        $this->_helper->json($response);
    }
    
    public function paymentOrderDataAction() {
        $table = Doctrine_Core::getTable('Order_Model_Doctrine_Payment');
        $dataTables = Default_DataTables_Factory::factory(array(
            'request' => $this->getRequest(), 
            'table' => $table, 
            'class' => 'Order_DataTables_Payment', 
        ));
        
        $results = $dataTables->getResult();
        
        $rows = array();
        foreach($results as $result) {
            $row = array();

            $row[] = $result['PaymentType']['name'];
            $row[] = $result['status'];

            $rows[] = $row;
        }

        $response = array(
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => $dataTables->getDisplayTotal(),
            "iTotalDisplayRecords" => $results->count(),
            "aaData" => $rows
        );
        $this->_helper->json($response);
    }
    
    public function deliveryOrderDataAction() {
        $table = Doctrine_Core::getTable('Order_Model_Doctrine_Delivery');
        $dataTables = Default_DataTables_Factory::factory(array(
            'request' => $this->getRequest(), 
            'table' => $table, 
            'class' => 'Order_DataTables_Delivery', 
        ));
        
        $results = $dataTables->getResult();
        
        $rows = array();
        foreach($results as $result) {
            $row = array();

            $row[] = $result['DeliveryType']['name'];
            $row[] = $result['status'];

            $rows[] = $row;
        }

        $response = array(
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => $dataTables->getDisplayTotal(),
            "iTotalDisplayRecords" => $results->count(),
            "aaData" => $rows
        );
        $this->_helper->json($response);
    }
    
    public function listDeliveryTypeAction() {
        
    }
    
    public function listDeliveryTypeDataAction() {
        $table = Doctrine_Core::getTable('Order_Model_Doctrine_DeliveryType');
        $dataTables = Default_DataTables_Factory::factory(array(
            'request' => $this->getRequest(), 
            'table' => $table, 
            'class' => 'Order_DataTables_DeliveryType', 
            'columns' => array('dt.name', 'dt.price'),
            'searchFields' => array('dt.name', 'dt.price')
        ));
        
        $results = $dataTables->getResult();
        
        $rows = array();
        foreach($results as $result) {
            $row = array();

            $row[] = $result['name'];
            
            $row[] = $result['price']." ".$this->view->translate('pounds');
            
            $options = '<a href="' . $this->view->adminUrl('edit-delivery-type', 'order', array('id' => $result['id'])) . '" title ="' . $this->view->translate('Edit') . '"><span class="icon24 entypo-icon-settings"></span></a>&nbsp;&nbsp;';     
            $options .= '<a href="' . $this->view->adminUrl('remove-delivery-type', 'order', array('id' => $result['id'])) . '" class="remove" title="' . $this->view->translate('Remove') . '"><span class="icon16 icon-remove"></span></a>';
            $row[] = $options;
            $rows[] = $row;
        }

        $response = array(
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => $dataTables->getDisplayTotal(),
            "iTotalDisplayRecords" => $dataTables->getTotal(),
            "aaData" => $rows
        );
        $this->_helper->json($response);
    }
    
    public function addDeliveryTypeAction() {
        $deliveryTypeService = $this->_service->getService('Order_Service_DeliveryType');
        
        $translator = $this->_service->get('translate');
        
        $form = $deliveryTypeService->getDeliveryTypeForm();
        
        $form->setAction($this->view->adminUrl('add-delivery-type', 'order'));
           
        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getParams())) {
                try {
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                    
                    $values = $form->getValues();

                    $deliveryType = $deliveryTypeService->saveDeliveryTypeFromArray($values);

                    $this->view->messages()->add($translator->translate('Item has been added'), 'success');
                    
                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
                
                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-delivery-type', 'order'));
                } catch(Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
        }
        
        $this->view->assign('form', $form);
    }
    
    public function editDeliveryTypeAction() {
        $deliveryTypeService = $this->_service->getService('Order_Service_DeliveryType');
        
        $translator = $this->_service->get('translate');
        
        if(!$deliveryType = $deliveryTypeService->getDeliveryType((int) $this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Delivery type not found');
        }
        
        $form = $deliveryTypeService->getDeliveryTypeForm($deliveryType);
      
        $form->setAction($this->view->adminUrl('edit-delivery-type', 'order'));
       
        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getPost())) {
                try {                                   
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                   
                    $values = $form->getValues();  
                    
                    $deliveryTypeService->saveDeliveryTypeFromArray($values); 

                    $this->view->messages()->add($translator->translate('Item has been updated'), 'success');
                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-delivery-type', 'order'));
                } catch(Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
        }    
       
        $this->view->assign('form', $form);
        $this->view->assign('deliveryType', $deliveryType);
    } 
    
    public function removeDeliveryTypeAction() {
        $deliveryTypeService = $this->_service->getService('Order_Service_DeliveryType');

        if($deliveryType = $deliveryTypeService->getDeliveryType($this->getRequest()->getParam('id'))) {
            try {
                $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                
                $deliveryTypeService->removeDeliveryType($deliveryType);
                     
                $this->_service->get('doctrine')->getCurrentConnection()->commit();
                $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-delivery-type', 'order'));
            } catch(Exception $e) {
                $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                $this->_service->get('log')->log($e->getMessage(), 4);
            }
        }      
        $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-delivery-type', 'order')); 
    }
    
    public function listPaymentTypeAction() {
        
    }
    
    public function listPaymentTypeDataAction() {
        $table = Doctrine_Core::getTable('Order_Model_Doctrine_PaymentType');
        $dataTables = Default_DataTables_Factory::factory(array(
            'request' => $this->getRequest(), 
            'table' => $table, 
            'class' => 'Order_DataTables_PaymentType', 
            'columns' => array('pt.name'),
            'searchFields' => array('pt.name')
        ));
        
        $results = $dataTables->getResult();
        
        $rows = array();
        foreach($results as $result) {
            $row = array();

            $row[] = $result['name'];
            
            $options = '<a href="' . $this->view->adminUrl('edit-payment-type', 'order', array('id' => $result['id'])) . '" title ="' . $this->view->translate('Edit') . '"><span class="icon24 entypo-icon-settings"></span></a>&nbsp;&nbsp;';     
            $options .= '<a href="' . $this->view->adminUrl('remove-payment-type', 'order', array('id' => $result['id'])) . '" class="remove" title="' . $this->view->translate('Remove') . '"><span class="icon16 icon-remove"></span></a>';
            $row[] = $options;
            $rows[] = $row;
        }

        $response = array(
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => $dataTables->getDisplayTotal(),
            "iTotalDisplayRecords" => $dataTables->getTotal(),
            "aaData" => $rows
        );
        $this->_helper->json($response);
    }
    public function listDiscountCodeDataAction()
    {
        $table = Doctrine_Core::getTable('Order_Model_Doctrine_DiscountCode');
        $dataTables = Default_DataTables_Factory::factory(array(
            'request' => $this->getRequest(), 
            'table' => $table, 
            'class' => 'Order_DataTables_DiscountCode', 
            'columns' => array('dc.code','dc.active','dc.id'),
            'searchFields' => array('dc.active')
        ));
        
        $results = $dataTables->getResult();
        
        $rows = array();
        foreach($results as $result) {
            $row = array();

            $row[] = $result['code'];
            if($result['active'])
                $row[] = "tak";
            else 
                $row[] = "nie";
            $row[] = ($result['discount']*100)."%";
            $options = '<a href="' . $this->view->adminUrl('edit-discount-code', 'order', array('id' => $result['id'])) . '" title ="' . $this->view->translate('Change status') . '"><span class="icon24 entypo-icon-settings"></span></a>&nbsp;&nbsp;';     
            $row[] = $options;
            $rows[] = $row;
        }
       // Zend_Debug::dump($rows);
        $response = array(
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => $dataTables->getDisplayTotal(),
            "iTotalDisplayRecords" => $dataTables->getTotal(),
            "aaData" => $rows
        );
        $this->_helper->json($response);
    }
    public function editDiscountCodeAction() {
        $discountCodeService = $this->_service->getService('Order_Service_DiscountCode');
        
        $translator = $this->_service->get('translate');
//        $discountCode = $discountCodeService->getDiscountCode(2);
//        echo $discountCode;
//        exit;
        if(!$discountCode = $discountCodeService->getDiscountCodeById((int) $this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Discount Code not found');
        }
                try { 
                    if($discountCode['active'])
                        $status = 0;
                    else
                        $status = 1;
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
               
                    $discountCodeService->changeActiveStatus((int) $this->getRequest()->getParam('id'),$status);

                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('order-discount', 'order'));
                } catch(Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
                  $this->_helper->viewRenderer->setNoRender();
        $this->_helper->layout->disableLayout();

//        $this->view->assign('form', $form);
//        $this->view->assign('orderStatus', $orderStatus);
    } 
       public function addDiscountCodeAction() {
        $discountCodeService = $this->_service->getService('Order_Service_DiscountCode');
        
        $translator = $this->_service->get('translate');
        
        $form = $discountCodeService->getDiscountCodeForm();
        
        $form->setAction($this->view->adminUrl('add-discount-code', 'order'));
           
        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getParams())) {
                try {
                   
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                     $values = $form->getValues();
                    

                    $discountCodeService = $discountCodeService->saveDiscountCodeFromArray($values);

                    $this->view->messages()->add($translator->translate('Discount code has been added'), 'success');
                    
                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
                
                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('order-discount', 'order'));
                } catch(Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
        }
        $this->view->assign('form', $form);
    }
    public function addPaymentTypeAction() {
        $paymentTypeService = $this->_service->getService('Order_Service_PaymentType');
        
        $translator = $this->_service->get('translate');
        
        $form = $paymentTypeService->getPaymentTypeForm();
        
        $form->setAction($this->view->adminUrl('add-payment-type', 'order'));
           
        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getParams())) {
                try {
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                    
                    $values = $form->getValues();

                    $paymentType = $paymentTypeService->savePaymentTypeFromArray($values);

                    $this->view->messages()->add($translator->translate('Item has been added'), 'success');
                    
                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
                
                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-payment-type', 'order'));
                } catch(Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
        }
        $this->view->assign('form', $form);
    }
    
    public function editPaymentTypeAction() {
        $paymentTypeService = $this->_service->getService('Order_Service_PaymentType');
        
        $translator = $this->_service->get('translate');
        
        if(!$paymentType = $paymentTypeService->getPaymentType((int) $this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Payment type not found');
        }
        
        $form = $paymentTypeService->getPaymentTypeForm($paymentType);
      
        $form->setAction($this->view->adminUrl('edit-payment-type', 'order'));
       
        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getPost())) {
                try {                                   
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                   
                    $values = $form->getValues();  
                    
                    $paymentTypeService->savePaymentTypeFromArray($values); 

                    $this->view->messages()->add($translator->translate('Item has been updated'), 'success');
                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-payment-type', 'order'));
                } catch(Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
        }    
       
        $this->view->assign('form', $form);
        $this->view->assign('paymentType', $paymentType);
    } 
    
    public function removePaymentTypeAction() {
        $paymentTypeService = $this->_service->getService('Order_Service_PaymentType');

        if($paymentType = $paymentTypeService->getPaymentType($this->getRequest()->getParam('id'))) {
            try {
                $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                
                $paymentTypeService->removePaymentType($paymentType);
                     
                $this->_service->get('doctrine')->getCurrentConnection()->commit();
                $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-payment-type', 'order'));
            } catch(Exception $e) {
                $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                $this->_service->get('log')->log($e->getMessage(), 4);
            }
        }      
        $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-payment-type', 'order')); 
    }
    
    public function listOrderStatusAction() {
        
    }
    
    public function listOrderStatusDataAction() {
        $table = Doctrine_Core::getTable('Order_Model_Doctrine_OrderStatus');
        $dataTables = Default_DataTables_Factory::factory(array(
            'request' => $this->getRequest(), 
            'table' => $table, 
            'class' => 'Order_DataTables_OrderStatus', 
            'columns' => array('os.name'),
            'searchFields' => array('os.name')
        ));
        
        $results = $dataTables->getResult();
        
        $rows = array();
        foreach($results as $result) {
            $row = array();

            $row[] = $result['name'];
            
            $options = '<a href="' . $this->view->adminUrl('edit-order-status', 'order', array('id' => $result['id'])) . '" title ="' . $this->view->translate('Edit') . '"><span class="icon24 entypo-icon-settings"></span></a>&nbsp;&nbsp;';     
            $options .= '<a href="' . $this->view->adminUrl('remove-order-status', 'order', array('id' => $result['id'])) . '" class="remove" title="' . $this->view->translate('Remove') . '"><span class="icon16 icon-remove"></span></a>';
            $row[] = $options;
            $rows[] = $row;
        }
       // Zend_Debug::dump($rows);
        $response = array(
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => $dataTables->getDisplayTotal(),
            "iTotalDisplayRecords" => $dataTables->getTotal(),
            "aaData" => $rows
        );
        $this->_helper->json($response);
    }
    
    public function addOrderStatusAction() {
        $orderStatusService = $this->_service->getService('Order_Service_OrderStatus');
        
        $translator = $this->_service->get('translate');
        
        $form = $orderStatusService->getOrderStatusForm();
        
        $form->setAction($this->view->adminUrl('add-order-status', 'order'));
           
        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getParams())) {
                try {
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                    
                    $values = $form->getValues();

                    $orderStatus = $orderStatusService->saveOrderStatusFromArray($values);

                    $this->view->messages()->add($translator->translate('Item has been added'), 'success');
                    
                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
                
                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-order-status', 'order'));
                } catch(Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
        }
        $this->view->assign('form', $form);
    }
    
    public function editOrderStatusAction() {
        $orderStatusService = $this->_service->getService('Order_Service_OrderStatus');
        
        $translator = $this->_service->get('translate');
        
        if(!$orderStatus = $orderStatusService->getOrderStatus((int) $this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Order status not found');
        }
        
        $form = $orderStatusService->getOrderStatusForm($orderStatus);
      
        $form->setAction($this->view->adminUrl('edit-order-status', 'order'));
       
        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getPost())) {
                try {                                   
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                   
                    $values = $form->getValues();  
                    
                    $orderStatusService->saveOrderStatusFromArray($values); 

                    $this->view->messages()->add($translator->translate('Item has been updated'), 'success');
                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-order-status', 'order'));
                } catch(Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
        }    
       
        $this->view->assign('form', $form);
        $this->view->assign('orderStatus', $orderStatus);
    } 
    
    public function removeOrderStatusAction() {
        $orderStatusService = $this->_service->getService('Order_Service_OrderStatus');

        if($orderStatus = $orderStatusService->getOrderStatus($this->getRequest()->getParam('id'))) {
            try {
                $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                
                $orderStatusService->removeOrderStatus($orderStatus);
                     
                $this->_service->get('doctrine')->getCurrentConnection()->commit();
                $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-order-status', 'order'));
            } catch(Exception $e) {
                $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                $this->_service->get('log')->log($e->getMessage(), 4);
            }
        }      
        $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-order-status', 'order')); 
    }

    public function pdfInvoiceAction() {
        require_once('tcpdf/tcpdf.php');
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        
        $orderService = $this->_service->getService('Order_Service_Order');
        
        if(!$order = $orderService->getFullOrder((int) $this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Order not found');
        }
        $code = 'F-'.MF_Text::timeFormat($order['created_at'], 'Ymd').'-'.$order['id'];
        
        $saleDate = MF_Text::timeFormat($order['created_at'], 'd.m.Y');
        $invoiceDate = date('d.m.Y');
        
        $this->view->assign('sale_date', $saleDate);
        $this->view->assign('invoice_date', $invoiceDate);
        $this->view->assign('code', $code);
        $this->view->assign('order', $order);
        
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false); 

        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetAutoPageBreak(1, 30);
        $pdf->SetFont('freesans');
        
        $htmlcontent = $this->view->render('admin/pdf-invoice.phtml');

        //$pdf->SetPrintHeader(false);
       // $pdf->SetPrintFooter(false);
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        
        
        $pdf->addPage();
        $pdf->writeHTML($htmlcontent, true, 0, true, 0);
        $pdf->lastPage();
        $pdf->Output();
        $pdf->Output($code . '.pdf', 'D');     
    }
}

