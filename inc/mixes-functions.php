<?php
/**
 * $Desc$
 *
 * @version    $Id$
 * @package    opaljob
 * @author     Opal  Team <opalwordpressl@gmail.com >
 * @copyright  Copyright (C) 2016 wpopal.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @website  http://www.wpopal.com
 * @support  http://www.wpopal.com/support/forum.html
 */
 
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

function opaljob_get_image_placeholder( $size, $url=false ){

    global $_wp_additional_sizes;

    $width  = 0;
    $height = 0;
    $img_text   = get_bloginfo('name');

    if ( in_array( $size , array( 'thumbnail', 'medium', 'large' ) ) ) {
        $width = get_option( $size . '_size_w' );
        $height = get_option( $size . '_size_h' );

    } elseif ( isset( $_wp_additional_sizes[$size] ) ) {

        $width = $_wp_additional_sizes[ $size ]['width'];
        $height = $_wp_additional_sizes[ $size ]['height'];
    }

    if( intval( $width ) > 0 && intval( $height ) > 0 ) {
        if( $url ){
           return 'http://placehold.it/' . $width . 'x' . $height . '&text=' . urlencode( $img_text ) ;
        }
        return '<img src="http://placehold.it/' . $width . 'x' . $height . '&text=' . urlencode( $img_text ) . '" />';
    }
}



/**
 * batch including all files in a path.
 *
 * @param String $path : PATH_DIR/*.php or PATH_DIR with $ifiles not empty
 */
function opaljob_includes( $path, $ifiles=array() ){

    if( !empty($ifiles) ){
         foreach( $ifiles as $key => $file ){
            $file  = $path.'/'.$file; 
            if(is_file($file)){
                require($file);
            }
         }   
    }else {

        $files = glob($path);
        foreach ($files as $key => $file) {
            if(is_file($file)){
                require($file);
               
            }
        }
    }
}

/**
 *
 */
function opaljob_works( $id ){
    global $work; 

    $work = new Opaljob_Work( $id );

    return $work; 
}

function opaljob_resumes( $id ){
    global $resume; 

    $resume = new Opaljob_Resume( $id );

    return $resume; 
}
function get_user_role() { // returns current user's role
    global $current_user;
    $user_roles = $current_user->roles;
    $user_role = array_shift($user_roles);
    return $user_role; // return translate_user_role( $user_role );
}

function opaljob_options( $key, $default = '' ){
    
    global $opaljob_options; 
    
    $value =  isset($opaljob_options[ $key ]) ? $opaljob_options[ $key ] : $default;
    
    $value = apply_filters( 'opaljob_option_', $value, $key, $default );
    
  
    return apply_filters( 'opaljob_option_' . $key, $value, $key, $default );
}

/**
 *
 */
function opaljob_get_currencies() {
    $currencies = array(
        'USD'  => __( 'US Dollars (&#36;)', 'give' ),
        'EUR'  => __( 'Euros (&euro;)', 'give' ),
        'GBP'  => __( 'Pounds Sterling (&pound;)', 'give' ),
        'AUD'  => __( 'Australian Dollars (&#36;)', 'give' ),
        'BRL'  => __( 'Brazilian Real (R&#36;)', 'give' ),
        'CAD'  => __( 'Canadian Dollars (&#36;)', 'give' ),
        'CZK'  => __( 'Czech Koruna', 'give' ),
        'DKK'  => __( 'Danish Krone', 'give' ),
        'HKD'  => __( 'Hong Kong Dollar (&#36;)', 'give' ),
        'HUF'  => __( 'Hungarian Forint', 'give' ),
        'ILS'  => __( 'Israeli Shekel (&#8362;)', 'give' ),
        'JPY'  => __( 'Japanese Yen (&yen;)', 'give' ),
        'MYR'  => __( 'Malaysian Ringgits', 'give' ),
        'MXN'  => __( 'Mexican Peso (&#36;)', 'give' ),
        'NZD'  => __( 'New Zealand Dollar (&#36;)', 'give' ),
        'NOK'  => __( 'Norwegian Krone (Kr.)', 'give' ),
        'PHP'  => __( 'Philippine Pesos', 'give' ),
        'PLN'  => __( 'Polish Zloty', 'give' ),
        'SGD'  => __( 'Singapore Dollar (&#36;)', 'give' ),
        'SEK'  => __( 'Swedish Krona', 'give' ),
        'CHF'  => __( 'Swiss Franc', 'give' ),
        'TWD'  => __( 'Taiwan New Dollars', 'give' ),
        'TOpaljob'  => __( 'Thai Baht (&#3647;)', 'give' ),
        'INR'  => __( 'Indian Rupee (&#8377;)', 'give' ),
        'TRY'  => __( 'Turkish Lira (&#8378;)', 'give' ),
        'RIAL' => __( 'Iranian Rial (&#65020;)', 'give' ),
        'RUB'  => __( 'Russian Rubles', 'give' )
    );

    return apply_filters( 'opaljob_currencies', $currencies );
}

 /**
 * Get the price format depending on the currency position
 *
 * @return string
 */
