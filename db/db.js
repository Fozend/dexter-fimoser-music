function toggleEditRow(userId) {
    const editRow = document.getElementById(`edit-row-${userId}`);
    editRow.style.display = editRow.style.display === 'none' || editRow.style.display === '' ? 'table-row' : 'none';
}

function hideEditRow(userId) {
    const editRow = document.getElementById(`edit-row-${userId}`);
    editRow.style.display = 'none';
}