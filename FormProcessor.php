<?php namespace ImForms;

/**
 * Class FormProcessor
 *
 * This is a FormProcessor an example module.
 * It automatically executes when you assign it to a form
 *
 * @package ImForms
 */
class FormProcessor extends Module
{
	/**
	 * @var bool - Validation error flag
	 */
	private $error = false;

	/**
	 * A method to determine the status of the user input check
	 *
	 * @return bool
	 */
	public function isError() { return $this->error; }

	/**
	 * __execute() method is the entry point of that module.
	 * This method will be called automatically if you assign
	 * this module to your form
	 *
	 */
	public function __execute()
	{
		// Merge language with im_forms default data
		$this->mergeLang();
		$this->sanitizer = $this->processor->getSanitizer();
		//$this->parser = $this->processor->getTemplateParser();

		// Let's check user input
		if(true === $this->checkUserInput()) {
			if(true === $this->save()) {
				return true;
			}
		}

		$this->error = true;
		return false;
	}

	/**
	 * Validate User input.
	 *
	 */
	private function checkUserInput()
	{
		$username = $this->sanitizer->text($this->input->post->username);
		if(!$username) {
			\MsgReporter::setClause('err_username', array(), true);
			$this->error = true;
		}

		$email = $this->sanitizer->email($this->input->post->email);
		if(!$email) {
			\MsgReporter::setClause('err_email', array(), true);
			$this->error = true;
		}

		if($this->error) {
			return false;
		}

		return true;
	}

	/**
	 * Save user input if the validation was successful
	 */
	private function save() {
		// There you can add your item save code ...
		\MsgReporter::setClause('successful_saved', array());

		return true;
	}

	/**
	 * Method merges the language variables already in memory
	 * with those of the plugin module.
	 */
	private function mergeLang()
	{
		global $i18n, $LANG;
		file_exists(__DIR__.'/lang/'.$LANG.'php') ?
			include(__DIR__.'/lang/'.$LANG.'php') : include(__DIR__.'/lang/en_US.php');
		$i18n = array_merge($i18n, $i18n_local);
	}
}