import './bootstrap.js';
import './styles/app.css';
import Sortable from 'sortablejs';

let itineraryId = null

const alert = document.querySelector('#flashMessage')
if (alert) {
    setTimeout(function() {
        alert.remove()
    }, 3000);
}
const itinerary = document.getElementById('itinerary')
if(itinerary) {
    itineraryId = itinerary.dataset.itineraryId
}

const container = document.getElementById("sort-container")

if(container) {
    Sortable.create(container, {
        sort: true,
        animation: 150,
        draggable: ".location",

        ghostClass: "sortable-ghost",
        chosenClass: "sortable-chosen",
        dragClass: "sortable-drag",


        // Element dragging ended
        onEnd: function () {
            updatePositions()
            savePositions()
        },
    });
    function updatePositions() {
        // Mettre à jour les attributs data-position de chaque élément
        Array.from(document.querySelectorAll('#sort-container a')).forEach((item, index) => {
            item.setAttribute('data-position', index+1);
        });

        Array.from(document.querySelectorAll('#sort-container a .order')).forEach((item, index) => {
            item.setAttribute('data-order', index+1)
            item.innerHTML = index+1
        })
    }

    function savePositions() {
        const items = Array.from(document.querySelectorAll('#sort-container a')).map(
            (item, index) => ({
                id: item.getAttribute('data-id'),
                order: index+1
            })
        )

        fetch(`/itinerary/${itineraryId}/update`, {
            method: "PUT",
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({items})
        })
            .then(response => response.json())
            .then(data => {
                console.log('Order saved successfully: ', data)
            })
            .catch(error => {
                console.error('Error when tried to save orders: ', error)
            })
    }

    updatePositions()
}
