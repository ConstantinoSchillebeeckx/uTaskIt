<div class="row">
	<div class="col-sm-10 col-sm-offset-1">
		<form method="post" action="" autocomplete="off" id="user_form" name="user_form" enctype="multipart/form-data">

			<div class="row">
				<div class="col-sm-12">
					<div class="row">
						<div class="col-sm-4">
							<div class="form-group">
								<label>First name</label>
								<input class="form-control" type="text" name="first_name" placeholder="Jane"
								required value=<?php echo $user_meta['first_name']; ?> >
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label>Last name</label>
								<input class="form-control" type="text" name="last_name" placeholder="Doe"
								required value=<?php echo $user_meta['last_name']; ?> >
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label>Email</label>
								<input class="form-control" type="email" name="user_email" placeholder="jane.doe@gmail.com"
								required value=<?php echo $user_meta['user_email']; ?> >
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-9">
							<div class="form-group">
								<label>Bio</label>
								<textarea name="description" class="form-control" rows="3" required
								placeholder="Tell us a little bit about yourself."
								><?php echo $user_meta['description']; ?></textarea>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="form-group">
								<label>CV</label>
								<?php echo ($user_meta['cv'] != '') ? sprintf('<p><a class="btn btn-info btn-sm" href="%s">View current CV</a></p>', $user_meta['cv']) : null; ?>
								<input type="file" name="cv_upload" accept="application/pdf" title="Upload your CV in PDF format"
								<?php echo ($user_meta['cv'] != '') ? null : 'required' ;?>/>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label>Hourly compensation range?</label><br>
						<div>
							<select name="Qpay_value" required>
								<option selected disabled hidden style='display: none' value=''></option>
								<option value="0-25"
								<?php echo ($user_meta['Qpay_value'] == '0-25') ? 'selected' : null ?>
								>0-$25/hr</option>
								<option value="25-50"
								<?php echo ($user_meta['Qpay_value'] == '25-50') ? 'selected' : null ?>
								>$25/hr-$50/hr</option>
								<option value="50-75"
								<?php echo ($user_meta['Qpay_value'] == '50-75') ? 'selected' : null ?>
								>$50/hr-$75/hr</option>
								<option value="75-100"
								<?php echo ($user_meta['Qpay_value'] == '75-100') ? 'selected' : null ?>
								>$75/hr-$100/hr</option>
							</select>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-4">
					<div class="form-group">
						<label>What is your highest completed degree?</label><br>
						<select name='Qeducation'>
							<option selected disabled hidden style='display: none' value=''></option>
							<option value="high_school"
							<?php echo ($user_meta['Qeducation'] == 'high_school') ? 'selected' : null ?>
							>High school</option>
							<option value="bs"
							<?php echo ($user_meta['Qeducation'] == 'bs') ? 'selected' : null ?>
							>Bachelors</option>
							<option value="ms"
							<?php echo ($user_meta['Qeducation'] == 'ms') ? 'selected' : null ?>
							>Masters</option>
							<option value="phd"
							<?php echo ($user_meta['Qeducation'] == 'phd') ? 'selected' : null ?>
							>PhD</option>
						</select>
						<div class="conditional" data-cond-option="Qeducation" data-cond-value="bs" style="display: none;">
							<input type="text" name="Qdeducation_focus_bs" class="form-control" placeholder="Insert Bacherlors degree focus"
							required value='<?php echo $user_meta['Qdeducation_focus_bs'] ?>'>
						</div>
						<div class="conditional" data-cond-option="Qeducation" data-cond-value="ms" style="display: none;">
							<input type="text" name="Qeducation_focus_ms" class="form-control" placeholder="Insert Masters degree focus"
							required value='<?php echo $user_meta['Qeducation_focus_ms'] ?>'>
						</div>
						<div class="conditional" data-cond-option="Qeducation" data-cond-value="phd" style="display: none;">
							<input type="text" name="Qeducation_focus_phd" class="form-control" placeholder="Insert PhD focus"
							required value='<?php echo $user_meta['Qeducation_focus_phd'] ?>'>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<label>Are you currently working toward a degree?</label><br>
						<input type="radio" name="Qdegree" value="yes"
						<?php echo ($user_meta['Qdegree'] == 'yes') ? 'checked' : null ?>
						> yes<br>
						<input type="radio" name="Qdegree" value="no"
						<?php echo ($user_meta['Qdegree'] == 'no') ? 'checked' : null ?>
						> no<br>
						<div class="conditional" data-cond-option="Qdegree" data-cond-value="yes" style="display: none;">
							<input type="text" name="Qdegree_focus" class="form-control" placeholder="Which degree are you working toward?"
							required value='<?php echo $user_meta['Qdegree_focus'] ?>'>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<label>Choose a primary and secondary focus area from the dropdowns</label><br>
						<div class="row">
							<div class="col-sm-6">
								<span>Primary focus </span>
								<select name='Qprimary_focus' required>
									<option selected disabled hidden style='display: none' value=''></option>
									<option value="life_science"
									<?php echo ($user_meta['Qprimary_focus'] == 'life_science') ? 'selected' : null ?>
									>Life Sciences</option>
									<option value="other_science"
									<?php echo ($user_meta['Qprimary_focus'] == 'other_science') ? 'selected' : null ?>
									>Other Sciences</option>
									<option value="web_design"
									<?php echo ($user_meta['Qprimary_focus'] == 'web_design') ? 'selected' : null ?>
									>Web Design</option>
									<option value="computer_programming"
									<?php echo ($user_meta['Qprimary_focus'] == 'computer_programming') ? 'selected' : null ?>
									>Computer Programming</option>
									<option value="marketing"
									<?php echo ($user_meta['Qprimary_focus'] == 'marketing') ? 'selected' : null ?>
									>Marketing</option>
									<option value="patent_law"
									<?php echo ($user_meta['Qprimary_focus'] == 'patent_law') ? 'selected' : null ?>
									>Patent Law</option>
									<option value="other_law"
									<?php echo ($user_meta['Qprimary_focus'] == 'other_law') ? 'selected' : null ?>
									>Other Law</option>
									<option value="marketing"
									<?php echo ($user_meta['Qprimary_focus'] == 'marketing') ? 'selected' : null ?>
									>Marketing</option>
									<option value="communications"
									<?php echo ($user_meta['Qprimary_focus'] == 'communications') ? 'selected' : null ?>
									>Communications</option>
									<option value="business"
									<?php echo ($user_meta['Qprimary_focus'] == 'business') ? 'selected' : null ?>
									>Business</option>
									<option value="human_resources"
									<?php echo ($user_meta['Qprimary_focus'] == 'human_resources') ? 'selected' : null ?>
									>Human Resources</option>
									<option value="other"
									<?php echo ($user_meta['Qprimary_focus'] == 'other') ? 'selected' : null ?>
									>Other</option>
								</select>
							</div>
							<div class="col-sm-6">
								<span>Secondary focus </span>
								<select name='Qsecondary_focus' required>
									<option selected disabled hidden style='display: none' value=''></option>
									<option value="life_science"
									<?php echo ($user_meta['Qsecondary_focus'] == 'life_science') ? 'selected' : null ?>
									>Life Sciences</option>
									<option value="other_science"
									<?php echo ($user_meta['Qsecondary_focus'] == 'other_science') ? 'selected' : null ?>
									>Other Sciences</option>
									<option value="web_design"
									<?php echo ($user_meta['Qsecondary_focus'] == 'web_design') ? 'selected' : null ?>
									>Web Design</option>
									<option value="computer_programming"
									<?php echo ($user_meta['Qsecondary_focus'] == 'computer_programming') ? 'selected' : null ?>
									>Computer Programming</option>
									<option value="marketing"
									<?php echo ($user_meta['Qsecondary_focus'] == 'marketing') ? 'selected' : null ?>
									>Marketing</option>
									<option value="patent_law"
									<?php echo ($user_meta['Qsecondary_focus'] == 'patent_law') ? 'selected' : null ?>
									>Patent Law</option>
									<option value="other_law"
									<?php echo ($user_meta['Qsecondary_focus'] == 'other_law') ? 'selected' : null ?>
									>Other Law</option>
									<option value="marketing"
									<?php echo ($user_meta['Qsecondary_focus'] == 'marketing') ? 'selected' : null ?>
									>Marketing</option>
									<option value="communications"
									<?php echo ($user_meta['Qsecondary_focus'] == 'communications') ? 'selected' : null ?>
									>Communications</option>
									<option value="business"
									<?php echo ($user_meta['Qsecondary_focus'] == 'business') ? 'selected' : null ?>
									>Business</option>
									<option value="human_resources"
									<?php echo ($user_meta['Qsecondary_focus'] == 'human_resources') ? 'selected' : null ?>
									>Human Resources</option>
									<option value="other"
									<?php echo ($user_meta['Qsecondary_focus'] == 'other') ? 'selected' : null ?>
									>Other</option>
								</select>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<label>A focus area you’d like more experience in, if any:</label><br>
						<input type="radio" name="Qmore_experience" value="yes" required
						<?php echo ($user_meta['Qmore_experience'] == 'yes') ? 'checked' : null ?>
						> yes</input><br>
						<input type="radio" name="Qmore_experience" value="no"
						<?php echo ($user_meta['Qmore_experience'] == 'no') ? 'checked' : null ?>
						> no</input><br>
						<div class="conditional" data-cond-option="Qmore_experience" data-cond-value="yes" style="display: none;">
								<select name='Qmore_experience_focus' required>
									<option selected disabled hidden style='display: none' value=''></option>
									<option value="life_science"
									<?php echo ($user_meta['Qsecondary_focus'] == 'life_science') ? 'selected' : null ?>
									>Life Sciences</option>
									<option value="finance"
									<?php echo ($user_meta['Qsecondary_focus'] == 'finance') ? 'selected' : null ?>
									>Finance</option>
									<option value="computer_science"
									<?php echo ($user_meta['Qsecondary_focus'] == 'computer_science') ? 'selected' : null ?>
									>Computer Science</option>
									<option value="law"
									<?php echo ($user_meta['Qsecondary_focus'] == 'law') ? 'selected' : null ?>
									>Law</option>
									<option value="marketing"
									<?php echo ($user_meta['Qsecondary_focus'] == 'marketing') ? 'selected' : null ?>
									>Marketing</option>
									<option value="communications"
									<?php echo ($user_meta['Qsecondary_focus'] == 'communications') ? 'selected' : null ?>
									>Communications</option>
								</select>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<label>List your primary skills that apply from the list below and rate your proficiency in each</label><br>
						<div class="row">
							<div class="col-sm-2">
								<label>Skill</label>
							</div>
							<div class="col-sm-2">
								<label>Limited exposure</label>
							</div>
							<div class="col-sm-2">
								<label>Beginner</label>
							</div>
							<div class="col-sm-2">
								<label>Moderately experienced</label>
							</div>
							<div class="col-sm-2">
								<label>Very experienced</label>
							</div>
							<div class="col-sm-2">
								<label>Expert</label>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-2">
								Market Research
							</div>
							<div class="col-sm-2">
								<input type="radio" name="Qskill_market_research" value="limited" required
								<?php echo ($user_meta['Qskill_market_research'] == 'limited') ? 'checked' : null ?>
								>
							</div>
							<div class="col-sm-2">
								<input type="radio" name="Qskill_market_research" value="beginner"
								<?php echo ($user_meta['Qskill_market_research'] == 'beginner') ? 'checked' : null ?>
								>
							</div>
							<div class="col-sm-2">
								<input type="radio" name="Qskill_market_research" value="moderate"
								<?php echo ($user_meta['Qskill_market_research'] == 'moderate') ? 'checked' : null ?>
								>
							</div>
							<div class="col-sm-2">
								<input type="radio" name="Qskill_market_research" value="experienced"
								<?php echo ($user_meta['Qskill_market_research'] == 'experienced') ? 'checked' : null ?>
								>
							</div>
							<div class="col-sm-2">
								<input type="radio" name="Qskill_market_research" value="expert"
								<?php echo ($user_meta['Qskill_market_research'] == 'expert') ? 'checked' : null ?>
								>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-2">
								Competitive analysis
							</div>
							<div class="col-sm-2">
								<input type="radio" name="Qskill_comp_analysis" value="limited" required
								<?php echo ($user_meta['Qskill_comp_analysis'] == 'limited') ? 'checked' : null ?>
								>
							</div>
							<div class="col-sm-2">
								<input type="radio" name="Qskill_comp_analysis" value="beginner"
								<?php echo ($user_meta['Qskill_comp_analysis'] == 'beginner') ? 'checked' : null ?>
								>
							</div>
							<div class="col-sm-2">
								<input type="radio" name="Qskill_comp_analysis" value="moderate"
								<?php echo ($user_meta['Qskill_comp_analysis'] == 'moderate') ? 'checked' : null ?>
								>
							</div>
							<div class="col-sm-2">
								<input type="radio" name="Qskill_comp_analysis" value="experienced"
								<?php echo ($user_meta['Qskill_comp_analysis'] == 'experienced') ? 'checked' : null ?>
								>
							</div>
							<div class="col-sm-2">
								<input type="radio" name="Qskill_comp_analysis" value="expert"
								<?php echo ($user_meta['Qskill_comp_analysis'] == 'expert') ? 'checked' : null ?>
								>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-2">
								Patent law
							</div>
							<div class="col-sm-2">
								<input type="radio" name="Qskill_patent_law" value="limited" required
								<?php echo ($user_meta['Qskill_patent_law'] == 'limited') ? 'checked' : null ?>
								>
							</div>
							<div class="col-sm-2">
								<input type="radio" name="Qskill_patent_law" value="beginner"
								<?php echo ($user_meta['Qskill_patent_law'] == 'beginner') ? 'checked' : null ?>
								>
							</div>
							<div class="col-sm-2">
								<input type="radio" name="Qskill_patent_law" value="moderate"
								<?php echo ($user_meta['Qskill_patent_law'] == 'moderate') ? 'checked' : null ?>
								>
							</div>
							<div class="col-sm-2">
								<input type="radio" name="Qskill_patent_law" value="experienced"
								<?php echo ($user_meta['Qskill_patent_law'] == 'experienced') ? 'checked' : null ?>
								>
							</div>
							<div class="col-sm-2">
								<input type="radio" name="Qskill_patent_law" value="expert"
								<?php echo ($user_meta['Qskill_patent_law'] == 'expert') ? 'checked' : null ?>
								>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-2">
								Technology due diligence
							</div>
							<div class="col-sm-2">
								<input type="radio" name="Qskill_tech_due_dilig" value="limited" required
								<?php echo ($user_meta['Qskill_tech_due_dilig'] == 'limited') ? 'checked' : null ?>
								>
							</div>
							<div class="col-sm-2">
								<input type="radio" name="Qskill_tech_due_dilig" value="beginner"
								<?php echo ($user_meta['Qskill_tech_due_dilig'] == 'beginner') ? 'checked' : null ?>
								>
							</div>
							<div class="col-sm-2">
								<input type="radio" name="Qskill_tech_due_dilig" value="moderate"
								<?php echo ($user_meta['Qskill_tech_due_dilig'] == 'moderate') ? 'checked' : null ?>
								>
							</div>
							<div class="col-sm-2">
								<input type="radio" name="Qskill_tech_due_dilig" value="experienced"
								<?php echo ($user_meta['Qskill_tech_due_dilig'] == 'experienced') ? 'checked' : null ?>
								>
							</div>
							<div class="col-sm-2">
								<input type="radio" name="Qskill_tech_due_dilig" value="expert"
								<?php echo ($user_meta['Qskill_tech_due_dilig'] == 'expert') ? 'checked' : null ?>
								>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-2">
								Customer feedback
							</div>
							<div class="col-sm-2">
								<input type="radio" name="Qskill_customer_feedback" value="limited" required
								<?php echo ($user_meta['Qskill_customer_feedback'] == 'limited') ? 'checked' : null ?>
								>
							</div>
							<div class="col-sm-2">
								<input type="radio" name="Qskill_customer_feedback" value="beginner"
								<?php echo ($user_meta['Qskill_customer_feedback'] == 'beginner') ? 'checked' : null ?>
								>
							</div>
							<div class="col-sm-2">
								<input type="radio" name="Qskill_customer_feedback" value="moderate"
								<?php echo ($user_meta['Qskill_customer_feedback'] == 'moderate') ? 'checked' : null ?>
								>
							</div>
							<div class="col-sm-2">
								<input type="radio" name="Qskill_customer_feedback" value="experienced"
								<?php echo ($user_meta['Qskill_customer_feedback'] == 'experienced') ? 'checked' : null ?>
								>
							</div>
							<div class="col-sm-2">
								<input type="radio" name="Qskill_customer_feedback" value="expert"
								<?php echo ($user_meta['Qskill_customer_feedback'] == 'expert') ? 'checked' : null ?>
								>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-2">
								Regulatory due diligence
							</div>
							<div class="col-sm-2">
								<input type="radio" name="Qskill_reg_due_diligence" value="limited" required
								<?php echo ($user_meta['Qskill_reg_due_diligence'] == 'limited') ? 'checked' : null ?>
								>
							</div>
							<div class="col-sm-2">
								<input type="radio" name="Qskill_reg_due_diligence" value="beginner"
								<?php echo ($user_meta['Qskill_reg_due_diligence'] == 'beginner') ? 'checked' : null ?>
								>
							</div>
							<div class="col-sm-2">
								<input type="radio" name="Qskill_reg_due_diligence" value="moderate"
								<?php echo ($user_meta['Qskill_reg_due_diligence'] == 'moderate') ? 'checked' : null ?>
								>
							</div>
							<div class="col-sm-2">
								<input type="radio" name="Qskill_reg_due_diligence" value="experienced"
								<?php echo ($user_meta['Qskill_reg_due_diligence'] == 'experienced') ? 'checked' : null ?>
								>
							</div>
							<div class="col-sm-2">
								<input type="radio" name="Qskill_reg_due_diligence" value="expert"
								<?php echo ($user_meta['Qskill_reg_due_diligence'] == 'expert') ? 'checked' : null ?>
								>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-2">
								Financial modeling
							</div>
							<div class="col-sm-2">
								<input type="radio" name="Qskill_financial_modeling" value="limited" required
								<?php echo ($user_meta['Qskill_financial_modeling'] == 'limited') ? 'checked' : null ?>
								>
							</div>
							<div class="col-sm-2">
								<input type="radio" name="Qskill_financial_modeling" value="beginner"
								<?php echo ($user_meta['Qskill_financial_modeling'] == 'beginner') ? 'checked' : null ?>
								>
							</div>
							<div class="col-sm-2">
								<input type="radio" name="Qskill_financial_modeling" value="moderate"
								<?php echo ($user_meta['Qskill_financial_modeling'] == 'moderate') ? 'checked' : null ?>
								>
							</div>
							<div class="col-sm-2">
								<input type="radio" name="Qskill_financial_modeling" value="experienced"
								<?php echo ($user_meta['Qskill_financial_modeling'] == 'experienced') ? 'checked' : null ?>
								>
							</div>
							<div class="col-sm-2">
								<input type="radio" name="Qskill_financial_modeling" value="expert"
								<?php echo ($user_meta['Qskill_financial_modeling'] == 'expert') ? 'checked' : null ?>
								>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-2">
								Comparable exit analysis
							</div>
							<div class="col-sm-2">
								<input type="radio" name="Qskill_exit_analysis" value="limited" required
								<?php echo ($user_meta['Qskill_exit_analysis'] == 'limited') ? 'checked' : null ?>
								>
							</div>
							<div class="col-sm-2">
								<input type="radio" name="Qskill_exit_analysis" value="beginner"
								<?php echo ($user_meta['Qskill_exit_analysis'] == 'beginner') ? 'checked' : null ?>
								>
							</div>
							<div class="col-sm-2">
								<input type="radio" name="Qskill_exit_analysis" value="moderate"
								<?php echo ($user_meta['Qskill_exit_analysis'] == 'moderate') ? 'checked' : null ?>
								>
							</div>
							<div class="col-sm-2">
								<input type="radio" name="Qskill_exit_analysis" value="experienced"
								<?php echo ($user_meta['Qskill_exit_analysis'] == 'experienced') ? 'checked' : null ?>
								>
							</div>
							<div class="col-sm-2">
								<input type="radio" name="Qskill_exit_analysis" value="expert"
								<?php echo ($user_meta['Qskill_exit_analysis'] == 'expert') ? 'checked' : null ?>
								>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-2">
								Research & Development planning
							</div>
							<div class="col-sm-2">
								<input type="radio" name="Qskill_r_d_planning" value="limited" required
								<?php echo ($user_meta['Qskill_r_d_planning'] == 'limited') ? 'checked' : null ?>
								>
							</div>
							<div class="col-sm-2">
								<input type="radio" name="Qskill_r_d_planning" value="beginner"
								<?php echo ($user_meta['Qskill_r_d_planning'] == 'beginner') ? 'checked' : null ?>
								>
							</div>
							<div class="col-sm-2">
								<input type="radio" name="Qskill_r_d_planning" value="moderate"
								<?php echo ($user_meta['Qskill_r_d_planning'] == 'moderate') ? 'checked' : null ?>
								>
							</div>
							<div class="col-sm-2">
								<input type="radio" name="Qskill_r_d_planning" value="experienced"
								<?php echo ($user_meta['Qskill_r_d_planning'] == 'experienced') ? 'checked' : null ?>
								>
							</div>
							<div class="col-sm-2">
								<input type="radio" name="Qskill_r_d_planning" value="expert"
								<?php echo ($user_meta['Qskill_r_d_planning'] == 'expert') ? 'checked' : null ?>
								>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-2">
								Website development
							</div>
							<div class="col-sm-2">
								<input type="radio" name="Qskill_web_dev" value="limited" required
								<?php echo ($user_meta['Qskill_web_dev'] == 'limited') ? 'checked' : null ?>
								>
							</div>
							<div class="col-sm-2">
								<input type="radio" name="Qskill_web_dev" value="beginner"
								<?php echo ($user_meta['Qskill_web_dev'] == 'beginner') ? 'checked' : null ?>
								>
							</div>
							<div class="col-sm-2">
								<input type="radio" name="Qskill_web_dev" value="moderate"
								<?php echo ($user_meta['Qskill_web_dev'] == 'moderate') ? 'checked' : null ?>
								>
							</div>
							<div class="col-sm-2">
								<input type="radio" name="Qskill_web_dev" value="experienced"
								<?php echo ($user_meta['Qskill_web_dev'] == 'experienced') ? 'checked' : null ?>
								>
							</div>
							<div class="col-sm-2">
								<input type="radio" name="Qskill_web_dev" value="expert"
								<?php echo ($user_meta['Qskill_web_dev'] == 'expert') ? 'checked' : null ?>
								>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-2">
								Marketing plans
							</div>
							<div class="col-sm-2">
								<input type="radio" name="Qskill_marketing" value="limited" required
								<?php echo ($user_meta['Qskill_marketing'] == 'limited') ? 'checked' : null ?>
								>
							</div>
							<div class="col-sm-2">
								<input type="radio" name="Qskill_marketing" value="beginner"
								<?php echo ($user_meta['Qskill_marketing'] == 'beginner') ? 'checked' : null ?>
								>
							</div>
							<div class="col-sm-2">
								<input type="radio" name="Qskill_marketing" value="moderate"
								<?php echo ($user_meta['Qskill_marketing'] == 'moderate') ? 'checked' : null ?>
								>
							</div>
							<div class="col-sm-2">
								<input type="radio" name="Qskill_marketing" value="experienced"
								<?php echo ($user_meta['Qskill_marketing'] == 'experienced') ? 'checked' : null ?>
								>
							</div>
							<div class="col-sm-2">
								<input type="radio" name="Qskill_marketing" value="expert"
								<?php echo ($user_meta['Qskill_marketing'] == 'expert') ? 'checked' : null ?>
								>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-2">
								Human resources
							</div>
							<div class="col-sm-2">
								<input type="radio" name="Qskill_human_resources" value="limited" required
								<?php echo ($user_meta['Qskill_human_resources'] == 'limited') ? 'checked' : null ?>
								>
							</div>
							<div class="col-sm-2">
								<input type="radio" name="Qskill_human_resources" value="beginner"
								<?php echo ($user_meta['Qskill_human_resources'] == 'beginner') ? 'checked' : null ?>
								>
							</div>
							<div class="col-sm-2">
								<input type="radio" name="Qskill_human_resources" value="moderate"
								<?php echo ($user_meta['Qskill_human_resources'] == 'moderate') ? 'checked' : null ?>
								>
							</div>
							<div class="col-sm-2">
								<input type="radio" name="Qskill_human_resources" value="experienced"
								<?php echo ($user_meta['Qskill_human_resources'] == 'experienced') ? 'checked' : null ?>
								>
							</div>
							<div class="col-sm-2">
								<input type="radio" name="Qskill_human_resources" value="expert"
								<?php echo ($user_meta['Qskill_human_resources'] == 'expert') ? 'checked' : null ?>
								>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-2">
								Communications
							</div>
							<div class="col-sm-2">
								<input type="radio" name="Qskill_communications" value="limited" required
								<?php echo ($user_meta['Qskill_communications'] == 'limited') ? 'checked' : null ?>
								>
							</div>
							<div class="col-sm-2">
								<input type="radio" name="Qskill_communications" value="beginner"
								<?php echo ($user_meta['Qskill_communications'] == 'beginner') ? 'checked' : null ?>
								>
							</div>
							<div class="col-sm-2">
								<input type="radio" name="Qskill_communications" value="moderate"
								<?php echo ($user_meta['Qskill_communications'] == 'moderate') ? 'checked' : null ?>
								>
							</div>
							<div class="col-sm-2">
								<input type="radio" name="Qskill_communications" value="experienced"
								<?php echo ($user_meta['Qskill_communications'] == 'experienced') ? 'checked' : null ?>
								>
							</div>
							<div class="col-sm-2">
								<input type="radio" name="Qskill_communications" value="expert"
								<?php echo ($user_meta['Qskill_communications'] == 'expert') ? 'checked' : null ?>
								>
							</div>
						</div>
					</div>
				</div>
			</div>


			<div class="row">
				<div class="col-sm-4">
					<div class="form-group">
						<label>Please enter the zipcode of your current location</label>
						<input type="text" name="Qzipcode" class="form-control" pattern="[0-9]{5}" placeholder="Zipcode (e.g. 63108)" required
						title="5 digit zipcode" value='<?php echo $user_meta['Qzipcode'] ?>'
						>
					</div>
				</div>
			</div>


			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<label>Please give a general idea of your availability over the next 3 months (Utaskit will automatically ask you to update this information every 3 months using the email address you have provided)</label><br>
						<select name='Qavailability' required>
							<option selected disabled hidden style='display: none' value=''></option>
							<option value="none"
							<?php echo ($user_meta['Qavailability'] == 'none') ? 'selected' : null ?>
							>no availability</option>
							<option value="1-5"
							<?php echo ($user_meta['Qavailability'] == '1-5') ? 'selected' : null ?>
							>1-5 hrs/week</option>
							<option value="5-10"
							<?php echo ($user_meta['Qavailability'] == '5-10') ? 'selected' : null ?>
							>5-10 hrs/week</option>
							<option value="10-15"
							<?php echo ($user_meta['Qavailability'] == '10-15') ? 'selected' : null ?>
							>10-15 hrs/week</option>
							<option value="15-20"
							<?php echo ($user_meta['Qavailability'] == '15-20') ? 'selected' : null ?>
							>15-20 hrs/week</option>
							<option value="20+"
							<?php echo ($user_meta['Qavailability'] == '20+') ? 'selected' : null ?>
							>20+ hrs/week</option>
						</select><br><br>
						<textarea name="Qavailability_notes" class="form-control" rows="3" placeholder="Availability notes"
						><?php echo $user_meta['Qavailability_notes']; ?></textarea>
					</div>
				</div>
			</div>
			<?php
			yti_list_applications( $current_user->ID );
			if ($user_id === null) {
				echo '<button type="submit" name="action" value="submit_user" class="btn btn-primary pull-right">Edit profile</button>';
			} else if ( $user_id != $current_user->ID ) { ?>
				<div class="row" id="contact_user_div" >
					<hr>
					<div class="col-sm-12">
						<p>If you'd like to contact <?php echo $user_meta['first_name']; ?> with a potential task offer, please fill out the text area below with your message.</p>
						<div class="form-group">
							<textarea class="form-control" name="contact_user_text" id="contact_user_text" rows="5"
							placeholder="<?php echo 'Type your message for ' . $user_meta['first_name'] . ' here'; ?>" ></textarea>
						</div>
					</div>
				</div>
				<div class="row" id="contact_user_div" style="margin-bottom:15px;">
					<div class="col-sm-2">
						<button name="action" value="contact_user" class="btn btn-primary">Contact user</button>
					</div>
				</div>
			<?php } ?>
		</form>
	</div>
</div>
