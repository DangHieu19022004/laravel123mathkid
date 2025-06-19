<!-- SweetAlert2 for better alerts -->
<script type="text/javascript" src="{{ asset('js/sweetalert2.min.js') }}"></script>

<!-- Custom Scripts -->
<script>
    // Common game functions
    function showSuccess(message) {
        return Swal.fire({
            icon: 'success',
            title: 'Tuyệt vời!',
            text: message,
            confirmButtonText: 'Tiếp tục'
        });
    }

    function showError(message) {
        return Swal.fire({
            icon: 'error',
            title: 'Chưa đúng!',
            text: message,
            confirmButtonText: 'Thử lại'
        });
    }

    // Add animation to cards
    document.addEventListener('DOMContentLoaded', function () {
        const cards = document.querySelectorAll('.game-card');
        cards.forEach(card => {
            card.classList.add('fade-in');
        });
    });
</script>
