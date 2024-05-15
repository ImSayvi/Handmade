function confirmDelete() {
    if (confirm("Czy na pewno chcesz usunąć tę kategorię?")) {
        return true; 
    } else {
        return false;
    }
}