document.addEventListener('DOMContentLoaded', function () {
    var loadingOverlay = document.getElementById('loading-overlay');

    window.addEventListener('load', function () {
        setTimeout(function () {
            loadingOverlay.style.opacity = '0';
            setTimeout(function () {
                loadingOverlay.style.display = 'none';
            }, 300);
        }, 500);
    });

    setTimeout(function () {
        loadingOverlay.style.opacity = '0';
        setTimeout(function () {
            loadingOverlay.style.display = 'none';
        }, 300);
    }, 3000); 

    
});