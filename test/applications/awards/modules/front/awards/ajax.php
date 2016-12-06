<?php
/**
 * @package        iAwards
 * @author        <a href='http://www.invisionizer.com'>Invisionizer</a>
 * @copyright    (c) 2015 Invisionizer
 */

namespace IPS\awards\modules\front\awards;

/* To prevent PHP errors (extending class does not exist) revealing path */
if ( !defined( '\IPS\SUITE_UNIQUE_KEY' ) )
{
    header( ( isset( $_SERVER['SERVER_PROTOCOL'] ) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0' ) . ' 403 Forbidden' );
    exit;
}

/**
 * AJAX actions
 */
class _ajax extends \IPS\Dispatcher\Controller
{

    /**
     * Top Contributors
     * @retun    void
     */
    public function topAwarded()
    {
        /* How many? */
        $limit = intval( ( isset( \IPS\Request::i()->limit ) and \IPS\Request::i()->limit <= 25 ) ? \IPS\Request::i()->limit : 5 );

        /* What timeframe? */
        $timeframe = 'all';
        if ( isset( \IPS\Request::i()->time ) and \IPS\Request::i()->time != 'all' )
        {
            switch ( \IPS\Request::i()->time )
            {
                case 'week':
                    $where[]   = array( 'awarded_date>?', \IPS\DateTime::create()->sub( new \DateInterval( 'P1W' ) )->getTimestamp() );
                    $timeframe = 'week';
                    break;
                case 'month':
                    $where[]   = array( 'awarded_date>?', \IPS\DateTime::create()->sub( new \DateInterval( 'P1M' ) )->getTimestamp() );
                    $timeframe = 'month';
                    break;
                case 'year':
                    $where[]   = array( 'awarded_date>?', \IPS\DateTime::create()->sub( new \DateInterval( 'P1Y' ) )->getTimestamp() );
                    $timeframe = 'year';
                    break;
            }

            $topAwarded = iterator_to_array( \IPS\Db::i()->select( 'awards_awarded.awarded_member as member, COUNT(awarded_id) as awarded', 'awards_awarded', $where, 'awarded DESC', $limit, 'member' )->setKeyField( 'member' )->setValueField( 'awarded' ) );

            arsort( $topAwarded );
            $topAwarded = array_slice( $topAwarded, 0, $limit, TRUE );

        } else
        {
            $topAwarded = iterator_to_array( \IPS\Db::i()->select( 'awards_awarded.awarded_member as member, COUNT(awarded_id) as awarded', 'awards_awarded', array(), 'awarded DESC', $limit, 'member' )->setKeyField( 'member' )->setValueField( 'awarded' ) );

            arsort( $topAwarded );
            $topAwarded = array_slice( $topAwarded, 0, $limit, TRUE );
        }

        /* Load their data */
        foreach ( \IPS\Db::i()->select( '*', 'core_members', \IPS\Db::i()->in( 'member_id', array_keys( $topAwarded ) ) ) as $member )
        {
            \IPS\Member::constructFromData( $member );
        }

        /* Render */
        $output = \IPS\Theme::i()->getTemplate( 'widgets', 'awards' )->topAwardedRows( $topAwarded, $timeframe, \IPS\Request::i()->orientation );
        if ( \IPS\Request::i()->isAjax() )
        {
            \IPS\Output::i()->sendOutput( $output );
        } else
        {
            \IPS\Output::i()->output = $output;
        }
    }


}