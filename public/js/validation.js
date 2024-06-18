document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form');
    const nombreInput = document.getElementById('nombre');
    const pesoInput = document.getElementById('peso');
    const errorContainer = document.createElement('div');
    errorContainer.classList.add('text-red-500', 'font-semibold', 'mt-2');
    form.appendChild(errorContainer);

    form.addEventListener('submit', (e) => {
        errorContainer.innerHTML = ''; // Clear previous errors
        let valid = true;

        // Validate nombre (only text)
        if (!/^[a-zA-Z\s]+$/.test(nombreInput.value)) {
            valid = false;
            showError('El nombre del electrodoméstico debe contener solo letras.');
        }

        // Validate peso (only numbers)
        if (!/^\d+(\.\d+)?$/.test(pesoInput.value)) {
            valid = false;
            showError('El peso debe ser un número válido.');
        }

        if (!valid) {
            e.preventDefault();
        }
    });

    function showError(message) {
        const error = document.createElement('p');
        error.textContent = message;
        errorContainer.appendChild(error);
    }
});

function mostrarTablas(event) {
            event.preventDefault(); // Evitar que el formulario se envíe
            document.getElementById('tablas').style.display = 'flex';
        }
