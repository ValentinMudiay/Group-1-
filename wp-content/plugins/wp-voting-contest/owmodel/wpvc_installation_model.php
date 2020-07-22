<?php
if(!class_exists('WPVC_Installation_Model')){ 
	class WPVC_Installation_Model {
		static function wpvc_create_tables_owvoting(){
			global $wpdb;
			/************* Create Tables if table not exists ****************/
			$vote_tbl_sql = 'CREATE TABLE IF NOT EXISTS ' . WPVC_VOTES_TBL . '(
								id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
								ip VARCHAR( 255 ) NOT NULL,
								votes INT NOT NULL DEFAULT 0,
								post_id INT NOT NULL,
								termid VARCHAR( 255 ) NOT NULL DEFAULT "0",
								ip_always VARCHAR( 255 ) NOT NULL DEFAULT "0",
								email_always VARCHAR( 255 ) NOT NULL DEFAULT "0",							
								date DATETIME
							)';
			$contestant_custom_table = "CREATE TABLE IF NOT EXISTS ".WPVC_VOTES_ENTRY_CUSTOM_TABLE." (
										`id` int(11) unsigned NOT NULL AUTO_INCREMENT,`sequence` int(11) NOT NULL DEFAULT '0',
										`question_type` enum('TEXT','TEXTAREA','MULTIPLE','SINGLE','DROPDOWN','FILE','DATE') NOT NULL DEFAULT 'TEXT',
										`question` text NOT NULL,`system_name` varchar(45) DEFAULT NULL,`response` text,
										`required` enum('Y','N') NOT NULL DEFAULT 'N',`required_text` text,
										`shwpvc_labels` enum('Y','N') NOT NULL DEFAULT 'N',					
										`wpvc_file_size` int(11) NOT NULL default '0',									
										`admin_only` enum('Y','N') NOT NULL DEFAULT 'N',
										`grid_only` enum('Y','N') NOT NULL DEFAULT 'N',
										`list_only` enum('Y','N') NOT NULL DEFAULT 'N',
										`delete_time` varchar(45) DEFAULT 0,
										`set_limit` enum('Y','N') NOT NULL DEFAULT 'N',
										`limit_count` int(11) DEFAULT 0,
										`wp_user` int(22) DEFAULT '1',
										`admin_view` VARCHAR(5) NOT NULL DEFAULT 'N',
										`pretty_view` enum('Y','N') NOT NULL DEFAULT 'N',
										PRIMARY KEY (`id`),KEY `wp_user` (`wp_user`),KEY `system_name` (`system_name`),KEY `admin_only` (`admin_only`)
									)ENGINE=InnoDB"; 
			$contestant_custom_val = "CREATE TABLE IF NOT EXISTS ".WPVC_VOTES_POST_ENTRY_TABLE." (
										`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
										`post_id_map` int(11) NOT NULL,
										`field_values` longtext NOT NULL,
										 PRIMARY KEY (`id`)
									)ENGINE=InnoDB";
			$contestant_register_custom_table = "CREATE TABLE IF NOT EXISTS ".WPVC_VOTES_USER_CUSTOM_TABLE." (
												`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
												`sequence` int(11) NOT NULL DEFAULT '0',
												`question_type` enum('TEXT','TEXTAREA','MULTIPLE','SINGLE','DROPDOWN') NOT NULL DEFAULT 'TEXT',
												`question` text NOT NULL,
												`system_name` varchar(45) DEFAULT NULL,
												`response` text,
												`required` enum('Y','N') NOT NULL DEFAULT 'N',
												`required_text` text,
												`admin_only` enum('Y','N') NOT NULL DEFAULT 'N',
												`delete_time` varchar(45) DEFAULT 0,
												`wp_user` int(22) DEFAULT '1',PRIMARY KEY (`id`),
												 KEY `wp_user` (`wp_user`),KEY `system_name` (`system_name`),KEY `admin_only` (`admin_only`)
												)ENGINE=InnoDB";
			$contestant_register_custom_val = "CREATE TABLE IF NOT EXISTS ".WPVC_VOTES_USER_ENTRY_TABLE." (
											`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
											`user_id_map` int(11) NOT NULL,
											`field_values` longtext NOT NULL,
											 PRIMARY KEY (`id`)
											)ENGINE=InnoDB";
											
			$post_track = "CREATE TABLE IF NOT EXISTS ".WPVC_VOTES_POST_ENTRY_TRACK." (
			`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
			`user_id_map` int(11) NOT NULL,
			`ip` VARCHAR( 255 ) NOT NULL,
			`count_post` INT NOT NULL,
			`wpvc_term_id` int(11) NOT NULL,		
			PRIMARY KEY (`id`)
			)ENGINE=InnoDB";
				
			ob_start();
			$wpdb->query($vote_tbl_sql);
			$wpdb->query($contestant_custom_table);
			$wpdb->query($contestant_custom_val);
			$wpdb->query($contestant_register_custom_table);
			$wpdb->query($contestant_register_custom_val);
			$wpdb->query($post_track);
			
			
			$field_desc_check = WPVC_Installation_Model::ow_voting_get_contestant_desc();
			
			if(empty($field_desc_check)){
				/****** INSERT THE DEFAULT FIELDS HERE *******/		
				$sql_inserts  = "INSERT INTO ".WPVC_VOTES_ENTRY_CUSTOM_TABLE." (sequence, question_type, question, system_name, required, admin_only, admin_view , response) VALUES
								(0, 'TEXT', 'Title', 'contestant-title', 'Y', 'Y', 'Y',''),
								(1, 'TEXTAREA', 'Description', 'contestant-desc', 'Y', 'Y', 'Y',''),
								(2, 'TEXT', 'Video Link URL', 'contestant-ow_video_url', 'Y', 'Y', 'Y',''),
								(3, 'FILE', 'Music Upload URL', 'contestant-ow_music_url', 'Y', 'Y', 'Y','mp3'),
								(4, 'FILE', 'Image', 'contestant-image', 'Y', 'Y', 'N',''),
								(5, 'TEXT', 'Music Link URL', 'contestant-ow_music_url_link', 'Y', 'Y', 'N',''),
								(6, 'TEXT', 'Email Address of Contestant', 'contestant-email_address', 'Y', 'Y', 'N','')
								";
				
				$wpdb->query($sql_inserts);
			}
		}
		
		static function ow_voting_get_contestant_desc(){
		    global $wpdb;            
		    $sql     = "SELECT * FROM " . WPVC_VOTES_ENTRY_CUSTOM_TABLE . " WHERE system_name = 'contestant-desc'";
		    $desc_rs = $wpdb->get_results($sql);    
		    return $desc_rs;
	    }
			
		static function wpvc_voting_delete_tables(){
			
			global $wpdb;
			
			//Delete all tables on deactivation 
			$vote_table = 'DROP TABLE IF EXISTS ' . WPVC_VOTES_TBL;
			$wpdb->query($vote_table);
			
			$contestant_cutom_tbl = 'DROP TABLE IF EXISTS ' . WPVC_VOTES_ENTRY_CUSTOM_TABLE;
			$wpdb->query($contestant_cutom_tbl);
			
			$contest_val_tbl = 'DROP TABLE IF EXISTS ' . WPVC_VOTES_POST_ENTRY_TABLE;
			$wpdb->query($contest_val_tbl);
			
			$contest_reg_tbl = 'DROP TABLE IF EXISTS ' . WPVC_VOTES_USER_CUSTOM_TABLE;
			$wpdb->query($contest_reg_tbl);
			
			$contest_reg_val_tbl = 'DROP TABLE IF EXISTS ' . WPVC_VOTES_USER_ENTRY_TABLE;
			$wpdb->query($contest_reg_val_tbl);
			
			$contest_entry_trk = 'DROP TABLE IF EXISTS ' . WPVC_VOTES_POST_ENTRY_TRACK;
			$wpdb->query($contest_entry_trk);
			
		}
	}	
	
}else
die("<h2>".__('Failed to load Voting installation model')."</h2>");
?>
