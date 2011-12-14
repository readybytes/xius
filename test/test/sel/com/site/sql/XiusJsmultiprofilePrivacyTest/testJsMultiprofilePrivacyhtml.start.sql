CREATE TABLE IF NOT EXISTS `bk_#__community_config` LIKE `#__community_config`;;
TRUNCATE TABLE `bk_#__community_config` ;;
INSERT INTO `bk_#__community_config` SELECT * FROM `#__community_config`;;

TRUNCATE TABLE `#__community_profiles`;;
INSERT INTO `#__community_profiles` (`id`, `name`, `description`, `approvals`, `published`, `avatar`, `watermark`, `watermark_hash`, `watermark_location`, `thumb`, `created`, `create_groups`, `create_events`, `ordering`) VALUES
(1, 'mp1', '', 0, 1, '', '', '', '', '', '2011-11-21 13:00:45', 0, 0, 1),
(2, 'mp2', '', 0, 1, '', '', '', '', '', '2011-11-21 13:00:54', 0, 0, 2);;

TRUNCATE TABLE `#__community_config`;;
INSERT INTO `#__community_config` (`name`, `params`) VALUES
('dbversion', '11'),
('config', 'enablegroups=1\nmoderategroupcreation=0\ncreategroups=1\ncreatediscussion=1\ngroupphotos=1\ngroupvideos=1\npoint0=50\npoint1=50\npoint2=100\npoint3=200\npoint4=350\npoint5=600\nwallediting=1\nlockprofilewalls=1\nlockgroupwalls=1\nlockvideoswalls=1\nlockeventwalls=1\nenablephotos=1\nenablepm=1\nnotifyby=1\nsitename=xiussite\nprivacyemail=1\nprivacyemailpm=1\nprivacyapps=1\ndisplayname=name\ntemplate=default\ntask=saveconfig\nview=configuration\noption=com_community\nprivacyprofile=0\nprivacyfriends=0\nprivacyphotos=0\nprivacyvideos=0\nphotomaxwidth=600\noriginalphotopath=originalphotos\narchive_activity_days= 21\ndisplayhome=1\nmaxactivities=20\nshowactivityavatar=1\nenablereporting=1\nmaxReport=50\nenablecustomviewcss=0\nfrontpageusers=20\njsnetwork_path=http://updates.jomsocial.com/index.php?option=com_jsnetwork&view=submit&task=update\ngroupnewseditor=1\nimageengine=auto\ndbversion=1.1\npredefinedreports=Spamming / Advertisement\\nProfanity / Inappropriate content.\\nAbusive.\nactivitiestimeformat=%I:%M %p\nactivitiesdayformat=%b %d\nflashuploader=0\nmaxuploadsize=8\nenablevideos=1\nenableprofilevideo=1\nenablevideosupload=0\nvideosSize=480x360\nvideosThumbSize=112x84\nfrontpagevideos=3\ndeleteoriginalvideos=0\nvideofolder=images\nimagefolder=images\nphotofolder=images\nvideobaseurl=\nimagebaseurl=\nphotobaseurl=\nimagecdnpath=\nvideocdnpath=\nphotocdnpath=\nmaxvideouploadsize=8\nvideodebug=0\nguestsearch=0\nfloodLimit=60\npmperday=30\nsendemailonpageload=0\nshowlatestvideos=1\nshowlatestgroups=1\nshowlatestphotos=1\nshowactivitystream=1\nshowlatestmembers=1\ndaylightsavingoffset=0\nsingularnumber=1\nusepackedjavascript=0\nfolderpermissionsphoto=0755\nfolderpermissionsvideo=0755\niphoneactivitiesapps=photos,groups,profile,walls\nsessionexpiryperiod=600\nactivationresetpassword=0\ngroupdiscussnotification=0\ntagboxwidth=150\ntagboxheight=150\nfrontpagephotos=20\nautoalbumcover=1\nenablesharethis=1\nenablekarma=1\nprivacywallcomment=0\nphotouploadlimit=500\nvideouploadlimit=500\ngroupcreatelimit=300\ngroupphotouploadlimit=500\ngroupvideouploadlimit=500\nfbsignupimport=1\nfbwatermark=1\nfbloginimportprofile=1\nfbloginimportavatar=1\nfbconnectupdatestatus=1\nfeatureduserslimit=10\nfeaturedvideoslimit=10\nfeaturedgroupslimit=10\nfeaturedalbumslimit=10\nrecaptcha=0\nprofileDateFormat=%d/%m/%Y\nfrontpagegroups=5\nfrontpageactivitydefault=all\nphotostorage=file\nphotodisplaysize=800\nstorages3bucket=\nstorages3accesskey=\nstorages3secretkey=\nrecaptchatheme=red\nrecaptchalang=en\nhtmlemail=1\nhtmlemailtemplate=html.mail\nvideostorage=file\nshowactivitycontent=1\ntotalemailpercron=150\nenablevideopseudostream=0\nphotosordering=DESC\nrespectactivityprivacy=1\nshowsearch=1\nshowonline=1\nfieldcodestreet=FIELD_ADDRESS\nfieldcodecity=FIELD_CITY\nfieldcodestate=FIELD_STATE\nfieldcodecountry=FIELD_COUNTRY\nalphabetfiltering=1\nenableevents=1\ncreateevents=1\neventcreatelimit=300\neventexportical=1\neventdateformat=%b %d\neventshowampm=1\neventshowmap=1\neventshowtimezone=0\ndeleteoriginalphotos=0\ngroupdiscussionmaxlist=5\nstatusmaxchar=400\nhtmleditor=tinymce\nfbconnectpoststatus=1\nstreamcontentlength=150\nextendeduserinfo=0\nallowhtml=1\nshow_toolbar=1\nactivitydateformat=lapse\nenableguestsearchgroups=1\nenableguestsearchevents=1\nenableguestsearchvideos=1\nuse_youtube_iframe_embed=1\nredirect_login=profile\nrecaptcha_secure=0\nevent_moderation=0\nprofile_deletion=1\ngroup_events=1\nphotos_auto_rotate=1\nevent_nearby_radius=5\nprofile_multiprofile=1\namazon_storageclass=STANDARD\nredirect_logout=frontpage\nfbapps_metatags=0\nfrontpage_latest_events=1\nfrontpage_events_limit=5\nuser_avatar_storage=file\nshow_like_public=1\ngroup_discuss_order=DESC\nlikes_profile=1\nlikes_groups=1\nlikes_events=1\nlikes_photo=1\nlikes_videos=1\nevent_import_ical=1\ntips_desc_length=450\ncustom_activity=1\nprivacy_show_admins=1\nprivacy_search_email=0\nprivacy_groups_list=0\ntags_videos=1\ntags_discussions=1\ntags_groups=1\ntags_events=1\ntags_photos=1\ntags_show_in_stream=1\nantispam_filter=akismet\nantispam_akismet_key=\nantispam_akismet_messages=1\nantispam_akismet_friends=1\nantispam_akismet_walls=1\nantispam_akismet_status=1\nantispam_akismet_discussions=1\nlimit_groups_perday=30\nlimit_photos_perday=30\nlimit_videos_perday=30\nlimit_friends_perday=50\ntoolbar_menutype=jomsocial\ntoolbar_single_itemid=1\nenable_videos_location=1\nenable_photos_location=1\nfacebook_invite_friends=1\nstream_show_map=1\nuser_address_fields=FIELD_ADDRESS,FIELD_CITY,FIELD_STATE,FIELD_ZIPCODE,FIELD_COUNTRY\noutput_image_quality=80\neditors=jomsocial\ncreateannouncement=1\narchive_activity_limit=500\ngroups_avatar_storage=file\nenable_refresh=1\nstream_refresh_interval=30000\nphotospath=/var/www/Joomla_1.5.23/images\nnotifyMaxReport=\nenableguestreporting=0\nenableterms=0\nregistrationTerms=\nrecaptchapublic=\nrecaptchaprivate=\nalloweddomains=\ndenieddomains=\nnewtab=0\nallmemberactivitycomment=0\ncopyrightemail=Copyright of Your Company\nantispam_enable=0\nphotopaginationlimit=100\nphotosmapdefault=0\nmagickPath=\nvideosmapdefault=0\nffmpegPath=\nflvtool2=\nqscale=11\ncustomCommandForVideo=\nenable_zencoder=0\nzencoder_api_key=\ndefaultpoint=0\nshow_featured=0\netype_groups_notify_admin=1\netype_user_profile_delete=1\netype_system_reports_threshold=0\netype_profile_status_update=1\netype_friends_request_connection=0\netype_friends_create_connection=1\netype_inbox_create_message=1\netype_groups_invite=1\netype_groups_discussion_reply=1\netype_groups_wall_create=1\netype_groups_create_discussion=1\netype_groups_create_news=1\netype_groups_create_album=0\netype_groups_create_video=0\netype_groups_create_event=0\netype_groups_sendmail=1\netype_groups_member_approved=1\netype_groups_member_join=1\netype_groups_notify_creator=1\netype_events_invite=1\netype_events_invitation_approved=1\netype_events_sendmail=1\netype_events_notify_admin=1\netype_videos_submit_wall=1\netype_photos_submit_wall=1\netype_photos_tagging=1\netype_system_bookmarks_email=1\netype_system_messaging=1\nnetwork_enable=0\nnetwork_description=Joomla! - the dynamic portal engine and content management system\nnetwork_keywords=joomla, Joomla\nnetwork_join_url=http://localhost/xius8681/index.php?option=com_community&view=register&Itemid=53\nnetwork_cron_freq=24\nnetwork_cron_last_run=0\nfbconnectkey=\nfbconnectsecret=\namazon_storage_class=STANDARD\nenablemyblogicon=0\n\n');;