function opaljob_price_format_position() {
    global $opaljob_options;
    $currency_pos = opaljob_options('currency_position','before');

    $format = '%1$s%2$s';
    switch ( $currency_pos ) {
        case 'before' :
            $format = '%1$s%2$s';
        break;
        case 'after' :
            $format = '%2$s%1$s';
        break;
        case 'left_space' :
            $format = '%1$s&nbsp;%2$s';
        break;
        case 'right_space' :
            $format = '%2$s&nbsp;%1$s';
        break;
    }

    return apply_filters( 'opaljob_price_format_position', $format, $currency_pos );
}

/**
 *
 */
function opaljob_price_format( $price, $args=array() ){

    $price = opaljob_price( $price , $args );
    $price = sprintf( opaljob_price_format_position(), opaljob_currency_symbol(), $price );
 
    return apply_filters( 'opaljob_price_format', $price ); 
}

function opaljob_get_currency( ){
    return opaljob_options( 'currency', 'USD' );
}

/**
 *
 */
function opaljob_currency_symbol( $currency = '' ) {
    if ( ! $currency ) {
        $currency = opaljob_get_currency();
    }

    switch ( $currency ) {
        case 'AED' :
            $currency_symbol = 'د.إ';
            break;
        case 'BDT':
            $currency_symbol = '&#2547;&nbsp;';
            break;
        case 'BRL' :
            $currency_symbol = '&#82;&#36;';
            break;
        case 'BGN' :
            $currency_symbol = '&#1083;&#1074;.';
            break;
        case 'AUD' :
        case 'CAD' :
        case 'CLP' :
        case 'COP' :
        case 'MXN' :
        case 'NZD' :
        case 'HKD' :
        case 'SGD' :
        case 'USD' :
            $currency_symbol = '&#36;';
            break;
        case 'EUR' :
            $currency_symbol = '&euro;';
            break;
        case 'CNY' :
        case 'RMB' :
        case 'JPY' :
            $currency_symbol = '&yen;';
            break;
        case 'RUB' :
            $currency_symbol = '&#1088;&#1091;&#1073;.';
            break;
        case 'KRW' : $currency_symbol = '&#8361;'; break;
            case 'PYG' : $currency_symbol = '&#8370;'; break;
        case 'TRY' : $currency_symbol = '&#8378;'; break;
        case 'NOK' : $currency_symbol = '&#107;&#114;'; break;
        case 'ZAR' : $currency_symbol = '&#82;'; break;
        case 'CZK' : $currency_symbol = '&#75;&#269;'; break;
        case 'MYR' : $currency_symbol = '&#82;&#77;'; break;
        case 'DKK' : $currency_symbol = 'kr.'; break;
        case 'HUF' : $currency_symbol = '&#70;&#116;'; break;
        case 'IDR' : $currency_symbol = 'Rp'; break;
        case 'INR' : $currency_symbol = 'Rs.'; break;
        case 'NPR' : $currency_symbol = 'Rs.'; break;
        case 'ISK' : $currency_symbol = 'Kr.'; break;
        case 'ILS' : $currency_symbol = '&#8362;'; break;
        case 'PHP' : $currency_symbol = '&#8369;'; break;
        case 'PLN' : $currency_symbol = '&#122;&#322;'; break;
        case 'SEK' : $currency_symbol = '&#107;&#114;'; break;
        case 'CHF' : $currency_symbol = '&#67;&#72;&#70;'; break;
        case 'TWD' : $currency_symbol = '&#78;&#84;&#36;'; break;
        case 'TOpaljob' : $currency_symbol = '&#3647;'; break;
        case 'GBP' : $currency_symbol = '&pound;'; break;
        case 'RON' : $currency_symbol = 'lei'; break;
        case 'VND' : $currency_symbol = '&#8363;'; break;
        case 'NGN' : $currency_symbol = '&#8358;'; break;
        case 'HRK' : $currency_symbol = 'Kn'; break;
        case 'EGP' : $currency_symbol = 'EGP'; break;
        case 'DOP' : $currency_symbol = 'RD&#36;'; break;
        case 'KIP' : $currency_symbol = '&#8365;'; break;
        default    : $currency_symbol = ''; break;
    }

    return apply_filters( 'opaljob_currency_symbol', $currency_symbol, $currency );
} 

