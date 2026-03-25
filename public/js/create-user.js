document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('create-user-form');
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('password_confirmation');
    const submitBtn = document.getElementById('btn-submit-user');

    form.addEventListener('submit', (e) => {
        let valid = true;

        if (password.value !== confirmPassword.value) {
            e.preventDefault();
            valid = false;
            
            // Highlight error
            confirmPassword.style.borderColor = 'var(--danger)';
            confirmPassword.style.boxShadow = '0 0 0 4px rgba(234, 84, 85, 0.1)';
            
            // Create or update error message
            let errorMsg = document.getElementById('pw-error');
            if(!errorMsg) {
                errorMsg = document.createElement('span');
                errorMsg.id = 'pw-error';
                errorMsg.style.color = 'var(--danger)';
                errorMsg.style.fontSize = '0.8rem';
                errorMsg.style.marginTop = '0.5rem';
                errorMsg.style.display = 'block';
                errorMsg.textContent = 'Las contraseñas no coinciden.';
                confirmPassword.closest('.form-group').appendChild(errorMsg);
            }
        }

        if (password.value.length < 8) {
            e.preventDefault();
            valid = false;
            password.style.borderColor = 'var(--warning)';
        }

        if(valid) {
            // Visual feedback on submission
            submitBtn.innerHTML = '<i data-lucide="loader" class="spin"></i><span>Creando...</span>';
            submitBtn.style.opacity = '0.8';
            submitBtn.style.pointerEvents = 'none';
            if (window.lucide) {
                lucide.createIcons();
            }
            
            // Added spin animation dynamically
            const style = document.createElement('style');
            style.textContent = `
                @keyframes spin { 100% { transform: rotate(360deg); } }
                .spin { animation: spin 1s linear infinite; }
            `;
            document.head.appendChild(style);
        }
    });

    // Reset styles on input
    confirmPassword.addEventListener('input', () => {
        confirmPassword.style.borderColor = '';
        confirmPassword.style.boxShadow = '';
        const errorMsg = document.getElementById('pw-error');
        if(errorMsg) errorMsg.remove();
    });
    
    password.addEventListener('input', () => {
        password.style.borderColor = '';
    });
});
