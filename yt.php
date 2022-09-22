<?php
$token = "5402299050:AAFT8kMP1IkS-FdUMjvQo2rq8OieKFJl6Fw";
define('API_KEY',$token);
echo file_get_contents("api.telegram.org/bot".API_KEY."/setwebhook?url=".$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME']);
function bot($method,$datas=[]) {
    $url = "https://api.telegram.org/bot".API_KEY."/".$method;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
    $res = curl_exec($ch);
    if(curl_error($ch)) {
        var_dump(curl_error($ch));
    }else {
        return json_decode($res);
    }
}
$update = json_decode(file_get_contents('php://input'));
$message = $update->message;
$id = $message->from->id;
$rep = $message->message_id;
$m = $rep + 1;
$chat_id = $message->chat->id;
$from_id = $message->from->id;
$admin = "1096062354";
//ايدي الادمن
$text = $message->text;
$namee = $update->callback_query->from->first_name;
$user = $message->from->username;
if(isset($update->callback_query)) {
    $chat_id = $update->callback_query->message->chat->id;
    $message_id = $update->callback_query->message->message_id;
    $data = $update->callback_query->data;
    $user = $update->callback_query->from->username;
}

if($message && $from_id != $admin) {
    bot('forwardMessage',[
'chat_id'=>$admin,
'from_chat_id'=>$chat_id,
'message_id'=>$rep,
'text'=>$text,
]);
}

$base = file_get_contents("$chat_id");
if($text == "/start" && $base == '') {
    bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"اختر كيف تريد استخدام بحث اليوتيوب ",
'reply_to_message_id'=>$update->message->message_id,
'parse_mode'=>"MARKDOWN",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>'تحميل صوت', 'callback_data'=>"mp3"],['text'=>'تحميل فيديو', 'callback_data'=>"mp4"]],
]
])
]);
}
if($data == 'mp3') {
    file_put_contents("$chat_id","mp3");
    bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"ارسل الكلمه للبحث عنها",
'parse_mode'=>"MARKDOWN",
]);
}
if($data == 'mp4') {
    file_put_contents("$chat_id","mp4");
    bot('EditMessageText',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"ارسل الكلمه للبحث عنها",
'parse_mode'=>"MARKDOWN",
]);
}
$yy = file_get_contents("$chat_id");
if($text && $yy == 'mp3') {
    file_put_contents("$chat_id","");
    file_get_contents("https://api.telegram.org/bot$token/sendAnimation?chat_id=$chat_id&animation=https://t.me/youtube7odabot/7951&reply_to_message_id=$rep");
    $xx = "http://api.medooo.ml/leomedo/yt?text=$text?token=$token&chat_id=$chat_id&msg_id=$rep&type=mp3";
    $ch = curl_init($xx);
     // such as http://example.com/example.xml
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    $data = curl_exec($ch);
    curl_close($ch);
    file_get_contents("https://api.telegram.org/bot$token/deleteMessage?chat_id=$chat_id&message_id=$m");
}
if($text && $yy == 'mp4') {
    file_put_contents("$chat_id","");
    file_get_contents("https://api.telegram.org/bot$token/sendAnimation?chat_id=$chat_id&animation=https://t.me/youtube7odabot/7951&reply_to_message_id=$rep");
    $ytt = "http://api.medooo.ml/leomedo/yt?text=$text?token=$token&chat_id=$chat_id&msg_id=$rep&type=mp4";
    $ch = curl_init($ytt);
     // such as http://example.com/example.xml
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    $data = curl_exec($ch);
    curl_close($ch);
    file_get_contents("https://api.telegram.org/bot$token/deleteMessage?chat_id=$chat_id&message_id=$m");
}
if($text == "وش بيقول" or $text == "بيقول اي" or $text == "??" or $text == "؟؟" && isset($update->message->reply_to_message->voice)) {
    $idd = $update->message->reply_to_message->voice->file_id;
    $ytt = "https://api.medooo.ml/leomedo/voiceRecognise?token=$token&chat_id=$chat_id&file_id=$idd&msg_id=$rep";
    $ch = curl_init($ytt);
     // such as http://example.com/example.xml
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    $data = curl_exec($ch);
    curl_close($ch);
}