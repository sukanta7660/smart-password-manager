export const isLoggedIn = () => {
    return window.ajax_object.is_logged_in;
};

const authenticated = (to, from, next) => {
    if (!isLoggedIn()) {
        next({ name: 'Login' });
    } else {
        next()
    }
}
export default authenticated;