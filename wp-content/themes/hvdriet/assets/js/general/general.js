const navigation = document.querySelector('.navigation-wrapper');

document.querySelectorAll('[data-click="toggle-navigation"]').forEach((item) => {
    item.addEventListener('click', () => {
        navigation.classList.toggle('is-active');
    })
})

