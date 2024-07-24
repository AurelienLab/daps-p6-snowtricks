document.addEventListener('DOMContentLoaded', function (e) {
    const arrow = document.querySelector('.js-tricks-arrow-up');

    if (typeof arrow !== 'undefined') {
        const trickList = document.getElementById('trick-list')
        document.addEventListener('scroll', function (e) {

            let rect = trickList.getBoundingClientRect()
            if (rect.top <= 0) {
                arrow.classList.remove('opacity-0', 'invisible')
            } else {
                arrow.classList.add('opacity-0', 'invisible')
            }
        })
        arrow.addEventListener('click', function (e) {
            e.preventDefault()

            const trickSection = document.getElementById('tricks')
            trickSection.scrollIntoView()
        })
    }

})