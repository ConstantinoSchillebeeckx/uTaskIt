<div class="row">
	<div class="col-sm-10 col-sm-offset-1">
		<form method="post" action="" autocomplete="off" id="task_form">
			<div class="row">
				<div class="col-sm-12">

					<? if ($action == 'create' || $action == 'edit') { ?>
						<h3>Public part</h3>
						<hr>
						<p>These are the public details of the task that will be visible to any UTaskiT consultants.</p>
					<?php } ?>
					<?php show_public_part($post_meta, $post_data); ?>

					<? if ($action == 'create' || $action == 'edit') { ?>
						<h3>Private part</h3>
						<hr>
						<p>
                            Choose the appropriate option below to make the task description and deliverables private:
                            <div class="radio">
                                <label>
                                  <input type="radio" name="task_private" id="task_private" value="private" <?php echo (!isset($post_meta['task_private']) || $post_meta['task_private'] == "private") ? "checked" : null ?> > Make private - no one will see these details except the consultant hired for this task
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                  <input type="radio" name="task_private" id="task_private" value="public" <?php echo $post_meta['task_private'] == "public" ? "checked" : null ?>> Make public - anyone viewing the task can see these details
                                </label>
                            </div>
                        </p>
					<?php } ?>
					<? if ($action == 'create' || $action == 'edit' || $post_meta['hired'] == $current_user->ID || $post_meta['task_private'] == 'public') { // show task if editing or person was hired ?>
						<?php show_private_part($post_meta, $post_data); ?>
					<?php } ?>
				</div>
			</div>


			<?php
			// note that $action is set in the yti_task_form() function
			if ( $action == 'create' || $action == 'edit' ) { // if creating or editing a task
				if ( $action == 'edit' ) { ?>
                    <?php
                    if (isset($post_meta['hired'])) {
						echo '<button type="submit" value="restore_task" name="action" class="btn btn-success pull-right"><i class="fa fa-check-circle" aria-hidden="true"></i> Un-hire</button>';
					} else if ( $post_data->post_status == 'pending' ) {
						echo '<button type="submit" value="restore_task" name="action" class="btn btn-success pull-right"><i class="fa fa-check-circle" aria-hidden="true"></i> Restore</button>';
					} else {
						echo '<button type="submit" value="archive_task" name="action" class="btn btn-danger pull-right"><i class="fa fa-trash-o" aria-hidden="true"></i> archive</button>';
					}
                    ?>
					<button type="submit" name="action" class="btn btn-primary pull-right" style="margin-right:5px" value="submit_task">Submit Task changes</button>
				<?php } else { ?>
					<button type="submit" name="action" class="btn btn-primary pull-right" value="submit_task">Create new Task</button>
				<?php } ?>
				<?php } else {
				if (yti_user_has_applied_to_task( $task_id )) { // $task_id will be defined if post is set for viewing
					echo '<button type="button" class="btn btn-warning pull-right disabled">You\'ve already applied</button>';
				} else if (get_the_author_meta('ID') == $current_user->ID) { // if task author is viewing their own task
					yti_list_applicants( $task_id );
				} else { ?>
					<button type="submit" name="action" class="btn btn-primary pull-right" value="apply_task">Apply to Task</button>
				<?php }
			} ?>
		</form>
	</div>
</div>


