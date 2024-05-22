document.querySelectorAll('[data-media-modal]').forEach((el) => {
    el.addEventListener('click', function (e) {
        e.preventDefault()
        const modal = e.currentTarget.dataset.mediaModal
        document.querySelector(modal).classList.add('open')
    })
})

document.querySelectorAll('.media-modal').forEach((el) => {
    el.querySelector('.media-modal__overlay').addEventListener('click', function (e) {
        e.currentTarget.parentNode.classList.remove('open')
    })
})


const showMediasButton = document.querySelector('.js-show-medias')
if (showMediasButton) {
    showMediasButton.addEventListener('click', function (e) {
        document.querySelector('.trick-medias').classList.replace('hidden', 'flex')
        document.querySelector('.js-hide-medias').classList.replace('hidden', 'flex')
        e.currentTarget.classList.replace('flex', 'hidden')
    })
}

const hideMediasButton = document.querySelector('.js-hide-medias')
if (hideMediasButton) {
    hideMediasButton.addEventListener('click', function (e) {
        document.querySelector('.trick-medias').classList.replace('flex', 'hidden')
        document.querySelector('.js-show-medias').classList.replace('hidden', 'flex')
        e.currentTarget.classList.replace('flex', 'hidden')
    })
}

document.addEventListener('DOMContentLoaded', function () {

    //------------------------------------------------------------
    //----------------------- DRAG AND DROP ----------------------
    //------------------------------------------------------------

    const dropzones = document.querySelectorAll('label.dropzone');

    function displayPreview(file) {
        var reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = () => {
            var preview = document.getElementById('preview');
            preview.src = reader.result;
            preview.classList.remove('hidden');
        };
    }

    dropzones.forEach(function (dropzone) {
        dropzone.addEventListener('dragover', e => {
            e.preventDefault();
            dropzone.classList.add('border-indigo-600');
        });

        dropzone.addEventListener('dragleave', e => {
            e.preventDefault();
            dropzone.classList.remove('border-indigo-600');
        });

        dropzone.addEventListener('drop', e => {
            e.preventDefault();
            dropzone.classList.remove('border-indigo-600');
            const file = e.dataTransfer.files[0];
            displayPreview(file);
        });

        const input = document.getElementById(dropzone.attributes.for.value);

        input.addEventListener('change', e => {
            const file = e.target.files[0];
            displayPreview(file);
        });
    })
})