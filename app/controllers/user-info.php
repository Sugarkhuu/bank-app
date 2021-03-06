<?php

/*
 * Bank
 * Copyright (C) 2015 Gunnar Beutner
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software Foundation
 * Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301, USA.
 */

require_once('helpers/session.php');
require_once('helpers/transaction.php');

class UserinfoController {
	public function get() {
		if (!get_user_attr(get_user_email(), 'admin')) {
			$params = [ 'message' => 'Zugriff verweigert.' ];
			return [ 'error', $params ];
		}

		$email = $_GET['email'];
		$params = [
			'balance' => get_user_attr($email, 'balance'),
            'last_positive' => get_user_last_balance_above($email),
            'last_above_threshold' => get_user_last_balance_above($email, -10),
            'last_credit_limit_adjustment' => get_user_attr($email, 'last_credit_limit_adjustment'),
			'tgt_reference' => get_user_transfer_code($email),
			'tgt_owner' => BANK_EXT_OWNER,
			'tgt_iban' => BANK_EXT_IBAN,
			'tgt_org' => BANK_EXT_ORG
		];
		return [ 'user-info', $params ];
	}
}
