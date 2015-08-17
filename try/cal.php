<?php
function curPageURL() {
 $pageURL = 'http';
 //if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}
?>
<?php
/* Hijri-Gregorian Calendar v.1.0.
by Tayeb Habib of www.redacacia.wordpress.com email tayeb.habib@gmail.com
a special thanks to Khaled Mamdouh ofwww.vbzoom.com for Hijri Conversion function.
Updated, and added Islamic names of months by Samir Greadly xushi@xushi.homelinux.org.
The code is "ehsalle-sawab" (benefit of the soul) of late Abdul Habib Mohamed, of
Pemba, Mozambique,late father of the author of this code.
*/

//timezone settings
$timezone = "Asia/Kuala_Lumpur";
if(function_exists('date_default_timezone_set')) date_default_timezone_set ($timezone);

//request for next and previous month
if (isset($_REQUEST["month"])){
	$month = $_REQUEST['month'];
	//$cMonth = $_REQUEST["month"];	
} else {
	$month = date("n",time());
}

if (isset($_REQUEST["year"])){	
	$year = $_REQUEST['year'];
	//$cYear = $_REQUEST["year"];
} else {
	$year = date("Y",time());
}

// obtain month, today date etc
//$month = (isset($month)) ? $month : date("n",time());
$monthnames = array("January","February","March","April","May","June","July","August","September","October","November","December");
$textmonth = $monthnames[$month - 1];
//$year = (isset($year)) ? $year : date("Y",time());
$today = (isset($today))? $today : date("j", time());
$today = ($month == date("n",time())) ? $today : 32;

// The Names of Hijri months
$mname = array("Muharram","Safar","Rabi'ul Awal","Rabi'ul Akhir","Jamadil Awal","Jamadil Akhir","Rajab","Sha'ban","Ramadhan","Shawwal","Zul Qida","Zul Hijja");
// End of the names of Hijri months

// Setting how many days each month has
if ( (($month <8 ) && ($month % 2 == 1)) || (($month > 7) && ($month % 2 ==
0)) ) $days = 31;
if ( (($month <8 ) && ($month % 2 == 0)) || (($month > 7) && ($month % 2 ==
1)) )
$days = 30;

//checking leap year to adjust february days
if ($month == 2)
$days = (date("L",time())) ? 29 : 28;

$dayone = date("w",mktime(1,1,1,$month,1,$year));
$daylast = date("w",mktime(1,1,1,$month,$days,$year));
$middleday = intval(($days-1)/2);

//checking the hijri month on beginning of gregorian calendar
$date_hijri = date("$year-$month-1");
list ($HDays, $HMonths, $HYear) = Hijri($date_hijri);
$smon_hijridone = $mname[$HMonths-1];
$syear_hijridone = $HYear;

//checking the hijri month on end of gregorian calendar
$date_hijri = date("$year-$month-$days");
list ($HDays, $HMonths, $HYear) = Hijri($date_hijri);
$smon_hijridlast = $mname[$HMonths-1];
$syear_hijridlast = $HYear;
//checking the hijri month on middle of gregorian calendar
$date_hijri = date("$year-$month-$middleday");
list ($HDays, $HMonths, $HYear) = Hijri($date_hijri);
$smon_hijridmiddle = $mname[$HMonths-1];
$syear_hijridmiddle = $HYear;

// checking if there's a span of a year
if ($syear_hijridone == $syear_hijridlast) {
$syear_hijridone = "";
}

//checking if span of month is only one or two or three hijri months
if (($smon_hijridone == $smon_hijridmiddle) AND ($smon_hijridmiddle == $smon_hijridlast)) {
$smon_hijri = $smon_hijridone."".$syear_hijridlast;
}

if (($smon_hijridone == $smon_hijridmiddle) AND ($smon_hijridmiddle != $smon_hijridlast)) {
$smon_hijri = $smon_hijridone."".$syear_hijridone."&nbsp;-&nbsp;".$smon_hijridlast."".$syear_hijridlast;
}
if (($smon_hijridone != $smon_hijridmiddle) AND ($smon_hijridmiddle == $smon_hijridlast)) {
$smon_hijri = $smon_hijridone."".$syear_hijridone."&nbsp;-&nbsp;".$smon_hijridlast."".$syear_hijridlast;
}

if (($smon_hijridone != $smon_hijridmiddle) AND ($smon_hijridmiddle != $smon_hijridlast)) {
$smon_hijri = $smon_hijridone."".$syear_hijridone."&nbsp;-&nbsp;"."&nbsp;-&nbsp;".$smon_hijridmiddle."&nbsp;-&nbsp;".$smon_hijridlast."&nbsp;".$syear_hijridlast;
}

//generating calendar pagination
//and ajax request.
$prev_year = $year;
$next_year = $year;
$prev_month = $month-1;
$next_month = $month+1;

 
if ($prev_month == 0 ) {
    $prev_month = 12;
    $prev_year = $year - 1;
	
}
if ($next_month == 13 ) {
    $next_month = 1;
    $next_year = $year + 1;
}

$prevCount = $month - 2;
$nextCount = $month;

//$prevText = $monthnames[$prevCount];
//$nextText = $monthnames[$nextCount];

if($prevCount < 0){
	//$prevCount = 12;
	$prevText = $monthnames[$prevCount + 12];
} else {
	$prevText = $monthnames[$month - 2];
}

if($nextCount == 12){
	$nextText = $monthnames[$nextCount - 12];
} else {
	$nextText = $monthnames[$nextCount];
}

// next part of code generates calendar
?>

<h2 class="cal-title"><?PHP echo '<span class="greg">'.$textmonth."&nbsp;".$year."</span><span class=\"hij\">".$smon_hijri."</span>"; ?></h2>
<div class="calendar-pagination">
	<a id="prev">&laquo;&nbsp;<?php echo $prevText; ?></a>
    <a id="next"><?php echo $nextText; ?>&nbsp;&raquo;</a>
</div>
<div class="calendar-wrapper">
          <header class="days">
    <div class="cell">AHAD</div>
    <div class="cell">ISNIN</div>
    <div class="cell">SELASA</div>
    <div class="cell">RABU</div>
    <div class="cell">KHAMIS</div>
    <div class="cell">JUMAAT</div>
    <div class="cell">SABTU</div>
  </header>
<?php

if($dayone != 0){
	$span1 = $dayone;
} else {
	$span1 = '';
}
if(6 - $daylast != 0){
	$span2 = 6 - $daylast;
} else { 
	$span2 = ''; 
}
for($i = 1; $i <= $days; $i++):
$dayofweek = date("w",mktime(1,1,1,$month,$i,$year));
$width = "14%";

if($dayofweek == 0 || $dayofweek == 6)
$width = "15%";

$x = strlen($i);
if ($x == 1){ $b = "0".$i;}
if ($x == 2){ $b = $i;}

$x = strlen($month);
if ($x == 1){ $c = "0".$month;}
if ($x == 2){ $c = $month;}
$data=$year."-".$c."-".$b;

if($i == 1 || $dayofweek == 0):
echo "<section>";
if($span1 > 0 && $i == 1)
for($j=0; $j < $span1; $j++){
echo '<div class="cell">&nbsp;</div>';
}
endif;
?>
          <div class="cell <?php echo ($i == $today) ? 'cellToday' : ''; ?>"><span>
    <?php
$date_hijri = date("$year-$month-$i");
list ($HDays, $HMonths, $HYear) = Hijri($date_hijri);
if ($HDays == 30) {
 $i = $i + 1;
 $date_hijri = date("$year-$month-$i");
 list ($HDays, $HMonths, $HYear) = Hijri($date_hijri);
 if ($HDays == 2) {
 $HDays = 1;
 }
 else {
 $HDays = 30;
 }
 $i = $i - 1;
 }

 $sday_hijri = $i."</span><span class=\"hij\">".$HDays."</span>";
// display da data
echo $sday_hijri;

/*if($i == $today){
	echo '<div class="data"><a href="#'.$i.'" class="cbData">Kuliyyah Magrhib<br />Ustaz Johari</a></div>';
	echo '<div style="display:none;"><div id="'.$i.'" class="
	dataContent"><h3 class="title-pengajian">Kuliyyah Magrhib</h3>
	<ul>
		<li><span class="label">Penceramah:</span> <p>Ustaz Johari</p></li>
		<li><span class="label">Masa:</span><p>Lepas Solat Maghrib</p></li>
		<li><span class="label">Keterangan:</span><p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.</p></li>
	</ul>
	
	</div></div>';
}*/

?>
  </div>
          <?php
if($i == $days):
if($span2 > 0)
for($j=0; $j < $span2; $j++){
echo '<div class="cell">&nbsp;</div>';
}
endif;
if($dayofweek == 6 || $i == $days):
echo "</section>\n";
endif;
endfor;
$ano = str_replace("20", "", $year);

$x = strlen($today);
if ($x == 1){ $b = "0".$today;}
if ($x == 2){ $b = $today;}
//echo $b;
$x = strlen($month);
if ($x == 1){ $c = "0".$month;}
if ($x == 2){ $c = $month;}
//echo $c;

$data=$year.$c.$b;
?>
          <?php
// Hijri conversion function
// Copyright 2002 by Khaled Mamdouh www.vbzoom.com. Updated, and added
// Islamic names of months by Samir Greadly xushi @xushi.homelinux.org

function Hijri($GetDate)
 {


$TDays=round(strtotime($GetDate)/(60*60*24));
$HYear=round($TDays/354.37419);
$Remain=$TDays-($HYear*354.37419);
$HMonths=round($Remain/29.531182);
$HDays=$Remain-($HMonths*29.531182);
$HYear=$HYear+1389;
$HMonths=$HMonths+10;
$HDays=$HDays+23;

// If the days is over 29, then update month and reset days
if ($HDays>29.531188 and round($HDays)!=30)
{
$HMonths=$HMonths+1;
$HDays=Round($HDays-29.531182);
}

else
{
$HDays=Round($HDays);
}

// If months is over 12, then add a year, and reset months
if($HMonths>12)
{
$HMonths=$HMonths-12;
$HYear=$HYear+1;
}

 return array ($HDays, $HMonths, $HYear);
}
// end of Hijri Conversion function
?>
</div>
<div class="calendar-pagination">
	<a href id="prev">&laquo;&nbsp;<?php echo $prevText; ?></a>
    <a href id="next"><?php echo $nextText; ?>&nbsp;&raquo;</a>
</div>
<script>
$(function(){ $
	('.cbData').colorbox({
		inline: true, 
		width:450, 
		height:350,
		close: 'Press ESC to close'
	}); 
	
	$('.calendar-pagination a').click(function(){
		
		var linkID = $(this).attr('id');
		
		switch(linkID){
			case 'prev':
				$.ajax({
					url: '/calendar.php?month=<?php echo $prev_month;?>&year=<?php echo $prev_year; ?>',
					type: 'post',
					complete: function(){
						FB.XFBML.parse();
					},
					success: function(data){
						$('#pContent').fadeOut();
						$('#pContent').empty().fadeIn().append(data);
					}
				});
			break;
			
			case 'next':
				$.ajax({
					url: 'includes/calendar.php?month=<?php echo $next_month;?>&year=<?php echo $next_year; ?>',
					type: 'post',
					complete: function(){
						FB.XFBML.parse();
					},
					success: function(data){
						$('#pContent').fadeOut();
						$('#pContent').empty().fadeIn().append(data);
					}
				});
			break;
		}
		return false;
	});
	
});
</script>