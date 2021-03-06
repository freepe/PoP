<?php
/**---------------------------------------------------------------------------------------------------------------
 *
 * Template Manager (Handlebars)
 *
 * ---------------------------------------------------------------------------------------------------------------*/

define ('GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_PRO_GENERALCOUNT', PoP_ServerUtils::get_template_definition('buttoncontrol-opinionatedvote-pro-generalcount'));
define ('GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_NEUTRAL_GENERALCOUNT', PoP_ServerUtils::get_template_definition('buttoncontrol-opinionatedvote-neutral-generalcount'));
define ('GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_AGAINST_GENERALCOUNT', PoP_ServerUtils::get_template_definition('buttoncontrol-opinionatedvote-against-generalcount'));
define ('GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_PRO_ARTICLECOUNT', PoP_ServerUtils::get_template_definition('buttoncontrol-opinionatedvote-pro-articlecount'));
define ('GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_NEUTRAL_ARTICLECOUNT', PoP_ServerUtils::get_template_definition('buttoncontrol-opinionatedvote-neutral-articlecount'));
define ('GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_AGAINST_ARTICLECOUNT', PoP_ServerUtils::get_template_definition('buttoncontrol-opinionatedvote-against-articlecount'));
define ('GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_PRO_COUNT', PoP_ServerUtils::get_template_definition('buttoncontrol-opinionatedvote-pro-count'));
define ('GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_NEUTRAL_COUNT', PoP_ServerUtils::get_template_definition('buttoncontrol-opinionatedvote-neutral-count'));
define ('GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_AGAINST_COUNT', PoP_ServerUtils::get_template_definition('buttoncontrol-opinionatedvote-against-count'));

class VotingProcessors_Template_Processor_CustomAnchorControls extends GD_Template_Processor_AnchorControlsBase {

	function get_templates_to_process() {
	
		return array(
			GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_PRO_GENERALCOUNT,
			GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_NEUTRAL_GENERALCOUNT,
			GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_AGAINST_GENERALCOUNT,
			GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_PRO_ARTICLECOUNT,
			GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_NEUTRAL_ARTICLECOUNT,
			GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_AGAINST_ARTICLECOUNT,
			GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_PRO_COUNT,
			GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_NEUTRAL_COUNT,
			GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_AGAINST_COUNT,
		);
	}

	function get_target($template_id, $atts) {

		switch ($template_id) {

			case GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_PRO_GENERALCOUNT:
			case GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_NEUTRAL_GENERALCOUNT:
			case GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_AGAINST_GENERALCOUNT:
			case GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_PRO_ARTICLECOUNT:
			case GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_NEUTRAL_ARTICLECOUNT:
			case GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_AGAINST_ARTICLECOUNT:
			case GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_PRO_COUNT:
			case GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_NEUTRAL_COUNT:
			case GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_AGAINST_COUNT:
				
				return GD_URLPARAM_TARGET_QUICKVIEW;
		}

		return parent::get_target($template_id, $atts);
	}

