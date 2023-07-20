<?php

// clean-up time
//

   // if uninstall.php is not called by WordPress..
   if(!defined( 'WP_UNINSTALL_PLUGIN')) {die;}


   // delete any plugin-specific options
   //

   // $option_name = 'wporg_option';
   // delete_option( $option_name );
   // for site options in Multisite
   // delete_site_option( $option_name );


   // drop any custom database tables
   //

   //global $wpdb;
   // $wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}mytable" );



