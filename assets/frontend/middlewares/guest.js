import {isLoggedIn} from './auth';

const guest = (to, from, next) => {
    let loginStatus = localStorage.getItem('isLoggedIn') || false;
    if (isLoggedIn()) {
        next({ name: 'Dashboard' });
    } else {
        next();
    }
}
export default guest;