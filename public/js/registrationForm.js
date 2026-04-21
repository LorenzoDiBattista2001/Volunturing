(() => {
  'use strict'

    const form = document.getElementById('registrationForm');

    const validators = {
        'telephoneNumber': val => /^[0-9]{10}$/.test(val),
        'taxCode': val => /^[A-Z]{6}([0-2][0-9]|[0-9]{2})[ABCDEHLMPRST]([04][1-9]|[1256][0-9]|[37][01])[A-Z][0-9]{3}[A-Z]$/.test(val),
        'streetAddress': val => val.length >= 6 && !/^[0-9]*$/.test(val),
        'houseNumber': val => /^[0-9]{1,4}(\/?[a-zA-Z])?$/.test(val),
        'password': val => val.length >= 8,
        'confirm': val => val === document.getElementById('password').value,
        'birthPlace': val => val.length >= 2 && !/[0-9]/.test(val),
        'birthDate': val => {
            const date = new Date(val);
            const now = new Date();
            return !isNaN(date.getTime()) && date < now;
        }
    };

    const feedbackMessages = {
        'telephoneNumber': 'Inserisci un numero di telefono valido',
        'taxCode': 'Inserisci un codice fiscale valido',
        'streetAddress': 'Inserisci un indirizzo valido',
        'houseNumber': 'Inserisci un numero civico valido',
        'password': 'La password deve avere una lunghezza di almeno 8 caratteri',
        'confirm': 'Le password non coincidono',
        'birthDate': 'La data inserita appartiene al futuro',
        'birthPlace': 'Inserisci un nome di luogo valido',
        'email': 'Inserisci un indirizzo email valido'
    };

    const validateInput = (input) => {
        const feedback = document.getElementById(`${input.id}Feedback`);
        if (!feedback) return;

        input.setCustomValidity('');

        if (input.validity.valueMissing) {
            feedback.textContent = 'Campo obbligatorio.';
            return;
        }

        if (input.type === 'email' && input.validity.typeMismatch) {
            feedback.textContent = feedbackMessages['email'];
            return;
        }

        if (validators[input.id]) {
            const isValid = validators[input.id](input.value);
            if (!isValid) {
                input.setCustomValidity('Invalid');
                feedback.textContent = feedbackMessages[input.id];
            }
        }
    };

    form.querySelectorAll('input').forEach(input => {
        input.addEventListener('change', () => {
            validateInput(input);

            if (input.id === 'password') {
                validateInput(document.getElementById('confirm'));
            }
        });
    });

    form.addEventListener('submit', event => {

        form.querySelectorAll('input').forEach(input => {
            validateInput(input);
        });

        if (!form.checkValidity()) {
            event.preventDefault()
            event.stopPropagation()
        }
        form.classList.add('was-validated');
    }, false);
})();