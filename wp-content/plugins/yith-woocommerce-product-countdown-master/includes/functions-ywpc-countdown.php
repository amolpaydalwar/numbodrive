<?php
/**
 * This file belongs to the YIT Plugin Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */

if ( !defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

if ( !function_exists( 'ywpc_days' ) ) {

    /**
     * How many days remains to $to
     *
     * @since   1.0.0
     *
     * @param   $to
     *
     * @return  integer
     * @author  Alberto Ruggiero
     */
    function ywpc_days( $to ) {

        return floor( ( $to - time() ) / 60 / 60 / 24 );

    }

}

if ( !function_exists( 'ywpc_hours' ) ) {

    /**
     * How many hours remains to $to
     *
     * @since   1.0.0
     *
     * @param   $to
     *
     * @return  integer
     * @author  Alberto Ruggiero
     */
    function ywpc_hours( $to ) {

        return floor( ( $to - time() ) / 60 / 60 );

    }

}

if ( !function_exists( 'ywpc_minutes' ) ) {

    /**
     * How many minutes remains to $to
     *
     * @since   1.0.0
     *
     * @param   $to
     *
     * @return  integer
     * @author  Alberto Ruggiero
     */
    function ywpc_minutes( $to ) {

        return floor( ( $to - time() ) / 60 );

    }

}

if ( !function_exists( 'ywpc_seconds' ) ) {

    /**
     * How many seconds remains to $to
     *
     * @since   1.0.0
     *
     * @param   $to
     *
     * @return  integer
     * @author  Alberto Ruggiero
     */
    function ywpc_seconds( $to ) {

        return $to - time();

    }

}

if ( !function_exists( 'ywpc_get_countdown' ) ) {

    /**
     * Return Countdown
     *
     * @since   1.0.0
     *
     * @param   $end_date
     *
     * @return  array
     * @author  Alberto Ruggiero
     */
    function ywpc_get_countdown( $end_date ) {

        $days    = ywpc_days( $end_date );
        $hours   = ywpc_hours( $end_date ) - ywpc_days( $end_date ) * 24;
        $minutes = ywpc_minutes( $end_date ) - ywpc_hours( $end_date ) * 60;
        $seconds = ywpc_seconds( $end_date ) - ywpc_minutes( $end_date ) * 60;

        return array(
            'gmt' => get_option( 'gmt_offset' ),
            'to'  => $end_date,
            'dd'  => ( $days > 10 ) ? $days : '0' . $days,
            'hh'  => ( $hours > 10 ) ? $hours : '0' . $hours,
            'mm'  => ( $minutes > 10 ) ? $minutes : '0' . $minutes,
            'ss'  => ( $seconds > 10 ) ? $seconds : '0' . $seconds,
        );

    }

}