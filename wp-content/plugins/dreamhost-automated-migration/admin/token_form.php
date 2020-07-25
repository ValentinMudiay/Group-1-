<?php if (!defined('ABSPATH')) exit; ?>
	<div id="wrapper" class="toplevel_page_dreamhost-automated-migration">
		<div class="grid">
			<div class="grid__col grid__col--6-of-12" style= "float: left; width: 50%;">
				<form id="dreamhost_migrate_form" dummy=">" action="<?php echo $this->bvinfo->appUrl(); ?>/home/migrate" onsubmit="document.getElementById('migratesubmit').disabled = true;" style="padding:0 2% 2em 1%;" method="post" name="signup">

					<input type="hidden" name="bvsrc" value="wpplugin" />
					<input type="hidden" name="migrate" value="dreamhost" />
					<input type="hidden" name="nameserver" value="ns1.dreamhost.com"/>
					<?php echo $this->siteInfoTags(); ?>
					<input type='hidden' name='adminurl' value="<?php echo $this->mainUrl() ?>"/>

					<div class="row-fluid">
						<div class="span5" style="border-right: 1px solid #EEE; padding-top:1%;">
							<label id='label_email'>Email</label>
							<div class="control-group">
								<div class="controls">
									<input type="text" id="email" name="email" placeholder="ex. user@mydomain.com">
								</div>
							</div>
							<label class="control-label" for="input02">Migration Token
								<p style="font-weight:normal;font-size:75%;margin:0px;">
									<a href="https://help.dreamhost.com/hc/en-us/articles/360035448951">What's this?</a>
								</p>
							</label>
							<div class="control-group">
								<div class="controls">
								<input type="text" class="input-large" name="migration_token" placeholder="ex. 6LB9ECHXP7LHMZ8V">
                </div>
							</div>
							<div style="text-align:right;max-width:496px">
								<a href="<?php echo admin_url('admin.php?page='.$this->bvinfo->plugname.'&ftp_details') ?>">Manually Input Host Details</a>
							</div>
							<div class="control-group">
								<div class="controls">
									<input type="checkbox" name="consent" onchange="document.getElementById('migratesubmit').disabled = !this.checked;" value="1"/>I agree to Blogvault <a href="https://blogvault.net/tos" target="_blank" rel="noopener noreferrer">Terms of Service</a> and <a href="https://blogvault.net/privacy" target="_blank" rel="noopener noreferrer">Privacy Policy</a>
								</div>
							</div>
						</div>
					</div>
					<input type='submit' disabled id='migratesubmit' value='Migrate' class="button button-primary" style="width: 100px;">
				</form>
			</div>
		</div>
	</div> <!-- wrapper ends here -->