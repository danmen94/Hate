//<?php

/**
 * @package      iAwards
 * @author       <a href='http://www.invisionizer.com'>Invisionizer</a>
 * @copyright    (c) 2015 Invisionizer
 */
class awards_hook_awardsGet extends _HOOK_CLASS_
{
    /**
     * @var string
     */
    protected static $containerNodeClass = 'IPS\awards\Awards';

    /**
     * @return bool
     */
    public function awardsPane()
    {
	try
	{
	        try
	        {
	            $member = \IPS\Member::load( $this->member_id );
	
	            if ( $member->member_id != NULL )
	            {
	                if ( \IPS\Settings::i()->award_settings_pane_cat_show_show == 'all' )
	                {
	                    if ( $member->award_member_show != NULL )
	                    {
	                        $where[] = array( 'awarded_member = ? AND awarded_award NOT IN (?)', $member->member_id, $member->award_member_show );
	                    } else
	                    {
	                        $where[] = array( 'awarded_member = ?', $member->member_id );
	                    }
	                } else
	                {
	                    $cats = explode( ",", \IPS\Settings::i()->award_settings_pane_cat );
	
	                    if ( $member->award_member_show != NULL )
	                    {
	                        $where = array( array( 'awarded_member = ? AND awarded_award NOT IN (?)', $member->member_id, $member->award_member_show ), \IPS\Db::i()->in( 'awarded_cat', $cats ) );
	                    } else
	                    {
	                        $where = array( array( 'awarded_member = ?', $member->member_id ), \IPS\Db::i()->in( 'awarded_cat', $cats ) );
	                    }
	                }
	
	                $rows = array();
	
	                foreach ( \IPS\awards\Awarded::getItemsWithPermission( $where, "awarded_{$member->award_sort} {$member->award_order}", \IPS\Settings::i()->award_settings_pane_total, 'view', NULL, 0, $member, TRUE, FALSE, FALSE, FALSE, NULL, FALSE, TRUE, TRUE, TRUE ) as $awarded )
	                {
	                    if ( \IPS\Member::loggedIn()->canAccessModule( \IPS\Application\Module::get( 'awards', 'awards' ) ) )
	                    {
	                        $rows[] = $awarded;
	                    } else
	                    {
	                        return FALSE;
	                    }
	                }
	
	                return \IPS\Theme::i()->getTemplate( 'global', 'awards', 'front' )->pane_rows( $rows );
	
	            }
	        } catch ( \RuntimeException $e )
	        {
	            if ( method_exists( get_parent_class(), __FUNCTION__ ) )
	            {
	                return call_user_func_array( 'parent::' . __FUNCTION__, func_get_args() );
	            } else
	            {
	                throw $e;
	            }
	        }
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

    /**
     * @return bool
     */
    public function awardsPosts()
    {
	try
	{
	        try
	        {
	            $member = \IPS\Member::load( $this->member_id );
	
	            if ( $member->member_id != NULL )
	            {
	                if ( \IPS\Settings::i()->award_settings_posts_cat_show_show == 'all' )
	                {
	                    if ( $member->award_member_show != NULL )
	                    {
	                        $where[] = array( 'awarded_member = ? AND awarded_award NOT IN (?)', $member->member_id, $member->award_member_show );
	                    } else
	                    {
	                        $where[] = array( 'awarded_member = ?', $member->member_id );
	                    }
	                } else
	                {
	                    $cats = explode( ",", \IPS\Settings::i()->award_settings_posts_cat );
	
	                    if ( $member->award_member_show != NULL )
	                    {
	                        $where = array( array( 'awarded_member = ? AND awarded_award NOT IN (?)', $member->member_id, $member->award_member_show ), \IPS\Db::i()->in( 'awarded_cat', $cats ) );
	                    } else
	                    {
	                        $where = array( array( 'awarded_member = ?', $member->member_id ), \IPS\Db::i()->in( 'awarded_cat', $cats ) );
	                    }
	
	                }
	
	                $rows = array();
	
	                foreach ( \IPS\awards\Awarded::getItemsWithPermission( $where, "awarded_{$member->award_sort} {$member->award_order}", \IPS\Settings::i()->award_settings_posts_total, 'view', NULL, 0, $member, TRUE, FALSE, FALSE, FALSE, NULL, FALSE, TRUE, TRUE, TRUE ) as $awarded )
	                {
	                    if ( \IPS\Member::loggedIn()->canAccessModule( \IPS\Application\Module::get( 'awards', 'awards' ) ) )
	                    {
	                        $rows[] = $awarded;
	                    } else
	                    {
	                        return FALSE;
	                    }
	                }
	
	                return \IPS\Theme::i()->getTemplate( 'global', 'awards', 'front' )->posts_rows( $rows );
	            }
	        } catch ( \RuntimeException $e )
	        {
	            if ( method_exists( get_parent_class(), __FUNCTION__ ) )
	            {
	                return call_user_func_array( 'parent::' . __FUNCTION__, func_get_args() );
	            } else
	            {
	                throw $e;
	            }
	        }
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


    /**
     * @return bool
     */
    public function awardsHover()
    {
	try
	{
	        try
	        {
	            $member = \IPS\Member::load( $this->member_id );
	
	            if ( $member->member_id != NULL )
	            {
	                if ( \IPS\Settings::i()->award_settings_hover_cat_show_show == 'all' )
	                {
	                    if ( $member->award_member_show != NULL )
	                    {
	                        $where[] = array( 'awarded_member = ? AND awarded_award NOT IN (?)', $member->member_id, $member->award_member_show );
	                    } else
	                    {
	                        $where[] = array( 'awarded_member = ?', $member->member_id );
	                    }
	
	                } else
	                {
	                    $cats = explode( ",", \IPS\Settings::i()->award_settings_hover_cat );
	
	                    if ( $member->award_member_show != NULL )
	                    {
	                        $where = array( array( 'awarded_member = ? AND awarded_award NOT IN (?)', $member->member_id, $member->award_member_show ), \IPS\Db::i()->in( 'awarded_cat', $cats ) );
	                    } else
	                    {
	                        $where = array( array( 'awarded_member = ?', $member->member_id ), \IPS\Db::i()->in( 'awarded_cat', $cats ) );
	                    }
	
	                }
	
	                $rows = array();
	
	                foreach ( \IPS\awards\Awarded::getItemsWithPermission( $where, "awarded_{$member->award_sort} {$member->award_order}", \IPS\Settings::i()->award_settings_hover_total, 'view', NULL, 0, $member, TRUE, FALSE, FALSE, FALSE, NULL, FALSE, TRUE, TRUE, TRUE ) as $awarded )
	                {
	                    if ( \IPS\Member::loggedIn()->canAccessModule( \IPS\Application\Module::get( 'awards', 'awards' ) ) )
	                    {
	                        $rows[] = $awarded;
	                    } else
	                    {
	                        return FALSE;
	                    }
	                }
	
	                return \IPS\Theme::i()->getTemplate( 'global', 'awards', 'front' )->hover_rows( $rows );
	
	            }
	        } catch ( \RuntimeException $e )
	        {
	            if ( method_exists( get_parent_class(), __FUNCTION__ ) )
	            {
	                return call_user_func_array( 'parent::' . __FUNCTION__, func_get_args() );
	            } else
	            {
	                throw $e;
	            }
	        }
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