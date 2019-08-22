<?php

/**
 * Radio image customize control.
 *
 * @since Blogberg 1.0.0
 * @access public
 */
if ( class_exists( 'WP_Customize_Control' ) ) :
    class Blogberg_Customize_Control_Radio_Image extends WP_Customize_Control {

        /**
         * The type of customize control being rendered.
         *
         * @since Blogberg 1.0.0
         * @access public
         * @var    string
         */
        public $type = 'radio-image';

        /**
         * Loads the jQuery UI Button script and custom scripts/styles.
         *
         * @since Blogberg 1.0.0
         * @access public
         * @return void
         */
        public function enqueue() {
            wp_enqueue_script( 'jquery-ui-button' );
            wp_enqueue_script( 'blogberg-customize-controls', get_template_directory_uri() . '/modules/customizer/framework/js/customize-controls.js', array( 'jquery' ) );
            wp_enqueue_style( 'blogberg-customize-controls', get_template_directory_uri() . '/modules/customizer/framework/css/customize-controls.css' );
        }

        /**
         * Add custom JSON parameters to use in the JS template.
         *
         * @since Blogberg 1.0.0
         * @access public
         * @return void
         */
        public function to_json() {
            parent::to_json();

            // We need to make sure we have the correct image URL.
            foreach ( $this->choices as $value => $args )
                $this->choices[ $value ]['url'] = esc_url( sprintf( $args['url'], get_template_directory_uri(), get_stylesheet_directory_uri() ) );

            $this->json['choices'] = $this->choices;
            $this->json['link']    = $this->get_link();
            $this->json['value']   = $this->value();
            $this->json['id']      = $this->id;
        }

        public function render_content(){
            
            if( !$this->choices )
                return;

            if( $this->label ){
                ?>
                <span class="customize-control-title">
                    <?php echo esc_html( $this->label ); ?>
                </span>
                <?php
            }

            if ( $this->description ) { ?>
                <span class="description customize-control-description">
                    <?php echo esc_html( $this->description ); ?>
                </span>
            <?php } ?>
            <div class="buttonset">
                <?php foreach( $this->choices as $key => $val ) { 
                    $img = get_template_directory_uri() . $val[ 'url' ];
                ?>
                    <input type="radio" 
                        value="<?php echo esc_attr( $key ); ?>" 
                        name="_customize-<?php echo esc_attr( $this->type ); ?>-<?php echo esc_attr( $this->id ); ?>" id="<?php echo esc_attr( $this->id ); ?>-<?php echo esc_attr( $key ); ?>" <?php $this->link(); ?> <?php checked( $key, $this->value() ); ?> />

                    <label for="<?php echo esc_attr( $this->id ); ?>-<?php echo esc_attr( $key ); ?>">
                        <span class="screen-reader-text">
                            <?php echo esc_html( $val[ 'label'] ); ?>
                        </span>
                        <img src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( $val[ 'label'] ); ?>" />
                    </label>
                <?php } ?>
            </div>
            <?php
        }
    }
endif;