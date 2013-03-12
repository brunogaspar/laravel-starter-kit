<?php

class SocialController extends BaseController {

	/**
	 *
	 *
	 * @return void
	 */
	public function auth($network)
	{
		$config = Config::get('opauth');

		$Opauth = new Opauth($config, TRUE);
	}

	/**
	 *
	 *
	 * @return void
	 */
	public function callback()
	{
		$config = Config::get('opauth');

		$Opauth = new Opauth($config, FALSE);

		if ( ! session_id())
		{
			session_start();
		}

		$response = (isset($_SESSION['opauth']) ? $_SESSION['opauth'] : array());

		$err_msg = null;

		unset($_SESSION['opauth']);

		if (array_key_exists('error', $response))
		{
			$err_msg = 'Authentication error:Opauth returns error auth response.';
		}
		else
		{
			if (empty($response['auth']) || empty($response['timestamp']) || empty($response['signature']) || empty($response['auth']['provider']) || empty($response['auth']['uid']))
			{
				$err_msg = 'Invalid auth response: Missing key auth response components.';
			}
			elseif (!$Opauth->validate(sha1(print_r($response['auth'], true)), $response['timestamp'], $response['signature'], $reason))
			{
				$err_msg = 'Invalid auth response: ' . $reason;
			}
		}

		if ($err_msg)
		{
			return Redirect::to('account/login')->with('error', $err_msg);
		}
		else
		{
			$email = $response['auth']['info']['email'];

			$authentication = new Authentication;
			$authentication->provider = $response['auth']['provider'];
			$authentication->provider_uid = $response['auth']['uid'];

			$authentication_exist = Authentication::where('provider', $authentication->provider)->where('provider_uid', '=', $authentication->provider_uid)->first();

			if (!$authentication_exist)
			{
				if (Sentry::check())
				{
					$user= Sentry::getUser();
					$authentication->user_id = $user->id;
				}
				else
				{
					try
					{
						$user = Sentry::getUserProvider()->findByLogin($email);
					}
					catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
					{
						$user = Sentry::register(array(
							'first_name' => $response['auth']['info']['first_name'],
							'last_name'  => $response['auth']['info']['last_name'],
							'email'      => $email,
							'password'   => Str::random(14)// Using random password here.
						), TRUE);
					}

					$authentication->user_id = $user->id;
				}
				$authentication->save();
			}
			else
			{
				$user = Sentry::getUserProvider()->findById($authentication_exist->user_id);

				Sentry::login($user);

				Session::put('user_image', $response['auth']['info']['image']);

				return Redirect::to('/');
			}
		}
	}

}
