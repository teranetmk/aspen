<?php

namespace Aspen;

use Aspen\Models\Contacts;
use WP_Error;
use WP_User;

class Login
{
	public function __construct()
	{
		add_filter( 'authenticate', [$this, 'login'], 40, 3 ) ;
		add_filter( 'login_redirect', [$this, 'login_redirect'], 40, 3 ) ;
		add_action( 'wp', [$this, 'must_be_logged_in'], 20, 0 ) ;
		add_action( 'wp_logout', [$this, 'login_page_on_logout'], 99, 0 ) ;
	}

	public function login( $user, $email, $pass )
	{
		if ($user instanceof WP_User) {
			return $user;
		}

		if ( empty( $email ) ) {
			return new WP_Error( 'empty_username', __( '<strong>Error</strong>: The username field is empty.' ) );
		}
		if ( empty( $pass ) ) {
			return new WP_Error( 'empty_password', __( '<strong>Error</strong>: The password field is empty.' ) );
		}

		$response = $this->authenticate_to_aspen($email, $pass);

		if (!$response->userId || !$response->succeeded) {
			return new WP_Error( 'authentication_failed', __( '<strong>Error</strong>: Invalid username, email address or incorrect password.' ) );
		}

		if (!$response->allowLogin) {
			# redirect? https://community.aspenrxhealth.com/
			return new WP_Error( 'authentication_failed', __( '<strong>Error</strong>: Login not allowed.' ) );
		}

		$user = get_user_by('email', $email);

		if (!$user) {

			$contact = Contacts::where('pharmacist_id', $response->userId)->first();

			$user_id = wp_insert_user([
				'user_login'    => $email,
				'user_email'    => $email,
				'user_pass'     => $pass,
				'nickname'      => $contact->first_name ?: $email,
				'first_name'    => $contact->first_name ?: $email,
				'last_name'     => $contact->last_name ?: $email,
				'display_name'  => $contact->first_name ?: $email,
				'user_nicename' => $contact->first_name ?: $email,
			]);


			if (!$user_id) {
				return new WP_Error( 'authentication_failed', __( '<strong>Error</strong>: Error creating user.' ) );
			}

			update_user_meta($user_id, 'pharmacist_id', $response->userId);

			$user = get_user_by('id', $user_id);
		}

		return $user;
	}

	private function authenticate_to_aspen($email, $pass)
	{
		if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;
		if (!isset($_POST['log']) && !isset($_POST['pwd'])) return;

		$url = 'https://portalapi.aspenrxhealth.com';
		// $url = 'https://portalapi-test.aspenrxhealth.com';
		$response = wp_remote_post("{$url}/grove/login", [
			'headers' => [
				'content-type' => 'application/json',
			],
			'body' => json_encode([
				'email' => $email,
				'password' => $pass,
			]),
		]);

		return json_decode($response['body']);
	}

	public function login_redirect( $redirect, $request, $user )
	{
		if (!is_wp_error($user)) {
			if ($user && array_intersect($user->roles, ['administrator'])) {
				return admin_url();
			}

			if ($user && array_intersect($user->roles, ['view-only-role'])) {
				return admin_url('users.php');
			}
		}

		return home_url();
	}

	public function must_be_logged_in()
	{
		if (is_admin()) return;

		if (!is_page('login') && !is_user_logged_in()) {
			wp_redirect(home_url('login'));
			exit;
		}
	}

	public function login_page_on_logout()
	{
		wp_redirect(home_url('login'));
		exit;
	}
}
