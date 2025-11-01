const menuDatabase = {
    appetizers: [
        {name: 'Cheese Stuffed Crispy Potato', price: 85},
        {name: 'Tamarind-Glazed Chicken Wings', price: 110},
        {name: 'Kesong Puti Caprese Skewers', price: 90},
        {name: 'Prawn Cocktails', price: 130},
        {name: 'Stuffed Mushroom', price: 95},
        {name: 'French Onion Dip Cups', price: 80},
        {name: 'Cheese Broccoli Puffs', price: 85},
        {name: 'Spanish Tortilla', price: 100},
        {name: 'Prosciutto-Wrapped Melon', price: 120}
    ],
    main: [
        {name: 'Spaghetti', price: 120},
        {name: 'Shrimp Carbonara Pasta', price: 150},
        {name: 'Honey Glazed Salmon with Rice', price: 230},
        {name: 'Beef Metchado with Rice', price: 180},
        {name: 'Curried Chicken and Rice Casserole', price: 160},
        {name: 'Cordon Bleu', price: 170},
        {name: 'Lemon and Garlic Roast Chicken', price: 160},
        {name: 'Beef Wellington', price: 3888},
        {name: 'Beer Braised Beef with Clams', price: 220}
    ],
    beverages: [
        {name: 'Royal Select', price: 180},
        {name: 'Wine Selection', price: 200},
        {name: 'Chivas Regal', price: 230},
        {name: 'Premium Bar Package', price: 250},
        {name: 'Jack Daniels', price: 220}
    ],
    desserts: [
        {name: 'Cheese Cake', price: 120},
        {name: 'Tiramisu', price: 130},
        {name: 'Macaroons', price: 90},
        {name: 'Cup Cake', price: 80},
        {name: 'Charcuterie', price: 150},
        {name: 'Buckeye Bundt Cake', price: 110},
        {name: 'Cake Pops', price: 85},
        {name: 'Strawberry Pretzel Salad', price: 100},
        {name: 'Carrot Cake', price: 115}
    ]
};

const decorationDatabase = {
    flowers: [
        {name: 'Roses', price: 400},
        {name: 'Tulips', price: 350},
        {name: 'Lilies', price: 380},
        {name: 'Peonies', price: 500},
        {name: 'Purple Orchid', price: 450},
        {name: 'Ranunculus', price: 300},
        {name: 'Celosia', price: 250},
        {name: 'Dahlia', price: 320},
        {name: 'Chrysanthemum', price: 280}
    ],
    lighting: [
        {name: 'Fairy light Canopy', price: 2500},
        {name: 'Up Lighting Glow', price: 500},
        {name: 'Dance floor Illumination', price: 1800},
        {name: 'Gobo Lightning', price: 800},
        {name: 'Chandeliers', price: 1200},
        {name: 'Mason Jar Light', price: 200},
        {name: 'Mirror Ball Tunnel', price: 3500},
        {name: 'Water Ripple Lighting', price: 1500},
        {name: 'Laser Tunnel Entrance', price: 4000}
    ],
    extras: [
        {name: 'Balloon Arrangement (Party)', price: 1500},
        {name: 'Balloon Arrangement (Formal)', price: 2500},
        {name: 'Light Up Letters', price: 3000},
        {name: 'Photo Booth Corner', price: 1100},
        {name: 'Disco Ball and lights', price: 1000},
        {name: 'Memory Wall', price: 900},
        {name: 'Crystal Curtain', price: 1800},
        {name: 'Feather Centerpiece', price: 1200},
        {name: 'Bubble Machine', price: 600}
    ]
};

const soundDatabase = {
    audio: [
        {name: 'Basic Audio', price: 1000},
        {name: 'Standard System', price: 1800},
        {name: 'Premium Package', price: 2500}
    ],
    extras: [
        {name: 'MCs (Host)', price: 800},
        {name: 'Live Band', price: 1500},
        {name: 'Clown', price: 400}
    ]
};

// Global arrays to store selected items
let selectedMenuItems = [];
let selectedDecorations = [];
let selectedSoundSystem = [];

// Load menu items based on category
function loadMenuItems() {
    const category = document.getElementById('menuCategory').value;
    const itemSelect = document.getElementById('menuItem');
    itemSelect.innerHTML = '<option value="">Select Item</option>';
    
    if (category && menuDatabase[category]) {
        menuDatabase[category].forEach(item => {
            const option = document.createElement('option');
            option.value = JSON.stringify(item);
            option.textContent = `${item.name} — ₱${item.price}`;
            itemSelect.appendChild(option);
        });
    }
}

