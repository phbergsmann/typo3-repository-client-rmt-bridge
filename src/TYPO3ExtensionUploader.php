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
		$username = Context::get('information-collector')->getValueFor('ter-username');
		$password = Context::get('information-collector')->getValueFor('ter-password');
		$comment = Context::get('information-collector')->getValueFor('ter-comment');

		$uploader = new \NamelessCoder\TYPO3RepositoryClient\Uploader();
		$uploader->upload($directory, $username, $password, $comment);
	}

	public function getInformationRequests()
	{
		$ir = array(
			new InformationRequest('ter-username', array('type' => 'text')),
			new InformationRequest('ter-password', array('type' => 'text')),
			new InformationRequest('ter-comment', array(
				'type' => 'text',
				'default' => 'Release of new version'
			))
		);

		return $ir;
	}
}
?>