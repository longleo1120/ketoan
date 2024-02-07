<?php

/**

 * Created by PhpStorm.

 * User: WEB

 * Date: 20/07/2018

 * Time: 11:14 SA

 */



function news_recruitment_ux_builder_element() {



    // Set defaults

    $repeater_columns = '4';

    $repeater_type = 'slider';

    $repeater_post_type = 'recruitment';

    $repeater_col_spacing = 'normal';



    $repeater_post_cat = 'recruitment_cat';

    $default_text_align = 'center';



    $options =  array(

        'style_options' => array(

            'type' => 'group',

            'heading' => __( 'Style' ),

            'options' => array(

                'style' => array(

                    'type' => 'select',

                    'heading' => __( 'Style' ),

                    'default' => '',

                    'options' => require( PARENT_THEME . '/values/box-layouts.php' )

                )

            ),

        ),

        'layout_options' => require( PARENT_THEME . '/commons/repeater-options.php' ),

        'layout_options_slider' => require( PARENT_THEME . '/commons/repeater-slider.php' ),

        'post_options' => require( PARENT_THEME . '/commons/repeater-posts.php' ),

        'post_title_options' => array(

            'type' => 'group',

            'heading' => __( 'Title' ),

            'options' => array(

                'title_size' => array(

                    'type' => 'select',

                    'heading' => 'Title Size',

                    'default' => '',

                    'options' => require( PARENT_THEME . '/values/sizes.php' )

                ),

                'title_style' => array(

                    'type' => 'radio-buttons',

                    'heading' => 'Title Style',

                    'default' => '',

                    'options' => array(

                        ''   => array( 'title' => 'Abc'),

                        'uppercase' => array( 'title' => 'ABC'),

                    )

                ),

            )

        ),

        'read_more_button' => array(

            'type' => 'group',

            'heading' => __( 'Read More' ),

            'options' => array(

                'readmore' => array(

                    'type' => 'textfield',

                    'heading' => 'Text',

                    'default' => '',

                ),

                'readmore_color' => array(

                    'type' => 'select',

                    'heading' => 'Color',

                    'conditions' => 'readmore',

                    'default' => '',

                    'options' => array(

                        '' => 'Default',

                        'primary' => 'Primary',

                        'secondary' => 'Secondary',

                        'alert' => 'Alert',

                        'success' => 'Success',

                        'white' => 'White',

                    )

                ),

                'readmore_style' => array(

                    'type' => 'select',

                    'heading' => 'Style',

                    'conditions' => 'readmore',

                    'default' => 'outline',

                    'options' => array(

                        '' => 'Default',

                        'outline' => 'Outline',

                        'link' => 'Simple',

                        'underline' => 'Underline',

                        'shade' => 'Shade',

                        'bevel' => 'Bevel',

                        'gloss' => 'Gloss',

                    )

                ),

                'readmore_size' => array(

                    'type' => 'select',

                    'conditions' => 'readmore',

                    'heading' => 'Size',

                    'default' => '',

                    'options' => require( PARENT_THEME . '/values/sizes.php' ),

                ),

            )

        ),

        'post_meta_options' => array(

            'type' => 'group',

            'heading' => __( 'Meta' ),

            'options' => array(



                'show_date' => array(

                    'type' => 'select',

                    'heading' => 'Date',

                    'default' => 'false',

                    'options' => array(

                        'badge' => 'Badge',

                        'text' => 'Text',

                        'false' => 'Hidden',

                    )

                ),

                'badge_style' => array(

                    'type' => 'select',

                    'heading' => 'Badge Style',

                    'default' => '',

                    'conditions' => 'show_date == "badge"',

                    'options' => array(

                        '' => 'Default',

                        'outline' => 'Outline',

                        'square' => 'Square',

                        'circle' => 'Circle',

                        'circle-inside' => 'Circle Inside',

                    )

                ),

                'excerpt' => array(

                    'type' => 'select',

                    'heading' => 'Excerpt',

                    'default' => 'false',

                    'options' => array(

                        'visible' => 'Visible',

                        'fade' => 'Fade In On Hover',

                        'slide' => 'Slide In On Hover',

                        'reveal' => 'Reveal On Hover',

                        'false' => 'Hidden',

                    )

                ),

                'excerpt_length' => array(

                    'type' => 'slider',

                    'heading' => 'Excerpt Length',

                    'default' => 15,

                    'max' => 50,

                    'min' => 5,

                ),

                'show_category' => array(

                    'type' => 'select',

                    'heading' => 'Category',

                    'default' => 'false',

                    'options' => array(

                        'label' => 'Label',

                        'text' => 'Text',

                        'false' => 'Hidden',

                    )

                ),

                'comments' => array(

                    'type' => 'select',

                    'heading' => 'Comments',

                    'default' => 'false',

                    'options' => array(

                        'visible' => 'Visible',

                        'false' => 'Hidden',

                    )

                ),

            ),

        ),

    );





    $box_styles = require( PARENT_THEME . '/commons/box-styles.php' );

    $options = array_merge($options, $box_styles);



    add_ux_builder_shortcode('ux_news_recruitment', array(

        'name' => __('A2Z - Tin tuyển dụng'),

        'category' => __('A2Z Content'),

        'priority' => 1,

        'options' => $options,

    ));

}



