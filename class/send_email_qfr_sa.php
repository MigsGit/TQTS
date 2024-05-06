<?php 
//EMAIL NOTIF INTENTED TO SPECIAL ACCEPTANCE REPORT ONLY 
class email {
	function send_email($to, $from, $cc, $subject, $message) {
		$common_function = '../handler/common_function.php';
		if(file_exists($common_function)){
			require_once($common_function);
		}else{
			return "Common function not found";
		}
		$return 	= array();
		$mail_data  = array();
		$message .= "<br><br>
					 For more info, please log-in to your Rapid account. Go to http://rapid/ and click http://rapid/TQTS_TS/index.php?page=iqc# TQTS Version 2 under Special Acceptance 
					 <br><br>Notice of Disclaimer:<br>
                     This message (including any attachments) contains confidential information intended for a specific individual and purpose, and is protected by law. If you are not the intended recipient, you should delete this message. Any disclosure,copying, or distribution of this message, or the taking of any action based on it, is strictly prohibited.";
		$mail_data  = array(
			"`to`"				=> $to,
			"cc"				=> $cc,
			// "`to`"				=> 'rdfernandez@pricon.ph',
			// "cc"				=> 'rdfernandez@pricon.ph',
			"bcc"				=> 'mclegaspi@pricon.ph',
			"`from`"			=> $from,
			"from_name"			=> 'TQTSystemNotification@pricon.ph',
			"subject"			=> $subject,
			"message"			=> $message,
			"send_date_time"	=> date('Y-m-d H:i:s'),
			"system_name"		=> 'TQTS',
			"username"			=> $from
		);
		$mail_result = send_with_mailer($mail_data);
		// $mail_result = send_with_auto_mailer($mail_data);
		$return['mail_result'] 		= $mail_result;
		$return['mail_data'] 		= $mail_data;
		return $return;
	}
	
	function send_email_with_attachment($to, $from, $cc, $subject, $message, $attachment_filename, $attachment) {
		/* 
			NOTE: PLEASE READ!!
			Attachment should be delimited by comma
			Example: 
			TQTS_edited/uploaded_file/test_file.jpg,TQTS_edited/uploaded_file/test_file_2.jpg
		*/
		$common_function = '../handler/common_function.php';
		if(file_exists($common_function)){
			require_once($common_function);
		}else{
			return "Common function not found";
		}
		
		// if(trim($from) == 'delaman@pricon.ph') {
			// $from_name = 'Dell Amandoron';
		// } else {
			$from_name = get_emp_name_by_email_add_systemone($from);
		// }
		
		$return 	= array();
		$mail_data  = array();
		$message .= "<br><br>
					 For more info, please log-in to your Rapid account. Go to http://rapid/ and click http://rapid/ TQTS Version 2 under Special Acceptance 
					 <br><br>Notice of Disclaimer:<br>
                     This message (including any attachments) contains confidential information intended for a specific individual and purpose, and is protected by law. If you are not the intended recipient, you should delete this message. Any disclosure,copying, or distribution of this message, or the taking of any action based on it, is strictly prohibited.";
		$mail_data  = array(
			"`to`"					=> $to,
			"cc"					=> $cc,
			// "`to`"				=> 'rdfernandez@pricon.ph',
			// "cc"					=> 'rdfernandez@pricon.ph',
			"bcc"					=> 'mclegaspi@pricon.ph,'.$from,
			// "bcc"					=> 'mclegaspi@pricon.ph,',
			"`from`"				=> $from,
			"from_name"				=> $from_name,
			"subject"				=> $subject,
			"message"				=> $message,
			"send_date_time"		=> date('Y-m-d H:i:s'),
			"system_name"			=> 'TQTS',
			"attachment_filename" 	=> $attachment_filename, 
			"attachment" 			=> $attachment, 
			"username"				=> $from
		);
		$mail_result = send_with_mailer_with_attachment($mail_data);
		$return['mail_result'] 		= $mail_result;
		$return['mail_data'] 		= $mail_data;
		return $return;
	}
	
