// Function to handle the delete action for users, bookings, and orders
function handleDelete(type, id) {
    if (confirm(`Are you sure you want to delete this ${type}?`)) {
        fetch(`php/delete_${type}.php`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ id: id }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(`${type.charAt(0).toUpperCase() + type.slice(1)} deleted successfully.`);
                location.reload(); // Refresh the page to show updated data
            } else {
                alert(`Failed to delete ${type}.`);
            }
        })
        .catch(error => console.error('Error:', error));
    }
}

// Function to handle the edit action for users, bookings, and orders
function handleEdit(type, id) {
    const newValue = prompt(`Enter new value for ${type} (ID: ${id}):`);
    
    if (newValue !== null && newValue.trim() !== "") {
        fetch(`php/edit_${type}.php`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ id: id, newValue: newValue }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(`${type.charAt(0).toUpperCase() + type.slice(1)} updated successfully.`);
                location.reload(); // Refresh the page to show updated data
            } else {
                alert(`Failed to update ${type}.`);
            }
        })
        .catch(error => console.error('Error:', error));
    } else {
        alert(`Invalid input. Please try again.`);
    }
}

// Adding event listeners for delete and edit buttons
document.addEventListener('DOMContentLoaded', function () {
    // Attach event listeners to all delete buttons
    const deleteButtons = document.querySelectorAll('button.delete');
    deleteButtons.forEach(button => {
        const type = button.dataset.type;
        const id = button.dataset.id;
        button.addEventListener('click', () => handleDelete(type, id));
    });

    // Attach event listeners to all edit buttons
    const editButtons = document.querySelectorAll('button.edit');
    editButtons.forEach(button => {
        const type = button.dataset.type;
        const id = button.dataset.id;
        button.addEventListener('click', () => handleEdit(type, id));
    });
});
