<?php
if(!function_exists('opaljob_ajax_get_import_demo')) :
	function opaljob_ajax_get_import_demo() {

		$arg_taxonomy = array(
			array(
			'term' 		=> 'California',
			'taxonomy' 	=> 'opaljob_location',
			'slug' 		=> 'california',
			),
			array(
			'term' 		=> 'Ha Noi',
			'taxonomy' 	=> 'opaljob_location',
			'slug' 		=> 'ha-noi',
			),
			array(
			'term' 		=> 'London',
			'taxonomy' 	=> 'opaljob_location',
			'slug' 		=> 'london',
			),
			array(
			'term' 		=> 'New York',
			'taxonomy' 	=> 'opaljob_location',
			'slug' 		=> 'new-york',
			),
			array(
			'term' 		=> 'Designer',
			'taxonomy' 	=> 'work_category',
			'slug' 		=> 'designer',
			),
			array(
			'term' 		=> 'Developer',
			'taxonomy' 	=> 'work_category',
			'slug' 		=> 'developer',
			),
			array(
			'term' 		=> 'Maketing',
			'taxonomy' 	=> 'work_category',
			'slug' 		=> 'maketing',
			),
			array(
			'term' 		=> 'Other',
			'taxonomy' 	=> 'work_category',
			'slug' 		=> 'other',
			),
			array(
			'term' 		=> 'Contract',
			'taxonomy' 	=> 'opaljob_types',
			'slug' 		=> 'contract',
			),
			array(
			'term' 		=> 'Full Time',
			'taxonomy' 	=> 'opaljob_types',
			'slug' 		=> 'full-time',
			),
			array(
			'term' 		=> 'Freelancer',
			'taxonomy' 	=> 'opaljob_types',
			'slug' 		=> 'freelance',
			),
			array(
			'term' 		=> 'Part Time',
			'taxonomy' 	=> 'opaljob_types',
			'slug' 		=> 'part-time',
			),
			array(
			'term' 		=> 'Php',
			'taxonomy' 	=> 'opaljob_tags',
			'slug' 		=> 'php',
			),
			array(
			'term' 		=> 'Java',
			'taxonomy' 	=> 'opaljob_tags',
			'slug' 		=> 'java',
			),
			array(
			'term' 		=> 'Android',
			'taxonomy' 	=> 'opaljob_tags',
			'slug' 		=> 'android',
			),
			array(
			'term' 		=> 'Ios',
			'taxonomy' 	=> 'opaljob_tags',
			'slug' 		=> 'ios',
			),
		);

		foreach ($arg_taxonomy  as $key => $taxonomy) {
			wp_insert_term(
			    $taxonomy["term"],   // the term 
			    $taxonomy["taxonomy"], // the taxonomy
			    array(
			        'slug'        => $taxonomy["slug"],
			    )
			);
		}

		$arg_company = array(
			array(
				'post_type'		=>'opaljob_company',
				'post_author' 	=> 1,
				'post_title'	=> 'Boostrap Freelancer Edit',
				'post_content' 	=> 'Boostrap Freelancer',
				'post_status'   => 'publish',
				'meta'		=> array(
					'avatar'	=> OPALJOB_PLUGIN_URL . '/assets/images/logo-company.png',
					'email'		=> 'demo@demo.com',
					'phone'		=> '0987654321',
					'mobile'	=> '09876543421',
					'fax'		=> '0987654321',
					'website'	=> 'wpopal.com',
					'address'	=> 'Tokyo - Japan',
					'facebook'	=> 'wpopal.com',
					'twitter'	=> 'wpopal.com',
					'google'	=> 'wpopal.com',
					'map'		=> '53.338989578861046,-6.296797164306668,13',
				),
			),
			array(
				'post_type'		=>'opaljob_company',
				'post_author' 	=> 1,
				'post_title'	=> 'BMW of North America',
				'post_content' 	=> 'BMW is headquartered in Munich, Bavaria. It also owns and produces Mini cars, and is the parent company of Rolls-Royce Motor Cars. BMW produces motorcycles under BMW Motorrad. In 2012, the BMW Group produced 1,845,186 automobiles and 117,109 motorcycles across all of its brands. BMW is part of the "German Big 3" luxury automakers, along with Audi and Mercedes-Benz, which are the three best-selling luxury automakers in the world.',
				'post_status'   => 'publish',
				'meta'		=> array(
					'avatar'	=> OPALJOB_PLUGIN_URL . 'assets/images/logo-company.png',
					'email'		=> 'demo@demo.com',
					'phone'		=> '0987654321',
					'mobile'	=> '09876543421',
					'fax'		=> '0987654321',
					'web'		=> 'wpopal.com',
					'address'	=> 'Tokyo - Japan',
					'facebook'	=> 'wpopal.com',
					'twitter'	=> 'wpopal.com',
					'google'	=> 'wpopal.com',
					'map'		=> '53,-6.,13',
					'user_meta_id' => 1,
				),
			),
		);
		$company_id = array();
		foreach ($arg_company as $key => $company) {
			$args = array(
				'post_type' 	=> 'opaljob_company',
				'post_author'	=> 1,
				'post_status'	=> 'publish',
				'post_title'	=> $company["post_title"],
				'post_content'	=> $company["post_content"],
			);
			$insert = wp_insert_post($args,true);
			if($insert ) {
				$company_id[] = $insert;
				foreach ($company["meta"] as $key => $meta) {
					opaljob_update_post($insert, OPALJOB_COMPANY_PREFIX . $key,$meta);
				}
			}else {
				$return = array( 'status' => 'danger', 'message' => __( 'Error import taxonomy', 'opaljob' ) );
				echo json_encode($return); die();
			}
		}
		// add work	
		$arg_work = array(
			array(
				'post_type'		=>'opaljob_work',
				'post_author' 	=> 1,
				'post_title'	=> 'Advertising Coordinator',
				'post_content' 	=> '<h3>Job Description</h3>
					Curabitur non nulla sit amet nisl tempus convallis quis ac lectus. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Praesent sapien massa, convallis a pellentesque nec, egestas non nisi. Curabitur aliquet quam id dui posuere blandit. Nulla porttitor accumsan tincidunt.

					Donec rutrum congue leo eget malesuada. Pellentesque in ipsum id orci porta dapibus. Donec sollicitudin molestie malesuada. Vivamus magna justo, lacinia eget consectetur sed, convallis at tellus. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
					<h3>Benefits</h3>
					<ul>
						<li>Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui. Sed porttitor lectus nibh. Pellentesque in ipsum id orci porta dapibus.</li>
						<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla porttitor accumsan tincidunt. Cras ultricies ligula sed magna dictum porta.</li>
						<li>Curabitur arcu erat, accumsan id imperdiet et, porttitor at sem. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae.</li>
						<li>Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula.</li>
					</ul>
					<h3>Job Requirements</h3>
					<ol>
						<li>Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui. Sed porttitor lectus nibh. Pellentesque in ipsum id orci porta dapibus.</li>
						<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla porttitor accumsan tincidunt. Cras ultricies ligula sed magna dictum porta.</li>
						<li>Curabitur arcu erat, accumsan id imperdiet et, porttitor at sem. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae.</li>
						<li>Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula.</li>
					</ol>
					<h3>How To Apply</h3>
					Praesent sapien massa, convallis a pellentesque nec, egestas non nisi. Curabitur aliquet quam id dui posuere blandit. Curabitur aliquet quam id dui posuere blandit. Curabitur non nulla sit amet nisl tempus convallis quis ac lectus. Proin eget tortor risus. Sed porttitor lectus nibh at hr@techcrunch.com. Curabitur non nulla sit amet nisl tempus convallis quis ac lectus. Cras ultricies ligula sed magna dictum porta. Proin eget tortor risus. Nulla quis lorem ut libero malesuada feugiat.',
				'post_status'   => 'publish',
				'meta'		=> array(
					'gallery'	=> OPALJOB_PLUGIN_URL . 'assets/images/logo-company.png',
					'featured'	=> 'on',
					'expires'	=> '09/30/2018',
					'address'	=> 'Tokyo - Japan',
					'salary'	=> '1000',
					'salarylabel'=> 'month',
					'map'		=> '53.338989578861046,-6.296797164306668,13',
					'company'	=> $company_id[array_rand($company_id)],
				),
				'category'		=> array(
					'opaljob_location' 	=> array('New York'),
					'work_category'		=> array('Developer','Other'),
					'opaljob_types'		=> array('Full TIme','Freelancer'),
					'opaljob_tags'		=> array('Php','Java'),
				),
			),
			array(
				'post_type'		=>'opaljob_work',
				'post_author' 	=> 1,
				'post_title'	=> 'Web Designer',
				'post_content' 	=> '<h3>Job Description</h3>
					Curabitur non nulla sit amet nisl tempus convallis quis ac lectus. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Praesent sapien massa, convallis a pellentesque nec, egestas non nisi. Curabitur aliquet quam id dui posuere blandit. Nulla porttitor accumsan tincidunt.

					Donec rutrum congue leo eget malesuada. Pellentesque in ipsum id orci porta dapibus. Donec sollicitudin molestie malesuada. Vivamus magna justo, lacinia eget consectetur sed, convallis at tellus. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
					<h3>Benefits</h3>
					<ul>
						<li>Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui. Sed porttitor lectus nibh. Pellentesque in ipsum id orci porta dapibus.</li>
						<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla porttitor accumsan tincidunt. Cras ultricies ligula sed magna dictum porta.</li>
						<li>Curabitur arcu erat, accumsan id imperdiet et, porttitor at sem. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae.</li>
						<li>Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula.</li>
					</ul>
					<h3>Job Requirements</h3>
					<ol>
						<li>Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui. Sed porttitor lectus nibh. Pellentesque in ipsum id orci porta dapibus.</li>
						<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla porttitor accumsan tincidunt. Cras ultricies ligula sed magna dictum porta.</li>
						<li>Curabitur arcu erat, accumsan id imperdiet et, porttitor at sem. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae.</li>
						<li>Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula.</li>
					</ol>
					<h3>How To Apply</h3>
					Praesent sapien massa, convallis a pellentesque nec, egestas non nisi. Curabitur aliquet quam id dui posuere blandit. Curabitur aliquet quam id dui posuere blandit. Curabitur non nulla sit amet nisl tempus convallis quis ac lectus. Proin eget tortor risus. Sed porttitor lectus nibh at hr@techcrunch.com. Curabitur non nulla sit amet nisl tempus convallis quis ac lectus. Cras ultricies ligula sed magna dictum porta. Proin eget tortor risus. Nulla quis lorem ut libero malesuada feugiat.',
				'post_status'   => 'publish',
				'meta'		=> array(
					'gallery'	=> OPALJOB_PLUGIN_URL . 'assets/images/logo-company.png',
					'featured'	=> 'on',
					'expires'	=> '09/30/2018',
					'address'	=> 'Lon Don - England',
					'salary'	=> '2000',
					'salarylabel'=> 'month',
					'map'		=> '54.338989578861046,-6.296797164306668,13',
					'company'	=> $company_id[array_rand($company_id)],
				),
				'category'		=> array(
					'opaljob_location' 	=> array('London'),
					'work_category'		=> array('Designer','Other'),
					'opaljob_types'		=> array('Full TIme','Part Time'),
					'opaljob_tags'		=> array('Php','Java','Ios','Android'),
				),
			),
			array(
				'post_type'		=>'opaljob_work',
				'post_author' 	=> 1,
				'post_title'	=> 'Product Designer',
				'post_content' 	=> '<h3>Job Description</h3>
					Curabitur non nulla sit amet nisl tempus convallis quis ac lectus. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Praesent sapien massa, convallis a pellentesque nec, egestas non nisi. Curabitur aliquet quam id dui posuere blandit. Nulla porttitor accumsan tincidunt.

					Donec rutrum congue leo eget malesuada. Pellentesque in ipsum id orci porta dapibus. Donec sollicitudin molestie malesuada. Vivamus magna justo, lacinia eget consectetur sed, convallis at tellus. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
					<h3>Benefits</h3>
					<ul>
						<li>Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui. Sed porttitor lectus nibh. Pellentesque in ipsum id orci porta dapibus.</li>
						<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla porttitor accumsan tincidunt. Cras ultricies ligula sed magna dictum porta.</li>
						<li>Curabitur arcu erat, accumsan id imperdiet et, porttitor at sem. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae.</li>
						<li>Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula.</li>
					</ul>
					<h3>Job Requirements</h3>
					<ol>
						<li>Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui. Sed porttitor lectus nibh. Pellentesque in ipsum id orci porta dapibus.</li>
						<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla porttitor accumsan tincidunt. Cras ultricies ligula sed magna dictum porta.</li>
						<li>Curabitur arcu erat, accumsan id imperdiet et, porttitor at sem. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae.</li>
						<li>Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula.</li>
					</ol>
					<h3>How To Apply</h3>
					Praesent sapien massa, convallis a pellentesque nec, egestas non nisi. Curabitur aliquet quam id dui posuere blandit. Curabitur aliquet quam id dui posuere blandit. Curabitur non nulla sit amet nisl tempus convallis quis ac lectus. Proin eget tortor risus. Sed porttitor lectus nibh at hr@techcrunch.com. Curabitur non nulla sit amet nisl tempus convallis quis ac lectus. Cras ultricies ligula sed magna dictum porta. Proin eget tortor risus. Nulla quis lorem ut libero malesuada feugiat.',
				'post_status'   => 'publish',
				'meta'		=> array(
					'gallery'	=> OPALJOB_PLUGIN_URL . 'assets/images/logo-company.png',
					'featured'	=> 'on',
					'expires'	=> '09/30/2018',
					'address'	=> 'Lon Don - England',
					'salary'	=> '2000',
					'salarylabel'=> 'month',
					'map'		=> '55.338989578861046,-6.296797164306668,13',
					'company'	=> $company_id[array_rand($company_id)],
				),
				'category'		=> array(
					'opaljob_location' 	=> array('London'),
					'work_category'		=> array('Designer','Other'),
					'opaljob_types'		=> array('Full TIme','Part Time'),
					'opaljob_tags'		=> array('Php','Java','Ios','Android'),
				),
			),
			array(
				'post_type'		=>'opaljob_work',
				'post_author' 	=> 1,
				'post_title'	=> 'Volkswagen Group',
				'post_content' 	=> '<h3>Job Description</h3>
					Curabitur non nulla sit amet nisl tempus convallis quis ac lectus. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Praesent sapien massa, convallis a pellentesque nec, egestas non nisi. Curabitur aliquet quam id dui posuere blandit. Nulla porttitor accumsan tincidunt.

					Donec rutrum congue leo eget malesuada. Pellentesque in ipsum id orci porta dapibus. Donec sollicitudin molestie malesuada. Vivamus magna justo, lacinia eget consectetur sed, convallis at tellus. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
					<h3>Benefits</h3>
					<ul>
						<li>Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui. Sed porttitor lectus nibh. Pellentesque in ipsum id orci porta dapibus.</li>
						<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla porttitor accumsan tincidunt. Cras ultricies ligula sed magna dictum porta.</li>
						<li>Curabitur arcu erat, accumsan id imperdiet et, porttitor at sem. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae.</li>
						<li>Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula.</li>
					</ul>
					<h3>Job Requirements</h3>
					<ol>
						<li>Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui. Sed porttitor lectus nibh. Pellentesque in ipsum id orci porta dapibus.</li>
						<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla porttitor accumsan tincidunt. Cras ultricies ligula sed magna dictum porta.</li>
						<li>Curabitur arcu erat, accumsan id imperdiet et, porttitor at sem. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae.</li>
						<li>Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula.</li>
					</ol>
					<h3>How To Apply</h3>
					Praesent sapien massa, convallis a pellentesque nec, egestas non nisi. Curabitur aliquet quam id dui posuere blandit. Curabitur aliquet quam id dui posuere blandit. Curabitur non nulla sit amet nisl tempus convallis quis ac lectus. Proin eget tortor risus. Sed porttitor lectus nibh at hr@techcrunch.com. Curabitur non nulla sit amet nisl tempus convallis quis ac lectus. Cras ultricies ligula sed magna dictum porta. Proin eget tortor risus. Nulla quis lorem ut libero malesuada feugiat.',
				'post_status'   => 'publish',
				'meta'		=> array(
					'gallery'	=> OPALJOB_PLUGIN_URL . 'assets/images/logo-company.png',
					'featured'	=> 'on',
					'expires'	=> '09/30/2018',
					'address'	=> 'Lon Don - England',
					'salary'	=> '2000',
					'salarylabel'=> 'month',
					'map'		=> '56.338989578861046,-6.296797164306668,13',
					'company'	=> $company_id[array_rand($company_id)],
				),
				'category'		=> array(
					'opaljob_location' 	=> array('London'),
					'work_category'		=> array('Designer','Other'),
					'opaljob_types'		=> array('Full TIme','Part Time'),
					'opaljob_tags'		=> array('Php','Java','Ios','Android'),
				),
			),
		);
		
		foreach ($arg_work as $key => $work) {

			$args = array(
				'post_type' 	=> 'opaljob_work',
				'post_author'	=> 1,
				'post_status'	=> 'publish',
				'post_title'	=> $work['post_title'],
				'post_content'	=> $work['post_content'],
			);

			$insert = wp_insert_post($args,true);
			if($insert) {
				foreach ($work['category'] as $key => $category) {
					wp_set_object_terms($insert,$category,$key);
				}

				foreach ($work['meta'] as $key => $value) {
					update_post_meta($insert, OPALJOB_WORK_PREFIX . $key , $value);
					
				}
			}else {
				$return = array( 'status' => 'danger', 'message' => __( 'Error import work', 'opaljob' ) );
				echo json_encode($return); die();
			}
		
		}
		// add resume
		$arg_resume = array(
			array(
				'post_type'		=>'opaljob_resume',
				'post_author' 	=> 1,
				'post_title'	=> 'Developer Online',
				'category' => array(
						'opaljob_location'		=> array('london'=>'London'),
						'work_category'		=>	array('designer'=>'Designer'),
				),
				'meta'			=> array(
					'salary'	=> '1000',
					'language'	=> 'English',
					'hightest_degree' 	=> 'adipiscing elit',
					'year_experience'	=> '4',
					'user_meta_id'		=> '1',
					'skill'		=> 'master',
					'resum_attachment'=> OPALJOB_PLUGIN_URL . 'assets/images/CV.doc',
					'email'		=> 'demo@gmail.com',
					'phone'		=> '09876554422',
					'address'	=> 'Mancheter City',
					'education_group' => array(
						array(
							'opaljob_resume_education_school_name' => 'School1',
							'opaljob_resume_education_qualification'=> 'Lorem ipsum dolor sit amet',
							'opaljob_resume_education_start_end_date'=> 'from 10/2008 to 10/2015',
						),
					),
					'work_experience'=> array(
						array(
							'opaljob_resume_work_experience_company'=> 'Lorem ipsum dolor sit amet',
							'opaljob_resume_work_experience_job_title'=> 'Lorem ipsum dolor sit amet',
							'opaljob_resume_work_experience_start_end_date'=> 'from 10/2008 to 10/2015',
						),
					),
					'summary_of_skills'=> array(
						array(
							'opaljob_resume_summary_of_skills_name' => 'English',
							'opaljob_resume_summary_of_skills_percent'=> '100',
						),
					),
					
				),
			),
		);
		
		foreach ($arg_resume as $key => $resume) {
			$arg = array(
				'post_type' 	=> 'opaljob_resume',
				'post_author'	=> 1,
				'post_status'	=> 'publish',
				'post_title'	=> $resume['post_title'],
			);
			$insert = wp_insert_post($arg,true);

			if($insert) {
				foreach ($resume['category'] as $key => $category) {
					wp_set_object_terms($insert,$category,$key);
				}

				foreach ($resume['meta'] as $key => $meta) {
					update_post_meta($insert, OPALJOB_RESUME_PREFIX . $key , $meta);
				}
			}else {
				$return = array( 'status' => 'danger', 'message' => __( 'Error import resume', 'opaljob' ) );
				echo json_encode($return); die();
			}
		}

		// add apply

		$arg_apply = array(
			array(
				'post_title'=>'admin',
				'meta'		=> array(
					'email'	=> 'demo@gmail.com',
					'position_applying' => 'Developer',
					'resume'=> OPALJOB_PLUGIN_URL . 'assets/images/CV.doc',
					'company_id'		=> '1',
					'jobseeker_id'		=> '1',
					'alert_recruiter'	=> '1',
				),
			),
		);

		foreach ($arg_apply as $key => $apply) {
			$arg = array(
				'post_type'		=> 'opaljob_apply',
				'post_title'	=> $apply['post_title'],
				'post_status'	=> 'pending',
				'post_author'	=> 1,
			);

			$insert = wp_insert_post($arg,true);
			if($insert) {
				foreach ($apply['meta'] as $key => $meta) {
					update_post_meta($insert, OPALJOB_APPLY_PREFIX . $key , $meta);
				}	
			}else {
				$return = array( 'status' => 'danger', 'message' => __( 'Error import taxonomy', 'opaljob' ) );
				echo json_encode($return); die();
			}		
		}

		$return = array( 'status' => 'success', 'message' => __( 'Import success', 'opaljob' ) );
		echo json_encode($return); die();
	}
	add_action( 'wp_ajax_opaljob_ajax_get_import_demo', 'opaljob_ajax_get_import_demo' );
	add_action( 'wp_ajax_nopriv_opaljob_ajax_get_import_demo', 'opaljob_ajax_get_import_demo' );
endif;

function opaljob_update_post($post_id,$name,$value) {
	$update = update_post_meta($post_id,$name,$value);
	return $update;
}