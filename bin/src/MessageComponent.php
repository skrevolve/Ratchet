<?php
namespace MyModule; // Service name. like Java package name (서비스명 지정. Java의 패키지명과 같음)

use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;

class MessageComponent implements MessageComponentInterface {
    protected $runMode = 'P'; // P= Operating mode (운영모드), D= Development mode (개발모드)
    protected $clients;

    //Constructor (생성자)
    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    // Server Operation mode config (서버 구동 모드 설정)
    // 'P' = print log x ,'D' = print log o (모드에 따라 로그 출력 여부가 결정됨)
    public function setMode($mode) {
        $this->runMode = $mode;
    }

    // Called when a specific client creates a WebSocket object and tries to connect (특정 클라이언트가 웹소켓 객체를 생성하고 연결을 시도하면 호출 됨)
    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later (나중에 메시지를 보낼 새 연결 저장)
        $this->clients->attach($conn);
        $this->conlog("New connection ! ({$conn->resourceId})\\n");
    }

    // Called when a specific client transmits a message by broadcasting (특정 클라이언트가 메세지를 브로드캐스트 전송할 경우 호출 됨)
    public function onMessage(ConnectionInterface $from, $msg) {
        $numRecv = count($this->clients) - 1;
        $this->conlog(sprintf('Connection $d sending message "%s" to $d other connection%s'."\n",
        $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's'));
        
        foreach ($this->clients as $client) {
            if ($from !== $client) {
                // The sender is not the receiver, send to each client connected
                $client->send($msg); // (보낸사람은 수신자가아니므로 연결된 각 클라이언트로 전송. 자기 자신은 제외)
            }
        }
    }

    // Called when a specific client closes a websocket (특정 클라이언트가 웹소켓을 닫을때 호출 됨)
    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);
        $this->conlog("Connection {$conn->resourceId} has disconnected\n");
    }

    // Called when an error occurs during web socket communication (웹 소켓 통신 시 오류가 발생하면 호출됨)
    public function onError(ConnectionInterface $conn, \Exception $e) {
        $this->conlog("An error has occurred: {$e->getMessage()}\n");
        $conn->close();
    }

    // Output logs according to server operation mode (서버 구동모드에 따라 로그를 출력)
    private function conlog($msg) {
        if ($this->runMode == 'D') {
            echo $msg;
        }
    }
}
?>