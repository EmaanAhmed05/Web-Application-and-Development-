// Dark Mode - ONE BUTTON FOR ENTIRE WEBSITE
function toggleDark() {
    document.body.classList.toggle('dark-mode');
    const isDark = document.body.classList.contains('dark-mode');
    localStorage.setItem('darkMode', isDark);
    
    const btns = document.querySelectorAll('.dark-mode-btn');
    btns.forEach(btn => {
        btn.innerHTML = isDark ? '☀️ Light Mode' : '🌙 Dark Mode';
    });
}

function loadDarkMode() {
    const savedDark = localStorage.getItem('darkMode');
    if(savedDark === 'true') {
        document.body.classList.add('dark-mode');
        const btns = document.querySelectorAll('.dark-mode-btn');
        btns.forEach(btn => {
            btn.innerHTML = '☀️ Light Mode';
        });
    }
}

// Other Functions
function confirmDelete() {
    return confirm('Are you sure you want to delete this task?');
}

function openEdit(id, title, desc, date, category, priority) {
    const modal = document.getElementById('modal');
    if(modal) {
        modal.style.display = 'block';
        document.getElementById('edit-id').value = id;
        document.getElementById('edit-title').value = title;
        document.getElementById('edit-desc').value = desc || '';
        document.getElementById('edit-date').value = date || '';
        if(document.getElementById('edit-category')) {
            document.getElementById('edit-category').value = category || 'other';
        }
        if(document.getElementById('edit-priority')) {
            document.getElementById('edit-priority').value = priority || 'medium';
        }
    }
}

function closeModal() {
    const modal = document.getElementById('modal');
    if(modal) modal.style.display = 'none';
}

function validateTask(form) {
    if(form.title.value.trim() === '') {
        alert('Title required');
        return false;
    }
    return true;
}

function validateAuth(form) {
    let ok = true;
    form.querySelectorAll('input').forEach(i => {
        if(!i.value.trim()) {
            i.style.border = '2px solid red';
            ok = false;
        } else {
            i.style.border = '1px solid #ccc';
        }
    });
    return ok;
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    loadDarkMode();
    
    const btns = document.querySelectorAll('.dark-mode-btn');
    btns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            toggleDark();
        });
    });
});
