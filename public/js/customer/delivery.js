document.addEventListener('DOMContentLoaded', () => {
    const sidebarItems = document.querySelectorAll('#sidebarMenu li');
    const purchaseTabs = document.querySelector('#purchaseTabs');
    const deliveryContent = document.querySelector('#deliveryContent');
    const notificationsSection = document.querySelector('.notifications-section');

    sidebarItems.forEach(item => {
        item.addEventListener('click', () => {
            // Remove active class from sidebar
            sidebarItems.forEach(li => li.classList.remove('active'));
            item.classList.add('active');

            if (item.dataset.content === 'purchase') {
                purchaseTabs.style.display = 'flex';
                deliveryContent.style.display = 'block';
                notificationsSection.style.display = 'none';
            } else if (item.dataset.content === 'notifications') {
                purchaseTabs.style.display = 'none';
                deliveryContent.style.display = 'none';
                notificationsSection.style.display = 'block';
            }
        });
    });

    // Tab switching for Purchase section only
    const tabs = document.querySelectorAll('.delivery-tab');
    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');

            const target = tab.getAttribute('data-tab');
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.remove('active');
                if (content.getAttribute('data-content') === target) {
                    content.classList.add('active');
                }
            });
        });
    });
});
