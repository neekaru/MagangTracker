document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.toggle-password').forEach(item => {
        item.addEventListener('click', function () {
            const inputGroup = this.closest('.input-group');
            if (inputGroup) {
                const input = inputGroup.querySelector('input');
                const icon = this.querySelector('i');
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            }
        });
    });
});