<?php
require_once('simplevk-master/autoload.php');
use DigitalStar\vk_api\VK_api as vk_api; // Основной класс

const VK_KEY = "vk1.a.AWQEJbtTALpdnMizEu-sACgfnyXg-RLD0x5EGg6We5YIiixiyITCLxTvvw4nc1yUsgayIozTQrXnhAegsrRa2N9YIRnD4BKOy2OeXtHQ-X-gOP7TQbITFhr0lReZLivnXDfm-DF4n7zrLSe6pkQvX6VZMWASmggd7iTH3_0qro6pyQuaybLERWId3M8BDFKYQWqU9ddOKo0V-inDBuDIjQ";
const ACCESS_KEY = "45c3a8ac";
const VERSION = "5.131";

$vk = vk_api::create(VK_KEY, VERSION)->setConfirm(ACCESS_KEY);

$vk->initVars($peer_id, $message, $payload, $vk_id, $type, $data); // Инициализация переменных

//Задаем кнопки
$btn_Start = $vk->buttonText('Начать', 'green', ['command' => 'btn_Start']);
$btn_K = $vk->buttonText('Камень', 'blue', ['command' => 'btn_K']);
$btn_N = $vk->buttonText('Ножницы', 'blue', ['command' => 'btn_N']);
$btn_B = $vk->buttonText('Бумага', 'blue', ['command' => 'btn_B']);


$vkid = $data->object->from_id; // Узнаем ID пользователя, кто написал нам
$message = $data->object->text; // Само сообщение от пользователя

$message = mb_strtolower($message);

//Функции
//Функция запуска кода
function Start($vk, $peer_id, $user_wins, $comp_wins, $cuser, $ccomp, $cc, $btn_K,$btn_N,$btn_B ) {

  $user_wins = 0;
  $comp_wins = 0;
  $ccomp;
  $cc = 0;

  if (($user_wins < 3) && ($comp_wins < 3)) {
    $vk->sendButton($peer_id, "Камень, ножницы, или бумага? ", [[$btn_K,$btn_N,$btn_B]]);
      
  }
}

function Start1($vk, $peer_id, $user_wins, $comp_wins, $cuser, $ccomp, $cc, $btn_K,$btn_N,$btn_B )
{

 //Здесь ход компьютера
 $cc = rand() % 3;
      
 if ($cc == 0) $ccomp = "Камень";
 if ($cc == 1) $ccomp = "Ножницы";
 if ($cc == 2) $ccomp = "Бумага";
 
 result($cuser, $ccomp);

 if (result($cuser,$ccomp) == -1) { $comp_wins++; 
   $vk->sendMessage($peer_id, "($cuser)  против   ($ccomp), Компьютер победил!;  ($user_wins)  : ($comp_wins) "); } 
 
 else

 if ($result($cuser,$ccomp) == 0) $vk->sendMessage($peer_id, "($cuser)  против  ($ccomp), Ничья!;  ($user_wins)  : $comp_wins ");
 
 else
 
 if (result($cuser,$ccomp) == 1) { $user_wins++; $vk->sendMessage($peer_id, "$cuser  против   $ccomp, Вы победили!;  $user_wins  : $comp_wins "); }
 
 else $vk->sendMessage($peer_id,  "Ошибка! Неверный ввод!" ); 
 
 
 if ($comp_wins > $user_wins) $vk->sendMessage($peer_id, "Компьютер победил!"); 
 else
 if ($comp_wins < $user_wins) $vk->sendMessage($peer_id, "Поздравляем! Вы победили"); 
 else
 if ($comp_wins = $user_wins) $vk->sendMessage($peer_id, "Ничья!");
 
 $vk->sendButton($peer_id, "Хотите начать новую игру?: ", [[$btn_Start]]); 
}


//Здесь вычисляется, кто победил
function result($cuser, $ccomp) {
  if (($cuser == "Камень") && ($ccomp == "Бумага") || ($cuser == "Ножницы") && ($ccomp == "Камень") || ($cuser == "Бумага") && ($ccomp == "Ножницы")) return -1;

  if (($cuser == "Камень") && ($ccomp == "Ножницы") || ($cuser == "Ножницы") && ($ccomp == "Бумага") ||($cuser == "Бумага") && ($ccomp == "Камень")) return 1;

  if ($cuser == $ccomp) return 0;
  }



//Начало кода
if ($data->type == 'message_new')
 {
    if ($message == 'начать' )
   {
    
    Start($vk, $peer_id, $user_wins, $comp_wins, $cuser, $ccomp, $cc, $btn_K,$btn_N,$btn_B );
   }}

if (isset($data->object->payload)) {  //получаем payload
    $payload = json_decode($data->object->payload, True);
} else {
    $payload = null;
}
$payload = $payload['command'];


 //Действия кнопок
 if ($payload == 'btn_K')
 $cuser = "Камень";
 if ($payload == 'btn_N')
 $cuser = "Бумага";
 if ($payload == 'btn_B')
 $cuser = "Ножницы";
 if ($payload == 'btn_Start')
 $vk->sendButton($peer_id, "Камень, ножницы, или бумага? ", [[$btn_K,$btn_N,$btn_B]]);
    ?>