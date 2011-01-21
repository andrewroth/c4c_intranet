CREATE TABLE `08_staff_survey` (
  `survey_id` int(10) NOT NULL auto_increment,
  `survey_name` varchar(128) NOT NULL default '',
  `survey_email` varchar(128) NOT NULL default '',
  PRIMARY KEY  (`survey_id`)
) ENGINE=MyISAM AUTO_INCREMENT=115 DEFAULT CHARSET=latin1;

CREATE TABLE `accountadmin_accesscategory` (
  `accesscategory_id` int(11) NOT NULL auto_increment,
  `accesscategory_key` varchar(50) NOT NULL default '',
  `english_value` text,
  PRIMARY KEY  (`accesscategory_id`),
  KEY `ciministry.accountadmin_accesscategory_accesscateg` (`accesscategory_key`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

CREATE TABLE `accountadmin_accessgroup` (
  `accessgroup_id` int(11) NOT NULL auto_increment,
  `accesscategory_id` int(11) NOT NULL default '0',
  `accessgroup_key` varchar(50) NOT NULL default '',
  `english_value` text,
  PRIMARY KEY  (`accessgroup_id`),
  KEY `ciministry.accountadmin_accessgroup_accessgroup_ke` (`accessgroup_key`)
) ENGINE=MyISAM AUTO_INCREMENT=53 DEFAULT CHARSET=latin1;

CREATE TABLE `accountadmin_accountadminaccess` (
  `accountadminaccess_id` int(11) NOT NULL auto_increment,
  `viewer_id` int(11) NOT NULL default '0',
  `accountadminaccess_privilege` int(1) NOT NULL default '0',
  PRIMARY KEY  (`accountadminaccess_id`),
  KEY `ciministry.accountadmin_accountadminaccess_viewer_` (`viewer_id`),
  KEY `ciministry.accountadmin_accountadminaccess_account` (`accountadminaccess_privilege`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

CREATE TABLE `accountadmin_accountgroup` (
  `accountgroup_id` int(11) NOT NULL auto_increment,
  `accountgroup_key` varchar(50) NOT NULL default '',
  `accountgroup_label_long` varchar(50) NOT NULL default '',
  `english_value` text,
  PRIMARY KEY  (`accountgroup_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

CREATE TABLE `accountadmin_language` (
  `language_id` int(11) NOT NULL auto_increment,
  `language_key` varchar(25) NOT NULL default '',
  `language_code` char(2) NOT NULL default '',
  `english_value` text,
  PRIMARY KEY  (`language_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

CREATE TABLE `accountadmin_viewer` (
  `viewer_id` int(11) NOT NULL auto_increment,
  `guid` varchar(64) default '',
  `accountgroup_id` int(11) NOT NULL default '0',
  `viewer_userID` varchar(50) NOT NULL default '',
  `viewer_passWord` varchar(50) default '',
  `language_id` int(11) NOT NULL default '0',
  `viewer_isActive` int(1) NOT NULL default '0',
  `viewer_lastLogin` datetime default NULL,
  `remember_token` varchar(255) default NULL,
  `remember_token_expires_at` datetime default NULL,
  `email_validated` tinyint(1) default NULL,
  `developer` tinyint(1) default NULL,
  `facebook_hash` varchar(255) default NULL,
  `facebook_username` varchar(255) default NULL,
  PRIMARY KEY  (`viewer_id`),
  KEY `ciministry.accountadmin_viewer_accountgroup_id_index` (`accountgroup_id`),
  KEY `ciministry.accountadmin_viewer_viewer_userID_index` (`viewer_userID`)
) ENGINE=InnoDB AUTO_INCREMENT=12468 DEFAULT CHARSET=latin1;

CREATE TABLE `accountadmin_vieweraccessgroup` (
  `vieweraccessgroup_id` int(11) NOT NULL auto_increment,
  `viewer_id` int(11) NOT NULL default '0',
  `accessgroup_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`vieweraccessgroup_id`),
  KEY `ciministry.accountadmin_vieweraccessgroup_viewer_i` (`viewer_id`),
  KEY `ciministry.accountadmin_vieweraccessgroup_accessgr` (`accessgroup_id`)
) ENGINE=MyISAM AUTO_INCREMENT=26105 DEFAULT CHARSET=latin1;

CREATE TABLE `aia_greycup` (
  `registration_id` int(10) NOT NULL,
  `num_tickets` int(5) NOT NULL default '0',
  `to_survey` int(1) NOT NULL default '0',
  PRIMARY KEY  (`registration_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

CREATE TABLE `cim_c4cwebsite_page` (
  `page_id` int(8) NOT NULL auto_increment,
  `page_parentID` int(8) NOT NULL default '0',
  `page_breadcrumbTitle` varchar(64) NOT NULL default '',
  `page_templateName` varchar(128) NOT NULL default '',
  `page_link` varchar(128) NOT NULL default '',
  `page_order` int(8) NOT NULL default '0',
  `page_keywords` text NOT NULL,
  PRIMARY KEY  (`page_id`)
) ENGINE=MyISAM AUTO_INCREMENT=193 DEFAULT CHARSET=latin1;

CREATE TABLE `cim_c4cwebsite_projects` (
  `projects_id` int(10) NOT NULL auto_increment,
  `projects_desc` varchar(50) NOT NULL default '',
  `project_website` varchar(200) default NULL,
  `project_name` varchar(50) default NULL,
  PRIMARY KEY  (`projects_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

CREATE TABLE `cim_downhere` (
  `dh_id` int(16) NOT NULL auto_increment,
  `cctransaction_cardName` varchar(64) NOT NULL default '',
  `cctype_id` int(16) NOT NULL default '0',
  `cctransaction_cardNum` varchar(64) NOT NULL default '',
  `cctransaction_expiry` varchar(64) NOT NULL default '',
  `cctransaction_billingPC` varchar(64) NOT NULL default '',
  `cctransaction_processed` int(16) NOT NULL default '0',
  `dh_name` varchar(128) NOT NULL default '',
  `dh_email` varchar(128) NOT NULL default '',
  `dh_phone` varchar(128) NOT NULL default '',
  `dh_numTickets` int(16) NOT NULL default '0',
  `dh_church` varchar(128) NOT NULL default '',
  PRIMARY KEY  (`dh_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

CREATE TABLE `cim_hrdb_access` (
  `access_id` int(50) NOT NULL auto_increment,
  `viewer_id` int(50) NOT NULL default '0',
  `person_id` int(50) NOT NULL default '0',
  PRIMARY KEY  (`access_id`),
  KEY `ciministry.cim_hrdb_access_viewer_id_index` (`viewer_id`),
  KEY `ciministry.cim_hrdb_access_person_id_index` (`person_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12227 DEFAULT CHARSET=latin1;

CREATE TABLE `cim_hrdb_activityschedule` (
  `activityschedule_id` int(15) NOT NULL auto_increment,
  `staffactivity_id` int(15) NOT NULL default '0',
  `staffschedule_id` int(15) NOT NULL default '0',
  PRIMARY KEY  (`activityschedule_id`),
  KEY `FK_activity_schedule` (`staffschedule_id`),
  KEY `FK_schedule_activity` (`staffactivity_id`)
) ENGINE=InnoDB AUTO_INCREMENT=815 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

CREATE TABLE `cim_hrdb_activitytype` (
  `activitytype_id` int(10) NOT NULL auto_increment,
  `activitytype_desc` varchar(75) collate latin1_general_ci NOT NULL default '',
  `activitytype_abbr` varchar(6) collate latin1_general_ci NOT NULL,
  `activitytype_color` varchar(7) collate latin1_general_ci NOT NULL default '#0000FF',
  PRIMARY KEY  (`activitytype_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

CREATE TABLE `cim_hrdb_admin` (
  `admin_id` int(1) NOT NULL auto_increment,
  `person_id` int(50) NOT NULL default '0',
  `priv_id` int(20) NOT NULL default '0',
  PRIMARY KEY  (`admin_id`),
  KEY `FK_hrdbadmin_person` (`person_id`),
  KEY `FK_admin_priv` (`priv_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

CREATE TABLE `cim_hrdb_assignment` (
  `assignment_id` int(50) NOT NULL auto_increment,
  `person_id` int(50) NOT NULL default '0',
  `campus_id` int(50) NOT NULL default '0',
  `assignmentstatus_id` int(10) NOT NULL default '0',
  PRIMARY KEY  (`assignment_id`),
  KEY `ciministry.cim_hrdb_assignment_person_id_index` (`person_id`),
  KEY `ciministry.cim_hrdb_assignment_campus_id_index` (`campus_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8491 DEFAULT CHARSET=latin1;

CREATE TABLE `cim_hrdb_assignmentstatus` (
  `assignmentstatus_id` int(10) NOT NULL auto_increment,
  `assignmentstatus_desc` varchar(64) collate latin1_general_ci NOT NULL default '',
  PRIMARY KEY  (`assignmentstatus_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

CREATE TABLE `cim_hrdb_campus` (
  `campus_id` int(50) NOT NULL auto_increment,
  `campus_desc` varchar(128) NOT NULL default '',
  `campus_shortDesc` varchar(50) NOT NULL default '',
  `accountgroup_id` int(16) NOT NULL default '0',
  `region_id` int(8) NOT NULL default '0',
  `campus_website` varchar(128) NOT NULL default '',
  `campus_facebookgroup` varchar(128) NOT NULL,
  `campus_gcxnamespace` varchar(128) NOT NULL,
  `province_id` int(11) default NULL,
  PRIMARY KEY  (`campus_id`),
  KEY `ciministry.cim_hrdb_campus_region_id_index` (`region_id`),
  KEY `ciministry.cim_hrdb_campus_accountgroup_id_index` (`accountgroup_id`)
) ENGINE=InnoDB AUTO_INCREMENT=142 DEFAULT CHARSET=latin1;

CREATE TABLE `cim_hrdb_campusadmin` (
  `campusadmin_id` int(20) NOT NULL auto_increment,
  `admin_id` int(20) NOT NULL default '0',
  `campus_id` int(20) NOT NULL default '0',
  PRIMARY KEY  (`campusadmin_id`),
  KEY `ciministry.cim_hrdb_campusadmin_admin_id_index` (`admin_id`),
  KEY `ciministry.cim_hrdb_campusadmin_campus_id_index` (`campus_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `cim_hrdb_country` (
  `country_id` int(50) NOT NULL auto_increment,
  `country_desc` varchar(50) collate latin1_general_ci NOT NULL default '',
  `country_shortDesc` varchar(50) collate latin1_general_ci NOT NULL default '',
  PRIMARY KEY  (`country_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

CREATE TABLE `cim_hrdb_customfields` (
  `customfields_id` int(16) unsigned NOT NULL auto_increment,
  `report_id` int(10) unsigned NOT NULL,
  `fields_id` int(16) NOT NULL,
  PRIMARY KEY  (`customfields_id`),
  KEY `FK_fields_report` (`report_id`),
  KEY `FK_report_field` (`fields_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

CREATE TABLE `cim_hrdb_customreports` (
  `report_id` int(10) unsigned NOT NULL auto_increment,
  `report_name` varchar(64) collate latin1_general_ci NOT NULL,
  `report_is_shown` int(1) NOT NULL default '0',
  PRIMARY KEY  (`report_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

CREATE TABLE `cim_hrdb_emerg` (
  `emerg_id` int(16) NOT NULL auto_increment,
  `person_id` int(16) NOT NULL default '0',
  `emerg_passportNum` varchar(32) NOT NULL default '',
  `emerg_passportOrigin` varchar(32) NOT NULL default '',
  `emerg_passportExpiry` date NOT NULL default '0000-00-00',
  `emerg_contactName` varchar(64) NOT NULL default '',
  `emerg_contactRship` varchar(64) NOT NULL default '',
  `emerg_contactHome` varchar(32) NOT NULL default '',
  `emerg_contactWork` varchar(32) NOT NULL default '',
  `emerg_contactMobile` varchar(32) NOT NULL default '',
  `emerg_contactEmail` varchar(32) NOT NULL default '',
  `emerg_birthdate` date NOT NULL default '0000-00-00',
  `emerg_medicalNotes` text NOT NULL,
  `emerg_contact2Name` varchar(64) NOT NULL,
  `emerg_contact2Rship` varchar(64) NOT NULL,
  `emerg_contact2Home` varchar(64) NOT NULL,
  `emerg_contact2Work` varchar(64) NOT NULL,
  `emerg_contact2Mobile` varchar(64) NOT NULL,
  `emerg_contact2Email` varchar(64) NOT NULL,
  `emerg_meds` text NOT NULL,
  `health_province_id` int(11) default NULL,
  `health_number` varchar(255) default NULL,
  `medical_plan_number` varchar(255) default NULL,
  `medical_plan_carrier` varchar(255) default NULL,
  `doctor_name` varchar(255) default NULL,
  `doctor_phone` varchar(255) default NULL,
  `dentist_name` varchar(255) default NULL,
  `dentist_phone` varchar(255) default NULL,
  `blood_type` varchar(255) default NULL,
  `blood_rh_factor` varchar(255) default NULL,
  PRIMARY KEY  (`emerg_id`),
  KEY `ciministry.cim_hrdb_emerg_person_id_index` (`person_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5570 DEFAULT CHARSET=latin1;

CREATE TABLE `cim_hrdb_fieldgroup` (
  `fieldgroup_id` int(10) NOT NULL auto_increment,
  `fieldgroup_desc` varchar(75) collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`fieldgroup_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

CREATE TABLE `cim_hrdb_fieldgroup_matches` (
  `fieldgroup_matches_id` int(20) NOT NULL auto_increment,
  `fieldgroup_id` int(10) NOT NULL default '0',
  `fields_id` int(16) NOT NULL default '0',
  PRIMARY KEY  (`fieldgroup_matches_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

CREATE TABLE `cim_hrdb_fields` (
  `fields_id` int(16) NOT NULL auto_increment,
  `fieldtype_id` int(16) NOT NULL default '0',
  `fields_desc` text NOT NULL,
  `staffscheduletype_id` int(15) NOT NULL default '0',
  `fields_priority` int(16) NOT NULL default '0',
  `fields_reqd` int(8) NOT NULL default '0',
  `fields_invalid` varchar(128) NOT NULL default '',
  `fields_hidden` int(8) NOT NULL default '0',
  `datatypes_id` int(4) NOT NULL default '0',
  `fieldgroup_id` int(10) NOT NULL default '0',
  `fields_note` varchar(75) NOT NULL,
  PRIMARY KEY  (`fields_id`),
  KEY `FK_fields_types2` (`fieldtype_id`),
  KEY `FK_fields_form` (`staffscheduletype_id`),
  KEY `FK_fields_dtype2` (`datatypes_id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=latin1;

CREATE TABLE `cim_hrdb_fieldvalues` (
  `fieldvalues_id` int(16) NOT NULL auto_increment,
  `fields_id` int(16) NOT NULL default '0',
  `fieldvalues_value` text NOT NULL,
  `person_id` int(16) NOT NULL default '0',
  `fieldvalues_modTime` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`fieldvalues_id`),
  KEY `FK_fieldvals_person` (`person_id`),
  KEY `FK_fieldvals_field2` (`fields_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1839 DEFAULT CHARSET=latin1;

CREATE TABLE `cim_hrdb_gender` (
  `gender_id` int(50) NOT NULL auto_increment,
  `gender_desc` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`gender_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

CREATE TABLE `cim_hrdb_ministry` (
  `ministry_id` int(20) unsigned NOT NULL auto_increment,
  `ministry_name` varchar(64) collate latin1_general_ci NOT NULL,
  `ministry_abbrev` varchar(16) collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`ministry_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

CREATE TABLE `cim_hrdb_person` (
  `person_id` int(50) NOT NULL auto_increment,
  `person_fname` varchar(50) NOT NULL default '',
  `person_lname` varchar(50) NOT NULL default '',
  `person_legal_fname` varchar(50) NOT NULL,
  `person_legal_lname` varchar(50) NOT NULL,
  `person_phone` varchar(50) NOT NULL default '',
  `person_email` varchar(128) NOT NULL default '',
  `person_addr` varchar(128) NOT NULL default '',
  `person_city` varchar(50) NOT NULL default '',
  `province_id` int(50) NOT NULL default '0',
  `person_pc` varchar(50) NOT NULL default '',
  `gender_id` int(50) NOT NULL default '0',
  `person_local_phone` varchar(50) NOT NULL default '',
  `person_local_addr` varchar(128) NOT NULL default '',
  `person_local_city` varchar(50) NOT NULL default '',
  `person_local_pc` varchar(50) NOT NULL default '',
  `person_local_province_id` int(50) NOT NULL default '0',
  `cell_phone` varchar(255) default NULL,
  `local_valid_until` date default NULL,
  `title_id` int(11) default NULL,
  `country_id` int(11) default NULL,
  `person_local_country_id` int(11) default NULL,
  `person_mname` varchar(255) default NULL,
  `person_mentor_id` int(11) default '0',
  PRIMARY KEY  (`person_id`),
  KEY `ciministry.cim_hrdb_person_gender_id_index` (`gender_id`),
  KEY `ciministry.cim_hrdb_person_province_id_index` (`province_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1295298510 DEFAULT CHARSET=latin1;

CREATE TABLE `cim_hrdb_person_year` (
  `personyear_id` int(50) NOT NULL auto_increment,
  `person_id` int(50) NOT NULL default '0',
  `year_id` int(50) NOT NULL default '0',
  `grad_date` date default '0000-00-00',
  PRIMARY KEY  (`personyear_id`),
  KEY `FK_cim_hrdb_person_year` (`person_id`),
  KEY `1` (`year_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3109 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

CREATE TABLE `cim_hrdb_priv` (
  `priv_id` int(20) NOT NULL auto_increment,
  `priv_accesslevel` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`priv_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

CREATE TABLE `cim_hrdb_province` (
  `province_id` int(50) NOT NULL auto_increment,
  `province_desc` varchar(50) NOT NULL default '',
  `province_shortDesc` varchar(50) NOT NULL default '',
  `country_id` int(11) default NULL,
  PRIMARY KEY  (`province_id`)
) ENGINE=MyISAM AUTO_INCREMENT=77 DEFAULT CHARSET=latin1;

CREATE TABLE `cim_hrdb_region` (
  `region_id` int(50) NOT NULL auto_increment,
  `reg_desc` varchar(64) NOT NULL default '',
  `country_id` int(50) NOT NULL default '0',
  PRIMARY KEY  (`region_id`),
  KEY `FK_region_country` (`country_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

CREATE TABLE `cim_hrdb_staff` (
  `staff_id` int(50) NOT NULL auto_increment,
  `person_id` int(50) NOT NULL default '0',
  `is_active` int(1) NOT NULL default '1',
  PRIMARY KEY  (`staff_id`),
  UNIQUE KEY `unique_person` (`person_id`),
  KEY `ciministry.cim_hrdb_staff_person_id_index` (`person_id`)
) ENGINE=InnoDB AUTO_INCREMENT=389 DEFAULT CHARSET=latin1;

CREATE TABLE `cim_hrdb_staffactivity` (
  `staffactivity_id` int(15) NOT NULL auto_increment,
  `person_id` int(50) NOT NULL default '0',
  `staffactivity_startdate` date NOT NULL default '0000-00-00',
  `staffactivity_enddate` date NOT NULL default '0000-00-00',
  `staffactivity_contactPhone` varchar(20) collate latin1_general_ci NOT NULL,
  `activitytype_id` int(10) NOT NULL default '0',
  PRIMARY KEY  (`staffactivity_id`),
  KEY `FK_activity_type` (`activitytype_id`),
  KEY `FK_activity_person` (`person_id`)
) ENGINE=InnoDB AUTO_INCREMENT=818 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

CREATE TABLE `cim_hrdb_staffdirector` (
  `staffdirector_id` int(60) unsigned NOT NULL auto_increment,
  `staff_id` int(50) NOT NULL,
  `director_id` int(50) NOT NULL,
  PRIMARY KEY  (`staffdirector_id`),
  KEY `FK_director_staff` (`director_id`),
  KEY `FK_staff_staff1` (`staff_id`)
) ENGINE=InnoDB AUTO_INCREMENT=234 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

CREATE TABLE `cim_hrdb_staffschedule` (
  `staffschedule_id` int(15) NOT NULL auto_increment,
  `person_id` int(50) NOT NULL default '0',
  `staffscheduletype_id` int(15) NOT NULL default '0',
  `staffschedule_approved` int(2) NOT NULL default '0',
  `staffschedule_approvedby` int(50) NOT NULL default '0',
  `staffschedule_lastmodifiedbydirector` timestamp NOT NULL default '0000-00-00 00:00:00',
  `staffschedule_approvalnotes` text collate latin1_general_ci NOT NULL,
  `staffschedule_tonotify` int(2) NOT NULL default '0',
  PRIMARY KEY  (`staffschedule_id`),
  KEY `FK_schedule_type` (`staffscheduletype_id`),
  KEY `FK_schedule_person1` (`person_id`)
) ENGINE=InnoDB AUTO_INCREMENT=202 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

CREATE TABLE `cim_hrdb_staffscheduleinstr` (
  `staffscheduletype_id` int(15) NOT NULL,
  `staffscheduleinstr_toptext` text collate latin1_general_ci NOT NULL,
  `staffscheduleinstr_bottomtext` text collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`staffscheduletype_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

CREATE TABLE `cim_hrdb_staffscheduletype` (
  `staffscheduletype_id` int(15) NOT NULL auto_increment,
  `staffscheduletype_desc` varchar(75) collate latin1_general_ci NOT NULL,
  `staffscheduletype_startdate` date NOT NULL default '0000-00-00',
  `staffscheduletype_enddate` date NOT NULL default '0000-00-00',
  `staffscheduletype_has_activities` int(2) NOT NULL default '1',
  `staffscheduletype_has_activity_phone` int(2) NOT NULL default '0',
  `staffscheduletype_activity_types` varchar(25) collate latin1_general_ci NOT NULL,
  `staffscheduletype_is_shown` int(2) NOT NULL default '0',
  PRIMARY KEY  (`staffscheduletype_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

CREATE TABLE `cim_hrdb_title` (
  `id` int(11) NOT NULL auto_increment,
  `desc` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

CREATE TABLE `cim_hrdb_year_in_school` (
  `year_id` int(11) NOT NULL auto_increment,
  `year_desc` char(50) NOT NULL default '',
  `position` int(11) default NULL,
  PRIMARY KEY  (`year_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

CREATE TABLE `cim_reg_activerules` (
  `pricerules_id` int(16) NOT NULL default '0',
  `is_active` int(1) NOT NULL default '0',
  `is_recalculated` int(1) NOT NULL default '1',
  PRIMARY KEY  (`pricerules_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `cim_reg_campusaccess` (
  `campusaccess_id` int(16) NOT NULL auto_increment,
  `eventadmin_id` int(16) NOT NULL default '0',
  `campus_id` int(16) NOT NULL default '0',
  PRIMARY KEY  (`campusaccess_id`)
) ENGINE=MyISAM AUTO_INCREMENT=217 DEFAULT CHARSET=latin1;

CREATE TABLE `cim_reg_cashtransaction` (
  `cashtransaction_id` int(16) NOT NULL auto_increment,
  `reg_id` int(16) NOT NULL default '0',
  `cashtransaction_staffName` varchar(64) NOT NULL default '',
  `cashtransaction_recd` int(8) NOT NULL default '0',
  `cashtransaction_amtPaid` float NOT NULL default '0',
  `cashtransaction_moddate` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`cashtransaction_id`),
  KEY `FK_cashtrans_reg` (`reg_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4821 DEFAULT CHARSET=latin1;

CREATE TABLE `cim_reg_ccreceipt` (
  `ccreceipt_sequencenum` varchar(18) NOT NULL,
  `ccreceipt_authcode` varchar(8) default NULL,
  `ccreceipt_responsecode` char(3) NOT NULL default '',
  `ccreceipt_message` varchar(100) NOT NULL default '',
  `ccreceipt_moddate` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `cctransaction_id` int(10) NOT NULL default '0',
  PRIMARY KEY  (`cctransaction_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `cim_reg_cctransaction` (
  `cctransaction_id` int(16) NOT NULL auto_increment,
  `reg_id` int(16) NOT NULL default '0',
  `cctransaction_cardName` varchar(64) NOT NULL default '',
  `cctype_id` int(16) NOT NULL default '0',
  `cctransaction_cardNum` text NOT NULL,
  `cctransaction_expiry` varchar(64) NOT NULL default '',
  `cctransaction_billingPC` varchar(64) NOT NULL default '',
  `cctransaction_processed` int(16) NOT NULL default '0',
  `cctransaction_amount` float NOT NULL default '0',
  `cctransaction_moddate` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `cctransaction_refnum` varchar(255) default NULL,
  PRIMARY KEY  (`cctransaction_id`),
  KEY `FK_cctrans_reg` (`reg_id`),
  KEY `FK_cctrans_ccid` (`cctype_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5177 DEFAULT CHARSET=latin1;

CREATE TABLE `cim_reg_cctype` (
  `cctype_id` int(16) NOT NULL auto_increment,
  `cctype_desc` varchar(32) NOT NULL default '',
  PRIMARY KEY  (`cctype_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

CREATE TABLE `cim_reg_datatypes` (
  `datatypes_id` int(4) NOT NULL auto_increment,
  `datatypes_key` varchar(8) collate latin1_general_ci NOT NULL default '',
  `datatypes_desc` varchar(64) collate latin1_general_ci NOT NULL default '',
  PRIMARY KEY  (`datatypes_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

CREATE TABLE `cim_reg_event` (
  `event_id` int(50) NOT NULL auto_increment,
  `country_id` int(50) NOT NULL default '0',
  `ministry_id` int(20) unsigned NOT NULL default '0',
  `event_name` varchar(128) character set latin1 NOT NULL default '',
  `event_descBrief` varchar(128) character set latin1 NOT NULL default '',
  `event_descDetail` text character set latin1 NOT NULL,
  `event_startDate` datetime NOT NULL default '0000-00-00 00:00:00',
  `event_endDate` datetime NOT NULL default '0000-00-00 00:00:00',
  `event_regStart` datetime NOT NULL default '0000-00-00 00:00:00',
  `event_regEnd` datetime NOT NULL default '0000-00-00 00:00:00',
  `event_website` varchar(128) character set latin1 NOT NULL default '',
  `event_emailConfirmText` text character set latin1 NOT NULL,
  `event_basePrice` float NOT NULL default '0',
  `event_deposit` float NOT NULL default '0',
  `event_contactEmail` text character set latin1 NOT NULL,
  `event_pricingText` text character set latin1 NOT NULL,
  `event_onHomePage` int(1) NOT NULL default '1',
  `event_allowCash` int(1) NOT NULL default '0',
  PRIMARY KEY  (`event_id`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8;

CREATE TABLE `cim_reg_eventadmin` (
  `eventadmin_id` int(16) NOT NULL auto_increment,
  `event_id` int(16) NOT NULL default '0',
  `priv_id` int(16) NOT NULL default '0',
  `viewer_id` int(16) NOT NULL default '0',
  PRIMARY KEY  (`eventadmin_id`),
  KEY `FK_admin_event` (`event_id`),
  KEY `FK_admin_viewer` (`viewer_id`),
  KEY `FK_evadmin_priv` (`priv_id`)
) ENGINE=InnoDB AUTO_INCREMENT=404 DEFAULT CHARSET=latin1;

CREATE TABLE `cim_reg_fields` (
  `fields_id` int(16) NOT NULL auto_increment,
  `fieldtype_id` int(16) NOT NULL default '0',
  `fields_desc` text NOT NULL,
  `event_id` int(16) NOT NULL default '0',
  `fields_priority` int(16) NOT NULL default '0',
  `fields_reqd` int(8) NOT NULL default '0',
  `fields_invalid` varchar(128) NOT NULL default '',
  `fields_hidden` int(8) NOT NULL default '0',
  `datatypes_id` int(4) NOT NULL default '0',
  PRIMARY KEY  (`fields_id`),
  KEY `FK_fields_types` (`fieldtype_id`),
  KEY `FK_fields_event` (`event_id`),
  KEY `FK_fields_dtype` (`datatypes_id`)
) ENGINE=InnoDB AUTO_INCREMENT=216 DEFAULT CHARSET=latin1;

CREATE TABLE `cim_reg_fieldtypes` (
  `fieldtypes_id` int(16) NOT NULL auto_increment,
  `fieldtypes_desc` varchar(128) NOT NULL default '',
  PRIMARY KEY  (`fieldtypes_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

CREATE TABLE `cim_reg_fieldvalues` (
  `fieldvalues_id` int(16) NOT NULL auto_increment,
  `fields_id` int(16) NOT NULL default '0',
  `fieldvalues_value` text NOT NULL,
  `registration_id` int(16) NOT NULL default '0',
  `fieldvalues_modTime` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`fieldvalues_id`),
  KEY `FK_fieldvals_reg` (`registration_id`),
  KEY `FK_fieldvals_field` (`fields_id`)
) ENGINE=InnoDB AUTO_INCREMENT=45881 DEFAULT CHARSET=latin1;

CREATE TABLE `cim_reg_pricerules` (
  `pricerules_id` int(16) NOT NULL auto_increment,
  `event_id` int(16) NOT NULL default '0',
  `priceruletypes_id` int(16) NOT NULL default '0',
  `pricerules_desc` text NOT NULL,
  `fields_id` int(10) NOT NULL default '0',
  `pricerules_value` varchar(128) NOT NULL default '',
  `pricerules_discount` float NOT NULL default '0',
  PRIMARY KEY  (`pricerules_id`),
  KEY `FK_prules_event` (`event_id`),
  KEY `FK_prules_type` (`priceruletypes_id`)
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=latin1;

CREATE TABLE `cim_reg_priceruletypes` (
  `priceruletypes_id` int(16) NOT NULL auto_increment,
  `priceruletypes_desc` varchar(128) NOT NULL default '',
  PRIMARY KEY  (`priceruletypes_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

CREATE TABLE `cim_reg_priv` (
  `priv_id` int(10) NOT NULL auto_increment,
  `priv_desc` varchar(64) NOT NULL default '',
  PRIMARY KEY  (`priv_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

CREATE TABLE `cim_reg_registration` (
  `registration_id` int(50) NOT NULL auto_increment,
  `event_id` int(50) NOT NULL default '0',
  `person_id` int(50) NOT NULL default '0',
  `registration_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `registration_confirmNum` varchar(64) NOT NULL default '',
  `registration_status` int(2) NOT NULL default '0',
  `registration_balance` float NOT NULL default '0',
  PRIMARY KEY  (`registration_id`),
  KEY `FK_reg_person` (`person_id`),
  KEY `FK_reg_status` (`registration_status`)
) ENGINE=InnoDB AUTO_INCREMENT=9550 DEFAULT CHARSET=latin1;

CREATE TABLE `cim_reg_scholarship` (
  `scholarship_id` int(16) NOT NULL auto_increment,
  `registration_id` int(16) NOT NULL default '0',
  `scholarship_amount` float NOT NULL default '0',
  `scholarship_sourceAcct` varchar(64) NOT NULL default '',
  `scholarship_sourceDesc` varchar(128) NOT NULL default '',
  PRIMARY KEY  (`scholarship_id`),
  KEY `FK_scholarship_reg` (`registration_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2271 DEFAULT CHARSET=latin1;

CREATE TABLE `cim_reg_status` (
  `status_id` int(10) NOT NULL,
  `status_desc` varchar(32) NOT NULL default '',
  PRIMARY KEY  (`status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `cim_reg_superadmin` (
  `superadmin_id` int(16) NOT NULL auto_increment,
  `viewer_id` int(16) NOT NULL default '0',
  PRIMARY KEY  (`superadmin_id`),
  KEY `FK_viewer_regsuperadmin` (`viewer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

CREATE TABLE `cim_sch_group` (
  `group_id` int(11) NOT NULL auto_increment,
  `groupType_id` int(11) default NULL,
  `group_name` varchar(20) NOT NULL,
  `group_desc` varchar(255) NOT NULL,
  PRIMARY KEY  (`group_id`),
  KEY `FK_group_type` (`groupType_id`)
) ENGINE=InnoDB AUTO_INCREMENT=427 DEFAULT CHARSET=latin1;

CREATE TABLE `cim_sch_groupType` (
  `groupType_id` int(11) NOT NULL auto_increment,
  `groupType_desc` varchar(20) default NULL,
  PRIMARY KEY  (`groupType_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

CREATE TABLE `cim_sch_schedule` (
  `schedule_id` int(11) NOT NULL auto_increment,
  `person_id` int(11) default NULL,
  `timezones_id` int(11) default NULL,
  `schedule_dateTimeStamp` datetime NOT NULL,
  PRIMARY KEY  (`schedule_id`),
  KEY `FK_sched_person` (`person_id`),
  KEY `FK_sched_tzone` (`timezones_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

CREATE TABLE `cim_sch_scheduleBlocks` (
  `scheduleBlocks_id` int(11) NOT NULL auto_increment,
  `schedule_id` int(11) default NULL,
  `scheduleBlocks_timeblock` int(11) default NULL,
  PRIMARY KEY  (`scheduleBlocks_id`),
  KEY `FK_schblock_sched` (`schedule_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

CREATE TABLE `cim_sch_timezones` (
  `timezones_id` int(11) NOT NULL auto_increment,
  `timezones_desc` varchar(32) default NULL,
  `timezones_offset` int(11) default NULL,
  PRIMARY KEY  (`timezones_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

CREATE TABLE `cim_stats_access` (
  `access_id` int(16) NOT NULL auto_increment,
  `staff_id` int(16) NOT NULL default '0',
  `priv_id` int(16) NOT NULL default '0',
  PRIMARY KEY  (`access_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `cim_stats_annualgoalsreport` (
  `annualGoalsReport_id` int(11) NOT NULL auto_increment,
  `campus_id` int(11) default NULL,
  `year_id` int(11) default NULL,
  `annualGoalsReport_studInMin` int(11) default '0',
  `annualGoalsReport_sptMulti` int(11) default '0',
  `annualGoalsReport_firstYears` int(11) default '0',
  `annualGoalsReport_summitWent` int(11) default '0',
  `annualGoalsReport_wcWent` int(11) default '0',
  `annualGoalsReport_projWent` int(11) default '0',
  `annualGoalsReport_spConvTotal` int(11) default '0',
  `annualGoalsReport_gosPresTotal` int(11) default '0',
  `annualGoalsReport_hsPresTotal` int(11) default '0',
  `annualGoalsReport_prcTotal` int(11) default '0',
  `annualGoalsReport_integBelievers` int(11) default '0',
  `annualGoalsReport_lrgEventAttend` int(11) default '0',
  PRIMARY KEY  (`annualGoalsReport_id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

CREATE TABLE `cim_stats_annualreport` (
  `annualReport_id` int(11) NOT NULL auto_increment,
  `campus_id` int(11) default NULL,
  `year_id` int(11) default NULL,
  `annualReport_lnz_avgPrayer` int(11) default '0',
  `annualReport_lnz_numFrosh` int(11) default '0',
  `annualReport_lnz_totalStudentInDG` int(11) default '0',
  `annualReport_lnz_totalSpMult` int(11) default '0',
  `annualReport_lnz_totalCoreStudents` int(11) default '0',
  `annualreport_lnz_p2c_numInEvangStudies` int(11) default '0',
  `annualreport_lnz_p2c_numSharingInP2c` int(11) default '0',
  `annualreport_lnz_p2c_numSharingOutP2c` int(11) default '0',
  PRIMARY KEY  (`annualReport_id`)
) ENGINE=InnoDB AUTO_INCREMENT=107 DEFAULT CHARSET=latin1;

CREATE TABLE `cim_stats_coordinator` (
  `coordinator_id` int(16) NOT NULL auto_increment,
  `access_id` int(16) NOT NULL default '0',
  `campus_id` int(16) NOT NULL default '0',
  PRIMARY KEY  (`coordinator_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `cim_stats_exposuretype` (
  `exposuretype_id` int(10) NOT NULL auto_increment,
  `exposuretype_desc` varchar(64) NOT NULL default '',
  PRIMARY KEY  (`exposuretype_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

CREATE TABLE `cim_stats_month` (
  `month_id` int(10) NOT NULL auto_increment,
  `month_desc` varchar(64) NOT NULL default '',
  `month_number` int(8) NOT NULL default '0',
  `year_id` int(10) NOT NULL default '0',
  `month_calendaryear` int(10) NOT NULL,
  `semester_id` int(10) default NULL,
  PRIMARY KEY  (`month_id`)
) ENGINE=MyISAM AUTO_INCREMENT=121 DEFAULT CHARSET=latin1;

CREATE TABLE `cim_stats_monthlyreport` (
  `monthlyreport_id` int(11) NOT NULL auto_increment,
  `campus_id` int(11) default NULL,
  `month_id` int(11) default NULL,
  `monthlyreport_avgPrayer` int(11) default '0',
  `monthlyreport_numFrosh` int(11) default '0',
  `monthlyreport_eventSpirConversations` int(11) default '0',
  `monthlyreport_eventGospPres` int(11) default '0',
  `monthlyreport_mediaSpirConversations` int(11) default '0',
  `monthlyreport_mediaGospPres` int(11) default '0',
  `monthlyreport_totalCoreStudents` int(11) default '0',
  `monthlyreport_totalStudentInDG` int(11) default '0',
  `monthlyreport_totalSpMult` int(11) default '0',
  `montlyreport_p2c_numInEvangStudies` int(11) default '0',
  `montlyreport_p2c_numTrainedToShareInP2c` int(11) default '0',
  `montlyreport_p2c_numTrainedToShareOutP2c` int(11) default '0',
  `montlyreport_p2c_numSharingInP2c` int(11) default '0',
  `montlyreport_p2c_numSharingOutP2c` int(11) default '0',
  `montlyreport_integratedNewBelievers` int(11) default '0',
  PRIMARY KEY  (`monthlyreport_id`)
) ENGINE=InnoDB AUTO_INCREMENT=279 DEFAULT CHARSET=latin1;

CREATE TABLE `cim_stats_morestats` (
  `morestats_id` int(10) NOT NULL auto_increment,
  `morestats_exp` int(10) NOT NULL default '0',
  `morestats_notes` text NOT NULL,
  `week_id` int(10) NOT NULL default '0',
  `campus_id` int(10) NOT NULL default '0',
  `exposuretype_id` int(10) NOT NULL default '0',
  PRIMARY KEY  (`morestats_id`)
) ENGINE=MyISAM AUTO_INCREMENT=579 DEFAULT CHARSET=latin1;

CREATE TABLE `cim_stats_prc` (
  `prc_id` int(10) NOT NULL auto_increment,
  `prc_firstName` varchar(128) NOT NULL default '',
  `prcMethod_id` int(10) NOT NULL default '0',
  `prc_witnessName` varchar(128) NOT NULL default '',
  `semester_id` int(10) NOT NULL default '0',
  `campus_id` int(10) NOT NULL default '0',
  `prc_notes` text NOT NULL,
  `prc_7upCompleted` int(10) NOT NULL default '0',
  `prc_7upStarted` int(10) NOT NULL default '0',
  `prc_date` date NOT NULL default '0000-00-00',
  PRIMARY KEY  (`prc_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1001 DEFAULT CHARSET=latin1;

CREATE TABLE `cim_stats_prcmethod` (
  `prcMethod_id` int(10) NOT NULL auto_increment,
  `prcMethod_desc` varchar(64) NOT NULL default '',
  PRIMARY KEY  (`prcMethod_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

CREATE TABLE `cim_stats_priv` (
  `priv_id` int(16) NOT NULL auto_increment,
  `priv_desc` varchar(64) NOT NULL default '',
  PRIMARY KEY  (`priv_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

CREATE TABLE `cim_stats_semester` (
  `semester_id` int(10) NOT NULL auto_increment,
  `semester_desc` varchar(64) NOT NULL default '',
  `semester_startDate` date NOT NULL default '0000-00-00',
  `year_id` int(8) NOT NULL default '0',
  PRIMARY KEY  (`semester_id`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;

CREATE TABLE `cim_stats_semesterreport` (
  `semesterreport_id` int(10) NOT NULL auto_increment,
  `semesterreport_avgPrayer` int(10) NOT NULL default '0',
  `semesterreport_avgWklyMtg` int(10) NOT NULL default '0',
  `semesterreport_numStaffChall` int(10) NOT NULL default '0',
  `semesterreport_numInternChall` int(10) NOT NULL default '0',
  `semesterreport_numFrosh` int(10) NOT NULL default '0',
  `semesterreport_numStaffDG` int(10) NOT NULL default '0',
  `semesterreport_numInStaffDG` int(10) NOT NULL default '0',
  `semesterreport_numStudentDG` int(10) NOT NULL default '0',
  `semesterreport_numInStudentDG` int(10) NOT NULL default '0',
  `semesterreport_numSpMultStaffDG` int(10) NOT NULL default '0',
  `semesterreport_numSpMultStdDG` int(10) NOT NULL default '0',
  `semester_id` int(10) NOT NULL default '0',
  `campus_id` int(10) NOT NULL default '0',
  `semesterreport_totalSpMultGradNonMinistry` int(11) default '0',
  `semesterreport_totalFullTimeC4cStaff` int(11) default '0',
  `semesterreport_totalFullTimeP2cStaffNonC4c` int(11) default '0',
  `semesterreport_totalPeopleOneYearInternship` int(11) default '0',
  `semesterreport_totalPeopleOtherMinistry` int(11) default '0',
  `semesterreport_studentsSummit` int(11) default '0',
  `semesterreport_studentsWC` int(11) default '0',
  `semesterreport_studentsProjects` int(11) default '0',
  `semesterreport_lnz_avgPrayer` int(11) default '0',
  `semesterreport_lnz_numFrosh` int(11) default '0',
  `semesterreport_lnz_totalStudentInDG` int(11) default '0',
  `semesterreport_lnz_totalSpMult` int(11) default '0',
  `semesterreport_lnz_totalCoreStudents` int(11) default '0',
  `semesterreport_lnz_p2c_numInEvangStudies` int(11) default '0',
  `semesterreport_lnz_p2c_numSharingInP2c` int(11) default '0',
  `semesterreport_lnz_p2c_numSharingOutP2c` int(11) default '0',
  PRIMARY KEY  (`semesterreport_id`)
) ENGINE=MyISAM AUTO_INCREMENT=335 DEFAULT CHARSET=latin1;

CREATE TABLE `cim_stats_week` (
  `week_id` int(50) NOT NULL auto_increment,
  `week_endDate` date NOT NULL default '0000-00-00',
  `semester_id` int(16) NOT NULL default '0',
  `month_id` int(11) NOT NULL,
  PRIMARY KEY  (`week_id`)
) ENGINE=MyISAM AUTO_INCREMENT=539 DEFAULT CHARSET=latin1;

CREATE TABLE `cim_stats_weeklyreport` (
  `weeklyReport_id` int(10) NOT NULL auto_increment,
  `weeklyReport_1on1SpConv` int(10) NOT NULL default '0',
  `weeklyReport_1on1GosPres` int(10) NOT NULL default '0',
  `weeklyReport_1on1HsPres` int(10) NOT NULL default '0',
  `staff_id` int(10) NOT NULL default '0',
  `week_id` int(10) NOT NULL default '0',
  `campus_id` int(10) NOT NULL default '0',
  `weeklyReport_7upCompleted` int(10) NOT NULL default '0',
  `weeklyReport_1on1SpConvStd` int(10) NOT NULL default '0',
  `weeklyReport_1on1GosPresStd` int(10) NOT NULL default '0',
  `weeklyReport_1on1HsPresStd` int(10) NOT NULL default '0',
  `weeklyReport_7upCompletedStd` int(10) NOT NULL default '0',
  `weeklyReport_cjVideo` int(10) NOT NULL default '0',
  `weeklyReport_mda` int(10) NOT NULL default '0',
  `weeklyReport_otherEVMats` int(10) NOT NULL default '0',
  `weeklyReport_rlk` int(10) NOT NULL default '0',
  `weeklyReport_siq` int(10) NOT NULL default '0',
  `weeklyReport_notes` text NOT NULL,
  `weeklyReport_p2c_numCommitFilledHS` int(11) default '0',
  PRIMARY KEY  (`weeklyReport_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9459 DEFAULT CHARSET=latin1;

CREATE TABLE `cim_stats_year` (
  `year_id` int(8) NOT NULL auto_increment,
  `year_desc` varchar(32) NOT NULL default '',
  PRIMARY KEY  (`year_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

CREATE TABLE `mt_evt_access` (
  `viewer_id` int(50) NOT NULL,
  `role` char(50) NOT NULL,
  `max_workload` int(12) NOT NULL default '0',
  `event_id` int(50) NOT NULL,
  PRIMARY KEY  (`viewer_id`,`role`,`event_id`),
  KEY `event_id` (`event_id`),
  KEY `role` (`role`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `mt_evt_assign` (
  `job_id` int(11) NOT NULL default '0',
  `viewer_id` int(50) NOT NULL default '0',
  PRIMARY KEY  (`job_id`,`viewer_id`),
  KEY `viewer_id` (`viewer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `mt_evt_job` (
  `job_id` int(11) NOT NULL auto_increment,
  `job_name` varchar(256) default NULL,
  `set_id` int(11) default NULL,
  `job_openings` int(11) NOT NULL default '0',
  `job_weight` int(11) NOT NULL default '1',
  PRIMARY KEY  (`job_id`),
  KEY `set_id` (`set_id`)
) ENGINE=InnoDB AUTO_INCREMENT=202 DEFAULT CHARSET=latin1;

CREATE TABLE `mt_evt_job_container` (
  `container_id` int(11) NOT NULL auto_increment,
  `container_name` varchar(256) default NULL,
  `event_id` int(50) default NULL,
  PRIMARY KEY  (`container_id`),
  KEY `event_id` (`event_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

CREATE TABLE `mt_evt_job_set` (
  `set_id` int(11) NOT NULL auto_increment,
  `set_name` varchar(256) default NULL,
  `container_id` int(11) default NULL,
  PRIMARY KEY  (`set_id`),
  KEY `container_id` (`container_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

CREATE TABLE `mt_evt_motd` (
  `event_id` int(50) NOT NULL,
  `motd` text NOT NULL,
  PRIMARY KEY  (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `mt_evt_role` (
  `role` char(50) NOT NULL,
  PRIMARY KEY  (`role`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `multi_gen_buttons` (
  `button_id` int(11) NOT NULL auto_increment,
  `site_id` int(11) NOT NULL default '0',
  `button_key` varchar(50) NOT NULL default '',
  `button_value` varchar(50) NOT NULL default '',
  `language_id` int(4) NOT NULL default '1',
  PRIMARY KEY  (`button_id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

CREATE TABLE `multi_labels` (
  `labels_id` int(11) NOT NULL auto_increment,
  `page_id` int(11) NOT NULL default '0',
  `language_id` int(4) NOT NULL default '0',
  `labels_key` varchar(50) character set latin1 NOT NULL default '',
  `labels_label` text character set latin1 NOT NULL,
  `labels_caption` text character set latin1,
  PRIMARY KEY  (`labels_id`),
  KEY `page_id` (`page_id`),
  KEY `language_id` (`language_id`)
) ENGINE=MyISAM AUTO_INCREMENT=26304 DEFAULT CHARSET=utf8;

CREATE TABLE `multi_languages` (
  `language_id` int(11) NOT NULL auto_increment,
  `language_label` varchar(128) NOT NULL default '',
  `labels_key` varchar(128) NOT NULL default '',
  PRIMARY KEY  (`language_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

CREATE TABLE `multi_page` (
  `page_id` int(11) NOT NULL auto_increment,
  `series_id` int(11) NOT NULL default '0',
  `page_label` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`page_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1685 DEFAULT CHARSET=latin1;

CREATE TABLE `multi_series` (
  `series_id` int(11) NOT NULL auto_increment,
  `site_id` int(11) NOT NULL default '0',
  `series_label` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`series_id`)
) ENGINE=MyISAM AUTO_INCREMENT=71 DEFAULT CHARSET=latin1;

CREATE TABLE `multi_site` (
  `site_id` int(11) NOT NULL auto_increment,
  `site_label` varchar(128) NOT NULL default '',
  PRIMARY KEY  (`site_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

CREATE TABLE `national_day` (
  `day_id` int(11) NOT NULL auto_increment,
  `day_date` date NOT NULL default '0000-00-00',
  PRIMARY KEY  (`day_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2018 DEFAULT CHARSET=latin1;

CREATE TABLE `national_signup` (
  `signup_id` int(11) NOT NULL auto_increment,
  `day_id` int(11) NOT NULL default '0',
  `time_id` int(11) NOT NULL default '0',
  `signup_name` varchar(128) NOT NULL default '',
  `campus_id` int(11) NOT NULL default '0',
  `signup_email` varchar(128) NOT NULL default '',
  PRIMARY KEY  (`signup_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5145 DEFAULT CHARSET=latin1;

CREATE TABLE `national_time` (
  `time_id` int(11) NOT NULL auto_increment,
  `time_time` time NOT NULL default '00:00:00',
  PRIMARY KEY  (`time_id`)
) ENGINE=MyISAM AUTO_INCREMENT=241 DEFAULT CHARSET=latin1;

CREATE TABLE `national_timezones` (
  `timezones_id` int(11) NOT NULL auto_increment,
  `timezones_desc` varchar(32) NOT NULL default '',
  `timezones_offset` int(11) NOT NULL default '0',
  PRIMARY KEY  (`timezones_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

CREATE TABLE `navbar_navbarcache` (
  `navbarcache_id` int(11) NOT NULL auto_increment,
  `viewer_id` int(11) NOT NULL default '0',
  `language_id` int(11) NOT NULL default '0',
  `navbarcache_cache` text NOT NULL,
  `navbarcache_isValid` int(1) NOT NULL default '0',
  PRIMARY KEY  (`navbarcache_id`)
) ENGINE=MyISAM AUTO_INCREMENT=146279 DEFAULT CHARSET=latin1;

CREATE TABLE `navbar_navbargroup` (
  `navbargroup_id` int(11) NOT NULL auto_increment,
  `navbargroup_nameKey` varchar(50) NOT NULL default '',
  `navbargroup_order` int(11) NOT NULL default '0',
  PRIMARY KEY  (`navbargroup_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

CREATE TABLE `navbar_navbarlinks` (
  `navbarlink_id` int(11) NOT NULL auto_increment,
  `navbargroup_id` int(11) NOT NULL default '0',
  `navbarlink_textKey` varchar(50) NOT NULL default '',
  `navbarlink_url` text NOT NULL,
  `module_id` int(11) NOT NULL default '0',
  `navbarlink_isActive` int(1) NOT NULL default '0',
  `navbarlink_isModule` int(1) NOT NULL default '0',
  `navbarlink_order` int(11) NOT NULL default '0',
  `navbarlink_startDateTime` datetime NOT NULL default '0000-00-00 00:00:00',
  `navbarlink_endDateTime` datetime NOT NULL default '9999-12-29 23:59:00',
  PRIMARY KEY  (`navbarlink_id`)
) ENGINE=MyISAM AUTO_INCREMENT=72 DEFAULT CHARSET=latin1;

CREATE TABLE `navbar_navlinkaccessgroup` (
  `navlinkaccessgroup_id` int(11) NOT NULL auto_increment,
  `navbarlink_id` int(11) NOT NULL default '0',
  `accessgroup_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`navlinkaccessgroup_id`)
) ENGINE=MyISAM AUTO_INCREMENT=111 DEFAULT CHARSET=latin1;

CREATE TABLE `navbar_navlinkviewer` (
  `navlinkviewer_id` int(11) NOT NULL auto_increment,
  `navbarlink_id` int(11) NOT NULL default '0',
  `viewer_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`navlinkviewer_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

CREATE TABLE `rad_dafield` (
  `dafield_id` int(11) NOT NULL auto_increment,
  `daobj_id` int(11) NOT NULL default '0',
  `statevar_id` int(11) NOT NULL default '-1',
  `dafield_name` varchar(50) NOT NULL default '',
  `dafield_desc` text NOT NULL,
  `dafield_type` varchar(50) NOT NULL default '',
  `dafield_dbType` varchar(50) NOT NULL default '',
  `dafield_formFieldType` varchar(50) NOT NULL default '',
  `dafield_isPrimaryKey` int(1) NOT NULL default '0',
  `dafield_isForeignKey` int(1) NOT NULL default '0',
  `dafield_isNullable` int(1) NOT NULL default '0',
  `dafield_default` varchar(50) NOT NULL default '',
  `dafield_invalidValue` varchar(50) NOT NULL default '',
  `dafield_isLabelName` int(1) NOT NULL default '0',
  `dafield_isListInit` int(1) NOT NULL default '0',
  `dafield_isCreated` int(1) NOT NULL default '0',
  `dafield_title` text NOT NULL,
  `dafield_formLabel` text NOT NULL,
  `dafield_example` text NOT NULL,
  `dafield_error` text NOT NULL,
  PRIMARY KEY  (`dafield_id`)
) ENGINE=MyISAM AUTO_INCREMENT=359 DEFAULT CHARSET=latin1;

CREATE TABLE `rad_daobj` (
  `daobj_id` int(11) NOT NULL auto_increment,
  `module_id` int(11) NOT NULL default '0',
  `daobj_name` varchar(50) NOT NULL default '',
  `daobj_desc` text NOT NULL,
  `daobj_dbTableName` varchar(100) NOT NULL default '',
  `daobj_managerInitVarID` int(11) NOT NULL default '0',
  `daobj_listInitVarID` int(11) NOT NULL default '0',
  `daobj_isCreated` int(1) NOT NULL default '0',
  `daobj_isUpdated` int(1) NOT NULL default '0',
  PRIMARY KEY  (`daobj_id`)
) ENGINE=MyISAM AUTO_INCREMENT=81 DEFAULT CHARSET=latin1;

CREATE TABLE `rad_module` (
  `module_id` int(11) NOT NULL auto_increment,
  `module_name` varchar(50) NOT NULL default '',
  `module_desc` text NOT NULL,
  `module_creatorName` text NOT NULL,
  `module_isCommonLook` int(1) NOT NULL default '0',
  `module_isCore` int(1) NOT NULL default '0',
  `module_isCreated` int(1) NOT NULL default '0',
  PRIMARY KEY  (`module_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

CREATE TABLE `rad_page` (
  `page_id` int(11) NOT NULL auto_increment,
  `module_id` int(11) NOT NULL default '0',
  `page_name` varchar(50) NOT NULL default '',
  `page_desc` text NOT NULL,
  `page_type` varchar(5) NOT NULL default '',
  `page_isAdd` int(1) NOT NULL default '0',
  `page_rowMgrID` int(11) NOT NULL default '0',
  `page_listMgrID` int(11) NOT NULL default '0',
  `page_isCreated` int(1) NOT NULL default '0',
  `page_isDefault` int(1) NOT NULL default '0',
  PRIMARY KEY  (`page_id`)
) ENGINE=MyISAM AUTO_INCREMENT=123 DEFAULT CHARSET=latin1;

CREATE TABLE `rad_pagefield` (
  `pagefield_id` int(11) NOT NULL auto_increment,
  `page_id` int(11) NOT NULL default '0',
  `daobj_id` int(11) NOT NULL default '0',
  `dafield_id` int(11) NOT NULL default '0',
  `pagefield_isForm` int(1) NOT NULL default '0',
  PRIMARY KEY  (`pagefield_id`)
) ENGINE=MyISAM AUTO_INCREMENT=433 DEFAULT CHARSET=latin1;

CREATE TABLE `rad_pagelabels` (
  `pagelabel_id` int(11) NOT NULL auto_increment,
  `page_id` int(11) NOT NULL default '0',
  `pagelabel_key` varchar(50) NOT NULL default '',
  `pagelabel_label` text NOT NULL,
  `language_id` int(11) NOT NULL default '0',
  `pagelabel_isCreated` int(1) NOT NULL default '0',
  PRIMARY KEY  (`pagelabel_id`)
) ENGINE=MyISAM AUTO_INCREMENT=186 DEFAULT CHARSET=latin1;

CREATE TABLE `rad_statevar` (
  `statevar_id` int(11) NOT NULL auto_increment,
  `module_id` int(11) NOT NULL default '0',
  `statevar_name` varchar(50) NOT NULL default '',
  `statevar_desc` text NOT NULL,
  `statevar_type` enum('STRING','BOOL','INTEGER','DATE') NOT NULL default 'STRING',
  `statevar_default` varchar(50) NOT NULL default '',
  `statevar_isCreated` int(1) NOT NULL default '0',
  `statevar_isUpdated` int(1) NOT NULL default '0',
  PRIMARY KEY  (`statevar_id`)
) ENGINE=MyISAM AUTO_INCREMENT=97 DEFAULT CHARSET=latin1;

CREATE TABLE `rad_transitions` (
  `transition_id` int(11) NOT NULL auto_increment,
  `module_id` int(11) NOT NULL default '0',
  `transition_fromObjID` int(11) NOT NULL default '0',
  `transition_toObjID` int(11) NOT NULL default '0',
  `transition_type` varchar(10) NOT NULL default '',
  `transition_isCreated` int(1) NOT NULL default '0',
  PRIMARY KEY  (`transition_id`)
) ENGINE=MyISAM AUTO_INCREMENT=48 DEFAULT CHARSET=latin1;

CREATE TABLE `site_logmanager` (
  `log_id` int(11) NOT NULL auto_increment,
  `log_userID` varchar(50) NOT NULL default '',
  `log_dateTime` datetime NOT NULL default '0000-00-00 00:00:00',
  `log_recipientID` varchar(50) NOT NULL default '',
  `log_description` text NOT NULL,
  `log_data` text NOT NULL,
  `log_viewerIP` varchar(15) NOT NULL default '',
  `log_applicationKey` varchar(4) NOT NULL default '',
  PRIMARY KEY  (`log_id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

CREATE TABLE `site_multilingual_label` (
  `label_id` int(11) NOT NULL auto_increment,
  `page_id` int(11) NOT NULL default '0',
  `label_key` varchar(50) NOT NULL default '',
  `label_label` text NOT NULL,
  `label_moddate` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `language_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`label_id`),
  KEY `ciministry.site_multilingual_label_page_id_index` (`page_id`),
  KEY `ciministry.site_multilingual_label_label_key_index` (`label_key`),
  KEY `ciministry.site_multilingual_label_language_id_index` (`language_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4646 DEFAULT CHARSET=latin1;

CREATE TABLE `site_multilingual_page` (
  `page_id` int(11) NOT NULL auto_increment,
  `series_id` int(11) NOT NULL default '0',
  `page_key` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`page_id`)
) ENGINE=MyISAM AUTO_INCREMENT=304 DEFAULT CHARSET=latin1;

CREATE TABLE `site_multilingual_series` (
  `series_id` int(11) NOT NULL auto_increment,
  `series_key` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`series_id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

CREATE TABLE `site_multilingual_xlation` (
  `xlation_id` int(11) NOT NULL auto_increment,
  `label_id` int(11) NOT NULL default '0',
  `language_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`xlation_id`),
  KEY `language_id` (`language_id`),
  KEY `label_id` (`label_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5548 DEFAULT CHARSET=latin1;

CREATE TABLE `site_page_modules` (
  `module_id` int(11) NOT NULL auto_increment,
  `module_key` varchar(50) NOT NULL default '',
  `module_path` text NOT NULL,
  `module_app` varchar(50) NOT NULL default '',
  `module_include` varchar(50) NOT NULL default '',
  `module_name` varchar(50) NOT NULL default '',
  `module_parameters` text NOT NULL,
  `module_systemAccessFile` varchar(50) NOT NULL default '',
  `module_systemAccessObj` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`module_id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

CREATE TABLE `site_session` (
  `session_id` varchar(32) NOT NULL default '',
  `session_data` text NOT NULL,
  `session_expiration` int(11) NOT NULL default '0',
  PRIMARY KEY  (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `spt_ticket` (
  `ticket_id` int(8) NOT NULL auto_increment,
  `viewer_id` int(8) NOT NULL default '0',
  `ticket_ticket` varchar(64) NOT NULL default '',
  `ticket_expiry` int(16) NOT NULL default '0',
  PRIMARY KEY  (`ticket_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13418 DEFAULT CHARSET=latin1;

CREATE TABLE `temp_mb_early_frosh` (
  `registration_id` int(10) NOT NULL,
  PRIMARY KEY  (`registration_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

CREATE TABLE `test_table` (
  `test_id` int(50) NOT NULL auto_increment,
  PRIMARY KEY  (`test_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

CREATE TABLE `uwo_bb_extended_info` (
  `person_faculty` varchar(128) default NULL,
  `person_verified` tinyint(1) default '0',
  `person_skills` text,
  `person_comments` text,
  `person_title` varchar(128) default NULL,
  `person_id` int(50) NOT NULL default '0',
  `person_major` varchar(128) default NULL,
  PRIMARY KEY  (`person_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `uwo_bb_group` (
  `group_id` int(50) NOT NULL auto_increment,
  `group_name` varchar(128) NOT NULL,
  `group_desc` text,
  `group_type_id` int(50) NOT NULL,
  PRIMARY KEY  (`group_id`),
  KEY `group_type_id` (`group_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `uwo_bb_group_assignment` (
  `person_id` int(50) NOT NULL,
  `group_id` int(50) NOT NULL,
  `group_assignment_type_id` int(50) NOT NULL,
  `group_assignment_title` varchar(128) NOT NULL,
  PRIMARY KEY  (`person_id`,`group_id`),
  KEY `group_id` (`group_id`),
  KEY `group_assignment_type_id` (`group_assignment_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `uwo_bb_group_assignment_type` (
  `group_assignment_type_id` int(50) NOT NULL auto_increment,
  `group_assignment_title` varchar(128) NOT NULL,
  PRIMARY KEY  (`group_assignment_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

CREATE TABLE `uwo_bb_group_type` (
  `group_type_id` int(50) NOT NULL auto_increment,
  `group_type_name` varchar(128) NOT NULL,
  PRIMARY KEY  (`group_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

CREATE TABLE `uwo_bb_login` (
  `person_id` int(50) NOT NULL,
  `campus_id` int(50) NOT NULL,
  `login_write` int(4) NOT NULL default '0',
  PRIMARY KEY  (`person_id`,`campus_id`),
  KEY `campus_id` (`campus_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `wp_comments` (
  `comment_ID` bigint(20) unsigned NOT NULL auto_increment,
  `comment_post_ID` int(11) NOT NULL default '0',
  `comment_author` tinytext NOT NULL,
  `comment_author_email` varchar(100) NOT NULL default '',
  `comment_author_url` varchar(200) NOT NULL default '',
  `comment_author_IP` varchar(100) NOT NULL default '',
  `comment_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `comment_date_gmt` datetime NOT NULL default '0000-00-00 00:00:00',
  `comment_content` text NOT NULL,
  `comment_karma` int(11) NOT NULL default '0',
  `comment_approved` varchar(20) NOT NULL default '1',
  `comment_agent` varchar(255) NOT NULL default '',
  `comment_type` varchar(20) NOT NULL default '',
  `comment_parent` bigint(20) NOT NULL default '0',
  `user_id` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`comment_ID`),
  KEY `comment_approved` (`comment_approved`),
  KEY `comment_post_ID` (`comment_post_ID`),
  KEY `comment_approved_date_gmt` (`comment_approved`,`comment_date_gmt`),
  KEY `comment_date_gmt` (`comment_date_gmt`)
) ENGINE=MyISAM AUTO_INCREMENT=40641 DEFAULT CHARSET=utf8;

CREATE TABLE `wp_formbuilder_fields` (
  `id` bigint(20) NOT NULL auto_increment,
  `form_id` bigint(20) NOT NULL,
  `display_order` int(11) NOT NULL,
  `field_type` varchar(255) NOT NULL,
  `field_name` varchar(255) NOT NULL,
  `field_value` blob NOT NULL,
  `field_label` blob NOT NULL,
  `required_data` varchar(255) NOT NULL,
  `error_message` blob NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=59 DEFAULT CHARSET=latin1;

CREATE TABLE `wp_formbuilder_forms` (
  `id` bigint(20) NOT NULL auto_increment,
  `name` blob NOT NULL,
  `subject` blob NOT NULL,
  `recipient` blob NOT NULL,
  `method` enum('POST','GET') NOT NULL,
  `action` varchar(255) NOT NULL,
  `thankyoutext` blob NOT NULL,
  `autoresponse` bigint(20) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

CREATE TABLE `wp_formbuilder_pages` (
  `id` bigint(20) NOT NULL auto_increment,
  `post_id` bigint(20) NOT NULL,
  `form_id` bigint(20) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

CREATE TABLE `wp_formbuilder_responses` (
  `id` bigint(20) NOT NULL auto_increment,
  `name` blob NOT NULL,
  `subject` blob NOT NULL,
  `message` blob NOT NULL,
  `from_name` blob NOT NULL,
  `from_email` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `wp_links` (
  `link_id` bigint(20) NOT NULL auto_increment,
  `link_url` varchar(255) NOT NULL default '',
  `link_name` varchar(255) NOT NULL default '',
  `link_image` varchar(255) NOT NULL default '',
  `link_target` varchar(25) NOT NULL default '',
  `link_category` bigint(20) NOT NULL default '0',
  `link_description` varchar(255) NOT NULL default '',
  `link_visible` varchar(20) NOT NULL default 'Y',
  `link_owner` int(11) NOT NULL default '1',
  `link_rating` int(11) NOT NULL default '0',
  `link_updated` datetime NOT NULL default '0000-00-00 00:00:00',
  `link_rel` varchar(255) NOT NULL default '',
  `link_notes` mediumtext NOT NULL,
  `link_rss` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`link_id`),
  KEY `link_category` (`link_category`),
  KEY `link_visible` (`link_visible`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

CREATE TABLE `wp_options` (
  `option_id` bigint(20) NOT NULL auto_increment,
  `blog_id` int(11) NOT NULL default '0',
  `option_name` varchar(64) NOT NULL default '',
  `option_value` longtext NOT NULL,
  `autoload` varchar(20) NOT NULL default 'yes',
  PRIMARY KEY  (`option_id`,`blog_id`,`option_name`),
  KEY `option_name` (`option_name`)
) ENGINE=MyISAM AUTO_INCREMENT=381 DEFAULT CHARSET=utf8;

CREATE TABLE `wp_postmeta` (
  `meta_id` bigint(20) NOT NULL auto_increment,
  `post_id` bigint(20) NOT NULL default '0',
  `meta_key` varchar(255) default NULL,
  `meta_value` longtext,
  PRIMARY KEY  (`meta_id`),
  KEY `post_id` (`post_id`),
  KEY `meta_key` (`meta_key`)
) ENGINE=MyISAM AUTO_INCREMENT=119 DEFAULT CHARSET=utf8;

CREATE TABLE `wp_posts` (
  `ID` bigint(20) unsigned NOT NULL auto_increment,
  `post_author` bigint(20) NOT NULL default '0',
  `post_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `post_date_gmt` datetime NOT NULL default '0000-00-00 00:00:00',
  `post_content` longtext NOT NULL,
  `post_title` text NOT NULL,
  `post_category` int(4) NOT NULL default '0',
  `post_excerpt` text NOT NULL,
  `post_status` varchar(20) NOT NULL default 'publish',
  `comment_status` varchar(20) NOT NULL default 'open',
  `ping_status` varchar(20) NOT NULL default 'open',
  `post_password` varchar(20) NOT NULL default '',
  `post_name` varchar(200) NOT NULL default '',
  `to_ping` text NOT NULL,
  `pinged` text NOT NULL,
  `post_modified` datetime NOT NULL default '0000-00-00 00:00:00',
  `post_modified_gmt` datetime NOT NULL default '0000-00-00 00:00:00',
  `post_content_filtered` text NOT NULL,
  `post_parent` bigint(20) NOT NULL default '0',
  `guid` varchar(255) NOT NULL default '',
  `menu_order` int(11) NOT NULL default '0',
  `post_type` varchar(20) NOT NULL default 'post',
  `post_mime_type` varchar(100) NOT NULL default '',
  `comment_count` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`ID`),
  KEY `post_name` (`post_name`),
  KEY `type_status_date` (`post_type`,`post_status`,`post_date`,`ID`),
  KEY `post_parent` (`post_parent`)
) ENGINE=MyISAM AUTO_INCREMENT=209 DEFAULT CHARSET=utf8;

CREATE TABLE `wp_term_relationships` (
  `object_id` bigint(20) NOT NULL default '0',
  `term_taxonomy_id` bigint(20) NOT NULL default '0',
  `term_order` int(11) NOT NULL default '0',
  PRIMARY KEY  (`object_id`,`term_taxonomy_id`),
  KEY `term_taxonomy_id` (`term_taxonomy_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `wp_term_taxonomy` (
  `term_taxonomy_id` bigint(20) NOT NULL auto_increment,
  `term_id` bigint(20) NOT NULL default '0',
  `taxonomy` varchar(32) NOT NULL default '',
  `description` longtext NOT NULL,
  `parent` bigint(20) NOT NULL default '0',
  `count` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`term_taxonomy_id`),
  UNIQUE KEY `term_id_taxonomy` (`term_id`,`taxonomy`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

CREATE TABLE `wp_terms` (
  `term_id` bigint(20) NOT NULL auto_increment,
  `name` varchar(200) NOT NULL default '',
  `slug` varchar(200) NOT NULL default '',
  `term_group` bigint(10) NOT NULL default '0',
  PRIMARY KEY  (`term_id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

CREATE TABLE `wp_usermeta` (
  `umeta_id` bigint(20) NOT NULL auto_increment,
  `user_id` bigint(20) NOT NULL default '0',
  `meta_key` varchar(255) default NULL,
  `meta_value` longtext,
  PRIMARY KEY  (`umeta_id`),
  KEY `user_id` (`user_id`),
  KEY `meta_key` (`meta_key`)
) ENGINE=MyISAM AUTO_INCREMENT=51 DEFAULT CHARSET=utf8;

CREATE TABLE `wp_users` (
  `ID` bigint(20) unsigned NOT NULL auto_increment,
  `user_login` varchar(60) NOT NULL default '',
  `user_pass` varchar(64) NOT NULL default '',
  `user_nicename` varchar(50) NOT NULL default '',
  `user_email` varchar(100) NOT NULL default '',
  `user_url` varchar(100) NOT NULL default '',
  `user_registered` datetime NOT NULL default '0000-00-00 00:00:00',
  `user_activation_key` varchar(60) NOT NULL default '',
  `user_status` int(11) NOT NULL default '0',
  `display_name` varchar(250) NOT NULL default '',
  PRIMARY KEY  (`ID`),
  KEY `user_login_key` (`user_login`),
  KEY `user_nicename` (`user_nicename`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;