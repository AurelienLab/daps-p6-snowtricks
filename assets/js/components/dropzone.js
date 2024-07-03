document.addEventListener('DOMContentLoaded', function () {
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