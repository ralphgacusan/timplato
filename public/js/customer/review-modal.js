// SVG star path (replace with your SVG if needed)
const starSVG = `<svg class="modal-star" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" stroke="#AFCBFF" stroke-width="2" fill="none"/><path class="star-fill" d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" fill="#AFCBFF" style="display:none;"/></svg>`;

// Show modal when Add Review is clicked
document.addEventListener('DOMContentLoaded', function () {
    const addReviewBtn = document.getElementById('addReviewBtn');
    const modalOverlay = document.getElementById('reviewModalOverlay');
    const modalCancelBtn = document.getElementById('modalCancelBtn');
    addReviewBtn.addEventListener('click', function () {
        modalOverlay.style.display = 'flex';
        document.body.style.overflow = 'hidden'; // Prevent background scroll
    });
    modalCancelBtn.addEventListener('click', function () {
        modalOverlay.style.display = 'none';
        document.body.style.overflow = '';
    });
    // Optional: clicking outside modal closes it
    modalOverlay.addEventListener('click', function (e) {
        if (e.target === modalOverlay) {
            modalOverlay.style.display = 'none';
            document.body.style.overflow = '';
        }
    });
});

// Inject stars
const starsContainer = document.getElementById('modalStars');
let currentRating = 0;
if (starsContainer) {
    for (let i = 1; i <= 5; i++) {
        const star = document.createElement('span');
        star.innerHTML = starSVG;
        star.classList.add('modal-star-wrapper');
        star.dataset.value = i;
        star.addEventListener('click', function () {
            setRating(i);
        });
        star.addEventListener('mouseover', function () {
            setRating(i, true);
        });
        star.addEventListener('mouseout', function () {
            setRating(currentRating);
        });
        starsContainer.appendChild(star);
    }
}
function setRating(rating, preview = false) {
    const starWrappers = document.querySelectorAll('.modal-star-wrapper');
    starWrappers.forEach((star, idx) => {
        const svg = star.querySelector('svg');
        const fill = svg.querySelector('.star-fill');
        if (idx < rating) {
            fill.style.display = 'block';
            svg.querySelector('path').setAttribute('stroke', '#2C3E50');
            fill.setAttribute('fill', '#2C3E50');
        } else {
            fill.style.display = 'none';
            svg.querySelector('path').setAttribute('stroke', '#AFCBFF');
            fill.setAttribute('fill', '#AFCBFF');
        }
    });
    if (!preview) currentRating = rating;
}

// Photo preview
const photoInput = document.getElementById('modalReviewPhoto');
const photoPreview = document.getElementById('modalPhotoPreview');
const photoPreviewWrapper = document.querySelector('.modal-photo-preview-wrapper');
const photoTrashIcon = document.querySelector('.modal-photo-trash');
if (photoInput && photoPreview && photoPreviewWrapper && photoTrashIcon) {
    photoInput.addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (ev) {
                photoPreview.src = ev.target.result;
                photoPreview.style.display = 'block';
                photoTrashIcon.style.display = 'none';
            };
            reader.readAsDataURL(file);
        } else {
            photoPreview.src = '';
            photoPreview.style.display = 'none';
            photoTrashIcon.style.display = 'none';
        }
    });
    // Click photo to remove
    photoPreviewWrapper.addEventListener('click', function () {
        if (photoPreview.style.display !== 'none') {
            photoPreview.src = '';
            photoPreview.style.display = 'none';
            photoInput.value = '';
            photoTrashIcon.style.display = 'none';
        }
    });
}

// Cancel button
const cancelBtn = document.getElementById('modalCancelBtn');
if (cancelBtn) {
    cancelBtn.addEventListener('click', function () {
        document.getElementById('reviewModalOverlay').style.display = 'none';
    });
}

// Submit button
const submitBtn = document.getElementById('modalSubmitBtn');
if (submitBtn) {
    submitBtn.addEventListener('click', function () {
        // Collect review data
        const review = document.getElementById('modalReviewText').value;
        const rating = currentRating;
        const photo = photoPreview.src && photoPreview.style.display !== 'none' ? photoPreview.src : null;
        // TODO: Send review data to backend or handle as needed
        alert('Review submitted!\nRating: ' + rating + '\nReview: ' + review);
        document.getElementById('reviewModalOverlay').style.display = 'none';
    });
}