// Open task editor
function openTask(taskID) {
    window.location.href = "edit_task.php?id=" + taskID;
}

// Animate timeline items staggered
document.addEventListener("DOMContentLoaded", () => {
    const items = document.querySelectorAll(".timeline-item");

    items.forEach((item, i) => {
        item.style.opacity = 0;
        setTimeout(() => {
            item.style.transition = "0.4s";
            item.style.opacity = 1;
            item.style.transform = "translateY(0)";
        }, i * 120);
    });
});
