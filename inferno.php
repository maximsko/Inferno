<?php

/**
 * Define for the beginning.
 */

define('INFERNO', basename(dirname(__FILE__)));
define('INFERNO_URL', trailingslashit(get_template_directory_uri()) . trailingslashit(basename(dirname(__FILE__))));
define('INFERNO_PATH', trailingslashit(get_template_directory()) . trailingslashit(basename(dirname(__FILE__))));
define('INFERNO_VERSION', '1.0');

if(!class_exists('Inferno')) {
  class Inferno {

    /**
     * This is the config. Initially turn off everything.
     *
     * @var array
     */
    private $_config = array(
      'canvas'              => false,
      'shortcodes'          => false,
      'shortcode-generator' => false,
      'meta-box'            => false,
      'breadcrumbs'         => false,
      'portfolio'           => false,
      'menu-options'        => false
    );

    /**
     * Debug constant
     * @var boolean
     */
    public static $_debug = false;

    private $_current_user_buffered = null;


    /**
     * Register all styles which come with the theme framework.
     * 
     * @var array
     */
    public $register_styles = array(
      array('css3d', 'assets/css/supports3d.css', false, INFERNO_VERSION, 'all'),
      array('flexslider', 'assets/css/flexslider.css', false, '2.1.1', 'all'),
      array('font-awesome', '//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css', false, '4.0.3', 'all'),
      array('image-picker', 'assets/css/image-picker.css', false, '0.1.7', 'all'),
      array('inferno-admin', 'assets/css/admin.css', false, INFERNO_VERSION, 'all'),
      array('inferno-mobile-admin', 'assets/css/mobile-admin.css', false, INFERNO_VERSION, 'all'),
      array('inferno-menu', 'assets/css/menu.css', false, INFERNO_VERSION, 'all'),
      array('inferno-portfolio', 'assets/css/portfolio.css', false, INFERNO_VERSION, 'all'),
      array('inferno-ui-helper', 'assets/css/ui-helper.css', false, INFERNO_VERSION, 'all'),
      array('jscrollpane', 'assets/css/jscrollpane.css', false, '2.0.19', 'all'),
      array('magnific-popup', 'assets/css/magnific-popup.css', false, '0.9.7', 'all'),
      array('normalize', 'assets/css/normalize.css', false, INFERNO_VERSION, 'all'),
      array('perfect-scrollbar', 'assets/css/perfect-scrollbar.css', false, '0.4.6', 'all'),
      array('qtip', 'assets/css/jquery.qtip.css', false, '2.2.0', 'all'),
      array('spectrum', 'assets/css/spectrum.css', false, '1.3.3', 'all'),
      array('structurize', 'assets/css/structurize.css', false, INFERNO_VERSION, 'all'),
      array('structurize-responsive', 'assets/css/structurize-responsive.css', false, INFERNO_VERSION, 'all'),
      array('shortcodes', 'assets/css/shortcodes.css', false, INFERNO_VERSION, 'all'),
      array('wpstyles', 'assets/css/wpstyles.css', false, INFERNO_VERSION, 'all')
    );

    /**
     * Register all scripts which come with the theme framework.
     *
     * @var array
     */
    public $register_scripts = array(
      array('eventemitter', 'assets/js/event-emitter.js', false, '4.2.5', true),
      array('eventie', 'assets/js/eventie.js', false, '1.0.4', true),
      array('inferno-admin', 'assets/js/admin.js', array('jquery'), INFERNO_VERSION, true),
      array('inferno-preview', 'assets/js/inferno-preview.js', array('jquery'), INFERNO_VERSION, true),
      array('iscroll', 'assets/js/iscroll.js', false, '4.2.5', true),
      array('jquery-animate-scale', 'assets/js/jquery.animate.scale.js', false, null, true),
      array('jquery-blur', 'assets/js/jquery/jquery.blur.js', array('jquery'), '1', true),
      array('jquery-colorbox', 'assets/js/jquery/jquery.colorbox.js', array('jquery'), '1.4.10', true),
      array('jquery-cookie', 'assets/js/jquery/jquery.cookie.js', array('jquery'), '1.3.1', true),
      array('jquery-confirm', 'assets/js/jquery/jquery.confirm.js', array('jquery'), '1.3', true),
      array('jquery-css-transform', 'assets/js/jquery/jquery.css.transform.js', array('jquery', 'jquery-animate-scale'), null, true),
      array('jquery-debouncedresize', 'assets/js/jquery/jquery.debouncedresize.js', array('jquery'), '1', true),
      array('jquery-easing', 'assets/js/jquery/jquery.easing.js', array('jquery'), '1.3', true),
      array('jquery-fitvids', 'assets/js/jquery/jquery.fitvids.js', array('jquery'), '1.0', true),
      array('jquery-flexslider', 'assets/js/jquery/jquery.flexslider.js', array('jquery'), '2.1', true),
      array('jquery-hoverintent', 'assets/js/jquery/jquery.hoverintent.js', array('jquery'), 'r7', true),
      array('jquery-image-picker', 'assets/js/jquery/jquery.image-picker.js', array('jquery'), '0.1.7', true),
      array('jquery-imagesloaded', 'assets/js/jquery/jquery.imagesloaded.js', array('jquery', 'eventemitter', 'eventie'), '3.1.1', true),
      array('jquery-infinitescroll', 'assets/js/jquery/jquery.infinitescroll.js', array('jquery'), '2.0b2.120519', true),
      array('jquery-infinitescroll-behavior-local', 'assets/js/jquery/jquery.infinitescroll.behavior-local.js', array('jquery-infinitescroll'), '2.0b2.120519', true),
      array('jquery-isotope', 'assets/js/jquery/jquery.isotope.js', array('jquery'), '1.5.25', true),
      array('jquery-isotope-2', 'assets/js/jquery/jquery.isotope2.js', false, '2.0b7', true),
      array('jquery-jscrollpane', 'assets/js/jquery/jquery.jscrollpane.js', array('jquery'), '2.0.19', true),
      array('jquery-mobile', 'assets/js/jquery/jquery.mobile.js', array('jquery'), '1.4.0', true),
      array('jquery-magnific-popup', 'assets/js/jquery/jquery.magnific-popup.js', array('jquery'), '0.9.7', true),
      array('jquery-mousewheel', 'assets/js/jquery/jquery.mousewheel.js', array('jquery'), '3.1.8', true),
      array('jquery-perfect-scrollbar', 'assets/js/jquery/jquery.perfect-scrollbar.js', array('jquery'), '0.4.6', true),
      array('jquery-pjax', 'assets/js/jquery/jquery.pjax.js', array('jquery'), '1.7.3', true),
      array('jquery-placeholder', 'assets/js/jquery/jquery.placeholder.js', array('jquery'), '2.0.7', true),
      array('jquery-qtip', 'assets/js/jquery/jquery.qtip.js', array('jquery'), '2.2.0', true),
      array('jquery-rotate', 'assets/js/jquery/jquery.rotate.js', array('jquery'), null, true),
      array('jquery-scrollto', 'assets/js/jquery/jquery.scrollto.js', array('jquery'), '1.4.5 BETA', true),
      array('jquery-spectrum', 'assets/js/jquery/jquery.spectrum.js', array('jquery'), '1.3.3', true),
      array('jquery-superfish', 'assets/js/jquery/jquery.superfish.js', array('jquery'), '1.7.4', true),
      array('jquery-throttle-debounce', 'assets/js/jquery/jquery.throttle-debounce.js', array('jquery'), '1.1', true),
      array('jquery-throttledresize', 'assets/js/jquery/jquery.throttledresize.js', array('jquery'), '1', true),
      array('jquery-tinynav', 'assets/js/jquery/jquery.tinynav.js', array('jquery'), '1.0.14', true),
      array('modernizr', 'assets/js/modernizr.js', false, '2.6.2', true),
      array('responsive-nav', 'assets/js/responsivenav.js', false, '1.0.14', true)
    );


    /**
     * The script handles needed for any inferno administration purposes
     */
    public static $admin_scripts = array(
      'jquery',
      'jquery-ui-core',
      'jquery-ui-widget',
      'jquery-ui-tabs',
      'jquery-ui-slider',
      'jquery-ui-sortable',
      'jquery-ui-button',
      'jquery-form',
      'media-upload',
      'jquery-magnific-popup',
      'thickbox',
      'jquery-image-picker',
      'jquery-confirm',
      'jquery-qtip',
      'jquery-spectrum',
      'inferno-admin'
    );

    /**
     * The style handles needed for any inferno administration purposes
     */
    public static $admin_styles = array(
      'font-awesome',
      'image-picker',
      'inferno-admin',
      'inferno-mobile-admin',
      'inferno-ui-helper',
      'magnific-popup',
      'qtip',
      'spectrum',
      'thickbox'
    );


    /**
     * Get configuration for optional modules and call initialization functions.
     */
    public function __construct($debug = false)
    {
      self::$_debug = $debug;

      $this->_config['canvas']              = get_theme_support( 'inferno-canvas' );
      $this->_config['shortcodes']          = get_theme_support( 'inferno-shortcodes' );
      $this->_config['shortcode-generator'] = get_theme_support( 'inferno-shortcode-generator' );
      $this->_config['meta-box']            = get_theme_support( 'inferno-meta-box' );
      $this->_config['menu-options']        = get_theme_support( 'inferno-menu-options' );
      $this->_config['portfolio']           = get_theme_support( 'inferno-portfolio' );

      $this->load();
      $this->actions();
    }

    /**
     * Include and initialize basic resources. Check for optional modules to load, if enqueued, load them, too.
     */
    private function load()
    {
      require_once(dirname(__FILE__) . '/inc/class-tgm-plugin-activation.php');
      require_once(dirname(__FILE__) . '/inc/functions.php');
      require_once(dirname(__FILE__) . '/inc/aq_resizer.php');
      require_once(dirname(__FILE__) . '/inc/class-preview.php');

      // options machine
      if((isset($this->_config['canvas']) && $this->_config['canvas']) || 
          isset($this->_config['shortcode-generator']) && $this->_config['shortcode-generator'] || 
          isset($this->_config['meta-box']) && $this->_config['meta-box']) {
        require_once(dirname(__FILE__) . '/inc/class-options-machine.php');
      }

      // canvas
      if( isset($this->_config['canvas']) && $this->_config['canvas'] ) {
        require( dirname( __FILE__ ) . '/canvas/class-canvas.php' );
        $current_user = wp_get_current_user();

        // TODO maybe do this in a cooler way?
        if(isset($this->_config['canvas'][0]['demo_mode']) && $this->_config['canvas'][0]['demo_mode'] == true
            && isset($this->_config['canvas'][0]['demo_account'])
            && (!is_user_logged_in()
            || $current_user->user_login == $this->_config['canvas'][0]['demo_account'])) {
          require( dirname( __FILE__ ) . '/canvas/class-demo-canvas.php' );
          new Inferno_Demo_Canvas();

          // for the comment forms
          add_action('comment_form_before', array($this, 'destroy_current_user'));
          add_action('comment_form', array($this, 'restore_current_user'));
        } else {
          new Inferno_Canvas();
        }
      }

      // meta boxes
      if( isset($this->_config['meta-box'][0]) && $this->_config['meta-box'][0] ) {
        require_once(dirname(__FILE__) . '/inc/class-meta-box.php');

        if(isset($this->_config['meta-box'][0]['file']) && is_string($this->_config['meta-box'][0]['file'])) {
          foreach( include( locate_template( $this->_config['meta-box'][0]['file'] ) ) as $meta_box ) {
            new Inferno_Meta_Box( $meta_box );
          }
        }
      }

      // shortcodes
      if( isset($this->_config['shortcodes']) && $this->_config['shortcodes'] ) {
        include( dirname(__FILE__) . '/shortcodes/class-shortcodes.php' );
        new Inferno_Shortcodes();
      }

      // shortcode generator
      if( isset($this->_config['shortcode-generator']) && $this->_config['shortcode-generator'] ) {
        require( dirname(__FILE__) . '/shortcodes/class-shortcode-generator.php' );

        new Inferno_Shortcode_Generator();
      }

      // menu options
      if( isset($this->_config['menu-options']) && $this->_config['menu-options'] ) {
        require_once( dirname(__FILE__) . '/inc/class-admin-menu.php' );

        Inferno_Admin_Menu::getInstance();
      }

      // portfolio
      if( isset($this->_config['portfolio']) && $this->_config['portfolio'] ) {
        require( dirname(__FILE__) . '/portfolio/class-portfolio.php' );

        new Inferno_Portfolio();
      }

      // todo: require_once(dirname(__FILE__) . '/inc/breadcrumbs.php');
      // todo: require_once(dirname(__FILE__) . '/inc/pagination.php');
      // todo: require_once(dirname(__FILE__) . '/builder/class-builder.php');
    }

    public function actions()
    {
      add_action('init', array(&$this, 'assets'));
      add_action('init', array(&$this, 'fixing_hooks')); // make that dynamically callable
      add_action('after_setup_theme', array(&$this, 'translate'));
      add_action('admin_enqueue_scripts', array(&$this, 'admin_enqueue'));
    }

    public function assets()
    {
      if(is_array($this->register_scripts) && !empty($this->register_scripts)) {
        foreach($this->register_scripts as $script) {
          wp_deregister_script($script[0]);
          wp_register_script($script[0], (substr($script[1], 0, 2) == '//' ? null : get_template_directory_uri() . '/' . basename(dirname(__FILE__)) . '/') . $script[1], $script[2], $script[3], $script[4]);
        }
      }

      if(is_array($this->register_styles) && !empty($this->register_styles)) {
        foreach($this->register_styles as $style) {
          wp_deregister_style($style[0]);
          wp_register_style($style[0], (substr($style[1], 0, 2) == '//' ? null : get_template_directory_uri() . '/' . basename(dirname(__FILE__)) . '/') . $style[1], $style[2], $style[3], $style[4]);
        }
      }
    }

    /**
     * see http://wordpress.stackexchange.com/questions/41207/how-do-i-enqueue-styles-scripts-on-certain-wp-admin-pages and 
     * http://codex.wordpress.org/Plugin_API/Action_Reference/admin_enqueue_scripts for more details. maybe improve this some time
     */
    public function admin_enqueue($hook)
    {
      if((($this->_config['shortcodes'] || $this->_config['meta-box']) && ($hook == 'post.php' || $hook == 'post-new.php')) || 
      ($this->_config['canvas'] && $hook == 'appearance_page_inferno-admin') ||
      ($this->_config['menu-options'] && $hook == 'nav-menus.php')) {
        foreach(self::$admin_scripts as $script) {
          wp_enqueue_script($script);
        }
        foreach(self::$admin_styles as $style) {
          wp_enqueue_style($style);
        }
      }
    }

    public function fixing_hooks()
    {
      // remove wp default gallery inline style
      add_filter('use_default_gallery_style', '__return_false'); 
    }

    public function translate()
    {
      load_theme_textdomain( 'inferno', INFERNO_PATH . 'languages' );
    }

    public function destroy_current_user()
    {
      $this->_current_user_buffered = $GLOBALS['current_user'];
      $GLOBALS['current_user'] = false;
      wp_set_current_user( 0 );
    }

    public function restore_current_user()
    {
      $current_user = $this->_current_user_buffered;
      $GLOBALS['current_user'] = $current_user;
      wp_set_current_user( $current_user->ID );
    }
  }
}