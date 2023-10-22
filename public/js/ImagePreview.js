class ImagePreview
{
    static fileInputsSelector = '.use-ImagePreview';
    static canvasSelector = '#canvas_ImagePreview';
    static svgSelector = '#default_ImagePreview';
    static modalSelector = '#modal_ImagePreview';
    static modalCanvasSelector = '#modalImage_ImagePreview';

    constructor() {
        ImagePreview.addListeners();
    }

    static addListeners() {
        const fileInputs = document.querySelectorAll(ImagePreview.fileInputsSelector);

        if (fileInputs) {
            fileInputs.forEach((fileInput) => {
                fileInput.addEventListener('change', (event) => ImagePreview.updatePreview(event));
            });
        }
    }

    static updatePreview(event) {
        const fileInput = event.target;
        const canvasImagePreview = document.querySelector(ImagePreview.canvasSelector);
        const modalCanvasImagePreview = document.querySelector(ImagePreview.modalCanvasSelector);
        const defaultImagePreview = document.querySelector(ImagePreview.svgSelector);

        if (fileInput.files[0]) {
            canvasImagePreview.classList.remove('hidden');
            defaultImagePreview.classList.add('hidden');
            canvasImagePreview.src = URL.createObjectURL(fileInput.files[0]);
            modalCanvasImagePreview.src = URL.createObjectURL(fileInput.files[0]);
            canvasImagePreview.onload = function() {
                URL.revokeObjectURL(canvasImagePreview.src);
            }
        } else {
            canvasImagePreview.classList.add('hidden');
            defaultImagePreview.classList.remove('hidden');
            canvasImagePreview.src = '';
            modalCanvasImagePreview.src = '';
        }
    }
}

