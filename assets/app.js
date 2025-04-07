import './bootstrap.js';
import './styles/app.css';

const alert = document.querySelector('#flashMessage')
if (alert) {
    setTimeout(function() {
        alert.remove()
    }, 3000);
}
