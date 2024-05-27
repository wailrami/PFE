
@props(['reservations'])

<div  id='calendar' class=" bg-slate-200">

</div>
	<script src="{{asset("../dist/index.global.js")}}"></script>
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