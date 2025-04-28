import {Controller} from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['address', 'latitude', 'longitude']
    static debounceTimer = null
    static selectCity = document.createElement('select')

    connect() {
        // Récupérer l'élément de sélection de ville
        const select = this.constructor.selectCity
        // Ajouter les classes CSS au select
        select.id = "selectCity"

        // Appeler la méthode pour afficher/masquer le select
        this.showSelect()

        // Récupération de l'élément parent
        const parent = document.getElementById("address-field")

        // Ajouter le select au parent
        parent.appendChild(select)
    }

    showSelect() {
        // Afficher ou masquer le select en fonction de la valeur de l'input
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

    // Fonction asynchrone pour récupérer les coordonnées d'une adresse
    async fetchCoordinates(address) {
        // Vérifie si l'adresse est vide
        if (!address) return;

        // Crée l'URL de la requête avec l'adresse encodée et la limite de résultats
        const url = `https://nominatim.openstreetmap.org/search?format=jsonv2&q=${encodeURIComponent(address)}&limit=20`;

        // Utilisation de try/catch pour gérer les erreurs
        try {
            // Envoi de la requête fetch
            const response = await fetch(url, {
                headers: {
                    'Accept': 'application/json'
                }
            })

            // Récupération de la réponse au format JSON
            const data = await response.json();

            // Récupération de l'élément select
            const select = document.getElementById("selectCity")
            // Reinitialisation de l'élément select
            select.innerHTML = ""

            // Vérification si des données ont été retournées
            if(data.length >= 0) {
                // Pour chaque élément de données, on crée une option
                for (const loc in data) {
                    // Création de l'élément option
                    const option = document.createElement('option')
                    // Ajout de la valeur et du texte afficher pour chaque option
                    option.value = loc
                    option.innerText = data[loc]["display_name"]

                    // Ajout de l'option à l'élément select
                    select.appendChild(option)
                }

                // Récupération de la latitude et de la longitude selon l'option sélectionnée
                const location = data[select.value];
                const lat = location.lat
                const lon = location.lon

                // Ajout de la latitude et de la longitude dans les champs cibles
                this.latitudeTarget.value = lat;
                this.longitudeTarget.value = lon;

                // Ajout d'un événement pour mettre à jour la latitude et la longitude lorsque l'utilisateur change de sélection
                select.addEventListener('change', (e) => {
                    // Empêche le comportement par défaut du select
                    e.preventDefault()
                    // Récupération de la valeur sélectionnée
                    const dataValue = select.value
                    // Récupération de la latitude et de la longitude selon l'option sélectionnée
                    const location = data[dataValue];
                    const lat = location.lat
                    const lon = location.lon

                    // Ajout de la latitude et de la longitude dans les champs cibles
                    this.latitudeTarget.value = lat;
                    this.longitudeTarget.value = lon;
                })
            } else {
                // Sinon, on affiche un message d'erreur dans la console
                console.warn('Aucune coordonnée trouvée pour cette adresse.')
            }

        } catch (err) {
            // Gestion des erreurs sur la requête
            console.error('Erreur pendant la récupération des coordonnées: ', err)
        }
    }
}
