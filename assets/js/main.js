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


document.querySelector('.js-show-medias').addEventListener('click', function (e) {
  document.querySelector('.trick-medias').classList.replace('hidden', 'flex')
  document.querySelector('.js-hide-medias').classList.replace('hidden', 'flex')
  e.currentTarget.classList.replace('flex', 'hidden')
})

document.querySelector('.js-hide-medias').addEventListener('click', function (e) {
  document.querySelector('.trick-medias').classList.replace('flex', 'hidden')
  document.querySelector('.js-show-medias').classList.replace('hidden', 'flex')
  e.currentTarget.classList.replace('flex', 'hidden')
})
