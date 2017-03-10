<meta charset="utf-8">
<div style="position: fixed; right: 10px;">Autor: Łukasz Olender I6Y4S1</div>
<?php $group = addslashes($_GET['group']);if(!$group)$group="I6Y4S1"; ?>
<style>
.activegroup{color:red;}
  a {text-decoration: none; color: green;}
  @keyframes bgcolor {
      70% {background-color: yellow;}
  }
  .activeblink {animation: bgcolor 2s linear infinite;}
  .active {background-color: yellow; border-color: red; color: red;}
  .nextday {background-color: #AA0;}
  .nextnextday {background-color: #770;}
  body {background-color: #BBB;}
  table {border-collapse: collapse;}
	td {width: 200px;}
	td:first-child {width: 50px;}
  .date {background: #BBB; text-align: center;}
  th {padding: 2px 5px 2px 5px; background-color: #888;}
</style>
<script src="jquery.js"></script>
<script>
  $.ajaxSetup({
    async: false
  });
  x = $.getJSON("<?php echo $group; ?>.json");
  x = x.responseJSON;
  s = {
  	"Algebra liniowa": ["All", "#B8860B"],
  	"Algorytmy i struktury danych": ["Als", "#E6E6FA"],
  	"Analiza matematyczna II": ["An", "#FFFACD"],
  	"Architektura i organizacja komputerów II": ["AoKII", "#D8BFD8"],
  	"Architektura i organizacja komputerów I": ["Aok", "#FF6347"],
  	"Fizyka": ["F", "#FFC0CB"],
  	"Matematyka dyskretna I": ["MD", "#FF69B4"],
  	"Matematyka dyskretna II": ["Md2", "#AFEEEE"],
  	"Podstawy elektrotechniki i elektroniki": ["Peie", "#F08080"],
  	"Programowanie niskopoziomowe i analiza kodu": ["Pnak", "#F0FFF0"],
  	"Podstawy miernictwa": ["Pom", "#FFEBCD"],
  	"Rachunek prawdopodobieństwa": ["Rp", "#FFD700"],
  	"Teoria grafów i sieci": ["Tgs", "#32CD32"],
  	"Teoria informacji i kodowania": ["Tik", "#00FFFF"],
  	"Teoretyczne podstawy informatyki": ["Tpi", "#ADFF2F"],
  	"Wychowanie fizyczne": ["WF", "#CD5C5C"],
  	"Wprowadzenie do programowania": ["WdP", "#FFA07A"],
  	"Analiza matematyczna I.": ["anm1", "#FFDEAD"],
  	"Podstawy podzespołów komputerów": ["ppk", "#E9967A"],
  }
</script>
<?php
$datef = fopen("lastup.txt", "r");
$lastupdate = fgets($datef);
$f = fopen($group."_daterange.txt", "r") or die("Unable to open file!");
$start = trim(fgets($f));
$stop = trim(fgets($f));
$start = DateTime::createFromFormat('Y-m-d', $start);
$stop = DateTime::createFromFormat('Y-m-d', $stop);
$now = new DateTime();
$weekday = date("w", $now->getTimestamp());
?>
<div style="position:fixed; right: 10px; bottom: 10px;">Data ostatniej aktualizacji: <?= $lastupdate; ?></div>
Dostępne plany:<br>
<?php
	$groups = array("I6Y2S1", "I6Y3S1", "I6Y4S1", "I6Y6S1", "K6X3S1", "H6X2S1");
	foreach ($groups as $g) {
		echo "<a";
		if ($g == $group) echo " class='activegroup'";
		echo " href='/index.php?group=".$g."'>".$g."</a> ";
	}
?><br>
Plan grupy <?= $group; ?>
<table border=1>
	<tr>
		<th></th>
		<th<?php if($weekday == 1) echo " class='active'"; ?>>Poniedziałek</th>
		<th<?php if($weekday == 2) echo " class='active'"; ?>>Wtorek</th>
		<th<?php if($weekday == 3) echo " class='active'"; ?>>Środa</th>
		<th<?php if($weekday == 4) echo " class='active'"; ?>>Czwartek</th>
		<th<?php if($weekday == 5) echo " class='active'"; ?>>Piątek</th>
	</tr>
  <?php
    for($i = $start; $i < $stop; $i->add(new DateInterval('P7D')))
    {
      $v = DateTime::createFromFormat('Y-m-d', $i->format('Y-m-d'));
      echo "<tr class='date'><th></th>";
      for($j = 0; $j < 5; $j++)
      {
        echo "<th id='d".$v->format("Y-m-d")."'>".$v->format("m-d")."</th>";
        $v->add(new DateInterval("P1D"));
      }
      echo "</tr>";
      $hours = array("8:00<br>9:35", "9:50<br>11:25", "11:40<br>13:15", "13:30<br>15:05", "15:45<br>17:20", "17:35<br>19:10", "19:25<br>21:00");
      for($j = 0; $j < 7; $j++)
      {
       $v = DateTime::createFromFormat('Y-m-d', $i->format('Y-m-d'));
       echo "<tr><th style='font-size: 12px;'>".$hours[$j]."</th>";
       echo "<td id='b".$v->format("Y-m-d-").$j."'></td>";$v->add(new DateInterval("P1D"));
       echo "<td id='b".$v->format("Y-m-d-").$j."'></td>";$v->add(new DateInterval("P1D"));
       echo "<td id='b".$v->format("Y-m-d-").$j."'></td>";$v->add(new DateInterval("P1D"));
       echo "<td id='b".$v->format("Y-m-d-").$j."'></td>";$v->add(new DateInterval("P1D"));
       echo "<td id='b".$v->format("Y-m-d-").$j."'></td>";$v->add(new DateInterval("P1D"));
       echo "</tr>";
      }
    }
  ?>
  <script>
    $.each(x, function(k, v){
      for(i = 0; i < 7; i++)
      {
        if(v[i].length > 0)
        {
          id = k + "-" + i.toString();
          text=s[v[i][0]][0]
          if(v[i][1] != 'null')
            text += " ("+v[i][1]+")";
          if(v[i][2] != 'null')
            text += " " + v[i][2]
          $("#b"+id).text(text);
          $("#b"+id).css('background-color', s[v[i][0]][1]);
        }
      }
    });
    <?php
      if($weekday > 0 && $weekday < 6)
      {
        $current_time = DateTime::createFromFormat("H:i", $now->format("H:i"));
        $nextday = DateTime::createFromFormat("Y-m-d", $now->format("Y-m-d"));
	$nextday->add(new DateInterval("P1D"));
	echo "$(\"#d".$nextday->format('Y-m-d')."\").addClass('nextday');";
	echo "$(\"#d".$now->format('Y-m-d')."\").addClass('active');";
	$nextday->add(new DateInterval("P1D"));
	echo "$(\"#d".$nextday->format('Y-m-d')."\").addClass('nextnextday');";
        function isBetween($current, $l, $h)
        {
          if($l<=$current && $current<$h) return true;
          return false;
        }
        $timearray = array(
          DateTime::createFromFormat("H:i", "7:45"),
          DateTime::createFromFormat("H:i", "9:35"),
          DateTime::createFromFormat("H:i", "11:25"),
          DateTime::createFromFormat("H:i", "13:15"),
          DateTime::createFromFormat("H:i", "15:15"),
          DateTime::createFromFormat("H:i", "17:20"),
          DateTime::createFromFormat("H:i", "19:10"),
          DateTime::createFromFormat("H:i", "21:00")
        );
        for($i = 0; $i < 7; $i++)
        {
          if(isBetween($current_time, $timearray[$i], $timearray[$i+1]))
          {
              echo "$(\"#b".$now->format('Y-m-d')."-".$i."\").addClass('activeblink');";
              break;
          }
        }
      }
    ?>
  </script>
</table>
