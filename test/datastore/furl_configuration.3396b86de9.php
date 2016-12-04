<?php

return <<<'VALUE'
"{\"forums_rss\":{\"friendly\":\"forum\\\/{#id}-{?}.xml\",\"real\":\"app=forums&module=forums&controller=forums&rss=1\",\"with_top_level\":\"forums\\\/forum\\\/{#id}-{?}.xml\",\"regex\":[\"forum\\\\\\\/(\\\\d+?)\\\\-(?!&)(.+?)\\\\.xml\",\"forums\\\\\\\/forum\\\\\\\/(\\\\d+?)\\\\-(?!&)(.+?)\\\\.xml\"],\"params\":[\"id\",\"\"]},\"forums_forum\":{\"friendly\":\"forum\\\/{#id}-{?}\",\"real\":\"app=forums&module=forums&controller=forums\",\"verify\":\"\\\\IPS\\\\forums\\\\Forum\",\"with_top_level\":\"forums\\\/forum\\\/{#id}-{?}\",\"regex\":[\"forum\\\\\\\/(\\\\d+?)\\\\-(?!&)(.+?)\",\"forums\\\\\\\/forum\\\\\\\/(\\\\d+?)\\\\-(?!&)(.+?)\"],\"params\":[\"id\",\"\"]},\"forums_topic\":{\"friendly\":\"topic\\\/{#id}-{?}\",\"real\":\"app=forums&module=forums&controller=topic\",\"verify\":\"\\\\IPS\\\\forums\\\\Topic\",\"with_top_level\":\"forums\\\/topic\\\/{#id}-{?}\",\"regex\":[\"topic\\\\\\\/(\\\\d+?)\\\\-(?!&)(.+?)\",\"forums\\\\\\\/topic\\\\\\\/(\\\\d+?)\\\\-(?!&)(.+?)\"],\"params\":[\"id\",\"\"]},\"forums\":{\"friendly\":\"\",\"real\":\"app=forums&module=forums&controller=index\",\"with_top_level\":\"forums\",\"regex\":[\"\",\"forums\"],\"params\":[]},\"topic_create\":{\"friendly\":\"submit\",\"real\":\"app=forums&module=forums&controller=forums&do=createMenu\",\"with_top_level\":\"forums\\\/submit\",\"regex\":[\"submit\",\"forums\\\\\\\/submit\"],\"params\":[]},\"login\":{\"friendly\":\"login\",\"real\":\"app=core&module=system&controller=login\",\"regex\":[\"login\"],\"params\":[]},\"logout\":{\"friendly\":\"logout\",\"real\":\"app=core&module=system&controller=login&do=logout\",\"regex\":[\"logout\"],\"params\":[]},\"lostpassword\":{\"friendly\":\"lostpassword\",\"real\":\"app=core&module=system&controller=lostpass\",\"regex\":[\"lostpassword\"],\"params\":[]},\"settings_email\":{\"friendly\":\"settings\\\/email\",\"real\":\"app=core&module=system&controller=settings&area=email\",\"regex\":[\"settings\\\\\\\/email\"],\"params\":[]},\"settings_password\":{\"friendly\":\"settings\\\/password\",\"real\":\"app=core&module=system&controller=settings&area=password\",\"regex\":[\"settings\\\\\\\/password\"],\"params\":[]},\"settings_securityquestions\":{\"friendly\":\"settings\\\/security-questions\",\"real\":\"app=core&module=system&controller=settings&area=securityquestions\",\"regex\":[\"settings\\\\\\\/security\\\\-questions\"],\"params\":[]},\"securityquestionsforgot\":{\"friendly\":\"settings\\\/security-questions\\\/forgot\",\"real\":\"app=core&module=system&controller=settings&do=securityquestionsforgot\",\"regex\":[\"settings\\\\\\\/security\\\\-questions\\\\\\\/forgot\"],\"params\":[]},\"securityquestionsvalidate\":{\"friendly\":\"settings\\\/security-questions\\\/validate\",\"real\":\"app=core&module=system&controller=settings&do=securityquestionsvalidate\",\"regex\":[\"settings\\\\\\\/security\\\\-questions\\\\\\\/validate\"],\"params\":[]},\"settings_username\":{\"friendly\":\"settings\\\/username\",\"real\":\"app=core&module=system&controller=settings&area=username\",\"regex\":[\"settings\\\\\\\/username\"],\"params\":[]},\"settings_signature\":{\"friendly\":\"settings\\\/signature\",\"real\":\"app=core&module=system&controller=settings&area=signature\",\"regex\":[\"settings\\\\\\\/signature\"],\"params\":[]},\"settings_Facebook\":{\"friendly\":\"settings\\\/facebook\",\"real\":\"app=core&module=system&controller=settings&area=profilesync&service=Facebook\",\"regex\":[\"settings\\\\\\\/facebook\"],\"params\":[]},\"settings_Google\":{\"friendly\":\"settings\\\/google\",\"real\":\"app=core&module=system&controller=settings&area=profilesync&service=Google\",\"regex\":[\"settings\\\\\\\/google\"],\"params\":[]},\"settings_Linkedin\":{\"friendly\":\"settings\\\/linkedin\",\"real\":\"app=core&module=system&controller=settings&area=profilesync&service=LinkedIn\",\"regex\":[\"settings\\\\\\\/linkedin\"],\"params\":[]},\"settings_Microsoft\":{\"friendly\":\"settings\\\/microsoft\",\"real\":\"app=core&module=system&controller=settings&area=profilesync&service=Microsoft\",\"regex\":[\"settings\\\\\\\/microsoft\"],\"params\":[]},\"settings_Twitter\":{\"friendly\":\"settings\\\/twitter\",\"real\":\"app=core&module=system&controller=settings&area=profilesync&service=Twitter\",\"regex\":[\"settings\\\\\\\/twitter\"],\"params\":[]},\"settings\":{\"friendly\":\"settings\",\"real\":\"app=core&module=system&controller=settings\",\"regex\":[\"settings\"],\"params\":[]},\"unsubscribe\":{\"friendly\":\"unsubscribe\",\"real\":\"app=core&module=system&controller=unsubscribe\",\"regex\":[\"unsubscribe\"],\"params\":[]},\"privacy\":{\"friendly\":\"privacy\",\"real\":\"app=core&module=system&controller=privacy\",\"regex\":[\"privacy\",\"privacypolicy\"],\"params\":[]},\"register\":{\"friendly\":\"register\",\"real\":\"app=core&module=system&controller=register\",\"regex\":[\"register\"],\"params\":[]},\"attachments\":{\"friendly\":\"attachments\",\"real\":\"app=core&module=system&controller=attachments\",\"regex\":[\"attachments\"],\"params\":[]},\"messenger_compose\":{\"friendly\":\"messenger\\\/compose\",\"real\":\"app=core&module=messaging&controller=messenger&do=compose\",\"regex\":[\"messenger\\\\\\\/compose\"],\"params\":[]},\"messenger_convo\":{\"friendly\":\"messenger\\\/{#id}\",\"real\":\"app=core&module=messaging&controller=messenger\",\"regex\":[\"messenger\\\\\\\/(\\\\d+?)\"],\"params\":[\"id\"]},\"messenger_unread\":{\"friendly\":\"messenger\\\/unread\",\"real\":\"app=core&module=messaging&controller=messenger&folder=unread\",\"regex\":[\"messenger\\\\\\\/unread\"],\"params\":[]},\"messenger_drafts\":{\"friendly\":\"messenger\\\/drafts\",\"real\":\"app=core&module=messaging&controller=messenger&folder=drafts\",\"regex\":[\"messenger\\\\\\\/drafts\"],\"params\":[]},\"messaging\":{\"friendly\":\"messenger\",\"real\":\"app=core&module=messaging&controller=messenger\",\"regex\":[\"messenger\"],\"params\":[]},\"warn_add\":{\"friendly\":\"profile\\\/{#id}-{?}\\\/warnings\\\/add\",\"real\":\"app=core&module=system&controller=warnings&do=warn\",\"regex\":[\"profile\\\\\\\/(\\\\d+?)\\\\-(?!&)(.+?)\\\\\\\/warnings\\\\\\\/add\"],\"params\":[\"id\",\"\"]},\"warn_view\":{\"friendly\":\"profile\\\/{#id}-{?}\\\/warnings\\\/{#w}\",\"real\":\"app=core&module=system&controller=warnings&do=view\",\"verify\":\"\\\\IPS\\\\core\\\\Warnings\\\\Warning\",\"regex\":[\"profile\\\\\\\/(\\\\d+?)\\\\-(?!&)(.+?)\\\\\\\/warnings\\\\\\\/(\\\\d+?)\"],\"params\":[\"id\",\"\",\"w\"]},\"warn_list\":{\"friendly\":\"profile\\\/{#id}-{?}\\\/warnings\",\"real\":\"app=core&module=system&controller=warnings\",\"regex\":[\"profile\\\\\\\/(\\\\d+?)\\\\-(?!&)(.+?)\\\\\\\/warnings\"],\"params\":[\"id\",\"\"]},\"profile_content\":{\"friendly\":\"profile\\\/{#id}-{?}\\\/content\",\"real\":\"app=core&module=members&controller=profile&do=content\",\"regex\":[\"profile\\\\\\\/(\\\\d+?)\\\\-(?!&)(.+?)\\\\\\\/content\"],\"params\":[\"id\",\"\"]},\"profile_reputation\":{\"friendly\":\"profile\\\/{#id}-{?}\\\/reputation\",\"real\":\"app=core&module=members&controller=profile&do=reputation\",\"regex\":[\"profile\\\\\\\/(\\\\d+?)\\\\-(?!&)(.+?)\\\\\\\/reputation\"],\"params\":[\"id\",\"\"]},\"edit_profile\":{\"friendly\":\"profile\\\/{#id}-{?}\\\/edit\",\"real\":\"app=core&module=members&controller=profile&do=edit\",\"regex\":[\"profile\\\\\\\/(\\\\d+?)\\\\-(?!&)(.+?)\\\\\\\/edit\"],\"params\":[\"id\",\"\"]},\"edit_profile_photo\":{\"friendly\":\"profile\\\/{#id}-{?}\\\/photo\",\"real\":\"app=core&module=members&controller=profile&do=editPhoto\",\"regex\":[\"profile\\\\\\\/(\\\\d+?)\\\\-(?!&)(.+?)\\\\\\\/photo\"],\"params\":[\"id\",\"\"]},\"flag_as_spammer\":{\"friendly\":\"profile\\\/{#id}-{?}\\\/spammer\",\"real\":\"app=core&module=system&controller=moderation&do=flagAsSpammer\",\"regex\":[\"profile\\\\\\\/(\\\\d+?)\\\\-(?!&)(.+?)\\\\\\\/spammer\"],\"params\":[\"id\",\"\"]},\"profile_followers\":{\"friendly\":\"profile\\\/{#id}-{?}\\\/followers\",\"real\":\"app=core&module=members&controller=profile&do=followers\",\"regex\":[\"profile\\\\\\\/(\\\\d+?)\\\\-(?!&)(.+?)\\\\\\\/followers\"],\"params\":[\"id\",\"\"]},\"profile\":{\"friendly\":\"profile\\\/{#id}-{?}\",\"real\":\"app=core&module=members&controller=profile\",\"verify\":\"\\\\IPS\\\\Member\",\"regex\":[\"profile\\\\\\\/(\\\\d+?)\\\\-(?!&)(.+?)\",\"user\\\\\\\/(\\\\d+?)\\\\-(?!&)(.+?)\"],\"params\":[\"id\",\"\"]},\"modcp_announcements\":{\"friendly\":\"modcp\\\/announcements\",\"real\":\"app=core&module=modcp&controller=modcp&tab=announcements\",\"regex\":[\"modcp\\\\\\\/announcements\"],\"params\":[]},\"modcp_report\":{\"friendly\":\"modcp\\\/reports\\\/{#id}\",\"real\":\"app=core&module=modcp&controller=modcp&tab=reports&action=view\",\"regex\":[\"modcp\\\\\\\/reports\\\\\\\/(\\\\d+?)\"],\"params\":[\"id\"]},\"modcp\":{\"friendly\":\"modcp\",\"real\":\"app=core&module=modcp&controller=modcp\",\"regex\":[\"modcp\"],\"params\":[]},\"modcp_members\":{\"friendly\":\"modcp\\\/members\",\"real\":\"app=core&module=modcp&controller=modcp&tab=members\",\"regex\":[\"modcp\\\\\\\/members\"],\"params\":[]},\"modcp_reports\":{\"friendly\":\"modcp\\\/reports\",\"real\":\"app=core&module=modcp&controller=modcp&tab=reports\",\"regex\":[\"modcp\\\\\\\/reports\"],\"params\":[]},\"modcp_content\":{\"friendly\":\"modcp\\\/content\",\"real\":\"app=core&module=modcp&controller=modcp&tab=hidden\",\"regex\":[\"modcp\\\\\\\/content\"],\"params\":[]},\"modcp_approval\":{\"friendly\":\"modcp\\\/approval-queue\",\"real\":\"app=core&module=modcp&controller=modcp&tab=approval\",\"regex\":[\"modcp\\\\\\\/approval\\\\-queue\"],\"params\":[]},\"modcp_recent_warnings\":{\"friendly\":\"modcp\\\/recent-warnings\",\"real\":\"app=core&module=modcp&controller=modcp&tab=recent_warnings\",\"regex\":[\"modcp\\\\\\\/recent\\\\-warnings\"],\"params\":[]},\"modcp_ip_tools\":{\"friendly\":\"modcp\\\/ip-tools\",\"real\":\"app=core&module=modcp&controller=modcp&tab=ip_tools\",\"regex\":[\"modcp\\\\\\\/ip\\\\-tools\"],\"params\":[]},\"ignore\":{\"friendly\":\"ignore\",\"real\":\"app=core&module=system&controller=ignore\",\"regex\":[\"ignore\"],\"params\":[]},\"online\":{\"friendly\":\"online\",\"real\":\"app=core&module=online&controller=online\",\"regex\":[\"online\"],\"params\":[]},\"staffdirectory\":{\"friendly\":\"staff\",\"real\":\"app=core&module=staffdirectory&controller=directory\",\"regex\":[\"staff\"],\"params\":[]},\"guidelines\":{\"friendly\":\"guidelines\",\"real\":\"app=core&module=system&controller=guidelines\",\"regex\":[\"guidelines\"],\"params\":[]},\"notifications_options\":{\"friendly\":\"notifications\\\/options\",\"real\":\"app=core&module=system&controller=notifications&do=options\",\"regex\":[\"notifications\\\\\\\/options\"],\"params\":[]},\"notifications\":{\"friendly\":\"notifications\",\"real\":\"app=core&module=system&controller=notifications\",\"regex\":[\"notifications\"],\"params\":[]},\"terms\":{\"friendly\":\"terms\",\"real\":\"app=core&module=system&controller=terms\",\"regex\":[\"terms\"],\"params\":[]},\"announcement\":{\"friendly\":\"announcement\\\/{#id}-{?}\",\"real\":\"app=core&module=system&controller=announcement\",\"regex\":[\"announcement\\\\\\\/(\\\\d+?)\\\\-(?!&)(.+?)\"],\"params\":[\"id\",\"\"]},\"contact\":{\"friendly\":\"contact\",\"real\":\"app=core&module=contact&controller=contact\",\"regex\":[\"contact\"],\"params\":[]},\"followed_content\":{\"friendly\":\"followed\",\"real\":\"app=core&module=system&controller=followed\",\"regex\":[\"followed\"],\"params\":[]},\"search\":{\"friendly\":\"search\",\"real\":\"app=core&module=search&controller=search\",\"regex\":[\"search\"],\"params\":[]},\"discover_unread\":{\"friendly\":\"discover\\\/unread\",\"real\":\"app=core&module=discover&controller=streams&id=1\",\"regex\":[\"discover\\\\\\\/unread\"],\"params\":[]},\"discover_istarted\":{\"friendly\":\"discover\\\/content-started\",\"real\":\"app=core&module=discover&controller=streams&id=2\",\"regex\":[\"discover\\\\\\\/content\\\\-started\"],\"params\":[]},\"discover_followed\":{\"friendly\":\"discover\\\/followed-content\",\"real\":\"app=core&module=discover&controller=streams&id=3\",\"regex\":[\"discover\\\\\\\/followed\\\\-content\"],\"params\":[]},\"discover_following\":{\"friendly\":\"discover\\\/followed-members\",\"real\":\"app=core&module=discover&controller=streams&id=4\",\"regex\":[\"discover\\\\\\\/followed\\\\-members\"],\"params\":[]},\"discover_posted\":{\"friendly\":\"discover\\\/content-posted\",\"real\":\"app=core&module=discover&controller=streams&id=5\",\"regex\":[\"discover\\\\\\\/content\\\\-posted\"],\"params\":[]},\"discover_stream\":{\"friendly\":\"discover\\\/{#id}\",\"real\":\"app=core&module=discover&controller=streams\",\"regex\":[\"discover\\\\\\\/(\\\\d+?)\"],\"params\":[\"id\"]},\"discover_rss_all_activity\":{\"friendly\":\"discover\\\/all.xml\",\"real\":\"app=core&module=discover&controller=streams&rss=1\",\"regex\":[\"discover\\\\\\\/all\\\\.xml\"],\"params\":[]},\"discover_rss\":{\"friendly\":\"discover\\\/{#id}.xml\",\"real\":\"app=core&module=discover&controller=streams&rss=1\",\"regex\":[\"discover\\\\\\\/(\\\\d+?)\\\\.xml\"],\"params\":[\"id\"]},\"discover_all\":{\"friendly\":\"discover\",\"real\":\"app=core&module=discover&controller=streams\",\"regex\":[\"discover\"],\"params\":[]},\"language\":{\"friendly\":\"language\",\"real\":\"app=core&module=system&controller=language\",\"regex\":[\"language\"],\"params\":[]},\"theme\":{\"friendly\":\"theme\",\"real\":\"app=core&module=system&controller=theme\",\"regex\":[\"theme\"],\"params\":[]},\"mark_site_as_read\":{\"friendly\":\"markallread\",\"real\":\"app=core&module=system&controller=markread\",\"regex\":[\"markallread\"],\"params\":[]},\"tags\":{\"friendly\":\"tags\\\/{@tags}\",\"real\":\"app=core&module=search&controller=search\",\"regex\":[\"tags\\\\\\\/(.+?)\"],\"params\":[\"tags\"]},\"activity\":{\"friendly\":\"activity\",\"real\":\"app=core&module=activity&controller=activity\",\"regex\":[\"activity\"],\"params\":[]},\"vnc\":{\"friendly\":\"new-content\",\"real\":\"app=core&module=discover&controller=vnc\",\"regex\":[\"new\\\\-content\"],\"params\":[]},\"blogs_rss\":{\"friendly\":\"blogs\\\/blog\\\/rss\\\/{#id}-{?}\",\"real\":\"app=blog&module=blogs&controller=view&do=rss\",\"without_top_level\":\"blog\\\/rss\\\/{#id}-{?}\",\"regex\":[\"blogs\\\\\\\/blog\\\\\\\/rss\\\\\\\/(\\\\d+?)\\\\-(?!&)(.+?)\",\"blog\\\\\\\/entry\\\\-(\\\\d+?)\\\\-(?!&)(.+?)\",\"blog\\\\\\\/rss\\\\\\\/(\\\\d+?)\\\\-(?!&)(.+?)\"],\"params\":[\"id\",\"\"]},\"blogs_blog\":{\"friendly\":\"blogs\\\/blog\\\/{#id}-{?}\",\"real\":\"app=blog&module=blogs&controller=view\",\"verify\":\"\\\\IPS\\\\blog\\\\Blog\",\"without_top_level\":\"blog\\\/{#id}-{?}\",\"regex\":[\"blogs\\\\\\\/blog\\\\\\\/(\\\\d+?)\\\\-(?!&)(.+?)\",\"blog\\\\\\\/(\\\\d+?)\\\\-(?!&)(.+?)\"],\"params\":[\"id\",\"\"]},\"blog_entry\":{\"friendly\":\"blogs\\\/entry\\\/{#id}-{?}\",\"real\":\"app=blog&module=blogs&controller=entry\",\"verify\":\"\\\\IPS\\\\blog\\\\Entry\",\"without_top_level\":\"entry\\\/{#id}-{?}\",\"regex\":[\"blogs\\\\\\\/entry\\\\\\\/(\\\\d+?)\\\\-(?!&)(.+?)\",\"blog\\\\\\\/(?!&)(?:.+?)\\\\\\\/entry\\\\-(\\\\d+?)\\\\-(?!&)(.+?)\",\"entry\\\\\\\/(\\\\d+?)\\\\-(?!&)(.+?)\"],\"params\":[\"id\",\"\"]},\"blog_submit\":{\"friendly\":\"blogs\\\/submit\",\"real\":\"app=blog&module=blogs&controller=submit\",\"without_top_level\":\"submit\",\"regex\":[\"blogs\\\\\\\/submit\",\"submit\"],\"params\":[]},\"blog_create\":{\"friendly\":\"blogs\\\/create\",\"real\":\"app=blog&module=blogs&controller=create\",\"without_top_level\":\"create\",\"regex\":[\"blogs\\\\\\\/create\",\"create\"],\"params\":[]},\"blogs\":{\"friendly\":\"blogs\",\"real\":\"app=blog&module=blogs&controller=browse\",\"without_top_level\":\"\",\"regex\":[\"blogs\",\"blog\"],\"params\":[]},\"calendar_calweek\":{\"friendly\":\"calendar\\\/{#id}-{?}\\\/week\\\/{@w}\",\"real\":\"app=calendar&module=calendar&controller=view&view=week\",\"without_top_level\":\"{#id}-{?}\\\/week\\\/{@w}\",\"regex\":[\"calendar\\\\\\\/(\\\\d+?)\\\\-(?!&)(.+?)\\\\\\\/week\\\\\\\/(.+?)\",\"(\\\\d+?)\\\\-(?!&)(.+?)\\\\\\\/week\\\\\\\/(.+?)\"],\"params\":[\"id\",\"\",\"w\"]},\"calendar_calstream\":{\"friendly\":\"calendar\\\/{#id}-{?}\\\/events\\\/{#y}\\\/{#m}\",\"real\":\"app=calendar&module=calendar&controller=view&view=stream\",\"without_top_level\":\"{#id}-{?}\\\/events\\\/{#y}\\\/{#m}\",\"regex\":[\"calendar\\\\\\\/(\\\\d+?)\\\\-(?!&)(.+?)\\\\\\\/events\\\\\\\/(\\\\d+?)\\\\\\\/(\\\\d+?)\",\"(\\\\d+?)\\\\-(?!&)(.+?)\\\\\\\/events\\\\\\\/(\\\\d+?)\\\\\\\/(\\\\d+?)\"],\"params\":[\"id\",\"\",\"y\",\"m\"]},\"calendar_calicaldownload\":{\"friendly\":\"calendar\\\/{#id}-{?}\\\/download\",\"real\":\"app=calendar&module=calendar&controller=view&do=download\",\"without_top_level\":\"{#id}-{?}\\\/download\",\"regex\":[\"calendar\\\\\\\/(\\\\d+?)\\\\-(?!&)(.+?)\\\\\\\/download\",\"(\\\\d+?)\\\\-(?!&)(.+?)\\\\\\\/download\"],\"params\":[\"id\",\"\"]},\"calendar_calday\":{\"friendly\":\"calendar\\\/{#id}-{?}\\\/{#y}\\\/{#m}\\\/{#d}\",\"real\":\"app=calendar&module=calendar&controller=view&view=day\",\"without_top_level\":\"{#id}-{?}\\\/{#y}\\\/{#m}\\\/{#d}\",\"regex\":[\"calendar\\\\\\\/(\\\\d+?)\\\\-(?!&)(.+?)\\\\\\\/(\\\\d+?)\\\\\\\/(\\\\d+?)\\\\\\\/(\\\\d+?)\",\"calendar\\\\\\\/(\\\\d+?)\\\\-(?!&)(.+?)\\\\\\\/day\\\\-(\\\\d+?)\\\\-(\\\\d+?)\\\\-(\\\\d+?)\",\"(\\\\d+?)\\\\-(?!&)(.+?)\\\\\\\/(\\\\d+?)\\\\\\\/(\\\\d+?)\\\\\\\/(\\\\d+?)\"],\"params\":[\"id\",\"\",\"y\",\"m\",\"d\"]},\"calendar_calmonth\":{\"friendly\":\"calendar\\\/{#id}-{?}\\\/{#y}\\\/{#m}\",\"real\":\"app=calendar&module=calendar&controller=view&view=month\",\"without_top_level\":\"{#id}-{?}\\\/{#y}\\\/{#m}\",\"regex\":[\"calendar\\\\\\\/(\\\\d+?)\\\\-(?!&)(.+?)\\\\\\\/(\\\\d+?)\\\\\\\/(\\\\d+?)\",\"(\\\\d+?)\\\\-(?!&)(.+?)\\\\\\\/(\\\\d+?)\\\\\\\/(\\\\d+?)\"],\"params\":[\"id\",\"\",\"y\",\"m\"]},\"calendar_calendar\":{\"friendly\":\"calendar\\\/{#id}-{?}\",\"real\":\"app=calendar&module=calendar&controller=view\",\"verify\":\"\\\\IPS\\\\calendar\\\\Calendar\",\"without_top_level\":\"{#id}-{?}\",\"regex\":[\"calendar\\\\\\\/(\\\\d+?)\\\\-(?!&)(.+?)\",\"(\\\\d+?)\\\\-(?!&)(.+?)\"],\"params\":[\"id\",\"\"]},\"calendar_day\":{\"friendly\":\"calendar\\\/{#y}\\\/{#m}\\\/{#d}\",\"real\":\"app=calendar&module=calendar&controller=view&view=day\",\"without_top_level\":\"{#y}\\\/{#m}\\\/{#d}\",\"regex\":[\"calendar\\\\\\\/(\\\\d+?)\\\\\\\/(\\\\d+?)\\\\\\\/(\\\\d+?)\",\"(\\\\d+?)\\\\\\\/(\\\\d+?)\\\\\\\/(\\\\d+?)\"],\"params\":[\"y\",\"m\",\"d\"]},\"calendar_month\":{\"friendly\":\"calendar\\\/{#y}\\\/{#m}\",\"real\":\"app=calendar&module=calendar&controller=view&view=month\",\"without_top_level\":\"{#y}\\\/{#m}\",\"regex\":[\"calendar\\\\\\\/(\\\\d+?)\\\\\\\/(\\\\d+?)\",\"(\\\\d+?)\\\\\\\/(\\\\d+?)\"],\"params\":[\"y\",\"m\"]},\"calendar_week\":{\"friendly\":\"calendar\\\/week\\\/{@w}\",\"real\":\"app=calendar&module=calendar&controller=view&view=week\",\"without_top_level\":\"week\\\/{@w}\",\"regex\":[\"calendar\\\\\\\/week\\\\\\\/(.+?)\",\"week\\\\\\\/(.+?)\"],\"params\":[\"w\"]},\"calendar_rss\":{\"friendly\":\"calendar\\\/events.xml\",\"real\":\"app=calendar&module=calendar&controller=view&do=rss\",\"without_top_level\":\"events.xml\",\"regex\":[\"calendar\\\\\\\/events\\\\.xml\",\"events\\\\.xml\"],\"params\":[]},\"calendar_stream\":{\"friendly\":\"calendar\\\/events\\\/{#y}\\\/{#m}\",\"real\":\"app=calendar&module=calendar&controller=view&view=stream\",\"without_top_level\":\"events\\\/{#y}\\\/{#m}\",\"regex\":[\"calendar\\\\\\\/events\\\\\\\/(\\\\d+?)\\\\\\\/(\\\\d+?)\",\"events\\\\\\\/(\\\\d+?)\\\\\\\/(\\\\d+?)\"],\"params\":[\"y\",\"m\"]},\"calendar_icaldownload\":{\"friendly\":\"calendar\\\/download\",\"real\":\"app=calendar&module=calendar&controller=view&do=download\",\"without_top_level\":\"download\",\"regex\":[\"calendar\\\\\\\/download\",\"download\"],\"params\":[]},\"calendar_event\":{\"friendly\":\"calendar\\\/event\\\/{#id}-{?}\",\"real\":\"app=calendar&module=calendar&controller=event\",\"verify\":\"\\\\IPS\\\\calendar\\\\Event\",\"without_top_level\":\"event\\\/{#id}-{?}\",\"regex\":[\"calendar\\\\\\\/event\\\\\\\/(\\\\d+?)\\\\-(?!&)(.+?)\",\"event\\\\\\\/(\\\\d+?)\\\\-(?!&)(.+?)\"],\"params\":[\"id\",\"\"]},\"calendar_submit\":{\"friendly\":\"calendar\\\/submit\",\"real\":\"app=calendar&module=calendar&controller=submit\",\"without_top_level\":\"submit\",\"regex\":[\"calendar\\\\\\\/submit\",\"submit\"],\"params\":[]},\"calendar\":{\"friendly\":\"calendar\",\"real\":\"app=calendar&module=calendar&controller=view\",\"without_top_level\":\"\",\"regex\":[\"calendar\"],\"params\":[]},\"chat\":{\"friendly\":\"chat\",\"real\":\"app=chat&module=chat&controller=view\",\"without_top_level\":\"\",\"regex\":[\"chat\"],\"params\":[]},\"downloads_submit\":{\"friendly\":\"files\\\/submit\",\"real\":\"app=downloads&module=downloads&controller=submit\",\"without_top_level\":\"submit\",\"regex\":[\"files\\\\\\\/submit\",\"submit\"],\"params\":[]},\"downloads_cat\":{\"friendly\":\"files\\\/category\\\/{#id}-{?}\",\"real\":\"app=downloads&module=downloads&controller=browse\",\"verify\":\"\\\\IPS\\\\downloads\\\\Category\",\"without_top_level\":\"category\\\/{#id}-{?}\",\"regex\":[\"files\\\\\\\/category\\\\\\\/(\\\\d+?)\\\\-(?!&)(.+?)\",\"category\\\\\\\/(\\\\d+?)\\\\-(?!&)(.+?)\"],\"params\":[\"id\",\"\"]},\"downloads_categories\":{\"friendly\":\"files\\\/categories\",\"real\":\"app=downloads&module=downloads&controller=browse&do=categories\",\"without_top_level\":\"categories\",\"regex\":[\"files\\\\\\\/categories\",\"categories\"],\"params\":[]},\"downloads_file\":{\"friendly\":\"files\\\/file\\\/{#id}-{?}\",\"real\":\"app=downloads&module=downloads&controller=view\",\"verify\":\"\\\\IPS\\\\downloads\\\\File\",\"without_top_level\":\"file\\\/{#id}-{?}\",\"regex\":[\"files\\\\\\\/file\\\\\\\/(\\\\d+?)\\\\-(?!&)(.+?)\",\"file\\\\\\\/(\\\\d+?)\\\\-(?!&)(.+?)\"],\"params\":[\"id\",\"\"]},\"downloads_rss\":{\"friendly\":\"files\\\/files.xml\",\"real\":\"app=downloads&module=downloads&controller=browse&do=rss\",\"without_top_level\":\"files.xml\",\"regex\":[\"files\\\\\\\/files\\\\.xml\",\"files\\\\.xml\"],\"params\":[]},\"downloads\":{\"friendly\":\"files\",\"real\":\"app=downloads&module=downloads&controller=browse\",\"without_top_level\":\"\",\"regex\":[\"files\"],\"params\":[]},\"gallery_category\":{\"friendly\":\"gallery\\\/category\\\/{#category}-{?}\",\"real\":\"app=gallery&module=gallery&controller=browse\",\"verify\":\"\\\\IPS\\\\gallery\\\\Category\",\"without_top_level\":\"category\\\/{#category}-{?}\",\"regex\":[\"gallery\\\\\\\/category\\\\\\\/(\\\\d+?)\\\\-(?!&)(.+?)\",\"category\\\\\\\/(\\\\d+?)\\\\-(?!&)(.+?)\"],\"params\":[\"category\",\"\"]},\"gallery_album\":{\"friendly\":\"gallery\\\/album\\\/{#album}-{?}\",\"real\":\"app=gallery&module=gallery&controller=browse\",\"verify\":\"\\\\IPS\\\\gallery\\\\Album\",\"without_top_level\":\"album\\\/{#album}-{?}\",\"regex\":[\"gallery\\\\\\\/album\\\\\\\/(\\\\d+?)\\\\-(?!&)(.+?)\",\"album\\\\\\\/(\\\\d+?)\\\\-(?!&)(.+?)\"],\"params\":[\"album\",\"\"]},\"gallery_categories\":{\"friendly\":\"gallery\\\/categories\",\"real\":\"app=gallery&module=gallery&controller=browse&do=categories\",\"without_top_level\":\"categories\",\"regex\":[\"gallery\\\\\\\/categories\",\"categories\"],\"params\":[]},\"gallery_rss\":{\"friendly\":\"gallery\\\/images.xml\",\"real\":\"app=gallery&module=gallery&controller=browse&do=rss\",\"without_top_level\":\"images.xml\",\"regex\":[\"gallery\\\\\\\/images\\\\.xml\",\"images\\\\.xml\"],\"params\":[]},\"gallery_image\":{\"friendly\":\"gallery\\\/image\\\/{#id}-{?}\",\"real\":\"app=gallery&module=gallery&controller=view\",\"verify\":\"\\\\IPS\\\\gallery\\\\Image\",\"without_top_level\":\"image\\\/{#id}-{?}\",\"regex\":[\"gallery\\\\\\\/image\\\\\\\/(\\\\d+?)\\\\-(?!&)(.+?)\",\"image\\\\\\\/(\\\\d+?)\\\\-(?!&)(.+?)\"],\"params\":[\"id\",\"\"]},\"gallery_submit\":{\"friendly\":\"gallery\\\/submit\",\"real\":\"app=gallery&module=gallery&controller=submit\",\"without_top_level\":\"submit\",\"regex\":[\"gallery\\\\\\\/submit\",\"submit\"],\"params\":[]},\"gallery\":{\"friendly\":\"gallery\",\"real\":\"app=gallery&module=gallery&controller=browse\",\"without_top_level\":\"\",\"regex\":[\"gallery\"],\"params\":[]},\"nexus_checkout\":{\"friendly\":\"checkout\\\/{#id}\",\"real\":\"app=nexus&module=checkout&controller=checkout\",\"regex\":[\"checkout\\\\\\\/(\\\\d+?)\"],\"params\":[\"id\"]},\"support_create\":{\"friendly\":\"support\\\/create\",\"real\":\"app=nexus&module=support&controller=home&do=create\",\"regex\":[\"support\\\\\\\/create\"],\"params\":[]},\"support_view\":{\"friendly\":\"support\\\/{#id}\",\"real\":\"app=nexus&module=support&controller=view\",\"verify\":\"\\\\IPS\\\\nexus\\\\Support\\\\Request\",\"regex\":[\"support\\\\\\\/(\\\\d+?)\"],\"params\":[\"id\"]},\"support\":{\"friendly\":\"support\",\"real\":\"app=nexus&module=support&controller=home\",\"regex\":[\"support\"],\"params\":[]},\"store_group\":{\"friendly\":\"store\\\/category\\\/{#cat}-{?}\",\"real\":\"app=nexus&module=store&controller=store\",\"verify\":\"\\\\IPS\\\\nexus\\\\Package\\\\Group\",\"regex\":[\"store\\\\\\\/category\\\\\\\/(\\\\d+?)\\\\-(?!&)(.+?)\"],\"params\":[\"cat\",\"\"]},\"store_product\":{\"friendly\":\"store\\\/product\\\/{#id}-{?}\",\"real\":\"app=nexus&module=store&controller=product\",\"verify\":\"\\\\IPS\\\\nexus\\\\Package\\\\Item\",\"regex\":[\"store\\\\\\\/product\\\\\\\/(\\\\d+?)\\\\-(?!&)(.+?)\"],\"params\":[\"id\",\"\"]},\"store_cart\":{\"friendly\":\"store\\\/cart\",\"real\":\"app=nexus&module=store&controller=cart\",\"regex\":[\"store\\\\\\\/cart\"],\"params\":[]},\"store_giftvouchers_redeem\":{\"friendly\":\"store\\\/redeem\",\"real\":\"app=nexus&module=store&controller=gifts&do=redeem\",\"regex\":[\"store\\\\\\\/redeem\"],\"params\":[]},\"store_giftvouchers\":{\"friendly\":\"store\\\/gift-cards\",\"real\":\"app=nexus&module=store&controller=gifts\",\"regex\":[\"store\\\\\\\/gift\\\\-cards\"],\"params\":[]},\"store\":{\"friendly\":\"store\",\"real\":\"app=nexus&module=store&controller=store\",\"regex\":[\"store\"],\"params\":[]},\"clientspurchasecancel\":{\"friendly\":\"clients\\\/purchases\\\/{#id}-{?}\\\/cancel\",\"real\":\"app=nexus&module=clients&controller=purchases&do=cancel\",\"regex\":[\"clients\\\\\\\/purchases\\\\\\\/(\\\\d+?)\\\\-(?!&)(.+?)\\\\\\\/cancel\"],\"params\":[\"id\",\"\"]},\"clientspurchaserenew\":{\"friendly\":\"clients\\\/purchases\\\/{#id}-{?}\\\/renew\",\"real\":\"app=nexus&module=clients&controller=purchases&do=renew\",\"regex\":[\"clients\\\\\\\/purchases\\\\\\\/(\\\\d+?)\\\\-(?!&)(.+?)\\\\\\\/renew\"],\"params\":[\"id\",\"\"]},\"clientspurchaseextra\":{\"friendly\":\"clients\\\/purchases\\\/{#id}-{?}\\\/extra\",\"real\":\"app=nexus&module=clients&controller=purchases&do=extra\",\"regex\":[\"clients\\\\\\\/purchases\\\\\\\/(\\\\d+?)\\\\-(?!&)(.+?)\\\\\\\/extra\"],\"params\":[\"id\",\"\"]},\"clientspurchase\":{\"friendly\":\"clients\\\/purchases\\\/{#id}-{?}\",\"real\":\"app=nexus&module=clients&controller=purchases&do=view\",\"verify\":\"\\\\IPS\\\\nexus\\\\Purchase\",\"regex\":[\"clients\\\\\\\/purchases\\\\\\\/(\\\\d+?)\\\\-(?!&)(.+?)\"],\"params\":[\"id\",\"\"]},\"clientspurchases\":{\"friendly\":\"clients\\\/purchases\",\"real\":\"app=nexus&module=clients&controller=purchases\",\"regex\":[\"clients\\\\\\\/purchases\"],\"params\":[]},\"clientsinvoice\":{\"friendly\":\"clients\\\/orders\\\/{#id}\",\"real\":\"app=nexus&module=clients&controller=invoices&do=view\",\"verify\":\"\\\\IPS\\\\nexus\\\\Invoice\",\"regex\":[\"clients\\\\\\\/orders\\\\\\\/(\\\\d+?)\"],\"params\":[\"id\"]},\"clientsinvoices\":{\"friendly\":\"clients\\\/orders\",\"real\":\"app=nexus&module=clients&controller=invoices\",\"regex\":[\"clients\\\\\\\/orders\"],\"params\":[]},\"clientsaddresses\":{\"friendly\":\"clients\\\/addresses\",\"real\":\"app=nexus&module=clients&controller=addresses\",\"regex\":[\"clients\\\\\\\/addresses\"],\"params\":[]},\"clientscards\":{\"friendly\":\"clients\\\/cards\",\"real\":\"app=nexus&module=clients&controller=cards\",\"regex\":[\"clients\\\\\\\/cards\"],\"params\":[]},\"clientsbillingagreements\":{\"friendly\":\"clients\\\/billing-agreements\",\"real\":\"app=nexus&module=clients&controller=billingagreements\",\"regex\":[\"clients\\\\\\\/billing\\\\-agreements\"],\"params\":[]},\"clientsbillingagreement\":{\"friendly\":\"clients\\\/billing-agreements\\\/{#id}\",\"real\":\"app=nexus&module=clients&controller=billingagreements&do=view\",\"regex\":[\"clients\\\\\\\/billing\\\\-agreements\\\\\\\/(\\\\d+?)\"],\"params\":[\"id\"]},\"clientsalternatives\":{\"friendly\":\"clients\\\/alternative-contacts\",\"real\":\"app=nexus&module=clients&controller=alternatives\",\"regex\":[\"clients\\\\\\\/alternative\\\\-contacts\"],\"params\":[]},\"clientscredit\":{\"friendly\":\"clients\\\/credit\",\"real\":\"app=nexus&module=clients&controller=credit\",\"regex\":[\"clients\\\\\\\/credit\"],\"params\":[]},\"clientsdonate\":{\"friendly\":\"clients\\\/donations\\\/{#id}-{?}\",\"real\":\"app=nexus&module=clients&controller=donations&do=donate\",\"verify\":\"\\\\IPS\\\\nexus\\\\Donation\\\\Goal\",\"regex\":[\"clients\\\\\\\/donations\\\\\\\/(\\\\d+?)\\\\-(?!&)(.+?)\"],\"params\":[\"id\",\"\"]},\"clientsdonations\":{\"friendly\":\"clients\\\/donations\",\"real\":\"app=nexus&module=clients&controller=donations\",\"regex\":[\"clients\\\\\\\/donations\"],\"params\":[]},\"clientsreferrals\":{\"friendly\":\"clients\\\/referrals\",\"real\":\"app=nexus&module=clients&controller=referrals\",\"regex\":[\"clients\\\\\\\/referrals\"],\"params\":[]},\"clientsinfo\":{\"friendly\":\"clients\\\/info\",\"real\":\"app=nexus&module=clients&controller=info\",\"regex\":[\"clients\\\\\\\/info\"],\"params\":[]},\"clients\":{\"friendly\":\"clients\",\"real\":\"app=nexus&module=clients&controller=invoices\",\"regex\":[\"clients\"],\"params\":[]},\"referral\":{\"friendly\":\"refer\\\/{#id}\",\"real\":\"app=nexus&module=promotion&controller=referral\",\"regex\":[\"refer\\\\\\\/(\\\\d+?)\"],\"params\":[\"id\"]},\"nexus_network_status\":{\"friendly\":\"network-status\",\"real\":\"app=nexus&module=clients&controller=networkStatus\",\"regex\":[\"network\\\\-status\"],\"params\":[]}}"
VALUE;
