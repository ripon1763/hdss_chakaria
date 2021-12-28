<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Base Site URL
|--------------------------------------------------------------------------
|
| URL to your CodeIgniter root. Typically this will be your base URL,
| WITH a trailing slash:
|
|	http://example.com/
|
| WARNING: You MUST set this value!
|
| If it is not set, then CodeIgniter will try guess the protocol and path
| your installation, but due to security concerns the hostname will be set
| to $_SERVER['SERVER_ADDR'] if available, or localhost otherwise.
| The auto-detection mechanism exists only for convenience during
| development and MUST NOT be used in production!
|
| If you need to allow multiple domains, remember that this file is still
| a PHP script and you can easily do that on your own.
|
*/
$base  = "http://".$_SERVER['HTTP_HOST'];
$base .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
$config['base_url'] = $base;


/*
|--------------------------------------------------------------------------
| Index File
|--------------------------------------------------------------------------
|
| Typically this will be your index.php file, unless you've renamed it to
| something else. If you are using mod_rewrite to remove the page set this
| variable so that it is blank.
|
*/
$config['index_page'] = '';

/*
|--------------------------------------------------------------------------
| URI PROTOCOL
|--------------------------------------------------------------------------
|
| This item determines which server global should be used to retrieve the
| URI string.  The default setting of 'REQUEST_URI' works for most servers.
| If your links do not seem to work, try one of the other delicious flavors:
|
| 'REQUEST_URI'    Uses $_SERVER['REQUEST_URI']
| 'QUERY_STRING'   Uses $_SERVER['QUERY_STRING']
| 'PATH_INFO'      Uses $_SERVER['PATH_INFO']
|
| WARNING: If you set this to 'PATH_INFO', URIs will always be URL-decoded!
*/
$config['uri_protocol']	= 'REQUEST_URI';
$config['application_name']	= 'Urban Health & Demographic Surveillance  System';
$config['prefix']	= 'icddr,b';
$config['site_currency']	= 'BDT';

/*
|--------------------------------------------------------------------------
| URL suffix
|--------------------------------------------------------------------------
|
| This option allows you to add a suffix to all URLs generated by CodeIgniter.
| For more information please see the user guide:
|
| https://codeigniter.com/user_guide/general/urls.html
*/
$config['url_suffix'] = '';

/*
|--------------------------------------------------------------------------
| Default Language
|--------------------------------------------------------------------------
|
| This determines which set of language files should be used. Make sure
| there is an available translation if you intend to use something other
| than english.
|
*/
$config['language']	= 'english';

/*
|--------------------------------------------------------------------------
| Default Character Set
|--------------------------------------------------------------------------
|
| This determines which character set is used by default in various methods
| that require a character set to be provided.
|
| See http://php.net/htmlspecialchars for a list of supported charsets.
|
*/
$config['charset'] = 'UTF-8';

/*
|--------------------------------------------------------------------------
| Enable/Disable System Hooks
|--------------------------------------------------------------------------
|
| If you would like to use the 'hooks' feature you must enable it by
| setting this variable to TRUE (boolean).  See the user guide for details.
|
*/
$config['enable_hooks'] = FALSE;

/*
|--------------------------------------------------------------------------
| Class Extension Prefix
|--------------------------------------------------------------------------
|
| This item allows you to set the filename/classname prefix when extending
| native libraries.  For more information please see the user guide:
|
| https://codeigniter.com/user_guide/general/core_classes.html
| https://codeigniter.com/user_guide/general/creating_libraries.html
|
*/
$config['subclass_prefix'] = 'MY_';

/*
|--------------------------------------------------------------------------
| Composer auto-loading
|--------------------------------------------------------------------------
|
| Enabling this setting will tell CodeIgniter to look for a Composer
| package auto-loader script in application/vendor/autoload.php.
|
|	$config['composer_autoload'] = TRUE;
|
| Or if you have your vendor/ directory located somewhere else, you
| can opt to set a specific path as well:
|
|	$config['composer_autoload'] = '/path/to/vendor/autoload.php';
|
| For more information about Composer, please visit http://getcomposer.org/
|
| Note: This will NOT disable or override the CodeIgniter-specific
|	autoloading (application/config/autoload.php)
*/
$config['composer_autoload'] = FALSE;

