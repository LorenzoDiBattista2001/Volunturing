const form = document.getElementById('eventForm');
const date = document.getElementById('date');
const eventDateFeedback = document.getElementById('eventDateFeedback');
const fieldOfAction = document.getElementById('fieldOfAction');

const requestedInput = document.getElementById('requestedVolunteerNumber');
const maxInput = document.getElementById('maxVolunteerNumber');
const volunteerFeedback = document.getElementById('volunteerNumberFeedback');

requestedInput.addEventListener('input', validateVolunteerNumbers);
maxInput.addEventListener('input', validateVolunteerNumbers);

date.addEventListener('change', (e) => {
    let eventDate = new Date(date.value);
    let now = new Date();

    if(eventDate < now) {
        date.setCustomValidity("invalid");
        eventDateFeedback.textContent = 'La data dell\'evento non può appartenere al passato'
        eventDateFeedback.style.display = 'block';
    } else {
        date.setCustomValidity("");
        eventDateFeedback.textContent = '';
        eventDateFeedback.style.display = 'none';
    }
});

fieldOfAction.addEventListener('change', (e) => {
    if(fieldOfAction.value === '') {
        fieldOfAction.setCustomValidity("invalid");
    } else {
        fieldOfAction.setCustomValidity("");
    }
});

form.addEventListener('submit', (e) => {

    if(!form.checkValidity()) {
        e.preventDefault();
        e.stopPropagation();
    }

    form.classList.add('was-validated');
});

function validateVolunteerNumbers() {
    const requested = parseInt(requestedInput.value) || 0;
    const max = parseInt(maxInput.value) || 0;

    if (max < requested) {
        maxInput.setCustomValidity("invalid");
        volunteerFeedback.textContent = "Il numero massimo di candidature non può essere inferiore al numero atteso di volontari";
        volunteerFeedback.style.display = 'block';
    } else {
        maxInput.setCustomValidity("");
        volunteerFeedback.style.display = 'none';
    }
}