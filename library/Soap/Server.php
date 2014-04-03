<?php
class Soap_Server {
	/**
	 * PHPDoc注释是必须的，否则，输入与输出在wsdl文件里得不到反应，自然会出错。
	 * @return string
	 */
	public function hello() {
		return 'Hello World';
	}
}