<?php

class Inv_Nettenode_Admin {

	private $my_plugin_screen_name;

	public static function adminInıt(){
		register_setting( 'inv_vpos_settings', 'inv_vpos_setting1' );
		register_setting( 'inv_vpos_settings', 'inv_vpos_setting2' );
		register_setting( 'inv_dia_settings', 'inv_dia_username' );
		register_setting( 'inv_dia_settings', 'inv_dia_password' );
		register_setting( 'inv_dia_settings', 'inv_dia_host' );
		register_setting( 'inv_email_settings', 'inv_email_setting1' );
		register_setting( 'inv_email_settings', 'inv_email_setting2' );
		register_setting( 'inv_page_settings', 'inv_page_login' );
		register_setting( 'inv_page_settings', 'inv_page_register' );


	}

	public static function adminMenuInıt() {
		add_submenu_page( 
			'options-general.php',
			'Netten Öde', 
			'Netten Öde',  
			'manage_options', 
			'inv_nettenode_ayarlar',
			array('Inv_Nettenode_Admin','displayAdminPage') 

			);

	}

	public static function displayAdminPage(){
		?>
		<?php
		if( isset( $_GET[ 'tab' ] ) ) {
		    $active_tab = $_GET[ 'tab' ];
		}else{
			$active_tab = 'vpos_settings';
		}
		?>
			<div class="wrap">

				<div id="icon-themes" class="icon32"></div>
        		<h2>Netten Öde Ayarları</h2>
				
				<h2 class="nav-tab-wrapper">
				    <a href="?page=inv_nettenode_ayarlar&tab=vpos_settings" class="nav-tab">Sanal Pos Ayarları</a>
				    <a href="?page=inv_nettenode_ayarlar&tab=dia_settings" class="nav-tab">Dia Entegrasyon</a>
				    <a href="?page=inv_nettenode_ayarlar&tab=email_settings" class="nav-tab">Email Ayarları</a>
				    <a href="?page=inv_nettenode_ayarlar&tab=page_settings" class="nav-tab">Sayfa Ayarları</a>
				</h2>

				<form method="post" action="options.php">
				<?php if($active_tab == "vpos_settings") : ?>
					<h3>Sanal Pos Ayarları</h3>
					<table class="form-table">
						<tr valign="top">
        					<th scope="row">Vpos Settings1</th>
					 		<td><input name="inv_vpos_setting1" value="<?php echo esc_attr( get_option('inv_vpos_setting1') ); ?>"></td>
					 	</tr>
					 	<tr valign="top">
					 		<th scope="row">Vpos Settings2</th>
					 		<td><input name="inv_vpos_setting2" value="<?php echo esc_attr( get_option('inv_vpos_setting2') ); ?>"></td>
					 	</tr>
					</table>
					<?php settings_fields( 'inv_vpos_settings' ); ?>
		            <?php do_settings_sections( 'inv_vpos_settings' ); ?> 
		            <?php submit_button(); ?>
		             
		        <?php elseif ($active_tab == "dia_settings") : ?>
		        	<h3>Dia Ayarları</h3>
		        	<table class="form-table">
						<tr valign="top">
        					<th scope="row">Dia Username</th>
					 		<td><input name="inv_dia_username" value="<?php echo esc_attr( get_option('inv_dia_username') ); ?>"></td>
					 	</tr>
					 	<tr valign="top">
					 		<th scope="row">Dia Password</th>
					 		<td><input name="inv_dia_password" value="<?php echo esc_attr( get_option('inv_dia_password') ); ?>"></td>
					 	</tr>
					 	<tr valign="top">
					 		<th scope="row">Dia Host</th>
					 		<td><input name="inv_dia_host" value="<?php echo esc_attr( get_option('inv_dia_host') ); ?>"></td>
					 	</tr>
					</table>
		        	<?php settings_fields( 'inv_dia_settings' ); ?>
		            <?php do_settings_sections( 'inv_dia_settings' ); ?> 
		            
		            <?php submit_button(); ?>
		        <?php elseif ($active_tab == "email_settings") : ?>
		        	<h3>Email Ayarları</h3>
		        	<table class="form-table">
						<tr valign="top">
        					<th scope="row">Email Settings1</th>
					 		<td><textarea name="inv_email_setting1"><?php echo esc_attr( get_option('inv_email_setting1') ); ?></textarea></td>
					 	</tr>
					 	<tr valign="top">
					 		<th scope="row">Email Settings2</th>
					 		<td><textarea name="inv_email_setting2"><?php echo esc_attr( get_option('inv_email_setting2') ); ?></textarea></td>
					 	</tr>
					</table>
		        	<?php settings_fields( 'inv_email_settings' ); ?>
		            <?php do_settings_sections( 'inv_email_settings' ); ?> 
		            <?php submit_button(); ?>
		        <?php elseif ($active_tab == "page_settings") : ?>
					<h3>Sayfa Ayarları</h3>
					<?php 

						// WP_Query arguments
						$args = array(
							'post_type' => 'page',
							'sort_order' => 'ASC',
							'sort_column' => 'post_title',
						);

						// The Query
						$pages = get_pages( $args );

						
					?>



					<table class="form-table">
						<tr valign="top">
        					<th scope="row">Login Page</th>
					 		<td>
					 			<select name="inv_page_login">
					 				<?php 
					 					foreach ( $pages as $page ) {
										  	$option = '<option value="'.$page->ID.'" '.(get_option('inv_page_login') == $page->ID ? 'selected="selected"':'').'>';
											$option .= $page->post_title;
											$option .= '</option>';
											echo $option;
										}
					 				?>
					 			</select>
					 		</td>
					 	</tr>
					 	<tr valign="top">
					 		<th scope="row">Register Page</th>
					 		<td>
					 			<select name="inv_page_register">
					 				<?php 
					 					foreach ( $pages as $page ) {
										  	$option = '<option value="'.$page->ID.'" '.(get_option('inv_page_register') == $page->ID ? 'selected="selected"':'').'>';
											$option .= $page->post_title;
											$option .= '</option>';
											echo $option;
										}
					 				?>
					 			</select>
					 		</td>
					 	</tr>
					</table>



					<?php settings_fields( 'inv_page_settings' ); ?>
		            <?php do_settings_sections( 'inv_page_settings' ); ?> 
		            <?php submit_button(); ?>
		        <?php endif; ?>


		         
				</form>

				
			</div>
		<?php

	}

	public static function saveUserExtraFields($user_id ){
		if ( !current_user_can( 'edit_user', $user_id ) )
		return false;

		update_user_meta( absint( $user_id ), 'cari_no', wp_kses_post( $_POST['cari_no'] ) );
	}



	public static function showUserExtraFields($user) { ?>
		<h3>Netten Öde Bilgileri</h3>
		<table class="form-table">
			<tr>
				<th><label for="cari_no">Cari No</label></th>
				<td>
					<input type="text" name="cari_no" id="cari_no" value="<?php echo esc_attr( get_user_meta( $user->ID,'cari_no',true  ) ); ?>" class="regular-text" /><br />
					<span class="description">Kullanıcının cari numarasını giriniz.</span>
				</td>
			</tr>
		</table>
	<?php
	}


}