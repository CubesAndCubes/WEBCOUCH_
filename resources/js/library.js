function media_upload() {
    const media_upload_button = document.getElementById('media-upload-button');

    /**
     * @type {HTMLInputElement}
     */
    const media = document.getElementById('media');

    /**
     * @type {HTMLFormElement}
     */
    const media_upload = document.getElementById('media-upload');

    media_upload_button.addEventListener('click', () => {
        media.click();
    });

    media.addEventListener('change', () => {
        if (1 > media.files.length) {
            return;
        }

        media_upload.submit();
    });
}

if (app.dataset.name === 'library') {
    media_upload();
}