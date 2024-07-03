document.addEventListener('DOMContentLoaded', function () {
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
})