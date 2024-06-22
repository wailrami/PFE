
@props(['reservations'])

<div  id='calendar' class=" bg-slate-200">

</div>
	<script src="{{asset("../dist/index.global.js")}}"></script>
	<script src='https://cdn.jsdelivr.net/npm/rrule@2.6.6/dist/es5/rrule.min.js'></script>
	<script>
            
		var events = new Array();
		@foreach($reservations as $reservation)
			events.push({
				title: 'Reserved by {{ $reservation->client->user->nom.' '.$reservation->client->user->prenom }} (Status: {{ $reservation->etat == 'enattente' ? 'Pending' : ($reservation->etat == 'accepte' ? 'Accepted' : 'Rejected')}})',
				start: '{{ $reservation->res_date }}T{{ $reservation->start_time }}',
				end: '{{ $reservation->res_date }}T{{ $reservation->end_time }}',
				textColor: 'white',
				borderColor: "{{($reservation->etat == 'enattente' ? 'orange' : ($reservation->etat == 'accepte' ? 'green' : 'red'))}}",
				backgroundColor: "{{($reservation->etat == 'enattente' ? 'orange' : ($reservation->etat == 'accepte' ? 'green' : 'red'))}}",
			});
		@endforeach

		//adding an rrule event to the event (element of events array) by periodicReservation variable
		// @foreach($reservations as $reservation)
		// 	@if($reservation->periodicReservation)
		// 		var rule = new RRule({
		// 			freq: RRule.WEEKLY,
		// 			interval: 1,
		// 			byweekday: [RRule.MO, RRule.TU, RRule.WE, RRule.TH, RRule.FR, RRule.SA, RRule.SU],
		// 			dtstart: new Date('{{ $reservation->res_date }}T{{ $reservation->start_time }}'),
		// 			until: new Date('{{ $reservation->end_date }}T{{ $reservation->end_time }}')
		// 		});
		// 		var ruleDates = rule.all();
		// 		ruleDates.forEach(function(date) {
		// 			events.push({
		// 				title: 'Reserved by {{ $reservation->client->user->nom.' '.$reservation->client->user->prenom }} (Status: {{ $reservation->etat == 'enattente' ? 'Pending' : ($reservation->etat == 'accepte' ? 'Accepted' : 'Rejected')}})',
		// 				start: date,
		// 				end: new Date(date.getTime() + new Date('{{ $reservation->res_date }}T{{ $reservation->end_time }}').getTime() - new Date('{{ $reservation->res_date }}T{{ $reservation->start_time }}').getTime(),
		// 				textColor: 'white',
		// 				borderColor: "{{($reservation->etat == 'enattente' ? 'orange' : ($reservation->etat == 'accepte' ? 'green' : 'red'))}}",
		// 				backgroundColor: "{{($reservation->etat == 'enattente' ? 'orange' : ($reservation->etat == 'accepte' ? 'green' : 'red'))}}",
		// 			});
		// 		});
		// 	@endif
		// @endforeach 

		document.addEventListener('DOMContentLoaded', function() {
		const calendarEl = document.getElementById('calendar')
		const calendar = new FullCalendar.Calendar(calendarEl, {
		//   initialView: 'dayGridMonth'
		headerToolbar: {
			left: 'prev,next today',
			center: 'title',
			right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
		},
		navLinks: true, // can click day/week names to navigate views
		editable: false,
		events: events
		})
		calendar.render()
		})
	</script>