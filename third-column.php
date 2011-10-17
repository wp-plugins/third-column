<?php
/*
Plugin Name: Bang Admin: Third Column
Plugin URI: http://www.bang-on.net/thirdcolumn.zip
Description: Adds a third column to the page and post edit form
Author: Marcus Downing
Author URI: http://www.bang-on.net
Version: 1.0
*/

/*  Copyright 2011  Marcus Downing  (email : marcus@bang-on.net)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/* Edit form */

add_action('submitpost_box', 'third_column_edit_form');
add_action('submitpage_box', 'third_column_edit_form');
function third_column_edit_form() {
  global $post;
  $post_type = $post->post_type;
  //  check post types
  $side_meta_boxes2 = do_meta_boxes($post_type, 'column3', $post);

  /*  Obscure case:
   *  The taxBox javascript is only initialised if the page loads with a tax box within
   *  #side-sortables, #normal-sortables or #advanced-sortables
   *  Since we're adding an unanticipated #column3-sortables, we need to force it to initialise.
   */
  ?><script type='text/javascript'>
    jQuery(document).ready(function($) {
      var toInit = false;
      $('#column3-sortables div.postbox').each(function(){
        if ( this.id.indexOf('tagsdiv-') === 0 ) {
          toInit = true;
        }
      });
      $('#side-sortables, #normal-sortables, #advanced-sortables').children('div.postbox').each(function(){
        if ( this.id.indexOf('tagsdiv-') === 0 ) {
          toInit = false;
        }
      });
      tagBox.init();
    });
  </script><?php
}

/* Options */

//add_action('admin_menu', 'third_column_create_menu');
function third_column_create_menu () {
  add_menu_page('Third Column', 'Third Column', 'administrator', __FILE__, 'third_column_settings',plugins_url('/images/icon.png', __FILE__));
  add_action('admin_init', 'third_column_register_settings');
}

function third_column_register_settings () {
  register_setting('third-column', 'cols-post');
  register_setting('third-column', 'cols-page');
}

function third_column_settings () {
  
}


function default_options () {
  return array(
    //
  );
}



/* CSS */

add_action('admin_print_styles', 'third_column_css');
function third_column_css () {
  ?><style>
#post #side-info-column {
  width: 580px;
}

#post #post-body {
  margin-right: -620px !important;
}

#post #post-body-content {
  margin-right: 600px !important;
}

#post #column3-sortables {
  width: 280px;
  float: right;
  display: block;
  min-height: 200px;
}

#post #side-sortables {
  float: left;
  display: block;
  min-height: 200px;
}

/* Style copied from #side-sortables */

#post #column3-sortables .category-tabs, #column3-sortables .category-tabs {
  margin-bottom: 3px;
}

#post #column3-sortables .category-tabs li, #column3-sortables .add-menu-item-tabs li {
  display: inline;
}

#post #column3-sortables .category-tabs a, #column3-sortables .add-menu-item-tabs a {
  text-decoration: none;
}

#post #column3-sortables .category-tabs .tabs a, #column3-sortables .add-menu-item-tabs .tabs a {
  color: #333;
}

  </style><?php
}
