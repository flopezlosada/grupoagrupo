<h3><?php echo __("Calendario de Eventos")?></h3>
<div id="fullCalendar"></div>
<div class="clear"></div>
<div class="event_legend"></div>
<div class="clear"></div>

<?php if ($sf_user->isAuthenticated()):?>
<div class="event_show">
  <div class="admin_box"><?php echo link_to(image_tag("admin/event_add", array('class'=>"admin_ico")).__("Añadir evento"),"event/add")?></div>
</div>
<?php endif;?>
<script>
$(function () {
	var date = new Date();
	var d = date.getDate();
	var m = date.getMonth();
	var y = date.getFullYear();
	
	$('#fullCalendar').fullCalendar({
		header: {
			left: 'prev, next',
			center: 'title',
			right: 'month,basicWeek,basicDay,'
		},		
        firstDay: 1,
		lazyFetching:true,
        timeFormat: {
                // for agendaWeek and agendaDay
                agenda: 'H:mm{ - H:mm}', // 5:00 - 6:30

                // for all other views
                '': 'H:mm'            // 7p
        },
        monthNames:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio','Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        dayNames:['Domingo', 'Lunes', 'Martes', 'Miércoles','Jueves', 'Viernes', 'Sábado'],
        monthNamesShort:['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun','Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],

        dayNamesShort:['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sáb'],
        buttonText: {
            prev:     '&nbsp;&#9668;&nbsp;',  // left triangle
            next:     '&nbsp;&#9658;&nbsp;',  // right triangle
            prevYear: '&nbsp;&lt;&lt;&nbsp;', // <<
            nextYear: '&nbsp;&gt;&gt;&nbsp;', // >>
            today:    'hoy',
            month:    'mes',
            week:     'semana',
            day:      'día'
        },
		eventSources: [
                {
                    url: '<?php echo url_for("event/getJsonUtil?type=event")?>', 
					
                }
		]
	});
});	
</script>