/*
|--------------------------------------------------------------------------
| Allowed URL Characters
|--------------------------------------------------------------------------
|
| This lets you specify which characters are permitted within your URLs.
| When someone tries to submit a URL with disallowed characters they will
| get a warning message.
|
| As a security measure you are STRONGLY encouraged to restrict URLs to
| as few characters as possible.  By default only these are allowed: a-z 0-9~%.:_-
|
| Leave blank to allow all characters -- but only if you are insane.
|
| The configured value is actually a regular expression character group
| and it will be executed as: ! preg_match('/^[<permitted_uri_chars>]+$/i
|
| DO NOT CHANGE THIS UNLESS YOU FULLY UNDERSTAND THE REPERCUSSIONS!!
|
*/
$config['permitted_uri_chars'] = 'a-z 0-9~%.:_\-';

/*
|--------------------------------------------------------------------------
| Enable Query Strings
|--------------------------------------------------------------------------
|
| By default CodeIgniter uses search-engine friendly segment based URLs:
| example.com/who/what/where/
|
| You can optionally enable standard query string based URLs:
| example.com?who=me&what=something&where=here
|
| Options are: TRUE or FALSE (boolean)
|
| The other items let you set the query string 'words' that will
| invoke your controllers and its functions:
| example.com/index.php?c=controller&m=function
|
| Please note that some of the helpers won't work as expected when
| this feature is enabled, since CodeIgniter is designed primarily to
| use segment based URLs.
|
*/
$config['enable_query_strings'] = FALSE;
$config['controller_trigger'] = 'c';
$config['function_trigger'] = 'm';
$config['directory_trigger'] = 'd';

/*
|--------------------------------------------------------------------------
| Allow $_GET array
|--------------------------------------------------------------------------
|
| By default CodeIgniter enables access to the $_GET array.  If for some
| reason you would like to disable it, set 'allow_get_array' to FALSE.
|
| WARNING: This feature is DEPRECATED and currently available only
|          for backwards compatibility purposes!
|
*/
$config['allow_get_array'] = TRUE;

/*
|--------------------------------------------------------------------------
| Error Logging Threshold
|--------------------------------------------------------------------------
|
| You can enable error logging by setting a threshold over zero. The
| threshold determines what gets logged. Threshold options are:
|
|	0 = Disables logging, Error logging TURNED OFF
|	1 = Error Messages (including PHP errors)
|	2 = Debug Messages
|	3 = Informational Messages
|	4 = All Messages
|
| You can also pass an array with threshold levels to show individual error types
|
| 	array(2) = Debug Messages, without Error Messages
|
| For a live site you'll usually only enable Errors (1) to be logged otherwise
| your log files will fill up very fast.
|
*/
$config['log_threshold'] = 0;

/*
|--------------------------------------------------------------------------
| Error Logging Directory Path
|--------------------------------------------------------------------------
|
| Leave this BLANK unless you would like to set something other than the default
| application/logs/ directory. Use a full server path with trailing slash.
|
*/
$config['log_path'] = '';

/*
|--------------------------------------------------------------------------
| Log File Extension
|--------------------------------------------------------------------------
|
| The default filename extension for log files. The default 'php' allows for
| protecting the log files via basic scripting, when they are to be stored
| under a publicly accessible directory.
|
| Note: Leaving it blank will default to 'php'.
|
*/
$config['log_file_extension'] = '';

/*
|--------------------------------------------------------------------------
| Log File Permissions
|--------------------------------------------------------------------------
|
| The file system permissions to be applied on newly created log files.
|
| IMPORTANT: This MUST be an integer (no quotes) and you MUST use octal
|            integer notation (i.e. 0700, 0644, etc.)
*/
$config['log_file_permissions'] = 0644;

/*
|--------------------------------------------------------------------------
| Date Format for Logs
|--------------------------------------------------------------------------
|
| Each item that is logged has an associated date. You can use PHP date
| codes to set your own date formatting
|
*/
$config['log_date_format'] = 'Y-m-d H:i:s';

