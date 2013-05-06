<?php

class IndexController extends CoreController
{
	
	public function indexAction()
	{}
	
	public function empresaAction()
	{}
	
	public function contatoAction()
	{
		$flashMessages = array();
		
		if ($this->getRequest()->isPost()) {
			$data = $this->getRequest()->getPost();
			
			$f = new Zend_Filter_StripTags();
			
			$nome = $f->filter($data['nome']);
			$email = $f->filter($data['email']);
			$telefone = $f->filter($data['telefone']);
			$mensagem = $f->filter($data['mensagem']);
			
			if (empty($nome)) {
				$flashMessages['error'] = "O campo Nome não foi preenchido.";
			}
			else if (empty($email)) {
				$validator = new Zend_Validate_EmailAddress();
				
				if (!$validator->isValid($email)) {
					$flashMessages['error'] = "E-mail digitado é inválido.";
				}
				
				$flashMessages['error'] = "O campo E-mail não foi preenchido.";
			}
			else if (empty($telefone)) {
				$flashMessages['error'] = "O campo Telefone não foi preenchido.";
			}
			else if (empty($mensagem)) {
				$flashMessages['error'] = "O campo Mensagem não foi preenchido.";
			}
			
			if (count($flashMessages) == 0) {
				$mail = new Email();
				
				$msg  = "====================== CONTATO PELO SITE ======================\n";
				$msg .= "NOME: ". $nome . "\n";
				$msg .= "E-MAIL: ". $email . "\n";
				$msg .= "TELEFONE: ". $telefone . "\n\n";
				$msg .= "MENSAGEM: \n". $mensagem . "\n";
				$msg .= "================== FIM DO CONTATO PELO SITE ===================\n";
				
				$mail->setSubject('Shopping Limpeza - Contato pelo Site');
				$mail->addTo("contato@shoplimpeza.com.br", "Contato Shopping Limpeza");
				$mail->setBodyText($msg);
				
				if ($mail->send()) {
					$flashMessages['success'] = "E-mail enviado com sucesso!";
				}
				else {
					$flashMessages['error'] = "Ocorreu um erro ao enviar o e-mail!";
				}
			}
			
			$this->_helper->flashMessenger->addMessage($flashMessages);
			$this->_redirect('/contato');
		}
	}
}
