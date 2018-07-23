window.document.addEventListener('readystatechange', () => {
    window.document.documentElement.classList.add(`is-${document.readyState}`);
});
