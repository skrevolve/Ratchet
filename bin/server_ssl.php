<?php
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

use MyModule\Message\Component;
use MyModule\MessageComponent;

require dirname(__DIR__).'/vendor/autoload.php';

// WebSocket server port number (웹소켓 서버 포트 번호)
// must Firewall TCP port is allowed below (반드시 Firewall 부분에서 아래의 TCP 포트가 허용되어야 한다)
$wsPort = 40999; //or else you want

// WebSocket server Operation mode (웹소켓 서버 구동모드)
// 'P' = Operating mode. Console message x (운영모드. 콘솔 메시지 출력 x)
// 'D' = Development mode. Console message o (개발모드. 콘솔 메시지 출력 o)
$wsMode = 'P';

// SSL certificate (SSL 인증서 설정)
$loop = React\EventLoop\Factory::create();
$webSock = new React\Socket\Server('0.0.0.0:'.$wsPort, $loop);
$webSock = new React\Socket\SecureServer($webSock, $loop, [
    'local_cert' => '/etc/httpd/SSL_test/www.test.co.kr/www.test.co.kr.crt', // Certificate file (인증서 파일)
    'local_pk' => '/etc/httpd/SSL_test/www.test.co.kr/www.test.co.kr.key', // Private Key file (비공개 키 파일)
    'allow_self_signed' => TRUE,
    'verify_peer' => FALSE
]);

$msgCom = new MessageComponent(); // Module start (모듈 실행)
$msgCom->setMode($wsMode);

$server = new IoServer(
    new HttpServer(
        new WsServer($msgCom)
    ),
    $webSock, // WebSocket Server Object assignment (웹소켓 서버 객체 설정)
    $loop // Event Loop Object assignment (이벤트 루프 객체 설정)
);
$server->run();
?>