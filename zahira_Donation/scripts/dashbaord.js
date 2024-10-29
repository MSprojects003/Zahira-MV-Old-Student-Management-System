 
import Navbar from './navbar.js'


 




document.addEventListener("DOMContentLoaded", function() {


    


   
    const openModalBtns = document.querySelectorAll('.openmodal');
        const modal = document.getElementById('modal');
        const closeModalBtn = document.getElementById('closemodal');

        // Open Modal
        openModalBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                modal.classList.remove('opacity-0', 'pointer-events-none', 'scale-0');
                modal.classList.add('opacity-100', 'pointer-events-auto', 'scale-100');
            });
        });

        // Close Modal
        closeModalBtn.addEventListener('click', () => {
            modal.classList.remove('opacity-100', 'pointer-events-auto', 'scale-100');
            modal.classList.add('opacity-0', 'pointer-events-none', 'scale-0');
        });
    

    let navbar = document.querySelector(".nav");
    let bodyContent = document.querySelector(".body");

    function createNavbar() {
        return Navbar();
    }

    navbar.innerHTML = createNavbar();

    // Add event listeners for the navbar items
   
    

   

    

     
    

    

    // Load the home content by default
     // Add the modal event listeners for the first load
});
