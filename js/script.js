window.addEventListener('load',() => {
    setTimeout(function() {
        const preload = document.querySelector('.preload');
        preload.classList.add('preload-finish');
    }, 2500);
});