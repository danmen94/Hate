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
 * hqAwards
 */
class _hqAwards extends \IPS\Dispatcher\Controller
{
	/**
	 * Execute
	 *
	 * @return	void
	 */
	public function execute()
	{
		\IPS\Dispatcher::i()->checkAcpPermission( 'upgrade_hq_manage' );

		\IPS\Output::i()->title = \IPS\Member::loggedIn()->language()->addToStack( 'hq' );

		parent::execute();
	}

	/**
	 * ...
	 *
	 * @return	void
	 */
	protected function manage()
	{
		if ( !\IPS\Db::i()->checkForTable( 'jlogica_awards' ) AND !\IPS\Db::i()->checkForTable( 'jlogica_awards_awarded' ) AND !\IPS\Db::i()->checkForTable( 'jlogica_awards_cats' ) )
		{
			# Not installed
			\IPS\Output::i()->output = "<div class='ipsType_reset ipsType_light ipsPad'>" . \IPS\Member::loggedIn()->language()->addToStack( 'awards_hq_not_installed' ) . "</div>";
		} else
		{
			# Check if already upgraded.
			$check = \IPS\Db::i()->select( '*', 'awards_upgrade', array( 'data = ?', 'hq' ) )->first();

			if ( $check['data'] == 'hq' AND $check['upgraded'] == 1 )
			{
				# Upgraded
				\IPS\Output::i()->output = "<div class='ipsType_reset ipsType_light ipsPad'>" . \IPS\Member::loggedIn()->language()->addToStack( 'awards_hq_upgraded' ) . "</div>";
			} else
			{
				$catsData  = \IPS\Db::i()->select( 'jlogica_awards_cats.cat_id, jlogica_awards_cats.title, jlogica_awards_cats.visible, jlogica_awards_cats.placement', 'jlogica_awards_cats', array(), NULL, NULL, NULL, NULL, \IPS\Db::SELECT_SQL_CALC_FOUND_ROWS )->setKeyField( 'cat_id' );
				$catsCount = $catsData->count( TRUE );

				if ( $catsCount < 1 )
				{
					\IPS\Output::i()->output = "<div class='ipsType_reset ipsType_light ipsPad'>" . \IPS\Member::loggedIn()->language()->addToStack( 'awards_no_cats' ) . "</div>";
				}

				$form = new \IPS\Helpers\Form;
				$form->add( new \IPS\Helpers\Form\Checkbox( 'awards_hq_upgrade', \IPS\Request::i()->awards_upgrade, FALSE, array() ) );

				$configurations = array();
				foreach ( \IPS\Db::i()->select( '*', 'core_file_storage' ) as $row )
				{
					$classname                             = 'IPS\File\\' . $row['method'];
					$configurations[$row['configuration']] = $classname::displayName( json_decode( $row['configuration'], TRUE ) );
				}

				$form->add( new \IPS\Helpers\Form\Select( 'awards_jawards', NULL, TRUE, array( 'options' => $configurations, 'disabled' => $disabled ) ) );

				if ( $values = $form->values() )
				{
					if ( $values['awards_hq_upgrade'] == 1 )
					{
						$cats = iterator_to_array( $catsData );

						if ( $catsCount > 0 )
						{
							foreach ( $cats as $c )
							{
								$cat           = new \IPS\awards\Cats;
								$cat->title    = $c['title'];
								$cat->position = $c['placement'];
								$cat->enabled  = $c['visible'];
								$cat->save();

								$awardsData  = \IPS\Db::i()->select( 'jlogica_awards.id, jlogica_awards.name, jlogica_awards.desc, jlogica_awards.longdesc, jlogica_awards.parent, jlogica_awards.visible, jlogica_awards.icon, jlogica_awards.placement', 'jlogica_awards', array( 'jlogica_awards.parent = ?', $c['cat_id'] ), NULL, NULL, NULL, NULL, \IPS\Db::SELECT_SQL_CALC_FOUND_ROWS )->setKeyField( 'id' );
								$awardsCount = $awardsData->count( TRUE );

								$awards = iterator_to_array( $awardsData );

								if ( $awardsCount > 0 )
								{
									foreach ( $awards as $a )
									{
										$loc = json_decode( $values['awards_jawards'] );

										$srcUrl = \IPS\ROOT_PATH . '/' . $loc->url . '/' . 'jawards' . '/' . $a['icon'];

										try
										{
											$icon = \IPS\File::create( 'awards_Awards', $a['icon'], NULL, NULL, FALSE, $srcUrl, FALSE );
										} catch ( \Exception $e )
										{
										}

										$award           = new \IPS\awards\Awards;
										$award->title    = $a['name'];
										$award->desc     = $a['desc'];
										$award->enabled  = $a['visible'];
										$award->position = $a['placement'];
										$award->cat_id   = $cat->id;
										$award->icon     = $icon;
										$award->reason   = $a['longdesc'];
										$award->show     = "awards";
										$award->save();

										$awardedData  = \IPS\Db::i()->select( 'jlogica_awards_awarded.row_id, jlogica_awards_awarded.award_id, jlogica_awards_awarded.user_id, jlogica_awards_awarded.is_active, jlogica_awards_awarded.notes, jlogica_awards_awarded.date, jlogica_awards_awarded.awarded_by', 'jlogica_awards_awarded', array( 'jlogica_awards_awarded.award_id = ?', $a['id'] ), NULL, NULL, NULL, NULL, \IPS\Db::SELECT_SQL_CALC_FOUND_ROWS )->setKeyField( 'row_id' );
										$awardedCount = $awardedData->count( TRUE );

										$awarded = iterator_to_array( $awardedData );

										if ( $awardedCount > 0 )
										{
											foreach ( $awarded as $m )
											{
												$members          = new \IPS\awards\Awarded;
												$members->member  = $m['user_id'];
												$members->award   = $award->id;
												$members->date    = $m['date'];
												$members->giver   = $m['awarded_by'];
												$members->reason  = $m['notes'];
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
									}
								}
							}
						}

						\IPS\Db::i()->update( 'awards_upgrade', array( 'upgraded' => 1 ), array( 'data=?', "hq" ) );

						\IPS\Output::i()->redirect( \IPS\Http\Url::internal( 'app=awards&module=upgrade&controller=hqAwards' ), 'awards_hq_upgraded_msg' );

					}
				}

				\IPS\Output::i()->output = $form;
			}
		}	}
	
}