// Load decorations based on category
function loadDecorations() {
    const category = document.getElementById('decorCategory').value;
    const itemSelect = document.getElementById('decorItem');
    itemSelect.innerHTML = '<option value="">Select Item</option>';
    
    if (category && decorationDatabase[category]) {
        decorationDatabase[category].forEach(item => {
            const option = document.createElement('option');
            option.value = JSON.stringify(item);
            option.textContent = `${item.name} — ₱${item.price}`;
            itemSelect.appendChild(option);
        });
    }
}

// Load sound system based on category
function loadSoundSystem() {
    const category = document.getElementById('soundCategory').value;
    const itemSelect = document.getElementById('soundItem');
    itemSelect.innerHTML = '<option value="">Select Item</option>';
    
    if (category && soundDatabase[category]) {
        soundDatabase[category].forEach(item => {
            const option = document.createElement('option');
            option.value = JSON.stringify(item);
            option.textContent = `${item.name} — ₱${item.price}`;
            itemSelect.appendChild(option);
        });
    }
}

// Add menu item
function addMenuItem() {
    const itemSelect = document.getElementById('menuItem');
    const qty = parseInt(document.getElementById('menuQty').value) || 1;
    
    if (itemSelect.value) {
        const item = JSON.parse(itemSelect.value);
        selectedMenuItems.push({
            name: item.name,
            price: item.price,
            quantity: qty
        });
        renderSelectedMenuItems();
        calculateTotalCost();
        
        // Reset
        document.getElementById('menuQty').value = 1;
        itemSelect.value = '';
    } else {
        alert('Please select an item first!');
    }
}

// Add decoration
function addDecoration() {
    const itemSelect = document.getElementById('decorItem');
    const qty = parseInt(document.getElementById('decorQty').value) || 1;
    
    if (itemSelect.value) {
        const item = JSON.parse(itemSelect.value);
        selectedDecorations.push({
            name: item.name,
            price: item.price,
            quantity: qty
        });
        renderSelectedDecorations();
        calculateTotalCost();
        
        // Reset
        document.getElementById('decorQty').value = 1;
        itemSelect.value = '';
    } else {
        alert('Please select an item first!');
    }
}

// Add sound system
function addSoundSystem() {
    const itemSelect = document.getElementById('soundItem');
    const qty = parseInt(document.getElementById('soundQty').value) || 1;
    
    if (itemSelect.value) {
        const item = JSON.parse(itemSelect.value);
        selectedSoundSystem.push({
            name: item.name,
            price: item.price,
            quantity: qty
        });
        renderSelectedSoundSystem();
        calculateTotalCost();
        
        // Reset
        document.getElementById('soundQty').value = 1;
        itemSelect.value = '';
    } else {
        alert('Please select an item first!');
    }
}

// Render selected menu items
function renderSelectedMenuItems() {
    const container = document.getElementById('selectedMenuItems');
    container.innerHTML = '';
    
    selectedMenuItems.forEach((item, index) => {
        const div = document.createElement('div');
        div.className = 'selected-item';
        div.innerHTML = `
            <span><strong>${item.name}</strong> - Qty: ${item.quantity} | ₱${(item.price * item.quantity).toFixed(2)}</span>
            <button type="button" class="remove-item-btn" onclick="removeMenuItem(${index})">Remove</button>
        `;
        container.appendChild(div);
    });
    
    document.getElementById('edit_menu_items').value = JSON.stringify(selectedMenuItems);
}

// Render selected decorations
function renderSelectedDecorations() {
    const container = document.getElementById('selectedDecorations');
    container.innerHTML = '';
    
    selectedDecorations.forEach((item, index) => {
        const div = document.createElement('div');
        div.className = 'selected-item';
        div.innerHTML = `
            <span><strong>${item.name}</strong> - Qty: ${item.quantity} | ₱${(item.price * item.quantity).toFixed(2)}</span>
            <button type="button" class="remove-item-btn" onclick="removeDecoration(${index})">Remove</button>
        `;
        container.appendChild(div);
    });
    
    document.getElementById('edit_decorations').value = JSON.stringify(selectedDecorations);
}

