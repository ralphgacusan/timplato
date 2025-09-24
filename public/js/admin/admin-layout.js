// Dropdown toggle logic
const userToggle = document.getElementById('userDropdownToggle');
const userMenu = document.getElementById('userDropdownMenu');
document.addEventListener('click', function (e) {
    if (userToggle && userMenu) {
        if (userToggle.contains(e.target)) {
            e.preventDefault();
            if (userMenu.classList.contains('dropdown-anim-show')) {
                userMenu.classList.remove('dropdown-anim-show');
                setTimeout(() => {
                    userMenu.style.display = 'none';
                }, 300);
            } else {
                userMenu.style.display = 'block';
                setTimeout(() => {
                    userMenu.classList.add('dropdown-anim-show');
                }, 10);
            }
        } else if (!userMenu.contains(e.target)) {
            if (userMenu.classList.contains('dropdown-anim-show')) {
                userMenu.classList.remove('dropdown-anim-show');
                setTimeout(() => {
                    userMenu.style.display = 'none';
                }, 300);
            } else {
                userMenu.style.display = 'none';
            }
        }
    }
});

// Sidebar expand/collapse toggle
document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.getElementById('sidebar');
    const body = document.body;

    function updateBodySidebarClass() {
        if (sidebar.classList.contains('expanded')) {
            body.classList.add('sidebar-expanded');
        } else {
            body.classList.remove('sidebar-expanded');
        }
    }

    sidebar.addEventListener('mouseenter', function () {
        sidebar.classList.add('expanded');
        updateBodySidebarClass();
    });
    sidebar.addEventListener('mouseleave', function () {
        sidebar.classList.remove('expanded');
        updateBodySidebarClass();
    });
    sidebar.addEventListener('click', function () {
        sidebar.classList.toggle('expanded');
        updateBodySidebarClass();
    });
});