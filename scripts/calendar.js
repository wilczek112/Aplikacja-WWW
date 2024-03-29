var calendar;
var Calendar = FullCalendar.Calendar;
var events = [];

$(function() {

    if (!!scheds) {
        Object.keys(scheds).map(k => {
            var row = scheds[k]
            events.push({ id: row.id, title: row.title, start: row.start_date, end: row.end_date });
        });
    }

    var date = new Date()
    var d = date.getDate(),
        m = date.getMonth(),
        y = date.getFullYear(),

        calendar = new Calendar(document.getElementById('calendar'), {
            headerToolbar: {
                left: 'prev,next today',
                right: 'dayGridMonth,dayGridWeek,list',
                center: 'title',
            },
            hour12: false,
            mon: true,
            selectable: false,
            themeSystem: 'bootstrap',
            events: events,
            eventClick: function(info) {
                var details = $('#event-details-modal');
                var id = info.event.id;

                if (!!scheds[id]) {
                    details.find('#title').text(scheds[id].title);
                    details.find('#description').text(scheds[id].description);
                    details.find('#start').text(scheds[id].sdate);
                    details.find('#end').text(scheds[id].edate);
                    details.find('#edit,#delete').attr('data-id', id);
                    details.modal('show');
                } else {
                    alert("Event is undefined");
                }
            },
            editable: true
        });

    calendar.render();

    // Form reset listener
    $('#schedule-form').on('reset', function() {
        $(this).find('input:hidden').val('');
        $(this).find('input:visible').first().focus();
    });

    // Edit Button
    $('#edit').click(function() {
        var id = $(this).attr('data-id');

        if (!!scheds[id]) {
            var form = $('#schedule-form');

            console.log(String(scheds[id].start_date), String(scheds[id].start_date).replace(" ", "\\t"));
            form.find('[name="id"]').val(id);
            form.find('[name="title"]').val(scheds[id].title);
            form.find('[name="description"]').val(scheds[id].description);
            form.find('[name="start_date"]').val(String(scheds[id].start_date).replace(" ", "T"));
            form.find('[name="end_date"]').val(String(scheds[id].end_date).replace(" ", "T"));
            $('#event-details-modal').modal('hide');
            form.find('[name="title"]').focus();
        } else {
            alert("Event is undefined");
        }
    });

    // Delete Button / Deleting an Event
    $('#delete').click(function() {
        var id = $(this).attr('data-id');

        if (!!scheds[id]) {
            var _conf = confirm("Czy na pewno chcesz usunąć to wydarzenie?");
            if (_conf === true) {
                location.href = "../calendar/delete_calendar.php?id=" + id;
            }
        } else {
            alert("Niezidentyfikowane wydarzenie");
        }
    });
});