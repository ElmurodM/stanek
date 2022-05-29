<?php
ob_start(); 
$token = "5557733869:AAGilCxgIiWp8DxKbkLkJlmj9yg8UKtD7xQ";
function del($nomi){
   array_map('unlink', glob("$nomi"));
   }
function bot($method,$datas=[]){
global $token;
    $url = "https://api.telegram.org/bot".$token."/".$method;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
    $res = curl_exec($ch);
    if(curl_error($ch)){
        var_dump(curl_error($ch));
    }else{
        return json_decode($res);
    }}
       function objectToArrays($object)
    {
        if (!is_object($object) && !is_array($object)) {
            return $object;
        }
        if (is_object($object)) {
            $object = get_object_vars($object);
        }
        return array_map("objectToArrays", $object);
    }

$connect = mysqli_connect(
'localhost', // tegilmasin
'stanek', // Baza nomi
'Stanek111', // Baza paroli
'stanek'); // Baza nomi
mysqli_set_charset($connect, "utf8mb4");

$update = json_decode(file_get_contents('php://input'));
$message = $update->message;
$reply = $message->reply_to_message->text;
$tx = $message->text;
$text= $message->text;
$name = $message->chat->first_name;
$mid = $message->message_id;
$fadmin = $message->from->id;
$data = $update->callback_query->data;
$cty = $message->chat->type;
$cid = $message->chat->id;
$type = $message->chat->type;
$photo = $message->photo;
$user=$message->user->username;
$reply = $message->reply_to_message->text;
$uid= $message->from->id;
$id = $message->reply_to_message->from->id;
$data = $update->callback_query->data;
$qid = $update->callback_query->id;
$callcid = $update->callback_query->message->chat->id;
$clid = $update->callback_query->from->id;
$callmid = $update->callback_query->message->message_id;
$gid = $update->callback_query->message->chat->id;
$id = $update->message->from->id;
$replyik = $message->reply_to_message->text;
$adminstep = file_get_contents("$cid.txt");
$menu = json_encode([ 
    'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"Старосты"]],
[['text'=>"Катры аудитории"]],
[['text'=>"Вопросы и ответы"]],
]
]);

$menustarost = json_encode([ 
    'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"Добавить старосту"]],
[['text'=>"Управление старостами"]],
[['text'=>"Назад"]],
]
]);
$menuvopros = json_encode([ 
    'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"Добавить в.о"]],
[['text'=>"Управление в.о"]],
[['text'=>"Назад"]],
]
]);

if($tx== "/start" or $tx == "Назад"){
 bot('sendmessage',[
        'chat_id'    => $cid, 
"text"=>"Выбирай",
'reply_markup'=>$menu,
]);
}





#starosti
if($tx== "Старосты"){
 bot('sendmessage',[
        'chat_id'    => $cid, 
"text"=>"Выбирай",
'reply_markup'=>$menustarost,
]);
}
if($tx== "Вопросы и ответы"){
 bot('sendmessage',[
        'chat_id'    => $cid, 
"text"=>"Выбирай",
'reply_markup'=>$menuvopros,
]);
}


if($tx== "Добавить старосту"){
 bot('sendmessage',[
        'chat_id'    => $cid, 
"text"=>"Название группы",
]);
file_put_contents("$cid.txt","1");
}
if($adminstep=="1"){
 bot('sendmessage',[
        'chat_id'    => $cid, 
"text"=>"Имя старосты $tx",
]);
file_put_contents("$cid.txt","2");
file_put_contents("gruppa$cid.txt","$tx");
}
if($adminstep=="2"){
 bot('sendmessage',[
        'chat_id'    => $cid, 
"text"=>"Контакты старосты",
]);
file_put_contents("imya$cid.txt","$tx");
file_put_contents("$cid.txt","3");
}
if($adminstep=="3"){
$ok=file_get_contents("imya$cid.txt");
$oke=file_get_contents("gruppa$cid.txt");
mysqli_query($connect,"INSERT INTO starosta(name,gruppa,contact) VALUES ('$ok','$oke','$tx')");
 bot('sendmessage',[
        'chat_id'    => $cid, 
"text"=>"Сохранено",
'reply_markup'=>$menu,
]);
unlink("imya$cid.txt");
unlink("gruppa$cid.txt");
unlink("$cid.txt");
}


