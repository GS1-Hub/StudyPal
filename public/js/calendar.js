var selectedDate = null;

document.addEventListener("DOMContentLoaded", function () {
    var calendarEl = document.getElementById("calendar");
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: "dayGridMonth",
        headerToolbar: {
            left: "prev,next today",
            center: "title",
            right: "dayGridMonth,timeGridWeek",
        },
        events: calendarEvents,
        dateClick: function (info) {
            selectedDate = info.dateStr;
            openModal(info.dateStr);
        },
    });
    calendar.render();
});

function openModal(date) {
    document.getElementById("modal-date").textContent = "Date: " + date;
    document.getElementById("modal").classList.remove("hidden");

    fetch("/tasks/unscheduled")
        .then((res) => res.json())
        .then((tasks) => {
            var list = document.getElementById("task-list");
            list.innerHTML = "";

            if (tasks.length === 0) {
                list.innerHTML = "<li>No tasks without date.</li>";
                return;
            }

            var grouped = {};
            tasks.forEach((task) => {
                var ucName = task.uc.name;
                if (!grouped[ucName]) grouped[ucName] = [];
                grouped[ucName].push(task);
            });

            Object.keys(grouped).forEach((ucName) => {
                var header = document.createElement("li");
                header.textContent = "📚 " + ucName;
                header.style.fontWeight = "bold";
                header.style.color = "#764ba2";
                header.style.cursor = "default";
                header.style.background = "none";
                header.style.border = "none";
                header.style.padding = "8px 0 4px";
                list.appendChild(header);

                grouped[ucName].forEach((task) => {
                    var li = document.createElement("li");
                    li.textContent = task.name;
                    li.onclick = () => assignTask(task.id);
                    list.appendChild(li);
                });
            });
        });
}

function assignTask(taskId) {
    fetch("/task/" + taskId + "/date", {
        method: "PUT",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": csrfToken,
        },
        body: JSON.stringify({ due_date: selectedDate }),
    }).then(() => {
        closeModal();
        location.reload();
    });
}

function closeModal() {
    document.getElementById("modal").classList.add("hidden");
}
