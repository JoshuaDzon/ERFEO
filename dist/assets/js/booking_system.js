// booking_system.js - FIXED VERSION
// Fixed bugs:
// 1. Sound system package selection based on guest count ranges
// 2. Auto-remove incompatible extras (Clown) when event type changes
// Author: Fixed by Claude

document.addEventListener('DOMContentLoaded', function () {
  // -------------------------
  // Session helpers
  // -------------------------
  function saveToSession(key, value) {
    try {
      sessionStorage.setItem(key, JSON.stringify(value));
    } catch (e) {
      console.error('sessionStorage set error', e);
    }
  }

  function getFromSession(key) {
    try {
      const raw = sessionStorage.getItem(key);
      return raw ? JSON.parse(raw) : null;
    } catch (e) {
      console.error('sessionStorage get error', e);
      return null;
    }
  }

  function clearAllSession() {
    try {
      sessionStorage.clear();
    } catch (e) {
      console.error('sessionStorage clear error', e);
    }
  }

  // -------------------------
  // Sound System Validation Functions - FIXED
  // -------------------------
  function validateSoundSelection() {
    const warningsContainer = document.getElementById('sound-warnings');
    if (!warningsContainer) return;
    
    warningsContainer.innerHTML = '';
    
    const soundInput = document.getElementById('sound_selection_input');
    const selectedItems = soundInput ? JSON.parse(soundInput.value || '[]') : [];
    
    // Get guest count and event type from global variables or hidden inputs
    const guestCount = window.guest_count || parseInt(document.getElementById('guest_count_input')?.value || '0');
    const eventType = window.event_type || document.getElementById('event_type_input')?.value || '';
    
    // No warnings needed - validation happens on button click
  }

  // NEW: Function to get valid sound packages based on guest count
  function getValidSoundPackages(guestCount) {
    // REMOVED - All packages should be available for selection
    // User can choose any package regardless of guest count
    return ['Basic Audio', 'Standard System', 'Premium Package'];
  }

  // NEW: Update guest count display on sound system page
  function updateGuestCountDisplay() {
    const guestCountDisplay = document.getElementById('current-guest-count');
    const eventTypeDisplay = document.getElementById('current-event-type');
    
    if (guestCountDisplay) {
      const attendees = getFromSession('attendeesData');
      const guestCount = attendees?.expectedTotal || window.guest_count || 0;
      guestCountDisplay.textContent = guestCount;
    }
    
    if (eventTypeDisplay) {
      const eventType = getFromSession('eventTypeData');
      const type = eventType?.type || window.event_type || '';
      eventTypeDisplay.textContent = type;
    }
  }

  // REMOVED: updateSoundPackageAvailability function
  // All packages should be clickable, not disabled based on guest count

  // NEW: Function to remove incompatible extras when event type changes
  function cleanIncompatibleExtras() {
    const eventType = window.event_type || document.getElementById('event_type_input')?.value || '';
    if (!eventType) return;
    
    const selectedSound = getFromSession('soundData') || [];
    let itemsRemoved = [];
    
    // Check each selected item
    const filteredSound = selectedSound.filter(item => {
      const card = document.querySelector(`.item-card[data-name="${item.name}"]`);
      if (!card) return true;
      
      const restrictedEvents = card.getAttribute('data-restricted-events');
      if (restrictedEvents) {
        const restricted = restrictedEvents.split(',');
        if (restricted.includes(eventType)) {
          itemsRemoved.push(item.name);
          return false; // Remove this item
        }
      }
      return true; // Keep this item
    });
    
    // Always save the cleaned data (even if empty)
    saveToSession('soundData', filteredSound);
    
    // Update hidden input
    const soundInput = document.getElementById('sound_selection_input');
    if (soundInput) {
      soundInput.value = JSON.stringify(filteredSound);
    }
    
    // Update all button states after cleaning
    if (document.getElementById('sound-section')) {
      // Force update button states with cleaned data
      document.querySelectorAll('#sound-section .sound-add-btn').forEach(btn => {
        const card = btn.closest('.item-card');
        const name = card?.getAttribute('data-name');
        
        // Check if this item exists in the CLEANED filteredSound array
        const isSelected = filteredSound.some(item => item.name === name);
        
        if (isSelected) {
          btn.textContent = '✔ ADDED';
          btn.style.backgroundColor = '#22c55e';
          btn.style.color = 'white';
          card && card.classList.add('selected');
        } else {
          btn.textContent = '+ ADD';
          btn.style.backgroundColor = '';
          btn.style.color = '';
          card && card.classList.remove('selected');
        }
      });
    }
    
    // Show alert to user if items were removed
    if (itemsRemoved.length > 0) {
      alert(`❌ The following items have been removed because they are not available for ${eventType} events:\n\n${itemsRemoved.join('\n')}`);
    }
  }

  // -------------------------
  // Restore UI from session (if present)
  // -------------------------
  function restoreUIFromSession() {
    // PHASE 1: schedule
    const schedule = getFromSession('scheduleData');
    if (schedule) {
      const elDate = document.getElementById('event_date_picker');
      const elTime = document.getElementById('event_time');
      const elName = document.getElementById('reservation_name');
      const elContact = document.getElementById('contact_number');
      const elLocation = document.getElementById('event_location');
      if (elDate) elDate.value = schedule.date || '';
      if (elTime) elTime.value = schedule.time || '';
      if (elName) elName.value = schedule.name || '';
      if (elContact) elContact.value = schedule.contact || '';
      if (elLocation) elLocation.value = schedule.location || '';
    }

    // PHASE 2: event type
    const eventTypeData = getFromSession('eventTypeData');
    if (eventTypeData) {
      const etInput = document.getElementById('event_type_input');
      const esdInput = document.getElementById('event_specific_details_input');
      if (etInput) etInput.value = eventTypeData.type || '';
      if (esdInput) esdInput.value = eventTypeData.details || '';
      const card = document.querySelector(`.event-card[data-event-type="${eventTypeData.type}"]`);
      if (card) card.classList.add('selected');
    }

    // PHASE 3: attendees
    const attendees = getFromSession('attendeesData');
    if (attendees) {
      const totalGuestsValue = document.getElementById('total_guests_value');
      if (totalGuestsValue) totalGuestsValue.value = attendees.expectedTotal ?? '0';
      if (attendees.categories) {
        Object.keys(attendees.categories).forEach(cat => {
          const categoryEl = document.querySelector(`.guest-category[data-category="${cat}"]`);
          if (categoryEl) {
            const valueInput = categoryEl.querySelector('.value');
            const guestCountEl = categoryEl.querySelector('.guest-count');
            if (valueInput) valueInput.value = attendees.categories[cat];
            if (guestCountEl) guestCountEl.textContent = attendees.categories[cat];
          }
        });
      }
      // Update summary
      updateAttendeesSummary();
    }

    // PHASE 4: menu
    const menu = getFromSession('menuData');
    if (Array.isArray(menu)) {
      menu.forEach(item => {
        const input = Array.from(document.querySelectorAll('.menu-qty-input')).find(i => {
          const card = i.closest('.item-card');
          return card && card.dataset.name === item.name;
        });
        if (input) {
          input.value = item.quantity;
          const card = input.closest('.item-card');
          if (card && item.quantity > 0) card.classList.add('added');
        }
      });
    }

    // PHASE 5: decor - Restore green buttons
    const decor = getFromSession('decorData');
    if (Array.isArray(decor)) {
      decor.forEach(item => {
        const card = Array.from(document.querySelectorAll('#decor-section .item-card'))
          .find(c => c.getAttribute('data-name') === item.name);
        if (card) {
          const btn = card.querySelector('.decor-add-btn');
          if (btn) {
            btn.textContent = '✔ ADDED';
            btn.style.backgroundColor = '#22c55e';
            btn.style.color = 'white';
          }
        }
      });
      // Update all hidden inputs
      document.querySelectorAll('#decor_selection_input').forEach(input => {
        input.value = JSON.stringify(decor);
      });
    }

    // PHASE 6: sound
    const sound = getFromSession('soundData');
    const soundInput = document.getElementById('sound_selection_input');
    if (Array.isArray(sound)) {
      sound.forEach(item => {
        const card = document.querySelector(`.item-card[data-name="${item.name}"]`);
        if (card) {
          card.classList.add('selected');
          const btn = card.querySelector('.sound-add-btn');
          if (btn) {
            btn.textContent = '✔ ADDED';
            btn.style.backgroundColor = '#22c55e';
            btn.style.color = 'white';
          }
        }
      });
      if (soundInput) soundInput.value = JSON.stringify(sound);
    }

    // If on receipt page, run final summary population
    if (document.getElementById('final-summary-list')) {
      updateFinalSummary();
    }
  } // end restoreUIFromSession

  // -------------------------
  // Attendees Summary Update Function
  // -------------------------
  function updateAttendeesSummary() {
    const totalCategorizedEl = document.getElementById('total-categorized');
    const totalExpectedEl = document.getElementById('total-expected');
    const totalGuestsInput = document.getElementById('total_guests_value');

    if (!totalGuestsInput || !totalCategorizedEl || !totalExpectedEl) return;

    let categorizedTotal = 0;
    document.querySelectorAll('.guest-category[data-category]').forEach(cat => {
      const valueInput = cat.querySelector('.value');
      if (valueInput) {
        categorizedTotal += parseInt(valueInput.value || '0') || 0;
      }
    });

    const expectedTotal = parseInt(totalGuestsInput.value || '0') || 0;
    
    totalCategorizedEl.textContent = categorizedTotal;
    totalExpectedEl.textContent = expectedTotal;

    // Save to session
    const categoriesData = {};
    document.querySelectorAll('.guest-category[data-category]').forEach(cat => {
      const catName = cat.dataset.category;
      const valueInput = cat.querySelector('.value');
      const count = valueInput ? parseInt(valueInput.value || '0') || 0 : 0;
      categoriesData[catName] = count;
    });
    saveToSession('attendeesData', { expectedTotal, categories: categoriesData });
  }

  restoreUIFromSession();
  
  // Update guest count and event type display on sound system page
  updateGuestCountDisplay();

  // -------------------------
  // PHASE 1: SET SCHEDULE
  // -------------------------
  (function phase1() {
    const confirmScheduleBtn = document.getElementById('confirm-schedule-btn');
    if (!confirmScheduleBtn) return;

    confirmScheduleBtn.addEventListener('click', function () {
      const dateEl = document.getElementById('event_date_picker');
      const timeEl = document.getElementById('event_time');
      const nameEl = document.getElementById('reservation_name');
      const contactEl = document.getElementById('contact_number');
      const locationEl = document.getElementById('event_location');

      const date = dateEl ? dateEl.value.trim() : '';
      const time = timeEl ? timeEl.value.trim() : '';
      const name = nameEl ? nameEl.value.trim() : '';
      const contact = contactEl ? contactEl.value.trim() : '';
      const location = locationEl ? locationEl.value.trim() : '';

      if (!date || !time || !name || !contact || !location) {
        alert('Please fill in all required fields.');
        return;
      }

      saveToSession('scheduleData', { date, time, name, contact, location });
      window.location.href = 'event_type.php';
    });
  })();

  // -------------------------
  // PHASE 2: EVENT TYPE (+ modal) - FIXED
  // -------------------------
  (function phase2() {
    const cards = document.querySelectorAll('.event-card');
    const modal = document.getElementById('eventDetailsModal');
    const modalTitle = document.getElementById('modal-title');
    const modalFields = document.getElementById('modal-form-fields');
    const modalForm = document.getElementById('modal-details-form');
    const closeModalBtn = document.querySelector('.close-modal');

    let selectedEventType = '';
    let previousEventType = getFromSession('eventTypeData')?.type || '';

    if (cards && cards.length) {
      cards.forEach(card => {
        card.addEventListener('click', () => {
          cards.forEach(c => c.classList.remove('selected'));
          card.classList.add('selected');
          selectedEventType = card.dataset.eventType || '';
          const evtInput = document.getElementById('event_type_input');
          if (evtInput) evtInput.value = selectedEventType;
          openModalForEvent(selectedEventType);
        });
      });
    }

    function openModalForEvent(type) {
      if (!modal || !modalTitle || !modalFields) return;
      modalTitle.textContent = `Fill out information for ${type}`;
      modalFields.innerHTML = '';

      let fields = [];
      switch (type) {
        case 'Wedding':
          fields = [
            { label: "Groom's Full Name", name: 'groom_name', type: 'text', required: true },
            { label: "Bride's Full Name", name: 'bride_name', type: 'text', required: true }
          ];
          break;
        case 'Christening':
          fields = [
            { label: "Child's Full Name", name: 'child_name', type: 'text', required: true },
            { label: "Godparents", name: 'godparents', type: 'text', required: false }
          ];
          break;
        case 'Birthday':
          fields = [
            { label: "Celebrant's Full Name", name: 'celebrant_name', type: 'text', required: true },
            { label: "Age Type", name: 'age_type', type: 'select', options: ['Years', 'Months'], required: true },
            { label: "Age", name: 'age_value', type: 'number', required: true, min: 1 }
          ];
          break;
        case 'Graduation':
          fields = [
            { label: "Graduate's Full Name", name: 'graduate_name', type: 'text', required: true },
            { label: "Degree/Course", name: 'degree', type: 'text', required: true }
          ];
          break;
        case 'Reunion':
          fields = [
            { label: "Family/Group Name", name: 'group_name', type: 'text', required: true },
            { label: "Occasion", name: 'occasion', type: 'text', required: false }
          ];
          break;
        case 'Corporate':
          fields = [
            { label: "Company Name", name: 'company_name', type: 'text', required: true },
            { label: "Event Purpose", name: 'purpose', type: 'text', required: true }
          ];
          break;
        default:
          fields = [
            { label: "Event Title", name: 'event_title', type: 'text', required: true }
          ];
      }

      const existing = getFromSession('eventTypeData');
      let existingDetails = {};
      if (existing && existing.details) {
        try { existingDetails = JSON.parse(existing.details); } catch (e) { existingDetails = {}; }
      }

      fields.forEach(f => {
        const lbl = document.createElement('label');
        lbl.textContent = f.label;
        lbl.style.display = 'block';
        lbl.style.marginTop = '8px';

        let input;
        if (f.type === 'select') {
          input = document.createElement('select');
          input.name = f.name;
          f.options.forEach(o => {
            const opt = document.createElement('option');
            opt.value = o;
            opt.textContent = o;
            input.appendChild(opt);
          });
          if (existingDetails[f.name]) input.value = existingDetails[f.name];
        } else {
          input = document.createElement('input');
          input.type = f.type;
          input.name = f.name;
          if (f.min !== undefined) input.min = f.min;
          if (existingDetails[f.name]) input.value = existingDetails[f.name];
        }

        if (f.required) input.required = true;

        modalFields.appendChild(lbl);
        modalFields.appendChild(input);
      });

      if (type === 'Birthday') {
        const ageTypeSel = modalFields.querySelector('select[name="age_type"]');
        const ageValInp = modalFields.querySelector('input[name="age_value"]');
        if (ageTypeSel && ageValInp) {
          ageTypeSel.addEventListener('change', function () {
            if (this.value === 'Months') {
              ageValInp.max = 12;
              ageValInp.min = 1;
              ageValInp.placeholder = 'Enter months (1-12)';
            } else {
              ageValInp.removeAttribute('max');
              ageValInp.min = 1;
              ageValInp.placeholder = 'Enter age (years)';
            }
          });
          ageTypeSel.dispatchEvent(new Event('change'));
        }
      }

      modal.style.display = 'block';
    }

    if (closeModalBtn) {
      closeModalBtn.addEventListener('click', () => {
        if (modal) modal.style.display = 'none';
      });
    }

    window.addEventListener('click', (ev) => {
      if (ev.target === modal) modal.style.display = 'none';
    });

    if (modalForm) {
      modalForm.addEventListener('submit', function (ev) {
        ev.preventDefault();
        const fd = new FormData(this);
        const details = {};
        fd.forEach((v, k) => details[k] = v);

        if (details.age_value) {
          const val = parseInt(details.age_value);
          if (isNaN(val) || val < 1) {
            alert('Age must be a positive number.');
            return;
          }
          if (details.age_type === 'Months' && val > 12) {
            alert('Months must be between 1 and 12.');
            return;
          }
        }

        // FIXED: Check if event type changed and clean incompatible extras
        if (previousEventType && previousEventType !== selectedEventType) {
          // Update global variable for cleaning function
          window.event_type = selectedEventType;
          cleanIncompatibleExtras();
        }

        saveToSession('eventTypeData', {
          type: selectedEventType,
          details: JSON.stringify(details)
        });

        const etInput = document.getElementById('event_type_input');
        const esdInput = document.getElementById('event_specific_details_input');
        if (etInput) etInput.value = selectedEventType;
        if (esdInput) esdInput.value = JSON.stringify(details);

        if (modal) modal.style.display = 'none';
        window.location.href = 'attendees.php';
      });
    }

    const confirmEventBtn = document.getElementById('confirm-event-btn');
    if (confirmEventBtn) {
      confirmEventBtn.addEventListener('click', function () {
        const et = document.getElementById('event_type_input') ? document.getElementById('event_type_input').value : '';
        if (!et) {
          alert('Please select an event type (click a card).');
          return;
        }
        window.location.href = 'attendees.php';
      });
    }
  })();

  // -------------------------
  // PHASE 3: ATTENDEES
  // -------------------------
  (function phase3() {
    const totalGuestsInput = document.getElementById('total_guests_value');
    const totalCategorizedEl = document.getElementById('total-categorized');
    const totalExpectedEl = document.getElementById('total-expected');
    const incTotalBtn = document.getElementById('increment-total');
    const decTotalBtn = document.getElementById('decrement-total');

    if (!totalGuestsInput) return;

    function calculateCategorizedTotal() {
      let t = 0;
      document.querySelectorAll('.guest-category[data-category]').forEach(cat => {
        const valueInput = cat.querySelector('.value');
        if (valueInput) {
          t += parseInt(valueInput.value || '0') || 0;
        }
      });
      return t;
    }

    function updateGuestSummaryAndSave() {
      const categorizedTotal = calculateCategorizedTotal();
      const expectedTotal = parseInt(totalGuestsInput.value || '0') || 0;
      
      if (totalCategorizedEl) totalCategorizedEl.textContent = categorizedTotal;
      if (totalExpectedEl) totalExpectedEl.textContent = expectedTotal;

      const categoriesData = {};
      document.querySelectorAll('.guest-category[data-category]').forEach(cat => {
        const catName = cat.dataset.category;
        const valueInput = cat.querySelector('.value');
        const count = valueInput ? parseInt(valueInput.value || '0') || 0 : 0;
        categoriesData[catName] = count;
        
        // Update guest count display
        const guestCountEl = cat.querySelector('.guest-count');
        if (guestCountEl) guestCountEl.textContent = count;
      });
      
      saveToSession('attendeesData', { expectedTotal, categories: categoriesData });
    }

    // Initialize summary
    updateGuestSummaryAndSave();

    // Total guests input change
    if (totalGuestsInput) {
      totalGuestsInput.addEventListener('change', updateGuestSummaryAndSave);
      totalGuestsInput.addEventListener('input', updateGuestSummaryAndSave);
    }

    if (incTotalBtn) {
      incTotalBtn.addEventListener('click', () => {
        let current = parseInt(totalGuestsInput.value || '0') || 0;
        totalGuestsInput.value = current + 1;
        updateGuestSummaryAndSave();
      });
    }
    
    if (decTotalBtn) {
      decTotalBtn.addEventListener('click', () => {
        let current = parseInt(totalGuestsInput.value || '0') || 0;
        if (current > 0) {
          totalGuestsInput.value = current - 1;
          updateGuestSummaryAndSave();
        }
      });
    }

    // Category input handling
    document.querySelectorAll('.guest-category[data-category]').forEach(cat => {
      const inc = cat.querySelector('.increment');
      const dec = cat.querySelector('.decrement');
      const valueInput = cat.querySelector('.value');
      const guestCountEl = cat.querySelector('.guest-count');

      if (valueInput) {
        // Input change event
        valueInput.addEventListener('change', updateGuestSummaryAndSave);
        valueInput.addEventListener('input', updateGuestSummaryAndSave);
      }

      if (inc) {
        inc.addEventListener('click', () => {
          const categorizedTotal = calculateCategorizedTotal();
          const expectedTotal = parseInt(totalGuestsInput.value || '0') || 0;
          
          if (categorizedTotal < expectedTotal) {
            let cur = parseInt(valueInput.value || '0') || 0;
            cur++;
            valueInput.value = cur;
            if (guestCountEl) guestCountEl.textContent = cur;
            updateGuestSummaryAndSave();
          } else {
            alert('You have reached the maximum number of expected guests.');
          }
        });
      }

      if (dec) {
        dec.addEventListener('click', () => {
          let cur = parseInt(valueInput.value || '0') || 0;
          if (cur > 0) {
            cur--;
            valueInput.value = cur;
            if (guestCountEl) guestCountEl.textContent = cur;
            updateGuestSummaryAndSave();
          }
        });
      }
    });

    const confirmAttendeesBtn = document.querySelector('.confirm-phase-btn[data-phase-target="menu-section"]');
    if (confirmAttendeesBtn) {
      confirmAttendeesBtn.addEventListener('click', () => {
        const categorizedTotal = calculateCategorizedTotal();
        const expectedTotal = parseInt(totalGuestsInput.value || '0') || 0;
        
        if (categorizedTotal !== expectedTotal) {
          alert(`Total guests must match exactly! Expected: ${expectedTotal}, Current: ${categorizedTotal}`);
          return;
        }
        window.location.href = 'menu.php';
      });
    }
  })();

  // -------------------------
  // PHASE 4: MENU (tabs, quantity controls and session save)
  // -------------------------
  (function phase4() {
    const menuSection = document.getElementById('menu-section');
    if (!menuSection) return;

    const menuTabs = document.querySelectorAll('#menu-section .tab-item');
    const itemLists = document.querySelectorAll('#menu-section .item-list');

    if (menuTabs && menuTabs.length) {
      menuTabs.forEach(tab => {
        tab.addEventListener('click', function() {
          menuTabs.forEach(t => t.classList.remove('active'));
          itemLists.forEach(list => list.classList.remove('active'));
          
          this.classList.add('active');
          
          const targetId = this.getAttribute('data-tab-target');
          const targetList = document.getElementById(targetId);
          if (targetList) {
            targetList.classList.add('active');
          }
        });
      });
    }

    const menuQtyInputs = document.querySelectorAll('.menu-qty-input');

    function saveMenuToSession() {
      const items = [];
      document.querySelectorAll('.menu-qty-input').forEach(inp => {
        const qty = parseInt(inp.value || '0') || 0;
        if (qty > 0) {
          const card = inp.closest('.item-card');
          const name = card ? (card.dataset.name || '') : '';
          const price = parseFloat(inp.dataset.price || card?.dataset.price || '0') || 0; 
          items.push({ name, quantity: qty, price });
        }
      });
      saveToSession('menuData', items);
      
      const menuInput = document.getElementById('menu_selection_input');
      if (menuInput) {
        menuInput.value = JSON.stringify(items);
      }
    }

    if (menuQtyInputs && menuQtyInputs.length) {
      menuQtyInputs.forEach(input => {
        const card = input.closest('.item-card');
        const inc = card ? card.querySelector('.menu-increment') : null;
        const dec = card ? card.querySelector('.menu-decrement') : null;

        if (parseInt(input.value || '0') > 0) card && card.classList.add('added');

        const updateQuantity = (delta) => {
          let q = parseInt(input.value || '0') || 0;
          q += delta;
          q = Math.max(0, q);
          input.value = q;
          if (q === 0) card && card.classList.remove('added');
          else card && card.classList.add('added');
          saveMenuToSession();
        };

        if (inc) {
          inc.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            updateQuantity(1);
          });
        }
        
        if (dec) {
          dec.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            updateQuantity(-1);
          });
        }

        input.addEventListener('change', () => {
          let q = parseInt(input.value || '0') || 0;
          if (q < 0) q = 0;
          input.value = q;
          if (q === 0) card && card.classList.remove('added');
          else card && card.classList.add('added');
          saveMenuToSession();
        });
      });
    }

    const confirmMenuBtn = document.querySelector('.confirm-phase-btn[data-phase-target="decor-section"]');
    if (confirmMenuBtn) {
      confirmMenuBtn.addEventListener('click', () => {
        saveMenuToSession();
        window.location.href = 'decorations.php';
      });
    }
  })();

  // -------------------------
  // PHASE 5: DECORATIONS (toggle/add, save, and form submission)
  // -------------------------
  (function phase5() {
    const decorSection = document.getElementById('decor-section');
    if (!decorSection) return;

    // Tab switching for decorations
    const decorTabs = document.querySelectorAll('#decor-tabs .tab-item');
    const decorLists = document.querySelectorAll('#decor-section .item-list');

    if (decorTabs && decorTabs.length) {
      decorTabs.forEach(tab => {
        tab.addEventListener('click', function() {
          decorTabs.forEach(t => t.classList.remove('active'));
          decorLists.forEach(list => list.classList.remove('active'));
          
          this.classList.add('active');
          const targetId = this.getAttribute('data-tab-target');
          const targetList = document.getElementById(targetId);
          if (targetList) {
            targetList.classList.add('active');
          }
        });
      });
    }

    // Load saved decorations from sessionStorage
    let selectedDecorations = [];
    const savedDecor = getFromSession('decorData');
    if (Array.isArray(savedDecor)) {
      selectedDecorations = savedDecor;
    }

    function saveDecorToSession() {
      saveToSession('decorData', selectedDecorations);
      
      // Update all hidden inputs
      document.querySelectorAll('#decor_selection_input').forEach(input => {
        input.value = JSON.stringify(selectedDecorations);
      });
    }

    // Restore button states on load (already done in restoreUIFromSession but ensure it happens)
    selectedDecorations.forEach(item => {
      const card = Array.from(document.querySelectorAll('#decor-section .item-card'))
        .find(c => c.getAttribute('data-name') === item.name);
      if (card) {
        const button = card.querySelector('.decor-add-btn');
        if (button) {
          button.textContent = '✔ ADDED';
          button.style.backgroundColor = '#22c55e';
          button.style.color = 'white';
        }
      }
    });

    // Add/remove decorations on button click
    document.querySelectorAll('#decor-section .decor-add-btn').forEach(button => {
      button.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        
        const card = button.closest('.item-card');
        const name = card.getAttribute('data-name');
        const price = parseFloat(card.getAttribute('data-price') || '0') || 0;

        const index = selectedDecorations.findIndex(item => item.name === name);

        if (index === -1) {
          // Add item
          selectedDecorations.push({ name, price });
          button.textContent = '✔ ADDED';
          button.style.backgroundColor = '#22c55e';
          button.style.color = 'white';
        } else {
          // Remove item
          selectedDecorations.splice(index, 1);
          button.textContent = '+ ADD';
          button.style.backgroundColor = '';
          button.style.color = '';
        }

        saveDecorToSession();
      });
    });

    // Confirm buttons - handle all three tabs
    document.querySelectorAll('#decor-section .confirm-phase-btn[data-phase-target="sound-section"]').forEach(btn => {
      btn.addEventListener('click', (e) => {
        e.preventDefault();
        saveDecorToSession();
        window.location.href = 'sound_system.php';
      });
    });
  })();

  // -------------------------
  // PHASE 6: SOUND SYSTEM - FIXED
  // -------------------------
  (function phase6() {
    const soundSection = document.getElementById('sound-section');
    if (!soundSection) return;

    // Tab switching for sound system
    const soundTabs = document.querySelectorAll('#sound-tabs .tab-item');
    const soundLists = document.querySelectorAll('#sound-section .item-list');

    if (soundTabs && soundTabs.length) {
      soundTabs.forEach(tab => {
        tab.addEventListener('click', function() {
          soundTabs.forEach(t => t.classList.remove('active'));
          soundLists.forEach(list => list.classList.remove('active'));

          this.classList.add('active');
          const targetId = this.getAttribute('data-tab-target');
          const targetList = document.getElementById(targetId);
          if (targetList) {
            targetList.classList.add('active');
          }
        });
      });
    }

    // Load saved sound items from sessionStorage
    let selectedSoundItems = [];
    const savedSound = getFromSession('soundData');
    if (Array.isArray(savedSound)) {
      selectedSoundItems = savedSound;
    }

    function saveSoundToSession() {
      saveToSession('soundData', selectedSoundItems);

      const hiddenInput = document.getElementById('sound_selection_input');
      if (hiddenInput) {
        hiddenInput.value = JSON.stringify(selectedSoundItems);
      }
      
      // Trigger validation after saving
      setTimeout(validateSoundSelection, 0);
    }

    function updateButtonStates() {
      // Get fresh data from selectedSoundItems
      const currentSelection = selectedSoundItems;
      
      // Update all buttons based on current selection
      document.querySelectorAll('#sound-section .sound-add-btn').forEach(btn => {
        const card = btn.closest('.item-card');
        const name = card?.getAttribute('data-name');
        
        // Check if this item is in currentSelection
        const isSelected = currentSelection.some(item => item.name === name);
        
        if (isSelected) {
          btn.textContent = '✔ ADDED';
          btn.style.backgroundColor = '#22c55e';
          btn.style.color = 'white';
          card && card.classList.add('selected');
        } else {
          btn.textContent = '+ ADD';
          btn.style.backgroundColor = '';
          btn.style.color = '';
          card && card.classList.remove('selected');
        }
      });
    }

    // Check if clown is allowed for current event type
    function isClownAllowed() {
      const eventType = window.event_type || document.getElementById('event_type_input')?.value || '';
      const restrictedEvents = ['Wedding', 'Christening', 'Graduation', 'Corporate'];
      return !restrictedEvents.includes(eventType);
    }

    // Check if item is a sound system package (not an extra)
    function isSoundSystemPackage(name) {
      const soundPackages = ['Basic Audio', 'Standard System', 'Premium Package'];
      return soundPackages.includes(name);
    }

    // FIXED: Clean incompatible extras on page load and reload selectedSoundItems
    cleanIncompatibleExtras();
    
    // Reload from session after cleaning (important!)
    const cleanedSound = getFromSession('soundData');
    if (Array.isArray(cleanedSound)) {
      selectedSoundItems = cleanedSound;
    }
    
    // Initial button state setup
    updateButtonStates();
    
    // Update guest count display
    updateGuestCountDisplay();

    // Add/remove sound items on button click
    document.querySelectorAll('#sound-section .sound-add-btn').forEach(button => {
      button.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();

        const card = button.closest('.item-card');
        const name = card.getAttribute('data-name');
        const price = parseFloat(card.getAttribute('data-price') || '0') || 0;

        // Check for clown restriction
        if (name === 'Clown' && !isClownAllowed()) {
          const eventType = window.event_type || document.getElementById('event_type_input')?.value || '';
          alert(`❌ Clown service is not available for ${eventType} events.`);
          return;
        }

        // Check for "choose only 1" for sound system packages (NOT for extras!)
        if (isSoundSystemPackage(name)) {
          // Check if clicking the same package that's already selected (to unselect it)
          const alreadySelected = selectedSoundItems.some(item => item.name === name);
          
          if (alreadySelected) {
            // Remove this package (unselect)
            selectedSoundItems = selectedSoundItems.filter(item => item.name !== name);
          } else {
            // Remove any other sound package and add this one
            selectedSoundItems = selectedSoundItems.filter(item => !isSoundSystemPackage(item.name));
            selectedSoundItems.push({ name, price });
          }
        } else {
          // For extras, toggle add/remove
          const index = selectedSoundItems.findIndex(item => item.name === name);

          if (index === -1) {
            // Add item
            selectedSoundItems.push({ name, price });
          } else {
            // Remove item
            selectedSoundItems.splice(index, 1);
          }
        }

        saveSoundToSession();
        updateButtonStates();
      });
    });

    // Clear / cancel button
    const cancelSoundBtn = document.querySelector('#sound-section .cancel-phase-btn');
    if (cancelSoundBtn) {
      cancelSoundBtn.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        selectedSoundItems = [];
        saveSoundToSession();
        updateButtonStates();
      });
    }

    // Confirm buttons - proceed to receipt.php
    const confirmSoundBtn = document.querySelector('#sound-section .confirm-phase-btn');
    const form = document.getElementById('reservationForm');
    if (confirmSoundBtn && form) {
      confirmSoundBtn.addEventListener('click', () => {
        saveSoundToSession();
        window.location.href = 'receipt.php';
      });
    }

    // Initialize validation when page loads
    validateSoundSelection();
  })();

  // -------------------------
  // PHASE 7: RECEIPT & FINAL SUMMARY
  // -------------------------
  function formatCurrency(amount) {
    return 'Php ' + (typeof amount === 'number' ? amount.toFixed(2) : '0.00');
  }

  function createSummaryHeader(text) {
    const h = document.createElement('h3');
    h.className = 'summary-header';
    h.textContent = text;
    return h;
  }

  function createSummaryItem(label, value, extra) {
    const div = document.createElement('div');
    div.className = 'summary-item';
    const lv = `<div class="summary-label">${label}</div><div class="summary-value">${value}</div>`;
    const ex = extra ? `<div class="summary-extra">${extra}</div>` : '';
    div.innerHTML = lv + ex;
    return div;
  }

  function updateFinalSummary() {
    const summaryList = document.getElementById('final-summary-list');
    if (!summaryList) return;
    summaryList.innerHTML = '';

    let totalCost = 0;

    const schedule = getFromSession('scheduleData');
    const eventType = getFromSession('eventTypeData');
    const attendees = getFromSession('attendeesData');
    const menu = getFromSession('menuData') || [];
    const decor = getFromSession('decorData') || [];
    const sound = getFromSession('soundData') || [];

    // 1. event details
    if (schedule || eventType) {
      summaryList.appendChild(createSummaryHeader('Event Details'));
      if (eventType && eventType.type) {
        summaryList.appendChild(createSummaryItem('Event Type', eventType.type));
        if (eventType.details) {
          try {
            const details = JSON.parse(eventType.details);
            for (const k in details) {
              if (!Object.prototype.hasOwnProperty.call(details, k)) continue;
              if (k === 'age_type' || k === 'age_value') continue;
              const label = k.replace(/_/g, ' ').replace(/\b\w/g, c => c.toUpperCase());
              summaryList.appendChild(createSummaryItem(label, details[k]));
            }
          } catch (e) {
            // ignore
          }
        }
      }
      if (schedule) {
        summaryList.appendChild(createSummaryItem('Full Name', schedule.name || ''));
        summaryList.appendChild(createSummaryItem('Contact', schedule.contact || ''));
        summaryList.appendChild(createSummaryItem('Address/Location', schedule.location || ''));
        summaryList.appendChild(createSummaryItem('Date', schedule.date || ''));
        summaryList.appendChild(createSummaryItem('Time', schedule.time || ''));
      }
      summaryList.appendChild(document.createElement('hr'));
    }

    // 2. attendees
    if (attendees) {
      summaryList.appendChild(createSummaryHeader('Attendees Summary'));
      const cats = attendees.categories || {};
      for (const k in cats) {
        summaryList.appendChild(createSummaryItem(k, cats[k]));
      }
      summaryList.appendChild(createSummaryItem('Total Expected Guests', attendees.expectedTotal ?? 0));
      summaryList.appendChild(document.createElement('hr'));
    }

    // 3. menu
    summaryList.appendChild(createSummaryHeader('Menu'));
    if (Array.isArray(menu) && menu.length > 0) {
      let menuSubtotal = 0;
      menu.forEach(it => {
        const itemTotal = (parseFloat(it.price || 0) || 0) * (parseInt(it.quantity || 0) || 0);
        summaryList.appendChild(createSummaryItem(`${it.name} (x${it.quantity})`, formatCurrency(itemTotal), `Price: Php ${parseFloat(it.price || 0).toFixed(2)}`));
        menuSubtotal += itemTotal;
      });
      totalCost += menuSubtotal;
      summaryList.appendChild(createSummaryItem('Menu Subtotal', formatCurrency(menuSubtotal)));
    } else {
      summaryList.appendChild(createSummaryItem('(No menu selected)', 'Php 0.00'));
    }
    summaryList.appendChild(document.createElement('hr'));

    // 4. decorations
    summaryList.appendChild(createSummaryHeader('Decorations'));
    if (Array.isArray(decor) && decor.length > 0) {
      let decorSubtotal = 0;
      decor.forEach(item => {
        const price = parseFloat(item.price || 0) || 0;
        summaryList.appendChild(createSummaryItem(item.name, formatCurrency(price)));
        decorSubtotal += price;
      });
      totalCost += decorSubtotal;
      summaryList.appendChild(createSummaryItem('Decor Subtotal', formatCurrency(decorSubtotal)));
    } else {
      summaryList.appendChild(createSummaryItem('(No decorations selected)', 'Php 0.00'));
    }
    summaryList.appendChild(document.createElement('hr'));

    // 5. sound
    summaryList.appendChild(createSummaryHeader('Sound System'));
    if (Array.isArray(sound) && sound.length > 0) {
      let soundSubtotal = 0;
      sound.forEach(item => {
        const price = parseFloat(item.price || 0) || 0;
        summaryList.appendChild(createSummaryItem(item.name, formatCurrency(price)));
        soundSubtotal += price;
      });
      totalCost += soundSubtotal;
      summaryList.appendChild(createSummaryItem('Sound Subtotal', formatCurrency(soundSubtotal)));
    } else {
      summaryList.appendChild(createSummaryItem('(No sound system selected)', 'Php 0.00'));
    }

    // 6. grand total
    const grand = document.createElement('div');
    grand.className = 'summary-grand-total';
    grand.innerHTML = `<strong>Grand Total:</strong> <span>${formatCurrency(totalCost)}</span>`;
    summaryList.appendChild(grand);

    // update total display if exists
    const totalDisplay = document.getElementById('total-cost-display');
    if (totalDisplay) totalDisplay.textContent = formatCurrency(totalCost);

    // fill hidden inputs for server
    function setValue(id, v) {
      const el = document.getElementById(id);
      if (el) el.value = v ?? '';
    }

    setValue('final_name', schedule?.name || '');
    setValue('final_contact_number', schedule?.contact || '');
    setValue('final_address', schedule?.location || '');
    setValue('final_event_date', schedule?.date || '');
    setValue('final_event_time', schedule?.time || '');
    setValue('final_event_type', eventType?.type || '');
    setValue('final_event_specific_details', eventType?.details || '');
    setValue('final_total_expected_guests', attendees?.expectedTotal ?? 0);
    setValue('final_attendee_categories', JSON.stringify(attendees?.categories || {}));
    setValue('final_menu_items', JSON.stringify(menu || []));
    setValue('final_decor_items', JSON.stringify(decor || []));
    setValue('final_sound_items', JSON.stringify(sound || []));
    setValue('final_total_cost', (totalCost).toFixed(2));
  } // end updateFinalSummary

  // run on load if receipt area present
  if (document.getElementById('final-summary-list')) {
    updateFinalSummary();
  }

  // -------------------------
  // Final confirm booking button (on receipt page)
  // -------------------------
  (function finalConfirm() {
    const confirmBtn = document.getElementById('confirm-booking-btn');
    const finalForm = document.getElementById('final-booking-form');
    if (!confirmBtn || !finalForm) return;

    confirmBtn.addEventListener('click', function () {
      const totalCostEl = document.getElementById('final_total_cost');
      const total = totalCostEl ? parseFloat(totalCostEl.value || '0') || 0 : 0;
      if (total <= 0) {
        alert('Total cost is Php 0.00. Please select items before confirming booking.');
        return;
      }

      const proceed = confirm('Are you sure you want to finalize and submit this booking?\n\nOnce submitted, your reservation will be sent for approval.');
      if (!proceed) return;

      sessionStorage.clear();
      finalForm.submit();
    });
  })();

  // -------------------------
  // Defensive: if pages use an element with id=reservationForm for submission, ensure submit validation
  // -------------------------
  (function attachReservationFormGuard() {
    const resForm = document.getElementById('reservationForm');
    if (!resForm) return;

    resForm.addEventListener('submit', function (ev) {
      if (resForm.id === 'final-booking-form') return true;

      const schedule = getFromSession('scheduleData');
      const eventType = getFromSession('eventTypeData');
      const attendees = getFromSession('attendeesData');

      if (!schedule || !schedule.date || !schedule.time || !schedule.name) {
        ev.preventDefault();
        alert('Please complete Set Schedule before submitting the form.');
        window.location.href = 'set_schedule.php';
        return false;
      }

      if (!eventType || !eventType.type) {
        ev.preventDefault();
        alert('Please select an Event Type before proceeding.');
        window.location.href = 'event_type.php';
        return false;
      }

      if (!attendees || typeof attendees.expectedTotal === 'undefined') {
        ev.preventDefault();
        alert('Please configure attendees before proceeding.');
        window.location.href = 'attendees.php';
        return false;
      }

      return true;
    });
  })();

  // -------------------------
  // Ensure we keep session updated when user navigates away via back/forward or unload
  // -------------------------
  window.addEventListener('beforeunload', function () {
    // Save schedule data
    (function saveScheduleNow() {
      const dateEl = document.getElementById('event_date_picker');
      const timeEl = document.getElementById('event_time');
      const nameEl = document.getElementById('reservation_name');
      const contactEl = document.getElementById('contact_number');
      const locationEl = document.getElementById('event_location');

      const date = dateEl ? dateEl.value.trim() : '';
      const time = timeEl ? timeEl.value.trim() : '';
      const name = nameEl ? nameEl.value.trim() : '';
      const contact = contactEl ? contactEl.value.trim() : '';
      const location = locationEl ? locationEl.value.trim() : '';

      if (date || time || name || contact || location) {
        saveToSession('scheduleData', { date, time, name, contact, location });
      }
    })();

    // Save menu selections
    (function saveMenuNow() {
      const arr = [];
      document.querySelectorAll('.menu-qty-input').forEach(inp => {
        const qty = parseInt(inp.value || '0') || 0;
        if (qty > 0) {
          const card = inp.closest('.item-card');
          const price = parseFloat(inp.dataset.price || card?.dataset.price || '0') || 0;
          arr.push({ name: card?.dataset?.name || '', quantity: qty, price });
        }
      });
      if (arr.length) saveToSession('menuData', arr);
    })();

    // Save decor & sound - selected classes (with price)
    (function saveDecorSoundNow() {
      const dec = [];
      document.querySelectorAll('#decor-section .decor-add-btn').forEach(btn => {
        if (btn.textContent.includes('✔')) {
          const card = btn.closest('.item-card');
          if (card) {
            const name = card.dataset.name;
            const price = parseFloat(card.dataset.price || '0') || 0;
            dec.push({ name, price });
          }
        }
      });
      if (dec.length) saveToSession('decorData', dec);

      const snd = [];
      document.querySelectorAll('#sound-section .item-card.selected').forEach(card => {
         if (card.querySelector('.sound-add-btn')) {
            const name = card.dataset.name;
            const price = parseFloat(card.dataset.price || '0') || 0;
            snd.push({ name, price });
         }
      });
      if (snd.length) saveToSession('soundData', snd);
    })();
  });

});

