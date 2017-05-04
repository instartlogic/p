<?php

/*

Template Name: Contact

*/
	get_header('contact');
?>

    <?php
        $address = get_post_meta( $post->ID, '_sydney_map_address', true );
        $form = get_post_meta( $post->ID, '_sydney_map_contact', true );
        $aside_address = get_post_meta( $post->ID, '_sydney_map_aside_address', true );
        $aside_email = get_post_meta( $post->ID, '_sydney_map_aside_email', true );
        $aside_phone = get_post_meta( $post->ID, '_sydney_map_aside_phone', true );   
        $aside_title = get_post_meta( $post->ID, '_sydney_map_aside_title', true );  
    ?>

	<div id="primary" class="content-area">
		<main id="main" class="post-wrap" role="main">
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                <?php if ($form !='') : ?>
                <div class="col-md-8">
                    <div class="contact-form-wrap">
                        <?php while ( have_posts() ) : the_post(); ?>
                            <header class="entry-header">
                                <?php the_title( '<h1 class="title-post">', '</h1>' ); ?>
                            </header>
                        <?php endwhile; ?>  
                        <?php echo do_shortcode('[contact-form-7 id="' . absint($form) . '"]'); ?>
                     </div><!-- /.contact-form-wrap -->
                </div><!-- /.col-md-8 -->
                <?php endif; ?> 

                <div class="col-md-4">
                        <div class="contact-form-aside">
                            <h5 class="title-post"><?php echo $aside_title; ?></h5>
                            <ul class="roll-infomation">
                                <?php if ($aside_address) : ?>
                                <li class="address"><?php echo $aside_address; ?></li>
                                <?php endif; ?> 
                                <?php if ($aside_phone) : ?>
                                <li class="phone"><?php echo $aside_phone; ?></li>
                                <?php endif; ?> 
                                <?php if ($aside_email) : ?>
                                <li class="email"><?php echo $aside_email; ?></li>
                                <?php endif; ?>
                            </ul>
                        </div><!-- /.contact-form-aside -->
                </div><!-- /.col-md-4 -->

            </article>
		</main><!-- #main -->
	</div><!-- #primary -->

<script type="text/javascript">
    jQuery(function($) {
        if ( $().gmap3 ) {
            $("#map").gmap3({
                map:{
                    options:{
                        zoom: 14,
                        mapTypeId: 'Idea_style',
                        mapTypeControlOptions: {
                            mapTypeIds: ['Idea_style', google.maps.MapTypeId.SATELLITE, google.maps.MapTypeId.HYBRID]
                        },
                        scrollwheel: false
                    }
                },
                getlatlng:{
                    address: "<?php echo $address; ?>",
                    callback: function(results) {
                        if ( !results ) return;
                        $(this).gmap3('get').setCenter(new google.maps.LatLng(results[0].geometry.location.lat(), results[0].geometry.location.lng()));
                        $(this).gmap3({
                            marker:{
                                latLng:results[0].geometry.location
                            }
                        });
                    }
                },
                styledmaptype:{
                    id: "Idea_style",
                    options:{
                        name: "Map"
                    },
                },
            });
        }
    });
</script>    

<?php get_footer(); ?>

