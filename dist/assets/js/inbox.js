// Set first tab as active on page load
    document.addEventListener('DOMContentLoaded', function() {
        const firstTab = document.querySelector('.filter-tab');
        if (firstTab) {
            firstTab.classList.add('active');
            firstTab.classList.add('bg-[#BF9374]');
            firstTab.classList.add('text-white');
        }
    });

    function filterMessages(status) {
        const messages = document.querySelectorAll('.message-item');
        const tabs = document.querySelectorAll('.filter-tab');
        
        // Update tabs
        tabs.forEach(tab => {
            tab.classList.remove('active');
            tab.classList.remove('bg-[#BF9374]');
            tab.classList.remove('text-white');
            tab.classList.add('bg-[#f5f5f5]');
            tab.classList.add('text-[#666]');
        });
        
        event.target.classList.add('active');
        event.target.classList.add('bg-[#BF9374]');
        event.target.classList.add('text-white');
        event.target.classList.remove('bg-[#f5f5f5]');
        event.target.classList.remove('text-[#666]');
        
        // Filter messages
        messages.forEach(message => {
            if (status === 'all') {
                message.classList.remove('hidden');
            } else {
                const messageStatus = message.getAttribute('data-status');
                if (messageStatus === status) {
                    message.classList.remove('hidden');
                } else {
                    message.classList.add('hidden');
                }
            }
        });
    }

    function markAsRead(inboxId, element) {
        if (inboxId === 0) return;
        
        fetch('mark_read.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'inbox_id=' + inboxId
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                const messageItem = element;
                if (messageItem) {
                    messageItem.classList.remove('unread');
                    messageItem.classList.remove('bg-[#e8f4fd]');
                    messageItem.classList.add('bg-[#fafafa]');
                    
                    const unreadBadge = document.querySelector('.unread-count');
                    if (unreadBadge) {
                        const currentCount = parseInt(unreadBadge.textContent);
                        if (currentCount > 1) {
                            unreadBadge.textContent = (currentCount - 1) + ' New';
                        } else {
                            unreadBadge.remove();
                        }
                    }
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    // ------------------ ACCOUNT DROPDOWN TOGGLE ------------------
function toggleAccountDropdown() {
    const dropdown = document.getElementById('accountDropdown');
    if (dropdown) {
        dropdown.classList.toggle('hidden');
    }
}

// Close dropdown when clicking outside
document.addEventListener('click', function(e) {
    const dropdown = document.getElementById('accountDropdown');
    const accountIcon = document.querySelector('img[alt="Account Icon"]');
    
    if (dropdown && accountIcon && !dropdown.contains(e.target) && !accountIcon.contains(e.target)) {
        dropdown.classList.add('hidden');
    }
});