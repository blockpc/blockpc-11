import './bootstrap';

document.addEventListener('livewire:navigated', () => {
    var themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
    var themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');
    var themeToggleBtn = document.getElementById('theme-toggle');

    themeToggleBtn?.addEventListener('click', function() {
        // toggle icons inside button
        themeToggleDarkIcon.classList.toggle('hidden');
        themeToggleLightIcon.classList.toggle('hidden');

        // get current theme from local storage
        var currentTheme = localStorage.getItem('color-theme') || (document.documentElement.classList.contains('dark') ? 'dark' : 'light');

        // toggle theme
        var newTheme = currentTheme === 'light' ? 'dark' : 'light';
        document.documentElement.classList.toggle('dark', newTheme === 'dark');
        localStorage.setItem('color-theme', newTheme);
    });

    // Change the icons inside the button based on previous settings
    if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        themeToggleLightIcon?.classList.remove('hidden');
        document.documentElement.classList.add('dark');
    } else {
        themeToggleDarkIcon?.classList.remove('hidden');
        document.documentElement.classList.remove('dark');
    }
});

window.closeAlert = (id) => {
    let element = document.getElementById(id);
    element.remove();
}
