<?php
/**
 * When enabled, ADMIN users will be not be logged-in on the front-end
 *
 * @author Stephen Billard (sbillard)
 * @package plugins
*/
$plugin_is_filter = 9|CLASS_PLUGIN;
$plugin_description = sprintf(gettext("Treats ADMIN users as not logged in for gallery pages."),DATA_FOLDER);
$plugin_author = "Stephen Billard (sbillard)";


zp_register_filter('guest_login_attempt', 'show_not_loggedin::adminLoginAttempt',2);
zp_register_filter('authorization_cookie', 'show_not_loggedin::adminCookie',2);

class show_not_loggedin {

	static function adminCookie($success) {
		global $_zp_current_admin_obj;
		if (!OFFSET_PATH) {
			if (isset($_SESSION)) {
				unset($_SESSION['zp_user_auth']);
			}
			if (isset($_COOKIE)) {
				unset($_COOKIE['zp_user_auth']);
			}
			$_zp_current_admin_obj = NULL;
			return 0;
		}
		return $success;
	}

	static function adminLoginAttempt($success, $user, $pass, $athority) {
		if ($athority == 'zp_admin_auth' && $success) {
			header('Location: ' . FULLWEBPATH . '/' . ZENFOLDER . '/admin.php');
			exit();
		}
		return $success;
	}

}
?>