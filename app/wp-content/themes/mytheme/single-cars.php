<?php get_header();?>

<section class="page-wrap">

  <div class="container">

  <h1><?php the_title();?></h1>

    <div class="gallery">
    <?php if(has_post_thumbnail()): ?>
    <a href="<?php the_post_thumbnail_url('blog-large');?>">
      <img src="<?php the_post_thumbnail_url('blog-large');?>" alt="<?php the_title(); ?>" class="img-fluid mb-3 img-thumbnail">
    </a>
      
    <?php endif;?>
    </div>

    <?php
      $gallery = get_field('gallery');
      if($gallery):?>
      <div class="gallery mb-5">
        <?php foreach($gallery as $image):?>
          <a href="<?php echo $image['sizes']['blog-large'] ?>">
          <img src="<?php echo $image['sizes']['blog-small'] ?>" alt="" class="img-fluid img-thumbnail" >
          </a>
        <?php endforeach;?>
      </div>
      <?php endif;?>

      <div class="row">
        <div class="col-lg-6">
          <?php get_template_part('includes/section', 'cars');?>
          <?php wp_link_pages();?>
        </div>
        <div class="col-lg-6">
          


        <ul>
            <li>
              Colour: <?php echo get_field('colour');?>
          </li>
            
            

            <li>Registration: <?php echo get_field('registration');?> 

            
          </ul>

          <h3>Features</h3>

          <ul>
            <?php if(have_rows('features')):?>
              <?php while(have_rows('features')): the_row();
              $feature = get_sub_field('feature');
              ?>
                <li>
                  <?php echo $feature;?>
                </li>
              <?php endwhile;?>
            <?php endif;?>
          </ul>            

        </div>
      </div>

  </div>

</section>

<?php get_footer();?>