<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>

<style>
    #loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: #0e0c28;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        transition: opacity 0.3s ease;
    }

    .spinner {
        width: 50px;
        height: 50px;
        border: 5px solid #f3f3f3;
        border-top: 5px solid #3498db;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin-bottom: 15px;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    .loading-text {
        font-size: 18px;
        color: white;
        font-weight: bold;
    }
</style>
<div id="loading-overlay">
    <div class="spinner"></div>
    <div class="loading-text">Loading Dashboard...</div>
</div>
<script>
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
</script>