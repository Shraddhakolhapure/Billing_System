document.getElementById('addMore').addEventListener('click', function() {
    let newItemSection = document.createElement('div');
    newItemSection.classList.add('form-section');
    
    newItemSection.innerHTML = `
        <input type="text" name="itemName[]" placeholder="Item Name" required>
        <input type="number" name="quantity[]" placeholder="Quantity" required>
        <input type="number" name="price[]" placeholder="Price (₹)" required>
    `;
    
    document.querySelector('.form-section').appendChild(newItemSection);
});
