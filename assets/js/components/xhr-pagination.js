document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.js-xhr-paginated').forEach(function (el) {
        const triggerObject = document.querySelector(el.dataset.trigger)

        triggerObject.addEventListener('click', async function (e) {
            e.preventDefault()
            let nextPage = el.dataset.nextPage

            const response = await fetch(nextPage)
                .then(function (response) {
                    if (response.ok) {
                        return response.json()
                    }
                }).catch((e) => {
                    console.log(e)
                    alert('Une erreur est survenue')
                })

            // Add new content in grid
            const placeholder = document.createElement('div')
            placeholder.innerHTML = response.content
            const firstElement = placeholder.children.item(0)
            el.append(...placeholder.childNodes)

            // Scroll to first element
            firstElement.scrollIntoView()

            // Rebind trick remove buttons
            document.dispatchEvent(new Event('refreshRemoveTrickButtons'))

            // Handle next page if exists, or delete button
            if (!response.paginator.is_last_page) {
                el.dataset.nextPage = response.paginator.next_page_url
            } else {
                triggerObject.remove()
            }
        })
    })
})