/*
|--------------------------------------------------------------------------
| Error Views Directory Path
|--------------------------------------------------------------------------
|
| Leave this BLANK unless you would like to set something other than the default
| application/views/errors/ directory.  Use a full server path with trailing slash.
|
*/
$config['error_views_path'] = '';

/*
|--------------------------------------------------------------------------
| Cache Directory Path
|--------------------------------------------------------------------------
|
| Leave this BLANK unless you would like to set something other than the default
| application/cache/ directory.  Use a full server path with trailing slash.
|
*/
$config['cache_path'] = '';

/*
|--------------------------------------------------------------------------
| Cache Include Query String
|--------------------------------------------------------------------------
|
| Whether to take the URL query string into consideration when generating
| output cache files. Valid options are:
|
|	FALSE      = Disabled
|	TRUE       = Enabled, take all query parameters into account.
|	             Please be aware that this may result in numerous cache
|	             files generated for the same page over and over again.
|	array('q') = Enabled, but only take into account the specified list
|	             of query parameters.
|
*/
$config['cache_query_string'] = FALSE;

/*
|--------------------------------------------------------------------------
| Encryption Key
|--------------------------------------------------------------------------
|
| If you use the Encryption class, you must set an encryption key.
| See the user guide for more info.
|
| https://codeigniter.com/user_guide/libraries/encryption.html
|
*/
$config['encryption_key'] = 'asjkrue*$djasfl134213';

/*
|--------------------------------------------------------------------------
| Session Variables
|--------------------------------------------------------------------------
|
| 'sess_driver'
|
|	The storage driver to use: files, database, redis, memcached
|
| 'sess_cookie_name'
|
|	The session cookie name, must contain only [0-9a-z_-] characters
|
| 'sess_expiration'
|
|	The number of SECONDS you want the session to last.
|	Setting to 0 (zero) means expire when the browser is closed.
|
| 'sess_save_path'
|
|	The location to save sessions to, driver dependent.
|
|	For the 'files' driver, it's a path to a writable directory.
|	WARNING: Only absolute paths are supported!
|
|	For the 'database' driver, it's a table name.
|	Please read up the manual for the format with other session drivers.
|
|	IMPORTANT: You are REQUIRED to set a valid save path!
|
| 'sess_match_ip'
|
|	Whether to match the user's IP address when reading the session data.
|
|	WARNING: If you're using the database driver, don't forget to update
|	         your session table's PRIMARY KEY when changing this setting.
|
| 'sess_time_to_update'
|
|	How many seconds between CI regenerating the session ID.
|
| 'sess_regenerate_destroy'
|
|	Whether to destroy session data associated with the old session ID
|	when auto-regenerating the session ID. When set to FALSE, the data
|	will be later deleted by the garbage collector.
|
| Other session cookie settings are shared with the rest of the application,
| except for 'cookie_prefix' and 'cookie_httponly', which are ignored here.
|
*/
$config['sess_driver'] = 'database';
$config['sess_cookie_name'] = 'ci_session';
$config['sess_expiration'] = 7200;
$config['sess_save_path'] = 'ci_sessions';
$config['sess_match_ip'] = FALSE;
$config['sess_time_to_update'] = 300;
$config['sess_regenerate_destroy'] = FALSE;

date_default_timezone_set('Asia/Dhaka');

/*
|--------------------------------------------------------------------------
| Cookie Related Variables
|--------------------------------------------------------------------------
|
| 'cookie_prefix'   = Set a cookie name prefix if you need to avoid collisions
| 'cookie_domain'   = Set to .your-domain.com for site-wide cookies
| 'cookie_path'     = Typically will be a forward slash
| 'cookie_secure'   = Cookie will only be set if a secure HTTPS connection exists.
| 'cookie_httponly' = Cookie will only be accessible via HTTP(S) (no javascript)
|
| Note: These settings (with the exception of 'cookie_prefix' and
|       'cookie_httponly') will also affect sessions.
|
*/
$config['cookie_prefix']	= '';
$config['cookie_domain']	= '';
$config['cookie_path']		= '/';
$config['cookie_secure']	= FALSE;
$config['cookie_httponly'] 	= FALSE;

