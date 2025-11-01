// ------------------ MODAL FUNCTIONS ------------------
function showLogin() {
    document.getElementById('loginModal').style.display = 'flex';
    document.getElementById('registerModal').style.display = 'none';
    document.getElementById('forgotPasswordModal').style.display = 'none';
    document.getElementById('resetPasswordModal').style.display = 'none';
    document.getElementById('adminLoginModal').style.display = 'none';
    setTimeout(initializePasswordToggles, 100);
}

function showRegister() {
    document.getElementById('registerModal').style.display = 'flex';
    document.getElementById('loginModal').style.display = 'none';
    document.getElementById('forgotPasswordModal').style.display = 'none';
    document.getElementById('resetPasswordModal').style.display = 'none';
    document.getElementById('adminLoginModal').style.display = 'none';
    setTimeout(initializePasswordToggles, 100);
}

function showForgotPassword() {
    document.getElementById('forgotPasswordModal').style.display = 'flex';
    document.getElementById('loginModal').style.display = 'none';
    document.getElementById('registerModal').style.display = 'none';
    document.getElementById('resetPasswordModal').style.display = 'none';
    document.getElementById('adminLoginModal').style.display = 'none';
}

function showResetPassword() {
    document.getElementById('resetPasswordModal').style.display = 'flex';
    document.getElementById('forgotPasswordModal').style.display = 'none';
    document.getElementById('loginModal').style.display = 'none';
    document.getElementById('registerModal').style.display = 'none';
    document.getElementById('adminLoginModal').style.display = 'none';
    setTimeout(initializePasswordToggles, 100);
}

function showAdminLogin() {
    document.getElementById('adminLoginModal').style.display = 'flex';
    document.getElementById('loginModal').style.display = 'none';
    document.getElementById('registerModal').style.display = 'none';
    document.getElementById('forgotPasswordModal').style.display = 'none';
    document.getElementById('resetPasswordModal').style.display = 'none';
    setTimeout(initializePasswordToggles, 100);
}

function closeModal(id) {
    document.getElementById(id).style.display = 'none';
}

// ------------------ PASSWORD TOGGLE FUNCTIONALITY ------------------
function initializePasswordToggles() {
    const passwordToggles = document.querySelectorAll('.password-toggle');
    
    passwordToggles.forEach(toggle => {
        // Remove existing event listeners to prevent duplicates
        toggle.replaceWith(toggle.cloneNode(true));
    });

    // Re-select the toggles after cloning
    const freshToggles = document.querySelectorAll('.password-toggle');
    
    freshToggles.forEach(toggle => {
        toggle.addEventListener('click', function() {
            const passwordInput = this.previousElementSibling;
            const icon = this.querySelector('i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('ph-eye');
                icon.classList.add('ph-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('ph-eye-slash');
                icon.classList.add('ph-eye');
            }
        });
    });
}

// Initialize password toggles when page loads
document.addEventListener('DOMContentLoaded', function() {
    initializePasswordToggles();
});

// ------------------ CLOSE MODAL ON OUTSIDE CLICK ------------------
window.addEventListener('click', function(e) {
    const modals = [
        'loginModal',
        'registerModal',
        'forgotPasswordModal',
        'resetPasswordModal',
        'adminLoginModal'
    ];
    
    modals.forEach(id => {
        const modal = document.getElementById(id);
        if (modal && e.target === modal) {
            modal.style.display = 'none';
        }
    });
});

// ------------------ COMMENTS SECTION ------------------
const form = document.getElementById('thoughtsForm');
const messageInput = document.getElementById('comment_message');
const commentsContainer = document.getElementById('commentsContainer');

if (form) {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const message = messageInput.value.trim();
        if (!message) return;
        const commentDiv = document.createElement('div');
        commentDiv.classList.add('comment');
        commentDiv.textContent = `Anonymous: ${message}`;
        commentsContainer.appendChild(commentDiv);
        commentsContainer.scrollTop = commentsContainer.scrollHeight;
        messageInput.value = '';
    });
}

// ------------------ FORGOT PASSWORD AJAX ------------------
const forgotForm = document.querySelector('#forgotPasswordModal form');
if (forgotForm) {
    forgotForm.addEventListener('submit', function(e){
        e.preventDefault();
        const username = this.username.value.trim();
        if(!username) {
            alert("Please enter your username.");
            return;
        }

        fetch('../dist/authentication/forgotpassword.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: 'username=' + encodeURIComponent(username)
        })
        .then(res => res.text())
        .then(response => {
            response = response.trim();
            if(response === "success") {
                closeModal('forgotPasswordModal');
                showResetPassword();
            } else {
                alert(response);
            }
        })
        .catch(err => {
            console.error('Error:', err);
            alert("Username was found! Please reset your password.");
        });
    });
}

// ------------------ RESET PASSWORD AJAX ------------------
const resetForm = document.querySelector('#resetPasswordModal form');
if (resetForm) {
    resetForm.addEventListener('submit', function(e){
        e.preventDefault();
        const newPass = this.new_password.value.trim();
        const confirmPass = this.confirm_password.value.trim();
        
        if(!newPass || !confirmPass) {
            alert("Please fill in all fields.");
            return;
        }

        if(newPass !== confirmPass) {
            alert("Passwords do not match.");
            return;
        }

        fetch('../dist/authentication/forgotpassword.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: 'new_password=' + encodeURIComponent(newPass) +
                  '&confirm_password=' + encodeURIComponent(confirmPass)
        })
        .then(res => res.text())
        .then(response => {
            response = response.trim();
            if(response === "success") {
                alert("Password reset successful! You can now login with your new password.");
                closeModal('resetPasswordModal');
                showLogin();
            } else {
                alert(response);
            }
        })
        .catch(err => {
            console.error('Error:', err);
            alert("An error occurred. Please try again.");
        });
    });
}
// ------------------ ACCOUNT DROPDOWN TOGGLE ------------------
function toggleAccountDropdown() {
    const dropdown = document.getElementById('accountDropdown');
    if (dropdown) {
        dropdown.classList.toggle('hidden');
    }
}

document.addEventListener('click', function(e) {
    const dropdown = document.getElementById('accountDropdown');
    const accountIcon = document.querySelector('img[alt="Account Icon"]');
    
    if (dropdown && accountIcon && !dropdown.contains(e.target) && !accountIcon.contains(e.target)) {
        dropdown.classList.add('hidden');
    }
});

function showLogin() {
    closeAllModals();
    document.getElementById('loginModal').style.display = 'flex';
    document.getElementById('loginModal').classList.add('show');
}

function showRegister() {
    closeAllModals();
    document.getElementById('registerModal').style.display = 'flex';
    document.getElementById('registerModal').classList.add('show');
}

function showForgotPassword() {
    closeAllModals();
    document.getElementById('forgotPasswordModal').style.display = 'flex';
    document.getElementById('forgotPasswordModal').classList.add('show');
}

function showAdminLogin() {
    closeAllModals();
    document.getElementById('adminModal').style.display = 'flex';
    document.getElementById('adminModal').classList.add('show');
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.style.display = 'none';
    modal.classList.remove('show');
}

function closeAllModals() {
    const modals = document.querySelectorAll('.modal-backdrop');
    modals.forEach(modal => {
        modal.style.display = 'none';
        modal.classList.remove('show');
    });
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modals = document.querySelectorAll('.modal-backdrop');
    modals.forEach(modal => {
        if (event.target === modal) {
            modal.style.display = 'none';
            modal.classList.remove('show');
        }
    });
}