//<?php
/**
 * @package      iAwards
 * @author       <a href='http://www.invisionizer.com'>Invisionizer</a>
 * @copyright    (c) 2015 Invisionizer
 */
 
class awards_hook_awardsAmount extends _HOOK_CLASS_
{
    /**
     * @return mixed
     */
    public function init()
    {
	try
	{
	        $return = call_user_func_array( 'parent::init', func_get_args() );
	
	        if ( \IPS\Settings::i()->award_settings_enable AND \IPS\Application::appIsEnabled( 'awards' ) ) {
	
	            $member = \IPS\Member::load( \IPS\Member::loggedIn()->member_id );
	
	            $giver = \IPS\Member::load( \IPS\Settings::i()->award_settings_bot );
	
	            foreach ( \IPS\Db::i()->select( '*', 'awards_awards', array( 'award_enabled = ? AND award_options = ?', 1, "awards_amount" ) ) as $row ) {
	
	                $rows[] = $row;
	            }
	
	            if ( count( $rows ) ) {
	                foreach ( $rows as $row ) {
	                    $award = \IPS\awards\Awards::load( $row['award_id'] );
	                    $total = $award->countAwards( $member );
	
	                    if ( $total === $row['award_when'] ) {
	                        try {
	                            $award->awardTo( $member, $award, $giver );
	                        } catch ( \Exception $e ) {
	                        }
	                    }
	                }
	            }
	
	        }
	
	        return $return;
	}
	catch ( \RuntimeException $e )
	{
		if ( method_exists( get_parent_class(), __FUNCTION__ ) )
		{
			return call_user_func_array( 'parent::' . __FUNCTION__, func_get_args() );
		}
		else
		{
			throw $e;
		}
	}
    }
}