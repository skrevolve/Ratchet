<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatting page</title>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
</head>
<body id="chatting">
    <div class="wrapper">
        <div class="chatting_con">
            <ul id="chat_output">
            <!-- chatting output -->
            </ul>
        </div>
        <textarea id="chat_input" placeholder="입력하세요"></textarea>
    </div>
    <script>
        $(function(){
            let conn = new WebSocket("wss://test.co.kr:40999/");

            conn.onopen = function(e) {
                conn.send(
                    JSON.stringify({
                        'type':'socket',
                        'usr_name':'<?php echo $_SESSION['usr_name'];?>'
                    })
                );
            }

            conn.onmessage = function(e) {
                let json = JSON.parse(e.data);
                switch(json.type){
                    case 'chat':
                        let output = "";
                        output += "<li>";
                        output += "<span>"+json.usr_name+"</span>'";
                        output += "<span>"+json.chat_msg+"</span>";
                        output += "</li>";
                        $('#chat_output').append(output);
                        $('#chat_input').val("");
                    break;
                }
            }

            $('#chat_input').on('keyup', function(e){
                if(e.keyCode==13 && !e.shiftKey){
                    let chat_msg = $(this).val();
                    conn.send(
                        JSON.stringify({
                            'type':'chat',
                            'usr_name':'<?php echo $_SESSION['usr_name'];?>',
                            'chat_msg':chat_msg
                        })
                    );
                    let output = "";
                    output += "<li>";
                    output += "<span>"+json.usr_name+"</span>'";
                    output += "<span>"+json.chat_msg+"</span>";
                    output += "</li>";
                    $('#chat_output').append(output);
                    $('#chat_input').val("");
                }
            });

            conn.onerror = function(e) {
                //error handle
            }
        });
    </script>
</body>
</html>