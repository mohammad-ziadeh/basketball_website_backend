(function () {
    const calendarOffcanvas = new bootstrap.Offcanvas(
        "#calendar-add_edit_event"
    );
    const calendarModal = new bootstrap.Modal("#calendar-modal");
    let calEvent = null;

    const calendar = new FullCalendar.Calendar(
        document.getElementById("calendar"),
        {
            headerToolbar: {
                left: "prev,next today",
                center: "title",
                right: "dayGridMonth,timeGridWeek,timeGridDay,listMonth",
            },
            themeSystem: "bootstrap",
            initialView: "timeGridWeek",
            height: "auto",
            selectable: true,
            editable: true,
            navLinks: true,
            selectMirror: true,
            slotMinTime: "08:00:00",
            slotMaxTime: "20:00:00",
            slotDuration: "00:30:00",
            eventTimeFormat: {
                hour: "2-digit",
                minute: "2-digit",
                hour12: false,
            },
            select: function (info) {
                // Use local date/time, not ISO string
                document.getElementById("pc-e-sdate").value = formatLocal(
                    info.start
                );
                document.getElementById("pc-e-edate").value = formatLocal(
                    info.end
                );
                document.getElementById("pc-e-title").value = "";
                document.getElementById("pc-e-venue").value = "";
                document.getElementById("pc-e-description").value = "";
                document.getElementById("pc-e-type").value = "event-primary";
                document.getElementById("pc-e-btn-text").innerHTML =
                    '<i class="align-text-bottom me-1 ti ti-calendar-plus"></i> Add';
                document
                    .getElementById("pc_event_add")
                    .setAttribute("data-pc-action", "add");
                calendarOffcanvas.show();
                calendar.unselect();
            },
            eventClick: function (info) {
                calEvent = info.event;
                document.querySelector(".calendar-modal-title").textContent =
                    calEvent.title;
                document.querySelector(".pc-event-title").textContent =
                    calEvent.title;
                document.querySelector(".pc-event-description").textContent =
                    calEvent.extendedProps.description || "";
                document.querySelector(".pc-event-date").textContent =
                    formatLocalDisplay(calEvent.start) +
                    (calEvent.end
                        ? " to " + formatLocalDisplay(calEvent.end)
                        : "");
                document.querySelector(".pc-event-venue").textContent =
                    calEvent.extendedProps.venue || "";
                calendarModal.show();
            },
            events: function (fetchInfo, successCallback, failureCallback) {
                axios
                    .get("/events")
                    .then((res) => {
                        const events = res.data.map((ev) => ({
                            id: ev.id,
                            title: ev.title,
                            start: ev.start_date, // keep local datetime string
                            end: ev.end_date,
                            description: ev.description,
                            venue: ev.venue,
                            className: ev.type,
                        }));
                        successCallback(events);
                    })
                    .catch((err) => failureCallback(err));
            },
        }
    );

    calendar.render();

    // Format local datetime for inputs (YYYY-MM-DDTHH:MM)
    function formatLocal(date) {
        const pad = (n) => n.toString().padStart(2, "0");
        const d = new Date(date);
        return `${d.getFullYear()}-${pad(d.getMonth() + 1)}-${pad(
            d.getDate()
        )}T${pad(d.getHours())}:${pad(d.getMinutes())}`;
    }

    // Format local datetime for display
    function formatLocalDisplay(date) {
        const d = new Date(date);
        const pad = (n) => n.toString().padStart(2, "0");
        return `${pad(d.getDate())}/${pad(
            d.getMonth() + 1
        )}/${d.getFullYear()} ${pad(d.getHours())}:${pad(d.getMinutes())}`;
    }

    document.addEventListener("DOMContentLoaded", function () {
        const addBtn = document.getElementById("pc_event_add");
        const editBtn = document.getElementById("pc_event_edit");
        const removeBtn = document.getElementById("pc_event_remove");

        if (addBtn) {
            addBtn.addEventListener("click", function () {
                const action = this.getAttribute("data-pc-action");
                const payload = {
                    title: document.getElementById("pc-e-title").value,
                    venue: document.getElementById("pc-e-venue").value,
                    description:
                        document.getElementById("pc-e-description").value,
                    type: document.getElementById("pc-e-type").value,
                    start_date: document.getElementById("pc-e-sdate").value,
                    end_date: document.getElementById("pc-e-edate").value,
                };

                if (action === "add") {
                    axios
                        .post("/events", payload)
                        .then((res) => {
                            calendar.addEvent({
                                id: res.data.id,
                                title: res.data.title,
                                start: res.data.start_date,
                                end: res.data.end_date,
                                description: res.data.description,
                                venue: res.data.venue,
                                className: res.data.type,
                            });
                            calendarOffcanvas.hide();
                            Swal.fire(
                                "Success",
                                "Event added successfully",
                                "success"
                            );
                        })
                        .catch((err) =>
                            Swal.fire("Error", "Failed to add event", "error")
                        );
                } else if (action === "edit" && calEvent) {
                    axios
                        .put(`/events/${calEvent.id}`, payload)
                        .then((res) => {
                            calEvent.remove();
                            calendar.addEvent({
                                id: res.data.id,
                                title: res.data.title,
                                start: res.data.start_date,
                                end: res.data.end_date,
                                description: res.data.description,
                                venue: res.data.venue,
                                className: res.data.type,
                            });
                            calendarOffcanvas.hide();
                            Swal.fire(
                                "Success",
                                "Event updated successfully",
                                "success"
                            );
                        })
                        .catch((err) =>
                            Swal.fire(
                                "Error",
                                "Failed to update event",
                                "error"
                            )
                        );
                }
            });
        }

        if (editBtn) {
            editBtn.addEventListener("click", function () {
                if (!calEvent) return;
                document.getElementById("pc-e-title").value = calEvent.title;
                document.getElementById("pc-e-venue").value =
                    calEvent.extendedProps.venue || "";
                document.getElementById("pc-e-description").value =
                    calEvent.extendedProps.description || "";
                document.getElementById("pc-e-type").value =
                    calEvent.classNames[0] || "event-primary";
                document.getElementById("pc-e-sdate").value = formatLocal(
                    calEvent.start
                );
                document.getElementById("pc-e-edate").value = formatLocal(
                    calEvent.end || calEvent.start
                );
                document.getElementById("pc-e-btn-text").innerHTML =
                    '<i class="align-text-bottom me-1 ti ti-calendar-stats"></i> Update';
                addBtn.setAttribute("data-pc-action", "edit");
                calendarModal.hide();
                calendarOffcanvas.show();
            });
        }

        if (removeBtn) {
            removeBtn.addEventListener("click", function () {
                if (!calEvent) return;
                Swal.fire({
                    title: "Are you sure?",
                    text: "You want to delete this event?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "Cancel",
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.delete(`/events/${calEvent.id}`).then(() => {
                            calEvent.remove();
                            calendarModal.hide();
                            Swal.fire(
                                "Deleted",
                                "Event has been deleted.",
                                "success"
                            );
                        });
                    }
                });
            });
        }
    });
})();
