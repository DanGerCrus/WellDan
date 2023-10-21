//Предпоказ изображения
function handleFileSelect(evt) {
    const file = evt.target.files; // FileList object
    const div = evt.target.parentNode.parentNode.parentNode.querySelector('.main-hid-img')// div
    const img = evt.target.parentNode.parentNode.parentNode.querySelector('.main-img[src]')// IMG
    const f = file[0];
    // Only process image files.
        if (!file.length || (!f.type.match('image/jpeg') && !f.type.match('image/png'))) {
            img.src = ''
            img.alt = ''
            img.title = ''
            img.classList.add('hidden')
            div.classList.remove('hidden')
        }
        else{
            const reader = new FileReader();
            // Closure to capture the file information.
            reader.onload = (function (theFile) {
                return function (e) {
                    // Render thumbnail.
                    img.src = e.target.result
                    img.alt = escape(theFile.name)
                    img.title = escape(theFile.name)
                    img.classList.remove('hidden')
                    div.classList.add('hidden')
                };
            })(f);
            // Read in the image file as a data URL.
            reader.readAsDataURL(f);
        }
}
//Предпоказ множество изображений
function handleFileMultiSelect(evt) {
    const files = evt.target.files; // FileList object
    const div = evt.target.parentNode.parentNode.parentNode.querySelector('.sec-hid-img')// div
    div.querySelectorAll('span').forEach(function (item){
        item.remove()
    })
    if (!files.length) {
        div.querySelectorAll('span').forEach(function (item){
            item.remove()
        })
        div.classList.add('hidden')
    }else{
        div.classList.remove('hidden')
        for (let i = 0, f; f = files[i]; i++) {
            // Only process image files.
            if ((!f.type.match('image/jpeg') && !f.type.match('image/png'))) {
                files.splice(i,1)
            } else {
                const reader = new FileReader();
                // Closure to capture the file information.
                reader.onload = (function (theFile) {
                    return function (e) {
                        // Render thumbnail.
                        const span = document.createElement('span');
                        span.innerHTML = ['<img class="h-12 w-12 mx-4 cursor-pointer" data-toggle="#imgModal" title="', escape(theFile.name), '" src="', e.target.result, '" />'].join('');
                        div.append(span);
                    };
                })(f);
                // Read in the image file as a data URL.
                reader.readAsDataURL(f);
            }
        }
    }
}

function imgModalHandler(e){
    const img= e.target.cloneNode(true)
    const name = img.title
    const modal = document.getElementById('imgModal')
    img.className='w-96 border border-black'
    modal.querySelector('.modal_header').innerHTML=name
    modal.querySelector('.modal_body').querySelectorAll('img').forEach(function(item){
        item.remove()
    })
    modal.querySelector('.modal_body').append(img)
}

if(document.querySelector('.container')){
    document.querySelector('.container').addEventListener('change',function (e){
        if(e.target && e.target.matches('.main-img[type="file"]')){
            handleFileSelect(e)
        }
        if(e.target && e.target.matches('.sec-img[type="file"]')){
            handleFileMultiSelect(e)
        }
    })
    document.querySelector('.container').addEventListener('click',function (e){
        if(e.target && e.target.matches('img[data-toggle="#imgModal"]')){
            imgModalHandler(e)
        }
    })
}
