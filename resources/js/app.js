import { Position } from 'ckeditor5'
import toast from 'toast-me'

window.toast = toast

const options = {
    position: 'bottom'
}

Livewire.on('itemAdd', (params) => {
    toast('Item add to cart: ' + params[0].title, options)
})
Livewire.on('itemChange', (params) => {
    toast('Item chante to cart: ' + params[0].title, options)
})
Livewire.on('itemDelete', () => {
    toast('Item delete to cart', options)
})