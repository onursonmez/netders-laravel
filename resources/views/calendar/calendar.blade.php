<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.5.0/main.min.css">
    <link href='https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.13.1/css/all.css' rel='stylesheet'>
    <style>
        .fc .fc-bg-event{opacity:1;background-color:#f9f9f9}
    </style>
    <script src='https://cdn.jsdelivr.net/npm/moment@2.27.0/min/moment.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.5.0/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.5.0/locales-all.js"></script>
    <script src="{{ asset('vendor/chat/vendor/sweetalert2.js') }}"></script>

    <div class="card mb-4 box-shadow">
        <div class="card-header">
            <h4 class="mb-0 pt-3 pb-3">{{ Lang::get('calendar.live_lesson_calendar') }}</h4>
        </div>
        <div class="card-body">
            <div id='calendar'></div>
            <input type="hidden" name="lesson_id" id="lesson_id" value="" />
            <input type="hidden" name="lesson_minute" id="lesson_minute" value="" />
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'timeGridWeek',
            initialDate: moment().utc().add(1,'days').startOf('day').toDate(),
            locale: 'tr',
            timeZone: '{{ Auth::user()->timezone->code ?? "Europe/Istanbul" }}',
            themeSystem: 'bootstrap',
            height: 300,
            allDaySlot: false,
            selectable: true,
            slotDuration: '00:15',
            slotLabelInterval: 15,
            slotMinTime: '{{ \Carbon\Carbon::parse($definition_min)->format("H:i") }}',
            slotMaxTime: '{{ \Carbon\Carbon::parse($definition_max)->format("H:i") }}',
            
            firstDay: moment().day(),     
                     
            slotLabelFormat: [
                {
                    hour: '2-digit',
                    minute: '2-digit',
                    omitZeroMinute: false,
                    meridiem: 'long'
                    }
            ],
            events: [
                @if($lessons->count() > 0)
                @foreach($lessons as $lesson)
                {
                    title: '{{ Lang::get("calendar.full") }}',
                    start: "{{ \Carbon\Carbon::parse($lesson->start_at, 'UTC')->setTimezone(Auth::user()->timezone->code ?? 'Europe/Istanbul')->format('Y-m-d H:i') }}",
                    end: "{{ \Carbon\Carbon::parse($lesson->end_at, 'UTC')->setTimezone(Auth::user()->timezone->code ?? 'Europe/Istanbul')->format('Y-m-d H:i') }}",
                },                 
                @endforeach
                @endif

                @if($exceptions->count() > 0)
                @foreach($exceptions as $exception)
                {
                    title: '{{ Lang::get("calendar.closed") }}',
                    groupId: 'exceptionId',
                    start: "{{ \Carbon\Carbon::parse($exception->from_date, 'UTC')->setTimezone(Auth::user()->timezone->code ?? 'Europe/Istanbul')->format('Y-m-d H:i') }}",
                    end: "{{ \Carbon\Carbon::parse($exception->to_date, 'UTC')->setTimezone(Auth::user()->timezone->code ?? 'Europe/Istanbul')->format('Y-m-d H:i') }}",
                    display: 'background',
                },                 
                @endforeach
                @endif

                {
                    title: '{{ Lang::get("calendar.closed") }}',
                    groupId: 'todayId',
                    start: moment().utc().subtract(1, 'year').startOf('day').toDate(),
                    end: moment().utc().endOf('day').toDate(),
                    display: 'background',
                },                   

                @if(!$definition->d1_from && !$definition->d1_to)
                {
                    title: '',
                    groupId: 'definitionId',
                    startTime: '00:00',
                    endTime: '23:45',
                    daysOfWeek: [1],
                    display: 'background',
                },
                @else
                {
                    title: '',
                    groupId: 'definitionId',
                    startTime: '{{ $definition->d1_from ? \Carbon\Carbon::parse($definition->d1_from, "UTC")->setTimezone(Auth::user()->timezone->code ?? "Europe/Istanbul")->format("H:i") : "00:00" }}',
                    endTime: '{{ $definition->d1_to ? \Carbon\Carbon::parse($definition->d1_to, "UTC")->setTimezone(Auth::user()->timezone->code ?? "Europe/Istanbul")->format("H:i") : "23:45" }}',
                    daysOfWeek: [1],
                    display: 'inverse-background',
                },               
                @endif

                @if(!$definition->d2_from && !$definition->d2_to)
                {
                    title: '{{ Lang::get("calendar.closed") }}',
                    groupId: 'definitionId',
                    startTime: '00:00',
                    endTime: '23:45',
                    daysOfWeek: [2],
                    display: 'background',
                },
                @else
                {
                    title: '{{ Lang::get("calendar.closed") }}',
                    groupId: 'definitionId',
                    startTime: '{{ $definition->d2_from ? \Carbon\Carbon::parse($definition->d2_from, "UTC")->setTimezone(Auth::user()->timezone->code ?? "Europe/Istanbul")->format("H:i") : "00:00" }}',
                    endTime: '{{ $definition->d2_to ? \Carbon\Carbon::parse($definition->d2_to, "UTC")->setTimezone(Auth::user()->timezone->code ?? "Europe/Istanbul")->format("H:i") : "23:45" }}',
                    daysOfWeek: [2],
                    display: 'inverse-background',
                },               
                @endif  

                @if(!$definition->d3_from && !$definition->d3_to)
                {
                    title: '',
                    groupId: 'definitionId',
                    startTime: '00:00',
                    endTime: '23:45',
                    daysOfWeek: [3],
                    display: 'background',
                },
                @else
                {
                    title: '',
                    groupId: 'definitionId',                    
                    startTime: '{{ $definition->d3_from ? \Carbon\Carbon::parse($definition->d3_from, "UTC")->setTimezone(Auth::user()->timezone->code ?? "Europe/Istanbul")->format("H:i") : "00:00" }}',
                    endTime: '{{ $definition->d3_to ? \Carbon\Carbon::parse($definition->d3_to, "UTC")->setTimezone(Auth::user()->timezone->code ?? "Europe/Istanbul")->format("H:i") : "23:45" }}',
                    daysOfWeek: [3],
                    display: 'inverse-background',
                },               
                @endif                    

                @if(!$definition->d4_from && !$definition->d4_to)
                {
                    title: '',
                    groupId: 'definitionId',
                    startTime: '00:00',
                    endTime: '23:45',
                    daysOfWeek: [4],
                    display: 'background',
                },
                @else
                {
                    title: '',
                    groupId: 'definitionId',
                    startTime: '{{ $definition->d4_from ? \Carbon\Carbon::parse($definition->d4_from, "UTC")->setTimezone(Auth::user()->timezone->code ?? "Europe/Istanbul")->format("H:i") : "00:00" }}',
                    endTime: '{{ $definition->d4_to ? \Carbon\Carbon::parse($definition->d4_to, "UTC")->setTimezone(Auth::user()->timezone->code ?? "Europe/Istanbul")->format("H:i") : "23:45" }}',
                    daysOfWeek: [4],
                    display: 'inverse-background',
                },               
                @endif 

                @if(!$definition->d5_from && !$definition->d5_to)
                {
                    title: '',
                    groupId: 'definitionId',
                    startTime: '00:00',
                    endTime: '23:45',
                    daysOfWeek: [5],
                    display: 'background',
                },
                @else
                {
                    title: '',
                    groupId: 'definitionId',
                    startTime: '{{ $definition->d5_from ? \Carbon\Carbon::parse($definition->d5_from, "UTC")->setTimezone(Auth::user()->timezone->code ?? "Europe/Istanbul")->format("H:i") : "00:00" }}',
                    endTime: '{{ $definition->d5_to ? \Carbon\Carbon::parse($definition->d5_to, "UTC")->setTimezone(Auth::user()->timezone->code ?? "Europe/Istanbul")->format("H:i") : "23:45" }}',
                    daysOfWeek: [5],
                    display: 'inverse-background',
                },               
                @endif 


                @if(!$definition->d6_from && !$definition->d6_to)
                {
                    title: '',
                    groupId: 'definitionId',
                    startTime: '00:00',
                    endTime: '23:45',
                    daysOfWeek: [6],
                    display: 'background',
                },
                @else
                {
                    title: '',
                    groupId: 'definitionId',
                    startTime: '{{ $definition->d6_from ? \Carbon\Carbon::parse($definition->d6_from, "UTC")->setTimezone(Auth::user()->timezone->code ?? "Europe/Istanbul")->format("H:i") : "00:00" }}',
                    endTime: '{{ $definition->d6_to ? \Carbon\Carbon::parse($definition->d6_to, "UTC")->setTimezone(Auth::user()->timezone->code ?? "Europe/Istanbul")->format("H:i") : "23:45" }}',
                    daysOfWeek: [6],
                    display: 'inverse-background',
                },               
                @endif    

                @if(!$definition->d7_from && !$definition->d7_to)
                {
                    title: '',
                    groupId: 'definitionId',
                    startTime: '00:00',
                    endTime: '23:45',
                    daysOfWeek: [0],
                    display: 'background',
                },
                @else
                {
                    title: '',
                    groupId: 'definitionId',
                    startTime: '{{ $definition->d7_from ? \Carbon\Carbon::parse($definition->d7_from, "UTC")->setTimezone(Auth::user()->timezone->code ?? "Europe/Istanbul")->format("H:i") : "00:00" }}',
                    endTime: '{{ $definition->d7_to ? \Carbon\Carbon::parse($definition->d7_to, "UTC")->setTimezone(Auth::user()->timezone->code ?? "Europe/Istanbul")->format("H:i") : "23:45" }}',
                    daysOfWeek: [0],
                    display: 'inverse-background',
                },               
                @endif               
            ],          
            customButtons: {
                selectLessonButton: {
                text: '',
                click: function() 
                {
                    @if(!Auth::check())
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: '{{ Lang::get("auth.login_required") }}',
                    });    
                    @else                    
                    var url = base_url + 'calendar/load_lessons';
                    var title = '{{ Lang::get("general.live_lessons") }}';
                
                    $('#dynamic_modal h5').html('');
                    $('#dynamic_modal .modal-body').html('');
                
                    $.post(url, { user_id: {{ $user->id }}, previous_lesson_id: $('#lesson_id').val(), previous_lesson_minute: $('#lesson_minute').val() }, function(res){
                        $('#dynamic_modal h5').html(title);
                        $('#dynamic_modal .modal-body').html(res.html);
                        $('#dynamic_modal .modal-dialog').removeClass('modal-lg');
                        $('#dynamic_modal').modal('show');
                    });   
                    @endif                     
                }
                }
            },    
            headerToolbar: {
                left: 'selectLessonButton',
                center: 'title',
                right: 'prev,next'
            },      
            
            dateClick: function(info) 
            {
                var lesson_id = $('#lesson_id').val();
                var lesson_minute = $('#lesson_minute').val();                

                @if(!Auth::check())
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: '{{ Lang::get("auth.login_required") }}',
                    });    
                @else
                if(!lesson_id && !lesson_minute)
                    {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: '{{ Lang::get("calendar.please_select_lesson_before") }}',
                        });                                    
                    }
                    else             
                    {
                        $.post(base_url + 'calendar/check', { date: info.dateStr, user_id: {{ $user->id }}, lesson_minute: $('#lesson_minute').val() }, function(response){
                            if(!response.success)
                            {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: '{{ Lang::get("calendar.lesson_out_of_available_date") }}',
                                });                                    
                                calendar.unselect();
                            }
                            else
                            {
                                if(moment().add(1,'days').startOf('day').diff(info.dateStr) >= 0)
                                {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: '{{ Lang::get("calendar.please_select_future_date") }}',
                                    });                                  
                                    return false;
                                } 
                                else
                                {
                                    $.post(base_url + 'calendar/add', {date: info.dateStr, user_id: {{ $user->id }}, lesson_id: lesson_id, lesson_minute: lesson_minute}, function(response){
                                        if(response.success)
                                        {
                                            calendar.addEvent({
                                                title: '{{ Lang::get("calendar.reserved") }}',
                                                start: response.start_date,
                                                end: response.end_date,
                                                color: "orange"
                                            });

                                            jgrowl(response.message);
                                        }
                                        else
                                        {
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Oops...',
                                                text: '{{ Lang::get("calendar.please_select_another_date") }}',
                                            });                                             
                                        }
                                    }).fail(function(xhr, status, error){
                                        var responseText = JSON.parse(xhr.responseText);
                                            if(typeof responseText.errors !== "undefined")
                                            {
                                                $.each(responseText.errors, function(i, item) {
                                                    jgrowl(item, 'red');
                                                });
                                            }
                                    });
                                } 
                            }
                        }); 
                    }
                @endif      
            }                                 
        });
        calendar.render();

        $('.fc-selectLessonButton-button').html('{{ Lang::get("general.select_lesson") }}');

    });

    </script>   