<?php function show_public_part($post_meta, $post_data) {
	?>
	<div class="row">
		<div class="col-sm-12">
			<div class="form-group">
				<label>Task title</label>
				<input type="text" name="task_title" class="form-control" required maxlength="140"
				value="<?php echo $post_data->post_title; ?>" >
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-12">
			<div class="row">
				<div class="col-sm-3">
					<div class="form-group">
						<label>Task Sector</label><br>
						<select name='task_sector' required>
							<option selected disabled hidden style='display: none' value=''></option>
							<option value="life_sciences"
							<?php echo ($post_meta['task_sector'] == 'life_sciences') ? 'selected' : null ?>
							>life sciences</option>
							<option value="app_web"
							<?php echo ($post_meta['task_sector'] == 'app_web') ? 'selected' : null ?>
							>apps and websites</option>
							<option value="service"
							<?php echo ($post_meta['task_sector'] == 'service') ? 'selected' : null ?>
							>service industry</option>
						</select>
					</div>
				</div>
				<div class="col-sm-3">
					<div class="form-group">
						<label>Task type</label><br>
						<select name='task_type' required>
							<option selected disabled hidden style='display: none' value=''></option>
							<option value="customer_validation"
							<?php echo ($post_meta['task_type'] == 'customer_validation') ? 'selected' : null ?>
							>customer validation</option>
							<option value="ip"
							<?php echo ($post_meta['task_type'] == 'ip') ? 'selected' : null ?>
							>IP analysis</option>
							<option value="legal_services"
							<?php echo ($post_meta['task_type'] == 'legal_services') ? 'selected' : null ?>
							>legal services</option>
							<option value="bookkeeping"
							<?php echo ($post_meta['task_type'] == 'bookkeeping') ? 'selected' : null ?>
							>bookkeeping services</option>
							<option value="lit_review"
							<?php echo ($post_meta['task_type'] == 'lit_review') ? 'selected' : null ?>
							>literature review</option>
							<option value="comp_analysis"
							<?php echo ($post_meta['task_type'] == 'comp_analysis') ? 'selected' : null ?>
							>competitive analysis</option>
							<option value="web"
							<?php echo ($post_meta['task_type'] == 'web') ? 'selected' : null ?>
							>web/logo/advert/other design</option>
							<option value="exp_design"
							<?php echo ($post_meta['task_type'] == 'exp_design') ? 'selected' : null ?>
							>experimental design</option>
						</select>
					</div>
				</div>
				<div class="col-sm-3">
					<div class="form-group">
						<label>Task due date</label><br>
						<input type='text' class="form-control" id='datetimepicker' name="task_date"
						value="<?php echo $post_meta['task_date']; ?>" />
					</div>
					<script type="text/javascript">
					jQuery(document).ready(function ($) { // http://stackoverflow.com/a/10807237/1153897
						$(function () {
							$('#datetimepicker').datetimepicker({
								format: 'DD/MM/YYYY'
							});
						});
					});
					</script>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<div class="row">
				<div class="col-sm-3">
					<div class="form-group">
						<label>Minimum education level</label><br>
						<select name='education_level' required>
							<option selected disabled hidden style='display: none' value=''></option>
							<option value="some_college"
							<?php echo ($post_meta['education_level'] == 'life_sciences') ? 'selected' : null ?>
							>Some college coursework</option>
							<option value="BA_BS"
							<?php echo ($post_meta['education_level'] == 'BA_BS') ? 'selected' : null ?>
							>BA/BS</option>
							<option value="MS"
							<?php echo ($post_meta['education_level'] == 'MS') ? 'selected' : null ?>
							>MS</option>
							<option value="MBA"
							<?php echo ($post_meta['education_level'] == 'MBA') ? 'selected' : null ?>
							>MBA</option>
							<option value="JD"
							<?php echo ($post_meta['education_level'] == 'JD') ? 'selected' : null ?>
							>JD</option>
							<option value="MD"
							<?php echo ($post_meta['education_level'] == 'MD') ? 'selected' : null ?>
							>MD</option>
							<option value="PHD"
							<?php echo ($post_meta['education_level'] == 'PHD') ? 'selected' : null ?>
							>PhD</option>
						</select>
					</div>
				</div>
				<div class="col-sm-3">
					<div class="form-group">
						<label>Budget</label><br>
						<select name='budget' required>
							<option selected disabled hidden style='display: none' value=''></option>
							<option value="negotiable"
							<?php echo ($post_meta['budget'] == 'life_sciences') ? 'selected' : null ?>
							>Negotiable</option>
							<option value="0"
							<?php echo ($post_meta['budget'] == '0') ? 'selected' : null ?>
							>$0</option>
							<option value="100"
							<?php echo ($post_meta['budget'] == '100') ? 'selected' : null ?>
							>$100</option>
							<option value="200"
							<?php echo ($post_meta['budget'] == '200') ? 'selected' : null ?>
							>$200</option>
							<option value="300"
							<?php echo ($post_meta['budget'] == '300') ? 'selected' : null ?>
							>$300</option>
							<option value="400"
							<?php echo ($post_meta['budget'] == '400') ? 'selected' : null ?>
							>$400</option>
							<option value="500"
							<?php echo ($post_meta['budget'] == '500') ? 'selected' : null ?>
							>$500</option>
							<option value="750"
							<?php echo ($post_meta['budget'] == '750') ? 'selected' : null ?>
							>$750</option>
							<option value="1000"
							<?php echo ($post_meta['budget'] == '1000') ? 'selected' : null ?>
							>$1000</option>
							<option value="1500"
							<?php echo ($post_meta['budget'] == '1500') ? 'selected' : null ?>
							>$1500</option>
							<option value="2000"
							<?php echo ($post_meta['budget'] == '2000') ? 'selected' : null ?>
							>$2000</option>
							<option value="2000+"
							<?php echo ($post_meta['budget'] == '2000+') ? 'selected' : null ?>
							>$2000+</option>
						</select>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-12">
			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<label>Task depth</label><br>
                        <div class="radio">
                            <label>
                                <input type="radio" name="task_depth" id="task_depth1" value="depth1" <?php echo ($post_meta['task_depth'] == 'depth1') ? 'checked' : null ?> required>
                                <b>First pass</b> - Select this option for a quick and economical approach to a task. This is a good option if you need a high-level approach to a task and don't need fine details.
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="task_depth" id="task_depth2" value="depth2" <?php echo ($post_meta['task_depth'] == 'depth2') ? 'checked' : null ?> required>
                                <b>Intermediate<b> - Select this option for a task that needs more time and analysis but does not need an exhaustive search or approach.
                            </label>
                        </div>
                        <div class="radio disabled">
                            <label>
                                <input type="radio" name="task_depth" id="task_depth3" value="depth3" <?php echo ($post_meta['task_depth'] == 'depth3') ? 'checked' : null ?> required>
                                <b>Deep dive</b> - Select this option for tasks that need a thorough, detailed approach from someone with specific in the relevant field. These tasks should take longer and cost more, but this is a good option for thorough, detailed analyses.
                            </label>
                        </div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
} ?>


<?php function show_private_part($post_meta, $post_data) {
	?>
	<div class="row">
		<div class="col-sm-12">
			<div class="form-group">
				<label>Task decription</label>
				<textarea name="task_descrip" class="form-control" rows="3" required
				placeholder="Please enter a complete description of the task"
				><?php echo $post_data->post_content; ?></textarea>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-12">
			<div class="form-group">
				<label>Milestones/deliverables</label>
				<textarea name="task_milestones" class="form-control" rows="7" required
				placeholder="<? echo $milestone_ex; ?>"
				><?php echo $post_meta['task_milestones']; ?></textarea>
			</div>
		</div>
	</div>
	<?php
} ?>
