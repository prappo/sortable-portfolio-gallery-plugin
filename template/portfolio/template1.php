<?php

wp_head();

get_header();
?>
    <div style="margin-top: 20px;margin-bottom: 50px" class="container">
        <div class="columns">

        </div>
        <div class="columns box">

            <div class="column">

                <div class="content ">
                    <svg viewBox="0 0 580 150">
                        <text text-anchor="middle" x="50%" y="50%"><?php echo get_the_title() ?></text>
                    </svg>
                    <!--                    <h1 style="text-align: center">-->

                    <div style="text-align: center">

                        <img class="sggRoundImage" src="<?php echo get_the_post_thumbnail_url() ?>"/>
	                    <br><br>
                        <?php
                            $preview_url = get_post_meta(get_the_ID(),'preview_url',true) ? get_post_meta(get_the_ID(),'preview_url',true) : '#'
                        ?>
	                    <a href="<?php echo $preview_url ?>" target="_blank" class="demoLink">Preview</a>
                    </div>

                    <div class="psg_content">
	                    <?php echo get_the_content() ?>
                    </div>

                </div>
            </div>
        </div>

    </div>


<?php
get_footer();
wp_footer();