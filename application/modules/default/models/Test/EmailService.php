<?php
class EmailService extends Zend_Mail_Storage_Imap
{
	public $unseenEmailsCnt;
	
	public function __construct($params) {
		//print_r($params);
    	parent::__construct($params);
    }
    
    
    //获取未读邮件ids
    public function getUnseenEmailIds() {
    	$unseenEmailIds = $this->_protocol->search(array('UNSEEN'));
    	$this->unseenEmailsCnt = count($unseenEmailIds);
    	return $unseenEmailIds;
    }
    
    
    //设置邮件id为$ueId的邮件状态为未读
    public function setUnseen($ueId) {
    	$this->_protocol->store(array('\Seen'), $ueId, null, '-', false);
    }
    
    
    //设置邮件id为$ueId的邮件状态为已读
	public function setSeen($ueId) {
    	$this->_protocol->store(array('\Seen'), $ueId, null, '+', false);
    }
    
    
    //设置邮件id为$ueId的邮件状态为标记（旗帜）
    public function setFlagged($ueId) {
    	$this->_protocol->store(array('\Flagged'), $ueId, null, '+', false);
    }
    
    
    //解码，根据编码类型
    static function decode_content($encoding, $content) {
    	$encoding = strtolower($encoding);
    	switch ($encoding) {
    		case 'quoted-printable':
    			$content = quoted_printable_decode($content);
    			break;
    		case 'base64':
    			$content = base64_decode($content);
    			break;    		
    		default: return $content;
    	}
    	return $content;
    }
    
    
    //解析出编码类型，$string如：
	//$string = '=?UTF-8?B?' . base64_encode('some string') . '?=';
	//用于解析附件内容或邮件正文
    static function parse_charset($string) {
    	$pos = strpos($string,'=?');
		if (!is_int($pos)) 
			return $string;
		$preceding = substr($string, 0, $pos); // save any preceding text
		$search = substr($string, $pos+2); /* the mime header spec says this is the longest a single encoded word can be */
		$d1 = strpos($search, '?');
		if (!is_int($d1)) 
			return $string;
		$charset = substr($string, $pos+2, $d1); //取出字符集的定义部分
		return $charset;
    }
    
    
    //解码，编码类型为mime
    //用于解析邮件标题、收发件人、附件名等
	static function decode_mime($string, $toCharset='UTF-8') {	
		$pos = strpos($string,'=?');
		if (!is_int($pos)) {
			return $string;
		}
		$preceding = substr($string, 0, $pos); // save any preceding text
		$search = substr($string, $pos+2); /* the mime header spec says this is the longest a single encoded word can be */
		$d1 = strpos($search, '?');
		if (!is_int($d1)) {
			return $string;
		}
		$charset = substr($string, $pos+2, $d1); //取出字符集的定义部分
		$charset = str_replace('ks_c_5601-1987', 'euc-kr', $charset);
		$search = substr($search, $d1+1); //字符集定义以后的部分＝>$search;
		$d2 = strpos($search, '?');
		if (!is_int($d2)) 
			return $string;
		$encoding = substr($search, 0, $d2); ////两个?　之间的部分编码方式　：ｑ　或　ｂ
		$search = substr($search, $d2+1);
		$end = strpos($search, '?='); //$d2+1 与 $end 之间是编码了的内容：=> $endcoded_text;
		if (!is_int($end))
			return $string;
		$encoded_text = substr($search, 0, $end);
		$rest = substr($string, (strlen($preceding . $charset . $encoding . $encoded_text)+6)); //+6 是前面去掉的　"=? ? ? ?="(不包括 中间的空格)　六个字符
		switch ($encoding) {
			case 'Q':
			case 'q':			
				$decoded = quoted_printable_decode($encoded_text);
				if (strtolower($charset) == 'windows-1251') {
					$decoded = convert_cyr_string($decoded, 'w', 'k');
				}
				//if($toCharset) $decoded =iconv($charset, $toCharset, $decoded);
				if($toCharset) $decoded = mb_convert_encoding($decoded,$toCharset,$charset);
				break;
			case 'B':
			case 'b':
				$decoded = base64_decode($encoded_text);
				if (strtolower($charset) == 'windows-1251') {
					$decoded = convert_cyr_string($decoded, 'w', 'k');
				}
				//if($toCharset) $decoded = iconv($charset, $toCharset, $decoded);
				if($toCharset) {
					$decoded = mb_convert_encoding($decoded,$toCharset,$charset);
				}
				break;
			default: $decoded = '=?' . $charset . '?' . $encoding . '?' . $encoded_text . '?=';
		}
		return $preceding . $decoded . self::decode_mime($rest, $toCharset);
	}
	
	
	
} //End: class EmailModel extends Zend_Mail_Storage_Imap
