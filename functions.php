<?php
/**
 * Divi child theme
 *
 * @package WordPress
 */

if (!defined('ABSPATH')) {
    die();
}

/**
 * Enqueue styles and scripts
 */
function imaggo_enqueue_scripts()
{
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css', null, '1.0');
    wp_enqueue_style('imaggo-style', get_stylesheet_directory_uri() . '/css/main.css', null, '1.0');
    wp_enqueue_script('imaggo-scripts', get_stylesheet_directory_uri() . '/scripts.js', array('jquery'), '1.0', true);
    wp_enqueue_script('ajax-script', get_stylesheet_directory_uri() . '/ajax.js', array('jquery'), '1.0', true);

    wp_localize_script('ajax-script', 'my_ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
}

add_action('wp_enqueue_scripts', 'imaggo_enqueue_scripts', 1);


add_filter('upload_mimes', 'imaggo_mime_types', 1, 1);
function imaggo_mime_types($mime_types)
{
    $mime_types['svg'] = 'image/svg+xml'; // Adding .svg extension
    $mime_types['webp'] = 'image/webp'; // Adding .webp extension

    return $mime_types;

}

/* add faq */
include('faq/faq.php');

add_action('wp_enqueue_scripts', 'wptuts_enqueue');
function wptuts_enqueue()
{
    wp_register_style('wptuts-jquery-ui-style', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.21/themes/south-street/jquery-ui.css');
    wp_enqueue_style('wptuts-jquery-ui-style');

    wp_register_script('wptuts-custom-js', get_template_directory_uri() . '/faq/faq.js', 'jquery-ui-accordion', '', true);
    wp_enqueue_script('wptuts-custom-js');
}


$customtaxo = wp_get_post_terms($post->ID, 'kategorie', array('fields' => 'all'));
if (!empty($customtaxo)) {
    foreach ($customtaxo as $t) {
        echo "<p lass=\"term-$t->term_id\">" . $t->name . "</p>";
    }
}


function translate_message($msg, $product) {

    $eng = array(
        'Upgrade to Lumion 12.x PRO (from Lumion 12)',
        'Upgrade to Lumion 12.x PRO (from Lumion 11)',
        'Upgrade to Lumion 12.x (from Lumion 11)',
        'Upgrade to Lumion 12.x PRO (from Lumion 11)',
        'Upgrade to Lumion 12.x PRO (from Lumion 10)'.
        'Upgrade to Lumion 12.x (from Lumion 10)',
        'Upgrade to Lumion 12.x PRO (from Lumion 10)',
        'Upgrade to Lumion 12.x PRO (from Lumion 9)',
        'Upgrade to Lumion 12.x (from Lumion 9)',
        'Upgrade to Lumion 12.x PRO (from Lumion 9)',
        'Upgrade to Lumion 12.x PRO (from Lumion 1-8)',
        'Upgrade to Lumion 12.x (from Lumion 1-8)',
        'Upgrade to Lumion 12.x PRO (from Lumion 1-8)',
        'Upgrade to Lumion 12.x PRO (from Lumion 1-8)',
        'Upgrade to Lumion 12.x (from Lumion 1-8)',
        'Upgrade to Lumion 12.x PRO (from Lumion 1-8)'

    );

    $pl = array(
        'Upgrade do Lumion 12.x PRO (z Lumion 12)',
        'Upgrade do Lumion 12.x PRO (z Lumion 11)',
        'Upgrade do Lumion 12.x (z Lumion 11)',
        'Upgrade do Lumion 12.x PRO (z Lumion 11 PRO)',
        'Upgrade do Lumion 12.x PRO (z Lumion 10)',
        'Upgrade do Lumion 12.x (z Lumion 10)',
        'Upgrade do Lumion 12.x PRO (z Lumion 10 PRO)',
        'Upgrade do Lumion 12.x PRO (z Lumion 9)',
        'Upgrade do Lumion 12.x (z Lumion 9)',
        'Upgrade do Lumion 12.x PRO (z Lumion 9 PRO)',
        'Upgrade do Lumion 12.x PRO (z Lumion 1-8)',
        'Upgrade do Lumion 12.x (z Lumion 1-8)',
        'Upgrade do Lumion 12.x PRO (z Lumion 1-8 PRO)',
        'Upgrade do Lumion 12.x PRO (z Lumion 1-8)',
        'Upgrade do Lumion 12.x (z Lumion 1-8)',
        'Upgrade do Lumion 12.x PRO (z Lumion 1-8 PRO)',

    );

    $products = array(
        'L12NL12PRO',
        'L11NL12PRO',
        'L11NL12NORM',
        'L11PL12PRO',
        'L10NL12PRO',
        'L10NL12NORM',
        'L10PL12RO',
        'L9NL12PRO',
        'L9NL12NORM',
        'L9PL12PRO',
        'L08NL12PRO',
        'L08NL12NORM',
        'L08PL12PRO',
        'L08NL12PRO',
        'L08NL12NORM',
        'L08PL12PRO'
    );

    $pro = array(
        'LUM8PRO',
        'L8PRO',
        'LUM9PRO',
        'L9PRO',
        'LUM10PRO',
        'L10PRO',
        'LUM11PRO',
        'L11PRO'
    );

    foreach($products as $key => $item) {
        if($item == $product) {
            $msg = $pl[$key];
            break;
        }
    }

    return $msg;

}


// AJAX
add_action('wp_ajax_nopriv_get_upgrade_info', 'get_upgrade_info');
add_action('wp_ajax_get_upgrade_info', 'get_upgrade_info');

function get_upgrade_info()
{
    parse_str($_POST['form'], $form);
    $licence_key = $form['GET_UPGRADE_LINK'];
    $upgrade_return_info = wp_remote_get('https://lumion.com/utilities/OrderService.php?GET_UPGRADE_LINK=' . $licence_key . '&rnd=0.09143386752977523');


    $body = $upgrade_return_info['body'];
    $body = json_decode($body, true);
    $table = $body['Table'];

    if (!empty($table)) {
        $html = "<div class='text-wrapper'><strong>Opcje uaktualnienia licencji</strong> (Kliknij aby dokonać zakupu)</div>";

        foreach ($table as $item) {
            $name = $item['name'];
            $seats = $item['seats'];
            $coupon = $item['discount_coupon'];
            $product = $item['SKU'];
            $translated_name = translate_message($name, $product);
            $shop_url = get_home_url() . '/kup-lumion-upgrade?product='.$product.'&qty=1&type=upgrade&licno=' . $licence_key;

            if($coupon) {
                $shop_url .= '&coupon=' . $coupon;
            }

            $html .= '<a style="display: block" href="'.$shop_url.'">' . $translated_name . '</a>';
        }

    } else {
       $html = '<div class="text-wrapper">Przepraszamy, nie rozpoznaliśmy klucza licencyjnego lub Twoja licencja jest wciąż aktualna.<br/>Jeśli masz jakiekolwiek pytania, skontaktuj się z nami. <br/> <a href="'.get_home_url().'/kontakt">skontaktuj się z nami</a></div>';
    }

    echo $html;
    wp_die();
}


add_action('wp_ajax_nopriv_get_seats_info', 'get_seats_info');
add_action('wp_ajax_get_seats_info', 'get_seats_info');

function get_seats_info(){
    parse_str($_POST['form'], $form);
    $licence_key = $form['GET_EXTRA_SEATS_LINK'];
    $upgrade_return_info = wp_remote_get('https://lumion.com/utilities/OrderService.php?GET_EXTRA_SEATS_LINK=' . $licence_key . '&rnd=0.09143386752977523');

    $body = $upgrade_return_info['body'];
    $body = json_decode($body, true);
    $table = $body['Table'];
    $action_after_response = 'redirect';

    if (!empty($table)) {

        $product_name = 'LUM12PROSEAT';

        if (strpos($licence_key, '12NORM') !== false) {
            $product_name = 'LUM12NORMSEAT';
        }

        $shop_url = get_home_url() .'/kup-stanowisko?product='.$product_name.'&type=extra-seats&licno=' . $licence_key;
        $data = $shop_url;
    }
    elseif (strpos($licence_key, '12NORM') !== false || strpos($licence_key, '12PRO') !== false) {
        $product_name = 'LUM12PROSEAT';

        if (strpos($licence_key, '12NORM') !== false) {
            $product_name = 'LUM12NORMSEAT';
        }

        $shop_url = get_home_url() .'/kup-stanowisko?product='.$product_name.'&type=extra-seats&licno=' . $licence_key;
        $data = $shop_url;
    }
    else {
        $action_after_response = 'html';
        $data = '<div class="text-wrapper">Możesz dodawać stanowiska tylko do kluczy licencyjnych Lumion 12. Aby dodać stanowiska do aktualnej licencji, zamów najpierw upgrade do Lumion 12.<br/> <a href="' . get_home_url() . '/kup-lumion-upgrade">zamów najpierw upgrade do Lumion 12</a> <br/>Jeśli masz jakiekolwiek pytania, skontaktuj się z nami. <a href="' . get_home_url() . '/kontakt">skontaktuj się z nami</a></div>';
    }

    $response = array(
        'action' => $action_after_response,
        'data' => $data
    );

    $response = json_encode($response);
    echo $response;
    wp_die();
}


if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page(array(
		'page_title' 	=> 'Opcje dodatkowe',
		'menu_title'	=> 'Opcje dodatkowe',
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
	
	
	
}

