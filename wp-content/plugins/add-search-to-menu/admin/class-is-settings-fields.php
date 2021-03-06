<?php

/**
 * Defines plugin settings fields.
 *
 * This class defines all code necessary to manage plugin settings fields.
 *
 * @package IS
 */
class IS_Settings_Fields
{
    /**
     * Stores plugin options.
     */
    public  $opt ;
    /**
     * Core singleton class
     * @var self
     */
    private static  $_instance ;
    private  $is_premium_plugin = false ;
    /**
     * Instantiates the plugin by setting up the core properties and loading
     * all necessary dependencies and defining the hooks.
     *
     * The constructor uses internal functions to import all the
     * plugin dependencies, and will leverage the Ivory_Search for
     * registering the hooks and the callback functions used throughout the plugin.
     */
    public function __construct( $is = null )
    {
        
        if ( null !== $is ) {
            $this->opt = $is;
        } else {
            $this->opt = Ivory_Search::load_options();
        }
    
    }
    
    /**
     * Gets the instance of this class.
     *
     * @return self
     */
    public static function getInstance()
    {
        if ( !self::$_instance instanceof self ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    
    /**
     * Displays settings sections having custom markup.
     */
    public function is_do_settings_sections( $page, $sec )
    {
        global  $wp_settings_sections, $wp_settings_fields ;
        if ( !isset( $wp_settings_sections[$page] ) ) {
            return;
        }
        $section = (array) $wp_settings_sections[$page][$sec];
        if ( $section['title'] ) {
            echo  "<h2>{$section['title']}</h2>\n" ;
        }
        if ( $section['callback'] ) {
            call_user_func( $section['callback'], $section );
        }
        if ( !isset( $wp_settings_fields ) || !isset( $wp_settings_fields[$page] ) || !isset( $wp_settings_fields[$page][$section['id']] ) ) {
            return;
        }
        echo  '<div class="form-table search-form-editor-box">' ;
        $this->is_do_settings_fields( $page, $section['id'] );
        echo  '</div>' ;
    }
    
    /**
     * Displays settings fields having custom markup.
     */
    public function is_do_settings_fields( $page, $section )
    {
        global  $wp_settings_fields ;
        if ( !isset( $wp_settings_fields[$page][$section] ) ) {
            return;
        }
        foreach ( (array) $wp_settings_fields[$page][$section] as $field ) {
            $class = '';
            if ( !empty($field['args']['class']) ) {
                $class = ' class="' . esc_attr( $field['args']['class'] ) . '"';
            }
            
            if ( !empty($field['args']['label_for']) ) {
                echo  '<h3 scope="row"><label for="' . esc_attr( $field['args']['label_for'] ) . '">' . $field['title'] . '</label>' ;
            } else {
                echo  '<h3 scope="row">' . $field['title'] ;
            }
            
            if ( 'Header Search' == $field['title'] || 'Extras' == $field['title'] ) {
                echo  '<span class="actions"><a class="expand" href="#">' . esc_html__( 'Expand All', 'add-search-to-menu' ) . '</a><a class="collapse" href="#" style="display:none;">' . esc_html__( 'Collapse All', 'add-search-to-menu' ) . '</a></span>' ;
            }
            echo  '</h3><div>' ;
            call_user_func( $field['callback'], $field['args'] );
            echo  '</div>' ;
        }
    }
    
    /**
     * Registers plugin settings fields.
     */
    function register_settings_fields()
    {
        if ( !empty($GLOBALS['pagenow']) && 'options.php' === $GLOBALS['pagenow'] ) {
            
            if ( isset( $_POST['is_menu_search'] ) ) {
                add_filter( 'whitelist_options', function ( $whitelist_options ) {
                    $whitelist_options['ivory_search'][0] = 'is_menu_search';
                    return $whitelist_options;
                } );
            } else {
                if ( isset( $_POST['is_analytics'] ) ) {
                    add_filter( 'whitelist_options', function ( $whitelist_options ) {
                        $whitelist_options['ivory_search'][0] = 'is_analytics';
                        return $whitelist_options;
                    } );
                }
            }
        
        }
        
        if ( !isset( $_GET['tab'] ) || 'settings' == $_GET['tab'] ) {
            add_settings_section(
                'ivory_search_settings',
                '',
                array( $this, 'settings_section_desc' ),
                'ivory_search'
            );
            add_settings_field(
                'ivory_search_header',
                __( 'Header Search', 'add-search-to-menu' ),
                array( $this, 'header' ),
                'ivory_search',
                'ivory_search_settings'
            );
            add_settings_field(
                'ivory_search_footer',
                __( 'Footer Search', 'add-search-to-menu' ),
                array( $this, 'footer' ),
                'ivory_search',
                'ivory_search_settings'
            );
            add_settings_field(
                'ivory_search_display_in_header',
                __( 'Mobile Search', 'add-search-to-menu' ),
                array( $this, 'menu_search_in_header' ),
                'ivory_search',
                'ivory_search_settings'
            );
            add_settings_field(
                'ivory_search_css',
                __( 'Custom CSS', 'add-search-to-menu' ),
                array( $this, 'custom_css' ),
                'ivory_search',
                'ivory_search_settings'
            );
            add_settings_field(
                'ivory_search_stopwords',
                __( 'Stopwords', 'add-search-to-menu' ),
                array( $this, 'stopwords' ),
                'ivory_search',
                'ivory_search_settings'
            );
            add_settings_field(
                'ivory_search_synonyms',
                __( 'Synonyms', 'add-search-to-menu' ),
                array( $this, 'synonyms' ),
                'ivory_search',
                'ivory_search_settings'
            );
            add_settings_field(
                'not_load_files',
                __( 'Plugin Files', 'add-search-to-menu' ),
                array( $this, 'plugin_files' ),
                'ivory_search',
                'ivory_search_settings'
            );
            add_settings_field(
                'ivory_search_extras',
                __( 'Extras', 'add-search-to-menu' ),
                array( $this, 'extras' ),
                'ivory_search',
                'ivory_search_settings'
            );
            register_setting( 'ivory_search', 'is_settings' );
        } else {
            
            if ( isset( $_GET['tab'] ) && 'menu-search' == $_GET['tab'] ) {
                add_settings_section(
                    'ivory_search_section',
                    '',
                    array( $this, 'menu_search_section_desc' ),
                    'ivory_search'
                );
                add_settings_field(
                    'ivory_search_locations',
                    __( 'Menu Search Form Settings', 'add-search-to-menu' ),
                    array( $this, 'menu_settings' ),
                    'ivory_search',
                    'ivory_search_section'
                );
                register_setting( 'ivory_search', 'is_menu_search' );
            } else {
                
                if ( isset( $_GET['tab'] ) && 'analytics' == $_GET['tab'] ) {
                    add_settings_section(
                        'ivory_search_analytics',
                        '',
                        array( $this, 'analytics_section_desc' ),
                        'ivory_search'
                    );
                    add_settings_field(
                        'ivory_search_analytics_fields',
                        __( 'Search Analytics', 'add-search-to-menu' ),
                        array( $this, 'analytics' ),
                        'ivory_search',
                        'ivory_search_analytics'
                    );
                    register_setting( 'ivory_search', 'is_analytics' );
                }
            
            }
        
        }
    
    }
    
    /**
     * Displays Search To Menu section description text.
     */
    function menu_search_section_desc()
    {
        echo  '<h4 class="panel-desc">' . __( 'Display search in menu and configure it using below options.', 'add-search-to-menu' ) . '</h4>' ;
    }
    
    /**
     * Displays Analytics section description text.
     */
    function analytics_section_desc()
    {
        echo  '<h4 class="panel-desc">' . __( 'Configure search analytics settings.', 'add-search-to-menu' ) . '</h4>' ;
    }
    
    /**
     * Displays Settings section description text.
     */
    function settings_section_desc()
    {
        echo  '<h4 class="panel-desc">' . __( 'Make search changes on entire website using below options.', 'add-search-to-menu' ) . '</h4>' ;
    }
    
    /**
     * Displays menu settings fields.
     */
    function menu_settings()
    {
        /**
         * Displays choose menu locations field.
         */
        $content = __( 'Display search form on selected menu locations.', 'add-search-to-menu' );
        IS_Help::help_info( $content );
        $html = '';
        $check_value = '';
        $menus = get_registered_nav_menus();
        
        if ( !empty($menus) ) {
            foreach ( $menus as $location => $description ) {
                
                if ( has_nav_menu( $location ) ) {
                    $check_value = ( isset( $this->opt['menus'][$location] ) ? $this->opt['menus'][$location] : 0 );
                    $html .= '<p><label for="is_menus' . esc_attr( $location ) . '"><input type="checkbox" class="ivory_search_locations" id="is_menus' . esc_attr( $location ) . '" name="is_menu_search[menus][' . esc_attr( $location ) . ']" value="' . esc_attr( $location ) . '" ' . checked( $location, $check_value, false ) . '/>';
                    $html .= '<span class="toggle-check-text"></span> ' . esc_html( $description ) . '</label></p>';
                }
            
            }
            if ( '' === $check_value ) {
                $html = sprintf( __( 'No menu assigned to navigation menu location in the %sMenus screen%s.', 'add-search-to-menu' ), '<a target="_blank" href="' . admin_url( 'nav-menus.php' ) . '">', '</a>' );
            }
        } else {
            $html = __( 'Navigation menu location is not registered on the site.', 'add-search-to-menu' );
        }
        
        echo  '<div>' . $html . '</div>' ;
        /**
         * Displays choose menu field.
         */
        echo  '<br />' ;
        $content = __( 'Display search form on selected menus.', 'add-search-to-menu' );
        IS_Help::help_info( $content );
        $html = '';
        $check_value = '';
        $menu_name = wp_get_nav_menus();
        
        if ( !empty($menu_name) ) {
            foreach ( $menu_name as $value ) {
                $check_value = ( isset( $this->opt['menu_name'][$value->slug] ) ? $this->opt['menu_name'][$value->slug] : 0 );
                $html .= '<p><label for="is_menu_name' . esc_attr( $value->slug ) . '"><input type="checkbox" class="ivory_search_menu_name" id="is_menu_name' . esc_attr( $value->slug ) . '" name="is_menu_search[menu_name][' . esc_attr( $value->slug ) . ']" value="' . esc_attr( $value->slug ) . '" ' . checked( $value->slug, $check_value, false ) . '/>';
                $html .= '<span class="toggle-check-text"></span> ' . esc_html( $value->name ) . '</label></p>';
            }
        } else {
            $html = sprintf( __( 'No menu created in the %sMenus screen%s.', 'add-search-to-menu' ), '<a target="_blank" href="' . admin_url( 'nav-menus.php' ) . '">', '</a>' );
        }
        
        echo  '<div>' . $html . '</div>' ;
        if ( !isset( $this->opt['menus'] ) && !isset( $this->opt['menu_name'] ) || '' === $check_value ) {
            return;
        }
        echo  '<div class="menu-settings-container"><br /><br />' ;
        /**
         * Displays search form at the beginning of menu field.
         */
        $check_value = ( isset( $this->opt['first_menu_item'] ) ? $this->opt['first_menu_item'] : 0 );
        $check_string = checked( 'first_menu_item', $check_value, false );
        $html = '<label for="first_menu_item"><input class="ivory_search_first_menu_item" type="checkbox" id="first_menu_item" name="is_menu_search[first_menu_item]" value="first_menu_item" ' . $check_string . ' />';
        $html .= '<span class="toggle-check-text"></span>' . esc_html__( 'Display search form at the start of the navigation menu', 'add-search-to-menu' ) . '</label>';
        echo  '<div>' . $html . '</div> <br /><br />' ;
        /**
         * Displays form style field.
         */
        $content = __( 'Select menu search form style.', 'add-search-to-menu' );
        IS_Help::help_info( $content );
        $styles = array(
            'default'         => __( 'Default', 'add-search-to-menu' ),
            'dropdown'        => __( 'Dropdown', 'add-search-to-menu' ),
            'sliding'         => __( 'Sliding', 'add-search-to-menu' ),
            'full-width-menu' => __( 'Full Width', 'add-search-to-menu' ),
            'popup'           => __( 'Popup', 'add-search-to-menu' ),
        );
        $menu_close_icon = false;
        
        if ( empty($this->opt) || !isset( $this->opt['menu_style'] ) ) {
            $this->opt['menu_style'] = 'dropdown';
            $menu_close_icon = true;
        }
        
        $html = '';
        $check_value = ( isset( $this->opt['menu_style'] ) ? $this->opt['menu_style'] : 'dropdown' );
        foreach ( $styles as $key => $style ) {
            $html .= '<p>';
            $html .= '<label for="is_menu_style' . esc_attr( $key ) . '"><input class="ivory_search_style" type="radio" id="is_menu_style' . esc_attr( $key ) . '" name="is_menu_search[menu_style]"';
            $html .= 'name="ivory_search[menu_style]" value="' . esc_attr( $key ) . '" ' . checked( $key, $check_value, false ) . '/>';
            $html .= '<span class="toggle-check-text"></span>' . esc_html( $style ) . '</label>';
            $html .= '</p>';
        }
        echo  '<div class="search-form-style">' . $html . '</div><br /><br />' ;
        echo  '<div class="form-style-dependent">' ;
        /**
         * Displays menu search magnifier colorpicker field.
         */
        $color = ( isset( $this->opt['menu_magnifier_color'] ) ? $this->opt['menu_magnifier_color'] : '#848484' );
        echo  '<input style="width: 80px;" class="menu-magnifier-color is-colorpicker" size="5" type="text" id="is-menu-magnifier-color" name="is_menu_search[menu_magnifier_color]" value="' . $color . '" />' ;
        echo  '<br /><i> ' . esc_html__( "Select menu magnifier icon color.", 'add-search-to-menu' ) . '</i><br /><br />' ;
        /**
         * Displays search form close icon field.
         */
        $check_value = ( isset( $this->opt['menu_close_icon'] ) ? $this->opt['menu_close_icon'] : 0 );
        if ( !$check_value && $menu_close_icon ) {
            $check_value = 'menu_close_icon';
        }
        $check_string = checked( 'menu_close_icon', $check_value, false );
        $html = '<label for="menu_close_icon"><input class="ivory_search_close_icon" type="checkbox" id="menu_close_icon" name="is_menu_search[menu_close_icon]" value="menu_close_icon" ' . $check_string . ' />';
        $html .= '<span class="toggle-check-text"></span>' . esc_html__( 'Display search form close icon', 'add-search-to-menu' ) . '</label>';
        echo  '<div>' . $html . '</div> <br /><br />' ;
        /**
         * Displays search menu title field.
         */
        $content = __( 'Add menu title to display in place of search icon.', 'add-search-to-menu' );
        IS_Help::help_info( $content );
        $this->opt['menu_title'] = ( isset( $this->opt['menu_title'] ) ? $this->opt['menu_title'] : '' );
        $html = '<input type="text" class="ivory_search_title" id="is_menu_title" name="is_menu_search[menu_title]" value="' . esc_attr( $this->opt['menu_title'] ) . '" />';
        echo  '<div>' . $html . '</div> <br /><br />' ;
        echo  '</div>' ;
        /**
         * Displays search menu classes field.
         */
        $content = __( 'Add class to search form menu item.', 'add-search-to-menu' );
        IS_Help::help_info( $content );
        $this->opt['menu_classes'] = ( isset( $this->opt['menu_classes'] ) ? $this->opt['menu_classes'] : '' );
        $html = '<input type="text" class="ivory_search_classes" id="is_menu_classes" name="is_menu_search[menu_classes]" value="' . esc_attr( $this->opt['menu_classes'] ) . '" />';
        $html .= '<br /><label for="is_menu_classes" style="font-size: 10px;">' . esc_html__( "Add multiple classes seperated by space.", 'add-search-to-menu' ) . '</label>';
        echo  '<div>' . $html . '</div> <br /><br />' ;
        /**
         * Displays menu search form field.
         */
        $content = __( 'Select search form that will control menu search functionality.', 'add-search-to-menu' );
        IS_Help::help_info( $content );
        $html = '';
        $args = array(
            'numberposts' => -1,
            'post_type'   => 'is_search_form',
            'order'       => 'ASC',
        );
        $posts = get_posts( $args );
        
        if ( !empty($posts) ) {
            $check_value = ( isset( $this->opt['menu_search_form'] ) ? $this->opt['menu_search_form'] : 0 );
            $html .= '<select class="ivory_search_form" id="menu_search_form" name="is_menu_search[menu_search_form]" >';
            $html .= '<option value="0">' . __( 'None', 'add-search-to-menu' ) . '</option>';
            foreach ( $posts as $post ) {
                $html .= '<option value="' . $post->ID . '"' . selected( $post->ID, $check_value, false ) . ' >' . $post->post_title . '</option>';
            }
            $html .= '</select>';
            
            if ( $check_value ) {
                $html .= '<a href="' . esc_url( menu_page_url( 'ivory-search', false ) ) . '&post=' . $check_value . '&action=edit">  ' . esc_html__( "Edit Search Form", 'add-search-to-menu' ) . '</a>';
            } else {
                $html .= '<a href="' . esc_url( menu_page_url( 'ivory-search-new', false ) ) . '">  ' . esc_html__( "Create New", 'add-search-to-menu' ) . '</a>';
            }
        
        }
        
        echo  '<div>' . $html . '</div><br /><br />' ;
        /**
         * Displays google cse field.
         */
        $content = __( 'Add Google Custom Search( CSE ) search form code that will replace default search form.', 'add-search-to-menu' );
        IS_Help::help_info( $content );
        $this->opt['menu_gcse'] = ( isset( $this->opt['menu_gcse'] ) ? $this->opt['menu_gcse'] : '' );
        $html = '<input class="ivory_search_gcse" type="text" id="is_menu_gcse" name="is_menu_search[menu_gcse]" value="' . esc_attr( $this->opt['menu_gcse'] ) . '" />';
        echo  '<div>' . $html . '</div></div>' ;
    }
    
    /**
     * Displays search analytics fields.
     */
    function analytics()
    {
        $is_analytics = get_option( 'is_analytics', array() );
        $check_value = ( isset( $is_analytics['disable_analytics'] ) ? $is_analytics['disable_analytics'] : 0 );
        $html = '<label for="is_disable_analytics"><select class="ivory_search_disable_analytics" id="is_disable_analytics" name="is_analytics[disable_analytics]" >';
        $html .= '<option value="0" ' . selected( 0, $check_value, false ) . '>' . __( 'Enabled', 'add-search-to-menu' ) . '</option>';
        $html .= '<option value="1"' . selected( 1, $check_value, false ) . ' >' . __( 'Disabled', 'add-search-to-menu' ) . '</option>';
        $html .= '</select> ' . esc_html__( 'Google Analytics tracking for searches', 'add-search-to-menu' ) . '</label>';
        echo  '<div>' . $html ;
        echo  '<div class="analytics-info"><br/><br/><p>' . __( 'Uses Google Analytics to track searches.', 'add-search-to-menu' ) . '</p>' ;
        echo  '<p>' . sprintf( __( "You need %s Google Analytics %s to be installed on your site.", 'add-search-to-menu' ), "<a target='_blank' href='https://developers.google.com/analytics/devguides/collection/analyticsjs/'>", '</a>' ) . '</p>' ;
        echo  '<p>' . __( "Data will be visible inside Google Analytics 'Events' and 'Site Search' report.", 'add-search-to-menu' ) . '</p>' ;
        echo  '<br/><p>' . __( "Events will be as below:", 'add-search-to-menu' ) . '</p>' ;
        echo  '<p><b>' . __( "Category - Results Found / Nothing Found", 'add-search-to-menu' ) . '</b></p>' ;
        echo  '<p><b>' . __( "Action - Ivory Search - ID", 'add-search-to-menu' ) . '</b></p>' ;
        echo  '<p><b>' . __( "Label - Value of search term", 'add-search-to-menu' ) . '</b></p>' ;
        echo  '<br/><p>' . sprintf( __( "Need to %s activate Site Search feature %s inside Google Analytics to display data inside 'Site Search' report.", 'add-search-to-menu' ), "<a target='_blank' href='https://support.google.com/analytics/answer/1012264'>", '</a>' ) . '</p>' ;
        echo  '<p>' . __( "Enable Site search Tracking option in Site Search Settings and set its parameters as below.", 'add-search-to-menu' ) . '</p>' ;
        echo  '<p><b>' . __( "Query parameter - s", 'add-search-to-menu' ) . '</b></p>' ;
        echo  '<p><b>' . __( "Category parameter - id / result", 'add-search-to-menu' ) . '</b></p>' ;
        echo  '</div></div>' ;
    }
    
    /**
     * Displays search form in site header.
     */
    function header()
    {
        $content = __( 'Select search form to display in site header( Not Menu ).', 'add-search-to-menu' );
        IS_Help::help_info( $content );
        $html = '';
        $args = array(
            'numberposts' => -1,
            'post_type'   => 'is_search_form',
        );
        $posts = get_posts( $args );
        
        if ( !empty($posts) ) {
            $check_value = ( isset( $this->opt['header_search'] ) ? $this->opt['header_search'] : 0 );
            $html .= '<select class="ivory_search_header" id="is_header_search" name="is_settings[header_search]" >';
            $html .= '<option value="0" ' . selected( 0, $check_value, false ) . '>' . __( 'None', 'add-search-to-menu' ) . '</option>';
            foreach ( $posts as $post ) {
                $html .= '<option value="' . $post->ID . '"' . selected( $post->ID, $check_value, false ) . ' >' . $post->post_title . '</option>';
            }
            $html .= '</select>';
            
            if ( $check_value && get_post_type( $check_value ) ) {
                $html .= '<a href="' . esc_url( menu_page_url( 'ivory-search', false ) ) . '&post=' . $check_value . '&action=edit">  ' . esc_html__( "Edit", 'add-search-to-menu' ) . '</a>';
            } else {
                $html .= '<a href="' . esc_url( menu_page_url( 'ivory-search-new', false ) ) . '">  ' . esc_html__( "Create New", 'add-search-to-menu' ) . '</a>';
            }
        
        }
        
        echo  '<div>' . $html . '<br/><br/><span class="is-help"><span class="is-info-warning">' . __( 'Please note that the above option displays search form in site header and not in navigation menu.', 'add-search-to-menu' ) . '</span></span></div>' ;
    }
    
    /**
     * Displays search form in site footer.
     */
    function footer()
    {
        $content = __( 'Select search form to display in site footer.', 'add-search-to-menu' );
        IS_Help::help_info( $content );
        $html = '';
        $args = array(
            'numberposts' => -1,
            'post_type'   => 'is_search_form',
        );
        $posts = get_posts( $args );
        
        if ( !empty($posts) ) {
            $check_value = ( isset( $this->opt['footer_search'] ) ? $this->opt['footer_search'] : 0 );
            $html .= '<select class="ivory_search_footer" id="is_footer_search" name="is_settings[footer_search]" >';
            $html .= '<option value="0" ' . selected( 0, $check_value, false ) . '>' . __( 'None', 'add-search-to-menu' ) . '</option>';
            foreach ( $posts as $post ) {
                $html .= '<option value="' . $post->ID . '"' . selected( $post->ID, $check_value, false ) . ' >' . $post->post_title . '</option>';
            }
            $html .= '</select>';
            
            if ( $check_value && get_post_type( $check_value ) ) {
                $html .= '<a href="' . esc_url( menu_page_url( 'ivory-search', false ) ) . '&post=' . $check_value . '&action=edit">  ' . esc_html__( "Edit", 'add-search-to-menu' ) . '</a>';
            } else {
                $html .= '<a href="' . esc_url( menu_page_url( 'ivory-search-new', false ) ) . '">  ' . esc_html__( "Create New", 'add-search-to-menu' ) . '</a>';
            }
        
        }
        
        echo  '<div>' . $html . '</div>' ;
    }
    
    /**
     * Displays display in header field.
     */
    function menu_search_in_header()
    {
        $check_value = ( isset( $this->opt['header_menu_search'] ) ? $this->opt['header_menu_search'] : 0 );
        $check_string = checked( 'header_menu_search', $check_value, false );
        $html = '<label for="is_search_in_header"><input class="ivory_search_display_in_header" type="checkbox" id="is_search_in_header" name="is_settings[header_menu_search]" value="header_menu_search" ' . $check_string . ' />';
        $html .= '<span class="toggle-check-text"></span>' . esc_html__( 'Display search form in site header on mobile devices', 'add-search-to-menu' ) . '</label>';
        echo  '<div>' . $html . '</div><br />' ;
        $html = '';
        $content = __( 'If this site uses cache then please select the below option to display search form on mobile.', 'add-search-to-menu' );
        IS_Help::help_info( $content );
        $check_value = ( isset( $this->opt['site_uses_cache'] ) ? $this->opt['site_uses_cache'] : 0 );
        $check_string = checked( 'site_uses_cache', $check_value, false );
        $html .= '<label for="is_site_uses_cache"><input class="ivory_search_display_in_header" type="checkbox" id="is_site_uses_cache" name="is_settings[site_uses_cache]" value="site_uses_cache" ' . $check_string . ' />';
        $html .= '<span class="toggle-check-text"></span>' . esc_html__( 'This site uses cache', 'add-search-to-menu' ) . '</label>';
        echo  '<div>' . $html . '</div>' ;
    }
    
    /**
     * Displays custom css field.
     */
    function custom_css()
    {
        $content = __( 'Add custom css code.', 'add-search-to-menu' );
        IS_Help::help_info( $content );
        $this->opt['custom_css'] = ( isset( $this->opt['custom_css'] ) ? $this->opt['custom_css'] : '' );
        $html = '<textarea class="ivory_search_css" rows="4" id="custom_css" name="is_settings[custom_css]" >' . esc_attr( $this->opt['custom_css'] ) . '</textarea>';
        echo  '<div>' . $html . '</div>' ;
    }
    
    /**
     * Displays stopwords field.
     */
    function stopwords()
    {
        $content = __( 'Enter stopwords here that will not be searched.', 'add-search-to-menu' );
        IS_Help::help_info( $content );
        $this->opt['stopwords'] = ( isset( $this->opt['stopwords'] ) ? $this->opt['stopwords'] : '' );
        $html = '<textarea class="ivory_search_stopwords" rows="4" id="stopwords" name="is_settings[stopwords]" >' . esc_attr( $this->opt['stopwords'] ) . '</textarea>';
        $html .= '<br /><label for="stopwords" style="font-size: 10px;">' . esc_html__( "Please separate multiple words with commas.", 'add-search-to-menu' ) . '</label>';
        echo  '<div>' . $html . '</div>' ;
    }
    
    /**
     * Displays synonyms field.
     */
    function synonyms()
    {
        $content = __( 'Add synonyms here to make the searches find better results.', 'add-search-to-menu' );
        $content .= '<br /><br />' . __( 'If you add bird = crow to the list of synonyms, searches for bird automatically become a search for bird crow and will thus match to posts that include either bird or crow.', 'add-search-to-menu' );
        $content .= '<br /><br /><span class="is-info-warning">' . __( 'This only works for search forms configured to search any of the search terms(OR) and not all search terms(AND) in the search form Options.', 'add-search-to-menu' ) . '</span>';
        IS_Help::help_info( $content );
        $this->opt['synonyms'] = ( isset( $this->opt['synonyms'] ) ? $this->opt['synonyms'] : '' );
        $html = '<textarea class="ivory_search_synonyms" rows="4" id="synonyms" name="is_settings[synonyms]" >' . esc_attr( $this->opt['synonyms'] ) . '</textarea>';
        $html .= '<br /><label for="synonyms" style="font-size: 10px;">' . esc_html__( 'The format here is key = value', 'add-search-to-menu' ) . '</label>';
        $html .= '<br /><label for="synonyms" style="font-size: 10px;">' . esc_html__( 'Please add every synonyms key = value pairs on new line.', 'add-search-to-menu' ) . '</label>';
        echo  '<div>' . $html . '</div>' ;
        $html = '';
    }
    
    /**
     * Displays do not load plugin files field.
     */
    function plugin_files()
    {
        $content = __( 'Enable below options to disable loading of plugin CSS and JavaScript files.', 'add-search-to-menu' );
        IS_Help::help_info( $content );
        $styles = array(
            'css' => __( 'Do not load plugin CSS files', 'add-search-to-menu' ),
            'js'  => __( 'Do not load plugin JavaScript files', 'add-search-to-menu' ),
        );
        $html = '';
        foreach ( $styles as $key => $file ) {
            $check_value = ( isset( $this->opt['not_load_files'][$key] ) ? $this->opt['not_load_files'][$key] : 0 );
            $check_string = checked( $key, $check_value, false );
            if ( 'js' == $key ) {
                $html .= '<br />';
            }
            $html .= '<br /><label for="not_load_files[' . esc_attr( $key ) . ']"><input class="not_load_files" type="checkbox" id="not_load_files[' . esc_attr( $key ) . ']" name="is_settings[not_load_files][' . esc_attr( $key ) . ']" value="' . esc_attr( $key ) . '" ' . $check_string . '/>';
            $html .= '<span class="toggle-check-text"></span>' . esc_html( $file ) . '</label>';
            $html .= '<span class="not-load-wrapper">';
            
            if ( 'css' == $key ) {
                $html .= '<br /><label for="not_load_files[' . esc_attr( $key ) . ']" style="font-size: 10px;">' . esc_html__( 'If checked, you have to add following plugin file code into your child theme CSS file.', 'add-search-to-menu' ) . '</label>';
                $html .= '<br /><a style="font-size: 13px;" target="_blank" href="' . plugins_url( '/public/css/ivory-search.css', IS_PLUGIN_FILE ) . '"/a>' . plugins_url( '/public/css/ivory-search.css', IS_PLUGIN_FILE ) . '</a>';
                $html .= '<br /><a style="font-size: 13px;" target="_blank" href="' . plugins_url( '/public/css/ivory-ajax-search.css', IS_PLUGIN_FILE ) . '"/a>' . plugins_url( '/public/css/ivory-ajax-search.css', IS_PLUGIN_FILE ) . '</a>';
                $html .= '<br />';
            } else {
                $html .= '<br /><label for="not_load_files[' . esc_attr( $key ) . ']" style="font-size: 10px;">' . esc_html__( "If checked, you have to add following plugin files code into your child theme JavaScript file.", 'add-search-to-menu' ) . '</label>';
                $html .= '<br /><a style="font-size: 13px;" target="_blank" href="' . plugins_url( '/public/js/ivory-search.js', IS_PLUGIN_FILE ) . '"/a>' . plugins_url( '/public/js/ivory-search.js', IS_PLUGIN_FILE ) . '</a>';
                $html .= '<br /><a style="font-size: 13px;" target="_blank" href="' . plugins_url( '/public/js/is-highlight.js', IS_PLUGIN_FILE ) . '"/a>' . plugins_url( '/public/js/is-highlight.js', IS_PLUGIN_FILE ) . '</a>';
                $html .= '<br /><a style="font-size: 13px;" target="_blank" href="' . plugins_url( '/public/js/ivory-ajax-search.js', IS_PLUGIN_FILE ) . '"/a>' . plugins_url( '/public/js/ivory-ajax-search.js', IS_PLUGIN_FILE ) . '</a>';
            }
            
            $html .= '</span>';
        }
        echo  '<div>' . $html . '</div>' ;
    }
    
    function extras()
    {
        /**
         * Controls default search functionality.
         */
        $content = __( 'Warning: Use with caution.', 'add-search-to-menu' );
        IS_Help::help_info( $content );
        $check_value = ( isset( $this->opt['default_search'] ) ? $this->opt['default_search'] : 0 );
        $disable = checked( 1, $check_value, false );
        $html = '<label for="is_default_search"><input class="ivory_search_default" type="checkbox" id="is_default_search" name="is_settings[default_search]" value="1" ' . $disable . ' />';
        $html .= '<span class="toggle-check-text"></span>' . esc_html__( 'Do not use Default Search Form to control WordPress default search functionality', 'add-search-to-menu' ) . '</label>';
        echo  '<div>' . $html . '</div><br />' ;
        /**
         * Disables search functionality on whole site.
         */
        $check_value = ( isset( $this->opt['disable'] ) ? $this->opt['disable'] : 0 );
        $disable = checked( 1, $check_value, false );
        $html = '<label for="is_disable"><input class="ivory_search_disable" type="checkbox" id="is_disable" name="is_settings[disable]" value="1" ' . $disable . ' />';
        $html .= '<span class="toggle-check-text"></span>' . esc_html__( 'Disable search functionality on entire website', 'add-search-to-menu' ) . '</label>';
        echo  '<div>' . $html . '</div><br />' ;
        /**
         * Display search forms easy to edit links.
         */
        $check_value = ( isset( $this->opt['easy_edit'] ) ? $this->opt['easy_edit'] : 0 );
        $easy_edit = checked( 1, $check_value, false );
        $html = '<br /><label for="is_easy_edit"><input class="ivory_search_easy_edit" type="checkbox" id="is_easy_edit" name="is_settings[easy_edit]" value="1" ' . $easy_edit . ' />';
        $html .= '<span class="toggle-check-text"></span>' . esc_html__( 'Display easy edit links of search form on the website frontend to the admin users', 'add-search-to-menu' ) . '</label>';
        echo  '<div>' . $html . '</div>' ;
    }

}