	function get_runtimetext($template_id, $atts) {

		switch ($template_id) {

			case GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_PRO_GENERALCOUNT:
			case GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_NEUTRAL_GENERALCOUNT:
			case GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_AGAINST_GENERALCOUNT:
			case GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_PRO_ARTICLECOUNT:
			case GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_NEUTRAL_ARTICLECOUNT:
			case GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_AGAINST_ARTICLECOUNT:
			case GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_PRO_COUNT:
			case GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_NEUTRAL_COUNT:
			case GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_AGAINST_COUNT:
				
				$pro = __('Pro', 'poptheme-wassup-votingprocessors');
				$neutral = __('Neutral', 'poptheme-wassup-votingprocessors');
				$against = __('Against', 'poptheme-wassup-votingprocessors');

				$labels = array(
					GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_PRO_GENERALCOUNT => $pro,
					GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_NEUTRAL_GENERALCOUNT => $neutral,
					GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_AGAINST_GENERALCOUNT => $against,
					GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_PRO_ARTICLECOUNT => $pro,
					GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_NEUTRAL_ARTICLECOUNT => $neutral,
					GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_AGAINST_ARTICLECOUNT => $against,
					GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_PRO_COUNT => $pro,
					GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_NEUTRAL_COUNT => $neutral,
					GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_AGAINST_COUNT => $against,
				);
				$label = $labels[$template_id];
				$cats = array(
					GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_PRO_GENERALCOUNT => POPTHEME_WASSUP_VOTINGPROCESSORS_CAT_OPINIONATEDVOTES_PRO,
					GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_NEUTRAL_GENERALCOUNT => POPTHEME_WASSUP_VOTINGPROCESSORS_CAT_OPINIONATEDVOTES_NEUTRAL,
					GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_AGAINST_GENERALCOUNT => POPTHEME_WASSUP_VOTINGPROCESSORS_CAT_OPINIONATEDVOTES_AGAINST,
					GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_PRO_ARTICLECOUNT => POPTHEME_WASSUP_VOTINGPROCESSORS_CAT_OPINIONATEDVOTES_PRO,
					GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_NEUTRAL_ARTICLECOUNT => POPTHEME_WASSUP_VOTINGPROCESSORS_CAT_OPINIONATEDVOTES_NEUTRAL,
					GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_AGAINST_ARTICLECOUNT => POPTHEME_WASSUP_VOTINGPROCESSORS_CAT_OPINIONATEDVOTES_AGAINST,
					GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_PRO_COUNT => POPTHEME_WASSUP_VOTINGPROCESSORS_CAT_OPINIONATEDVOTES_PRO,
					GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_NEUTRAL_COUNT => POPTHEME_WASSUP_VOTINGPROCESSORS_CAT_OPINIONATEDVOTES_NEUTRAL,
					GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_AGAINST_COUNT => POPTHEME_WASSUP_VOTINGPROCESSORS_CAT_OPINIONATEDVOTES_AGAINST,
				);

				$general = array(
					GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_PRO_GENERALCOUNT,
					GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_NEUTRAL_GENERALCOUNT,
					GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_AGAINST_GENERALCOUNT,
				);
				$article = array(
					GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_PRO_ARTICLECOUNT,
					GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_NEUTRAL_ARTICLECOUNT,
					GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_AGAINST_ARTICLECOUNT,
				);
				$combined = array(
					GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_PRO_COUNT,
					GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_NEUTRAL_COUNT,
					GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_AGAINST_COUNT,
				);

				$query = array();

				if (in_array($template_id, $general)) {

					// Query all the General thoughts about TPP: add query args
					VotingProcessors_Template_Processor_CustomSectionBlocksUtils::add_dataloadqueryargs_opinionatedvotereferences($query);
				}
				elseif (in_array($template_id, $article)) {

					// Query all the General thoughts about TPP: add query args
					VotingProcessors_Template_Processor_CustomSectionBlocksUtils::add_dataloadqueryargs_articleopinionatedvotereferences($query);
				}

				// Override the category
				$query['cat'] = $cats[$template_id];

				// All results
				$query['posts_per_page'] = 0;
				$query['fields'] = 'ids';

				// Taken from https://stackoverflow.com/questions/2504311/wordpress-get-post-count
				$wp_query = new WP_Query();
				$wp_query->query($query);
				$count = $wp_query->found_posts;

				return sprintf(
					'<strong>%s</strong> %s',
					$count,
					$label
				);
		}

		return parent::get_runtimetext($template_id, $atts);
	}
	function get_fontawesome($template_id, $atts) {
				
		$pages = array(
			GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_PRO_GENERALCOUNT => POPTHEME_WASSUP_VOTINGPROCESSORS_PAGE_OPINIONATEDVOTES_PRO_GENERAL,
			GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_NEUTRAL_GENERALCOUNT => POPTHEME_WASSUP_VOTINGPROCESSORS_PAGE_OPINIONATEDVOTES_NEUTRAL_GENERAL,
			GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_AGAINST_GENERALCOUNT => POPTHEME_WASSUP_VOTINGPROCESSORS_PAGE_OPINIONATEDVOTES_AGAINST_GENERAL,
			GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_PRO_ARTICLECOUNT => POPTHEME_WASSUP_VOTINGPROCESSORS_PAGE_OPINIONATEDVOTES_PRO_ARTICLE,
			GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_NEUTRAL_ARTICLECOUNT => POPTHEME_WASSUP_VOTINGPROCESSORS_PAGE_OPINIONATEDVOTES_NEUTRAL_ARTICLE,
			GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_AGAINST_ARTICLECOUNT => POPTHEME_WASSUP_VOTINGPROCESSORS_PAGE_OPINIONATEDVOTES_AGAINST_ARTICLE,
			GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_PRO_COUNT => POPTHEME_WASSUP_VOTINGPROCESSORS_PAGE_OPINIONATEDVOTES_PRO,
			GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_NEUTRAL_COUNT => POPTHEME_WASSUP_VOTINGPROCESSORS_PAGE_OPINIONATEDVOTES_NEUTRAL,
			GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_AGAINST_COUNT => POPTHEME_WASSUP_VOTINGPROCESSORS_PAGE_OPINIONATEDVOTES_AGAINST,
		);
		if ($page = $pages[$template_id]) {
		
			return gd_navigation_menu_item($page, false);
		}

		return parent::get_fontawesome($template_id, $atts);
	}
	function get_href($template_id, $atts) {

		$pages = array(
			GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_PRO_GENERALCOUNT => POPTHEME_WASSUP_VOTINGPROCESSORS_PAGE_OPINIONATEDVOTES_PRO_GENERAL,
			GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_NEUTRAL_GENERALCOUNT => POPTHEME_WASSUP_VOTINGPROCESSORS_PAGE_OPINIONATEDVOTES_NEUTRAL_GENERAL,
			GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_AGAINST_GENERALCOUNT => POPTHEME_WASSUP_VOTINGPROCESSORS_PAGE_OPINIONATEDVOTES_AGAINST_GENERAL,
			GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_PRO_ARTICLECOUNT => POPTHEME_WASSUP_VOTINGPROCESSORS_PAGE_OPINIONATEDVOTES_PRO_ARTICLE,
			GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_NEUTRAL_ARTICLECOUNT => POPTHEME_WASSUP_VOTINGPROCESSORS_PAGE_OPINIONATEDVOTES_NEUTRAL_ARTICLE,
			GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_AGAINST_ARTICLECOUNT => POPTHEME_WASSUP_VOTINGPROCESSORS_PAGE_OPINIONATEDVOTES_AGAINST_ARTICLE,
			GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_PRO_COUNT => POPTHEME_WASSUP_VOTINGPROCESSORS_PAGE_OPINIONATEDVOTES_PRO,
			GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_NEUTRAL_COUNT => POPTHEME_WASSUP_VOTINGPROCESSORS_PAGE_OPINIONATEDVOTES_NEUTRAL,
			GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_AGAINST_COUNT => POPTHEME_WASSUP_VOTINGPROCESSORS_PAGE_OPINIONATEDVOTES_AGAINST,
		);
		if ($page = $pages[$template_id]) {
				
			return get_permalink($page);
		}

		return parent::get_href($template_id, $atts);
	}
	function init_atts($template_id, &$atts) {

		switch ($template_id) {

			case GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_PRO_GENERALCOUNT:
			case GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_NEUTRAL_GENERALCOUNT:
			case GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_AGAINST_GENERALCOUNT:
			case GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_PRO_ARTICLECOUNT:
			case GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_NEUTRAL_ARTICLECOUNT:
			case GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_AGAINST_ARTICLECOUNT:
			case GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_PRO_COUNT:
			case GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_NEUTRAL_COUNT:
			case GD_TEMPLATE_ANCHORCONTROL_OPINIONATEDVOTE_AGAINST_COUNT:

				$this->append_att($template_id, $atts, 'class', 'btn btn-link');
				break;
		}

		return parent::init_atts($template_id, $atts);
	}
}

/**---------------------------------------------------------------------------------------------------------------
 * Initialization
 * ---------------------------------------------------------------------------------------------------------------*/
new VotingProcessors_Template_Processor_CustomAnchorControls();