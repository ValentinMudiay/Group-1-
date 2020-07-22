<?php
if(!function_exists('wpvc_votes_admin_menu_custom')){
    function wpvc_votes_admin_menu_custom(){
	$called_php_file = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
	$active_tab = (isset($_GET[ 'page' ]))?$_GET[ 'page' ]:'';
	$active_tab1 = (isset($_GET[ 'post_type' ]))?$_GET[ 'post_type' ]:'';
	$active_tab2 = (isset($_GET[ 'taxonomy' ]))?$_GET[ 'taxonomy' ]:'';

	$current_post = (isset($_GET[ 'post' ]))?$_GET['post']:'';
	$edit_post_page = '';

    if ( 'contestants' == get_post_type($current_post) )
        $edit_post_page = isset($_GET['action'])?$_GET['action']:'';


	remove_action( 'admin_notices', 'update_nag', 3 );

	$page_show = array('move_posts','wpvc_upgrade','votes_export','votinglogs','fieldcontestant','edit');
	$post_show = array('contestants','move_posts','wpvc_upgrade','votes_export','votinglogs','fieldcontestant','edit');
	$tax_show  = array('contest_category');
    if((in_array($active_tab,$page_show) || in_array($active_tab1,$post_show) || in_array($edit_post_page,$page_show))&&($called_php_file=='edit.php' || $called_php_file=='admin.php' || $called_php_file=='edit-tags.php')) {
	 if(!in_array($active_tab2,$tax_show)){


	    wp_register_style('wpvc_voting_tabs', WPVC_ASSETS_CSS_PATH.'wpvc_tabs.css');
	    wp_enqueue_style('wpvc_voting_tabs');
	?>
	    <div id="wpbody">
		<div class="wrap wpvc_tab_wrap">
		    <div class="wpvc_vote_tabs wpvc_vote_tabs-style-bar">
			<a id="mobile-contestant-menu"><?php _e('Contestant Menu'); ?><span class="wt-arrow"></span></a>
			<nav class="wpvc_contestant_nav_menu">
			    <ul>
				<li class="<?php echo ($active_tab1 == WPVC_VOTES_TYPE && $called_php_file=='edit.php')? 'tab-current' : ''; ?>">
				    <a class="owvotingicon owicon-users" href="edit.php?post_type=contestants"><?php _e('Contestants','voting-contest'); ?></a>
				</li>

				<li class="<?php echo ($active_tab1 == WPVC_VOTES_TYPE && $called_php_file=='post-new.php') ? 'tab-current' : ''; ?>">
				    <a class="owvotingicon owicon-add" href="post-new.php?post_type=contestants"><?php _e('Add Contestants','voting-contest'); ?></a>
				</li>

				<li class="<?php echo ($active_tab == 'votinglogs') ? 'tab-current' : ''; ?>">
				    <a class="owvotingicon owicon-list-alt" href="admin.php?page=votinglogs"><?php _e('Vote Log','voting-contest'); ?></a>
				</li>

				<li class="<?php echo ($active_tab == 'fieldcontestant') ? 'tab-current' : ''; ?>">
				    <a class="owvotingicon owicon-edit" href="admin.php?page=fieldcontestant"><?php _e('Contestant Form Builder','voting-contest'); ?></a>
				</li>

                <li class="<?php echo ($active_tab == 'wpvc_upgrade') ? 'tab-current' : ''; ?>">
				    <a class="owvotingicon owicon-download" href="admin.php?page=wpvc_upgrade"><?php _e('Upgrade to PRO','voting-contest'); ?></a>
				</li>

			    </ul>
			</nav>
		    </div>
		</div>
	    </div>
	    <script type="text/javascript">
		jQuery(document).ready( function($) {
		    jQuery('li#toplevel_page_contestants').removeClass('wp-not-current-submenu');
		    jQuery('li#toplevel_page_contestants').addClass('wp-has-current-submenu');
		    jQuery('li#toplevel_page_contestants a.toplevel_page_contestants').removeClass('wp-not-current-submenu');
		    jQuery('li#toplevel_page_contestants a.toplevel_page_contestants').addClass('wp-has-current-submenu');

		    var reference = jQuery('.vote_contest_contestants').parent().parent();
		    reference.addClass('current');
		    reference.parent().find('li:first').removeClass('current');

			$("#mobile-contestant-menu").click(function(){
				$(this).toggleClass( "show" );
				$(".wpvc_contestant_nav_menu").toggleClass( "show" );
			});

		});
	    </script>
	<?php
	    }
	}

    if((in_array($active_tab,$page_show) || in_array($active_tab1,$post_show) || in_array($edit_post_page,$page_show))&&($called_php_file=='edit.php' || $called_php_file=='admin.php' || $called_php_file=='edit-tags.php' || $called_php_file == 'post.php' || $called_php_file == 'post-new.php')) {
	       if(!in_array($active_tab2,$tax_show)){
                ?>
                    <script type="text/javascript">
                    jQuery(document).ready( function($) {
                        jQuery('li#toplevel_page_contestants').removeClass('wp-not-current-submenu');
                        jQuery('li#toplevel_page_contestants').addClass('wp-has-current-submenu');
                        jQuery('li#toplevel_page_contestants a.toplevel_page_contestants').removeClass('wp-not-current-submenu');
                        jQuery('li#toplevel_page_contestants a.toplevel_page_contestants').addClass('wp-has-current-submenu');

                        var reference = jQuery('.vote_contest_contestants').parent().parent();
                        reference.addClass('current');
                        reference.parent().find('li:first').removeClass('current');

                        $("#mobile-contestant-menu").click(function(){
                            $(this).toggleClass( "show" );
                            $(".ow_contestant_nav_menu").toggleClass( "show" );
                        });

                    });
                    </script>
                <?php
        }
    }
    
    }
}else
die("<h2>".__('Failed to load Voting contestant admin menu','voting-contest')."</h2>");

?>