/*
|--------------------------------------------------------------------------
| Standardize newlines
|--------------------------------------------------------------------------
|
| Determines whether to standardize newline characters in input data,
| meaning to replace \r\n, \r, \n occurrences with the PHP_EOL value.
|
| WARNING: This feature is DEPRECATED and currently available only
|          for backwards compatibility purposes!
|
*/
$config['standardize_newlines'] = FALSE;

/*
|--------------------------------------------------------------------------
| Global XSS Filtering
|--------------------------------------------------------------------------
|
| Determines whether the XSS filter is always active when GET, POST or
| COOKIE data is encountered
|
| WARNING: This feature is DEPRECATED and currently available only
|          for backwards compatibility purposes!
|
*/
$config['global_xss_filtering'] = FALSE;

/*
|--------------------------------------------------------------------------
| Cross Site Request Forgery
|--------------------------------------------------------------------------
| Enables a CSRF cookie token to be set. When set to TRUE, token will be
| checked on a submitted form. If you are accepting user data, it is strongly
| recommended CSRF protection be enabled.
|
| 'csrf_token_name' = The token name
| 'csrf_cookie_name' = The cookie name
| 'csrf_expire' = The number in seconds the token should expire.
| 'csrf_regenerate' = Regenerate token on every submission
| 'csrf_exclude_uris' = Array of URIs which ignore CSRF checks
*/
$config['csrf_protection'] = FALSE;
$config['csrf_token_name'] = 'csrf_test_name';
$config['csrf_cookie_name'] = 'csrf_cookie_name';
$config['csrf_expire'] = 7200;
$config['csrf_regenerate'] = TRUE;
$config['csrf_exclude_uris'] = array();


// table names

$config['storeTable'] 				= 'tbl_store';
$config['lookMasterTable'] 			= 'tbl_lookup_master';
$config['countryTable'] 			= 'tbl_country';
$config['lookDetailsTable'] 		= 'tbl_lookup_details';
$config['divTable'] 				= 'tbl_division';
$config['districtTable'] 			= 'tbl_district';
$config['upazilaTable'] 			= 'tbl_thana';
$config['slumTable'] 				= 'tbl_slum';
$config['slumAreaTable'] 			= 'tbl_slum_area';
$config['roundTable'] 				= 'tbl_round_master';
$config['roundSlumMapTable'] 		= 'tbl_round_slum_mapping';
$config['countryTable'] 			= 'tbl_country';
$config['householdMasterTable'] 	= 'household_master';
$config['memberMasterTable'] 		= 'tbl_member_master';
$config['memberHouseholdTable'] 	= 'tbl_member_household';
$config['memberEducationTable'] 	= 'tbl_member_education';
$config['memberOccupationTable']	= 'tbl_member_occupation';
$config['memberHeadTable'] 			= 'tbl_household_head';
$config['memberRelationTable'] 		= 'tbl_member_relation';
$config['householdVisitTable'] 		= 'tbl_household_visit';
$config['householdAssetTable'] 		= 'tbl_household_assets';
$config['deathTable'] 				= 'tbl_member_death';
$config['conceptionTable'] 			= 'tbl_member_conception';
$config['pregnancyTable'] 			= 'tbl_member_pregnancy';
$config['marriageStartTable'] 		= 'tbl_member_marriage_start';
$config['marriageEndTable'] 		= 'tbl_member_marriage_end';
$config['migrationOutTable'] 		= 'tbl_member_migration_out';
$config['migrationInTable'] 		= 'tbl_member_migration_in';
$config['baselineCensusTable']      = 'tbl_baseline_census';
$config['memberImmunizationTable']  = 'tbl_member_immunization';
$config['householdFamilyPlanningTable'] = 'tbl_member_family_planning';

$config['memberChildIllnessTable']       = 'tbl_member_child_illness';


//verbal autopsy table
$config['deathTableExtended'] 		= 'member_death_extended';
$config['lookMasterTable_va'] 		= 'lookup_master_va';
$config['lookDetailsTable_va'] 		= 'lookup_details_va';
$config['stillBirthTable'] 			= 'member_still_birth';


//look up master variable 

