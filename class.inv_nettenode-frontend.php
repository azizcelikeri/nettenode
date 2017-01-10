<?php

class Inv_Nettenode_Front_End {
	public function __construct()
	{
		add_filter( 'the_content', array($this, 'contentFilter') );
		add_action( 'wp_enqueue_scripts', array($this, 'addStylesScripts') );
		add_action("init",array($this, 'checkDiaCookie'));
		add_action('wp_login', array($this, 'loginDia'));
	}

	public function contentFilter($content){
		if(is_singular('page')){
			switch (get_the_id()) {
				case get_option('inv_page_register'):
						$content = self::getRegisterForm().$content;
					break;
				case get_option('inv_page_login'):
						$extraContent = '';
						if(function_exists('wsl_render_auth_widget')){
							$extraContent .= wsl_render_auth_widget();
						}
						$extraContent .= wp_login_form(array('echo'=>false) );
						$content .= $extraContent.$content;
					break;
				
				default:
					# code...
					break;
			}	
		}
		
		return $content;
	}

	public function getRegisterForm()
	{
		ob_start(); 
		if(function_exists('wsl_render_auth_widget')){
			echo wsl_render_auth_widget();
		}
		?>

			<form id="inv_registerForm">
				<div class="form-group">
					<label for="username">User Name</label>
					<input type="text" name="username" class="form-control" />
				</div>
				<div class="form-group">
					<label for="email">Email</label>
					<input type="email" name="email" class="form-control" />
				</div>
				<div class="form-group">
					<label for="password">Password</label>
					<input type="password" name="password" class="form-control" />
				</div>
				<div class="form-group">
					<label for="password-repeat">Repeat Password</label>
					<input type="password" name="password-repeat" class="form-control" />
				</div>
				<div class="form-group">
					<input type="submit" class="submit" value="Submit" />
				</div>
			</form>

		<?php
		return ob_get_clean();
	}

	public function addStylesScripts()	
	{
	    wp_enqueue_script( 'nettenode', plugins_url('js/nettenode.js', __FILE__ ), array( 'jquery' ), '1.0.0', true );
	    wp_localize_script( 'nettenode', 'ajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
	}
	
	public static function loginDia()	
	{
	    $url = esc_attr( get_option('inv_dia_host') )."sis/json";

		$data = array(
			"login" => array(
					"username"=> esc_attr( get_option('inv_dia_username') ),
					"password"=> esc_attr( get_option('inv_dia_password') ),
		     		"disconnect_same_user"=> "False"
				)
		);

		$decodedData = json_encode($data);

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($curl, CURLOPT_POSTFIELDS, $decodedData);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
		    'Content-Type: application/json',
		    'Content-Length: ' . strlen($decodedData))
		);
		curl_setopt($curl, CURLOPT_URL, $url);
		$result = curl_exec($curl);
		$json=json_decode($result,true);
		curl_close($curl);
        set_transient( 'dia_session_id', $json["msg"], HOUR_IN_SECONDS );
	}

	public static function checkDiaCookie(){
		if(is_user_logged_in()){
			if(false === get_transient('dia_session_id') ){
				self::loginDia();
			}	
		}
		
	}


}



?>