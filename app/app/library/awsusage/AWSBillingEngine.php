<?php
/**
 * Class and Function List:
 * Function list:
 * - init()
 * - request()
 * - register()
 * - authenticate()
 * - create_billing()
 * - getDeploymentStatus()
 * - Collection()
 *  * Classes list:
 * - AWSBillingEngine
 */
class AWSBillingEngine {
    private static $connection;
    private static $orchestrationParams;
  
    private static function init() 
    {
        self::$orchestrationParams = Config::get('awsusageanalyzr');
      
    }
    
    public static function request($url, $data) {
        Log::info((Auth::check() ? Auth::user()->username : json_encode($data)) . ' URL : ' . $url);
        $process = curl_init();
        curl_setopt($process, CURLOPT_URL, $url);
        curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($process, CURLOPT_SSL_VERIFYPEER, FALSE);
        //url-ify the data for the POST
        curl_setopt($process, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($process, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($process, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($process, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen(json_encode($data))
        ));
        $status = curl_exec($process);
        curl_close($process);
        
        return $status;
    }
    
    public static function register($data) {
        self::init();
        return self::request(self::$orchestrationParams['endpoint_ip'] . self::$orchestrationParams['register'], $data);
    }
    
    public static function authenticate($data) {
        self::init();
        return self::request(self::$orchestrationParams['endpoint_ip'] . self::$orchestrationParams['authenticate'], $data);
    }
    
    public static function create_billing($data) {
        self::init();
        return self::request(self::$orchestrationParams['endpoint_ip'] . self::$orchestrationParams['create_billing'], $data);
    }
    
    public static function getDeploymentStatus($data) {
        self::init();
        return self::request(self::$orchestrationParams['endpoint_ip'] . self::$orchestrationParams['getDeploymentStatus'] . '/' . $data['job_id'], $data);
    }
    
	public static function GetCurrentCost($data) {
        self::init();
        return self::request(self::$orchestrationParams['endpoint_ip'] . self::$orchestrationParams['GetCurrentCost'] . '/' . $data['job_id'], $data);
    }
	
	public static function Collection($data) {
        self::init();
        return self::request(self::$orchestrationParams['endpoint_ip'] . self::$orchestrationParams['Collection'] . '/' . $data['job_id'], $data);
    }
   
	
	public static function removeUsername($data) {
        self::init();
		Log::info('Debug :' . json_encode($data));
        return self::request(self::$orchestrationParams['endpoint_ip'] . self::$orchestrationParams['removeUsername'], $data);
    }
	
	///Following methods are helper for accessing the config variables
	public static function getTag($dockerName)
	{
		$settings = Config::get('docker_settings');
		return isset($settings[$dockerName]) ? $settings[$dockerName]['tags'] : '';
	}
	
}
