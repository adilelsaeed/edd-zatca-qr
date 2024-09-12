<?php
/**
 * Settings
 *
 * Registers all the settings required for the plugin.
 *
 * @package EDD Zatca QR Fatora
 * @since 1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Registers the settings section
 *
 * @since 2.2.20
 *
 * @param array $sections Array of EDD Extensions settings sections
 *
 * @return array The modified EDD Extensions settings section array
 */
function ezq_settings_section( $sections ) {
	$sections['eddzatca-settings'] = __( 'Zatca QR Fatora ', 'eddzatca' );
	return $sections;
}
add_filter( 'edd_settings_sections_extensions', 'ezq_settings_section' );

/**
 * Add Settings
 *
 * Adds the new settings for the plugin
 *
 * @since 1.0
 *
 * @param array $settings Array of pre-defined setttings
 *
 * @return array Merged array with new settings
 */
function ezq_add_settings( $settings ) {
	$ezq_settings = array(
		array(
			'id'   => 'ezq_settings',
			'name' => '<strong>' . __( 'Zatca QR Fatora Settings', 'eddzatca' ) . '</strong>',
			'desc' => __( 'Configure the Zatca QR Fatora settings', 'eddzatca' ),
			'type' => 'header'
		),
		array(
			'id'      => 'ezq_show_on_order',
			'name'    => __( 'Show QR On Order Page', 'eddzatca' ),
			'desc'    => __( 'Check this box to Show QR On Order Page.', 'eddzatca' ),
			'type'    => 'checkbox',
            'std'     => 'checked'
		),
        array(
			'id'      => 'ezq_show_on_completed_order',
			'name'    => __( 'Show QR Only on Completed Order', 'eddzatca' ),
			'desc'    => __( 'Check this box to Show QR Only on Completed Order (Which is recommended to met Zatca standards.', 'eddzatca' ),
			'type'    => 'checkbox',
            'std'     => true
		),

		array(
			'id'      => 'ezq_show_on_email',
			'name'    => __( 'Show QR On Order Email', 'eddzatca' ),
			'desc'    => __( 'Check this box to Show QR On Order Email.', 'eddzatca' ),
			'type'    => 'checkbox',
            'std'     => true
		),

		array(
			'id'   => 'ezq_company_name',
			'name' => __( 'Company Name', 'eddzatca' ),
			'desc' => __( 'Enter the legal company name that will be Used on the QR.', 'eddzatca' ),
			'type' => 'text',
			'size' => 'regular',
			'std'  => edd_get_option('entity_name')
		),

        array(
            'id'   => 'ezq_tax_number',
            'name' => __( 'Company Tax Number', 'eddzatca' ),
            'desc' => __( 'Enter the Company Tax Number.',
                'eddzatca' ),
            'type' => 'text',
            'size' => 'regular',
            'std'  => ''
        ),
		// array(
		// 	'id'   => 'ezq_email_settings',
		// 	'name' => '<strong>' . __( 'PDF Invoice Email Settings', 'eddzatca' ) . '</strong>',
		// 	'type' => 'header'
		// ),
		// array(
		// 	'id'   => 'ezq_email_logo',
		// 	'name' => __( 'Email Logo', 'eddzatca' ),
		// 	'desc' => __( 'Upload or choose a logo to be displayed at the top of the email', 'eddzatca' ),
		// 	'type' => 'upload',
		// 	'size' => 'regular'
		// )
	);

	if ( version_compare( EDD_VERSION, 2.5, '>=' ) ) {
		$ezq_settings = array( 'eddzatca-settings' => $ezq_settings );
	}

	return array_merge( $settings, $ezq_settings );
}
add_filter( 'edd_settings_extensions', 'ezq_add_settings' );

