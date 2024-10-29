document.addEventListener('DOMContentLoaded', () => {
    const openModalBtn = document.querySelector('.openmodal');
    const modal = document.getElementById('modal');
    const closeModalBtn = document.getElementById('closemodal');

    // Open Modal
    openModalBtn.addEventListener('click', () => {
        modal.classList.remove('opacity-0', 'pointer-events-none', 'scale-0');
        modal.classList.add('opacity-100', 'pointer-events-auto', 'scale-100');
    });

    // Close Modal
    closeModalBtn.addEventListener('click', () => {
        modal.classList.remove('opacity-100', 'pointer-events-auto', 'scale-100');
        modal.classList.add('opacity-0', 'pointer-events-none', 'scale-0');
    });
});
