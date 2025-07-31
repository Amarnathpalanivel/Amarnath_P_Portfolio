document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("contact-form");
    const successMessage = document.querySelector(".success-message");

    form.addEventListener("submit", function (e) {
        e.preventDefault();

        const formData = new FormData(form);

        fetch(form.action, {
            method: "POST",
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.nameMessage || data.emailMessage || data.messageMessage) {
                alert("⚠ Please fill out all required fields correctly.");
            } else if (data.succesMessage) {
                successMessage.style.display = "block";
                successMessage.textContent = "✔ Thank you! Your message has been sent successfully.";
                form.reset(); // Clear the form
            } else {
                successMessage.style.display = "block";
                successMessage.textContent = "❌ Something went wrong. Please try again.";
            }
        })
        .catch(() => {
            successMessage.style.display = "block";
            successMessage.textContent = "❌ Error submitting form. Please try again later.";
        });
    });
});
