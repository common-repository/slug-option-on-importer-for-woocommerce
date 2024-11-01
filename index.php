<?php
/*
Plugin Name: Slug Option on Importer for WooCommerce
Plugin URI: https://webodid.com
Description: add slug field for Woocommerce csv importer
Author: Pedram Nasertorabi
Version: 1.0
Author URI: http://webodid.com/
*/
defined( 'ABSPATH' ) || exit();

/*Activation Deactivation*/
register_activation_hook( __FILE__, 'SFWI_Activation' );
register_deactivation_hook( __FILE__, 'SFWI_Deactivation' );
function SFWI_Activation() {}
function SFWI_Deactivation() {}

function SFWI_add_column_to_importer($options)
{
    $options['slug'] = 'Slug';
    return $options;
}
add_filter('woocommerce_csv_product_import_mapping_options', 'SFWI_add_column_to_importer');


function SFWI_add_column_to_mapping_screen($columns)
{
    // potential column name => CSV column slug
    $columns['Slug'] = 'slug';
    return $columns;
}

add_filter('woocommerce_csv_product_import_mapping_default_columns', 'SFWI_add_column_to_mapping_screen');


function SFWI_process_import($object, $data)
{
    if (!empty($data['slug'])) {
        $object->set_slug($data['slug']);
    }
    return $object;
}

add_filter('woocommerce_product_import_pre_insert_product_object', 'SFWI_process_import', 10, 2);