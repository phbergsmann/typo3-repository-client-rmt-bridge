<?php
use Liip\RMT\Action\BaseAction;
use Liip\RMT\Context;
use Liip\RMT\Information\InformationRequest;
use Liip\RMT\Information\InteractiveQuestion;

class Versioner extends BaseAction
{
	public function execute()
	{
		$versioner = new \NamelessCoder\TYPO3RepositoryClient\Versioner();

		$directory = trim(shell_exec('pwd'));

		$version = $versioner->read('.');
		$version[0] = Context::getParam('new-version');

		try {
			$version[1] = Context::getParam('stability');
		} catch(\InvalidArgumentException $e) {
			$ir = new InformationRequest('stability', array(
				'type' => 'choice',
				'choices' => array(
					\NamelessCoder\TYPO3RepositoryClient\Versioner::STABILITY_STABLE,
					\NamelessCoder\TYPO3RepositoryClient\Versioner::STABILITY_BETA,
					\NamelessCoder\TYPO3RepositoryClient\Versioner::STABILITY_ALPHA,
					\NamelessCoder\TYPO3RepositoryClient\Versioner::STABILITY_EXPERIMENTAL,
					\NamelessCoder\TYPO3RepositoryClient\Versioner::STABILITY_OBSOLETE,
				),
				'default' => \NamelessCoder\TYPO3RepositoryClient\Versioner::STABILITY_STABLE,
			));
			$question = new InteractiveQuestion($ir);

			$version[1] = Context::get('output')->askQuestion($question);
		}

		$versioner->write($directory, $version[0], $version[1]);
	}
}
?>