<?php if ( !defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

	/**
	 * The MIT License (MIT)
	 *
	 * Copyright (c) 2016 Mladen Janjusevic
	 *
	 * Permission is hereby granted, free of charge, to any person obtaining a copy
	 * of this software and associated documentation files (the "Software"), to deal
	 * in the Software without restriction, including without limitation the rights
	 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
	 * copies of the Software, and to permit persons to whom the Software is
	 * furnished to do so, subject to the following conditions:
	 *
	 * The above copyright notice and this permission notice shall be included in all
	 * copies or substantial portions of the Software.
	 *
	 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
	 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
	 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
	 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
	 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
	 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
	 * SOFTWARE.
	 */
	class Facebook
	{

		/**
		 * Facebook library.
		 *
		 * @author Mladen Janjusevic mladenjanjusevic@designia.rs
		 * @www www.designia.rs
		 * @fb www.fb.me/designia.rs
		 * Source code: https://github.com/designia/facebook-login-codeigniter-with-ion-auth
		 *
		 * @package 1.0
		 */

		public function __construct ()
		{
			$this->ci =& get_instance();

			$this->ci->load->config( 'facebook', TRUE );

			$this->app_id           = $this->ci->config->item( 'app_id', 'facebook' );
			$this->app_secret       = $this->ci->config->item( 'app_secret', 'facebook' );
			$this->graph_version    = $this->ci->config->item( 'default_graph_version', 'facebook' );
			$this->scope            = $this->ci->config->item( 'scope', 'facebook' );
			$this->redirect_uri     = $this->ci->config->item( 'redirect_uri', 'facebook' );
			$this->get_fields       = $this->ci->config->item( 'get_fields', 'facebook' );
			$this->default_password = $this->ci->config->item( 'default_facebook_password', 'facebook' );
			$this->remember_me      = $this->ci->config->item( 'remember_me', 'facebook' );
			$this->generate_url     = $this->ci->config->item( 'generate_url', 'facebook' );

			$this->fb = new Facebook\Facebook( [
				'app_id'                => $this->app_id,
				'app_secret'            => $this->app_secret,
				'default_graph_version' => $this->graph_version,
			] );

			if ( !$this->redirect_uri )
				$this->login_url = base_url();
			else
				$this->login_url = base_url( $this->redirect_uri );
		}

		/**
		 * [facebook] function generate redirect url or
		 * redirect user to facebook.
		 * Can be used in two ways.
		 */
		public function facebook ()
		{
			$redirect_login = $this->fb->getRedirectLoginHelper();
			$permissions    = $this->scope;
			$login_url      = $redirect_login->getLoginUrl( $this->login_url, $permissions );

			if ( $this->generate_url )
				return $login_url;
			else
				redirect( $login_url );
		}

		/**
		 * [facebook_login] function authenticate users and
		 * get user graph data and use graph data to login
		 * or register user with ion_auth.
		 *
		 * TODO v1.1 get user profile image
		 *
		 * @throws \Facebook\Exceptions\FacebookSDKException
		 *
		 * @return boolean
		 */
		public function facebook_login ()
		{
			$redirect_login = $this->fb->getRedirectLoginHelper();

			try {
				$access_token = $redirect_login->getAccessToken();
				$response     = $this->fb->get( '/me?fields=' . $this->get_fields, $access_token );
				$user_scope   = $response->getGraphUser();
			} catch ( Facebook\Exceptions\FacebookResponseException $e ) {
				echo 'Graph returned an error: ' . $e->getMessage();
				exit;
			} catch ( Facebook\Exceptions\FacebookSDKException $e ) {
				echo 'Facebook SDK returned an error: ' . $e->getMessage();
				exit;
			}

			if ( !isset( $access_token ) ) {
				if ( $redirect_login->getError() ) {
					header( 'HTTP/1.0 401 Unauthorized' );
					echo "Error: " . $redirect_login->getError() . "\n";
					echo "Error Code: " . $redirect_login->getErrorCode() . "\n";
					echo "Error Reason: " . $redirect_login->getErrorReason() . "\n";
					echo "Error Description: " . $redirect_login->getErrorDescription() . "\n";
				} else {
					header( 'HTTP/1.0 400 Bad Request' );
					echo 'Bad request';
				}
				exit;
			}

			/**
			 * From this point user is ready for login/register.
			 */

			$o_auth2client = $this->fb->getOAuth2Client();

			$token_metadata = $o_auth2client->debugToken( $access_token );
			$token_metadata->validateAppId( $this->app_id );
			$token_metadata->validateExpiration();

			if ( !$access_token->isLongLived() ) {
				try {
					$access_long_token = $o_auth2client->getLongLivedAccessToken( $access_token );
				} catch ( Facebook\Exceptions\FacebookSDKException $e ) {
					echo "<p>Error getting long-lived access token: " . $e->getMessage() . "</p>\n\n";
					exit;
				}
			}

			// get all user graph data
			$facebook_user_id = $user_scope->getId();
			$full_name        = $user_scope->getName();
			$first_name       = $user_scope->getFirstName();
			$middle_name      = $user_scope->getMiddleName();
			$last_name        = $user_scope->getLastName();
			$email            = $user_scope->getEmail();
			$gender           = $user_scope->getGender();
			$profile_link     = $user_scope->getLink();
			$birthday         = $user_scope->getBirthday();
			$location         = $user_scope->getLocation();
			$hometown         = $user_scope->getHometown();

			// you can store some additional data in database for future use.
			$additional_data = [
				'facebook_uid'  => $facebook_user_id,
				'first_name'    => $first_name,
				'last_name'     => $last_name,
				'facebook_link' => $profile_link,
			];

			if ( !$this->ci->ion_auth_model->identity_check( $email ) ) {
				if ( $this->ci->ion_auth->register( $email, $this->default_password, $email, $additional_data ) )
					return $this->ci->ion_auth->login( $email, $this->default_password, $this->remember_me );
			} else {
				return $this->ci->ion_auth->login( $email, $this->default_password, $this->remember_me );
			}
		}
	}