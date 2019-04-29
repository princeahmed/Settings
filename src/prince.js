function importAll (r) {
    r.keys().forEach(r);
}

importAll(require.context('./images/layout/', true, /\.png$/));
import prince_logo from './images/Prince-Crown-Logo-White-50x44.png';
import * as datetime_picker from './js/vendor/jquery-ui-timepicker';
import * as admin_js from './js/prince-admin';
import * as css from './css/prince-admin.scss';
