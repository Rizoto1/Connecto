//ctrl + f5 na hard refresh !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!§
//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
// Event delegation for performance and to handle dynamically loaded posts

document.addEventListener('click', (e) => {
    console.log("Testing click event");
    const target = e.target;

    // Teraz hľadáme button, nie a-tag
    const commentButton = target.closest('.post-toolbar button');
    if (commentButton) {
        const postItem = commentButton.closest('.post-item');
        if (postItem) {
            postItem.classList.toggle('shift-left');
            console.log("Shift triggered");
        }
        e.preventDefault();
    }
});


