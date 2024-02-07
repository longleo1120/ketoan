<?php
/**
 * The template for displaying the footer.
 *
 * @package flatsome
 */

global $flatsome_opt;
?>

</main>

<footer id="footer" class="footer-wrapper">

	<?php do_action('flatsome_footer'); ?>

</footer>

</div>

<?php
    if(is_singular( 'service' )):
?>

<div id="popup-register" class="lightbox-register-service lightbox-by-id lightbox-content lightbox-white mfp-hide" style="max-width:900px ;">
    <?php echo do_shortcode('[block id="popup-form-dich-vu"]'); ?>
</div>



<?php
    endif;

?>
<div id="popup-consultation" class="lightbox-register-service lightbox-by-id lightbox-content lightbox-white mfp-hide" style="max-width:900px ;">
    <?php echo do_shortcode('[contact-form-7 id="671" title="Form đăng ký tư vấn"]') ?>
</div>

<a class="btn-sm-consultation" href="#popup-consultation">
    <img src="<?php echo get_stylesheet_directory_uri();?>/assets/img/icon-gmail.svg" alt="">
</a>
<a class="btn-sm-consultation btn-sm-hotline" href="tel:0829985588">
    <img src="<?php echo get_stylesheet_directory_uri();?>/assets/img/user-advise.svg" alt="">
</a>

<script>
    document.addEventListener( 'wpcf7mailsent', function( event ) {

        if(event.detail.contactFormId == '626') {
            location = '<?php echo get_page_link(773); ?>';
        }else if(event.detail.contactFormId == '670') {
            location = '<?php echo get_page_link(773); ?>';
        }else if(event.detail.contactFormId == '671') {
            location = '<?php echo get_page_link(657); ?>';
        }else{
            location = '<?php echo get_page_link(657); ?>';
        }


    }, false );
</script>


<?php wp_footer(); ?>

</body>
</html>