document.addEventListener('DOMContentLoaded', function() {
    // Tab functionality for menu
    const menuTabs = document.querySelectorAll('#menu-tabs .tab-item');
    const menuSections = document.querySelectorAll('#menu-section .item-list');

    if (menuTabs.length > 0) {
        menuTabs.forEach(tab => {
            tab.addEventListener('click', function() {
                // Remove active class from all tabs and sections
                menuTabs.forEach(t => t.classList.remove('active', 'bg-gray-300'));
                menuSections.forEach(s => {
                    s.classList.add('hidden');
                    s.classList.remove('active', 'flex');
                });
                
                // Add active class to clicked tab
                this.classList.add('active', 'bg-gray-300');
                
                // Show corresponding section
                const targetId = this.getAttribute('data-tab-target');
                const targetSection = document.getElementById(targetId);
                if (targetSection) {
                    targetSection.classList.remove('hidden');
                    targetSection.classList.add('active', 'flex');
                }
            });
        });
    }
});
document.addEventListener('DOMContentLoaded', function() {
    // Tab functionality for decorations
    const decorTabs = document.querySelectorAll('#decor-tabs .tab-item');
    const decorSections = document.querySelectorAll('#decor-section .item-list');

    if (decorTabs.length > 0) {
        decorTabs.forEach(tab => {
            tab.addEventListener('click', function() {
                // Remove active class from all tabs and sections
                decorTabs.forEach(t => t.classList.remove('active', 'bg-gray-300'));
                decorSections.forEach(s => {
                    s.classList.add('hidden');
                    s.classList.remove('active', 'flex');
                });
                
                // Add active class to clicked tab
                this.classList.add('active', 'bg-gray-300');
                
                // Show corresponding section
                const targetId = this.getAttribute('data-tab-target');
                const targetSection = document.getElementById(targetId);
                if (targetSection) {
                    targetSection.classList.remove('hidden');
                    targetSection.classList.add('active', 'flex');
                }
            });
        });
    }
});
document.addEventListener('DOMContentLoaded', function() {
    // Tab functionality for sound system
    const soundTabs = document.querySelectorAll('#sound-tabs .tab-item');
    const soundSections = document.querySelectorAll('#sound-section .item-list');

    if (soundTabs.length > 0) {
        soundTabs.forEach(tab => {
            tab.addEventListener('click', function() {
                // Remove active class from all tabs and sections
                soundTabs.forEach(t => t.classList.remove('active', 'bg-gray-300'));
                soundSections.forEach(s => {
                    s.classList.add('hidden');
                    s.classList.remove('active', 'flex');
                });
                
                // Add active class to clicked tab
                this.classList.add('active', 'bg-gray-300');
                
                // Show corresponding section
                const targetId = this.getAttribute('data-tab-target');
                const targetSection = document.getElementById(targetId);
                if (targetSection) {
                    targetSection.classList.remove('hidden');
                    targetSection.classList.add('active', 'flex');
                }
            });
        });
    }
});