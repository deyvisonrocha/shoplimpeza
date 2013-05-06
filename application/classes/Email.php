<?php

class Email extends Zend_Mail 
{
	
	public function __construct()
	{
		parent::__construct('UTF-8');
		
		$transportMail = Zend_Registry::get('transportMail');
		parent::setDefaultTransport($transportMail);
		
		$config_mail = Zend_Registry::get('config');
		
		$name = $config_mail->email->name;
		$email = $config_mail->email->email;
		
		parent::setFrom($email, $name);
	}
	
}