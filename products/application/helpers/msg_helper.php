<?php defined('BASEPATH') OR exit('No direct script access allowed.');
if (! function_exists ( 'DateInterval' )) {
	function DateInterval($dateii, $userType){
	    $CI = & get_instance();  //get instance, access the CI superobject
	    $CI->load->library('session');
	    $msg = "";
		$datetime1 = date_create ( $dateii );
		$datetime2 = date_create ( date ( 'Y-m-d' ) );
		$interval = $datetime2->diff ( $datetime1 )->format ( "%a" );
		//echo $interval; die;
		//$interval=30;
		$SingleUserInterval = $CI->config->item('SingleUserInterval');
		$InstitutionalUserInterval = $CI->config->item('InstitutionalUserInterval');
			if ($userType == 'SINGLE' && $interval==$SingleUserInterval) {
				$msg = 'Your license will expire on '. $dateii .'<a href='. base_url () .'>Renew now <a>.';
				return $msg;
			}else if($userType == 'MULTI' && $interval==$InstitutionalUserInterval){ 
				 $msg = 'Your institutions license will expire on license '. $dateii .'.Please contact ASCE Customer Service at <a href="mailto:ascelibrary@asce.org">ascelibrary@asce.org</a> or call 1.800.548.2723 to renew now.';
				 return $msg;
			}else if($userType == 'IPBASED' && $interval==$InstitutionalUserInterval){
			$msg = 'Your institutions license will expire on license '. $dateii .'.Please contact ASCE Customer Service at <a href="mailto:ascelibrary@asce.org">ascelibrary@asce.org</a> or call 1.800.548.2723 to renew now.';
				 return $msg;
			}else if($interval==0){
			 $msg = 'Your license has expired but you are in a grace period. Please contact ASCE Customer Service at ascelibrary@asce.org or call 1.800.548.2723 to renew now.';
			 return $msg;
			}
		
	}
}

?>
