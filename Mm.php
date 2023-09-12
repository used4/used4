<?php
ob_start();
define('API_KEY','5219067615:AAF56yjRBDls091hKxGr3nJVm8PxRoIOCu4');
function salavat($method,$datas=[]){
    $url = "https://api.telegram.org/bot".API_KEY."/".$method;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,http_build_query($datas));
    $res = curl_exec($ch);
    if(curl_error($ch)){
        var_dump(curl_error($ch));
    }else{
        return json_decode($res);
    }
}
$update = json_decode(file_get_contents('php://input'));
if(isset($update->callback_query)){
    $callbackMessage = 'جاري غفران الذنوب 💫';
    var_dump(salavat('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>$callbackMessage
    ]));
    $chat_id = $update->callback_query->message->chat->id;
    $message_id = $update->callback_query->message->message_id;
    $add = $update->callback_query->data+1;
    $rem = $update->callback_query->data-1;
    var_dump(
        salavat('editMessageText',[
            'chat_id'=>$chat_id,
            'message_id'=>$message_id,
            'text'=>($add)." هذا هو عدد تسبيحاتك 🌙📿",
            'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"تسبيح تنازلي 💫",'callback_data'=>"$rem"],['text'=>"📿 تسبيح ✨",'callback_data'=>"$add"]
                    ],
                [
                ['text'=>"Team iraq 📡",'url'=>"https://t.me/chiiiraq"]
                ]
                ]
            ])
        ])
    );
}else{
    var_dump(salavat('sendMessage',[
        'chat_id'=>$update->message->chat->id,
        'text'=>"مرحبا بكم في بوت المسبحه 📿
بوت لغفران الذنوب ولتسبيح لله 🌙
اظغط علئ بدا لتبدء التسبح 🔮",
        'reply_markup'=>json_encode([
            'inline_keyboard'=>[
                [
                    ['text'=>"بدا💎",'callback_data'=>'-1']
                ],
                [
                    ['text'=>"Connect us 📳",'url'=>"https://t.me/Iraq11bot"],['text'=>"SEMO 🛂",'url'=>"https://t.me/lqoopl"]
            ],
            [
            ['text'=>"Team iraq 📡",'url'=>"https://t.me/chiiiraq"]
            ]
            ]
        ])
    ]));
}
file_put_contents('log',ob_get_clean());