$config['hhentrytype'] 				= 'hh_entry_type';
$config['migReason'] 				= 'migration_reason';
$config['hhcontacttyp'] 			= 'hh_contact_typ';
$config['mementrytyp'] 				= 'mem_entry_typ';
$config['membersextype'] 			= 'member_sex_type';
$config['relationhhh'] 				= 'relation_hhh';
$config['religion'] 				= 'religion';
$config['maritalstatustyp'] 		= 'marital_status_typ';
$config['educationtyp'] 			= 'education_typ';
$config['secularedutyp'] 			= 'secular_edu_typ';
$config['religiousedutype'] 		= 'religious_edu_type';
$config['occupationtyp'] 			= 'occupation_typ';
$config['yes_no'] 					= 'yes_no';
$config['asset_yes_no'] 			= 'asset_yes_no';
$config['whynotbirthreg'] 			= 'why_not_birth_reg';
$config['interviewstatus'] 			= 'interview_status';
$config['interviewercode'] 			= 'interviewer_code';
$config['respondent_typ'] 			= 'respondent_typ';
$config['hh_change_reason'] 		= 'hh_change_reason';
$config['member_death_cause'] 		= 'member_death_cause';
$config['member_death_place'] 		= 'member_death_place';
$config['type_of_death'] 			= 'type_of_death';
$config['death_confirm_by'] 		= 'death_confirm_by';
$config['member_exit_typ'] 		    = 'member_exit_typ';
$config['conception_plan'] 		    = 'conception_plan';
$config['conception_order'] 		= 'conception_order';
$config['consp_follow_up_status'] 	= 'consp_follow_up_status';
$config['pregnancy_result'] 		= 'pregnancy_result';
$config['delivery_methodology'] 	= 'delivery_methodology';
$config['preg_term_assist'] 		= 'preg_term_assist';
$config['preg_term_place'] 			= 'preg_term_place';
$config['yes_no_miss_not_app'] 		= 'yes_no_miss_not_app';
$config['birth_weight_size'] 		= 'birth_weight_size';
$config['mother_live_birth_order'] 	= 'mother_live_birth_order';
$config['marriage_order'] 			= 'marriage_order';
$config['marriage_registration'] 	= 'marriage_registration';
$config['marriage_end_typ'] 		= 'marriage_end_typ';
$config['marriage_end_cause'] 		= 'marriage_end_cause';
$config['internal_movement_cause'] 	= 'internal_movement_cause';
$config['outside_cause'] 			= 'outside_cause';
$config['movement_group_typ'] 		= 'movement_group_typ';
$config['ancPncVisit'] 				= 'pnc_visit_list';
$config['hh_extinct_typ'] 			= 'hh_extinct_typ';
$config['education_year'] 			= 'education_year';
$config['child_after_year'] 		= 'child_after_year';
$config['house_owner'] 		        = 'house_owner';
$config['land_owner'] 		        = 'land_owner';
$config['litter_size'] 		        = 'litter_size';
$config['facility_delivery'] 		= 'facility_delivery';
$config['fast_milk_birth'] 		    = 'fast_milk_birth';
$config['anc_assist_typ'] 		    = 'anc_assist_typ';
$config['ifa_supliment_source']     = 'ifa_supliment_source';
$config['how_many_tablet']          = 'how_many_tablet';
$config['yes_no_not_applicable']    = 'yes_no_not_applicable';
$config['knowledge_behavior']       = 'knowledge_behavior';


$config['yes_no_dont_know']       	= 'yes_no_dont_know';
$config['roof_build_with']       	= 'roof_build_with';
$config['floor_build_with']       	= 'floor_build_with';
$config['water_source']       		= 'water_source';
$config['water_source_location']    = 'water_source_location';
$config['water_collector']       	= 'water_collector';
$config['water_supplier']       	= 'water_supplier';
$config['toilet_cleaner']       	= 'toilet_cleaner';
$config['toilet_dirt_remover']      = 'toilet_dirt_remover';
$config['light_source']       		= 'light_source';
$config['hand_washing_place']       = 'hand_washing_place';
$config['toilet_type']      		= 'toilet_type';
$config['dirt_removing_type']       = 'dirt_removing_type';
$config['hand_washing_arrangement'] = 'hand_washing_arrangement';
$config['spontaneously_afterTelling_dontKnow']       = 'spontaneously_afterTelling_dontKnow';
$config['fuel_type']      			= 'fuel_type';
$config['dirt_taken_place']       	= 'dirt_taken_place';
$config['dirt_collection_time']     = 'dirt_collection_time';


