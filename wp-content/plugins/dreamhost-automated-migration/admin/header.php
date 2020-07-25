<?php

if (!defined('ABSPATH')) exit;

	$_error = null;
	if (array_key_exists('error', $_REQUEST)) {
		$_error = $_REQUEST['error'];
		$open_tag = '<div class="error" style="padding-bottom:0.5%;margin-left:0;"><p>';
		$close_tag = '</p></div>';
		if ($_error == "email") {
			$error_message = $open_tag . 'There is already an account with this email.' . $close_tag;
		} else if ($_error == "blog") {
			$error_message = $open_tag . 'Could not create an account. Please contact <a href="http://blogvault.net/contact/">blogVault Support</a><br />
				<font color="red">NOTE: We do not support automated migration of locally hosted sites.</font>' . $close_tag;
		} else if (($_error == "custom") && isset($_REQUEST['bvnonce']) && wp_verify_nonce($_REQUEST['bvnonce'], "bvnonce")) {
			$error_message = $open_tag . esc_html(base64_decode($_REQUEST['message'])) . $close_tag;
		}
	}
?>
		<div class="logo-container" style="padding: 50px 0px 10px 20px">
			<a href="https://www.dreamhost.com/" style="padding-right: 20px;"><img src="<?php echo plugins_url($this->getPluginLogo(), __FILE__); ?>" style="width:200px;" /></a>
			<a href="http://blogvault.net/"><img src="<?php echo plugins_url('../assets/img/blogvault-logo-120.png', __FILE__); ?>" style="width:150px;"></a>
		</div>

		<div id="wrapper" class="toplevel_page_dreamhost-automated-migration">
			<h1>Migrate Your Sites to DreamHost</h1>
			<div class="grid">
				<div class="grid__col grid__col--6-of-12" style= "float: left; width: 50%;">
					<p><font size="3">The DreamHost automated migration plugin makes moving sites to the DreamHost platform effortless. It doesn't matter if you're a qualified developer or someone teaching yourself for the first time, this plugin does all the hard work for you. Move as many sites as you need quickly, and with minimal interaction with support.</font></p>
					<?php
						if (isset($error_message)) {
							echo $error_message;
						}
					?>
				</div>
			</div>
		</div>