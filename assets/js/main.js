document.addEventListener('DOMContentLoaded', function () {
    //------------------------------------------------------------
    //-------------------- MODAL INTERACTIONS --------------------
    //------------------------------------------------------------

    document.querySelectorAll('[data-modal]').forEach((el) => {
        el.addEventListener('click', function (e) {
            e.preventDefault()
            const modal = e.currentTarget.dataset.modal
            document.querySelector(modal).classList.add('open')
        })
    })

    document.querySelectorAll('.modal').forEach((el) => {
        el.querySelector('.modal__overlay').addEventListener('click', function (e) {
            e.currentTarget.parentNode.classList.remove('open')
        })

        el.querySelectorAll('.js-modal-close').forEach((el) => el.addEventListener('click', function (e) {
            e.currentTarget.closest('.modal').classList.remove('open')
        }))
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

    //------------------------------------------------------------
    //--------------------- TRICK FORM MEDIA  --------------------
    //------------------------------------------------------------


    // ADD BUTTONS
    document.querySelectorAll('.js-media-add').forEach((el) => {
        el.addEventListener('click', e => {
            const target = document.getElementById('form-trick-medias')

            const container = document.createElement('div');
            container.classList.add('media-form-container');

            // Append form
            const item = document.createElement('div');
            item.innerHTML = e.currentTarget.dataset.prototype.replace(/__name__/g, e.currentTarget.dataset.index);
            item.querySelector('div').classList.add('media-form')
            container.appendChild(item);

            // Append remove button
            const buttonContainer = document.createElement('div');
            buttonContainer.classList.add('flex', 'justify-center', 'mt-2');
            const button = document.createElement('button');
            button.classList.add('text-gray-700')
            button.setAttribute('type', 'button')
            button.innerHTML = `<svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>`
            bindRemoveButton(button)
            buttonContainer.appendChild(button);
            container.appendChild(buttonContainer)

            target.appendChild(container)

            e.currentTarget.dataset.index++
        })
    })

    // REMOVE BUTTON
    document.querySelectorAll('.js-delete-media').forEach((el) => {
        bindRemoveButton(el)
    })

    function bindRemoveButton(button) {
        button.addEventListener('click', e => {
            const domTarget = e.currentTarget.closest('.media-form-container')
            domTarget.remove()
        })
    }

    // EDIT BUTTON
    document.querySelectorAll('.js-edit-media').forEach((el) => {
        el.addEventListener('click', e => {
            const domTarget = document.getElementById(e.currentTarget.dataset.targetId)
            domTarget.querySelector('.js-edit-media').classList.add('hidden')
            domTarget.querySelector('.media-display').classList.add('hidden')
            domTarget.querySelector('.media-form').classList.remove('hidden')
        })
    })

    //------------------------------------------------------------
    //----------------------- TRICK REMOVE -----------------------
    //------------------------------------------------------------


    document.querySelectorAll('.js-remove-trick').forEach((el) => {
        el.addEventListener('click', e => {
            e.preventDefault()
            const trickId = e.currentTarget.dataset.trickId
            const modal = document.getElementById('trick-remove-modal')

            document.getElementById('remove_trick_form_id').value = trickId

            modal.classList.add('open')
        })
    })
})