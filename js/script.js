window.addEventListener('scroll', function() {
    var y = window.scrollY;
    if (y > 0) {
        document.getElementById('navbar').classList.add('shadow');
    } else {
        document.getElementById('navbar').classList.remove('shadow');
    }
});
document.addEventListener('DOMContentLoaded', (event) => {
    const tooltip = document.querySelector('.card');
    const tooltipText = tooltip.querySelector('.tooltiptext');

    tooltip.addEventListener('click', () => {
        if (tooltipText.style.visibility === 'visible') {
            tooltipText.style.visibility = 'hidden';
            tooltipText.style.opacity = '0';
        } else {
            tooltipText.style.visibility = 'visible';
            tooltipText.style.opacity = '1';
        }
    });
});
function toggleMenu() {
    const mobileNav = document.getElementById('mobileNav');
    if (mobileNav.style.display === "flex") {
        mobileNav.style.display = "none";
    } else {
        mobileNav.style.display = "flex";
    }
}
