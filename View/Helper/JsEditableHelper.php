<?php
App::uses('AppHelper', 'View/Helper');

/**
 * DataTable Helper
 *
 * @package Plugin.DataTable
 * @subpackage Plugin.DataTable.View.Helper
 * @author Tigran Gabrielyan
 *
 * @property HtmlHelper $Html
 */
class JsEditableHelper extends AppHelper {

	/*
	 * $settings - storing all the settings from Controller
	 */
	public $settings = array();

	/*
	 * $view - storing the view where the helper is called
	 */
	protected $view;

/**
 * Constructor
 *
 * @param View $View The View this helper is being attached to.
 * @param array $settings Configuration settings for the helper.
 */
	public function __construct(View $View, $settings = array()) {
		$this->settings = $settings;
		$this->view = $View;
	}

	/*
	 * printValue
	 * 
	 * Print out the dependentItem from specific variable
	 * 
	 * @param $name - name of the variable
	 * 
	 */

	public function printValue($name) {
		debug($this->$name);die();
	}

	/*
	 * init
	 * 
	 * Initialize the javascript code on the View Page
	 * 
	 * @param $name - name of the variable
	 * 
	 */
	public function init() {
		return $this->output($this->view->element('script', compact('settings'), array('plugin' => 'JsEditable')));
	}

}