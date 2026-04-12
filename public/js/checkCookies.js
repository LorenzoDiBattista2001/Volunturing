function checkCookies() {
    document.cookie = "testcookie=1";

    let cookieEnabled = (document.cookie.indexOf("testcookie") !== -1);
    document.cookie = "testcookie=1; expires=Thu, 01 Jan 1970 00:00:00 UTC";
    
    if (!cookieEnabled) {
        document.getElementById('cookie-alert').classList.remove('d-none');
    }
}

document.addEventListener('DOMContentLoaded', checkCookies);

