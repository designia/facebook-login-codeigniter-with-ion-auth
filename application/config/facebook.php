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
	 *
	 * Facebook config file for Facebook library.
	 *
	 * @author Mladen Janjusevic mladenjanjusevic@designia.rs
	 * @website www.designia.rs
	 * @fb www.fb.me/designia.rs
	 * Source code: https://github.com/designia/facebook-login-codeigniter-with-ion-auth
	 *
	 * @package 1.0
	 */

	/**
	 * facebook settings
	 */
	$config[ 'app_id' ]                = ''; // app id
	$config[ 'app_secret' ]            = ''; // secret app id
	$config[ 'default_graph_version' ] = 'v2.5';
	$config[ 'redirect_uri' ]          = ''; // redirect route EXAMPLE facebook/do_login
	$config[ 'get_fields' ]            = 'id,name,first_name,middle_name,last_name,email,gender,link,birthday,location,hometown,picture'; // delete items that you will not use
	$config[ 'scope' ]                 = [ 'email', 'public_profile', 'user_location' ]; // leave scope like this
	$config[ 'generate_url' ]          = TRUE; // set this to TRUE to return generated url or FALSE for automatic redirect

	/**
	 * ion_auth settings
	 */
	$config[ 'default_facebook_password' ] = 'wZ0NT5-52Bk2ul-geznV-OjpATNR5'; // set default password for facebook users NOTICE: When you first set up the password do not change it
	$config[ 'remember_me' ]               = TRUE; // set to TRUE or FALSE to remeber user login or not