	function send_email_detailed($to, $from, $from_name, $cc, $bcc, $subject, $message, $send_date_time, $username) {
		$common_function = '../handler/common_function.php';
		if(file_exists($common_function)){
			require_once($common_function);
		}else{
			return "Common function not found";
		}
		$return 	= array();
		$mail_data  = array();
		$message .= "<br><br>
					 For more info, please log-in to your Rapid account. Go to http://rapid/ and click http://rapid/TQTS_TS/index.php?page=iqc# TQTS Version 2 under Special Acceptance 
					 <br><br>Notice of Disclaimer:<br>
                     This message (including any attachments) contains confidential information intended for a specific individual and purpose, and is protected by law. If you are not the intended recipient, you should delete this message. Any disclosure,copying, or distribution of this message, or the taking of any action based on it, is strictly prohibited.";
		$mail_data  = array(
			"`to`"				=> $to,
			"cc"				=> $cc,
			"bcc"				=> $bcc,
			"`from`"			=> $from,
			"from_name"			=> 'TQTSystemNotification@pricon.ph',
			"subject"			=> $subject,
			"message"			=> $message,
			"send_date_time"	=> $send_date_time,
			"system_name"		=> 'TQTS',
			"username"			=> $username
		);
		$mail_result = send_with_mailer($mail_data);
		$return['mail_result'] 		= $mail_result;
		$return['mail_data'] 		= $mail_data;
		return $return;
	}
	
	function send_scheduled_email($tbl_name, $fkid, $to, $from, $cc, $subject, $message , $date_start, $frequency) {
		$common_function = '../handler/common_function.php';
		if(file_exists($common_function)){
			require_once($common_function);
		}else{
			return "Common function not found";
		}
		$return 	= array();
		$mail_data  = array();
		$message .= "<br><br>
					 For more info, please log-in to your Rapid account. Go to http://rapid/ and click http://rapid/TQTS_TS/index.php?page=iqc# TQTS Version 2 under Special Acceptance 
					 <br><br>Notice of Disclaimer:<br>
                     This message (including any attachments) contains confidential information intended for a specific individual and purpose, and is protected by law. If you are not the intended recipient, you should delete this message. Any disclosure,copying, or distribution of this message, or the taking of any action based on it, is strictly prohibited.";
		$mail_data  = array(
			"`table_name`"			=> $tbl_name,
			"`fkid`"				=> $fkid,
			"`to`"					=> $to,
			"cc"					=> $cc,
			"bcc"					=> 'mclegaspi@pricon.ph',
			"`from`"				=> $from,
			"from_name"				=> 'TQTSystemNotification@pricon.ph',
			"subject"				=> $subject,
			"date_start"			=> $date_start,
			"message"				=> $message,
			"frequency"				=> $frequency,
			"system_name"			=> 'TQTS',
			"created_by"			=> $from
		);
		$mail_result = send_with_auto_mailer($mail_data);
		$return['mail_result'] 		= $mail_result;
		$return['mail_data'] 		= $mail_data;
		return $return;
	}
	
	function send_scheduled_email_with_attachment($tbl_name, $fkid, $to, $from, $cc, $subject, $message, $attachment_filename, $attachment, $date_start, $frequency) {
		$common_function = '../handler/common_function.php';
		if(file_exists($common_function)){
			require_once($common_function);
		}else{
			return "Common function not found";
		}
		$return 	= array();
		$mail_data  = array();
		$message .= "<br><br>
					 For more info, please log-in to your Rapid account. Go to http://rapid/ and click http://rapid/TQTS_TS/index.php?page=iqc# TQTS Version 2 under Special Acceptance 
					 <br><br>Notice of Disclaimer:<br>
                     This message (including any attachments) contains confidential information intended for a specific individual and purpose, and is protected by law. If you are not the intended recipient, you should delete this message. Any disclosure,copying, or distribution of this message, or the taking of any action based on it, is strictly prohibited.";
		$mail_data  = array(
			"`table_name`"			=> $tbl_name,
			"`fkid`"				=> $fkid,
			"`to`"					=> $to,
			"cc"					=> $cc,
			"bcc"					=> 'mclegaspi@pricon.ph',
			"`from`"				=> $from,
			"from_name"				=> 'TQTSystemNotification@pricon.ph',
			"subject"				=> $subject,
			"date_start"			=> $date_start,
			"message"				=> $message,
			"frequency"				=> $frequency,
			"system_name"			=> 'TQTS',
			"attachment_filename" 	=> $attachment_filename, 
			"attachment" 			=> $attachment, 
			"created_by"			=> $from
		);
		$mail_result = send_with_auto_mailer($mail_data);
		$return['mail_result'] 		= $mail_result;
		$return['mail_data'] 		= $mail_data;
		return $return;
	}
}
?>