// immunization
$config['information_recorded_from']       = 'information_recorded_from';
$config['child_follow_up_exit_type']       = 'child_follow_up_exit_type';
$config['why_not_seen_card']       		   = 'why_not_seen_card';
$config['interview_status_immunization']   = 'interview_status_immunization';

// family planning

$config['husband_staying_place']       						 = 'husband_staying_place';
$config['birth_control_method']       						 = 'birth_control_method';
$config['method_taken_from']       					  		 = 'method_taken_from';
$config['birth_control_method_taking_decision']      		 = 'birth_control_method_taking_decision';
$config['reason_behind_not_taking_birth_control_method']     = 'reason_behind_not_taking_birth_control_method';
$config['yes_no_pregnant_dont_know']    					 = 'yes_no_pregnant_dont_know';
$config['how_many_children']      							 = 'how_many_children';
$config['alive_children']      								 = 'alive_children';
$config['no_one_how_many_others']   						 = 'no_one_how_many_others';
$config['boy_girl_anyone']       							 = 'boy_girl_anyone';

// illness

$config['instantly_hour_day']       						= 'instantly_hour_day';
$config['drink_type']       								= 'drink_type';
$config['month_dont_know']      						    = 'month_dont_know';
$config['diarrhea_happened']       							= 'diarrhea_happened';
$config['diarrhea_type']       								= 'diarrhea_type';
$config['diarrhea_treatment_type']       					= 'diarrhea_treatment_type';
$config['treatment_taken_from']       						= 'treatment_taken_from';
$config['antibiotic_for_pneumonia']       					= 'antibiotic_for_pneumonia';
$config['interview_status_child_illness']       			= 'interview_status_child_illness';





//variable by id

$config['relationHead'] = 27;
$config['household_head_code'] = 'hhh';
$config['exitTypeDeath'] = 'dth';
$config['conceptionFollowpID'] = 90;
$config['pregnancyOutID'] = 91;
$config['femaleSexCode'] = 26;
$config['femaleSexCodeMale'] = 25;
$config['maritalStatusMarried'] = 41;
$config['maritalStatusUnMarried'] = 40;
$config['internalMovement'] = 135;
$config['migrationOutMovement'] = 79;
$config['bangladesh'] = 19;

$config['internalMovementIn'] = 134;
$config['migrationInMovement'] = 22;


$config['HHEntyMigIn'] = 15;
$config['HHEntyIntIn'] = 156;


