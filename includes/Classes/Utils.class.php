<?php
namespace HooAddons\Classes;
use Elementor\Plugin;

class Utils{

	/**
	 * JS & CSS debug
	 *
	 * @since 1.0.0
	 * @access public
	 */
    public static function is_script_debug() {
		return defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG;
	}

	/**
	 * Get Elementor templates List
	 *
	 * @since 1.0.1
	 * @access public
	 *
	 * @return array
	 */
	public static function get_elementor_templates_list() {

		$templateslist = get_posts(
			array(
				'post_type' => 'elementor_library',
				'showposts' => 999,
			)
		);

		if ( ! empty( $templateslist ) && ! is_wp_error( $templateslist ) ) {

			foreach ( $templateslist as $post ) {
				$options[ $post->post_title ] = $post->post_title;
			}

			return $options;
		}
	}

	/**
	 * Get Elementor Template HTML Content
	 *
	 * @since 1.0.1
	 * @access public
	 *
	 * @param string $title Template Title.
	 *
	 * @return $template_content string HTML Markup of the selected template.
	 */
	public static function get_template_content( $title ) {

		$frontend = Plugin::$instance->frontend;

		$id = $this->get_id_by_title( $title );

		$id = apply_filters( 'wpml_object_id', $id, 'elementor_library', true );

		$template_content = $frontend->get_builder_content_for_display( $id, true );

		return $template_content;

	}

}