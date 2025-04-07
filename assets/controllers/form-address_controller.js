import {Controller} from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['address', 'latitude', 'longitude']
    static debounceTimer = null
    static selectCity = document.createElement('select')

    connect() {
        const select = this.constructor.selectCity
        select.id = "selectCity"

        this.showSelect()

        const parent = document.getElementById("address-field")

        parent.appendChild(select)
    }

    showSelect() {
        if(!this.addressTarget.value) {
            this.constructor.selectCity.className = "hidden"
        } else {
            this.constructor.selectCity.className = "p-2 border border-gray-300 rounded-md w-full"
        }
    }

    typing() {
        this.showSelect()
        const address = this.addressTarget.value;

        // Nettoie l'ancien timer si l'utilisateur tape encore
        clearTimeout(this.constructor.debounceTimer);

        // Lance un nouveau timer qui s'exécutera dans 600ms (par exemple)
        this.constructor.debounceTimer = setTimeout(() => {
            this.fetchCoordinates(address);
        }, 600);
    }

    async fetchCoordinates(address) {
        if (!address) return;

        const url = `https://nominatim.openstreetmap.org/search?format=jsonv2&q=${encodeURIComponent(address)}&limit=20`;

        try {
            const response = await fetch(url, {
                headers: {
                    'Accept': 'application/json'
                }
            })

            const data = await response.json();

            const select = document.getElementById("selectCity")
            select.innerHTML = ""


            if(data.length >= 0) {
                for (const loc in data) {
                    const option = document.createElement('option')
                    option.value = loc
                    option.innerText = data[loc]["display_name"]

                    select.appendChild(option)
                }

                const location = data[select.value];
                const lat = location.lat
                const lon = location.lon

                this.latitudeTarget.value = lat;
                this.longitudeTarget.value = lon;

                select.addEventListener('change', (e) => {
                    e.preventDefault()
                    const dataValue = select.value
                    const location = data[dataValue];
                    const lat = location.lat
                    const lon = location.lon

                    this.latitudeTarget.value = lat;
                    this.longitudeTarget.value = lon;
                })
            } else {
                console.warn('Aucune coordonnée trouvée pour cette adresse.')
            }

        } catch (err) {
            console.error('Erreur pendant la récupération des coordonnées: ', err)
        }
    }
}
