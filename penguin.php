<?php
/*
Title: Self-Paced Penguin CMS Template
Version: 0.01
Author: Damion Armentrout & Austin Cooley
*/

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php the_title(); ?></title>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo plugin_dir_url(__FILE__); ?>penguin-assets/style.css">

    <style>
        .cat-icon-a { background-color: <?php echo get_field('header_color'); ?>; }
        <?php
        $header_color = get_field('header_color');
        if('#de3518' == $header_color): ?>
            #heading{
                background-image: url('<?php echo plugin_dir_url(__FILE__); ?>penguin-assets/images/logo-white.png');
            }
            #heading h1,
            .cat-icon-a{
                color: white!important;
            }
        <?php endif; ?>
    </style>

</head>
<body>
<div id="container" class="container">
<div id="wrapper" class="row">


<?php if(have_posts()) : ?><?php while(have_posts()) : the_post();

    // check if the repeater field has rows of data
    if( have_rows('repeaterslide') ): ?>

    <div id="heading" class="col-md-12" style="background-color: <?php the_field('header_color'); ?>">
        <h1><?php the_title(); ?></h1>
    </div>

    <img src="<?php echo plugin_dir_url(__FILE__); ?>penguin-assets/images/<?php the_field('hero_image'); ?>" id="headerPhoto" alt="">

    <div id="main" class="col-md-12">

        <!--START OF CONTENT-->
        <?php

                    // loop through the rows of data
                    while ( have_rows('repeaterslide') ) : the_row();

                        if( !empty(get_sub_field('repeatersub')) ){ ?>

                            <div class="category">
                                <div class="cat-head" tabindex="0" role="button">
                                    <h2 class="default"><?php the_sub_field('rptrtitle'); ?></h2>
                                    <img src="<?php echo plugin_dir_url(__FILE__); ?>penguin-assets/images/arrow.png" class="arrow" alt=""/>
                                    <div class="cat-icon-a">00</div>
                                </div>
                                <div class="cat-content">
                                    <?php the_sub_field('repeatersub'); ?>
                                </div>
                            </div>
                            <!-- end .category -->

                        <?php }

                        // get subfield contents, replace bracket codes with html elements

                        $carousel = get_sub_field('rptrinnerslide');

                        if( !empty($carousel) ){ ?>

                            <div class="category">
                                <div class="cat-head" tabindex="0" role="button">
                                    <h2 class="default"><?php the_sub_field('rptrtitle'); ?></h2>
                                    <img src="<?php echo plugin_dir_url(__FILE__); ?>penguin-assets/images/arrow.png" class="arrow"/>
                                    <div class="cat-icon-a">00</div>
                                </div>
                                <div class="cat-content carousel-container">

                                <div id="carousel-1" class="carousel slide" data-interval="false">
                                <div class="carousel-inner" role="listbox"  aria-live="polite">

                                <?php

                                    $carousel = preg_replace('/\[slide\]/i', '<div class="item">', $carousel);
                                    $carousel = preg_replace('/item/', 'item active', $carousel, 1);
                                    $carousel = preg_replace('/\[\/slide\]/i', '</div>', $carousel);

                                    echo $carousel;
                                ?>

                                </div>
                                <!-- CONTROLS -->
                                <div class="controls row">
                                    <!-- Controls -->
                                    <a class="left carousel-control" href="#carousel-1" role="button" data-slide="prev" tabindex="-1">
                                        <span class="glyphicon-chevron-left" aria-hidden="true" tabindex="0"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <!-- Indicators -->
                                    <ol class="carousel-indicators" aria-label="Jump to Slide">
                                    </ol>
                                    <a class="right carousel-control" href="#carousel-1" role="button" data-slide="next" tabindex="-1">
                                        <span class="glyphicon-chevron-right" aria-hidden="true" tabindex="0"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>
                                </div>


                                </div>
                                <!-- end cat-content -->
                            </div>

                        <?php }

                    endwhile;

                else :

                    // no rows found

                endif;

            ?>

    <?php endwhile; endif; ?>



        <div class="clear">
            <!-- keep this at the bottom
            within #main to create some
            space by shoving it down to
            the footer -->
        </div>

    </div>
    <!-- end #main -->

</div>
<!-- end #wrapper -->


<div id="sticky-footer" class="row">
    <div class="col-md-12">
        <img src="<?php echo plugin_dir_url(__FILE__); ?>penguin-assets/images/someLogo.png" alt=""> &copy; 2006-<span id="currentYear">2016</span> Some Company, Inc. All rights reserved.
    </div>
</div>

</div>
<!-- end #container -->






<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" crossorigin="anonymous"></script>
<script src="<?php echo plugin_dir_url(__FILE__); ?>penguin-assets/what-input/dist/what-input.js"></script>

<script>
// set the numbers on the right for each dropdown
jQuery('.category').each(function(){
    var thisIndex = $(this).index() + 1;
    jQuery(this).find('.cat-icon-a').text( thisIndex );
    // if there's a carousel, rename the id and add control elements
    if( jQuery(this).find('.cat-content').hasClass('carousel-container') ){
        jQuery(this).find('.slide').attr('id','carousel-' + thisIndex);
        jQuery(this).find('.carousel-control').attr('href','#carousel-' + thisIndex);
        var slideCount = jQuery(this).find('.item').last().index();
        var i = 0;
        while( i <= slideCount ){
            jQuery(this).find('.carousel-indicators').append(
                '<li data-target="#carousel-' + thisIndex +'" data-slide-to="' + i + '" tabindex="0" aria-label="slide ' + (i+1) + '" role="button"></li>'
            );
            i++;
        }
        jQuery(this).find('.carousel-indicators li:eq(0)').addClass('active');
    }
});

</script>


<script src="<?php echo plugin_dir_url(__FILE__); ?>penguin-assets/script.js"></script>




<!-- GOOGLE ANALYTICS FOR MM -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
  ga('create', 'XXXXXXX', 'auto');
  ga('send', 'pageview');
</script>

</body>
</html>
