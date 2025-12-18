

document.addEventListener('DOMContentLoaded', function () {
    // Product Category Carousel
    if (document.querySelector('.product-carousel.swiper')) {
        new Swiper('.product-carousel.swiper', {
            slidesPerView: 5,
            slidesPerGroup: 1,
            spaceBetween: 14,
            navigation: {
                nextEl: '.product-carousel .swiper-button-next',
                prevEl: '.product-carousel .swiper-button-prev',
            },
            loop: false,
        });
    }

    // Suggested Products Carousel
    if (document.querySelector('.suggested-products-swiper')) {
        new Swiper('.suggested-products-swiper', {
            slidesPerView: 6,
            slidesPerGroup: 1,
            spaceBetween: 16,
            navigation: {
                nextEl: '.suggested-products-swiper .suggested-swiper-next',
                prevEl: '.suggested-products-swiper .suggested-swiper-prev',
            },
            loop: false,
        });
    }

    // Wishlist toggle
    const wishlistButtons = document.querySelectorAll('.add-to-wishlist2');
    wishlistButtons.forEach(button => {
        button.addEventListener('click', function (event) {
            event.preventDefault();
            event.stopPropagation();
            this.classList.toggle('active');
            const icon = this.querySelector('i');
            if (this.classList.contains('active')) {
                icon.classList.remove('fa-regular');
                icon.classList.add('fa-solid');
            } else {
                icon.classList.remove('fa-solid');
                icon.classList.add('fa-regular');
            }
        });
    });

    // Cart add
    const cartButtons = document.querySelectorAll('.add-to-cart-btn');
    cartButtons.forEach(button => {
        button.addEventListener('click', function (event) {
            event.preventDefault();
            const productId = this.getAttribute('data-id');
            const quantity = 1;
            const formData = new URLSearchParams();
            formData.append('product_id', productId);
            formData.append('quantity', quantity);
            fetch('add_to_cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: formData.toString(),
            })
                .then(response => response.text())
                .then(data => {
                    console.log(data);
                    alert('Product successfully added to your cart!');
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to add product to cart. Please try again.');
                });
        });
    });
});