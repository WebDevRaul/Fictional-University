<?php 
  get_header();

  while((have_posts())) {
    the_post();
    ?>
      <div class="page-banner">
        <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/ocean.jpg') ?>);"></div>
        <div class="page-banner__content container container--narrow">
          <h1 class="page-banner__title"><?php the_title(); ?></h1>
          <div class="page-banner__intro">
            <p>DONT FORGET TO REPLACE ME LATER</p>
          </div>
        </div>  
      </div>
      <div class="container container--narrow page-section">
        <div class="metabox metabox--position-up metabox--with-home-link">
          <p><a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('program'); ?>"><i class="fa fa-home" aria-hidden="true"></i> All Programs </a> <span class="metabox__main"><?php the_title(); ?></span></p>
        </div>
        <div class="generic-content">
          <?php the_content(); ?>
          <?php 
            $queryProfessors = new WP_Query(array(
              "posts_per_page" => -1,
              "post_type" => "professor",
              "orderby" => "title",
              "order" => "ASC",
              "meta_query" => array(
                array(
                  "key" => "related_programs",
                  "compare" => "LIKE",
                  "value" => '"'.get_the_ID().'"',
                ),
              ),
            ));

            if($queryProfessors->have_posts()) {
              ?>
                <hr class="section-break">
                <h2 class="headline headline--medium"><?php the_title(); ?> Professors</h2>
              <?php
              while($queryProfessors->have_posts()) {
                $queryProfessors->the_post();
                ?>
                  <li>
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                  </li>
                <?php
              }
              wp_reset_postdata();
            };


            $today = date('Ymd');
            $queryEvents = new WP_Query(array(
              "posts_per_page" => -1,
              "post_type" => "event",
              "meta_key" => "event_date",
              "orderby" => "meta_value_num",
              "order" => "ASC",
              "meta_query" => array(
                array(
                  "key" => "event_date",
                  "compare" => ">=",
                  "value" => $today,
                  "type" => "numeric"
                ),
                array(
                  "key" => "related_programs",
                  "compare" => "LIKE",
                  "value" => '"'.get_the_ID().'"',
                ),
              ),
            ));

            if($queryEvents->have_posts()) {
              ?>
                <hr class="section-break">
                <h2 class="headline headline--medium">Upcoming <?php the_title(); ?> Events </h2>
              <?php
              while($queryEvents->have_posts()) {
                $queryEvents->the_post();
                ?>
                <div class="event-summary">
                  <a class="event-summary__date t-center" href="<?php the_permalink(); ?>">
                  
                    <span class="event-summary__month"><?php
                      $date = new DateTime(get_field('event_date'));
                      echo $date->format('M');
                    ?></span>
                    <span class="event-summary__day"><?php echo $date->format('d'); ?></span>
                  </a>
                  <div class="event-summary__content">
                    <h5 class="event-summary__title headline headline--tiny">
                      <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h5>
                    <p>
                      <?php wp_trim_words(the_content(), 18); ?>
                    <a href="<?php the_permalink(); ?>" class="nu gray">Learn more</a></p>
                  </div>
                </div>
                <?php
              }
              wp_reset_postdata();
            };
          ?>
        </div> 
      </div>
    <?php
  };
  get_footer();
?>