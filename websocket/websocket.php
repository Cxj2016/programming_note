<?php

class Websocket
{
    public $log;
    public $event;
    public $sockets;
    public $users;
    public $master;

    public function __construct($config)
    {
        if (strtolower(substr(php_sapi_name(), 0, 3)) !== "cli") {
            die("请通过命令行运行");
        }

        error_reporting(E_ALL);
        set_time_limit(0);
        ob_implicit_flush();

        $this->event = $config['event'];
        $this->log = $config['log'];
        $this->master = $this->webSocket($config['address'], $config['port']);
        $this->sockets = array('s' => $this->master);
    }

    //返回服务端套接字
    function webSocket($address, $port)
    {
        $server_socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        socket_set_option($server_socket, SOL_SOCKET, SO_REUSEADDR, 1);
        socket_bind($server_socket, $address, $port);
        socket_listen($server_socket);
        $this->log("开始监听---" . $address . ":" . $port);
        return $server_socket;
    }

    //运行
    function run()
    {
        while (TRUE) {
            $changes = $this->sockets;
            @socket_select($changes, $write = null, $except = null, null);
            foreach ($changes AS $sign) {
                if ($sign == $this->master) {
                    $client = socket_accept($this->master);
                    $this->sockets[] = $client;
                    $user = array('socket' => $client, 'hand' => false);
                    $this->users[] = $user;
                    $key = $this->search($client);
                    $event_return = array('k' => $key, 'sign' => $sign);
                    $this->event_output('in', $event_return);
                } else {
                    $len = socket_recv($sign, $buffer, 2048, 0);
                    $k = $this->search($sign);
//                    $user = $this->users[$k];
                    if ($len < 7) {
                        $this->close($sign);
                        $event_return = array('k' => $k, 'sign' => $sign);
                        $this->event_output('out', $event_return);
                        continue;
                    }
                    if (!$this->users[$k]['hand']) {//没有握手，进行握手
                        $this->handshake($k, $buffer);
                    } else {
                        $buffer = $this->uncode($buffer);
                        $event_return = array('k' => $k, 'sign' => $sign, 'msg' => $buffer);
                        $this->event_output('msg', $event_return);
                    }
                }
            }
        }
    }

    function search($sign)
    {//通过标识遍历获取id
        foreach ($this->users AS $key => $value) {
            if ($sign == $value['socket']) {
                return $key;
            }
        }
        return false;
    }

    function close($sign)
    {
        $k = array_search($sign, $this->sockets);
        socket_close($sign);

        unset($this->sockets[$k]);
        unset($this->users[$k]);
    }

    function handshake($k, $buffer)
    {
        $buf = substr($buffer, strpos($buffer, 'Sec-WebSocket-Key:') + 18);
        $key = trim(substr($buf, 0, strpos($buf, "\r\n")));
        $new_key = base64_encode(sha1($key . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11', true));
        $new_message = "HTTP/1.1 101 Switching Protocols\r\n";
        $new_message .= "Upgrade: websocket\r\n";
        $new_message .= "Sec-WebSocket-Version: 13\r\n";
        $new_message .= "Connection: Upgrade\r\n";
        $new_message .= "Sec-WebSocket-Accept: " . $new_key . "\r\n\r\n";

        socket_write($this->users[$k]['socket'], $new_message, strlen($new_message));
        $this->users[$k]['hand'] = true;
        return true;
    }

    function uncode($str)
    {
        $mask = array();
        $data = '';
        $msg = unpack('H*', $str);
        $head = substr($msg[1], 0, 2);
        if (hexdec($head{1}) === 8) {
            $data = false;
        } else if (hexdec($head{1}) === 1) {
            $mask[] = hexdec(substr($msg[1], 4, 2));
            $mask[] = hexdec(substr($msg[1], 6, 2));
            $mask[] = hexdec(substr($msg[1], 8, 2));
            $mask[] = hexdec(substr($msg[1], 10, 2));
            $s = 12;
            $e = strlen($msg[1]) - 2;
            $n = 0;
            for ($i = $s; $i <= $e; $i += 2) {
                $data .= chr($mask[$n % 4] ^ hexdec(substr($msg[1], $i, 2)));
                $n++;
            }
        }
        return $data;
    }

    function code($msg)
    {
        $msg = preg_replace(array('/\r$/', '/\n$/', '/\r\n$/',), '', $msg);
        $frame = array();
        $frame[0] = '81';
        $len = strlen($msg);
        $frame[1] = $len < 16 ? '0' . dechex($len) : dechex($len);
        $frame[2] = $this->ord_hex($msg);
        $data = implode('', $frame);
        return pack("H*", $data);
    }

    function ord_hex($data)
    {
        $msg = '';
        $l = strlen($data);
        for ($i = 0; $i < $l; $i++) {
            $msg .= dechex(ord($data{$i}));
        }
        return $msg;
    }

    function idwrite($id, $t)
    {//通过id推送
        if (!$this->users[$id]['socket']) {
            return false;
        }
        $t = $this->code($t);

        return socket_write($this->users[$id]['socket'], $t, strlen($t));
    }

    function write($k, $t)
    {
        $t = $this->code($t);
        return socket_write($k, $t, strlen($t));
    }


    //事件回调
    function event_output($type, $event)
    {
        call_user_func($this->event, $type, $event);
    }

    function log($str)
    {
        if ($this->log) {
            $str = $str . "\r\n";
            fwrite(STDOUT, $str);
        }
    }
}