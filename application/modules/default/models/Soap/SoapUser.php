<?php

class SoapUser {
	private $email = null;
	private $password = null;
	
	
	/**
	 * 构造函数
	 * @param string $email
	 * @param string $password
	 */
	public function __construct($email, $password) {
		$this->email = $email;
		$this->password = $password;
	}

} //End: class SoapUser