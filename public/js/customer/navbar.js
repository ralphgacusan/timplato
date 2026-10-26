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
    if (!container) return;

    const notificationTypes = ['success', 'error', 'info', 'warning'];
    const safeType = notificationTypes.includes(type) ? type : 'success';
    const notif = document.createElement('div');
    notif.className = `notification ${safeType}`;

    const messageText = document.createElement('span');
    messageText.textContent = String(message ?? '');

    const closeButton = document.createElement('button');
    closeButton.type = 'button';
    closeButton.className = 'close-btn';
    closeButton.setAttribute('aria-label', 'Close notification');
    closeButton.textContent = '×';
    closeButton.style.background = 'transparent';
    closeButton.style.border = '0';
    closeButton.style.color = 'inherit';
    closeButton.style.font = 'inherit';
    closeButton.style.fontWeight = 'bold';
    closeButton.style.cursor = 'pointer';
    closeButton.addEventListener('click', () => notif.remove());

    notif.append(messageText, closeButton);

    container.appendChild(notif);

    setTimeout(() => {
        notif.remove();
    }, duration);
}

document.addEventListener('DOMContentLoaded', function () {
    const bell = document.getElementById('notificationToggle');
    const modal = document.getElementById('notificationModal');
    if (!bell || !modal) return;

    function toggleModal() {
        modal.classList.toggle('show');
    }

    function closeModal() {
        modal.classList.remove('show');
    }

    // Toggle modal when bell is clicked
    bell.addEventListener('click', function (e) {
        e.preventDefault();
        e.stopPropagation(); // Prevent document click from firing
        toggleModal();
    });

    // Close when clicking outside modal
    document.addEventListener('click', function (e) {
        if (modal.classList.contains('show') && !modal.contains(e.target) && e.target !== bell) {
            closeModal();
        }
    });

    // Optional: close on Escape key
    document.addEventListener('keydown', function (e) {
        if (e.key === "Escape") {
            closeModal();
        }
    });
});
