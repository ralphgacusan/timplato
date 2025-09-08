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

// Search bar expand/collapse (expand to the left)
const searchToggle = document.getElementById('searchToggle');
const searchBar = document.getElementById('navbarSearchBar');
let searchOpen = false;
if (searchToggle && searchBar) {
    // Set initial styles for left expansion
    searchBar.style.right = '220px';
    searchBar.style.left = 'auto';
    searchBar.style.textAlign = 'left';
    searchBar.style.direction = 'ltr';

    searchToggle.addEventListener('click', function (e) {
        e.preventDefault();
        searchOpen = !searchOpen;
        if (searchOpen) {
            searchBar.style.display = 'block';
            setTimeout(() => {
                searchBar.style.width = '1020px';
                searchBar.style.padding = '6px 12px';
                searchBar.focus();
            }, 10);
        } else {
            searchBar.style.width = '0';
            searchBar.style.padding = '0';
            setTimeout(() => {
                searchBar.style.display = 'none';
            }, 300);
        }
    });
    // Hide search bar if click outside
    document.addEventListener('click', function (e) {
        if (searchOpen && !searchBar.contains(e.target) && !searchToggle.contains(e.target)) {
            searchBar.style.width = '0';
            searchBar.style.padding = '0';
            searchOpen = false;
            setTimeout(() => {
                searchBar.style.display = 'none';
            }, 300);
        }
    });
}

function showNotification(message, type = 'success', duration = 6000) {
    const container = document.getElementById('notification-container');
    const notif = document.createElement('div');
    notif.className = `notification ${type}`;
    notif.innerHTML = `
                <span>${message}</span>
                <span class="close-btn" onclick="this.parentElement.remove()">×</span>
            `;

    container.appendChild(notif);

    setTimeout(() => {
        notif.remove();
    }, duration);
}