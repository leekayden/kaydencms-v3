<?php
/**
 * Error Protection API: WP_Recovery_Mode_Key_Service class
 *
 * @package kaydenCMS
 * @since 5.2.0
 */

/**
 * Core class used to generate and validate keys used to enter Recovery Mode.
 *
 * @since 5.2.0
 */
final class WP_Recovery_Mode_Key_Service {

	/**
	 * The option name used to store the keys.
	 *
	 * @since 5.2.0
	 * @var string
	 */
	private $option_name = 'recovery_keys';

	/**
	 * Creates a recovery mode token.
	 *
	 * @since 5.2.0
	 *
	 * @return string A random string to identify its associated key in storage.
	 */
	public function generate_recovery_mode_token() {
		return wp_generate_password( 22, false );
	}

	/**
	 * Creates a recovery mode key.
	 *
	 * @since 5.2.0
	 *
	 * @global PasswordHash $wp_hasher
	 *
	 * @param string $token A token generated by {@see generate_recovery_mode_token()}.
	 * @return string Recovery mode key.
	 */
	public function generate_and_store_recovery_mode_key( $token ) {

		global $wp_hasher;

		$key = wp_generate_password( 22, false );

		if ( empty( $wp_hasher ) ) {
			require_once ABSPATH . WPINC . '/class-phpass.php';
			$wp_hasher = new PasswordHash( 8, true );
		}

		$hashed = $wp_hasher->HashPassword( $key );

		$records = $this->get_keys();

		$records[ $token ] = array(
			'hashed_key' => $hashed,
			'created_at' => time(),
		);

		$this->update_keys( $records );

		/**
		 * Fires when a recovery mode key is generated.
		 *
		 * @since 5.2.0
		 *
		 * @param string $token The recovery data token.
		 * @param string $key   The recovery mode key.
		 */
		do_action( 'generate_recovery_mode_key', $token, $key );

		return $key;
	}

	/**
	 * Verifies if the recovery mode key is correct.
	 *
	 * Recovery mode keys can only be used once; the key will be consumed in the process.
	 *
	 * @since 5.2.0
	 *
	 * @param string $token The token used when generating the given key.
	 * @param string $key   The unhashed key.
	 * @param int    $ttl   Time in seconds for the key to be valid for.
	 * @return true|WP_Error True on success, error object on failure.
	 */
	public function validate_recovery_mode_key( $token, $key, $ttl ) {

		$records = $this->get_keys();

		if ( ! isset( $records[ $token ] ) ) {
			return new WP_Error( 'token_not_found', __( 'Recovery Mode not initialized.' ) );
		}

		$record = $records[ $token ];

		$this->remove_key( $token );

		if ( ! is_array( $record ) || ! isset( $record['hashed_key'], $record['created_at'] ) ) {
			return new WP_Error( 'invalid_recovery_key_format', __( 'Invalid recovery key format.' ) );
		}

		if ( ! wp_check_password( $key, $record['hashed_key'] ) ) {
			return new WP_Error( 'hash_mismatch', __( 'Invalid recovery key.' ) );
		}

		if ( time() > $record['created_at'] + $ttl ) {
			return new WP_Error( 'key_expired', __( 'Recovery key expired.' ) );
		}

		return true;
	}

	/**
	 * Removes expired recovery mode keys.
	 *
	 * @since 5.2.0
	 *
	 * @param int $ttl Time in seconds for the keys to be valid for.
	 */
	public function clean_expired_keys( $ttl ) {

		$records = $this->get_keys();

		foreach ( $records as $key => $record ) {
			if ( ! isset( $record['created_at'] ) || time() > $record['created_at'] + $ttl ) {
				unset( $records[ $key ] );
			}
		}

		$this->update_keys( $records );
	}

	/**
	 * Removes a used recovery key.
	 *
	 * @since 5.2.0
	 *
	 * @param string $token The token used when generating a recovery mode key.
	 */
	private function remove_key( $token ) {

		$records = $this->get_keys();

		if ( ! isset( $records[ $token ] ) ) {
			return;
		}

		unset( $records[ $token ] );

		$this->update_keys( $records );
	}

	/**
	 * Gets the recovery key records.
	 *
	 * @since 5.2.0
	 *
	 * @return array Associative array of $token => $data pairs, where $data has keys 'hashed_key'
	 *               and 'created_at'.
	 */
	private function get_keys() {
		return (array) get_option( $this->option_name, array() );
	}

	/**
	 * Updates the recovery key records.
	 *
	 * @since 5.2.0
	 *
	 * @param array $keys Associative array of $token => $data pairs, where $data has keys 'hashed_key'
	 *                    and 'created_at'.
	 * @return bool True on success, false on failure.
	 */
	private function update_keys( array $keys ) {
		return update_option( $this->option_name, $keys );
	}
}