// va list
//All option list
$config['VA_Relation'] = 'VA_Relation';
$config['va_yes_no'] = 'va_yes_no';
$config['va_gender'] = 'MEMBER_SEX_TYPE';
$config['VA_Marital_Status'] = 'MARITAL_STATUS_TYP';
$config['VA_Yes_No_Reluctant_Unknown'] = 'VA_Yes_No_Reluctant_Unknown';
$config['VA_Education_Institute_Type'] = 'VA_Education_Institute_Type';
$config['VA_Occupation_Type'] = 'OCCUPATION_TYP';
$config['VA_INJURY_OR_ACCIDENT_TYPE'] = 'VA_INJURY_OR_ACCIDENT_TYPE';
$config['VA_Road_OR_Water_Vehicle_Type'] = 'VA_Road_OR_Water_Vehicle_Type';
$config['VA_Medicine_Or_Poison_Type'] = 'VA_Medicine_Or_Poison_Type';
$config['VA_Yes_No_Reluctant_NotApplicable_Unknown'] = 'VA_Yes_No_Reluctant_NotApplicable_Unknown';
$config['VA_Death_When'] = 'VA_Death_When';
$config['VA_Delivery_Result'] = 'VA_Delivery_Result';
$config['VA_Delivery_Durability'] = 'VA_Delivery_Durability';
$config['VA_Delivery_Place'] = 'VA_Delivery_Place';
$config['VA_Delivery_Method'] = 'VA_Delivery_Method';
$config['VA_Fever_Dimension'] = 'VA_Fever_Dimension';
$config['VA_Fever_Type'] = 'VA_Fever_Type';
$config['VA_Body_Where'] = 'VA_Body_Where';
$config['VA_Grain_Type'] = 'VA_Grain_Type';
$config['VA_Arsenic_Identification_Hospital'] = 'VA_Arsenic_Identification_Hospital';
$config['VA_Swollen_Body_Part'] = 'VA_Swollen_Body_Part';
$config['VA_Glands_Swollen_Where'] = 'VA_Glands_Swollen_Where';
$config['VA_Shortness_of_breath_Body_Condition'] = 'VA_Shortness_of_breath_Body_Condition';
$config['VA_Yes_No_Unknown'] = 'VA_Yes_No_Unknown';
$config['VA_Chest_Pain_Where'] = 'VA_Chest_Pain_Where';
$config['VA_Chest_Pain_Continuous'] = 'VA_Chest_Pain_Continuous';
$config['VA_Chest_Pain_Suddenly'] = 'VA_Chest_Pain_Suddenly';
$config['VA_Chest_Pain_Stability'] = 'VA_Chest_Pain_Stability';
$config['VA_Stool_Type'] = 'VA_Stool_Type';
$config['VA_Diarrhea_Continuous'] = 'VA_Diarrhea_Continuous';
$config['VA_Vomit_Looks_Like'] = 'VA_Vomit_Looks_Like';
$config['VA_Abdominal_Pain_Type'] = 'VA_Abdominal_Pain_Type';
$config['VA_Abdominal_Pain_Where'] = 'VA_Abdominal_Pain_Where';
$config['VA_Pain_Dimension'] = 'VA_Pain_Dimension';
$config['VA_Abdominal_Pain_Stool_Look_Like'] = 'VA_Abdominal_Pain_Stool_Look_Like';
$config['VA_ABDOMINAL_DISTENSION_QUICK'] = 'VA_ABDOMINAL_DISTENSION_QUICK';
$config['VA_MASS_in_Abdomen_Strong_Wheel_Position'] = 'VA_MASS_in_Abdomen_Strong_Wheel_Position';
$config['VA_Headache_Quick_Or_Slow'] = 'VA_Headache_Quick_Or_Slow';
$config['VA_Suddenly_Slowly_Unknown'] = 'VA_Suddenly_Slowly_Unknown';
$config['VA_Status_Before_Swoon'] = 'VA_Status_Before_Swoon';
$config['VA_Paralyzed_Body_Part'] = 'VA_Paralyzed_Body_Part';
$config['VA_Paralyzed_When'] = 'VA_Paralyzed_When';
$config['VA_Urine_Color'] = 'VA_Urine_Color';
$config['VA_Urine_Dimension'] = 'VA_Urine_Dimension';
$config['VA_Drug_Collection_Place'] = 'VA_Drug_Collection_Place';
$config['VA_Treatment_Provider'] = 'VA_Treatment_Provider';
$config['VA_Death_Place'] = 'VA_Death_Place';
$config['VA_Reason_Teller'] = 'VA_Reason_Teller';
$config['VA_Hospital_List'] = 'VA_Hospital_List';
$config['VA_Supervisor_List'] = 'VA_Supervisor_List';
$config['VA_Leg_Wound'] = 'VA_Leg_Wound';
$config['VA_Weight_Loss_Type'] = 'VA_Weight_Loss_Type';
$config['VA_Breathing_Problem_Type'] = 'VA_Breathing_Problem_Type';
$config['VA_Daily_Work_Hampered_By_Breathing_Problem'] = 'VA_Daily_Work_Hampered_By_Breathing_Problem';
$config['VA_Breathing_Problem_When'] = 'VA_Breathing_Problem_When';



