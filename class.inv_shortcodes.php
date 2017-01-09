<?php 
class Inv_Nettenode_Shortcodes{
	
	private static $userCariNo;

	public function __construct()
	{
		add_shortcode('inv_login', array($this, 'loginShortcode'));
		add_shortcode('inv_faturalar', array($this, 'faturalarShortcode'));
		add_shortcode('inv_cari', array($this, 'cariBakiyeShortcode'));

		add_action('init', function() {

		    $userId = get_current_user_id();
    	
			self::$userCariNo = get_user_meta($userId,"cari_no", true);
		});
	}

	public function loginShortcode()
    {
    	
    }

    public function faturalarShortcode()
    {
    	

    	$diaSessionId = get_transient( 'dia_session_id' );
    	$url = esc_attr( get_option('inv_dia_host') )."scf/json";

		// SESSION ID MANUEL GİRİLMELİ

		$firma_kodu = 1;
		$donem_kodu = 20;

		$data = array(
			"scf_fatura_listele" => array(
					"session_id"=> $diaSessionId,
					"firma_kodu"=> 50,
		     		"donem_kodu"=> 4,
		     		"filters"=> array(array("field"=> "__carikartkodu", "operator"=> "IN", "value"=> self::$userCariNo)),
		     		"sorts"=> '',
		     		"params"=> '',
		     		"limit"=> 100,
		     		"offset"=> 0
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
        $outputString = '<table class="table">';
        foreach ($json["result"] as $key => $value) {
        	$outputString .= '<tr>';
        	$outputString .= '<td>'.$value["__carifirma"].'</td>';
        	$outputString .= '<td>'.$value["_date"].'</td>';
        	$outputString .= '<td>'.$value["dovizkuru"].'</td>';
        	$outputString .= '<td>'.$value["dovizturu"].'</td>';
        	$outputString .= '<td>'.$value["ortalamavade"].'</td>';
        	$outputString .= '<td>'.$value["net"].'</td>';
        	$outputString .= '</tr>';
        }
        $outputString .= '</table>';

        return $outputString;




    }

    public function cariBakiyeShortcode()
    {
    	$diaSessionId = get_transient( 'dia_session_id' );
    	$url = esc_attr( get_option('inv_dia_host') )."scf/json";

		// SESSION ID MANUEL GİRİLMELİ

		$firma_kodu = 1;
		$donem_kodu = 20;

		$data = array(
			"scf_carikart_listele" => array(
					"session_id"=> $diaSessionId,
					"firma_kodu"=> 50,
		     		"donem_kodu"=> 4,
		     		"filters"=> array(array("field"=> "carikartkodu", "operator"=> "IN", "value"=> self::$userCariNo)),
		     		"sorts"=> array("field"=> "carikartkodu",  "sorttype"=> "DESC"),
		     		"params"=> array("irsaliyeleriDahilEt"=> "False"),
		     		"limit"=> 100,
		     		"offset"=> 0
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

		$outputString = '<table class="table"><tr></tr><th>No</th><th>Şirket Adı</th><th>Bakiye</th></tr>';
        foreach ($json["result"] as $key => $value) {
        	$outputString .= '<tr>';
        	$outputString .= '<td>'.$key.'</td>';
        	$outputString .= '<td>'.$value["unvan"].'</td>';
        	$outputString .= '<td>'.$value["bakiye"].'</td>';
        	$outputString .= '</tr>';
        }
        $outputString .= '</table>';

        return $outputString;

    }


}
?>