<?php
class CKHBE_Main
{
    private static $instance = null;

    public static function get_instance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public static function activate()
    {
        // Activation logic here
    }

    public static function deactivate()
    {
        // Deactivation logic here
    }

    private function __construct()
    {
        add_action('wp_enqueue_scripts', array($this, 'enqueue_assets'));
    }

    public function enqueue_assets()
    {
        wp_enqueue_script('ckhbe-alpine', plugins_url('../assets/js/alpine.min.js', __FILE__), array(), null, true);
        wp_enqueue_style('ckhbe-style', plugins_url('../assets/css/wpbe-style.css', __FILE__));
    }
}
