import {Controller} from '@hotwired/stimulus';
import {forEach} from "core-js/stable/dom-collections";

export default class extends Controller {
    static targets = ['address', 'latitude', 'longitude']
    static debounceTimer = null

    connect() {
        console.log("Stimulus connecté ✅");
        console.log("Address target :", this.addressTarget);
        console.log("Latitude target :", this.latitudeTarget);
        console.log("Longitude target :", this.longitudeTarget);
    }

    typing(event) {
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

        const url = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(address)}`;

        try {
            const response = await fetch(url, {
                headers: {
                    'Accept': 'application/json'
                }
            })

            const data = await response.json();
            console.log('Data: ', data)

            if(data.length >= 0) {
                const location = data[0];
                const lat = location.lat
                const lon = location.lon

                this.latitudeTarget.value = lat;
                this.longitudeTarget.value = lon;

                console.log('Coords updated: ', location.lat, location.lon)
            } else {
                console.warn('Aucune coordonnée trouvée pour cette adresse.')
            }

        } catch (err) {
            console.error('Erreur pendant la récupération des coordonnées: ', err)
        }
    }
}