add_action('ux_builder_setup', 'news_recruitment_ux_builder_element');



function news_recruitment_shortcode($atts)

{

    extract(shortcode_atts(array(

		"_id" => 'row-'.rand(),

		'style' => '',

		'class' => '',

		'visibility' => '',



		// Layout

		"columns" => '4',

		"columns__sm" => '1',

		"columns__md" => '',

		'col_spacing' => '',

		"type" => 'slider', // slider, row, masonery, grid

		'width' => '',

		'grid' => '1',

		'grid_height' => '600px',

		'grid_height__md' => '500px',

		'grid_height__sm' => '400px',

		'slider_nav_style' => 'reveal',

		'slider_nav_position' => '',

		'slider_nav_color' => '',

		'slider_bullets' => 'false',

	 	'slider_arrows' => 'true',

		'auto_slide' => 'false',

		'infinitive' => 'true',

		'depth' => '',

   		'depth_hover' => '',



		// posts

		'posts' => '8',

		'ids' => false, // Custom IDs

		'cat' => '',

		'category' => '', // Added for Flatsome v2 fallback

		'excerpt' => 'false',

		'excerpt_length' => 15,

		'offset' => '',

		'orderby' => 'date',

		'order' => 'DESC',



		// Read more

		'readmore' => '',

		'readmore_color' => '',

		'readmore_style' => 'outline',

		'readmore_size' => 'small',



		// div meta

		'post_icon' => 'true',

		'comments' => 'false',

		'show_date' => 'false', // badge, text

		'badge_style' => '',

		'show_category' => 'false',



		//Title

		'title_size' => 'large',

		'title_style' => '',



		// Box styles

		'animate' => '',

		'text_pos' => 'bottom',

	  	'text_padding' => '',

	  	'text_bg' => '',

	  	'text_size' => '',

	 	'text_color' => '',

	 	'text_hover' => '',

	 	'text_align' => 'center',

	 	'image_size' => 'medium',

	 	'image_width' => '',

	 	'image_radius' => '',

	 	'image_height' => '56%',

	    'image_hover' => '',

	    'image_hover_alt' => '',

	    'image_overlay' => '',

	    'image_depth' => '',

	    'image_depth_hover' => '',



	), $atts));



	// Stop if visibility is hidden

    if($visibility == 'hidden') return;



	ob_start();



	$classes_box = array();

	$classes_image = array();

	$classes_text = array();



	// Fix overlay color

    if($style == 'text-overlay'){

      $image_hover = 'zoom';

    }

    $style = str_replace('text-', '', $style);



	// Fix grids

	if($type == 'grid'){

	  if(!$text_pos) $text_pos = 'center';

	  $columns = 0;

	  $current_grid = 0;

	  $grid = flatsome_get_grid($grid);

	  $grid_total = count($grid);

	  flatsome_get_grid_height($grid_height, $_id);

	}



	// Fix overlay

	if($style == 'overlay' && !$image_overlay) $image_overlay = 'rgba(0,0,0,.25)';



	// Set box style

	if($style) $classes_box[] = 'box-'.$style;

	if($style == 'overlay') $classes_box[] = 'dark';

	if($style == 'shade') $classes_box[] = 'dark';

	if($style == 'badge') $classes_box[] = 'hover-dark';

	if($text_pos) $classes_box[] = 'box-text-'.$text_pos;



	if($image_hover)  $classes_image[] = 'image-'.$image_hover;

	if($image_hover_alt)  $classes_image[] = 'image-'.$image_hover_alt;

	if($image_height) $classes_image[] = 'image-cover';



	// Text classes

	if($text_hover) $classes_text[] = 'show-on-hover hover-'.$text_hover;

	if($text_align) $classes_text[] = 'text-'.$text_align;

	if($text_size) $classes_text[] = 'is-'.$text_size;

	if($text_color == 'dark') $classes_text[] = 'dark';



	$css_args_img = array(

	  array( 'attribute' => 'border-radius', 'value' => $image_radius, 'unit' => '%' ),

	  array( 'attribute' => 'width', 'value' => $image_width, 'unit' => '%' ),

	);



	$css_image_height = array(

      array( 'attribute' => 'padding-top', 'value' => $image_height),

  	);



	$css_args = array(

      array( 'attribute' => 'background-color', 'value' => $text_bg ),

      array( 'attribute' => 'padding', 'value' => $text_padding ),

  	);



    // Add Animations

	if($animate) {$animate = 'data-animate="'.$animate.'"';}



	$classes_text = implode(' ', $classes_text);

	$classes_image = implode(' ', $classes_image);

	$classes_box = implode(' ', $classes_box);



	// Repeater styles

	$repeater['id'] = $_id;

	$repeater['type'] = $type;

	$repeater['class'] = $class;

	$repeater['visibility'] = $visibility;

	$repeater['style'] = $style;

	$repeater['slider_style'] = $slider_nav_style;

	$repeater['slider_nav_position'] = $slider_nav_position;

	$repeater['slider_nav_color'] = $slider_nav_color;

	$repeater['slider_bullets'] = $slider_bullets;

    $repeater['auto_slide'] = $auto_slide;

	$repeater['row_spacing'] = $col_spacing;

	$repeater['row_width'] = $width;

	$repeater['columns'] = $columns;

	$repeater['columns__md'] = $columns__md;

	$repeater['columns__sm'] = $columns__sm;

	$repeater['depth'] = $depth;

	$repeater['depth_hover'] = $depth_hover;



	$args = array(

		'post_status' => 'publish',

		'post_type' => 'recruitment',

		'offset' => $offset,

		'posts_per_page' => $posts,

		'ignore_sticky_posts' => true,

		'orderby'             => $orderby,

		'order'               => $order,

	);

    if ($cat) {

        $args['tax_query'] = array(

            array(

                'taxonomy' => 'recruitment_cat',

                'field' => 'term_id',

                'terms' => $cat

            )

        );

    }     



	// Added for Flatsome v2 fallback

	if ( get_theme_mod('flatsome_fallback', 0) && $category ) {

		$args['category_name'] = $category;

	}



	// If custom ids

	if ( !empty( $ids ) ) {

		$ids = explode( ',', $ids );

		$ids = array_map( 'trim', $ids );



		$args = array(

			'post__in' => $ids,

            'post_type' => array(

                'recruitment',

            ),

			'numberposts' => -1,

			'orderby' => 'post__in',

			'posts_per_page' => 9999,

			'ignore_sticky_posts' => true,

		);

	}



    $recentPosts = new WP_Query( $args );



    // Get repeater HTML.

    get_flatsome_repeater_start($repeater);



    while ( $recentPosts->have_posts() ) : $recentPosts->the_post();



        $col_class    = array( 'post-item' );

        $show_excerpt = $excerpt;



        if(get_post_format() == 'video') $col_class[] = 'has-post-icon';



        if($type == 'grid'){

        if($grid_total > $current_grid) $current_grid++;

        $current = $current_grid-1;



        $col_class[] = 'grid-col';

        if($grid[$current]['height']) $col_class[] = 'grid-col-'.$grid[$current]['height'];



        if($grid[$current]['span']) $col_class[] = 'large-'.$grid[$current]['span'];

        if($grid[$current]['md']) $col_class[] = 'medium-'.$grid[$current]['md'];



        // Set image size

        if($grid[$current]['size']) $image_size = $grid[$current]['size'];



        // Hide excerpt for small sizes

        if($grid[$current]['size'] == 'thumbnail') $show_excerpt = 'false';

    } ?>

<div class="col recruitment-item <?php echo implode(' ', $col_class); ?>" <?php echo $animate;?>>

    <div class="col-inner">

        <div class="plain">

            <div class="box-recruitment">

                <?php do_action('flatsome_blog_recruitment_before'); ?>

                <div class="row row-collapse align-middle">

                    <div class="col large-9 medium-12 small-12">

                        <h5 class="post-title is-<?php echo $title_size; ?> <?php echo $title_style;?>">

                            <a href="<?php the_permalink() ?>" title="<?php the_title(); ?>">

                                <?php the_title(); ?>

                            </a>

                        </h5>
                        
                        

                        <?php do_action('flatsome_blog_recruitment_after'); ?>

                    </div>

                    <div class="col large-3 medium-12 small-12 text-right">

                        <a href="<?php the_permalink() ?>" class="apply-now">

                            Ứng tuyển

                        </a>

                    </div>

                </div>

                <?php if(has_post_thumbnail() && ($show_date == 'badge' || $show_date == 'true')) {?>

                <?php if(!$badge_style) $badge_style = get_theme_mod('blog_badge_style', 'outline'); ?>

                <div class="badge absolute top post-date badge-<?php echo $badge_style; ?>">

                    <div class="badge-inner">

                        <span class="post-date-day"><?php echo get_the_time('d', get_the_ID()); ?></span><br>

                        <span class="post-date-month is-xsmall"><?php echo get_the_time('M', get_the_ID()); ?></span>

                    </div>

                </div>

                <?php } ?>

            </div>

        </div>

    </div>

</div>

<?php flatsome_posts_pagination(); ?>

<?php endwhile;

    wp_reset_query();



    // Get repeater end.

    get_flatsome_repeater_end($atts);



    $content = ob_get_contents();

    ob_end_clean();

    return $content;

}



add_shortcode('ux_news_recruitment', 'news_recruitment_shortcode');