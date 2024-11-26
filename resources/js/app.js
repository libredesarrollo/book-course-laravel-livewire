import { Alignment, Position } from 'ckeditor5'
import toast from 'toast-me'

// import { Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';

// import Alpine from 'alpinejs'
// import { persist } from '@alpinejs/persist'
import Sortable from 'sortablejs'

// console.log(persist)
// Alpine.plugin(p)

// console.log(Alpine)

// window.Alpine = Alpine
window.Sortable = Sortable

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