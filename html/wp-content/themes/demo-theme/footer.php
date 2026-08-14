</main>

<footer class="site-footer">
    <div class="footer-container">
        <p>&copy; <?php echo esc_html(wp_date('Y')); ?> <?php bloginfo('name'); ?>.</p>
        <a href="<?php echo esc_url(home_url('/kontakt/')); ?>" class="btn-primary">Kontakt</a>
    </div>
</footer>
<?php wp_footer(); ?>
</body>

</html>