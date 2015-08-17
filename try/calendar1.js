$(document).ready(function(){
callCalendar('calendar.php');
$('body').delegate('.ajax-navigation', 'click', function(e){
e.preventDefault();
callCalendar($(this).attr('href'));
});
});
function callCalendar(url) {
$.get(url,function(data){
$('.calendar').html(data);
});
}