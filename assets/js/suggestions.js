const input = document.getElementById("taskTitle");
const box = document.getElementById("suggestionsBox");

const ideas = [
    "Study for exam",
    "Complete homework",
    "Review notes",
    "Clean room",
    "Pay bills",
    "Prepare project report",
    "Buy groceries",
    "Call family",
    "Workout session"
];

input.addEventListener("input", () => {
    let val = input.value.toLowerCase();
    box.innerHTML = "";

    if (val.length === 0) return;

    let filtered = ideas.filter(i => i.toLowerCase().includes(val));
    filtered.slice(0,5).forEach(s => {
        let div = document.createElement("div");
        div.innerText = s;
        div.style.padding = "8px";
        div.style.cursor = "pointer";
        div.onclick = () => {
            input.value = s;
            box.innerHTML = "";
        };
        box.appendChild(div);
    });
});
