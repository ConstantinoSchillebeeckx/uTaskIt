			<!-- footer -->
			<footer class="footer" role="contentinfo" style="margin-top:20px;">

				<!-- copyright -->
				<p class="copyright">
					&copy; <?php echo date('Y'); ?> Copyright <?php bloginfo('name'); ?>
				</p>
				<!-- /copyright -->

			</footer>
			<!-- /footer -->

		</div>
		<!-- /wrapper -->

		<?php wp_footer(); ?>

		<script>
       			// conditionizr.com
		        // configure environment tests
        		conditionizr.config({
            			assets: '<?php echo get_template_directory_uri(); ?>',
            			tests: {}
        		});
        	</script>

		<!-- analytics -->
        <script>
          (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

          ga('create', 'UA-81113829-1', 'auto');
          ga('send', 'pageview');

        </script>

	</body>
</html>
