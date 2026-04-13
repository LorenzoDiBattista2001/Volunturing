
(function () {
  'use strict'
  const form = document.getElementById('reviewForm');
  const ratingInputs = document.querySelectorAll('input[name="rating"]');
  const ratingLabel = document.getElementById('ratingLabel');

        const labels = {
          '1': 'Molto scarso',
          '2': 'Scarso',
          '3': 'Sufficiente',
          '4': 'Buono',
          '5': 'Ottimo'
        };

  ratingInputs.forEach(input => {
    input.addEventListener('change', () => {
      ratingLabel.textContent = labels[input.value];
      ratingLabel.classList.add('fw-bold', 'text-brand');
    });
  });

    form.addEventListener('submit', function (event) {
      if (!form.checkValidity()) {
        event.preventDefault()
        event.stopPropagation()
      }
      form.classList.add('was-validated')
    }, false)
})()