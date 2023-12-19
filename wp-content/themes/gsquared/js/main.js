const currentAmount = document.getElementById('hidden-current-amount') ? parseFloat(document.getElementById('hidden-current-amount').value) : 0; // This would be dynamic in production
const totalAmount = 4000000;

const animateCount = (elementId, endValue, duration) => {
    const element = document.getElementById(elementId);
    let startValue = 0;
    let currentCount = startValue;
    const frameRate = 60; // frames per second
    const totalFrames = (duration / 1000) * frameRate;
    const increment = endValue / totalFrames;

    const updateCounter = () => {
        currentCount += increment;
        element.textContent = '$' + formatNumber(Math.min(Math.floor(currentCount), endValue));

        if (currentCount < endValue) {
            requestAnimationFrame(updateCounter);
        } else {
            element.textContent = '$' + formatNumber(endValue); // ensure it ends on the exact end value
        }

        adjustProgressBar(calculateProgress(currentCount));
    };

    requestAnimationFrame(updateCounter);
}

const calculateProgress = (amount = 0) => {
    const accumulated = amount;
    const total = accumulated >= totalAmount ? totalAmount : accumulated;

    return ((total / totalAmount) * 100).toFixed(2);
}

const adjustProgressBar = (progressWidth) => {
    document.querySelector('.gs-progress-bar').style.width = progressWidth + '%';
}

document.addEventListener('DOMContentLoaded', (event) => {
    animateCount("current-amount", currentAmount, 5000);

    window.history.pushState({}, document.title, "/" );
});

document.getElementById("donation-form").addEventListener("submit", function (event) {
    event.preventDefault(); // Prevent the form from submitting

    const isValid = validateInputs();

    if (isValid) {
        // If no errors, submit the form
        this.submit();
    }
});

const validateInputs = () => {
    const inputs = [
        'donation_amount',
        'first_name',
        'last_name',
        'email',
        'phone',
        'payment_method',
    ];

    let errors = {};

    inputs.forEach((name) => {
        const input = document.querySelector(`input[name="${name}"]`);
        if (input.value.trim() === '') {
            errors[name] = "This field is required.";
        } else if (name === 'donation_amount' && parseFloat(input.value) <= 0) {
            errors[name] = "Donation amount should be more than $0.00";
        }
    });

    clearErrors();

    if (Object.keys(errors).length > 0) {
        renderErrors(errors);
        return false;
    }

    return true;
}

const renderErrors = (errors) => {
    Object.keys(errors).forEach(name => {
        const input = document.querySelector(`input[name="${name}"]`);
        let hasExisting = false;
        let errorElement = document.querySelector(`.error-message[data-error-name="${name}"]`);

        if (!errorElement) {
            errorElement = document.createElement('span');
        } else {
            hasExisting = true;
        }

        errorElement.classList.add('error-message', 'text-red-400', 'mt-2');
        errorElement.textContent = errors[name];

        if (!hasExisting) {
            input.parentNode.insertBefore(errorElement, input.nextSibling);
        }

        input.classList.add('!border-red-400');

        errorElement.classList.remove('hidden');
    });
}

const clearErrors = () => {
    document.querySelectorAll(".error-message").forEach(el => el.classList.add('hidden'));
}

document.getElementById('donation-amount').addEventListener('change', function () {
    var value = parseFloat(this.value.replace(/,/g, ''));

    if (!isNaN(value)) {
        this.value = formatNumber(value);
    }

    document.querySelector('.donation-amount-display').textContent = `$${this.value}`;
    document.querySelector(`[type="hidden"][name="donation_amount"]`).value = value;
});

document.getElementById('donation-amount').addEventListener('keydown', function (e) {
    // Allow numeric keys, backspace, tab, enter, escape, and decimal point
    if (e.key >= '0' && e.key <= '9' ||
        e.key === 'Backspace' ||
        e.key === 'Tab' ||
        e.key === 'Enter' ||
        e.key === 'Escape' ||
        e.key === '.' ||
        e.key === 'Delete' ||
        e.key === 'ArrowLeft' ||
        e.key === 'ArrowRight' ||
        // Allow Ctrl+A, Ctrl+C, Ctrl+V, Ctrl+X
        (['a', 'c', 'v', 'x'].indexOf(e.key) !== -1 && (e.ctrlKey === true || e.metaKey === true))) {
        // Let it happen, don't do anything
        return;
    }
    // Prevent default for other keys
    e.preventDefault();
});

const formatNumber = (num) => {
    return num.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
}
