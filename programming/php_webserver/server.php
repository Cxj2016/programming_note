<?php
//http建立在tcp的基础上，这里使用socket
//客户端使用浏览器。这里浏览器发起的是http请求，需要处理http请求报文。并返回响应报文。

class server
{
	const WEB_ROOT = "/Users/chenxj/personal_interest/githubs/programming/php_webserver/";
	private $ip;
	private $port;

	public function __construct( $ip, $port )
	{
		$this->ip   = $ip;
		$this->port = $port;

		$this->handle();
	}

	/**
	 * 接收并处理客户端连接
	 * create
	 * bind
	 * listen
	 * accept
	 */
	private function handle()
	{
		//创建套接字
		$socket = socket_create( AF_INET, SOCK_STREAM, SOL_TCP );
		if ( ! $socket ) {
			echo "CREATE FAILED:" . socket_strerror( socket_last_error() ) . "\n";
			exit;
		}

		//套接字绑定ip地址和端口号
		$res = socket_bind( $socket, $this->ip, $this->port );
		if ( ! $res ) {
			echo "BIND FAILED:" . socket_strerror( socket_last_error() ) . "\n";
			exit;
		}
		echo "START SUCCESSFULLY!\n";

		//套接字监听
		$res = socket_listen( $socket );
		if ( $res < 0 ) {
			echo "LISTEN FAILED:" . socket_strerror( socket_last_error() ) . "\n";
		}

		//监听客户端连接
		do {
			$client = null;
			try {
				$client = socket_accept( $socket );
			} catch ( Exception $e ) {
				echo $e->getMessage();
				echo "ACCEPT FAILED:" . socket_strerror( socket_last_error() ) . "\n";
			}
			try {
				$request_string = socket_read( $client, 1024 ); //接收客户端提交的报文
				$response       = $this->response( $request_string );  //处理报文
				socket_write( $client, $response ); //响应报文
				socket_close( $client );
			} catch ( Exception $e ) {
				echo $e->getMessage();
				echo "READ FAILED:" . socket_strerror( socket_last_error() ) . "\n";
			}
		} while ( true );
	}

	/**
	 * @param $request_message
	 *
	 * @return string
	 */
	private function response( $request_message )
	{
		//处理请求报文,解析出uri
		$request_arr = explode( " ", $request_message );//请求报文的请求头格式为: 请求方式<空格>URI<空格>HTTP版本号
		if ( count( $request_arr ) < 2 ) {
			return $this->output( 400, 'ERROR OCCURRED' );
		}

		//$method = request_arr[0];//请求方式，本例子只处理GET请求。其他请求方式同理
		$uri = $request_arr[1];
		echo "request uri is :" . $uri . "\n";

		if ( "/" == $uri ) {
			return $this->output( 200, 'OK', "welcome~" );
		}
		if ( "/favicon.ico" == $uri ) {
			return '';
		}

		//处理查询字符串,区别是静态请求还是动态请求。静态请求直接读取文件，并返回内容。动态请求则交由cgi程序处理
		if ( strpos( $uri, 'cgi' ) || strpos( $uri, 'php' ) ) {//是动态请求 或者是php、python等文件结尾的文件,这里只处理cgi(二进制)和php(脚本程序)
			if ( strpos( $uri, "?" ) ) {//有参数则传递给cig程序处理，否则直接访问进程数据
				$uri_arr      = explode( "?", $uri );
				$uri          = $uri_arr[0];
				$query_string = isset( $uri_arr[1] ) ? $uri_arr[1] : '';//eg: id=1&name=xijian.chen
				$this->set_env( $query_string );
			}

			$handle  = popen( self::WEB_ROOT . '/cgi' . $uri, 'r' );//打开进程文件指针
			$content = stream_get_contents( $handle );
			pclose( $handle ); //关闭文件指针

			return $this->output( 200, 'OK', $content );
		} else {//静态请求,即处理静态文件
			$file_name = self::WEB_ROOT . 'html/' . $uri;
			echo "request file is: $file_name \n";
			if ( file_exists( $file_name ) ) {
				return $this->output( 200, 'OK', file_get_contents( $file_name ) );
			} else {
				return $this->output( 404, 'FILE NOT EXIST' );
			}
		}
	}


	/**
	 * * 返回响应报文  HTTP版本/内容类型/内容长度等
	 *
	 * @param        $error_code -状态码
	 * @param        $content -内容
	 * @param string $content
	 *
	 * @return string
	 */
	private function output( $error_code, $error_msg, $content = '' )
	{
		return "HTTP/1.1 $error_code $error_msg\r\nContent-Type: text/html\r\nContent-Length: " . strlen( $content ) . "\r\n\r\n" . $content;
	}

	/**
	 *
	 *
	 * @param $string
	 *
	 * @return string
	 */
	private function add_header( $string )
	{
		return "HTTP/1.1 200 OK\r\nContent-Length: " . strlen( $string ) . "\r\nServer: xijian.chen\r\n\r\n" . $string;
	}

	/**
	 * 设置环境变量,传递给cgi程序。
	 *
	 * @param $query_string
	 *
	 * @return bool
	 */
	private function set_env( $query_string )
	{
		if ( ! $query_string ) {
			return '';
		}

		if ( strpos( $query_string, "=" ) ) {
			putenv( "QUERY_STRING=" . $query_string );
		}
	}
}

$ip   = "127.0.0.1";
$port = 6688;
new server( $ip, $port );




