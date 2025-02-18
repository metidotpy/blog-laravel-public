// Simple pagination logic
const postsPerPage = 2;
let currentPage = 1;

function loadPosts(page) {
    const posts = document.querySelectorAll('.post');
    const start = (page - 1) * postsPerPage;
    const end = start + postsPerPage;

    posts.forEach((post, index) => {
        if (index >= start && index < end) {
            post.style.display = 'block';
        } else {
            post.style.display = 'none';
        }
    });

    updatePagination();
}

function updatePagination() {
    const totalPosts = document.querySelectorAll('.post').length;
    const totalPages = Math.ceil(totalPosts / postsPerPage);
    const pagination = document.querySelector('.pagination');

    pagination.innerHTML = '';
    for (let i = 1; i <= totalPages; i++) {
        const pageLink = document.createElement('a');
        pageLink.href = '#';
        pageLink.textContent = i;
        pageLink.addEventListener('click', () => {
            currentPage = i;
            loadPosts(currentPage);
        });
        pagination.appendChild(pageLink);
    }
}

window.onload = () => loadPosts(currentPage);

// Toggle mobile navigation menu
const toggleNav = () => {
    const navLinks = document.querySelector('.nav-links');
    navLinks.classList.toggle('active');
};

document.querySelector('.logo').addEventListener('click', toggleNav); // Toggle menu when the logo is clicked
