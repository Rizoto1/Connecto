//ctrl + f5 na hard refresh !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!§
//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
// Event delegation for performance and to handle dynamically loaded posts

// Helper: get auth state from body data attributes injected by server layout
// NOTE: Read these values lazily (inside event handlers) because this script is loaded in <head>
// and the <body> element with data-* attributes may not be parsed yet at load time.
// const bodyEl = document.body; // old eager read (can be null/without dataset early)
// const isLoggedIn = bodyEl?.dataset?.loggedIn === '1';
// const loginUrl = bodyEl?.dataset?.loginUrl || '/login';

document.addEventListener('click', (e) => {
    const target = e.target;

    // Hľadáme button v toolbar-e daného príspevku
    const commentButton = target.closest('.post-toolbar button');
    if (commentButton) {
        // Read auth state at the moment of interaction to ensure correctness
        const isLoggedIn = document.body?.dataset?.loggedIn === '1';

        // Block guests from opening comments
        if (!isLoggedIn) {
            e.preventDefault();
            // Optional: guide user to login
            alert('Pre prístup ku komentárom sa musíte prihlásiť.');
            // Optional: redirect after confirmation could be added here using loginUrl
            return; // stop handling
        }

        const postItem = commentButton.closest('.post-item');
        if (postItem) {
            // Toggle post shift-left to make visual space
            postItem.classList.toggle('shift-left');

            // Toggle the comment window inside this post
            const commentWindow = postItem.querySelector('.comment-window');
            if (commentWindow) {
                const isOpen = commentWindow.classList.toggle('open');
                commentWindow.setAttribute('aria-hidden', String(!isOpen));
            }
        }
        e.preventDefault();
    }
});

// Global utility to toggle edit panels by field key (e.g., 'username', 'email', 'password', 'avatar')
// Kept simple and dependency-free so it works across views that call onclick="toggleEdit('field')"
function toggleEdit(field) {
    try {
        var el = document.getElementById('edit-' + field);
        if (!el) return;
        var isHidden = el.style.display === 'none' || el.style.display === '';
        el.style.display = isHidden ? 'block' : 'none';
        if (isHidden) {
            var input = el.querySelector('input, textarea, select');
            if (input) { input.focus(); }
        }
    } catch (e) {
        // Fail silently to avoid breaking other interactions
        // console.warn('toggleEdit error', e);
    }
}

// Profile form: enable "Uložiť zmeny" only when something actually changed
// Runs after DOM is parsed so elements exist even though this script is loaded in <head>
document.addEventListener('DOMContentLoaded', function () {
    try {
        var form = document.getElementById('profileForm');
        if (!form) return; // not on the profile page

        var saveBtn = document.getElementById('saveBtn');
        var usernameInput = document.getElementById('username');
        var emailInput = document.getElementById('email');
        var passwordInput = document.getElementById('password');
        var avatarInput = document.getElementById('avatar');

        var initial = {
            username: usernameInput ? usernameInput.value : '',
            email: emailInput ? emailInput.value : ''
            // password and avatar are treated as unchanged when empty
        };

        function computeDirty() {
            var dirty = false;
            if (usernameInput && usernameInput.value !== initial.username) dirty = true;
            if (!dirty && emailInput && emailInput.value !== initial.email) dirty = true;
            if (!dirty && passwordInput && passwordInput.value.length > 0) dirty = true;
            if (!dirty && avatarInput && avatarInput.files && avatarInput.files.length > 0) dirty = true;
            return dirty;
        }

        function updateButton() {
            var dirty = computeDirty();
            if (saveBtn) {
                saveBtn.disabled = !dirty;
                if (saveBtn.disabled) {
                    saveBtn.setAttribute('aria-disabled', 'true');
                } else {
                    saveBtn.removeAttribute('aria-disabled');
                }
            }
        }

        var inputs = [usernameInput, emailInput, passwordInput, avatarInput].filter(Boolean);
        inputs.forEach(function (el) {
            var eventName = (el.type === 'file') ? 'change' : 'input';
            el.addEventListener(eventName, updateButton);
            el.addEventListener('change', updateButton);
        });

        // Initial state
        updateButton();
    } catch (e) {
        // Silent fail to avoid breaking other pages
    }
});
