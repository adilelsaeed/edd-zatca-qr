<?php
/* 
* Plugin Name: EDD Zatca QR Fatora
* Plugin URI: https://adilelsaeed.com/ar/edd-zatca/
* Description: Generate Zatca compatible invoices by including Zatca receipt QR to Easy Digital Downloads Orders
* Version:     1.0.0
* Author: Adil Elsaeed
* Author URI: https://adilelsaeed.com/
* License:     GPLv2 or later
* License URI: https://www.gnu.org/licenses/gpl-2.0.html
* Text Domain: eddzatca
* Domain Path: /languages
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

define( 'EDD_ZATCA_PLUGIN_VERSION', '1.0' );
define( 'EDD_ZATCA_PLUGIN_ITEM_NAME', __('EDD Zatca QR Fatora', 'eddzatca') ); 
define( 'EDD_ZATCA_PLUGIN_FILE', __FILE__ );


require_once __DIR__ . '/inc/settings.php';
require_once __DIR__ . '/lib/generate-qr.php';


/*
* Admin notice to install EDD 
*/
add_action('admin_notices', 'ezq_admin_notice');
function ezq_admin_notice(){
   
    if ( !class_exists('Easy_Digital_Downloads') ) {
         echo '<div class="notice notice-warning is-dismissible">
             <p>'.__( 'Please install Easy Digital Downloads', 'eddzatca') .'</p>
         </div>';
    }

}


/**
 * Load plugin textdomain.
 */
add_action( 'init', 'ezq_load_textdomain');
function ezq_load_textdomain() {
  load_plugin_textdomain( 'eddzatca', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 
}


/**
 * SHow QR in order details (Receipt) page
 */
add_action('edd_order_receipt_after', 'ezq_show_order_qr');
function ezq_show_order_qr($order, $width = 0, $height = 0)
{
    if(edd_get_option('ezq_show_on_order')):
        // generate order qr only if order status is "complete"
        if(edd_get_option('ezq_show_on_completed_order')){
            if(!$order->is_complete()) return;
        }
        $qr_data = ezq_generate_order_qr($order);
        $chs = '100x100';
        echo ezq_show_qr_image($qr_data, $chs);
    endif;
	
}


/**
 * SHow QR in order email receipt
 */
function ezq_show_order_qr_email( $content, $order ) {
    $qr = '';
    if(edd_get_option('ezq_show_on_email')):
        // generate order qr only if order status is "complete"
        if(edd_get_option('ezq_show_on_completed_order')){
            if(!$order->is_complete()) return;
        }
        $qr_data = ezq_generate_order_qr($order);
        $chs = '80x80';
       $qr=  ezq_show_qr_image($qr_data, $chs);
    endif;

	return $content . $qr;
}
add_filter( 'edd_order_receipt', 'ezq_show_order_qr_email', 2, 2 );



function ezq_show_qr_image($qr_data, $chs){
    ob_start();
    $qr_url = "https://image-charts.com/chart?chs=" . $chs . "&cht=qr&chl=". $qr_data . "&choe=UTF-8";
    ?>
    <div class="zatca_order_invoices">
        <img class="zatca_order_qr_code_image" src="<?php echo $qr_url; ?>" />
    </div>  
    <?php
    return ob_get_clean();
}

function ezq_generate_order_qr($order){
    global $edd_options;
	$order_date =   new DateTime($order->date_completed);
	$order_date = $order_date->format('Y-m-d\TH:i:s\Z');
	$order_tax = $order->tax;
	$order_total= $order->total;
	$qr_data = new GenerateQrCode();
    $company_name = edd_get_option('ezq_company_name');
    $tax_number = edd_get_option('ezq_tax_number');
    $qr_data = $qr_data->encoding($company_name, $tax_number, $order_date, $order_total, $order_tax);
    return $qr_data;
}
