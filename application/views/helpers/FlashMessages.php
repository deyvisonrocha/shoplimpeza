<?php 
class Zend_View_Helper_FlashMessages extends Zend_View_Helper_Abstract
{
    public function flashMessages()
    {
        $messages = Zend_Controller_Action_HelperBroker::getStaticHelper('FlashMessenger')->getMessages();
        $output = '';
        
        if (!empty($messages)) {
            $output .= '<div class="row-fluid" id="messages">';
            foreach ($messages as $message) {
            	$output .= '<div class="alert alert-'. key($message) . '">';
                $output .= current($message);
                $output .= '</div>';
            }
            $output .= '</div>';
        }
        
        return $output;
    }
}
