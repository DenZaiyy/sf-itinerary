import { Controller } from '@hotwired/stimulus';

export default class extends Controller {

    /**
     *  Variables d'instance
     */
    static values = {
        addLabel: String,
        deleteLabel: String
    }

    /**
     * Injecte dynamiquement le bouton "Ajouter" et les boutons "Supprimer"
     */
    connect() {
        // Récupère l'élément parent
        this.index = this.element.childElementCount
        // Crée un bouton "Ajouter" et l'ajoute à la fin de l'élément selectionné
        const btn = document.createElement('button')
        // Ajoute les classes CSS au bouton
        btn.setAttribute('class', 'p-2 bg-blue-500 text-white rounded-md w-full')
        // Définit le texte du bouton "Ajouter"
        btn.innerText = this.addLabelValue || 'Ajouter un élément'
        // Définit l'attribut "type" du bouton
        btn.setAttribute('type', 'button')
        // Ajoute un événement au bouton "Ajouter" pour ajouter un nouvel élément
        btn.addEventListener('click', this.addElement)
        // Ajoute un bouton de suppression à chaque élément existant
        this.element.childNodes.forEach(this.addDeleteButton)
        this.element.append(btn)
    }

    /**
     * Ajoute une nouvelle entrée dans la structure HTML
     *
     * @param {MouseEvent} e
     */
    addElement = (e) => {
        // Empêche le comportement par défaut du bouton
        e.preventDefault()
        // Récupère le modèle de prototype
        const element = document.createRange().createContextualFragment(
            this.element.dataset['prototype'].replaceAll('__name__', this.index)
        ).firstElementChild
        // Ajoute un bouton de suppression à l'élément
        this.addDeleteButton(element)
        // Incrémente l'index pour le prochain élément
        this.index++
        // Ajoute l'élément avant le bouton "Ajouter"
        e.currentTarget.insertAdjacentElement('beforebegin', element)
    }

    /**
     * Ajoute le bouton pour supprimer une ligne
     *
     * @param {HTMLElement} item
     */
    addDeleteButton = (item) => {
        // Crée un bouton "Supprimer" et l'ajoute à l'élément
        const btn = document.createElement('button')
        // Ajoute les classes CSS au bouton
        btn.setAttribute('class', 'p-2 bg-red-500 text-white rounded-md w-full my-2')
        // Définit le texte du bouton "Supprimer"
        btn.innerText = this.deleteLabelValue || 'Supprimer'
        // Définit l'attribut "type" du bouton
        btn.setAttribute('type', 'button')
        // Ajouter le bouton Supprimer à l'élément récupérer
        item.append(btn)
        // Ajoute un événement au bouton "Supprimer" pour supprimer l'élément
        btn.addEventListener('click', e => {
            // Empêche le comportement par défaut du bouton
            e.preventDefault()
            // Supprime l'élément
            item.remove()
        })
    }
}
