//ctrl + f5 na hard refresh !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!§
//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
// Event delegation for performance and to handle dynamically loaded posts

document.addEventListener('click', (e) => {
    const target = e.target;

    // Hľadáme button v toolbar-e daného príspevku
    const commentButton = target.closest('.post-toolbar button');
    if (commentButton) {
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
