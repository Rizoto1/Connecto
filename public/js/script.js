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
        const loginUrl = document.body?.dataset?.loginUrl || '/login';

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
