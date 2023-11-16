document.querySelector('#btn-show-password').addEventListener('click', function() {
    let input = document.querySelector('#yourPassword');
    if (input.type == 'password') {
        input.type = 'text';
        this.innerHTML = '<i class="bi bi-eye-slash"></i>';
    } else {
        input.type = 'password';
        this.innerHTML = '<i class="bi bi-eye"></i>';
    }
});