// Sidebar switching
document.querySelectorAll('#sidebarMenu li').forEach(function (item) {
    item.addEventListener('click', function () {
        document.querySelectorAll('#sidebarMenu li').forEach(li => li.classList.remove('active'));
        item.classList.add('active');
        // Change content based on sidebar
        const content = document.getElementById('deliveryContent');
        switch (item.dataset.content) {
            case 'account':
                content.innerHTML = `<div style='padding:32px;'><h2>My Account</h2><p>Account details and settings go here.</p></div>`;
                break;
            case 'purchase':
                content.innerHTML = `<div style='padding:32px;'><h2>My Purchase</h2><p>List of your purchases will be shown here.</p></div>`;
                break;
            case 'notifications':
                content.innerHTML = `<div style='padding:32px;'><h2>Notifications</h2><p>Your notifications will be shown here.</p></div>`;
                break;
            case 'vouchers':
            default:
                content.innerHTML = '';
        }
    });
});
// Tab switching (only To Ship tab shown)
document.querySelectorAll('.delivery-tab').forEach(function (tab) {
    tab.addEventListener('click', function () {
        document.querySelectorAll('.delivery-tab').forEach(t => t.classList.remove('active'));
        tab.classList.add('active');
    });
    // Only one tab, but you can add more logic here if needed
    //     const content = document.getElementById('deliveryContent');
    //     content.innerHTML = `<div class='order-card'>
    //         <div class='order-header'>
    //             <div><span class='mall'>Mall</span> <span class='store'>Lenovo Audio Official Store</span></div>
    //             <div class='order-actions'>
    //                 <button>Chat</button>
    //                 <button>View Shop</button>
    //             </div>
    //         </div>
    //         <div class='order-details'>
    //             <img src='../img/product-placeholder.png' alt='Product'>
    //             <div class='order-info'>
    //                 <div class='title'>Lenovo Mini Earbuds LP19 Wireless Bluetooth Earphones Semi In Ear Hifi Stereo Waterproof Intelligent Touch Control Mini With Microphone Bluetooth 5.1</div>
    //                 <div class='variation'>Variation: Black</div>
    //                 <div class='qty'>x1</div>
    //             </div>
    //             <div class='order-status'>
    //                 <div class='delivered'>Parcel has been delivered</div>
    //                 <div class='to-receive'>TO RECEIVE</div>
    //             </div>
    //         </div>
    //         <div class='order-footer'>
    //             <div class='confirm'>Confirm receipt after you've checked the received items</div>
    //             <div class='total'>Order Total: ₱486</div>
    //         </div>
    //         <div class='order-actions-main'>
    //             <button class='received'>Order Received</button>
    //             <button class='refund'>Request For Return/Refund</button>
    //             <button class='contact'>Contact Seller</button>
    //         </div>
    //     </div>`;
    // });
});