// Render selected sound system
function renderSelectedSoundSystem() {
    const container = document.getElementById('selectedSoundSystem');
    container.innerHTML = '';
    
    selectedSoundSystem.forEach((item, index) => {
        const div = document.createElement('div');
        div.className = 'selected-item';
        div.innerHTML = `
            <span><strong>${item.name}</strong> - Qty: ${item.quantity} | ₱${(item.price * item.quantity).toFixed(2)}</span>
            <button type="button" class="remove-item-btn" onclick="removeSoundSystem(${index})">Remove</button>
        `;
        container.appendChild(div);
    });
    
    document.getElementById('edit_sound_system').value = JSON.stringify(selectedSoundSystem);
}

// Remove functions
function removeMenuItem(index) {
    selectedMenuItems.splice(index, 1);
    renderSelectedMenuItems();
    calculateTotalCost();
}

function removeDecoration(index) {
    selectedDecorations.splice(index, 1);
    renderSelectedDecorations();
    calculateTotalCost();
}

function removeSoundSystem(index) {
    selectedSoundSystem.splice(index, 1);
    renderSelectedSoundSystem();
    calculateTotalCost();
}

// Calculate total cost
function calculateTotalCost() {
    let total = 0;
    
    selectedMenuItems.forEach(item => {
        total += (parseFloat(item.price) || 0) * (parseInt(item.quantity) || 0);
    });
    
    selectedDecorations.forEach(item => {
        total += (parseFloat(item.price) || 0) * (parseInt(item.quantity) || 0);
    });
    
    selectedSoundSystem.forEach(item => {
        total += (parseFloat(item.price) || 0) * (parseInt(item.quantity) || 0);
    });
    
    total = isNaN(total) ? 0 : total;
    
    document.getElementById('displayTotalCost').textContent = total.toFixed(2);
    document.getElementById('edit_total_cost').value = total.toFixed(2);
    
    console.log('Total Cost Calculated:', total);
    console.log('Hidden Field Value:', document.getElementById('edit_total_cost').value);
}

// Open Edit Modal
function openEditModal(booking) {
    document.getElementById('editBookingId').textContent = booking.booking_id;
    document.getElementById('edit_booking_id').value = booking.booking_id;
    document.getElementById('edit_total_guests').value = booking.total_expected_guests || 0;
    
    // Parse existing data
    selectedMenuItems = [];
    selectedDecorations = [];
    selectedSoundSystem = [];
    
    try {
        if (booking.menu_items && booking.menu_items.trim().startsWith('[')) {
            const items = JSON.parse(booking.menu_items);
            selectedMenuItems = items.map(item => ({
                name: item.name,
                price: parseFloat(item.price) || 0,
                quantity: parseInt(item.quantity) || 1
            }));
        }
    } catch (e) {
        console.error('Error parsing menu items:', e);
    }
    
    try {
        if (booking.decorations && booking.decorations.trim().startsWith('[')) {
            const items = JSON.parse(booking.decorations);
            selectedDecorations = items.map(item => ({
                name: item.name,
                price: parseFloat(item.price) || 0,
                quantity: parseInt(item.quantity) || 1
            }));
        }
    } catch (e) {
        console.error('Error parsing decorations:', e);
    }
    
    try {
        if (booking.sound && booking.sound.trim().startsWith('[')) {
            const items = JSON.parse(booking.sound);
            selectedSoundSystem = items.map(item => ({
                name: item.name,
                price: parseFloat(item.price) || 0,
                quantity: parseInt(item.quantity) || 1
            }));
        }
    } catch (e) {
        console.error('Error parsing sound system:', e);
    }
    
    // Render existing items
    renderSelectedMenuItems();
    renderSelectedDecorations();
    renderSelectedSoundSystem();
    calculateTotalCost();
    
    document.getElementById('editModal').style.display = 'flex';
}

// Close Edit Modal
function closeEditModal() {
    document.getElementById('editModal').style.display = 'none';
    selectedMenuItems = [];
    selectedDecorations = [];
    selectedSoundSystem = [];
}

// Form validation before submit
document.addEventListener('DOMContentLoaded', function() {
    const editForm = document.getElementById('editBookingForm');
    if (editForm) {
        editForm.addEventListener('submit', function(e) {
            const totalCost = document.getElementById('edit_total_cost').value;
            
            if (!totalCost || parseFloat(totalCost) <= 0) {
                e.preventDefault();
                alert('Please add items to the booking! Total cost cannot be zero.');
                return false;
            }
            
            console.log('Form submitting with total cost:', totalCost);
            return true;
        });
    }
});

