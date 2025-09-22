const toast = {
    success(title, message) {
        toastr.success(message, title);
    },
    info(title, message) {
        toastr.info(message, title);
    },
    error(title, message) {
        toastr.error(message, title);
    },
    warning(title, message) {
        toastr.warning(message, title);
    }
};
