document.addEventListener('DOMContentLoaded', () => {
    const prevBtn = document.querySelector('.prev-btn');
    const nextBtn = document.querySelector('.next-btn');
    const container = document.querySelector('.carousel-container');
    const slides = document.querySelectorAll('.carousel-slide');
    let index = 0;

    function showSlide(i) {
        if (i >= slides.length) index = 0;
        else if (i < 0) index = slides.length - 1;
        else index = i;

        container.style.transform = `translateX(${-index * 100}%)`;
    }

    nextBtn.addEventListener('click', () => {
        showSlide(index + 1);
    });

    prevBtn.addEventListener('click', () => {
        showSlide(index - 1);
    });

    // Opcional: cambiar automáticamente las imágenes cada 5 segundos
    setInterval(() => {
        showSlide(index + 1);
    }, 5000);
});
