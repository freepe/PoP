<?php
/**---------------------------------------------------------------------------------------------------------------
 *
 * Template Manager (Handlebars)
 *
 * ---------------------------------------------------------------------------------------------------------------*/

define ('GD_SETTINGS_HIERARCHY_PAGE', 'page');
define ('GD_SETTINGS_HIERARCHY_AUTHOR', 'author');
define ('GD_SETTINGS_HIERARCHY_HOME', 'home');
define ('GD_SETTINGS_HIERARCHY_TAG', 'tag');
define ('GD_SETTINGS_HIERARCHY_SINGLE', 'single');

class GD_Template_SettingsManager {

	function get_hierarchies() {

		/**
		 * There are different hierarchies, where each one can have its own set of blocks/actions
		 * Eg: Author hierarchy will filter its posts by the corresponding author / Send 'Contact Profile' to that author without the need to send the user_id
		 */
		return array(
			GD_SETTINGS_HIERARCHY_PAGE,
			GD_SETTINGS_HIERARCHY_AUTHOR,
			GD_SETTINGS_HIERARCHY_HOME,
			GD_SETTINGS_HIERARCHY_TAG,
			GD_SETTINGS_HIERARCHY_SINGLE
		);
	}

	protected function get_hierarchy($hierarchy = null) {

		// Check the Wordpress hierarchy and return the corresponding hierarchy
		if (!$hierarchy) {
			
			if (is_page()) {
				$hierarchy = GD_SETTINGS_HIERARCHY_PAGE;
			}
			elseif (is_home() || is_front_page()) {
				$hierarchy = GD_SETTINGS_HIERARCHY_HOME;
			}
			elseif (is_tag()) {
				$hierarchy = GD_SETTINGS_HIERARCHY_TAG;
			}
			elseif (is_author()) {
				$hierarchy = GD_SETTINGS_HIERARCHY_AUTHOR;
			}
			elseif (is_single()) {
				$hierarchy = GD_SETTINGS_HIERARCHY_SINGLE;
			}
		}

		return $hierarchy;
	}

	function get_block_page($block, $hierarchy = null) {

		$hierarchy = $this->get_hierarchy($hierarchy);
	
		global $gd_template_settingsprocessor_manager;
		if (!($processor = $gd_template_settingsprocessor_manager->get_processor_by_block($block, $hierarchy))) {		
			return null;
		}

		// Search from all blocks and return the corresponding page
		foreach ($processor->get_page_blocks($hierarchy) as $page_id => $pagesettings) {
		
			if ($pagesettings['blocks']) {
				$blocks = array_values($pagesettings['blocks']);
				if (in_array($block, $blocks)) {
					return $page_id;
				}
			}
		}	

		return null;
	}

	function get_blockgroup_page($blockgroup, $hierarchy = null) {

		$hierarchy = $this->get_hierarchy($hierarchy);
	
		global $gd_template_settingsprocessor_manager;
		if (!($processor = $gd_template_settingsprocessor_manager->get_processor_by_blockgroup($blockgroup, $hierarchy))) {		
			return null;
		}

		// Search from all blocks and return the corresponding page
		foreach ($processor->get_page_blockgroups($hierarchy) as $page_id => $pagesettings) {
		
			if ($pagesettings['blockgroups']) {
				$blockgroups = array_values($pagesettings['blockgroups']);
				if (in_array($blockgroup, $blockgroups)) {
					return $page_id;
				}
			}
		}	

		return null;
	}

	function get_action_page($action, $hierarchy = null) {

		$hierarchy = $this->get_hierarchy($hierarchy);
	
		global $gd_template_settingsprocessor_manager;
		if (!($processor = $gd_template_settingsprocessor_manager->get_processor_by_action($action, $hierarchy))) {		
			return null;
		}

		// Search from all blocks and return the corresponding page
		foreach ($processor->get_page_blocks($hierarchy) as $page_id => $pagesettings) {
		
			if ($action == $pagesettings['action']) {
				return $page_id;
			}
		}	

		return null;
	}

	function get_page_block($page_id = null, $hierarchy = null, $format = null) {

		if (!$page_id && is_page()) {

			global $post;
			$page_id = $post->ID;
		}
		elseif (!$page_id && (is_home() || is_front_page())) {
			$page_id = POPTHEME_WASSUP_PAGEPLACEHOLDER_HOME;
		}
		elseif (!$page_id && is_tag()) {
			$page_id = POPTHEME_WASSUP_PAGEPLACEHOLDER_TAG;
		}
		$hierarchy = $this->get_hierarchy($hierarchy);

		global $gd_template_settingsprocessor_manager;
		if (!($processor = $gd_template_settingsprocessor_manager->get_processor_by_page($page_id, $hierarchy))) {
		
			return null;
		}

		$page_blocks = $processor->get_page_blocks($hierarchy);
		if (!$format) {

			$vars = GD_TemplateManager_Utils::get_vars();
			$format = $vars['format'];
		}

		if ($block = $page_blocks[$page_id]['blocks'][$format]) {
			return $block;
		}

		return $page_blocks[$page_id]['blocks']['default'];
	}

