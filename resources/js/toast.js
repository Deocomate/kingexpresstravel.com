import Swal from 'sweetalert2';

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 2500,
    timerProgressBar: true,
    customClass: {
        popup: 'custom-toast'
    },
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});

window.showSuccessToast = function(message) {
    Toast.fire({
        icon: 'success',
        title: message
    });
}

window.showErrorToast = function(message) {
    Toast.fire({
        icon: 'error',
        title: message
    });
}
