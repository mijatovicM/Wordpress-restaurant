<?php
/**
* Blogberg Author Widget
*
* @since Blogberg 1.0.0
*/
if( ! class_exists( 'Blogberg_Author_Widget' ) ) :
    
    class Blogberg_Author_Widget extends Blogberg_Base_Widget {

        var $image_field = 'image';  // the image field ID

        public function __construct() {

            $widget_ops = array(
                'description' => esc_html__( 'Widget for your profile.', 'blogberg' ), 
                'customize_selective_refresh' => true
            );
            
            parent::__construct(
                'blogberg_author_widget', 
                esc_html__( 'Blogberg Author', 'blogberg' ),
                $widget_ops
            );

            $this->fields = array(
                'title' => array(
                    'label'   => esc_html__( 'Title', 'blogberg' ),
                    'type'    => 'text',
                    'default' => esc_html__( 'About the Author', 'blogberg' )
                ),
                'page_id' => array(
                    'label' => esc_html__( 'Select Page', 'blogberg' ),
                    'type'  => 'dropdown-pages',
                ),
                'sub_title' => array(
                    'label'   => esc_html__( 'Sub Title', 'blogberg' ),
                    'type'    => 'text',
                    'default' => esc_html__( 'Lifestyle Blogger','blogberg' )
                ),
                'social_menu' => array(
                    'label' => esc_html__( 'Select Social Menu', 'blogberg' ),
                    'type'  => 'dropdown-menus',
                ) 
            );
        }

        public function widget( $args, $instance ) {
            
            echo $args[ 'before_widget' ];

            $instance = $this->init_defaults( $instance );
            $unique_id = uniqid();
            ?>
            <?php if( $instance[ 'page_id' ] ): ?>

            <section class="<?php echo empty( $instance[ 'title' ] ) ? esc_attr( 'no-title' ): ''; ?> wrapper author-widget class-<?php echo esc_attr( $unique_id ); ?>">
                <?php
                echo '<div class="widget-title-wrap">' . $args[ 'before_title'] . esc_html( $instance[ 'title' ] ) . $args[ 'after_title' ] . '</div>';

                $query = new WP_Query( array(
                    'p'         => $instance[ 'page_id' ],
                    'post_type' => 'page'
                ) );

                while( $query->have_posts() ){
                    $query->the_post();
                    if( has_post_thumbnail() ){
                        $src = get_the_post_thumbnail_url( get_the_ID(), 'thumbnail' );
                    }else{
                        $src = blogberg_get_dummy_image( array(
                            'size' => 'thumbnail'
                        ) );
                    }
                ?>
                <div class="widget-content">
                    <div class="profile">
                        <div class="name-title">
                            <headgroup>
                                <?php the_title( '<h2><a href="'. esc_url( get_permalink() ) .'">', '</a></h2>' ); ?>
                                 <span><?php echo esc_html( $instance[ 'sub_title' ] ); ?></span>
                            </headgroup>
                        </div>
                        <figure class="avatar">
                             <a href="<?php the_permalink(); ?>">
                                <img src="<?php echo esc_url( $src ); ?>" >
                             </a>
                        </figure>
                        <div class="text-content">
                            <?php
                                $excerpt_length = blogberg_get_option( 'post_excerpt_length' );
                                blogberg_excerpt( $excerpt_length , true );
                            ?>
                        </div>
                        <div class="socialgroup">
                            <?php echo $this->get_menu( $instance[ 'social_menu' ] ); ?>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </section>
            <?php endif; ?>
            <?php
            
            wp_reset_postdata();
            echo $args[ 'after_widget' ];
        }
    }

endif;