/**
 * Return the thousand separator for prices
 * @since  2.3
 * @return string
 */
function opaljob_get_price_thousand_separator() {
    $separator = stripslashes( opaljob_options( 'thousands_separator' ) );
    return $separator;
}

/**
 * Return the decimal separator for prices
 * @since  2.3
 * @return string
 */
function opaljob_get_price_decimal_separator() {
    $separator = stripslashes( opaljob_options( 'decimal_separator' ,'.') );
    return $separator ? $separator : '.';
}

/**
 * Return the number of decimals after the decimal point.
 * @since  2.3
 * @return int
 */
function opaljob_get_price_decimals() {
    return absint( opaljob_options( 'price_num_decimals', 2 ) );
}


/**
 *
 */    
function opaljob_price( $price, $args=array() ){

    $negative = $price < 0;

    if( $negative ) {
        $price = substr( $price, 1 );  
    }
    

    extract( apply_filters( 'opaljob_price_args', wp_parse_args( $args, array(
        'ex_tax_label'       => false,
        'decimal_separator'  => opaljob_get_price_decimal_separator(),
        'thousand_separator' => opaljob_get_price_thousand_separator(),
        'decimals'           => opaljob_get_price_decimals(),
 
    ) ) ) );

    $negative        = $price < 0;
    $price           = apply_filters( 'opaljob_raw_price', floatval( $negative ? $price * -1 : $price ) );
    $price           = apply_filters( 'opaljob_formatted_price', number_format( $price, $decimals, $decimal_separator, $thousand_separator ), $price, $decimals, $decimal_separator, $thousand_separator );

    return $price;     
}

/**
 *
 *  Applyer function to show unit for work
 */

function opaljob_areasize_unit_format( $value='' ){
    return  $value . ' ' . '<span>'.'m2'.'</span>';
}

add_filter( 'opaljob_areasize_unit_format', 'opaljob_areasize_unit_format' );

/**
 *
 *  Applyer function to show unit for work
 */
if(!function_exists('opaljob_fnc_excerpt')){
    //Custom Excerpt Function
    function opaljob_fnc_excerpt($limit,$afterlimit='[...]') {
        $excerpt = get_the_excerpt();
        if( $excerpt != ''){
           $excerpt = explode(' ', strip_tags( $excerpt ), $limit);
        }else{
            $excerpt = explode(' ', strip_tags(get_the_content( )), $limit);
        }
        if (count($excerpt)>=$limit) {
            array_pop($excerpt);
            $excerpt = implode(" ",$excerpt).' '.$afterlimit;
        } else {
            $excerpt = implode(" ",$excerpt);
        }
        $excerpt = preg_replace('`[[^]]*]`','',$excerpt);
        return strip_shortcodes( $excerpt );
    }
}


/**
 *
 */
function opaljob_is_own_work( $post_id, $user_id ){
        
    $post = get_post( $post_id );
    wp_reset_postdata();
    if( !is_object($post)  || !$post->ID ){
        return false;
    }
    return $user_id == $post->post_author;    
}

