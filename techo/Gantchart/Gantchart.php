<?php
  //$timestanp = mkdate(sec,min,hour,day,month,year)
  //$format = date(format,timestanp)
  //$timestamp = strtotime('year-month',timestamp)

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

  $today = date('Y-m-j');

  $html_title = date('Y年n月', $timestamp);

  $prev = date('Y-m', mktime(0, 0, 0, date('m', $timestamp)-1, 1, date('Y', $timestamp)));
  $next = date('Y-m', mktime(0, 0, 0, date('m', $timestamp)+1, 1, date('Y', $timestamp)));

  $day_count = date('t', $timestamp);

// １日が何曜日か　0:日 1:月 2:火 ... 6:土
  $youbi = date('w', mktime(0, 0, 0, date('m', $timestamp), 1, date('Y', $timestamp)));

  $weekday=['日','月','火','水','木','金','土'];
  $week = '';
  $days = '';
  $cells = '';

// 第１週目：空のセルを追加
// 例）１日が水曜日だった場合、日曜日から火曜日の３つ分の空セルを追加する
// $youbi=2　のとき
// $week='<td></td> <td></td>'

  for ( $day = 1; $day <= $day_count; $day++, $youbi++) {
    $week=$weekday[($youbi)%7];
    if($week=="日"){
      $a .= '<td class="week sunday">' . $week.'</td>';
      $days .= '<td class="day sunday">' . $day.'</td>';
      $cells .= '<td class="cell sunday"></td>';
    }else if($week=="土"){
      $a .= '<td class="saturday week">' . $week.'</td>';
      $days .= '<td class="day saturday">' . $day.'</td>';
      $cells .= '<td class="cell saturday"></td>';
    }else{
      $a .= '<td class="week">' . $week.'</td>';
      $days .= '<td class="day">' . $day.'</td>';
      $cells .= '<td class="cell"></td>';
    }
    if ($day == $day_count) {
      $weeks = '<tr>' . $a . '</tr>';
      $days = '<tr>' . $days . '</tr>';
      $cells = '<tr>' . $cells . '</tr>';
    }
  }

 
?>

<!doctype html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
    integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css?family=Noto+Sans" rel="stylesheet">

  <style>
  
    @page {
        size: A5 landscape;
        margin: 0;
    }
    @media print {
    body{
      width:210mm;
    }
    .sheet {
      zoom:140%;
      width: 210mm; /* needed for Chrome */
      }
    }

  @media screen {
    body {
      margin: 0;
        width:210mm;
      background: #eee;
    }
    /* session{
      margin:10mm;
        height:210mm;
        width:148mm;
      background: white;
    } */
  }

    body{
      width: 210mm;
      background: #eee;
    }

    .sheet{
      page-break-after: always;
      margin:0 0 5mm 0mm;
        width: 210mm;
        height: 149mm;
          background: white;
          box-shadow: 0 .5mm 2mm rgba(0,0,0,.3);
    }



    .container{
      margin: 0;
      padding-top: 15mm;
      padding-left: 8mm;
    }

    .table td{
      width: 7mm;
      padding: 1mm;
      font-size: 7; 
    }

    .table tr{
      width:210;
    }

    th {
      text-align: center;
    }


    .today {
      background: orange;
    }

    .sunday {
      color: red;
      background: rgba(155,155,155,0.15);
    }
   

    .saturday {
      color: blue;
      background: rgba(155,155,155,0.15);

    }

    .week{
      font-size:small;
    }

    .day{
      font-size:small;
    }

    .cell{
      height: 100mm;
    }
  </style>

  <title>カレンダー</title>
</head>

<body>

  <section class="sheet">
    <div class="container">
      <h3 class="title">
        <a href="?ym=<?php echo $prev; ?>">&lt;</a> 
        <?php echo $html_title; ?>
        <a href="?ym=<?php echo $next; ?>">&gt;</a>
      </h3>
      <table class="table table-bordered">
          <?php echo $weeks; ?>
          <?php echo $days; ?>
          <?php echo $cells; ?>
        </table>
    </div>
  </section>










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

