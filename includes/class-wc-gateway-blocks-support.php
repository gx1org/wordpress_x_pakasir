<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
use Automattic\WooCommerce\Blocks\Payments\Integrations\AbstractPaymentMethodType;

/**
 * WC_Gateway_Blocks_Support class.
 *
 * This class provides a custom payment gateway integration for WooCommerce Blocks, enabling compatibility
 * with the block-based checkout experience. Extending WooCommerce's AbstractPaymentMethodType, this class
 * handles both frontend and backend operations for the custom gateway, such as initializing settings,
 * enqueuing scripts, and processing custom fields in the checkout context.
 *
 * @package WooCommerce\Blocks\Payments\Integrations
 */
final class WC_Gateway_Blocks_Support extends AbstractPaymentMethodType {

	/**
	 * The unique identifier for the custom payment gateway.
	 *
	 * This ID is used to register and manage the gateway within WooCommerce.
	 * It is also utilized in settings retrieval and script handles specific to this gateway.
	 *
	 * @var string
	 */
	protected $name = 'pakasir'; // payment gateway id.

	/**
	 * Constructor.
	 *
	 * Sets up the gateway by adding the necessary action for processing payments with context.
	 */
	public function __construct() {
	}

	/**
	 * Initializes the payment method.
	 *
	 * This function will get called during the server side initialization process and is a good place to put any settings
	 * population etc. Basically anything you need to do to initialize your gateway.
	 *
	 * Note, this will be called on every request so don't put anything expensive here.
	 */
	public function initialize() {
		// get payment gateway settings.
		$this->settings = get_option( "woocommerce_{$this->name}_settings", array() );
	}

	/**
	 * This should return whether the payment method is active or not.
	 *
	 * If false, the scripts will not be enqueued.
	 *
	 * @return boolean
	 */
	public function is_active() {
		return filter_var( $this->get_setting( 'enabled', false ), FILTER_VALIDATE_BOOLEAN );
	}

	/**
	 * Returns an array of scripts/handles to be registered for this payment method.
	 *
	 * @return array
	 */
	public function get_payment_method_script_handles() {
		wp_register_script(
			'pakasir-block',
			plugin_dir_url( __DIR__ ) . 'assets/pakasir-blocks.js',
			['react-jsx-runtime', 'wp-element', 'wp-html-entities', 'wp-i18n'],
			time(),
			true
		);

		return array( 'pakasir-block' );
	}

	public function get_payment_method_script_handles_for_admin() {
		return $this->get_payment_method_script_handles();
	}

	public function get_payment_method_data() {
		return array(
			'title'          => $this->get_setting( 'title' ),
			'description'    => $this->get_setting( 'description' ),
			'supports'       => $this->get_supported_features(),
		);
	}

}