elseif ($text=="Управление старостами") { 

      $siql = "SELECT * FROM starosta"; 
        $risdata = mysqli_query($connect,$siql); 
  $sin=0; 
$one = [];
  while($roww = mysqli_fetch_array($risdata)){ 

$alll = $roww['name']; 
$gruppa = $roww['gruppa'];
$id = $roww['id']; 
$contact = $roww['contact']; 
 $sin++; 
$one[] = ["callback_data"=>"oddiy","text"=>"$sin"];
$one[] = ["callback_data"=>"deletest*$id","text"=>"Delete"];
 $msgg .= $sin.". ".$alll." - ".$gruppa." \n"; 
 }
bot("sendmessage", [ 
"chat_id" =>$cid,  
"text"=>$msgg, 
 'reply_markup'=>json_encode([ 
'inline_keyboard'=>array_merge (array_chunk ($one,2))
      ])  
]); 
}

if(mb_strpos($data, "deletest*")!== false){
    $data = explode ("*",$data);
    $name = $data[0];
    $pagen = $data[1];
mysqli_query($connect,"DELETE FROM `starosta` WHERE `id`='$pagen' ");
 bot("deletemessage", [
"chat_id" =>$callcid,
"message_id" => $callmid,
]);
bot("sendmessage", [
"chat_id" =>$callcid,
'text'=>"Удалено",
]);
exit();
}

#end starosti

#voprosi

if($tx== "Добавить в.о"){
 bot('sendmessage',[
        'chat_id'    => $cid, 
"text"=>"Отправьте вопрос",
]);
file_put_contents("$cid.txt","v1");
}
if($adminstep=="v1"){
 bot('sendmessage',[
        'chat_id'    => $cid, 
"text"=>"Ответ к этому вопросу",
]);
file_put_contents("$cid.txt","v2");
file_put_contents("vopros$cid.txt","$tx");
}
if($adminstep=="v2"){
$oke=file_get_contents("vopros$cid.txt");
mysqli_query($connect,"INSERT INTO vopros(vopros,otvet) VALUES ('$oke','$tx')");
 bot('sendmessage',[
        'chat_id'    => $cid, 
"text"=>"Сохранено",
'reply_markup'=>$menu,
]);
unlink("vopros$cid.txt");
unlink("$cid.txt");
}


elseif ($text=="Управление в.о") { 

      $siql = "SELECT * FROM vopros"; 
        $risdata = mysqli_query($connect,$siql); 
  $sin=0; 
$one = [];
  while($roww = mysqli_fetch_array($risdata)){ 

$alll = $roww['vopros']; 
$otvet = $roww['otvet'];
$id = $roww['id'];  
 $sin++; 
$one[] = ["callback_data"=>"oddiy","text"=>"$sin"];
$one[] = ["callback_data"=>"deletev*$id","text"=>"Delete"];
 $msgg .= $sin.". ".$alll." - ".$otvet." \n"; 
 }
bot("sendmessage", [ 
"chat_id" =>$cid,  
"text"=>$msgg, 
 'reply_markup'=>json_encode([ 
'inline_keyboard'=>array_merge (array_chunk ($one,2))
      ])  
]); 
}

if(mb_strpos($data, "deletev*")!== false){
    $data = explode ("*",$data);
    $name = $data[0];
    $pagen = $data[1];
mysqli_query($connect,"DELETE FROM `vopros` WHERE `id`='$pagen' ");
 bot("deletemessage", [
"chat_id" =>$callcid,
"message_id" => $callmid,
]);
bot("sendmessage", [
"chat_id" =>$callcid,
'text'=>"Удалено",
]);
exit();
}

#end vopros

#start karta


if($tx== "Катры аудитории"){
 bot('sendmessage',[
        'chat_id'    => $cid, 
"text"=>"Отправьте ссылку",
]);
file_put_contents("$cid.txt","k1");
}
if($adminstep=="k1"){
mysqli_query($connect,"INSERT INTO karta(url) VALUES ('$tx')");
 bot('sendmessage',[
        'chat_id'    => $cid, 
"text"=>"Сохранено",
'reply_markup'=>$menu,
]);
unlink("$cid.txt");
}
