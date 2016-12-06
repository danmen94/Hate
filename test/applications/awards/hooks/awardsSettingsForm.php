//<?php
/**
 * @package      iAwards
 * @author       <a href='http://www.invisionizer.com'>Invisionizer</a>
 * @copyright    (c) 2015 Invisionizer
 */

class awards_hook_awardsSettingsForm extends _HOOK_CLASS_
{
    protected function _awards()
    {
	try
	{
		try
		{
		        if ( !\IPS\Application::appIsEnabled( 'awards' ) )
		        {
		            return FALSE;
		        }
		
		        if ( !\IPS\Member::loggedIn()->canAccessModule( \IPS\Application\Module::get( 'awards', 'awards' ) ) )
		        {
		            return FALSE;
		        }
		
		        $member = \IPS\Member::load( \IPS\Member::loggedIn()->member_id );
		
		        $form = new \IPS\Helpers\Form;
		        $form->add( new \IPS\Helpers\Form\Select( 'award_sort', ( \IPS\Member::loggedIn()->award_sort ) ? \IPS\Member::loggedIn()->award_sort : 'date', FALSE, array( 'options' => array( 'date' => 'awards_member_date', 'cat' => 'awards_member_cat', 'title' => 'awards_member_title' ) ), NULL, NULL, NULL, NULL ) );
		
		        $form->add( new \IPS\Helpers\Form\Select( 'award_order', ( \IPS\Member::loggedIn()->award_order ) ? \IPS\Member::loggedIn()->award_order : 'desc', FALSE, array( 'options' => array( 'desc' => 'awards_member_desc', 'asc' => 'awards_member_asc' ) ), NULL, NULL, NULL, NULL ) );
		
		
		        $rows = array();
		        foreach ( \IPS\awards\Awarded::getItemsWithPermission( array( 'awarded_member = ?', $member->member_id ), "awarded_{$member->award_sort} {$member->award_order}", null, 'view', NULL, 0, $member, TRUE, FALSE, FALSE, FALSE, NULL, FALSE, TRUE, TRUE, TRUE, FALSE ) as $awarded )
		        {
		            $rows[ $awarded->id ] = $awarded->title;
		        }
		
		        if ( count( $rows ) < 1 )
		        {
		            $rows[] = NULL;
		        }
		
		        $form->add( new \IPS\Helpers\Form\Select( 'award_member_show', array_filter( explode( ',', $member->award_member_show ) ), FALSE, array( 'options' => $rows, 'parse' => 'normal', 'multiple' => TRUE ) ) );
		
		        if ( $values = $form->values(  ) )
		        {
		            $member->award_sort        = $values['award_sort'];
		            $member->award_order       = $values['award_order'];
		
		            $member->award_member_show = implode( ',', $values['award_member_show']);
		            $member->save();
		
		
		            \IPS\Output::i()->redirect( \IPS\Http\Url::internal( 'app=core&module=system&controller=settings&area=awards', 'front', 'settings_awards' ), 'awards_changed' );
		
		        }
		
		        return \IPS\Theme::i()->getTemplate( 'profile', 'awards', 'front' )->awardsSettings( $form );
		
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