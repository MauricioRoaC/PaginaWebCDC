
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');
            if (!calendarEl) return;

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'es',
                height: "auto",
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,listWeek'
                },
                buttonText: {
                    today: 'Hoy',
                    month: 'Mes',
                    week: 'Semana',
                    list: 'Lista'
                },
                // URL de tu backend Laravel
                events: 'http://127.0.0.1:8000/api/events',

                // Añadir descripción también en la vista "Lista"
                eventDidMount: function(info) {
                    // Solo para vistas tipo lista (listDay, listWeek, listMonth, etc.)
                    if (info.view.type.startsWith('list')) {
                        var titleEl = info.el.querySelector('.fc-list-event-title');
                        if (titleEl && info.event.extendedProps.description) {
                            var descEl = document.createElement('div');
                            descEl.classList.add('text-muted', 'small');
                            descEl.textContent = info.event.extendedProps.description;
                            titleEl.appendChild(descEl);
                        }
                    }
                },

                // Al hacer clic, mostrar modal con datos
                eventClick: function(info) {
                    info.jsEvent.preventDefault();

                    var title = info.event.title || 'Sin asunto';
                    var location = info.event.extendedProps.location || 'No especificada';
                    var description = info.event.extendedProps.description || 'Sin descripción';
                    
                    var start = info.event.start;
                    var end = info.event.end;

                    var options = {
                        dateStyle: 'full',
                        timeStyle: 'short'
                    };

                    var dateText = '';
                    if (start) {
                        dateText = start.toLocaleString('es-BO', options);
                        if (end) {
                            // Solo añadimos hora de fin para no repetir la fecha completa
                            dateText += ' - ' + end.toLocaleTimeString('es-BO', { timeStyle: 'short' });
                        }
                    } else {
                        dateText = 'Sin fecha registrada';
                    }

                    document.getElementById('eventTitle').textContent = title;
                    document.getElementById('eventLocation').textContent = location;
                    document.getElementById('eventDescription').textContent = description;
                    document.getElementById('eventDateTime').textContent = dateText;

                    // Mostrar modal con Bootstrap 5
                    var modalEl = document.getElementById('eventModal');
                    var modal = new bootstrap.Modal(modalEl);
                    modal.show();
                }
            });

            calendar.render();
        });
   