document.addEventListener('DOMContentLoaded', function () {
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
})