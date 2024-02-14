document.addEventListener('DOMContentLoaded', function() {
    const uploadButton = document.getElementById('ct_tax_media_button');
    const removeButton = document.getElementById('ct_tax_media_remove');
    const imageIdInput = document.getElementById('perseo-category-image-id');
    const imageWrapper = document.getElementById('category-image-wrapper');

    uploadButton.addEventListener('click', function() {
        const mediaUploader = wp.media({
            title: 'Select an image',
            button: {
                text: 'Use this image'
            },
            multiple: false
        }).on('select', function() {
            const attachment = mediaUploader.state().get('selection').first().toJSON();
            imageIdInput.value = attachment.id;
            imageWrapper.innerHTML = `<img src="${attachment.url}" style="max-width:100%; height:auto;">`;
        }).open();
    });

    removeButton.addEventListener('click', function() {
        imageIdInput.value = '';
        imageWrapper.innerHTML = '';
    });
});
