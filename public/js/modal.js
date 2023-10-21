const myModal = new HystModal({
    linkAttributeName: 'data-toggle',
    catchFocus: true,
    waitTransitions: true,
    closeOnEsc: false,
    // beforeOpen: function(modal){
    //     console.log('Message before opening the modal');
    //     console.log(modal); //modal window object
    // },
    // afterClose: function(modal){
    //     console.log('Message after modal has closed');
    //     console.log(modal); //modal window object
    // },
});

//Функция клонирует форму внутри модального окна
function cloneHandler(item){
    const form = item.parentNode.parentNode
    const cloneObject = form.querySelector('.clone').cloneNode(true)
    const cloneObjects =form.querySelectorAll('.cloneObj')
    const lastHead =form.querySelectorAll('.num')[form.querySelectorAll('.num').length-1]
    const num = Number(lastHead.innerText.slice(-2,-1))===0 ? Number(lastHead.innerText.slice(-1)):Number(lastHead.innerText.slice(-2,-1))
    const content = form.querySelector('.content')
    const del = document.createElement('button')
    del.className='delClone inline-flex mx-1 items-center p-1.5 bg-red-600 border border-transparent rounded-md hover:bg-red-700 active:bg-red-800 focus:outline-none focus:border-red-900 focus:ring ring-red-600 disabled:opacity-25 transition ease-in-out duration-150'
    del.innerHTML='x'
    del.type="button"
    del.addEventListener('click',delCloneHandler)
    cloneObject.classList.remove('clone')
    cloneObject.classList.add('cloneObj')
    cloneObject.querySelector('.num').innerHTML='# '+String(num+1)
    cloneObject.querySelector('.num').append(del)
    cloneObject.querySelectorAll('input').forEach(function (item){
        item.value=''
    })
    if(cloneObject.querySelector('.sec-hid-img') && cloneObject.querySelector('.main-hid-img')){
        cloneObject.querySelector('textarea').innerText=''
        cloneObject.querySelectorAll('.remGenre').forEach(function (item){
            item.parentNode.remove()
        })
        const main_img = cloneObject.querySelector('.main-img[src]')// IMG
        main_img.src = ''
        main_img.alt = ''
        main_img.title = ''
        main_img.classList.add('hidden')
        cloneObject.querySelector('.main-hid-img').classList.remove('hidden')
        cloneObject.querySelector('.sec-hid-img').querySelectorAll('span').forEach(function (item){
            item.remove()
        })
        cloneObject.querySelector('.sec-hid-img').classList.add('hidden')
        console.log(cloneObjects.length)
        if(cloneObjects.length!==0){
            const imgName =cloneObjects[cloneObjects.length-1].querySelector('input[type="file"].sec-img').name
            const genreName =cloneObjects[cloneObjects.length-1].querySelector('.addGenre').parentNode.querySelector('select').name
            cloneObject.querySelector('input[type="file"].sec-img').name= 'images['+Number(Number(imgName.slice(imgName.indexOf('[')+1,imgName.indexOf('[')+2))+1)+'][]'
            cloneObject.querySelector('.addGenre').parentNode.querySelector('select').name= 'genre['+Number(Number(genreName.slice(genreName.indexOf('[')+1,genreName.indexOf('[')+2))+1)+'][]'
        }else{
            console.log(7)
            const imgName =cloneObject.querySelector('input[type="file"].sec-img').name
            const genreName =cloneObject.querySelector('.addGenre').parentNode.querySelector('select').name
            cloneObject.querySelector('input[type="file"].sec-img').name= 'images['+Number(Number(imgName.slice(imgName.indexOf('[')+1,imgName.indexOf('[')+2))+1)+'][]'
            cloneObject.querySelector('.addGenre').parentNode.querySelector('select').name= 'genre['+Number(Number(genreName.slice(genreName.indexOf('[')+1,genreName.indexOf('[')+2))+1)+'][]'
        }
    }
    content.append(cloneObject)
}

//Функция удаления склонированного объекта
function delCloneHandler(e){
    e.target.parentNode.parentNode.parentNode.remove()
}

//Инициализация прослушиваний
function init(){
    const btnClone = document.querySelectorAll('.addClone')
    btnClone.forEach(function(item){
        item.addEventListener('click',()=>cloneHandler(item))
    })
}
init()
