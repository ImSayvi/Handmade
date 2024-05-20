document.addEventListener('DOMContentLoaded', function () {
    var myModal = new bootstrap.Modal(document.getElementById('exampleModal'), {
        backdrop: 'static'
    });
    myModal.show();

    document.querySelectorAll('[data-bs-toggle="modal"]').forEach(function (element) {
        element.addEventListener('click', function () {
            var target = document.querySelector(element.getAttribute('data-bs-target'));
            var modal = bootstrap.Modal.getInstance(target) || new bootstrap.Modal(target);
            modal.show();
        });
    });
});
