<?php

  function dayhour(){
    $ans ="";
    for($i=6;$i<=22;$i++){
      if($i==22){
        $ans.='<div class="hoursets">';
        $ans.='<div class="hourline"></div>';  
        $ans.='</div>';
      }else{
        $ans.='<div class="hoursets">';
        $ans.='<div class="hour"><p>'.$i.'</p></div>';
        $ans.='<div class="hourline"></div>';
        $ans.='<div class="quarterlines"><hr class="quarterline"><hr class="quarterline"><hr class="quarterline"></div> <div></div>';
        $ans.='</div>';
      }
    }
    return $ans;
  }

date_default_timezone_set('Asia/Tokyo');

if (isset($_GET['ym'])) {
  $ym = $_GET['ym'];
} else {
  $ym = date('Y-m');
    }  

    $timestamp = strtotime($ym . '-01');
    if ($timestamp === false) {
        $ym = date('Y-m');
        $timestamp = strtotime($ym . '-01');
    }
    $html_title = date('Y年n月', $timestamp);
  
    $prev = date('Y-m', mktime(0, 0, 0, date('m', $timestamp)-1, 1, date('Y', $timestamp)));

  
    $next = date('Y-m', mktime(0, 0, 0, date('m', $timestamp)+1, 1, date('Y', $timestamp)));

    $today = date('Y-m-j');
        
  function Charendar($res){
    global $ym;
    global $today;
    global $prev;
    global $next;
    $html_title = date('Y年n月', $res);

    $IItableday=['日','月','火','水','木','金','土'];
    $IItable='';
    
    $day_count = date('t', $res);
    
    $youbi = date('w', mktime(0, 0, 0, date('m', $res), 1, date('Y', $res)));
    
    
    $IItables = [];
    $IItable = '';
    $flag=0;
    
    for ( $day = 1; $day <= $day_count; $day+=4) {
      $ans = '<section class="sheet">';
      if($flag%2==0){
        $ans.='<div class="Iodd">';
      }else{
        $ans.='<div class="even">';
      }
      $ans .= '<div class="title">';
      $ans .=  $html_title;
      $ans .=  '</div>';

      $cell='';
      for($i=$day ; $i<$day+4 ; $i++){
        $cell.='<div class="IIItabletop"><p class="d">'.$i;
        if(($youbi+$i-1)%7==0){
          $cell.='<span class="w sunday"> ('.$IItableday[($youbi+$i-1)%7].')'.'</span></p></div>'; 
        }else if(($youbi+$i-1)%7==6){
          $cell.='<span class="w saturday"> ('.$IItableday[($youbi+$i-1)%7].')'.'</span></p></div>'; 
        }else{
          $cell.='<span class="w"> ('.$IItableday[($youbi+$i-1)%7].')'.'</span></p></div>'; 
        }
        if ($i == $day_count) {
          $cell .= str_repeat('<div class="IIItabletop free"><p class="d">Memo</p></div>', 4 - ($i % 4));
          break;
        }        
      }
      
      for($i=$day ; $i<$day+4 ; $i++){
        $cell.='<div class="IIItablemiddle">'.dayhour().'</div>';  
        if ($i == $day_count) {
          $cell .= str_repeat('<div class="IIItablemiddle free"></div>', 4- ($i % 4));
          break;
        }        
      }
      $ans .= '<div class="IItable">'.$cell.'</div>';
      $ans .= '</div>';
      $ans .= '</section>';
      echo $ans;
      $date = $ym . '-' . $day;
 
      $ans = '';
      $flag++;
    }

  }

?>

<!doctype html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  
  <link rel="stylesheet" href="all.css">
  <link rel="stylesheet" href="grid1.css">
  <link rel="stylesheet" href="grid2.css">
  
  <title>バーティカル</title>
</head>
<body>

  <?php
    echo '<div class="edit hide">';
    echo '<a class="yazi" href="?ym='. $prev.'">&lt;</a>';
    echo '<span class="tsuki">月</span>';
    echo '<a class="yazi" href="?ym='. $next.'">&gt;</a>';
    echo '</div>';
    Charendar($timestamp);
  ?>

</body>
</html>

