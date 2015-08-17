<?php
//@Author: Azhagupandian - wsnippets.com
function showMonth($month = null, $year = null)
{
$calendar = '';
if($month == null || $year == null) {
$month = date('m');
$year = date('Y');
}
$date = mktime(12, 0, 0, $month, 1, $year);
$daysInMonth = date("t", $date);
$offset = date("w", $date);
$rows = 1;
$prev_month = $month - 1;
$prev_year = $year;
if ($month == 1) {
$prev_month = 12;
$prev_year = $year-1;
}
 
$next_month = $month + 1;
$next_year = $year;
if ($month == 12) {
$next_month = 1;
$next_year = $year + 1;
}
$calendar .= "<div class='panel-heading text-center'><div class='row'><div class='col-md-3 col-xs-4'><a class='ajax-navigation btn btn-default btn-sm' href='calendar.php?month=".$prev_month."&year=".$prev_year."'><span class='glyphicon glyphicon-arrow-left'></span></a></div><div class='col-md-6 col-xs-4'><strong>" . date("F Y", $date) . "</strong></div>";
$calendar .= "<div class='col-md-3 col-xs-4 '><a class='ajax-navigation btn btn-default btn-sm' href='calendar.php?month=".$next_month."&year=".$next_year."'><span class='glyphicon glyphicon-arrow-right'></span></a></div></div></div>";
$calendar .= "<table class='table table-bordered'>";
$calendar .= "<tr><th>Sun</th><th>Mon</th><th>Tue</th><th>Wed</th><th>Thu</th><th>Fri</th><th>Sat</th></tr>";
$calendar .= "<tr>";
for($i = 1; $i <= $offset; $i++) {
$calendar .= "<td></td>";
}
for($day = 1; $day <= $daysInMonth; $day++) {
if( ($day + $offset - 1) % 7 == 0 && $day != 1) {
$calendar .= "</tr><tr>";
$rows++;
}
$calendar .= "<td>" . $day . "</td>";
}
while( ($day + $offset) <= $rows * 7)
{
$calendar .= "<td></td>";
$day++;
}
$calendar .= "</tr>";
$calendar .= "</table>";
return $calendar;
}
 
?>