
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');
            if (!calendarEl) return;

            const status = document.createElement('div');
            status.setAttribute('role', 'status');
            status.className = 'small mb-2';
            calendarEl.before(status);
            const legend = document.createElement('p');
            legend.className = 'small mb-3';
            legend.textContent = 'Hora de Bolivia (UTC−4) · Azul: próximo · Verde: en curso · Gris: finalizado';
            calendarEl.before(legend);
            const mobile = window.matchMedia('(max-width: 767px)');
            const toolbar = () => mobile.matches
                ? {left:'prev,next', center:'title', right:'today,listWeek,dayGridMonth'}
                : {left:'prev,next today', center:'title', right:'dayGridMonth,timeGridWeek,listWeek'};
            var calendar = new FullCalendar.Calendar(calendarEl, {
              
                initialView: mobile.matches ? 'listWeek' : 'dayGridMonth',
                timeZone: 'America/La_Paz',
                eventTimeFormat: {hour:'2-digit', minute:'2-digit', hour12:false},
                dayMaxEvents: true,
                eventDisplay: 'block',
                locale: 'es',
                height: "auto",
                headerToolbar: toolbar(),
                buttonText: {
                    today: 'Hoy',
                    month: 'Mes',
                    week: 'Semana',
                    list: 'Lista'
                },
                // URL de tu backend Laravel
                events: window.APP_CONFIG.backendUrl + '/api/events',
                loading: function(isLoading) {
                    if (isLoading) status.textContent = 'Cargando eventos…';
                    else if (status.textContent === 'Cargando eventos…') status.textContent = '';
                },
                eventSourceSuccess: function(events) {
                    status.textContent = '';
                    const now = Date.now();
                    const today = luxon.DateTime.now().setZone('America/La_Paz').toISODate();
                    return events.map(event => {
                        const start = event.allDay ? event.start : Date.parse(event.start);
                        const end = event.allDay ? event.end : Date.parse(event.end || event.start);
                        const finished = event.allDay ? (end ? end <= today : start < today) : end < now;
                        const active = !finished && (event.allDay ? start <= today : start <= now);
                        const color = finished ? '#64748b' : active ? '#287448' : '#245c99';
                        return {...event, backgroundColor:color, borderColor:color, textColor:'#ffffff'};
                    });
                },
                eventSourceFailure: function() {
                    status.replaceChildren(document.createTextNode('No se pudieron cargar los eventos. '));
                    const retry = document.createElement('button');
                    retry.type = 'button';
                    retry.className = 'btn btn-outline-secondary btn-sm';
                    retry.textContent = 'Reintentar';
                    retry.addEventListener('click', () => calendar.refetchEvents());
                    status.appendChild(retry);
                },

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
                        timeStyle: 'short',
                        timeZone: 'America/La_Paz'
                    };

                    var dateText = '';
                    if (start) {
                        dateText = info.event.allDay ? info.event.startStr + ' (Todo el día)' : start.toLocaleString('es-BO', options);
                        if (end && !info.event.allDay) {
                            dateText += ' — ' + end.toLocaleString('es-BO', options);
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
                    var modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                    modal.show();
                }
            });

            calendar.render();
            mobile.addEventListener('change', () => calendar.setOption('headerToolbar', toolbar()));
        });
   