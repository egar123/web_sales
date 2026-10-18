// ===============================
// CARD HOVER EFFECT
// ===============================
const cards = document.querySelectorAll('.card');

cards.forEach(card => {
    card.addEventListener('mouseenter', () => {
        card.style.transform = 'translateY(-5px)';
        card.style.transition = '0.3s';
    });

    card.addEventListener('mouseleave', () => {
        card.style.transform = 'translateY(0px)';
    });
});


// ===============================
// TOGGLE PASSWORD
// ===============================
function togglePassword() {
    const input = document.getElementById("password");

    if (!input) return; // safety check biar nggak error

    if (input.type === "password") {
        input.type = "text";
    } else {
        input.type = "password";
    }
}