<?php
//Add New category text
function wpvc_category_settings(){	
	?>
	<div class="wp_voting-upsell-under-box">
		<h3>Want even more settings?</h3>
		<p>By upgrading to WP Voting Contest Pro, you can start many types of online contests such as photo, video, audio, essay with very little effort.</p>
		<p class="wp_voting-upsell-button-par"><a href="https://plugins.ohiowebtech.com/?download=wordpress-voting-photo-contest-plugin" class="button button-primary">Click here to Upgrade</a></p>
	</div>
	<?php
}

//Add New Custom field text
function wpvc_add_custom_field_settings(){	
	?>
	<div class="wp_voting-upsell-under-box">
		<h3>Want to add new custom field ?</h3>
		<p>
			Custom questions are much like building a contact form within the contest plugin. You can add questions to the registration form when a user registers to your website or the contestant form when a user enters your contest. Using the Contestants fields, you can ask private information such as phone number or email address and choose not to display those details on the front end contestants page, keeping the details private for the admin to view on the contestants admin page only.
			
		</p>
		<p>If you want to add questions to your Contest Entry form : </p>
		<p class="wp_voting-upsell-button-par"><a href="https://plugins.ohiowebtech.com/?download=wordpress-voting-photo-contest-plugin" class="button button-primary">Click here to Upgrade</a></p>
	</div>
	<?php
}

//Text in the Voting Log Admin View
function wpvc_add_vote_log_settings(){
	?>
	<div class="wp_voting-upsell-under-box">
		<h3>Need Export of Vote Log ?</h3>
		<p>
			There are also 5 different file types to chose from when exporting your data. You can also export the voting log for building an email marketing list.			
		</p>
		<p>If you want to export the Vote log : </p>
		<p class="wp_voting-upsell-button-par"><a href="https://plugins.ohiowebtech.com/?download=wordpress-voting-photo-contest-plugin" class="button button-primary">Click here to Upgrade</a></p>
	</div>
	<?php
}

//Text in the Common Settings Admin View
function wpvc_add_vote_type_settings(){	
	?>
	<div class="wp_voting-upsell-under-box">
		<h3>Need to have VIDEO, MUSIC, ESSAY CONTEST Settings?</h3>
		<p>
			Run multiple contests and contest types at the same time each with their own settings and options. We are the ONLY all in one contest plugin that supports simultaneously running Photo Contests, Video Contests, Music Contests and Essay Contests using a single plugin.
		</p>		
		<p class="wp_voting-upsell-button-par"><a href="https://plugins.ohiowebtech.com/?download=wordpress-voting-photo-contest-plugin" class="button button-primary">Click here to Upgrade</a></p>
	</div>
	<?php
}

//Text in the Contest Settings Admin View
function wpvc_add_vote_contest_settings(){	
	?>
	<div class="wp_voting-upsell-under-box">
		<h3>Need to Control Vote Frequency ?</h3>
		<p>
			Over 24 different configurations of controlling votes! (x) per category, (x) per calendar day, (x) per (x) hours, and unlimited. Also determine if user can vote for single, multiple (exclusive), or multiple (split) contestants.	
		</p>
		<img src="<?php echo WPVC_ASSETS_IMAGE_PATH; ?>vote-frequency.jpg" />
		<p class="wp_voting-upsell-button-par"><a href="https://plugins.ohiowebtech.com/?download=wordpress-voting-photo-contest-plugin" class="button button-primary">Click here to Upgrade</a></p>
	</div>
	<?php
}


