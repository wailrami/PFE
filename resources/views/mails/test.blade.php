<html>
    <head>
        <title>Jasmin</title>
        <script src="../dist/index.global.js"></script>
        <meta name="csrf-token" content="{{ csrf_token() }}">

        @vite('resources/css/app.css')
        @vite('resources/js/dropzone.js')
    @vite('resources/css/dropzone.css')
    </head>
    
    <body>
        
        
        <div id='calendar' class="size-1/2"></div>

        <form action="/upload" method="post" class="dropzone dropzone-previews" id="myDropzone">
            @csrf
            <div class="fallback">
              
              <input type="file" name="images" accept="image/*" multiple id="" class="hidden">
            </div>

        </form>
        

        <script>
            

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
        })
        calendar.render()
      })
            </script>
    </body>

    
    
</html>