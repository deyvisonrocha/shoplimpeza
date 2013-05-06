<?php 
class Zend_View_Helper_FlashMessages extends Zend_View_Helper_Abstract
{
    public function flashMessages($manager = true)
    {
        $messages = Zend_Controller_Action_HelperBroker::getStaticHelper('FlashMessenger')->getMessages();
        
        if (!empty($messages)) {
        	$output = '';
        	
        	if ($manager) {
            	$output .= '<div class="row-fluid" id="messages">';
        	}
            foreach ($messages as $message) {
            	$output .= '<div class="alert alert-'. key($message) . '">';
                $output .= current($message);
                $output .= '</div>';
            }
            if ($manager) {
            	$output .= '</div>';
            }
            
            return $output;
        }
        
        return false;
    }
}
