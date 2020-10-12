<?php
//Load Sytle sheets
function load_css()
{

  wp_register_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), false, 'all' );
  wp_enqueue_style('bootstrap');

  wp_register_style('magnific', get_template_directory_uri() . '/css/magnific-popup.css', array(), false, 'all' );
  wp_enqueue_style('magnific');

  wp_register_style('main', get_template_directory_uri() . '/css/main.css', array(), false, 'all' );
  wp_enqueue_style('main');

}
add_action('wp_enqueue_scripts', 'load_css');


//Load JavaScript
function load_js() 
{

  wp_enqueue_script('jquery');

  wp_register_script('bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', ['jquery'], false, true);
  wp_enqueue_script('bootstrap');

  wp_register_script('magnific', get_template_directory_uri() . '/js/jquery.magnific-popup.min.js', 'jquery', false, true);
  wp_enqueue_script('magnific');

  wp_register_script('custom', get_template_directory_uri() . '/js/custom.js', 'jquery', false, true);
  wp_enqueue_script('custom');

}
add_action('wp_enqueue_scripts', 'load_js');

//theme options
add_theme_support('menus');
add_theme_support('post-thumbnails');
add_theme_support('widgets');

//Menus

register_nav_menus(

  array(

      'top-menu' => 'Top Menu Location',
      'mobile-menu' => 'Mobile Menu Location',
      'footer-menu' => 'Footer Menu Location'

  )

);

// Cust Img sizes
add_image_size('blog-large', 800, 400, true);
add_image_size('blog-small', 300, 200, true);

//Register Sidebars
function my_sidebars()
{
  register_sidebar(
    array(
      'name' => 'Page Sidebar',
      'id' => 'page-sidebar',
      'before_title' => '<h4 class="widget-title">',
      'after_title' => '</h4>'
    )
  );

  register_sidebar(
    array(
      'name' => 'Blog Sidebar',
      'id' => 'blog-sidebar',
      'before_title' => '<h4 class="widget-title">',
      'after_title' => '</h4>'
    )
  );
}

add_action('widgets_init', 'my_sidebars');

function custom_post_type()
{
  $args = array(
    'labels' => array( 
      'name' => 'Cars',
      'singular_name' => 'Car'
    ),
    'hierarchical' => true,
    'menu_icon' => 'dashicons-car',
    'public' => true,
    'has_archive' => true,
    'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'),
    //'rewrite' => array('slug' => 'my-cars')
  );

  register_post_type('cars', $args);

}
add_action('init','custom_post_type');

function custom_taxonomy() {
  $args = array(
    'labels' => array( 
      'name' => 'Brands',
      'singular_name' => 'Brand'
    ),
    'public' => true,
    'hierarchical' => true
  );

  register_taxonomy('brands', array('cars'), $args);

}

add_action('init', 'custom_taxonomy');

add_action('wp_ajax_enquiry', 'enquiry_form');
add_action('wp_ajax_nopriv_enquiry', 'enquiry_form');

function enquiry_form() 
{

  $formdata = [];

  wp_parse_str($_POST['enquiry'], $formdata);

  //admin email address
  $admin_email = get_option('admin_email');

  //Email headers
  $headers[] = 'Content-Type: text/html; charset=UTF-8';
  $headers[] = 'From' . $admin_email;
  $headers[] = 'Reply-to:' . $formdata['email'];

  //Who are we sending the email to
  $send_to = $admin_email;

  //subject
  $subject = "Enquiry from" . $formdata['fname'] . ' ' . $formdata['lname'];

  //message
  $message = '';

  foreach($formdata as $index => $field) 
  {

    $message .= '<strong>' . $field . '</strong>: ' . '<br />';

  }

  try {

    if($sent = wp_mail($send_to, $subject, $message, $headers))
    {
      wp_send_json_success('Email Sent');
    }
    else {
      $error = new WP_Error('400', 'Email Failed', [
        'sent' => $sent,
        'sent_to' => $send_to,
        'subject' => $subject,
        'message' => $message,
        'headers' => $headers
      ]);
      wp_send_json_error( $error );
    }
  } catch (Exception $e)
  {
    wp_send_json_error($e -> getMessage());
  }

  wp_send_json_success($formdata['fname']);

}