	function get_page_blockgroup($page_id = null, $hierarchy = null, $format = null) {

		if (!$page_id && is_page()) {

			global $post;
			$page_id = $post->ID;
		}
		elseif (is_home() || is_front_page()) {
			$page_id = POPTHEME_WASSUP_PAGEPLACEHOLDER_HOME;
		}
		elseif (!$page_id && is_tag()) {
			$page_id = POPTHEME_WASSUP_PAGEPLACEHOLDER_TAG;
		}
		$hierarchy = $this->get_hierarchy($hierarchy);

		global $gd_template_settingsprocessor_manager;
		if (!($processor = $gd_template_settingsprocessor_manager->get_processor_by_page($page_id, $hierarchy))) {
		
			return null;
		}

		$page_blockgroups = $processor->get_page_blockgroups($hierarchy);
		if (!$format) {

			$vars = GD_TemplateManager_Utils::get_vars();
			$format = $vars['format'];
		}

		if ($blockgroup = $page_blockgroups[$page_id]['blockgroups'][$format]) {
			return $blockgroup;
		}
		return $page_blockgroups[$page_id]['blockgroups']['default'];
	}

	function get_page_action($page_id = null, $hierarchy = null) {

		if (!$page_id && is_page()) {
			
			global $post;
			$page_id = $post->ID;
		}

		$hierarchy = $this->get_hierarchy($hierarchy);
	
		global $gd_template_settingsprocessor_manager;
		if (!($processor = $gd_template_settingsprocessor_manager->get_processor_by_page($page_id, $hierarchy))) {
		
			return null;
		}

		$page_blocks = $processor->get_page_blocks($hierarchy);
		return $page_blocks[$page_id]['action'];
	}

	function get_page_checkpoints($page_id = null, $hierarchy = null) {

		if (!$page_id && is_page()) {
			
			global $post;
			$page_id = $post->ID;
		}

		$hierarchy = $this->get_hierarchy($hierarchy);
		$nocheckpoints = array(
			'checkpoints' => array(),
			'type' => false
		);
	
		global $gd_template_settingsprocessor_manager;
		if (!($processor = $gd_template_settingsprocessor_manager->get_processor_by_page($page_id, $hierarchy))) {
		
			return $nocheckpoints;
		}

		$checkpoints = $processor->get_checkpoints($hierarchy);
		if ($checkpoints[$page_id]) {
			return $checkpoints[$page_id];
		}
		return $nocheckpoints;
	}

	function silent_document($page_id = null, $hierarchy = null) {

		if (!$page_id && is_page()) {
			
			global $post;
			$page_id = $post->ID;
		}

		$hierarchy = $this->get_hierarchy($hierarchy);
		
		global $gd_template_settingsprocessor_manager;
		if (!($processor = $gd_template_settingsprocessor_manager->get_processor_by_page($page_id, $hierarchy))) {
		
			return false;
		}

		// If we get an array, then it defines the value on a page by page basis
		// Otherwise, it's true/false, just return it
		$silent = $processor->silent_document($hierarchy);
		if (is_array($silent)) {

			return $silent[$page_id];
		}

		return $silent;
	}

	function is_appshell($page_id = null, $hierarchy = null) {

		if (!$page_id && is_page()) {
			
			global $post;
			$page_id = $post->ID;
		}

		$hierarchy = $this->get_hierarchy($hierarchy);
		
		global $gd_template_settingsprocessor_manager;
		if (!($processor = $gd_template_settingsprocessor_manager->get_processor_by_page($page_id, $hierarchy))) {
		
			return false;
		}

		// If we get an array, then it defines the value on a page by page basis
		// Otherwise, it's true/false, just return it
		$appshell = $processor->is_appshell($hierarchy);
		if (is_array($appshell)) {

			return $appshell[$page_id];
		}

		return $appshell;
	}

	function store_local($page_id = null, $hierarchy = null) {

		if (!$page_id && is_page()) {
			
			global $post;
			$page_id = $post->ID;
		}

		$hierarchy = $this->get_hierarchy($hierarchy);
		
		global $gd_template_settingsprocessor_manager;
		if (!($processor = $gd_template_settingsprocessor_manager->get_processor_by_page($page_id, $hierarchy))) {
		
			return false;
		}

		// If we get an array, then it defines the value on a page by page basis
		// Otherwise, it's true/false, just return it
		$storelocal = $processor->store_local($hierarchy);
		if (is_array($storelocal)) {

			return $storelocal[$page_id];
		}

		return $storelocal;
	}
}

/**---------------------------------------------------------------------------------------------------------------
 * Initialization
 * ---------------------------------------------------------------------------------------------------------------*/
global $gd_template_settingsmanager;
$gd_template_settingsmanager = new GD_Template_SettingsManager();
