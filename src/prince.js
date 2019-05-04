function importAll (r) {
    r.keys().forEach(r);
}

importAll(require.context('./images/layout/', true, /\.png$/));
import prince_logo from './images/Prince-Crown-Logo-White-50x44.png';
import  './js/jquery-ui-timepicker';
import  './js/prince-admin';
import  './js/extra';
import  './css/prince-admin.scss';
