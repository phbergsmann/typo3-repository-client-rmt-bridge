<?php

use Liip\RMT\Context;
use Liip\RMT\Information\InformationRequest;
use Liip\RMT\Action\BaseAction;
use Liip\RMT\Information\InteractiveQuestion;

class TYPO3ExtensionUploader extends BaseAction
{
	public function getTitle()
	{
		return 'TYPO3 Extension TER upload';
	}

	public function execute() {
		$directory = trim(shell_exec('pwd'));

		$usernameIr = new InformationRequest('ter-username', array('type' => 'text'));
		$username = new InteractiveQuestion($usernameIr);

		$passwordIr = new InformationRequest('ter-password', array('type' => 'text'));
		$password = new InteractiveQuestion($passwordIr);

		$commentIr = new InformationRequest('ter-comment', array(
				'type' => 'text',
				'default' => 'Release of version ' . Context::getParam('new-version')
			));
		$comment = new InteractiveQuestion($commentIr);

		$uploader = new \NamelessCoder\TYPO3RepositoryClient\Uploader();
		$uploader->upload($directory, $username, $password, $comment);
	}
}
?>