//Text in the Overview Admin View
function wpvc_add_vote_overview_settings(){	
	?>
	<div class="wp_voting-upsell-under-box">
		<h3>Need More Shortcodes ?</h3>
		<li><b>profilescreen</b>
			<p><i>The "profilescreen" shortcode is used when you require a contestant to register/login to enter a contest. Since the user account is created, we can now track their entries. This allows us to display all of thier own entries on the profile screen after they login. From here they can delete their entries. Optionally, if you enable it, they can edit their entry from this screen as well. You can <a href="https://demo.ohiowebtech.com/contestant-profile-page/" target="_blank">view the demo here</a>.</i></p>
		   <p>Basic Use: [profilescreen]</p>
		   <p>Advanced Use:
		   [profilescreen contests=1 postperpage=20 form=1]</p>
			<p><i><?php _e('Attributes that can be passed to this shortcode are as follows:','voting-contest'); ?></i></p>
				<ul>
				   <?php
				   echo html('li', '<u>contests</u> &nbsp '.__('(Note: Adding the shortcode attritube contests=1 will force display the contestant entries. Using contests=0 will hide their entries.)','voting-contest'));
				   echo html('li', '<u>postperpage</u> &nbsp '.__('(Note: Adding the shortcode attribute postperpage=10 will display 10 entries per page on the profile screen.)','voting-contest'));
				   echo html('li', '<u>form</u> &nbsp '.__('(Note: You can override the global contestant edit setting by using the shortcode attribute form=1 to enable editing of contestants. You can also use form=0 to disable editing.)','voting-contest'));
				   ?>
			   </ul>
		   </li>
		   
		   <li ><b>showallcontestants</b>
			<p><i>The "showallcontestants" shortcode is a completely new layout and view for displaying all the contestants on a signle page from all contest categories. With this view only, you can search for contestants and filter by category. You can <a href="https://demo.ohiowebtech.com/show-all-contest-contestants/" target="_blank">view the demo here</a>.</i></p>
		   <p>Basic Use: [showallcontestants]</p>
		   <p>Advanced Use:
		   [showallcontestants orderby=votes order=ASC postperpage=8]</p>
		   <p><i><?php _e('Attributes that can be passed to this shortcode are as follows:','voting-contest'); ?></i></p>
			   <ul>
				   <?php
				   echo html('li', '<u>orderby</u> &nbsp'.__('(Note: Specify how your contestants are ordered by, by adding orderby=votes to your shortcode. Options are listed <a href="http://plugins.ohiowebtech.com/documentation/shortcode-usage/" target="_blank">HERE</a> )','voting-contest'));
				   echo html('li', '<u>order</u> &nbsp '.__('(Note: Specify the Order the Contestants are listed in by adding order=ASC or order=DESC to your shortcode.)','voting-contest'));
				   echo html('li', '<u>postperpage</u> &nbsp '.__('(Note: Specify the Number of Contestants to display per page in the Contest Listing by adding postperpage=10 to your shortcode. Change # to desired amount.)','voting-contest'));
				   ?>
			   </ul>
		   </li>
		   <li><b>addcontest</b>
			<p><i>The "addcontest" shortcode will allow you to show a single entry form to enter all of your contests. This shortcode will not allow you to show the contestants listing. You can <a href="https://demo.ohiowebtech.com/entry-form-with-multiple-categories/" target="_blank">view the demo here</a>.</i></p>
		   <p>Basic Use: [addcontest]</p>
			<p><i><?php _e('Attributes that can be passed to this shortcode are as follows:','voting-contest'); ?></i></p>
				<ul>
				   <?php
				   echo html('li', __('(No Attributes available for this shortcode.)','voting-contest'));
				   ?>
			   </ul>
		   </li>
		<p class="wp_voting-upsell-button-par"><a href="https://plugins.ohiowebtech.com/?download=wordpress-voting-photo-contest-plugin" class="button button-primary">Click here to Upgrade</a></p>
	</div>
	<?php
}



function wpvc_upgrade_text(){	
	wp_register_style('wpvc_voting_admin', WPVC_ASSETS_CSS_PATH.'wpvc_admin_styles.css');
	wp_enqueue_style('wpvc_voting_admin');
	?>
	<div class="wp_voting-upsell-under-box">
		<h1>Upgrade to WP Voting Contest PRO</h1>
		<div class="wpvc_admin_left">
			<a href="https://plugins.ohiowebtech.com/?download=wordpress-voting-photo-contest-plugin" target="_blank" title="WP Voting Contest">
				<img src="<?php echo WPVC_ASSETS_IMAGE_PATH; ?>photo_contest_01.jpg" />
			</a>
		</div>
		
		<div class="wpvc_admin_right">
			<p>
				Thank you for installing the <a href="https://plugins.ohiowebtech.com/?download=wordpress-voting-photo-contest-plugin" target="_blank" title="WP Voting Contest">WP Voting Contest</a>.			
			</p>
			<p>The #1 Contest Plugin for WordPress just got better!</p>		
			<p>
				The WordPress Voting Contest plugin gives you the ability to quickly and seamlessly integrate an online contest into your WordPress 4.0 – 4.9.6+ website. You can start many types of online contests, using a single plugin, with very little effort such as a WordPress Photo Contest, WordPress Video Contest, WordPress Music Contest or WordPress Essay Contests!
			</p>
			<p>
				You can set up multiple contest categories each with their own set of options. With timers, social sharing, Facebook and Twitter Login, widgets, custom form builder for your entry form and site registration, multiple options per contest, move contestants, vote frequency control and many other amazing features, you can run a full featured online WordPress contest that suits your needs.
			</p>
			<p>
				The first release of WP Voting Contest was released on July 4th, 2013. This project took 2 years of development and had over 1 Million votes run through the system before releasing the plugin for sale to the general public. At the release of version 3.0 in 2015, which took nearly 6 months to develop from the ground up, we have had approximately 40 Million votes run through the system since the initial release of version 1.0 in July of 2013. We have taken every precaution to make sure that the system is light weight, secure, tamper resistant, packed full of features and compatible with today's themes and plugins.
			</p>
			<p>
				The WP Voting Contest Plugin is the #1 choice of Radio Stations, Magazine Companies, and TV Stations across the US. Now made available on your own WordPress website!
			</p>
			<p>
				If you are looking for an ALL IN ONE CONTEST plugin for WordPress available today, it is safe to say that the WP Voting Contest Plugin is among the best, if not, the best... but you can vote on that for yourself.
			</p>
			
			<p class="wp_voting-upsell-button-par"><a href="https://plugins.ohiowebtech.com/?download=wordpress-voting-photo-contest-plugin" class="button button-primary">Click here to Upgrade</a></p>
			
		</div>
	</div>
	<?php
}