function couch_select() {
    /**
     * @type {HTMLFormElement}
     */
    const media_select = document.getElementById('media-select');

    /**
     * @type {HTMLInputElement}
     */
    const media = document.getElementById('media');

    for (const media_select_button of document.querySelectorAll('.media-select-button')) {
        media_select_button.addEventListener('click', () => {
            media.value = media_select_button.dataset.uuid;

            media_select.submit();
        });
    }
}

if (app.dataset.name === 'couch-select') {
    couch_select();
}