<?php
/**
 * @package      iAwards
 * @author       <a href='http://www.invisionizer.com'>Invisionizer</a>
 * @copyright    (c) 2015 Invisionizer
 */

namespace IPS\awards\modules\admin\upgrade;

/* To prevent PHP errors (extending class does not exist) revealing path */
if ( !defined( '\IPS\SUITE_UNIQUE_KEY' ) )
{
	header( ( isset( $_SERVER['SERVER_PROTOCOL'] ) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0' ) . ' 403 Forbidden' );
	exit;
}

/**
 * awardsSystem
 */
class _awardsSystem extends \IPS\Dispatcher\Controller
{
	/**
	 * Execute
	 *
	 * @return	void
	 */
	public function execute()
	{
		\IPS\Dispatcher::i()->checkAcpPermission( 'upgrade_as_manage' );

		\IPS\Output::i()->title = \IPS\Member::loggedIn()->language()->addToStack( 'as' );

		parent::execute();
	}

	/**
	 * ...
	 *
	 * @return	void
	 */
	protected function manage()
	{
		if ( !\IPS\Db::i()->checkForTable( 'awards' ) AND !\IPS\Db::i()->checkForTable( 'awards_cat' ) AND !\IPS\Db::i()->checkForTable( 'awarded' ) AND !\IPS\Db::i()->checkForTable( 'award_removed' ) )
		{
			# Not installed
			\IPS\Output::i()->output = "<div class='acpFormTabContent'><div class='ipsType_reset ipsType_light ipsPad'>" . \IPS\Member::loggedIn()->language()->addToStack( 'awards_as_not_installed' ) . "</div></div>";
		} else
		{
			# Check if already upgraded.
			$check = \IPS\Db::i()->select( '*', 'awards_upgrade', array( 'data = ?', 'as' ) )->first();

			if ( $check['data'] == 'as' AND $check['upgraded'] == 1 )
			{

				# Upgraded
				\IPS\Output::i()->output = "<div class='acpFormTabContent'><div class='ipsType_reset ipsType_light ipsPad'>" . \IPS\Member::loggedIn()->language()->addToStack( 'awards_as_upgraded' ) . "</div></div>";
			} else
			{
				$catsData  = \IPS\Db::i()->select( 'awards_cat.awards_cat_id,awards_cat.awards_cat_name,awards_cat.awards_cat_pos', 'awards_cat', array(), NULL, NULL, NULL, NULL, \IPS\Db::SELECT_SQL_CALC_FOUND_ROWS )->setKeyField( 'awards_cat_id' );
				$catsCount = $catsData->count( TRUE );

				if ( $catsCount < 1 )
				{
					\IPS\Output::i()->output = "<div class='ipsType_reset ipsType_light ipsPad'>" . \IPS\Member::loggedIn()->language()->addToStack( 'awards_no_cats' ) . "</div>";
				}

				$form = new \IPS\Helpers\Form;
				$form->add( new \IPS\Helpers\Form\Checkbox( 'awards_as_upgrade', \IPS\Request::i()->awards_upgrade, FALSE, array() ) );

				$configurations = array();
				foreach ( \IPS\Db::i()->select( '*', 'core_file_storage' ) as $row )
				{
					$classname                             = 'IPS\File\\' . $row['method'];
					$configurations[$row['configuration']] = $classname::displayName( json_decode( $row['configuration'], TRUE ) );
				}

				$form->add( new \IPS\Helpers\Form\Select( 'awards_awards_system', NULL, TRUE, array( 'options' => $configurations, 'disabled' => $disabled ) ) );

				if ( $values = $form->values() )
				{

					if ( $values['awards_as_upgrade'] == 1 )
					{

						$cats = iterator_to_array( $catsData );

						if ( $catsCount > 0 )
						{
							foreach ( $cats as $c )
							{
								$cat           = new \IPS\awards\Cats;
								$cat->title    = $c['awards_cat_name'];
								$cat->position = $c['awards_cat_pos'];
								$cat->enabled  = 1;
								$cat->save();

								$awardsData  = \IPS\Db::i()->select( 'awards.awards_id,awards.awards_name,awards.awards_desc,awards.awards_img,awards.awards_pos,awards.awards_cat_id,awards.awards_awarded', 'awards', array( 'awards.awards_cat_id = ?', $c['awards_cat_id'] ), NULL, NULL, NULL, NULL, \IPS\Db::SELECT_SQL_CALC_FOUND_ROWS )->setKeyField( 'awards_id' );
								$awardsCount = $awardsData->count( TRUE );

								$awards = iterator_to_array( $awardsData );

								if ( $awardsCount > 0 )
								{
									foreach ( $awards as $a )
									{

										$loc = json_decode( $values['awards_awards_system'] );

										$srcUrl = \IPS\ROOT_PATH . '/' . $loc->url . '/' . 'awards_images' . '/' . $a['awards_img'];

										try
										{
											$icon = \IPS\File::create( 'awards_Awards', $a['awards_img'], NULL, NULL, FALSE, $srcUrl, FALSE );
										} catch ( \Exception $e )
										{
										}

										$award           = new \IPS\awards\Awards;
										$award->title    = $a['awards_name'];
										$award->desc     = $a['awards_desc'];
										$award->enabled  = 1;
										$award->position = $a['awards_pos'];
										$award->cat_id   = $cat->id;
										$award->icon     = $icon;
										$award->reason   = $a['awarded_reason'];
										$award->show     = "awards";
										$award->save();

										$awardedData  = \IPS\Db::i()->select( 'awarded.awarded_id,awarded.awards_user_id,awarded.awarded_who_gave,awarded.awarded_date,awarded.awarded_reason', 'awarded', array( 'awarded.awards_id = ?', $a['awards_id'] ), NULL, NULL, NULL, NULL, \IPS\Db::SELECT_SQL_CALC_FOUND_ROWS )->setKeyField( 'awarded_id' );
										$awardedCount = $awardedData->count( TRUE );

										$awarded = iterator_to_array( $awardedData );

										if ( $awardedCount > 0 )
										{
											foreach ( $awarded as $m )
											{
												$members          = new \IPS\awards\Awarded;
												$members->member  = $m['awards_user_id'];
												$members->award   = $award->id;
												$members->date    = $m['awarded_date'];
												$members->giver   = $m['awarded_who_gave'];
												$members->reason  = $m['awarded_reason'];
												$members->cat     = $cat->id;
												$members->title   = $award->title;
												$members->show    = "awards";
												$members->options = "manual";
												$members->save();

												$award        = \IPS\awards\Awards::load( $award->id );
												$award->count = $award->count + 1;
												$award->save();
											}
										}

										$removedData  = \IPS\Db::i()->select( 'award_removed.deawarded_id,award_removed.deawarder_id,award_removed.awarded_id,award_removed.awards_id,award_removed.awarded_user_id,award_removed.awarded_who_gave,award_removed.awarded_date,award_removed.awarded_reason,award_removed.deawarded_reason', 'award_removed', array( 'award_removed.awards_id = ?', $award->id ), NULL, NULL, NULL, NULL, \IPS\Db::SELECT_SQL_CALC_FOUND_ROWS )->setKeyField( 'awarded_id' );
										$removedCount = $removedData->count( TRUE );

										$removed = iterator_to_array( $removedData );

										if ( $removedCount > 0 )
										{
											foreach ( $removed as $r )
											{
												$remove               = new \IPS\awards\Removed;
												$remove->award        = $r['awards_id'];
												$remove->member       = $r['awarded_user_id'];
												$remove->giver        = $r['awarded_who_gave'];
												$remove->date         = $r['awarded_date'];
												$remove->by           = $r['deawarder_id'];
												$remove->date         = $r['awarded_date'];
												$remove->title        = $award->title;
												$remove->awarded_date = $r['awarded_date'];
												$remove->reason       = $r['deawarded_reason'];
												$remove->save();
											}
										}
									}
								}
							}
						}

						\IPS\Db::i()->update( 'awards_upgrade', array( 'upgraded' => 1 ), array( 'data=?', "as" ) );

						\IPS\Output::i()->redirect( \IPS\Http\Url::internal( 'app=awards&module=upgrade&controller=awardsSystem' ), 'awards_as_upgraded_msg' );

					}
				}

				\IPS\Output::i()->output = $form;
			}
		}
	}

}