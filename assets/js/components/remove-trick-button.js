document.addEventListener('DOMContentLoaded', function () {
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