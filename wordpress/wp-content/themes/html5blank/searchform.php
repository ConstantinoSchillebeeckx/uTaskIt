<!-- search -->
<div class="row">
	<div class="col-sm-4 col-md-offset-1">
		<label>Task search</label>
		<form class="search" method="get" action="<?php echo home_url(); ?>" role="search">
			<div class="input-group">
				<input type="search" name="s" class="form-control search-input" placeholder="<?php _e( 'To search for a task, type and hit enter.', 'html5blank' ); ?>">
				<span class="input-group-btn">
					<input type="hidden" name="post_type" value="task">
					<button class="btn btn-primary search-submit" type="submit" role="button"><i class="fa fa-search fa-lg"></i></button>
				</span>
			</div>
		</form>
		<p style="margin-top:10px; margin-left:5px;"><a href='?s&post_type=task'>View all tasks</a></p>
	</div>


	<div class="col-sm-4 col-md-offset-2">
		<label>User search</label>
		<form class="search" method="get" action="<?php echo home_url(); ?>" role="search">
			<div class="input-group">
				<input type="search" name="s" class="form-control search-input" placeholder="<?php _e( 'To search for a user, type and hit enter.', 'html5blank' ); ?>">
				<span class="input-group-btn">
					<input type="hidden" name="post_type" value="user">
					<button class="btn btn-primary search-submit" type="submit" role="button"><i class="fa fa-search fa-lg"></i></button>
				</span>
			</div>
		</form>
		<p style="margin-top:10px; margin-left:5px;"><a href='?s&post_type=user'>View all users</a></p>
	</div>
</div>




<!-- /search -->
