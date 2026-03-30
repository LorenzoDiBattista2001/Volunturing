const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

const form = document.getElementById('form');
const cardNumber = document.getElementById('cardNumber');
const expirationDate = document.getElementById('expirationDate');
const cvv = document.getElementById('cvv');

const cardNumberFeedback = document.getElementById('cardNumberFeedback');
const expirationDateFeedback = document.getElementById('expirationDateFeedback');
const cvvFeedback = document.getElementById('cvvFeedback');

form.addEventListener('submit', (event) => {

    if(!validateCardNumber(cardNumber.value)) {
        cardNumber.setCustomValidity("Formato non valido");
        cardNumberFeedback.textContent = 'Il numero della carta non è valido';
    } else {
        cardNumber.setCustomValidity("");
        cardNumberFeedback.textContent = '';
    }

    if(!validateExpirationDateFormat(expirationDate.value)) {
        expirationDate.setCustomValidity("Formato non valido");
        expirationDateFeedback.textContent = 'La data inserita non è in un formato valido (MM/AA)';
    } else {
        if(!validateExpirationDate(expirationDate.value)) {
            expirationDate.setCustomValidity("Carta scaduta");
            expirationDateFeedback.textContent = 'La carta è scaduta';
        } else {
            expirationDate.setCustomValidity("");
            expirationDateFeedback.textContent = '';
        }
    }

    if(!validateCVV(cvv.value)) {
        cvv.setCustomValidity("Formato non valido");
        cvvFeedback.textContent = 'Il codice inserito non è valido';
    } else {
        cvv.setCustomValidity("");
        cvvFeedback.textContent = '';
    }

    if(!form.checkValidity()) {
        event.preventDefault();
        event.stopPropagation();
    }
    form.classList.add('was-validated');
});

function validateCardNumber(number) {
    let pattern = new RegExp("^[0-9]{16}$");
    return pattern.test(number);
}

function validateExpirationDate(expirationDate) {
    const array = expirationDate.split('/');
    const month = parseInt(array[0]);
    const year = parseInt('20' + array[1]);

    const expirationDateObject = new Date(
        year, month, 0, 23, 59, 59
    );
    return expirationDateObject > new Date();
}

function validateExpirationDateFormat(expirationDate) {
    let pattern = new RegExp("^(0[1-9]|1[0-2])\/[1-6][0-9]$");
    return pattern.test(expirationDate);
}

function validateCVV(cvv) {
    let pattern = new RegExp("^[0-9]{3}$");
    return pattern.test(cvv);
}