$config['VA_Mother_Death_When'] = 'VA_Mother_Death_When';
$config['VA_Day_Month_Reluctant_Unknown'] = 'VA_Day_Month_Reluctant_Unknown';
$config['VA_Birth_Order'] = 'VA_Birth_Order';
$config['VA_Pregnancy_Ending_Time'] = 'VA_Pregnancy_Ending_Time';
$config['VA_Related_To_EDD'] = 'VA_Related_To_EDD';
$config['VA_Baby_Movement_Feeling'] = 'VA_Baby_Movement_Feeling';
$config['VA_Water_Broken'] = 'VA_Water_Broken';
$config['VA_Baby_Single_Double'] = 'VA_Baby_Single_Double';
$config['VA_Baby_Weight'] = 'VA_Baby_Weight';
$config['VA_Baby_Body_Color'] = 'VA_Baby_Body_Color';
$config['VA_Pate_Status'] = 'VA_Pate_Status';
$config['VA_Frequently_Breathing'] = 'VA_Frequently_Breathing';
$config['VA_Baby_Cry'] = 'VA_Baby_Cry';
$config['VA_Baby_Milk'] = 'VA_Baby_Milk';
$config['VA_Baby_Drinking_Milk_Shut_Down'] = 'VA_Baby_Drinking_Milk_Shut_Down';
$config['VA_Diarrhea_Situation'] = 'VA_Diarrhea_Situation';
$config['VA_Baby_Vomit_Looks_Like'] = 'VA_Baby_Vomit_Looks_Like';
$config['VA_Birth_Weight_Source'] = 'VA_Birth_Weight_Source';
$config['VA_Child_Age'] = 'VA_Child_Age';
$config['VA_Sitting_Style'] = 'VA_Sitting_Style';
$config['va_dysentery_stop_situation'] = 'va_dysentery_stop_situation';
$config['VA_Body_Curves_Like_Bow'] = 'VA_Body_Curves_Like_Bow';
$config['VA_Weight_Specific'] = 'VA_Weight_Specific';
$config['VA_Organ_Distortion'] = 'VA_Organ_Distortion';
$config['VA_Day_Hour_Reluctant_Unknown'] = 'VA_Day_Hour_Reluctant_Unknown';



/*
|--------------------------------------------------------------------------
| Output Compression
|--------------------------------------------------------------------------
|
| Enables Gzip output compression for faster page loads.  When enabled,
| the output class will test whether your server supports Gzip.
| Even if it does, however, not all browsers support compression
| so enable only if you are reasonably sure your visitors can handle it.
|
| Only used if zlib.output_compression is turned off in your php.ini.
| Please do not use it together with httpd-level output compression.
|
| VERY IMPORTANT:  If you are getting a blank page when compression is enabled it
| means you are prematurely outputting something to your browser. It could
| even be a line of whitespace at the end of one of your scripts.  For
| compression to work, nothing can be sent before the output buffer is called
| by the output class.  Do not 'echo' any values with compression enabled.
|
*/
$config['compress_output'] = FALSE;

/*
|--------------------------------------------------------------------------
| Master Time Reference
|--------------------------------------------------------------------------
|
| Options are 'local' or any PHP supported timezone. This preference tells
| the system whether to use your server's local time as the master 'now'
| reference, or convert it to the configured one timezone. See the 'date
| helper' page of the user guide for information regarding date handling.
|
*/
$config['time_reference'] = 'local';

/*
|--------------------------------------------------------------------------
| Rewrite PHP Short Tags
|--------------------------------------------------------------------------
|
| If your PHP installation does not have short tag support enabled CI
| can rewrite the tags on-the-fly, enabling you to utilize that syntax
| in your view files.  Options are TRUE or FALSE (boolean)
|
| Note: You need to have eval() enabled for this to work.
|
*/
$config['rewrite_short_tags'] = FALSE;

/*
|--------------------------------------------------------------------------
| Reverse Proxy IPs
|--------------------------------------------------------------------------
|
| If your server is behind a reverse proxy, you must whitelist the proxy
| IP addresses from which CodeIgniter should trust headers such as
| HTTP_X_FORWARDED_FOR and HTTP_CLIENT_IP in order to properly identify
| the visitor's IP address.
|
| You can use both an array or a comma-separated list of proxy addresses,
| as well as specifying whole subnets. Here are a few examples:
|
| Comma-separated:	'10.0.1.200,192.168.5.0/24'
| Array:		array('10.0.1.200', '192.168.5.0/24')
*/
$config['proxy_ips'] = '';