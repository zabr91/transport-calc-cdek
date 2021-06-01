<?php

namespace TransportCalcCDEK;

use WPMVC\Bridge;
/**
 * Main class.
 * Bridge between WordPress and App.
 * Class contains declaration of hooks and filters.
 *
 * @author Ivan Zabroda <zabr91.github.io>
 * @package transport-calc-cdek
 * @version 1.0.0
 */
class Main extends Bridge
{
    /**
     * Declaration of public WordPress hooks.
     */
    public function init()
    {
        $this->add_shortcode( 'calculator-cdek', 'view@shortcodes.calculator-cdek' );
    }


    /**
     * Declaration of admin only WordPress hooks.
     * For WordPress admin dashboard.
     */
    public function on_admin()
    {
        add_action( 'admin_menu', function(){//page-slug
            $hook = add_menu_page( 'Настройки Transport Calc CDEK', 'Настройки Transport Calc CDEK',
                'manage_options', 'transportcalccdek-settings',
                [&$this, 'viewDashboard'], 'dashicons-calculator', 100 );


            add_action( "load-$hook", [&$this, 'pageLoad'] );


        } );

        add_action('admin_init', [&$this, 'addControls']);
    }

    /**
     * View page on dasboard
     */
    public function viewDashboard(){
        echo $this->mvc->view->get( 'dashboard-main' );
       // $this->view->show('dashboard-main',[]);
    }

    public function pageLoad(){

    }

    public function addControls(){

        register_setting( 'transportcalccdek', 'transportcalccdek', 'sanitize_callback' );

        add_settings_section( 'section_id', 'Основные настройки', '', 'transportcalccdek-settings' );

        add_settings_field('cdek_api', 'CDEK API', [&$this, 'fill_cdek_api'], 'transportcalccdek-settings', 'section_id' );

        add_settings_field('modal_content', 'Контент модального окна', [&$this, 'fill_modal_content'], 'transportcalccdek-settings', 'section_id' );


    }

    public function fill_cdek_api(){
        $val = get_option('transportcalccdek');
        $val = $val ? $val['cdek_api'] : null;
        ?>
        <input type="text" name="transportcalccdek[cdek_api]" value="<?php echo esc_attr( $val ) ?>" />
        <?php
    }

    public function fill_modal_content(){
        $val = get_option('transportcalccdek');
        $val = $val ? $val['fill_modal_content'] : null;
        ?>
        <textarea rows="10" cols="45"  name="transportcalccdek[modal_content]"/>
        <?php echo esc_attr( $val ) ?>
        </textarea>
        <?php
    }

    function sanitize_callback( $options ){
        // очищаем
        foreach( $options as $name => & $val ){
            if( $name == 'input' )
                $val = strip_tags( $val );

            if( $name == 'checkbox' )
                $val = intval( $val );
        }

        return $options;
    }
}