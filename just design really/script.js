
document.addEventListener('DOMContentLoaded', () => {
    const taskInput = document.getElementById('task-input');
    const addTaskBtn = document.getElementById('add-task-button');
    const taskList = document.getElementById('task-list');
    const emptyImage = document.querySelector('.empty-image');

    const toggleEmptyState = () => {
        emptyImage.computedStyleMap.display = taskList.children.length == 0 ? 'block' : 'none';
    };

    const addTask = (event) => {
        event.preventDefault();
        const tasktext = taskInput.value.trim();
        if (!tasktext) {
            return;
        }

        const li = document.createElement('li');
        li.innerHTML = '
        <input type="checkbox" class="task-checkbox">
        <span>$task-text">' + tasktext + '</span>
        <button class="delete-task-button">Delete</button>
        ';  

        taskList.appendChild(li);
        taskInput.value = '';
        toggleEmptyState();
    };

    addTaskBtn.addEventListener('click', addTask);  
    taskInput.addEventListener('keypress', function(event) {
        if (event.key === 'Enter') {
            addTask(event);
        }
    })
});