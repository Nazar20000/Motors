export default function ExampleComponent() {
    const el = document.createElement('div');
    el.textContent = 'Example frontend component: Motors is working!';
    el.style.padding = '1rem';
    el.style.background = '#f3f4f6';
    el.style.borderRadius = '8px';
    return el;
}

// For auto-connection to the main page (if needed)
document.addEventListener('DOMContentLoaded', () => {
    if (document.body) {
        document.body.appendChild(ExampleComponent());
    }
}); 