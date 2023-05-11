const guest = (to, from, next) => {
    let loginStatus = localStorage.getItem('isLoggedIn') || false;
    if (loginStatus) {
        next({ name: 'Home' });

    } else {
        next()
    }
}
export default guest;