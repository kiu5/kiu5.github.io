<?php

  function dayhour(){
    $ans = '';
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

//-------------------------------------------------------------------------
//-------------------------------------------------------------------------

  function GetYoubi($num){
    $IItableday=['月','火','水','木','金','土','日'];
    if($num%7==5){
      $res = '<div class="w saturday"> ('.$IItableday[$num%7].')'.'</div>';
    }else if($num%7==6){
      $res = '<div class="w sunday"> ('.$IItableday[$num%7].')'.'</div>';
    }else{
      $res = '<div class="w"> ('.$IItableday[$num%7].')'.'</div>';
    }
    return $res;
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

//-------------------------------------------------------------------------
//-------------------------------------------------------------------------
        
  function Charendar($res,$i){
    global $ym;
    global $today;
    global $prev;
    global $next;
    $html_title = date('Y年n月', $res);

    $IItableday=['月','火','水','木','金','土','日'];
    $IItable='';
    
    $PreMonth = date('n',$res-1);
    $PreMonthDays = date('t', $res-1);
    $MonthDays = date('t', $res);
    
    $FirstDayYoubi = (date('w', mktime(0, 0, 0, date('m', $res), 1, date('Y', $res)))+6)%7;
    
    
    $flag=0;
    $FirstDay=1;
    if($i==1){
      $ans='<section class="sheet"><div class="first_page">
      <hr class="first_mark">
      <hr class="second_mark">
      <hr class="third_mark">
      <hr class="forth_mark">
      <hr class="fifth_mark">
      <hr class="sixth_mark">
      </div></section>';
    }else{
      $ans='<section class="sheet"></section>
      <section class="sheet"><div class="first_page">
      <hr class="first_mark">
      <hr class="second_mark">
      <hr class="third_mark">
      <hr class="forth_mark">
      <hr class="fifth_mark">
      <hr class="sixth_mark">
      </div></section>';
    }

    if($FirstDayYoubi<4){
      $ans .= '<section class="sheet">';
      if($FirstDayYoubi==0){
        $cell='';
        for($i=1;$i<=4;$i++){
          $cell .= '<div class="IIItabletop"><p class="d">'.$i;
          $cell .= GetYoubi($i-1).'</p></div>';
        }
        $FirstDay=5;
      }else if($FirstDayYoubi==1){
        $cell='';
        $cell.='<div class="IIItabletop"><p class="d">'.($PreMonth)."/".$PreMonthDays;
        $cell.='<span class="w"> ('.$IItableday[0].')'.'</span></p></div>';
        for($i=1;$i<=3;$i++){
          $cell.='<div class="IIItabletop"><p class="d">'.$i;
          $cell.=GetYoubi($i%7).'</p></div>';
        }
        $FirstDay=4;
      }else if($FirstDayYoubi==2){
        $cell='';
        $a=0;
        for($i=$PreMonthDays-1;$i<=$PreMonthDays;$i++){
          $cell.='<div class="IIItabletop"><p class="d">'.($PreMonth)."/".$i;
          $cell.=GetYoubi($a).'</p></div>';
          $a++;
        }
        for($i=1;$i<=2;$i++){
          $cell.='<div class="IIItabletop"><p class="d">'.$i;
          $cell.=GetYoubi($a).'</p></div>';
          $a++;
        }
        $FirstDay=3;     
      }else if($FirstDayYoubi==3){
        $cell='';
        for($i=$PreMonthDays-2;$i<=$PreMonthDays;$i++){
          $cell.='<div class="IIItabletop"><p class="d">'.($PreMonth)."/".$i;
          $cell.=GetYoubi($i).'</p></div>';
        }
        $cell.='<div class="IIItabletop"><p class="d">1';
        $cell.=GetYoubi(3).'</p></div>';
        $FirstDay=2;
      }else{
        echo $FirstDayYoubi;
      }
      for($i=0;$i<4;$i++){
        $cell.='<div class="IIItablemiddle">'.dayhour().'</div>';        
      }
      $ans.='<div class="Iodd">';
      $ans .= '<div class="title">';
      $ans .=  $html_title;
      $ans .=  '</div>';
      $ans .= '<div class="IItable">'.$cell.'</div>';
      $ans .= '</div>';
      $ans .= '</section>';
      echo $ans;     
      $ans = '';
      $flag++;
    }else{

      
      $ans .= '<section class="sheet">';
      $cell='';
      $a=0;
      for($i=$PreMonthDays-$FirstDayYoubi+1;$i<=$PreMonthDays-$FirstDayYoubi+4;$i++){
        $cell.='<div class="IIItabletop"><p class="d">'.($PreMonth)."/".$i;
        $cell.=GetYoubi($a).'</p></div>';
        $a++;
      }
      for($i=0;$i<4;$i++){
        $cell.='<div class="IIItablemiddle">'.dayhour().'</div>';        
      }
      $ans.='<div class="Iodd">';
      $ans .= '<div class="title">';
      $ans .=  $html_title;
      $ans .=  '</div>';
      $ans .= '<div class="IItable">'.$cell.'</div>';
      $ans .= '</div>';
      $ans .= '</section>';
      echo $ans;     
      $ans = '';
      $flag++;


      $ans = '<section class="sheet">';
      if($FirstDayYoubi==4){
        $cell='';
        $a=4;
        for($i=1;$i<=3;$i++){
          $cell.='<div class="IIItabletop"><p class="d">'.$i;
          $cell.=GetYoubi($a).'</p></div>';
          $a++;
        }
        $FirstDay=4;
      }else if($FirstDayYoubi==5){
        $cell='';
        $a=5;
        $cell.='<div class="IIItabletop"><p class="d">'.($PreMonth)."/".$PreMonthDays;
        $cell.=GetYoubi($a-1).'</p></div>';
        for($i=1;$i<=2;$i++){
          $cell.='<div class="IIItabletop"><p class="d">'.$i;
          $cell.=GetYoubi($a).'</p></div>';
          $a++;
        }
        $FirstDay=3;     
      }else if($FirstDayYoubi==6){
        $cell='';
        $a=4;
        for($i=$PreMonthDays-1;$i<=$PreMonthDays;$i++){
          $cell.='<div class="IIItabletop"><p class="d">'.($PreMonth)."/".$i;
          $cell.=GetYoubi($a).'</p></div>';
          $a++;
        }
        $cell.='<div class="IIItabletop"><p class="d">1';
        $cell.=GetYoubi(6).'</p></div>';
        $FirstDay=2;
      }
      $cell .= '<div></div>';
      for($i=0;$i<3;$i++){
        $cell.='<div class="IIItablemiddle">'.dayhour().'</div>';        
      }
      $ans.='<div class="even">';
      $ans .= '<div class="title">';
      $ans .=  $html_title;
      $ans .=  '</div>';
      $ans .= '<div class="IItable">'.$cell.'</div>';
      $ans .= '</div>';
      $ans .= '</section>';
      echo $ans;
      $ans = '';
      $flag++;
    }

    $j=$FirstDay;
    while($j<=$MonthDays+7){
      if($flag%2==0 && $j+4>=$MonthDays){
        break;
      }else if($flag%2==0){
        $ans = '<section class="sheet">';
        $cell='';
        for($k=0;$k<4;$k++){
          if($k+$j>$MonthDays){
            for($l=0;$l<4-($MonthDays-$j)-1;$l++){
              $cell.='<div></div>';
            }
            break;
          }else{
            $cell.='<div class="IIItabletop"><p class="d">'.($k+$j);
            $cell.=GetYoubi($k+$j+$FirstDayYoubi-1).'</p></div>';
          }
        }
        for($k=0;$k<4;$k++){
          if($k+$j>$MonthDays){
            for($l=0;$l<4-($MonthDays-$j)-1;$l++)
            $cell.='<div></div>';
            break;
          }else{
            $cell.='<div class="IIItablemiddle">'.dayhour().'</div>';
          }
        }
        $ans.='<div class="Iodd">';
        $ans .= '<div class="title">';
        $ans .=  $html_title;
        $ans .=  '</div>';
        $ans .= '<div class="IItable">'.$cell.'</div>';
        $ans .= '</div>';
        $ans .= '</section>';
        echo $ans;
        $ans = '';
        $flag++;  
        $j+=4;
      }else{
        $ans = '<section class="sheet">';
        $cell='';
        for($k=0;$k<3;$k++){
          if($k+$j>$MonthDays){
            for($l=0;$l<3-($MonthDays-$j)-1;$l++)
            $cell.='<div></div>';
            break;
          }else{
            $cell.='<div class="IIItabletop"><p class="d">'.($k+$j);
            $cell.=GetYoubi($k+$j+$FirstDayYoubi-1).'</p></div>';
          }
        }
        $cell.='<div></div>';
        for($k=0;$k<3;$k++){
          if($k+$j>$MonthDays){
            for($l=0;$l<$MonthDays-$k-$j;$l++)
            $cell.='<div></div>';
            break;
          }else{
            $cell.='<div class="IIItablemiddle">'.dayhour().'</div>';
          }
        }
        $ans.='<div class="even">';
        $ans .= '<div class="title">';
        $ans .=  $html_title;
        $ans .=  '</div>';
        $ans .= '<div class="IItable">'.$cell.'</div>';
        $ans .= '</div>';
        $ans .= '</section>';
        echo $ans;
        $ans = '';
        $flag++;  
        $j+=3;
      }
    }
  }




  //     if($flag%2==0){
  //       $ans.='<div class="Iodd">';
  //       $ans .= '<div class="title">';
  //       $ans .=  $html_title;
  //       $ans .=  '</div>';

  //       $cell='';



  //       $cell='';
  //     for($i=0 ; $i<=4 ; $i++){
  //       $cell.='<div class="IIItabletop"><p class="d">'.$i;
  //       $cell.='<span class="w"> ('.$IItableday[$i].')'.'</span></p></div>'; 
        
  //       if ($i == $day_count) {
  //         $cell .= str_repeat('<div class="IIItabletop free"><p class="d">Memo</p></div>', 4 - ($i % 4));
  //         break;
  //       }        
  //     }
  //     $cell.='<div class="IIItablemiddle">'.dayhour().'</div>';        
  //     if ($i == $day_count) {
  //       $cell .= str_repeat('<div class="IIItablemiddle free"></div>', 4- ($i % 4));
  //       break;
  //     }        
  //     $ans .= '<div class="IItable">'.$cell.'</div>';
  //     $ans .= '</div>';
  //     $ans .= '</section>';
  //     echo $ans;
 
  //     $ans = '';
  //     $flag++;




  //     }else{
  //       $ans.='<div class="even">';
  //       $ans .= '<div class="title">';
  //       $ans .=  $html_title;
  //       $ans .=  '</div>';




  //     }
   
  //     $cell='';
  //     for($i=$day ; $i<$day+4 ; $i++){
  //       $cell.='<div class="IIItabletop"><p class="d">'.$i;
  //       if(($youbi+$i-1)%7==0){
  //         $cell.='<span class="w sunday"> ('.$IItableday[($youbi+$i-1)%7].')'.'</span></p></div>'; 
  //       }else if(($youbi+$i-1)%7==6){
  //         $cell.='<span class="w saturday"> ('.$IItableday[($youbi+$i-1)%7].')'.'</span></p></div>'; 
  //       }else{
  //         $cell.='<span class="w"> ('.$IItableday[($youbi+$i-1)%7].')'.'</span></p></div>'; 
  //       }
  //       if ($i == $day_count) {
  //         $cell .= str_repeat('<div class="IIItabletop free"><p class="d">Memo</p></div>', 4 - ($i % 4));
  //         break;
  //       }        
  //     }
      
  //     for($i=$day ; $i<$day+4 ; $i++){
  //       $cell.='<div class="IIItablemiddle">'.dayhour().'</div>';        
  //       if ($i == $day_count) {
  //         $cell .= str_repeat('<div class="IIItablemiddle free"></div>', 4- ($i % 4));
  //         break;
  //       }        
  //     }
  //     $ans .= '<div class="IItable">'.$cell.'</div>';
  //     $ans .= '</div>';
  //     $ans .= '</section>';
  //     echo $ans;
 
  //     $ans = '';
  //     $flag++;
  //   }

  // }

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
    echo '<span class="tsuki">'.$html_title.'</span>';
    echo '<a class="yazi" href="?ym='. $next.'">&gt;</a>';
    echo '</div>';
    for($i=1; $i<=3; $i++){
      Charendar($timestamp,$i);
      $next = date('Y-m', mktime(0, 0, 0, date('m', $timestamp)+1, 1, date('Y', $timestamp)));
      $timestamp = strtotime($next . '-01');
    }
  ?>

</body>
</html>

