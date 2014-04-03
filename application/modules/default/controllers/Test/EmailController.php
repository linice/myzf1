<?php
include_once 'Test/EmailService.php';


class Test_EmailController extends Zend_Controller_Action {
	public function init() {
	}
	
	
	//Test email
	public function indexAction() {
		set_time_limit(0);
		ini_set('memory_limit', '-1');
		$this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		
//		$config = array('auth' => 'login',
//			'username' => 'linice01',
//			'password' => 'SunShine10'
//		);
		$config = array('auth' => 'login',
			'username' => 'linice01',
			'password' => '********'
			/*'username' => 'ljxie@suntekstore.ca',
			'password' => 'GoodLife10',
			'ssl' => 'ssl'
			*/
		);
		//gmail: smtp.gmail.com
		//163 mail: smtp.163.com
		$transport = new Zend_Mail_Transport_Smtp('smtp.163.com', $config);
		$mail = new Zend_Mail('UTF-8');
		//这一句，可以替代$mail->send($transport);的参数
		//Zend_Mail::setDefaultTransport($transport);
		$mail->setBodyHtml('This is the html content of the mail.');
//		$mail->setFrom('linice01@163.com', 'linice01');
		$mail->setFrom('linice01@163.com', null);
//		$mail->addTo('linice01@163.com', 'los@163.com');
//		$mail->addTo('51220269@qq.com', null);
		$receiver = '"linice" <51220269@qq.com>';
//		$receiver = 'auction_cs06@suntekstore.com';
//		echo strpos($receiver, '<');
		if (strpos($receiver, '<') !== false) {
			$receiver = substr($receiver, strpos($receiver, '<') + 1, - 1);
		}
//		var_dump($receiver);
//		exit;
		$mail->addTo($receiver, null);
		$mail->setSubject('TestSubject');
//		$file = file_get_contents('D:/CurrentWork/中文名文件.docx');
		$file = file_get_contents('D:/CurrentWork/js.js');
//		$at = new Zend_Mime_Part($file);
//		$at->type        = 'application/octet-stream';
//		$at->disposition = Zend_Mime::DISPOSITION_ATTACHMENT;
//		$at->encoding    = Zend_Mime::ENCODING_BASE64;
//		$at->filename    = 'js.js';
//		$mail->addAttachment($at);
		$mail->createAttachment($file, 'application/octet-stream', 
			Zend_Mime::DISPOSITION_ATTACHMENT, Zend_Mime::ENCODING_BASE64,
			'by createAttachment js.js');
		try {
			$mail->send($transport);
			echo 'Send email success.';
		} catch (Exception $e) {
//			echo 'Send email error.';
			echo $e->getMessage();
		}
	}
	
	
	//下载邮件
	public function downloademailsAction() {
    	$this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		
    	$params = array();
    	$params['host'] = 'imap.163.com';
    	$params['user'] = 'linice01@163.com';
    	$params['password'] = '*********';
   		$params['port'] = '993';
    	$params['ssl'] = 'SSL';
    	
    	$msi = new EmailService($params);
    	$unseenEmailIds = $msi->getUnseenEmailIds();
//    	var_dump($unseenEmailIds);
//    	exit;
    	
		foreach($unseenEmailIds as $ueId) {
	    	try {
//	    		$msi->setFlagged($ueId);
//	    		exit;
	            $row = array();
	            $email = $msi->getMessage($ueId);
//				var_dump($email);
//				exit;
	            //如果已经查看过，则读下一封邮件
	            if ($email->hasFlag('\Seen'))
	            	continue;
	            $row['subject'] = $email->headerExists('subject') ? EmailService::decode_mime($email->subject) : '';
	            if (isset($email->from)) {
	            	$row['from'] = EmailService::decode_mime($email->from);
	            } else if (isset($email->returnPath)){
	            	$row['from'] = is_array($email->returnPath) ? array_pop($email->returnPath) : $email->returnPath;
	            } else {
	            	$row['from'] = '（未知发件人）';	
	            }
	            $row['to'] = isset($email->to) ? EmailService::decode_mime($email->to) : 'linice01@163.com';
	            $row['send_time'] = date('Y-m-d H:i:s', isset($email->date) ? strtotime($email->date) : time());
	            $row['body_html'] = '';
                $row['attachment'] = '';
                $body_plain = '';
	            $attachList = array();
				if ($email->isMultipart()) {
//					echo '$email->isMultipart()';
//					exit;
	                $savePath = 'D:/CurrentWork/email/'.date('Ymd');
    				if (!file_exists($savePath)) {
    					@mkdir($savePath, 0755, true);
    				}
    				$i = 1;
					foreach (new RecursiveIteratorIterator($email) as $part) {
	                	//var_dump($part);
	                	//附件
	                	if ($part->headerExists('Content-Disposition') && $part->contentDisposition != 'inline') {
//	                		var_dump('not inline');
//	                    	exit;
	                		if (preg_match('/attachment;\s*filename=["\']*([^"\']+)["\']*/i', $part->contentDisposition, $fileResult1)) {
	                			$fileName = EmailService::decode_mime($fileResult1[1]);
	                		} else if ($part->headerExists('Content-Type') && preg_match('/name=["\']*([^"\']+)["\']*/i', $part->contentType, $fileResult2)) {
	                			$fileName = EmailService::decode_mime($fileResult2[1]);
	                		} else {
	                			$fileName = 'attachment';
	                		}
	                		$fileExt = substr($fileName, strrpos($fileName, '.')); //包括小数点
                            $attachFullname = $savePath . '/' . $ueId . '_' . $i . $fileExt;
                            $attach = array('name'=>$fileName, 'path'=>$attachFullname);
                            $attachList[$ueId] = $attach;
                            $handle = fopen($attachFullname, 'wb');
                            if ($part->headerExists('Content-Transfer-Encoding')){
                                $part = EmailService::decode_content($part->contentTransferEncoding, $part);
                            }
                            fwrite($handle, $part);
                            fclose($handle);
                            $i++;
	                    //} else if (preg_match('/text\/([\w]+);\s*charset=["\']*([-\w]+)["\']*/i', $part->contentType, $parseResult)) {
	                    } else { //正文
//	                    	var_dump('inline');
//	                    	exit;
	                    	$partContent = $part->getContent();
	                    	if ($part->headerExists('Content-Transfer-Encoding')) {
	                            $partContent = EmailService::decode_content($part->contentTransferEncoding, $partContent);
	                        }
	                    	if ($part->headerExists('Content-Type')) {
			                    preg_match('/charset=[\'"]*([-\w]+)[\'"]*/i', $part->contentType, $parseResult);
			                    $charset = isset($parseResult[1]) ? $parseResult[1] : 'ISO-8859-1';
			                    if (strtoupper($charset) != 'UTF-8') {
			                    	$partContent = mb_convert_encoding($partContent, 'UTF-8', $charset);
			                    }
			                	preg_match('/text\/([\w]+);*/i', $part->contentType, $parseType);
	                    		$type = strtolower(isset($parseType[1]) ? $parseType[1] : 'html');
	                    		if ($type == 'html') {
	                    			$row['body_html'] .= $partContent;
	                    		} else {
	                    			$body_plain .= $partContent;
	                    		}
	                    	} else {
	                    		$row['body_html'] .= $partContent;
	                    	}
	                    } //End: if ($part->headerExists('Content-Disposition') && $part->contentDisposition != 'inline')
	                } //End: foreach (new RecursiveIteratorIterator($email) as $part)
	                if (!empty($attachList)) {
	                	$row['attachment'] = json_encode($attachList);
	                }
	            } else { //if ($email->isMultipart())
	                $content = $email->getContent();
	                if ($email->headerExists('Content-Transfer-Encoding')) {
	                    $content = EmailService::decode_content($email->contentTransferEncoding, $content);
	                }
	                if ($email->headerExists('Content-Type')) {
	                    preg_match('/charset=[\'"]*([-\w]+)[\'"]*/i', $email->contentType, $parseResult);
	                    $charset = isset($parseResult[1]) ? $parseResult[1] : 'ISO-8859-1';
	                } else {
	                    $charset = EmailService::parse_charset($email->subject);
	                }
	                if (strtoupper($charset) == 'UTF-8') {
	                	$row['body_html'] = $content;
	                } else {
	                	$row['body_html'] = mb_convert_encoding($content, 'UTF-8', $charset);
	                }
	            } //End: if ($email->isMultipart())
	            
	            if (!$row['body_html']) {
	            	$row['body_html'] = $body_plain;
	            }
	            if (empty($attachList) && !$row['body_html']) {
	            	throw new Exception('content is empty'); 
	            }
				var_dump($row);
				$msi->setUnseen($ueId);
	    	} catch (Exception $ex) {
	        	if ($msi){
	        		$msi->setUnseen($ueId);
					$msi->setFlagged($ueId);
				} else{
					$msi = new EmailService($params);
					$msi->setUnseen($ueId);
					$msi->setFlagged($ueId);
				}
//				$ret = array('error' => 1, 'msg' => '\r'.date('Y-m-d H:i:s').' '.$ex->getMessage());
				echo "\r".date('Y-m-d H:i:s').' '.$ex->getMessage(); @ob_flush();@flush();
				echo "\r".date('Y-m-d H:i:s').' '.$ex->__toString(); @ob_flush();@flush();
				
				if ($ex->getCode() == 2006) {
//					$breakAll = true;
					$ret = array('error' => 1, 'msg' => $ex->getMessage());
					exit(json_encode($ret));
				}
        	}
        } //End: foreach($unseenEmailIds as $ueId)
    } //End: downloademailsAction
    
    
    
    
    
} //End: class Test_EmailController