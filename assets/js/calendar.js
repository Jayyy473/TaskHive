const calendar = document.getElementById("calendar");
const monthLabel = document.getElementById("monthLabel");

let date = new Date();

function loadCalendar() {
    calendar.innerHTML = "";

    let year = date.getFullYear();
    let month = date.getMonth();

    monthLabel.innerText = date.toLocaleString("default", { month: "long" }) + " " + year;

    let firstDay = new Date(year, month, 1).getDay();
    let daysInMonth = new Date(year, month + 1, 0).getDate();

    // Calendar grid alignment
    for (let i = 0; i < firstDay; i++) {
        let filler = document.createElement("div");
        filler.classList.add("day");
        filler.style.visibility = "hidden";
        calendar.appendChild(filler);
    }

    for (let d = 1; d <= daysInMonth; d++) {
        let dayBox = document.createElement("div");
        dayBox.classList.add("day");
        dayBox.innerText = d;

        let formatted = `${year}-${String(month + 1).padStart(2,"0")}-${String(d).padStart(2,"0")}`;

        // Check if this date has tasks
        let match = events.some(ev => ev.dueDate === formatted);

        if (match) dayBox.classList.add("hasEvent");

        dayBox.onclick = () => {
            window.location.href = `timeline.php?date=${formatted}`;
        };

        calendar.appendChild(dayBox);
    }
}

document.getElementById("prev").onclick = () => {
    date.setMonth(date.getMonth() - 1);
    loadCalendar();
};
document.getElementById("next").onclick = () => {
    date.setMonth(date.getMonth() + 1);
    loadCalendar();
};

loadCalendar();
