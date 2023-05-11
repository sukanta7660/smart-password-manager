const authenticated = (to, from, next) => {
    let loginStatus = localStorage.getItem('isLoggedIn') || false;
    if (!loginStatus) {
        next({ name: 'Login' });

    } else {
        next()
    }
}
export default authenticated;