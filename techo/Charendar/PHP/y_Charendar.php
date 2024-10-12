<?php

  date_default_timezone_set('Asia/Tokyo');

    $ym = date('Y-m');
  
    $timestamp = strtotime($ym . '-01');
    if ($timestamp === false) {
        $ym = date('Y-m');
        $timestamp = strtotime($ym . '-01');
    }

    $today = date('Y-m-j');
        
  function Charendar($res){
    global $ym;
    global $today;
    $html_title = date('Y年n月', $res);
    $html_title = '<h4 class="title">'.$html_title.'</h4>';

    $ans = '<section class="sheet">';
    $ans .= '<div class="c2">';
    $ans .= $html_title;
    $ans.='<table class="table table-bordered">';
    $weekday=['日','月','火','水','木','金','土'];
    $week='';
    for($i=0 ; $i<5 ; $i++){
      $week.='<td class="week">'.$weekday[$i].'</td>';
    }
    $ans .= '<tr class="l_week">'.$week.'</tr>';
    
    for($i=5 ; $i<7 ; $i++){
      $week.='<td class="week">'.$weekday[$i].'</td>';
    }
    $ans .= '<tr class="r_week">'.$week.'</tr>';

    $day_count = date('t', $res);
    
    $youbi = date('w', mktime(0, 0, 0, date('m', $res), 1, date('Y', $res)));
    
    
    $weeks = [];
    $week = '';
    
    $week .= str_repeat('<td class="day"></td>', $youbi);
    
    for ( $day = 1; $day <= $day_count; $day++, $youbi++) {
      $date = $ym . '-' . $day;
      $week .= '<td class="day">' . $day. '</td>';    

      if ($youbi % 7 == 6 || $day == $day_count) {
        
        if ($day == $day_count) {
          // 月の最終日の場合、空セルを追加
          // 例）最終日が木曜日の場合、金・土曜日の空セルを追加
          $week .= str_repeat('<td class="day"></td>', 6 - ($youbi % 7));
        }
        
        // weeks配列にtrと$weekを追加する
        $weeks[] = '<tr class="day">' . $week . '</tr>';
        
        // weekをリセット
        $week = '';
      }
    }

    foreach ($weeks as $week) {
      $ans .= $week;
    }
    $ans .= '</table>';
    $ans .= '</section>';
    $ans .= '</div>';
    
    echo $ans;
  }
?>

<!doctype html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!--------------------------- Bootstrap ----------------------------->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
    integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
  <!--------------------------- Google Fonts ----------------------------->
  <link href="https://fonts.googleapis.com/css?family=Noto+Sans" rel="stylesheet">

  <style>
    @page {
        size: A5;
        size: 210mm 148mm;
        margin: 0;
    }
    @media print {
    body {
      zoom:unset;
      height: 210mm; /* needed for Chrome */
      }
    }

  @media screen {
    body {
      width:fit-content;
      background: #eee;
      margin: 0;
    }
    .sheet{
      
      box-shadow: 0 .5mm 2mm rgba(0,0,0,.3); /* ドロップシャドウ */
    }
  }

  

    .sheet{
      border:1px;
      page-break-after:always;
      margin: 5mm 5mm 5mm 5mm;
      padding: 0;
        width: 240mm;
        height: 162mm;

    }

    .c1{
      padding-top: 15mm;
      display:grid;
      grid-template-columns:148mm 148mm;

      background: white;
    }

    .table{
      width: 220mm;
      height: 110mm;
    }

    .week td{
      height: 6mm;
      border-collapse:separate;
        padding:0;
          text-align:center;
          font-size: medium;
    }

    .day td{
      width: 23mm;
      height: 23mm;
      border-collapse:separate;
        padding-top:0.5mm;
        padding-left: 0.5mm;
      font-size: 15;
      text-align:left;
      vertical-align : top; 
    }


  

    th {
      text-align: center;
    }


    th:nth-of-type(1),
    td:nth-of-type(1) {
      color: red;
    }

    th:nth-of-type(7),
    td:nth-of-type(7) {
      color: blue;
    }
  </style>

  <title>カレンダー</title>
</head>

<body>



    <?php
      for($j = 1;$j<14;$j++){
        Charendar($timestamp);
        $a = date('Y-m', mktime(0, 0, 0, date('m', $timestamp)+1, 1, date('Y', $timestamp)));
        $timestamp = strtotime($a.'-01');
      }
    ?>








  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
    crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
    integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI"
    crossorigin="anonymous"></script>
</body>

</html>