if(!function_exists('convertAccentsAndSpecialToNormal')):
function convertAccentsAndSpecialToNormal($string) {
    $table = array(
        'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Ă'=>'A', 'Ā'=>'A', 'Ą'=>'A', 'Æ'=>'A', 'Ǽ'=>'A',
        'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'ă'=>'a', 'ā'=>'a', 'ą'=>'a', 'æ'=>'a', 'ǽ'=>'a',

        'Þ'=>'B', 'þ'=>'b', 'ß'=>'Ss',

        'Ç'=>'C', 'Č'=>'C', 'Ć'=>'C', 'Ĉ'=>'C', 'Ċ'=>'C',
        'ç'=>'c', 'č'=>'c', 'ć'=>'c', 'ĉ'=>'c', 'ċ'=>'c',

        'Đ'=>'Dj', 'Ď'=>'D', 'Đ'=>'D',
        'đ'=>'dj', 'ď'=>'d',

        'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'Ĕ'=>'E', 'Ē'=>'E', 'Ę'=>'E', 'Ė'=>'E',
        'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ĕ'=>'e', 'ē'=>'e', 'ę'=>'e', 'ė'=>'e',

        'Ĝ'=>'G', 'Ğ'=>'G', 'Ġ'=>'G', 'Ģ'=>'G',
        'ĝ'=>'g', 'ğ'=>'g', 'ġ'=>'g', 'ģ'=>'g',

        'Ĥ'=>'H', 'Ħ'=>'H',
        'ĥ'=>'h', 'ħ'=>'h',

        'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'İ'=>'I', 'Ĩ'=>'I', 'Ī'=>'I', 'Ĭ'=>'I', 'Į'=>'I',
        'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'į'=>'i', 'ĩ'=>'i', 'ī'=>'i', 'ĭ'=>'i', 'ı'=>'i',

        'Ĵ'=>'J',
        'ĵ'=>'j',

        'Ķ'=>'K',
        'ķ'=>'k', 'ĸ'=>'k',

        'Ĺ'=>'L', 'Ļ'=>'L', 'Ľ'=>'L', 'Ŀ'=>'L', 'Ł'=>'L',
        'ĺ'=>'l', 'ļ'=>'l', 'ľ'=>'l', 'ŀ'=>'l', 'ł'=>'l',

        'Ñ'=>'N', 'Ń'=>'N', 'Ň'=>'N', 'Ņ'=>'N', 'Ŋ'=>'N',
        'ñ'=>'n', 'ń'=>'n', 'ň'=>'n', 'ņ'=>'n', 'ŋ'=>'n', 'ŉ'=>'n',

        'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ō'=>'O', 'Ŏ'=>'O', 'Ő'=>'O', 'Œ'=>'O',
        'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ō'=>'o', 'ŏ'=>'o', 'ő'=>'o', 'œ'=>'o', 'ð'=>'o',

        'Ŕ'=>'R', 'Ř'=>'R',
        'ŕ'=>'r', 'ř'=>'r', 'ŗ'=>'r',

        'Š'=>'S', 'Ŝ'=>'S', 'Ś'=>'S', 'Ş'=>'S',
        'š'=>'s', 'ŝ'=>'s', 'ś'=>'s', 'ş'=>'s',

        'Ŧ'=>'T', 'Ţ'=>'T', 'Ť'=>'T',
        'ŧ'=>'t', 'ţ'=>'t', 'ť'=>'t',

        'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ũ'=>'U', 'Ū'=>'U', 'Ŭ'=>'U', 'Ů'=>'U', 'Ű'=>'U', 'Ų'=>'U',
        'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ü'=>'u', 'ũ'=>'u', 'ū'=>'u', 'ŭ'=>'u', 'ů'=>'u', 'ű'=>'u', 'ų'=>'u',

        'Ŵ'=>'W', 'Ẁ'=>'W', 'Ẃ'=>'W', 'Ẅ'=>'W',
        'ŵ'=>'w', 'ẁ'=>'w', 'ẃ'=>'w', 'ẅ'=>'w',

        'Ý'=>'Y', 'Ÿ'=>'Y', 'Ŷ'=>'Y',
        'ý'=>'y', 'ÿ'=>'y', 'ŷ'=>'y',

        'Ž'=>'Z', 'Ź'=>'Z', 'Ż'=>'Z', 'Ž'=>'Z',
        'ž'=>'z', 'ź'=>'z', 'ż'=>'z', 'ž'=>'z',

        '“'=>'"', '”'=>'"', '‘'=>"'", '’'=>"'", '•'=>'-', '…'=>'...', '—'=>'-', '–'=>'-', '¿'=>'?', '¡'=>'!', '°'=>' degrees ',
        '¼'=>' 1/4 ', '½'=>' 1/2 ', '¾'=>' 3/4 ', '⅓'=>' 1/3 ', '⅔'=>' 2/3 ', '⅛'=>' 1/8 ', '⅜'=>' 3/8 ', '⅝'=>' 5/8 ', '⅞'=>' 7/8 ',
        '÷'=>' divided by ', '×'=>' times ', '±'=>' plus-minus ', '√'=>' square root ', '∞'=>' infinity ',
        '≈'=>' almost equal to ', '≠'=>' not equal to ', '≡'=>' identical to ', '≤'=>' less than or equal to ', '≥'=>' greater than or equal to ',
        '←'=>' left ', '→'=>' right ', '↑'=>' up ', '↓'=>' down ', '↔'=>' left and right ', '↕'=>' up and down ',
        '℅'=>' care of ', '℮' => ' estimated ',
        'Ω'=>' ohm ',
        '♀'=>' female ', '♂'=>' male ',
        '©'=>' Copyright ', '®'=>' Registered ', '™' =>' Trademark ',
    );

    $string = strtr($string, $table);
    // Currency symbols: £¤¥€  - we dont bother with them for now
    $string = preg_replace("/[^\x9\xA\xD\x20-\x7F]/u", "", $string);

    return $string;
}
endif;
function fileupload_process($file){

    if($file['type']!='application/pdf'){
        if( intval($file['height'])<500 || intval($file['width']) <500 ){
            $response = array('success' => false,'image'=>true);
            echo json_encode($response);
            exit;
        }
    }
        
    if( intval ( $file['base']) ==0){ }

    $attachment = handle_file($file);

    if (is_array($attachment)) {
        $html = getHTML($attachment);

        $response = array(
            'base' =>  $file['base'],
            'type'      =>  $file['type'],
            'height'      =>  $file['height'],
            'width'      =>  $file['width'],
            'success'   => true,
            'html'      => $html,
            'attach'    => $attachment['id'],
            
            
        );

        echo json_encode($response);
        exit;
    }

    $response = array('success' => false);
    echo json_encode($response);
    exit;
}
function handle_file($upload_data){
    $return = false;
    
    
    $uploaded_file = wp_handle_upload($upload_data, array('test_form' => false));

    if (isset($uploaded_file['file'])) {
        $file_loc   =   $uploaded_file['file'];
        $file_name  =   basename($upload_data['name']);
        $file_type  =   wp_check_filetype($file_name);

        $attachment = array(
            'post_mime_type' => $file_type['type'],
            'post_title' => preg_replace('/\.[^.]+$/', '', basename($file_name)),
            'post_content' => '',
            'post_status' => 'inherit'
        );

        $attach_id      =   wp_insert_attachment($attachment, $file_loc);
        $attach_data    =   wp_generate_attachment_metadata($attach_id, $file_loc);
        wp_update_attachment_metadata($attach_id, $attach_data);

        $return = array('data' => $attach_data, 'id' => $attach_id);

        return $return;
    }

    return $return;
}
function getHTML($attachment){
    $attach_id  =   $attachment['id'];
    $file='';
    $html='';
    //print_r($attachment);
    if( isset($attachment['data']['file'])){
        $file       =   explode('/', $attachment['data']['file']);
        $file       =   array_slice($file, 0, count($file) - 1);
        $path       =   implode('/', $file);

        $image      =   $attachment['data']['sizes']['thumbnail']['file'];
        $post       =   get_post($attach_id);
        $dir        =   wp_upload_dir();
        $path       =   $dir['baseurl'] . '/' . $path;
        $html       =   '';
        $current_user = wp_get_current_user();
        $userID  =   $current_user->ID;
        $html   .=   $path.'/'.$image; 

    }
    return $html;
}
