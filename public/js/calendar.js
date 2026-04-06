var selectedDate = null;
var selectedTaskId = null;
var calendar;

document.addEventListener("DOMContentLoaded", function () {
    var calendarEl = document.getElementById("calendar");
    calendar = new FullCalendar.Calendar(calendarEl, {
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
        eventClick: function (info) {
            selectedTaskId = info.event.id;
            console.log("Task ID:", selectedTaskId);
            document.getElementById("task-modal-title").textContent =
                info.event.title;
            document.getElementById("task-modal-uc").textContent =
                "📚 " + (info.event.extendedProps.uc || "");
            document.getElementById("task-notes").value =
                info.event.extendedProps.notes || "";
            document.getElementById("task-modal").classList.remove("hidden");
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

window.closeTaskModal = function () {
    document.getElementById("task-modal").classList.add("hidden");
    selectedTaskId = null;
};

window.saveNotes = function () {
    var notes = document.getElementById("task-notes").value;
    fetch("/task/" + selectedTaskId + "/notes", {
        method: "PUT",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": csrfToken,
        },
        body: JSON.stringify({ notes: notes }),
    })
        .then((res) => res.json())
        .then((data) => {
            window.closeTaskModal();
            var msg = document.createElement("div");
            msg.textContent = "✅ Notes saved!";
            msg.style.cssText =
                "position:fixed;bottom:24px;right:24px;background:#764ba2;color:#fff;padding:12px 20px;border-radius:8px;font-size:0.95rem;z-index:9999;";
            document.body.appendChild(msg);
            setTimeout(() => location.reload(), 1500);
        })
        .catch((err) => console.log("erro:", err));
};

window.closeModal = function () {
    document.getElementById("modal").classList.add("hidden");
};
