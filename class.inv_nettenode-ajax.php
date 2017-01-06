<?php
class Inv_Nettenode_Ajax{

	public function __construct()
	{
		add_action('wp_ajax_nopriv_invvo_register_ajax', array($this, 'registerAjax'));
		add_action('wp_ajax_invvo_register_ajax', array($this, 'registerAjax'));
	}

	public function registerAjax(){
		$inputs = $_POST['inputs'];

		$returnData = array(
				"message"=>"",
				"state"=>0
			); 


		if(empty($inputs["username"]) || empty($inputs["email"]) || empty($inputs["password"]) || empty($inputs["passwordRepeat"]) ){
			$returnData["message"] = 'tüm alanları girdiğinize emin olunuz.';
			echo json_encode($returnData);
			die();
		}

		if(strlen($inputs["password"])<8){
			$returnData["message"] = 'Şifreniz 8 karakter ve üzeri olmalıdır.';
			echo json_encode($returnData);
			die();
		}

		if($inputs["password"] != $inputs["passwordRepeat"]){
			$returnData["message"] = 'Girdiğiniz şifreler eşleşmiyor.';
			echo json_encode($returnData);
			die();
		}



		$userdata = array(
			'user_login'  =>  $inputs['username'],
			'user_pass'  =>  $inputs["password"],
			'user_email' => $inputs['email'],
			'role' => get_option('default_role')
		);

		$user_id = wp_insert_user( $userdata ) ;

		if (is_wp_error( $user_id ) ) {
			foreach ($user_id->errors as $error) {
				$errorMessage .= $error[0];
			}
			$returnData["message"] = $errorMessage;
			echo json_encode($returnData);
			die();
		}


		$returnData["message"] = 'Kullanıcınız oluşturulmuştur. Lütfen giriş yapınız';
		$returnData["state"] = 1;
		echo json_encode($returnData);
		die();


	}

}
?>