// FIX: Tab switching function - properly show/hide cards
function showTab(tab) {
    const cards = document.querySelectorAll('.booking-table');
    const buttons = document.querySelectorAll('.flex.bg-gray-100 button');
    
    // Update button styles
    buttons.forEach(btn => {
        btn.classList.remove('active', 'border-b-4', 'border-b-[#BF9374]', 'bg-white', 'text-black');
        btn.classList.add('text-gray-600');
    });
    
    const activeBtn = document.getElementById(tab + 'Btn');
    if (activeBtn) {
        activeBtn.classList.remove('text-gray-600');
        activeBtn.classList.add('active', 'border-b-4', 'border-b-[#BF9374]', 'bg-white', 'text-black');
    }
    
    // Show/hide booking cards based on data-tab attribute
    cards.forEach(card => {
        if (card.getAttribute('data-tab') === tab) {
            card.classList.remove('hidden');
            card.classList.add('block', 'animate-fadeInUp');
        } else {
            card.classList.add('hidden');
            card.classList.remove('block');
        }
    });
}

// Modal functions
function showActionModal(id, eventType, action) {
    document.getElementById('modalResId').textContent = id;
    document.getElementById('modalEventType').textContent = eventType;
    document.getElementById('modalResIdInput').value = id;
    
    const approveBtn = document.querySelector('.modal-btn[value="approve"]');
    const declineBtn = document.querySelector('.modal-btn[value="decline"]');
    
    if(action === 'approve') {
        approveBtn.style.display = 'inline-block';
        declineBtn.style.display = 'none';
    } else if(action === 'decline') {
        declineBtn.style.display = 'inline-block';
        approveBtn.style.display = 'none';
    } else {
        approveBtn.style.display = 'inline-block';
        declineBtn.style.display = 'inline-block';
    }
    
    document.getElementById('actionModal').style.display = 'flex';
}

function closeModal() {
    document.getElementById('actionModal').style.display = 'none';
    document.getElementById('owner_message').value = '';
}

// Calendar functions
let currentDate = new Date();
const eventDates = window.eventDatesData || {};

function renderCalendar() {
    const year = currentDate.getFullYear();
    const month = currentDate.getMonth();
    
    document.getElementById('currentMonth').textContent = 
        new Date(year, month).toLocaleDateString('en-US', { month: 'long', year: 'numeric' });
    
    const firstDay = new Date(year, month, 1).getDay();
    const daysInMonth = new Date(year, month + 1, 0).getDate();
    const daysInPrevMonth = new Date(year, month, 0).getDate();
    
    const calendarDates = document.getElementById('calendarDates');
    calendarDates.innerHTML = '';
    
    const today = new Date();
    const todayStr = today.toISOString().split('T')[0];
    
    // Previous month days
    for (let i = firstDay - 1; i >= 0; i--) {
        const day = daysInPrevMonth - i;
        const dateDiv = document.createElement('div');
        dateDiv.className = 'calendar-date other-month';
        dateDiv.textContent = day;
        calendarDates.appendChild(dateDiv);
    }
    
    // Current month days
    for (let day = 1; day <= daysInMonth; day++) {
        const dateDiv = document.createElement('div');
        dateDiv.className = 'calendar-date';
        dateDiv.textContent = day;
        
        const dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
        
        if (dateStr === todayStr) {
            dateDiv.classList.add('today');
        }
        
        if (eventDates[dateStr]) {
            dateDiv.classList.add('has-event');
            dateDiv.title = `${eventDates[dateStr]} event(s)`;
        }
        
        calendarDates.appendChild(dateDiv);
    }
    
    // Next month days
    const totalCells = firstDay + daysInMonth;
    const remainingCells = totalCells % 7 === 0 ? 0 : 7 - (totalCells % 7);
    
    for (let day = 1; day <= remainingCells; day++) {
        const dateDiv = document.createElement('div');
        dateDiv.className = 'calendar-date other-month';
        dateDiv.textContent = day;
        calendarDates.appendChild(dateDiv);
    }
}

function prevMonth() {
    currentDate.setMonth(currentDate.getMonth() - 1);
    renderCalendar();
}

function nextMonth() {
    currentDate.setMonth(currentDate.getMonth() + 1);
    renderCalendar();
}

// Initialize on page load
window.onload = function() {
    const urlParams = new URLSearchParams(window.location.search);
    const tab = urlParams.get('tab');
    
    if (tab === 'pending' || tab === 'finished') {
        showTab(tab);
    } else {
        showTab('pending');
    }
    
    renderCalendar();
};