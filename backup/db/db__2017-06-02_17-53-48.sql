-- mysqldump-php https://github.com/ifsnop/mysqldump-php
--
-- Host: localhost	Database: yiisnsapp_new
-- ------------------------------------------------------
-- Server version 	5.1.30-community
-- Date: Fri, 02 Jun 2017 17:53:49 +0000

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `message`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `message` (
  `id` int(11) NOT NULL DEFAULT '0',
  `language` varchar(255) NOT NULL DEFAULT '',
  `translation` text,
  PRIMARY KEY (`id`,`language`),
  CONSTRAINT `fk_source_message_message` FOREIGN KEY (`id`) REFERENCES `source_message` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `message`
--

LOCK TABLES `message` WRITE;
/*!40000 ALTER TABLE `message` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `message` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

--
-- Table structure for table `migration`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migration`
--

LOCK TABLES `migration` WRITE;
/*!40000 ALTER TABLE `migration` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `migration` VALUES ('m000000_000000_base',1490649754),('m140506_102106_rbac_init',1490649755),('m140801_201442_create_user_table',1490649764),('m140814_223103_create_user_authclient_table',1490649775),('m140902_110812_create_storage_file_table',1490649780),('m141019_100557_create_publication_table',1490649784),('m141019_162718_create_comment_table',1490649786),('m141019_162721_subscribe_create_table',1490649788),('m141019_162726_create_vote_table',1490649790),('m141104_100557_create_yiisns_tree_table',1490649795),('m141106_100557_create_user_group_table',1490649798),('m141109_100557_create_yiisns_infoblock_table',1490649800),('m141111_100557_alter_tables_tree_and_publication',1490649801),('m141116_100557_create_teable_static_block',1490649802),('m141117_100557_create_teable_site',1490649804),('m141205_100557_alter_table_published_behavior',1490649806),('m141231_100557_create_teable_yiisns_tree_menu',1490649808),('m141231_100559_alter_table_tree',1490649809),('m150116_100559_alter_table_publications',1490649810),('m150121_193200_create_table__yiisns_user_email',1490649811),('m150121_273200_create_table__yiisns_user_phone',1490649812),('m150121_273203_alter_table__yiisns_user',1490649814),('m150121_273205_alter_table__yiisns_user__add_emails',1490649815),('m150122_273205_alter_table__yiisns_user__emails_adn_phones',1490649816),('m150316_273205_alter_table__yiisns_user__emails_adn_phones_1',1490649817),('m150324_273205_alter_table__yiisns_infoblock',1490649818),('m150324_273210_alter_table__yiisns_infoblock_2',1490649818),('m150327_273210_create_table__yiisns_settings',1490649819),('m150512_103210_create_table__yiisns_content_type',1490649821),('m150512_103220_create_table__yiisns_content',1490649824),('m150512_103230_create_table__yiisns_content_element',1490649829),('m150512_113230_create_table__yiisns_content_property',1490649833),('m150512_123230_create_table__yiisns_content_property_enum',1490649836),('m150512_153230_create_table__yiisns_content_element_property',1490649839),('m150516_103230_create_table__yiisns_content_element_tree',1490649841),('m150519_103210_drop_tables_social',1490649841),('m150519_113210_yiisns_alter_clear_social_data',1490649845),('m150519_123210_yiisns_alter_drop_publications_and_page_options',1490649845),('m150520_103210_yiisns_alter_user_data',1490649846),('m150520_133210_yiisns_alter_storage_files',1490649848),('m150520_143210_yiisns_alter_yiisns_tree',1490649850),('m150520_153210_yiisns_alter_meta_data',1490649851),('m150520_153305_yiisns_alter_table__yiisns_lang',1490649854),('m150520_153310_yiisns_alter_table__yiisns_site',1490649856),('m150520_163310_insert_yiisns_site_and_lang',1490649856),('m150520_173310_create_table__yiisns_site_domain',1490649858),('m150520_183310_alter_table__yiisns_tree',1490649859),('m150521_183310_alter_table__yiisns_tree',1490649860),('m150521_183315_alter_table__yiisns_tree',1490649860),('m150521_193315_alter_table__yiisns_settings',1490649860),('m150522_193315_drop_table__yiisns_infoblock',1490649860),('m150523_103220_create_table__yiisns_tree_type',1490649863),('m150523_103520_create_table__yiisns_tree_type_property',1490649868),('m150523_103525_create_table__yiisns_tree_type_property_enum',1490649870),('m150523_104025_create_table__yiisns_tree_property',1490649873),('m150523_114025_alter_table__yiisns_tree',1490649874),('m150528_114025_alter_table__yiisns_component_settings',1490649876),('m150528_114030_alter_table__yiisns_component_settings',1490649876),('m150604_114030_alter_table__yiisns_user',1490649878),('m150607_114030_alter_table__yiisns_tree_and_yiisns_content_element',1490649880),('m150608_114030_alter_table__yiisns_site_code_length',1490649881),('m150608_154030_alter_table__yiisns_user_emails_and_phones',1490649882),('m150615_162718_create_table__form2_form',1490649884),('m150615_162740_create_table__form2_form_send',1490649887),('m150615_172718_create_table__form2_form_property',1490649892),('m150615_182718_create_table__form2_form_property_enum',1490649895),('m150615_192740_create_table__form2_form_send_property',1490649897),('m150622_114030_alter_table__yiisns_user',1490649898),('m150702_114030_alter_table__yiisns_user',1490649899),('m150707_114030_alter_table__big_text',1490649902),('m150715_103220_create_table__yiisns_agent',1490649903),('m150715_162718_create_table__log_db_target',1490649904),('m150730_103220_create_table__yiisns_session',1490649904),('m150730_213220_create_table__yiisns_event',1490649905),('m150806_213220_alter_table__yiisns_tree_type_property',1490649906),('m150807_213220_alter_table__yiisns_content_property',1490649906),('m150819_162718_create_table__comments2_message',1492325257),('m150825_213220_delete_table__yiisns_user_group',1490649907),('m150826_113220_create_table__yiisns_user_universal_property',1490649911),('m150826_123220_create_table__yiisns_user_universal_property_enum',1490649914),('m150826_133220_create_table__yiisns_user_property',1490649916),('m150827_133220_create_table__yiisns_search_phrase',1490649919),('m150922_213220_alter_table__yiisns_user',1490649919),('m150922_223220_update_data__yiisns_user',1490649919),('m150922_233220_alter_table__yiisns_tree',1490649921),('m150922_234220_update_data__yiisns_tree',1490649921),('m150922_235220_alter_table__yiisns_content_element',1490649923),('m150922_235320_update_data__yiisns_content_element',1490649923),('m150922_235520_alter_table__drop_files_column',1490649924),('m150923_133220_create_table__yiisns_tree_image',1490649926),('m150923_143220_create_table__yiisns_tree_file',1490649929),('m150923_153220_create_table__yiisns_content_element_image',1490649932),('m150923_163220_create_table__yiisns_content_element_file',1490649934),('m150923_173220_update_data__images_and_files',1490649935),('m150923_183220_alter_table__tree__content_element',1490649935),('m150924_183220_alter_table__yiisns_user',1490649936),('m150924_193220_alter_table__yiisns_user_email',1490649936),('m151023_113220_alter_table__yiisns_site',1490649937),('m151023_153220_alter_table__yiisns_content',1490649938),('m151023_163220_alter_table__yiisns_content',1490649939),('m151023_173220_alter_table__yiisns_tree_type',1490649940),('m151030_173220_alter_table__yiisns_tree',1490649940),('m151030_183220_alter_table__yiisns_tree',1490649941),('m151030_193220_alter_table__yiisns_tree',1490649942),('m151110_193220_alter_table__yiisns_content',1490649942),('m151113_113220_alter_table__yiisns_site_and_lang',1490649943),('m151215_193220_alter_table__yiisns_content',1490649944),('m151221_093837_addI18nTables',1490649944),('m160215_093837__create_table__yiisns_dashboard',1490649947),('m160216_093837__create_table__yiisns_dashboard_widget',1490649949),('m160221_193220__alter_table__yiisns_tree',1490649950),('m160222_193220__alter_table__yiisns_content',1490649951),('m160222_203220__alter_table__yiisns_content',1490649952),('m160313_203220__alter_table__yiisns_storage_file',1490649954),('m160315_093837__create_table__yiisns_user2yiisns_content_elements',1490649956),('m160319_093837__drop_table__yiisns_session',1490649956),('m160320_093837__alter_table__yiisns_storage_file',1490649957),('m160320_103837__alter_table__yiisns_user',1490649959),('m160329_103837__alter_table__yiisns_user',1490649960),('m160329_113837__update_data__yiisns_user',1490649960),('m160412_113837__drop_table__yiisns_tree_menu',1490649960),('m160413_103837__alter_table__yiisns_content_element',1490649961),('m160415_093837_create_table__yiisns_search_phrase',1490649961),('m160417_103220_create_table__yiisns_agent',1490649961),('m160422_162718_alter_table__log_db_target',1490649961),('m160522_093837__create_table__yiisns_admin_filter',1490649963),('m160701_192740_alter_table__form2_form_send_property',1490649964);
/*!40000 ALTER TABLE `migration` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

--
-- Table structure for table `source_message`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `source_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(255) DEFAULT NULL,
  `message` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `source_message`
--

LOCK TABLES `source_message` WRITE;
/*!40000 ALTER TABLE `source_message` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `source_message` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

--
-- Table structure for table `yiisns_admin_filter`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yiisns_admin_filter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `is_default` int(11) DEFAULT NULL,
  `name` varchar(64) DEFAULT NULL,
  `namespace` varchar(255) NOT NULL,
  `values` text COMMENT 'Values filters',
  `visibles` text COMMENT 'Visible fields',
  PRIMARY KEY (`id`),
  KEY `updated_by` (`updated_by`),
  KEY `created_by` (`created_by`),
  KEY `created_at` (`created_at`),
  KEY `updated_at` (`updated_at`),
  KEY `user_id` (`user_id`),
  KEY `unique_default` (`is_default`,`namespace`,`user_id`),
  CONSTRAINT `yiisns_admin_filter_user_id` FOREIGN KEY (`user_id`) REFERENCES `yiisns_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `yiisns_admin_filter__created_by` FOREIGN KEY (`created_by`) REFERENCES `yiisns_user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `yiisns_admin_filter__updated_by` FOREIGN KEY (`updated_by`) REFERENCES `yiisns_user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8 COMMENT='Filters in the administrative part';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yiisns_admin_filter`
--

LOCK TABLES `yiisns_admin_filter` WRITE;
/*!40000 ALTER TABLE `yiisns_admin_filter` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `yiisns_admin_filter` VALUES (1,1,1,1490651779,1490651779,1,1,NULL,'cms/admin-cms-lang','',''),(2,1,1,1490651903,1490651903,1,1,NULL,'rbac/admin-role','',''),(3,1,1,1490651925,1490651925,1,1,'','cms/admin-user','',''),(4,1,1,1490653280,1490653280,1,1,NULL,'rbac/admin-permission','',''),(5,1,1,1490654352,1490654352,1,1,NULL,'cms/admin-cms-content-type','',''),(6,1,1,1490682541,1490682541,1,1,NULL,'cms/admin-user-phone','',''),(8,1,1,1490684262,1490684262,1,1,NULL,'form2/admin-form','',''),(9,1,1,1490684269,1490684269,1,1,NULL,'form2/admin-form-send','',''),(11,1,1,1490688630,1490688630,1,1,NULL,'cms/admin-user-email','',''),(12,1,1,1490689079,1490689079,1,1,NULL,'cmsAgent/admin-cms-agent','',''),(13,1,1,1490689136,1490689136,1,1,NULL,'logDbTarget/admin-log-db-target','',''),(14,1,1,1490790110,1490790110,1,1,NULL,'cms/admin-cms-tree-type','',''),(16,1,1,1490801795,1490801795,1,1,NULL,'cms/admin-storage-files','',''),(17,1,1,1490802886,1490802886,1,1,NULL,'cms/admin-cms-content-element_1','',''),(20,1,1,1490905954,1491997206,1,1,NULL,'cms/admin-cms-site','','cmssite-name'),(21,1,1,1491099319,1491099319,1,1,NULL,'cms/admin-cms-content-element_2','',''),(22,1,1,1491367736,1491367736,1,1,NULL,'cms/admin-cms-content-element_3','',''),(23,1,1,1491968018,1491968018,1,1,NULL,'cms/admin-cms-content-element_4','',''),(24,1,1,1492960934,1492960934,1,1,NULL,'admin/admin-user','',''),(25,1,1,1492969186,1492969186,1,1,NULL,'admin/admin-cms-site','',''),(26,1,1,1492969202,1492969202,1,1,NULL,'admin/admin-cms-lang','',''),(27,1,1,1492969234,1492969234,1,1,NULL,'admin/admin-cms-tree-type','',''),(28,1,1,1492969239,1492969239,1,1,NULL,'admin/admin-cms-content-type','',''),(29,1,1,1493003422,1493003422,1,1,NULL,'admin/admin-cms-content-element_3','',''),(30,1,1,1493004269,1493004269,1,1,NULL,'admin/admin-cms-content-element_4','',''),(31,1,1,1493404612,1493404612,1,1,NULL,'admin/admin-user-email','',''),(32,1,1,1493404616,1493404616,1,1,NULL,'admin/admin-user-phone','',''),(33,1,1,1493648766,1493648766,1,1,NULL,'admin/admin-storage-files','',''),(34,2,2,1495893140,1495893140,2,1,NULL,'cms/admin-user','',''),(35,2,2,1495893157,1495893157,2,1,NULL,'cms/admin-cms-content-type','',''),(36,2,2,1495893162,1495893162,2,1,NULL,'cms/admin-cms-site','',''),(37,2,2,1495893440,1495893440,2,1,NULL,'cmsAgent/admin-cms-agent','','');
/*!40000 ALTER TABLE `yiisns_admin_filter` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

--
-- Table structure for table `yiisns_agent`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yiisns_agent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `last_exec_at` int(11) DEFAULT NULL,
  `next_exec_at` int(11) NOT NULL,
  `name` text NOT NULL,
  `description` text,
  `agent_interval` int(11) NOT NULL DEFAULT '86400',
  `priority` int(11) NOT NULL DEFAULT '100',
  `active` char(1) NOT NULL DEFAULT 'Y',
  `is_period` char(1) NOT NULL DEFAULT 'Y',
  `is_running` char(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`id`),
  KEY `last_exec_at` (`last_exec_at`),
  KEY `next_exec_at` (`next_exec_at`),
  KEY `agent_interval` (`agent_interval`),
  KEY `priority` (`priority`),
  KEY `active` (`active`),
  KEY `is_period` (`is_period`),
  KEY `is_running` (`is_running`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Агенты';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yiisns_agent`
--

LOCK TABLES `yiisns_agent` WRITE;
/*!40000 ALTER TABLE `yiisns_agent` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `yiisns_agent` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

--
-- Table structure for table `yiisns_auth_assignment`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yiisns_auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  KEY `auth_assignment_user_id` (`user_id`),
  CONSTRAINT `yiisns_auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `yiisns_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_assignment_user_id` FOREIGN KEY (`user_id`) REFERENCES `yiisns_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yiisns_auth_assignment`
--

LOCK TABLES `yiisns_auth_assignment` WRITE;
/*!40000 ALTER TABLE `yiisns_auth_assignment` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `yiisns_auth_assignment` VALUES ('admin',1,1495540459),('editor',2,1495893318),('root',1,1490650357);
/*!40000 ALTER TABLE `yiisns_auth_assignment` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

--
-- Table structure for table `yiisns_auth_item`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yiisns_auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`),
  CONSTRAINT `yiisns_auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `yiisns_auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yiisns_auth_item`
--

LOCK TABLES `yiisns_auth_item` WRITE;
/*!40000 ALTER TABLE `yiisns_auth_item` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `yiisns_auth_item` VALUES ('admin',1,'Administrator',NULL,NULL,1490650354,1490650354),('admin/clear',2,'Administration | Delete temporary files',NULL,NULL,1490687691,1490687691),('approved',1,'Authenticated user',NULL,NULL,1490650354,1490650354),('cms.admin-access',2,'Access to system administration',NULL,NULL,1490650354,1490650354),('cms.admin-dashboards-edit',2,'Access to edit dashboards',NULL,NULL,1490650355,1490650355),('cms.controll-panel-access',2,'Access site management panel',NULL,NULL,1490650354,1490650354),('cms.edit-view-files',2,'The ability to edit view files',NULL,NULL,1490650354,1490650354),('cms.elfinder-additional-files',2,'Access to all files',NULL,NULL,1490650355,1490650355),('cms.elfinder-common-public-files',2,'Access to the general public files',NULL,NULL,1490650355,1490650355),('cms.elfinder-user-files',2,'Access to personal files',NULL,NULL,1490650355,1490650355),('cms.model-create',2,'The ability to create records',NULL,NULL,1490650354,1490650354),('cms.model-delete',2,'The ability to delete records',NULL,NULL,1490650355,1490650355),('cms.model-delete-own',2,'Remove of their records','isAuthor',NULL,1490650355,1490650355),('cms.model-update',2,'Update of the data record',NULL,NULL,1490650355,1490650355),('cms.model-update-advanced',2,'Additional data records',NULL,NULL,1490650355,1490650355),('cms.model-update-advanced-own',2,'Update their records additional data','isAuthor',NULL,1490650355,1490650355),('cms.model-update-own',2,'Update their record data','isAuthor',NULL,1490650355,1490650355),('cms.user-full-edit',2,'The ability to manage user groups',NULL,NULL,1490650355,1490650355),('cms/admin-cms-content-element__1',2,'',NULL,NULL,1490802037,1490802037),('cms/admin-cms-content-element__2',2,'',NULL,NULL,1491099194,1491099194),('cms/admin-cms-content-element__3',2,'',NULL,NULL,1491366929,1491366929),('cms/admin-cms-content-element__4',2,'',NULL,NULL,1491967977,1491967977),('cms/admin-cms-content-type',2,'Administration | Content management',NULL,NULL,1490687691,1490687691),('cms/admin-cms-lang',2,'Administration | Language Management',NULL,NULL,1490687690,1490687690),('cms/admin-cms-site',2,'Administration | Site management',NULL,NULL,1490687690,1490687690),('cms/admin-cms-tree-type',2,'Administration | Configuration sections',NULL,NULL,1490687691,1490687691),('cms/admin-cms-user-universal-property',2,'Administration | User control property',NULL,NULL,1490687690,1490687690),('cms/admin-file-manager',2,'Administration | File manager',NULL,NULL,1490687690,1490687690),('cms/admin-settings',2,'',NULL,NULL,1490804824,1490804824),('cms/admin-storage',2,'Administration | Management of servers',NULL,NULL,1490687690,1490687690),('cms/admin-storage-files',2,'Administration | Management of files storage',NULL,NULL,1490687690,1490687690),('cms/admin-tree',2,'Administration | A tree of pages',NULL,NULL,1490687690,1490687690),('cms/admin-user',2,'Administration | Management of users',NULL,NULL,1490687690,1490687690),('cms/admin-user-email',2,'Administration | Management of email addresses',NULL,NULL,1490687690,1490687690),('cms/admin-user-phone',2,'Administration | management of phone',NULL,NULL,1490687690,1490687690),('cmsMarketplace/admin-marketplace',2,'Administration | Marketplace',NULL,NULL,1490687691,1490687691),('editor',1,'Editor (access to administration)',NULL,NULL,1490650354,1490650354),('guest',1,'Unauthorized user',NULL,NULL,1490650354,1490650354),('manager',1,'Manager (access to administration)',NULL,NULL,1490650354,1490650354),('rbac/admin-permission',2,'Administration | Privilege management',NULL,NULL,1490687690,1490687690),('rbac/admin-role',2,'Administration | Roles management',NULL,NULL,1490687690,1490687690),('root',1,'Superuser',NULL,NULL,1490650357,1490650357),('user',1,'Registered user',NULL,NULL,1490650355,1490650355);
/*!40000 ALTER TABLE `yiisns_auth_item` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

--
-- Table structure for table `yiisns_auth_item_child`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yiisns_auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `yiisns_auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `yiisns_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `yiisns_auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `yiisns_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yiisns_auth_item_child`
--

LOCK TABLES `yiisns_auth_item_child` WRITE;
/*!40000 ALTER TABLE `yiisns_auth_item_child` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `yiisns_auth_item_child` VALUES ('root','admin'),('cms.admin-dashboards-edit','admin/clear'),('root','admin/clear'),('root','approved'),('admin','cms.admin-access'),('editor','cms.admin-access'),('manager','cms.admin-access'),('root','cms.admin-access'),('root','cms.admin-dashboards-edit'),('admin','cms.controll-panel-access'),('editor','cms.controll-panel-access'),('manager','cms.controll-panel-access'),('root','cms.controll-panel-access'),('root','cms.edit-view-files'),('admin','cms.elfinder-additional-files'),('root','cms.elfinder-additional-files'),('admin','cms.elfinder-common-public-files'),('editor','cms.elfinder-common-public-files'),('manager','cms.elfinder-common-public-files'),('root','cms.elfinder-common-public-files'),('admin','cms.elfinder-user-files'),('editor','cms.elfinder-user-files'),('manager','cms.elfinder-user-files'),('root','cms.elfinder-user-files'),('admin','cms.model-create'),('editor','cms.model-create'),('manager','cms.model-create'),('root','cms.model-create'),('admin','cms.model-delete'),('cms.model-delete-own','cms.model-delete'),('manager','cms.model-delete'),('root','cms.model-delete'),('editor','cms.model-delete-own'),('root','cms.model-delete-own'),('admin','cms.model-update'),('cms.model-update-own','cms.model-update'),('manager','cms.model-update'),('root','cms.model-update'),('admin','cms.model-update-advanced'),('cms.model-update-advanced-own','cms.model-update-advanced'),('root','cms.model-update-advanced'),('root','cms.model-update-advanced-own'),('editor','cms.model-update-own'),('root','cms.model-update-own'),('root','cms.user-full-edit'),('root','cms/admin-cms-content-element__1'),('root','cms/admin-cms-content-element__2'),('root','cms/admin-cms-content-element__3'),('root','cms/admin-cms-content-element__4'),('root','cms/admin-cms-content-type'),('root','cms/admin-cms-lang'),('root','cms/admin-cms-site'),('root','cms/admin-cms-tree-type'),('root','cms/admin-cms-user-universal-property'),('root','cms/admin-file-manager'),('root','cms/admin-settings'),('root','cms/admin-storage'),('root','cms/admin-storage-files'),('root','cms/admin-tree'),('root','cms/admin-user'),('root','cms/admin-user-email'),('root','cms/admin-user-phone'),('root','cmsMarketplace/admin-marketplace'),('root','editor'),('root','guest'),('root','manager'),('root','rbac/admin-permission'),('root','rbac/admin-role'),('root','user');
/*!40000 ALTER TABLE `yiisns_auth_item_child` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

--
-- Table structure for table `yiisns_auth_rule`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yiisns_auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yiisns_auth_rule`
--

LOCK TABLES `yiisns_auth_rule` WRITE;
/*!40000 ALTER TABLE `yiisns_auth_rule` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `yiisns_auth_rule` VALUES ('isAuthor','O:22:\"yiisns\\rbac\\AuthorRule\":3:{s:4:\"name\";s:8:\"isAuthor\";s:9:\"createdAt\";i:1490650354;s:9:\"updatedAt\";i:1490650354;}',1490650354,1490650354);
/*!40000 ALTER TABLE `yiisns_auth_rule` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

--
-- Table structure for table `yiisns_component_settings`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yiisns_component_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `component` varchar(255) DEFAULT NULL,
  `value` longtext,
  `site_code` char(15) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `lang_code` char(5) DEFAULT NULL,
  `namespace` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `updated_by` (`updated_by`),
  KEY `created_by` (`created_by`),
  KEY `created_at` (`created_at`),
  KEY `updated_at` (`updated_at`),
  KEY `component` (`component`),
  KEY `site_code` (`site_code`),
  KEY `user_id` (`user_id`),
  KEY `lang_code` (`lang_code`),
  KEY `namespace` (`namespace`),
  CONSTRAINT `yiisns_component_settings_lang_code` FOREIGN KEY (`lang_code`) REFERENCES `yiisns_lang` (`code`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `yiisns_component_settings_site_code` FOREIGN KEY (`site_code`) REFERENCES `yiisns_site` (`code`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `yiisns_component_settings_user_id` FOREIGN KEY (`user_id`) REFERENCES `yiisns_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `yiisns_settings_created_by` FOREIGN KEY (`created_by`) REFERENCES `yiisns_user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `yiisns_settings_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `yiisns_user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yiisns_component_settings`
--

LOCK TABLES `yiisns_component_settings` WRITE;
/*!40000 ALTER TABLE `yiisns_component_settings` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `yiisns_component_settings` VALUES (18,1,1,1491451706,1491451706,'skeeks\\cms\\modules\\admin\\widgets\\gridView\\GridViewSettings','{\"enabledPjaxPagination\":\"Y\",\"pageSize\":\"10\",\"pageSizeLimitMin\":\"1\",\"pageSizeLimitMax\":\"500\",\"pageParamName\":\"page\",\"visibleColumns\":\"\",\"grid\":null,\"orderBy\":\"id\",\"order\":\"3\",\"defaultAttributes\":{\"enabledPjaxPagination\":\"Y\",\"pageSize\":\"10\",\"pageSizeLimitMin\":\"1\",\"pageSizeLimitMax\":\"500\",\"pageParamName\":\"page\",\"visibleColumns\":[],\"grid\":null,\"orderBy\":\"id\",\"order\":3,\"defaultAttributes\":[],\"namespace\":\"cms/admin-cms-lang/index\"},\"namespace\":\"cms/admin-cms-lang/index\"}',NULL,NULL,NULL,'cms/admin-cms-lang/index'),(39,1,1,1495635503,1496391284,'skeeks\\cms\\modules\\admin\\components\\settings\\AdminSettings','{\"languageCode\":\"zh-CN\"}',NULL,1,NULL,NULL),(47,1,1,1496422658,1496422660,'skeeks\\cms\\components\\CmsToolbar','{\"isOpen\":\"N\"}',NULL,1,NULL,NULL);
/*!40000 ALTER TABLE `yiisns_component_settings` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

--
-- Table structure for table `yiisns_content`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yiisns_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(50) NOT NULL,
  `active` char(1) NOT NULL DEFAULT 'Y',
  `priority` int(11) NOT NULL DEFAULT '500',
  `description` text,
  `index_for_search` char(1) NOT NULL DEFAULT 'Y',
  `name_meny` varchar(100) DEFAULT NULL,
  `name_one` varchar(100) DEFAULT NULL,
  `tree_chooser` char(1) DEFAULT NULL,
  `list_mode` char(1) DEFAULT NULL,
  `content_type` varchar(32) NOT NULL,
  `default_tree_id` int(11) DEFAULT NULL,
  `is_allow_change_tree` varchar(1) NOT NULL DEFAULT 'Y',
  `root_tree_id` int(11) DEFAULT NULL,
  `viewFile` varchar(255) DEFAULT NULL,
  `meta_title_template` varchar(500) DEFAULT NULL,
  `meta_description_template` text,
  `meta_keywords_template` text,
  `access_check_element` varchar(1) NOT NULL DEFAULT 'N',
  `parent_content_id` int(11) DEFAULT NULL,
  `visible` varchar(1) NOT NULL DEFAULT 'Y',
  `parent_content_on_delete` varchar(10) NOT NULL DEFAULT 'CASCADE',
  `parent_content_is_required` varchar(1) NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `updated_by` (`updated_by`),
  KEY `created_by` (`created_by`),
  KEY `created_at` (`created_at`),
  KEY `updated_at` (`updated_at`),
  KEY `priority` (`priority`),
  KEY `name` (`name`),
  KEY `active` (`active`),
  KEY `index_for_search` (`index_for_search`),
  KEY `name_meny` (`name_meny`),
  KEY `name_one` (`name_one`),
  KEY `tree_chooser` (`tree_chooser`),
  KEY `list_mode` (`list_mode`),
  KEY `content_type` (`content_type`),
  KEY `default_tree_id` (`default_tree_id`),
  KEY `is_allow_change_tree` (`is_allow_change_tree`),
  KEY `root_tree_id` (`root_tree_id`),
  KEY `viewFile` (`viewFile`),
  KEY `parent_content_id` (`parent_content_id`),
  KEY `visible` (`visible`),
  KEY `parent_content_on_delete` (`parent_content_on_delete`),
  KEY `parent_content_is_required` (`parent_content_is_required`),
  CONSTRAINT `yiisns_content_yiisns_content_type` FOREIGN KEY (`content_type`) REFERENCES `yiisns_content_type` (`code`),
  CONSTRAINT `yiisns_content_created_by` FOREIGN KEY (`created_by`) REFERENCES `yiisns_user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `yiisns_content_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `yiisns_user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `yiisns_content__yiisns_content` FOREIGN KEY (`parent_content_id`) REFERENCES `yiisns_content` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `yiisns_content__default_tree_id` FOREIGN KEY (`default_tree_id`) REFERENCES `yiisns_tree` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `yiisns_content__root_tree_id` FOREIGN KEY (`root_tree_id`) REFERENCES `yiisns_tree` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yiisns_content`
--

LOCK TABLES `yiisns_content` WRITE;
/*!40000 ALTER TABLE `yiisns_content` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `yiisns_content` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

--
-- Table structure for table `yiisns_content_element`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yiisns_content_element` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `published_at` int(11) DEFAULT NULL,
  `published_to` int(11) DEFAULT NULL,
  `priority` int(11) NOT NULL DEFAULT '500',
  `active` char(1) NOT NULL DEFAULT 'Y',
  `name` varchar(255) NOT NULL,
  `image_id` int(11) DEFAULT NULL,
  `image_full_id` int(11) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `description_short` longtext,
  `description_full` longtext,
  `content_id` int(11) DEFAULT NULL,
  `tree_id` int(11) DEFAULT NULL,
  `show_counter` int(11) DEFAULT NULL,
  `show_counter_start` int(11) DEFAULT NULL,
  `meta_title` varchar(500) NOT NULL,
  `meta_description` text,
  `meta_keywords` text,
  `description_short_type` varchar(10) NOT NULL DEFAULT 'text',
  `description_full_type` varchar(10) NOT NULL DEFAULT 'text',
  `parent_content_element_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `content_id_2` (`content_id`,`code`),
  UNIQUE KEY `tree_id_2` (`tree_id`,`code`),
  KEY `updated_by` (`updated_by`),
  KEY `created_by` (`created_by`),
  KEY `created_at` (`created_at`),
  KEY `updated_at` (`updated_at`),
  KEY `published_at` (`published_at`),
  KEY `published_to` (`published_to`),
  KEY `priority` (`priority`),
  KEY `name` (`name`),
  KEY `code` (`code`),
  KEY `active` (`active`),
  KEY `content_id` (`content_id`),
  KEY `tree_id` (`tree_id`),
  KEY `show_counter` (`show_counter`),
  KEY `show_counter_start` (`show_counter_start`),
  KEY `meta_title` (`meta_title`(255)),
  KEY `description_short_type` (`description_short_type`),
  KEY `description_full_type` (`description_full_type`),
  KEY `image_id` (`image_id`),
  KEY `image_full_id` (`image_full_id`),
  KEY `parent_content_element_id` (`parent_content_element_id`),
  CONSTRAINT `yiisns_content_element_content_id` FOREIGN KEY (`content_id`) REFERENCES `yiisns_content` (`id`),
  CONSTRAINT `yiisns_content_element_created_by` FOREIGN KEY (`created_by`) REFERENCES `yiisns_user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `yiisns_content_element_tree_id` FOREIGN KEY (`tree_id`) REFERENCES `yiisns_tree` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `yiisns_content_element_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `yiisns_user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `yiisns_content_element__yiisns_content_element` FOREIGN KEY (`parent_content_element_id`) REFERENCES `yiisns_content_element` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `yiisns_content_element__image_full_id` FOREIGN KEY (`image_full_id`) REFERENCES `yiisns_storage_file` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `yiisns_content_element__image_id` FOREIGN KEY (`image_id`) REFERENCES `yiisns_storage_file` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yiisns_content_element`
--

LOCK TABLES `yiisns_content_element` WRITE;
/*!40000 ALTER TABLE `yiisns_content_element` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `yiisns_content_element` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

--
-- Table structure for table `yiisns_content_element2yiisns_user`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yiisns_content_element2yiisns_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `yiisns_user_id` int(11) NOT NULL,
  `yiisns_content_element_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user2elements` (`yiisns_user_id`,`yiisns_content_element_id`),
  KEY `updated_by` (`updated_by`),
  KEY `created_by` (`created_by`),
  KEY `created_at` (`created_at`),
  KEY `updated_at` (`updated_at`),
  KEY `yiisns_content_element2yiisns_user__yiisns_content_element_id` (`yiisns_content_element_id`),
  CONSTRAINT `yiisns_content_element2yiisns_user__yiisns_content_element_id` FOREIGN KEY (`yiisns_content_element_id`) REFERENCES `yiisns_content_element` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `yiisns_content_element2yiisns_user__yiisns_user_id` FOREIGN KEY (`yiisns_user_id`) REFERENCES `yiisns_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `yiisns_content_element2yiisns_user__created_by` FOREIGN KEY (`created_by`) REFERENCES `yiisns_user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `yiisns_content_element2yiisns_user__updated_by` FOREIGN KEY (`updated_by`) REFERENCES `yiisns_user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Favorites content items';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yiisns_content_element2yiisns_user`
--

LOCK TABLES `yiisns_content_element2yiisns_user` WRITE;
/*!40000 ALTER TABLE `yiisns_content_element2yiisns_user` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `yiisns_content_element2yiisns_user` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

--
-- Table structure for table `yiisns_content_element_file`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yiisns_content_element_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `storage_file_id` int(11) NOT NULL,
  `content_element_id` int(11) NOT NULL,
  `priority` int(11) NOT NULL DEFAULT '100',
  PRIMARY KEY (`id`),
  UNIQUE KEY `storage_file_id__content_element_id` (`storage_file_id`,`content_element_id`),
  KEY `updated_by` (`updated_by`),
  KEY `created_by` (`created_by`),
  KEY `created_at` (`created_at`),
  KEY `updated_at` (`updated_at`),
  KEY `storage_file_id` (`storage_file_id`),
  KEY `content_element_id` (`content_element_id`),
  KEY `priority` (`priority`),
  CONSTRAINT `yiisns_content_element_file_created_by` FOREIGN KEY (`created_by`) REFERENCES `yiisns_user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `yiisns_content_element_file_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `yiisns_user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `yiisns_content_element_file__content_element_id` FOREIGN KEY (`content_element_id`) REFERENCES `yiisns_content_element` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `yiisns_content_element_file__storage_file_id` FOREIGN KEY (`storage_file_id`) REFERENCES `yiisns_storage_file` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Связь элементов и файлов';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yiisns_content_element_file`
--

LOCK TABLES `yiisns_content_element_file` WRITE;
/*!40000 ALTER TABLE `yiisns_content_element_file` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `yiisns_content_element_file` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

--
-- Table structure for table `yiisns_content_element_image`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yiisns_content_element_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `storage_file_id` int(11) NOT NULL,
  `content_element_id` int(11) NOT NULL,
  `priority` int(11) NOT NULL DEFAULT '100',
  PRIMARY KEY (`id`),
  UNIQUE KEY `storage_file_id__content_element_id` (`storage_file_id`,`content_element_id`),
  KEY `updated_by` (`updated_by`),
  KEY `created_by` (`created_by`),
  KEY `created_at` (`created_at`),
  KEY `updated_at` (`updated_at`),
  KEY `storage_file_id` (`storage_file_id`),
  KEY `content_element_id` (`content_element_id`),
  KEY `priority` (`priority`),
  CONSTRAINT `yiisns_content_element_image_created_by` FOREIGN KEY (`created_by`) REFERENCES `yiisns_user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `yiisns_content_element_image_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `yiisns_user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `yiisns_content_element_image__content_element_id` FOREIGN KEY (`content_element_id`) REFERENCES `yiisns_content_element` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `yiisns_content_element_image__storage_file_id` FOREIGN KEY (`storage_file_id`) REFERENCES `yiisns_storage_file` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Связь элементов и файлов изображений';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yiisns_content_element_image`
--

LOCK TABLES `yiisns_content_element_image` WRITE;
/*!40000 ALTER TABLE `yiisns_content_element_image` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `yiisns_content_element_image` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

--
-- Table structure for table `yiisns_content_element_property`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yiisns_content_element_property` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `property_id` int(11) DEFAULT NULL,
  `element_id` int(11) DEFAULT NULL,
  `value` longtext NOT NULL,
  `value_enum` int(11) DEFAULT NULL,
  `value_num` decimal(18,4) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `updated_by` (`updated_by`),
  KEY `created_by` (`created_by`),
  KEY `created_at` (`created_at`),
  KEY `updated_at` (`updated_at`),
  KEY `property_id` (`property_id`),
  KEY `element_id` (`element_id`),
  KEY `value_enum` (`value_enum`),
  KEY `value_num` (`value_num`),
  KEY `description` (`description`),
  CONSTRAINT `yiisns_content_element_property_created_by` FOREIGN KEY (`created_by`) REFERENCES `yiisns_user` (`id`),
  CONSTRAINT `yiisns_content_element_property_element_id` FOREIGN KEY (`element_id`) REFERENCES `yiisns_content_element` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `yiisns_content_element_property_property_id` FOREIGN KEY (`property_id`) REFERENCES `yiisns_content_property` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `yiisns_content_element_property_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `yiisns_user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Связь товара свойства и значения';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yiisns_content_element_property`
--

LOCK TABLES `yiisns_content_element_property` WRITE;
/*!40000 ALTER TABLE `yiisns_content_element_property` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `yiisns_content_element_property` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

--
-- Table structure for table `yiisns_content_element_tree`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yiisns_content_element_tree` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `element_id` int(11) NOT NULL,
  `tree_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `element_id_2` (`element_id`,`tree_id`),
  KEY `updated_by` (`updated_by`),
  KEY `created_by` (`created_by`),
  KEY `created_at` (`created_at`),
  KEY `updated_at` (`updated_at`),
  KEY `tree_id` (`tree_id`),
  KEY `element_id` (`element_id`),
  CONSTRAINT `yiisns_content_element_tree_created_by` FOREIGN KEY (`created_by`) REFERENCES `yiisns_user` (`id`),
  CONSTRAINT `yiisns_content_element_tree_element_id` FOREIGN KEY (`element_id`) REFERENCES `yiisns_content_element` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `yiisns_content_element_tree_tree_id` FOREIGN KEY (`tree_id`) REFERENCES `yiisns_tree` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `yiisns_content_element_tree_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `yiisns_user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Связь контента и разделов';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yiisns_content_element_tree`
--

LOCK TABLES `yiisns_content_element_tree` WRITE;
/*!40000 ALTER TABLE `yiisns_content_element_tree` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `yiisns_content_element_tree` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

--
-- Table structure for table `yiisns_content_property`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yiisns_content_property` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(64) DEFAULT NULL,
  `content_id` int(11) DEFAULT NULL,
  `active` char(1) NOT NULL DEFAULT 'Y',
  `priority` int(11) NOT NULL DEFAULT '500',
  `property_type` char(1) NOT NULL DEFAULT 'S',
  `list_type` char(1) NOT NULL DEFAULT 'L',
  `multiple` char(1) NOT NULL DEFAULT 'N',
  `multiple_cnt` int(11) DEFAULT NULL,
  `with_description` char(1) DEFAULT NULL,
  `searchable` char(1) NOT NULL DEFAULT 'N',
  `filtrable` char(1) NOT NULL DEFAULT 'N',
  `is_required` char(1) DEFAULT NULL,
  `version` int(11) NOT NULL DEFAULT '1',
  `component` varchar(255) DEFAULT NULL,
  `component_settings` longtext,
  `hint` varchar(255) DEFAULT NULL,
  `smart_filtrable` char(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`id`),
  UNIQUE KEY `code_2` (`code`,`content_id`),
  KEY `updated_by` (`updated_by`),
  KEY `created_by` (`created_by`),
  KEY `created_at` (`created_at`),
  KEY `updated_at` (`updated_at`),
  KEY `name` (`name`),
  KEY `content_id` (`content_id`),
  KEY `active` (`active`),
  KEY `priority` (`priority`),
  KEY `property_type` (`property_type`),
  KEY `list_type` (`list_type`),
  KEY `multiple` (`multiple`),
  KEY `multiple_cnt` (`multiple_cnt`),
  KEY `with_description` (`with_description`),
  KEY `searchable` (`searchable`),
  KEY `filtrable` (`filtrable`),
  KEY `is_required` (`is_required`),
  KEY `version` (`version`),
  KEY `component` (`component`),
  KEY `hint` (`hint`),
  KEY `smart_filtrable` (`smart_filtrable`),
  KEY `code` (`code`) USING BTREE,
  CONSTRAINT `yiisns_content_property_content_id` FOREIGN KEY (`content_id`) REFERENCES `yiisns_content` (`id`),
  CONSTRAINT `yiisns_content_property_created_by` FOREIGN KEY (`created_by`) REFERENCES `yiisns_user` (`id`),
  CONSTRAINT `yiisns_content_property_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `yiisns_user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Свойства элементов';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yiisns_content_property`
--

LOCK TABLES `yiisns_content_property` WRITE;
/*!40000 ALTER TABLE `yiisns_content_property` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `yiisns_content_property` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

--
-- Table structure for table `yiisns_content_property_enum`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yiisns_content_property_enum` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `property_id` int(11) DEFAULT NULL,
  `value` varchar(255) NOT NULL,
  `def` char(1) NOT NULL DEFAULT 'N',
  `code` varchar(32) NOT NULL,
  `priority` int(11) NOT NULL DEFAULT '500',
  PRIMARY KEY (`id`),
  KEY `updated_by` (`updated_by`),
  KEY `created_by` (`created_by`),
  KEY `created_at` (`created_at`),
  KEY `updated_at` (`updated_at`),
  KEY `property_id` (`property_id`),
  KEY `def` (`def`),
  KEY `code` (`code`),
  KEY `priority` (`priority`),
  KEY `value` (`value`),
  CONSTRAINT `yiisns_content_property_enum_created_by` FOREIGN KEY (`created_by`) REFERENCES `yiisns_user` (`id`),
  CONSTRAINT `yiisns_content_property_enum_property_id` FOREIGN KEY (`property_id`) REFERENCES `yiisns_content_property` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `yiisns_content_property_enum_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `yiisns_user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Справочник значений свойств типа список';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yiisns_content_property_enum`
--

LOCK TABLES `yiisns_content_property_enum` WRITE;
/*!40000 ALTER TABLE `yiisns_content_property_enum` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `yiisns_content_property_enum` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

--
-- Table structure for table `yiisns_content_type`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yiisns_content_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `files` text,
  `priority` int(11) NOT NULL DEFAULT '500',
  `name` varchar(255) NOT NULL,
  `code` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `updated_by` (`updated_by`),
  KEY `created_by` (`created_by`),
  KEY `created_at` (`created_at`),
  KEY `updated_at` (`updated_at`),
  KEY `priority` (`priority`),
  KEY `name` (`name`),
  CONSTRAINT `yiisns_content_type_created_by` FOREIGN KEY (`created_by`) REFERENCES `yiisns_user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `yiisns_content_type_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `yiisns_user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yiisns_content_type`
--

LOCK TABLES `yiisns_content_type` WRITE;
/*!40000 ALTER TABLE `yiisns_content_type` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `yiisns_content_type` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

--
-- Table structure for table `yiisns_dashboard`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yiisns_dashboard` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `priority` int(11) NOT NULL DEFAULT '100',
  `columns` int(11) unsigned NOT NULL DEFAULT '1',
  `columns_settings` text,
  PRIMARY KEY (`id`),
  KEY `updated_by` (`updated_by`),
  KEY `created_by` (`created_by`),
  KEY `created_at` (`created_at`),
  KEY `updated_at` (`updated_at`),
  KEY `name` (`name`),
  KEY `yiisns_user_id` (`user_id`),
  KEY `priority` (`priority`),
  KEY `columns` (`columns`),
  CONSTRAINT `yiisns_dashboard_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `yiisns_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `yiisns_dashboard_created_by` FOREIGN KEY (`created_by`) REFERENCES `yiisns_user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `yiisns_dashboard_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `yiisns_user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yiisns_dashboard`
--

LOCK TABLES `yiisns_dashboard` WRITE;
/*!40000 ALTER TABLE `yiisns_dashboard` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `yiisns_dashboard` VALUES (4,1,1,1496385242,1496385242,'默认工作台',NULL,100,1,NULL);
/*!40000 ALTER TABLE `yiisns_dashboard` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

--
-- Table structure for table `yiisns_dashboard_widget`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yiisns_dashboard_widget` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `dashboard_id` int(11) NOT NULL,
  `dashboard_column` int(11) NOT NULL DEFAULT '1',
  `priority` int(11) NOT NULL DEFAULT '100',
  `component` varchar(255) NOT NULL,
  `component_settings` text,
  PRIMARY KEY (`id`),
  KEY `updated_by` (`updated_by`),
  KEY `created_by` (`created_by`),
  KEY `created_at` (`created_at`),
  KEY `updated_at` (`updated_at`),
  KEY `priority` (`priority`),
  KEY `component` (`component`),
  KEY `dashboard_id` (`dashboard_id`),
  KEY `dashboard_column` (`dashboard_column`),
  CONSTRAINT `yiisns_dashboard_widget_created_by` FOREIGN KEY (`created_by`) REFERENCES `yiisns_user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `yiisns_dashboard_widget_ibfk_1` FOREIGN KEY (`dashboard_id`) REFERENCES `yiisns_dashboard` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `yiisns_dashboard_widget_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `yiisns_user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='Виджет рабочего стола';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yiisns_dashboard_widget`
--

LOCK TABLES `yiisns_dashboard_widget` WRITE;
/*!40000 ALTER TABLE `yiisns_dashboard_widget` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `yiisns_dashboard_widget` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

--
-- Table structure for table `yiisns_event`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yiisns_event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_name` varchar(255) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` text,
  `priority` int(11) NOT NULL DEFAULT '150',
  PRIMARY KEY (`id`),
  UNIQUE KEY `event_name` (`event_name`),
  KEY `priority` (`priority`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yiisns_event`
--

LOCK TABLES `yiisns_event` WRITE;
/*!40000 ALTER TABLE `yiisns_event` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `yiisns_event` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

--
-- Table structure for table `yiisns_form2_form`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yiisns_form2_form` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `code` varchar(32) DEFAULT NULL,
  `emails` text,
  `phones` text,
  `user_ids` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `updated_by` (`updated_by`),
  KEY `created_by` (`created_by`),
  KEY `created_at` (`created_at`),
  KEY `updated_at` (`updated_at`),
  KEY `name` (`name`),
  CONSTRAINT `form2_form_created_by` FOREIGN KEY (`created_by`) REFERENCES `yiisns_user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `form2_form_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `yiisns_user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yiisns_form2_form`
--

LOCK TABLES `yiisns_form2_form` WRITE;
/*!40000 ALTER TABLE `yiisns_form2_form` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `yiisns_form2_form` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

--
-- Table structure for table `yiisns_form2_form_property`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yiisns_form2_form_property` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(64) DEFAULT NULL,
  `active` char(1) NOT NULL DEFAULT 'Y',
  `priority` int(11) NOT NULL DEFAULT '500',
  `property_type` char(1) NOT NULL DEFAULT 'S',
  `list_type` char(1) NOT NULL DEFAULT 'L',
  `multiple` char(1) NOT NULL DEFAULT 'N',
  `multiple_cnt` int(11) DEFAULT NULL,
  `with_description` char(1) DEFAULT NULL,
  `searchable` char(1) NOT NULL DEFAULT 'N',
  `filtrable` char(1) NOT NULL DEFAULT 'N',
  `is_required` char(1) DEFAULT NULL,
  `version` int(11) NOT NULL DEFAULT '1',
  `component` varchar(255) DEFAULT NULL,
  `component_settings` text,
  `hint` varchar(255) DEFAULT NULL,
  `smart_filtrable` char(1) NOT NULL DEFAULT 'N',
  `form_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`,`form_id`),
  KEY `updated_by` (`updated_by`),
  KEY `created_by` (`created_by`),
  KEY `created_at` (`created_at`),
  KEY `updated_at` (`updated_at`),
  KEY `name` (`name`),
  KEY `active` (`active`),
  KEY `priority` (`priority`),
  KEY `property_type` (`property_type`),
  KEY `list_type` (`list_type`),
  KEY `multiple` (`multiple`),
  KEY `multiple_cnt` (`multiple_cnt`),
  KEY `with_description` (`with_description`),
  KEY `searchable` (`searchable`),
  KEY `filtrable` (`filtrable`),
  KEY `is_required` (`is_required`),
  KEY `version` (`version`),
  KEY `component` (`component`),
  KEY `hint` (`hint`),
  KEY `smart_filtrable` (`smart_filtrable`),
  KEY `form_id` (`form_id`),
  CONSTRAINT `form2_form_property_created_by` FOREIGN KEY (`created_by`) REFERENCES `yiisns_user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `form2_form_property_form2_form` FOREIGN KEY (`form_id`) REFERENCES `yiisns_form2_form` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `form2_form_property_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `yiisns_user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yiisns_form2_form_property`
--

LOCK TABLES `yiisns_form2_form_property` WRITE;
/*!40000 ALTER TABLE `yiisns_form2_form_property` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `yiisns_form2_form_property` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

--
-- Table structure for table `yiisns_form2_form_property_enum`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yiisns_form2_form_property_enum` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `property_id` int(11) DEFAULT NULL,
  `value` varchar(255) NOT NULL,
  `def` char(1) NOT NULL DEFAULT 'N',
  `code` varchar(32) NOT NULL,
  `priority` int(11) NOT NULL DEFAULT '500',
  PRIMARY KEY (`id`),
  KEY `updated_by` (`updated_by`),
  KEY `created_by` (`created_by`),
  KEY `created_at` (`created_at`),
  KEY `updated_at` (`updated_at`),
  KEY `property_id` (`property_id`),
  KEY `def` (`def`),
  KEY `code` (`code`),
  KEY `priority` (`priority`),
  KEY `value` (`value`),
  CONSTRAINT `form2_form_property_enum_created_by` FOREIGN KEY (`created_by`) REFERENCES `yiisns_user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `form2_form_property_enum_property_id` FOREIGN KEY (`property_id`) REFERENCES `yiisns_form2_form_property` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `form2_form_property_enum_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `yiisns_user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yiisns_form2_form_property_enum`
--

LOCK TABLES `yiisns_form2_form_property_enum` WRITE;
/*!40000 ALTER TABLE `yiisns_form2_form_property_enum` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `yiisns_form2_form_property_enum` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

--
-- Table structure for table `yiisns_form2_form_send`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yiisns_form2_form_send` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `processed_by` int(11) DEFAULT NULL,
  `processed_at` int(11) DEFAULT NULL,
  `data_values` text,
  `data_labels` text,
  `emails` text,
  `phones` text,
  `user_ids` text,
  `email_message` text,
  `phone_message` text,
  `status` smallint(6) NOT NULL DEFAULT '0',
  `form_id` int(255) DEFAULT NULL,
  `ip` varchar(32) DEFAULT NULL,
  `page_url` varchar(500) DEFAULT NULL,
  `data_server` text,
  `data_session` text,
  `data_cookie` text,
  `data_request` text,
  `additional_data` text,
  `site_code` char(15) DEFAULT NULL,
  `comment` text,
  PRIMARY KEY (`id`),
  KEY `updated_by` (`updated_by`),
  KEY `created_by` (`created_by`),
  KEY `created_at` (`created_at`),
  KEY `updated_at` (`updated_at`),
  KEY `form_id` (`form_id`),
  KEY `processed_by` (`processed_by`),
  KEY `processed_at` (`processed_at`),
  KEY `status` (`status`),
  KEY `ip` (`ip`),
  KEY `page_url` (`page_url`(255)),
  KEY `site_code` (`site_code`),
  CONSTRAINT `form2_form_send_created_by` FOREIGN KEY (`created_by`) REFERENCES `yiisns_user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `form2_form_send_form_id` FOREIGN KEY (`form_id`) REFERENCES `yiisns_form2_form` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `form2_form_send_processed_by` FOREIGN KEY (`processed_by`) REFERENCES `yiisns_user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `form2_form_send_site_code_fk` FOREIGN KEY (`site_code`) REFERENCES `yiisns_site` (`code`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `form2_form_send_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `yiisns_user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yiisns_form2_form_send`
--

LOCK TABLES `yiisns_form2_form_send` WRITE;
/*!40000 ALTER TABLE `yiisns_form2_form_send` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `yiisns_form2_form_send` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

--
-- Table structure for table `yiisns_form2_form_send_property`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yiisns_form2_form_send_property` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `property_id` int(11) DEFAULT NULL,
  `element_id` int(11) DEFAULT NULL,
  `value` longtext NOT NULL,
  `value_enum` int(11) DEFAULT NULL,
  `value_num` decimal(18,4) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `updated_by` (`updated_by`),
  KEY `created_by` (`created_by`),
  KEY `created_at` (`created_at`),
  KEY `updated_at` (`updated_at`),
  KEY `property_id` (`property_id`),
  KEY `element_id` (`element_id`),
  KEY `value_enum` (`value_enum`),
  KEY `value_num` (`value_num`),
  KEY `description` (`description`),
  CONSTRAINT `form2_form_send_property_created_by` FOREIGN KEY (`created_by`) REFERENCES `yiisns_user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `form2_form_send_property_element_id` FOREIGN KEY (`element_id`) REFERENCES `yiisns_form2_form_send` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `form2_form_send_property_property_id` FOREIGN KEY (`property_id`) REFERENCES `yiisns_form2_form_property` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `form2_form_send_property_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `yiisns_user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yiisns_form2_form_send_property`
--

LOCK TABLES `yiisns_form2_form_send_property` WRITE;
/*!40000 ALTER TABLE `yiisns_form2_form_send_property` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `yiisns_form2_form_send_property` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

--
-- Table structure for table `yiisns_lang`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yiisns_lang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `active` char(1) NOT NULL DEFAULT 'Y',
  `def` char(1) NOT NULL DEFAULT 'N',
  `priority` int(11) NOT NULL DEFAULT '500',
  `code` char(5) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `image_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code_2` (`code`),
  KEY `updated_by` (`updated_by`),
  KEY `created_by` (`created_by`),
  KEY `created_at` (`created_at`),
  KEY `updated_at` (`updated_at`),
  KEY `def` (`def`),
  KEY `code` (`code`),
  KEY `priority` (`priority`),
  KEY `name` (`name`),
  KEY `description` (`description`),
  KEY `yiisns_lang__image_id` (`image_id`),
  CONSTRAINT `yiisns_lang_created_by` FOREIGN KEY (`created_by`) REFERENCES `yiisns_user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `yiisns_lang_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `yiisns_user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `yiisns_lang__image_id` FOREIGN KEY (`image_id`) REFERENCES `yiisns_storage_file` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='Доступные языки';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yiisns_lang`
--

LOCK TABLES `yiisns_lang` WRITE;
/*!40000 ALTER TABLE `yiisns_lang` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `yiisns_lang` VALUES (2,1,1,1432126667,1495561435,'Y','N',50,'en','英语','英文站点语言包',NULL),(3,1,1,1490790480,1495561410,'Y','N',100,'zh-CN','中文','中文站点语言包',NULL);
/*!40000 ALTER TABLE `yiisns_lang` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

--
-- Table structure for table `yiisns_log_db_target`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yiisns_log_db_target` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `level` int(11) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `log_time` int(11) DEFAULT NULL,
  `prefix` text,
  `message` text,
  PRIMARY KEY (`id`),
  KEY `idx_log_level` (`level`),
  KEY `idx_log_category` (`category`)
) ENGINE=InnoDB AUTO_INCREMENT=2677 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yiisns_log_db_target`
--

LOCK TABLES `yiisns_log_db_target` WRITE;
/*!40000 ALTER TABLE `yiisns_log_db_target` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `yiisns_log_db_target` VALUES (2673,2,'skeeks\\modules\\cms\\form2\\cmsWidgets\\form2\\FormWidget',1496424371,'[192.168.1.165][1][-]','The shape is not found: code=callback'),(2674,1,'yii\\web\\HttpException:404',1496424372,'[192.168.1.165][1][n0jc68orc2omr61dkk05o12um1]','yii\\base\\InvalidRouteException: Unable to resolve the request \"smarty/js/scripts.js\". in G:\\wwwroot\\yiisns.cn\\vendor\\yiisoft\\yii2\\base\\Module.php:586\nStack trace:\n#0 G:\\wwwroot\\yiisns.cn\\vendor\\yiisoft\\yii2\\web\\Application.php(107): yii\\base\\Module->runAction(\'smarty/js/scrip...\', Array)\n#1 G:\\wwwroot\\yiisns.cn\\vendor\\yiisoft\\yii2\\base\\Application.php(426): yii\\web\\Application->handleRequest(Object(yii\\web\\Request))\n#2 G:\\wwwroot\\yiisns.cn\\vendor\\skeeks\\cms\\app-web.php(24): yii\\base\\Application->run()\n#3 G:\\wwwroot\\yiisns.cn\\application\\web\\index.php(34): include(\'G:\\\\wwwroot\\\\yiis...\')\n#4 {main}\n\nNext yii\\web\\NotFoundHttpException: ?????? in G:\\wwwroot\\yiisns.cn\\vendor\\yiisoft\\yii2\\web\\Application.php:119\nStack trace:\n#0 G:\\wwwroot\\yiisns.cn\\vendor\\yiisoft\\yii2\\base\\Application.php(426): yii\\web\\Application->handleRequest(Object(yii\\web\\Request))\n#1 G:\\wwwroot\\yiisns.cn\\vendor\\skeeks\\cms\\app-web.php(24): yii\\base\\Application->run()\n#2 G:\\wwwroot\\yiisns.cn\\application\\web\\index.php(34): include(\'G:\\\\wwwroot\\\\yiis...\')\n#3 {main}'),(2675,1,'skeeks\\cms\\marketplace\\CmsMarketplaceComponent',1496424885,'[192.168.1.165][1][-]','curl request failed: Operation timed out after 0 milliseconds with 0 out of 0 bytes received'),(2676,1,'Error',1496425951,'[192.168.1.165][1][n0jc68orc2omr61dkk05o12um1]','Error: Class \'skeeks\\cms\\controllers\\CmsManager\' not found in G:\\wwwroot\\yiisns.cn\\vendor\\skeeks\\cms\\controllers\\ElfinderFullController.php:28\nStack trace:\n#0 G:\\wwwroot\\yiisns.cn\\vendor\\yiisoft\\yii2\\base\\Object.php(107): skeeks\\cms\\controllers\\ElfinderFullController->init()\n#1 G:\\wwwroot\\yiisns.cn\\vendor\\yiisoft\\yii2\\base\\Controller.php(101): yii\\base\\Object->__construct(Array)\n#2 [internal function]: yii\\base\\Controller->__construct(\'elfinder-full\', Object(skeeks\\cms\\Module), Array)\n#3 G:\\wwwroot\\yiisns.cn\\vendor\\yiisoft\\yii2\\di\\Container.php(375): ReflectionClass->newInstanceArgs(Array)\n#4 G:\\wwwroot\\yiisns.cn\\vendor\\yiisoft\\yii2\\di\\Container.php(156): yii\\di\\Container->build(\'skeeks\\\\cms\\\\cont...\', Array, Array)\n#5 G:\\wwwroot\\yiisns.cn\\vendor\\yiisoft\\yii2\\BaseYii.php(340): yii\\di\\Container->get(\'skeeks\\\\cms\\\\cont...\', Array)\n#6 G:\\wwwroot\\yiisns.cn\\vendor\\yiisoft\\yii2\\base\\Module.php(705): yii\\BaseYii::createObject(\'skeeks\\\\cms\\\\cont...\', Array)\n#7 G:\\wwwroot\\yiisns.cn\\vendor\\yiisoft\\yii2\\base\\Module.php(652): yii\\base\\Module->createControllerByID(\'elfinder-full\')\n#8 G:\\wwwroot\\yiisns.cn\\vendor\\yiisoft\\yii2\\base\\Module.php(644): yii\\base\\Module->createController(\'manager\')\n#9 G:\\wwwroot\\yiisns.cn\\vendor\\yiisoft\\yii2\\base\\Module.php(571): yii\\base\\Module->createController(\'elfinder-full/m...\')\n#10 G:\\wwwroot\\yiisns.cn\\vendor\\yiisoft\\yii2\\web\\Application.php(107): yii\\base\\Module->runAction(\'cms/elfinder-fu...\', Array)\n#11 G:\\wwwroot\\yiisns.cn\\vendor\\yiisoft\\yii2\\base\\Application.php(426): yii\\web\\Application->handleRequest(Object(yii\\web\\Request))\n#12 G:\\wwwroot\\yiisns.cn\\vendor\\skeeks\\cms\\app-web.php(24): yii\\base\\Application->run()\n#13 G:\\wwwroot\\yiisns.cn\\application\\web\\index.php(34): include(\'G:\\\\wwwroot\\\\yiis...\')\n#14 {main}');
/*!40000 ALTER TABLE `yiisns_log_db_target` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

--
-- Table structure for table `yiisns_search_phrase`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yiisns_search_phrase` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `phrase` varchar(255) DEFAULT NULL,
  `result_count` int(11) NOT NULL DEFAULT '0',
  `pages` int(11) NOT NULL DEFAULT '0',
  `ip` varchar(32) DEFAULT NULL,
  `session_id` varchar(32) DEFAULT NULL,
  `site_code` char(15) DEFAULT NULL,
  `data_server` text,
  `data_session` text,
  `data_cookie` text,
  `data_request` text,
  PRIMARY KEY (`id`),
  KEY `updated_by` (`updated_by`),
  KEY `created_by` (`created_by`),
  KEY `created_at` (`created_at`),
  KEY `updated_at` (`updated_at`),
  KEY `phrase` (`phrase`),
  KEY `result_count` (`result_count`),
  KEY `pages` (`pages`),
  KEY `ip` (`ip`),
  KEY `session_id` (`session_id`),
  KEY `site_code` (`site_code`),
  CONSTRAINT `yiisns_search_phrase_created_by` FOREIGN KEY (`created_by`) REFERENCES `yiisns_user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `yiisns_search_phrase_site_code_fk` FOREIGN KEY (`site_code`) REFERENCES `yiisns_site` (`code`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `yiisns_search_phrase_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `yiisns_user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Поисковые фразы';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yiisns_search_phrase`
--

LOCK TABLES `yiisns_search_phrase` WRITE;
/*!40000 ALTER TABLE `yiisns_search_phrase` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `yiisns_search_phrase` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

--
-- Table structure for table `yiisns_site`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yiisns_site` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `active` char(1) NOT NULL DEFAULT 'Y',
  `def` char(1) NOT NULL DEFAULT 'N',
  `priority` int(11) NOT NULL DEFAULT '500',
  `code` char(15) NOT NULL,
  `name` varchar(255) NOT NULL,
  `server_name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `image_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `updated_by` (`updated_by`),
  KEY `created_by` (`created_by`),
  KEY `created_at` (`created_at`),
  KEY `updated_at` (`updated_at`),
  KEY `active` (`active`),
  KEY `server_name` (`server_name`),
  KEY `def` (`def`),
  KEY `priority` (`priority`),
  KEY `yiisns_site__image_id` (`image_id`),
  CONSTRAINT `yiisns_site_created_by` FOREIGN KEY (`created_by`) REFERENCES `yiisns_user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `yiisns_site_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `yiisns_user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `yiisns_site__image_id` FOREIGN KEY (`image_id`) REFERENCES `yiisns_storage_file` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='Сайты';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yiisns_site`
--

LOCK TABLES `yiisns_site` WRITE;
/*!40000 ALTER TABLE `yiisns_site` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `yiisns_site` VALUES (1,1,1,1432128290,1495974353,'Y','Y',100,'chinese','中文站','','中文站点',NULL),(4,1,1,1491967822,1496383075,'N','N',100,'en','英文站','','英文站点',NULL);
/*!40000 ALTER TABLE `yiisns_site` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

--
-- Table structure for table `yiisns_site_domain`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yiisns_site_domain` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `site_code` char(15) NOT NULL,
  `domain` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `domain` (`domain`,`site_code`),
  KEY `updated_by` (`updated_by`),
  KEY `created_by` (`created_by`),
  KEY `created_at` (`created_at`),
  KEY `updated_at` (`updated_at`),
  KEY `yiisns_site_domain_site_code` (`site_code`),
  CONSTRAINT `yiisns_site_domain_created_by` FOREIGN KEY (`created_by`) REFERENCES `yiisns_user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `yiisns_site_domain_site_code` FOREIGN KEY (`site_code`) REFERENCES `yiisns_site` (`code`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `yiisns_site_domain_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `yiisns_user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='Доменные имена сайтов';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yiisns_site_domain`
--

LOCK TABLES `yiisns_site_domain` WRITE;
/*!40000 ALTER TABLE `yiisns_site_domain` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `yiisns_site_domain` VALUES (1,1,1,1490685900,1495974326,'chinese','www.yiisns.cn');
/*!40000 ALTER TABLE `yiisns_site_domain` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

--
-- Table structure for table `yiisns_storage_file`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yiisns_storage_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cluster_id` varchar(16) DEFAULT NULL,
  `cluster_file` varchar(255) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `size` bigint(32) DEFAULT NULL,
  `mime_type` varchar(16) DEFAULT NULL,
  `extension` varchar(16) DEFAULT NULL,
  `original_name` varchar(255) DEFAULT NULL,
  `name_to_save` varchar(32) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description_short` text,
  `description_full` text,
  `image_height` int(11) DEFAULT NULL,
  `image_width` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cluster_id` (`cluster_id`,`cluster_file`),
  KEY `cluster_id_2` (`cluster_id`),
  KEY `cluster_file` (`cluster_file`),
  KEY `updated_by` (`updated_by`),
  KEY `created_by` (`created_by`),
  KEY `created_at` (`created_at`),
  KEY `updated_at` (`updated_at`),
  KEY `size` (`size`),
  KEY `extension` (`extension`),
  KEY `name_to_save` (`name_to_save`),
  KEY `name` (`name`),
  KEY `mime_type` (`mime_type`),
  KEY `image_height` (`image_height`),
  KEY `image_width` (`image_width`),
  CONSTRAINT `storage_file_created_by` FOREIGN KEY (`created_by`) REFERENCES `yiisns_user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `storage_file_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `yiisns_user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='Файл';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yiisns_storage_file`
--

LOCK TABLES `yiisns_storage_file` WRITE;
/*!40000 ALTER TABLE `yiisns_storage_file` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `yiisns_storage_file` VALUES (3,'local','fc\\3b\\8d\\fc3b8da5c254c0ebf538178829ac4a93.jpg',1,1,1495897286,1495897287,566616,'image/jpeg','jpg','小外甥.jpg',NULL,'原味咖啡',NULL,NULL,2560,1440);
/*!40000 ALTER TABLE `yiisns_storage_file` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

--
-- Table structure for table `yiisns_tree`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yiisns_tree` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `image_id` int(11) DEFAULT NULL,
  `image_full_id` int(11) DEFAULT NULL,
  `description_short` longtext,
  `description_full` longtext,
  `code` varchar(64) DEFAULT NULL,
  `pid` int(11) DEFAULT NULL,
  `pids` varchar(255) DEFAULT NULL,
  `level` int(11) DEFAULT '0',
  `dir` text,
  `has_children` smallint(1) DEFAULT '0',
  `priority` int(11) NOT NULL DEFAULT '0',
  `published_at` int(11) DEFAULT NULL,
  `redirect` varchar(500) DEFAULT NULL,
  `tree_menu_ids` varchar(500) DEFAULT NULL,
  `active` char(1) NOT NULL DEFAULT 'Y',
  `meta_title` varchar(500) DEFAULT NULL,
  `meta_description` text,
  `meta_keywords` text,
  `site_code` char(15) NOT NULL,
  `tree_type_id` int(11) DEFAULT NULL,
  `description_short_type` varchar(10) NOT NULL DEFAULT 'text',
  `description_full_type` varchar(10) NOT NULL DEFAULT 'text',
  `redirect_tree_id` int(11) DEFAULT NULL,
  `redirect_code` int(11) NOT NULL DEFAULT '301',
  `name_hidden` varchar(255) DEFAULT NULL,
  `view_file` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pid_2` (`pid`,`code`),
  KEY `updated_by` (`updated_by`),
  KEY `created_by` (`created_by`),
  KEY `created_at` (`created_at`),
  KEY `updated_at` (`updated_at`),
  KEY `name` (`name`),
  KEY `seo_page_name` (`code`),
  KEY `pid` (`pid`),
  KEY `pids` (`pids`),
  KEY `level` (`level`),
  KEY `priority` (`priority`),
  KEY `has_children` (`has_children`),
  KEY `published_at` (`published_at`),
  KEY `redirect` (`redirect`(255)),
  KEY `tree_menu_ids` (`tree_menu_ids`(255)),
  KEY `meta_title` (`meta_title`(255)),
  KEY `site_code` (`site_code`),
  KEY `tree_type_id` (`tree_type_id`),
  KEY `description_short_type` (`description_short_type`),
  KEY `description_full_type` (`description_full_type`),
  KEY `image_id` (`image_id`),
  KEY `image_full_id` (`image_full_id`),
  KEY `redirect_tree_id` (`redirect_tree_id`),
  KEY `redirect_code` (`redirect_code`),
  KEY `name_hidden` (`name_hidden`),
  KEY `view_file` (`view_file`),
  CONSTRAINT `yiisns_tree_created_by` FOREIGN KEY (`created_by`) REFERENCES `yiisns_user` (`id`),
  CONSTRAINT `yiisns_tree_pid_yiisns_tree` FOREIGN KEY (`pid`) REFERENCES `yiisns_tree` (`id`),
  CONSTRAINT `yiisns_tree_site_code` FOREIGN KEY (`site_code`) REFERENCES `yiisns_site` (`code`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `yiisns_tree_tree_type_id` FOREIGN KEY (`tree_type_id`) REFERENCES `yiisns_tree_type` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `yiisns_tree_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `yiisns_user` (`id`),
  CONSTRAINT `yiisns_tree__image_full_id` FOREIGN KEY (`image_full_id`) REFERENCES `yiisns_storage_file` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `yiisns_tree__image_id` FOREIGN KEY (`image_id`) REFERENCES `yiisns_storage_file` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `yiisns_tree__redirect_tree_id` FOREIGN KEY (`redirect_tree_id`) REFERENCES `yiisns_tree` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='Страницы дерево';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yiisns_tree`
--

LOCK TABLES `yiisns_tree` WRITE;
/*!40000 ALTER TABLE `yiisns_tree` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `yiisns_tree` VALUES (1,NULL,1,NULL,1491988123,'Home',NULL,NULL,'','','Home',NULL,'',0,NULL,0,0,NULL,'','','Y','','','','chinese',NULL,'text','text',NULL,301,'',''),(5,1,1,1491988123,1491988221,'技术文章',NULL,NULL,'','','news',1,'1',1,'news',0,100,NULL,'','','Y','','','','chinese',NULL,'text','text',NULL,301,'','');
/*!40000 ALTER TABLE `yiisns_tree` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

--
-- Table structure for table `yiisns_tree_file`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yiisns_tree_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `storage_file_id` int(11) NOT NULL,
  `tree_id` int(11) NOT NULL,
  `priority` int(11) NOT NULL DEFAULT '100',
  PRIMARY KEY (`id`),
  UNIQUE KEY `storage_file_id__tree_id` (`storage_file_id`,`tree_id`),
  KEY `updated_by` (`updated_by`),
  KEY `created_by` (`created_by`),
  KEY `created_at` (`created_at`),
  KEY `updated_at` (`updated_at`),
  KEY `storage_file_id` (`storage_file_id`),
  KEY `tree_id` (`tree_id`),
  KEY `priority` (`priority`),
  CONSTRAINT `yiisns_tree_file_created_by` FOREIGN KEY (`created_by`) REFERENCES `yiisns_user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `yiisns_tree_file_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `yiisns_user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `yiisns_tree_file__storage_file_id` FOREIGN KEY (`storage_file_id`) REFERENCES `yiisns_storage_file` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `yiisns_tree_file__tree_id` FOREIGN KEY (`tree_id`) REFERENCES `yiisns_tree` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Связь разделов и файлов';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yiisns_tree_file`
--

LOCK TABLES `yiisns_tree_file` WRITE;
/*!40000 ALTER TABLE `yiisns_tree_file` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `yiisns_tree_file` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

--
-- Table structure for table `yiisns_tree_image`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yiisns_tree_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `storage_file_id` int(11) NOT NULL,
  `tree_id` int(11) NOT NULL,
  `priority` int(11) NOT NULL DEFAULT '100',
  PRIMARY KEY (`id`),
  UNIQUE KEY `storage_file_id__tree_id` (`storage_file_id`,`tree_id`),
  KEY `updated_by` (`updated_by`),
  KEY `created_by` (`created_by`),
  KEY `created_at` (`created_at`),
  KEY `updated_at` (`updated_at`),
  KEY `storage_file_id` (`storage_file_id`),
  KEY `tree_id` (`tree_id`),
  KEY `priority` (`priority`),
  CONSTRAINT `yiisns_tree_image_created_by` FOREIGN KEY (`created_by`) REFERENCES `yiisns_user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `yiisns_tree_image_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `yiisns_user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `yiisns_tree_image__storage_file_id` FOREIGN KEY (`storage_file_id`) REFERENCES `yiisns_storage_file` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `yiisns_tree_image__tree_id` FOREIGN KEY (`tree_id`) REFERENCES `yiisns_tree` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Связь разделов и файлов изображений';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yiisns_tree_image`
--

LOCK TABLES `yiisns_tree_image` WRITE;
/*!40000 ALTER TABLE `yiisns_tree_image` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `yiisns_tree_image` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

--
-- Table structure for table `yiisns_tree_property`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yiisns_tree_property` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `property_id` int(11) DEFAULT NULL,
  `element_id` int(11) DEFAULT NULL,
  `value` longtext NOT NULL,
  `value_enum` int(11) DEFAULT NULL,
  `value_num` decimal(18,4) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `updated_by` (`updated_by`),
  KEY `created_by` (`created_by`),
  KEY `created_at` (`created_at`),
  KEY `updated_at` (`updated_at`),
  KEY `property_id` (`property_id`),
  KEY `element_id` (`element_id`),
  KEY `value_enum` (`value_enum`),
  KEY `value_num` (`value_num`),
  KEY `description` (`description`),
  CONSTRAINT `yiisns_tree_property_created_by` FOREIGN KEY (`created_by`) REFERENCES `yiisns_user` (`id`),
  CONSTRAINT `yiisns_tree_property_element_id` FOREIGN KEY (`element_id`) REFERENCES `yiisns_tree` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `yiisns_tree_property_property_id` FOREIGN KEY (`property_id`) REFERENCES `yiisns_tree_type_property` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `yiisns_tree_property_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `yiisns_user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Связь свойства и значения';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yiisns_tree_property`
--

LOCK TABLES `yiisns_tree_property` WRITE;
/*!40000 ALTER TABLE `yiisns_tree_property` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `yiisns_tree_property` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

--
-- Table structure for table `yiisns_tree_type`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yiisns_tree_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(50) NOT NULL,
  `active` char(1) NOT NULL DEFAULT 'Y',
  `priority` int(11) NOT NULL DEFAULT '500',
  `description` text,
  `index_for_search` char(1) NOT NULL DEFAULT 'Y',
  `name_meny` varchar(100) DEFAULT NULL,
  `name_one` varchar(100) DEFAULT NULL,
  `viewFile` varchar(255) DEFAULT NULL,
  `default_children_tree_type` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `updated_by` (`updated_by`),
  KEY `created_by` (`created_by`),
  KEY `created_at` (`created_at`),
  KEY `updated_at` (`updated_at`),
  KEY `priority` (`priority`),
  KEY `name` (`name`),
  KEY `active` (`active`),
  KEY `index_for_search` (`index_for_search`),
  KEY `name_meny` (`name_meny`),
  KEY `name_one` (`name_one`),
  KEY `viewFile` (`viewFile`),
  KEY `default_children_tree_type` (`default_children_tree_type`),
  CONSTRAINT `yiisns_tree_type_created_by` FOREIGN KEY (`created_by`) REFERENCES `yiisns_user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `yiisns_tree_type_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `yiisns_user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `yiisns_tree_type__default_children_tree_type` FOREIGN KEY (`default_children_tree_type`) REFERENCES `yiisns_tree_type` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Тип раздела';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yiisns_tree_type`
--

LOCK TABLES `yiisns_tree_type` WRITE;
/*!40000 ALTER TABLE `yiisns_tree_type` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `yiisns_tree_type` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

--
-- Table structure for table `yiisns_tree_type_property`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yiisns_tree_type_property` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(64) DEFAULT NULL,
  `active` char(1) NOT NULL DEFAULT 'Y',
  `priority` int(11) NOT NULL DEFAULT '500',
  `property_type` char(1) NOT NULL DEFAULT 'S',
  `list_type` char(1) NOT NULL DEFAULT 'L',
  `multiple` char(1) NOT NULL DEFAULT 'N',
  `multiple_cnt` int(11) DEFAULT NULL,
  `with_description` char(1) DEFAULT NULL,
  `searchable` char(1) NOT NULL DEFAULT 'N',
  `filtrable` char(1) NOT NULL DEFAULT 'N',
  `is_required` char(1) DEFAULT NULL,
  `version` int(11) NOT NULL DEFAULT '1',
  `component` varchar(255) DEFAULT NULL,
  `component_settings` longtext,
  `hint` varchar(255) DEFAULT NULL,
  `smart_filtrable` char(1) NOT NULL DEFAULT 'N',
  `tree_type_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code_2` (`code`,`tree_type_id`),
  KEY `updated_by` (`updated_by`),
  KEY `created_by` (`created_by`),
  KEY `created_at` (`created_at`),
  KEY `updated_at` (`updated_at`),
  KEY `name` (`name`),
  KEY `active` (`active`),
  KEY `priority` (`priority`),
  KEY `property_type` (`property_type`),
  KEY `list_type` (`list_type`),
  KEY `multiple` (`multiple`),
  KEY `multiple_cnt` (`multiple_cnt`),
  KEY `with_description` (`with_description`),
  KEY `searchable` (`searchable`),
  KEY `filtrable` (`filtrable`),
  KEY `is_required` (`is_required`),
  KEY `version` (`version`),
  KEY `component` (`component`),
  KEY `hint` (`hint`),
  KEY `smart_filtrable` (`smart_filtrable`),
  KEY `tree_type_id` (`tree_type_id`),
  KEY `code` (`code`) USING BTREE,
  CONSTRAINT `yiisns_tree_type_property_created_by` FOREIGN KEY (`created_by`) REFERENCES `yiisns_user` (`id`),
  CONSTRAINT `yiisns_tree_type_property_tree_type_id` FOREIGN KEY (`tree_type_id`) REFERENCES `yiisns_tree_type` (`id`),
  CONSTRAINT `yiisns_tree_type_property_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `yiisns_user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Свойство раздела';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yiisns_tree_type_property`
--

LOCK TABLES `yiisns_tree_type_property` WRITE;
/*!40000 ALTER TABLE `yiisns_tree_type_property` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `yiisns_tree_type_property` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

--
-- Table structure for table `yiisns_tree_type_property_enum`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yiisns_tree_type_property_enum` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `property_id` int(11) DEFAULT NULL,
  `value` varchar(255) NOT NULL,
  `def` char(1) NOT NULL DEFAULT 'N',
  `code` varchar(32) NOT NULL,
  `priority` int(11) NOT NULL DEFAULT '500',
  PRIMARY KEY (`id`),
  KEY `updated_by` (`updated_by`),
  KEY `created_by` (`created_by`),
  KEY `created_at` (`created_at`),
  KEY `updated_at` (`updated_at`),
  KEY `property_id` (`property_id`),
  KEY `def` (`def`),
  KEY `code` (`code`),
  KEY `priority` (`priority`),
  KEY `value` (`value`),
  CONSTRAINT `yiisns_tree_type_property_enum_created_by` FOREIGN KEY (`created_by`) REFERENCES `yiisns_user` (`id`),
  CONSTRAINT `yiisns_tree_type_property_enum_property_id` FOREIGN KEY (`property_id`) REFERENCES `yiisns_tree_type_property` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `yiisns_tree_type_property_enum_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `yiisns_user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Справочник значений свойств для разделов';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yiisns_tree_type_property_enum`
--

LOCK TABLES `yiisns_tree_type_property_enum` WRITE;
/*!40000 ALTER TABLE `yiisns_tree_type_property_enum` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `yiisns_tree_type_property_enum` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

--
-- Table structure for table `yiisns_user`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yiisns_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `auth_key` varchar(32) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `password_reset_token` varchar(255) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `image_id` int(11) DEFAULT NULL,
  `gender` enum('men','women') NOT NULL DEFAULT 'men',
  `active` char(1) NOT NULL DEFAULT 'Y',
  `updated_by` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `logged_at` int(11) DEFAULT NULL,
  `last_activity_at` int(11) DEFAULT NULL,
  `last_admin_activity_at` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(64) DEFAULT NULL,
  `email_is_approved` int(1) unsigned NOT NULL DEFAULT '0',
  `phone_is_approved` int(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `phone` (`phone`),
  KEY `created_at` (`created_at`),
  KEY `updated_at` (`updated_at`),
  KEY `password_hash` (`password_hash`),
  KEY `password_reset_token` (`password_reset_token`),
  KEY `name` (`name`),
  KEY `updated_by` (`updated_by`),
  KEY `created_by` (`created_by`),
  KEY `logged_at` (`logged_at`),
  KEY `last_activity_at` (`last_activity_at`),
  KEY `last_admin_activity_at` (`last_admin_activity_at`),
  KEY `image_id` (`image_id`),
  KEY `phone_is_approved` (`phone_is_approved`),
  KEY `email_is_approved` (`email_is_approved`),
  CONSTRAINT `yiisns_user_created_by` FOREIGN KEY (`created_by`) REFERENCES `yiisns_user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `yiisns_user_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `yiisns_user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `yiisns_user__image_id` FOREIGN KEY (`image_id`) REFERENCES `yiisns_storage_file` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='Пользователь';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yiisns_user`
--

LOCK TABLES `yiisns_user` WRITE;
/*!40000 ALTER TABLE `yiisns_user` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `yiisns_user` VALUES (1,'root','otv60YW-nV6-8GRI4La3vYNhu_-dmp_n','$2y$13$FTan.A2mnpMvCdMsjPK62eiZHUcBMRfgyo2wN8BrRbaf.1hy6RBCS','wn49wJLj9OMVjgj8bBzBjND4nFixyJgt_1413297645',1493406984,1496426028,'原味咖啡',3,'men','Y',1,1,1495897907,1496426028,1496426028,'admin@yiisns.cn','+86 523 8888 8888',1,1),(2,'uussoft','ZWsaR-8lBHy1BTlpyE2K2GCVoVoYG_Bw','$2y$13$cmGub1t69g8hqeyDYpdQUOV1S8DLdPuVN95snRBK1UZtH78pN31HK',NULL,1495883470,1495981763,'原味咖啡',NULL,'men','Y',1,1,1495893429,1495893580,1495893580,NULL,NULL,0,0);
/*!40000 ALTER TABLE `yiisns_user` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

--
-- Table structure for table `yiisns_user_authclient`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yiisns_user_authclient` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `provider` varchar(50) DEFAULT NULL,
  `provider_identifier` varchar(100) DEFAULT NULL,
  `provider_data` text,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `created_at` (`created_at`),
  KEY `updated_at` (`updated_at`),
  KEY `provider` (`provider`),
  KEY `provider_identifier` (`provider_identifier`),
  CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `yiisns_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yiisns_user_authclient`
--

LOCK TABLES `yiisns_user_authclient` WRITE;
/*!40000 ALTER TABLE `yiisns_user_authclient` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `yiisns_user_authclient` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

--
-- Table structure for table `yiisns_user_email`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yiisns_user_email` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `value` varchar(255) NOT NULL,
  `approved` char(1) NOT NULL DEFAULT 'N',
  `def` varchar(1) NOT NULL DEFAULT 'N',
  `approved_key` varchar(255) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `value` (`value`),
  KEY `approved_key` (`approved_key`),
  KEY `approved` (`approved`),
  KEY `user_id` (`user_id`),
  KEY `created_at` (`created_at`),
  KEY `updated_at` (`updated_at`),
  CONSTRAINT `yiisns_user_email_user_id` FOREIGN KEY (`user_id`) REFERENCES `yiisns_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yiisns_user_email`
--

LOCK TABLES `yiisns_user_email` WRITE;
/*!40000 ALTER TABLE `yiisns_user_email` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `yiisns_user_email` VALUES (1,1,'uussoft@qq.com','Y','Y',NULL,1495559996,1495559996);
/*!40000 ALTER TABLE `yiisns_user_email` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

--
-- Table structure for table `yiisns_user_phone`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yiisns_user_phone` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `value` varchar(255) NOT NULL,
  `approved` char(1) NOT NULL DEFAULT 'N',
  `def` varchar(1) NOT NULL DEFAULT 'N',
  `approved_key` varchar(255) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `value` (`value`),
  KEY `approved_key` (`approved_key`),
  KEY `approved` (`approved`),
  KEY `user_id` (`user_id`),
  KEY `created_at` (`created_at`),
  KEY `updated_at` (`updated_at`),
  CONSTRAINT `yiisns_user_phone_user_id` FOREIGN KEY (`user_id`) REFERENCES `yiisns_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yiisns_user_phone`
--

LOCK TABLES `yiisns_user_phone` WRITE;
/*!40000 ALTER TABLE `yiisns_user_phone` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `yiisns_user_phone` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

--
-- Table structure for table `yiisns_user_property`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yiisns_user_property` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `property_id` int(11) DEFAULT NULL,
  `element_id` int(11) DEFAULT NULL,
  `value` varchar(255) NOT NULL,
  `value_enum` int(11) DEFAULT NULL,
  `value_num` decimal(18,4) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `updated_by` (`updated_by`),
  KEY `created_by` (`created_by`),
  KEY `created_at` (`created_at`),
  KEY `updated_at` (`updated_at`),
  KEY `property_id` (`property_id`),
  KEY `element_id` (`element_id`),
  KEY `value` (`value`),
  KEY `value_enum` (`value_enum`),
  KEY `value_num` (`value_num`),
  KEY `description` (`description`),
  CONSTRAINT `yiisns_user_property_created_by` FOREIGN KEY (`created_by`) REFERENCES `yiisns_user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `yiisns_user_property_element_id` FOREIGN KEY (`element_id`) REFERENCES `yiisns_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `yiisns_user_property_property_id` FOREIGN KEY (`property_id`) REFERENCES `yiisns_user_universal_property` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `yiisns_user_property_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `yiisns_user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='Связь свойства и значения';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yiisns_user_property`
--

LOCK TABLES `yiisns_user_property` WRITE;
/*!40000 ALTER TABLE `yiisns_user_property` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `yiisns_user_property` VALUES (1,1,1,1495804948,1496232409,1,1,'江苏泰州市海陵区祥云花园13栋203室',0,0.0000,NULL),(2,1,1,1495883470,1495981763,1,2,'',0,0.0000,NULL);
/*!40000 ALTER TABLE `yiisns_user_property` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

--
-- Table structure for table `yiisns_user_universal_property`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yiisns_user_universal_property` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(64) DEFAULT NULL,
  `active` char(1) NOT NULL DEFAULT 'Y',
  `priority` int(11) NOT NULL DEFAULT '500',
  `property_type` char(1) NOT NULL DEFAULT 'S',
  `list_type` char(1) NOT NULL DEFAULT 'L',
  `multiple` char(1) NOT NULL DEFAULT 'N',
  `multiple_cnt` int(11) DEFAULT NULL,
  `with_description` char(1) DEFAULT NULL,
  `searchable` char(1) NOT NULL DEFAULT 'N',
  `filtrable` char(1) NOT NULL DEFAULT 'N',
  `is_required` char(1) DEFAULT NULL,
  `version` int(11) NOT NULL DEFAULT '1',
  `component` varchar(255) DEFAULT NULL,
  `component_settings` text,
  `hint` varchar(255) DEFAULT NULL,
  `smart_filtrable` char(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `updated_by` (`updated_by`),
  KEY `created_by` (`created_by`),
  KEY `created_at` (`created_at`),
  KEY `updated_at` (`updated_at`),
  KEY `name` (`name`),
  KEY `active` (`active`),
  KEY `priority` (`priority`),
  KEY `property_type` (`property_type`),
  KEY `list_type` (`list_type`),
  KEY `multiple` (`multiple`),
  KEY `multiple_cnt` (`multiple_cnt`),
  KEY `with_description` (`with_description`),
  KEY `searchable` (`searchable`),
  KEY `filtrable` (`filtrable`),
  KEY `is_required` (`is_required`),
  KEY `version` (`version`),
  KEY `component` (`component`),
  KEY `hint` (`hint`),
  KEY `smart_filtrable` (`smart_filtrable`),
  CONSTRAINT `yiisns_user_universal_property_created_by` FOREIGN KEY (`created_by`) REFERENCES `yiisns_user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `yiisns_user_universal_property_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `yiisns_user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='Свойства пользователей';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yiisns_user_universal_property`
--

LOCK TABLES `yiisns_user_universal_property` WRITE;
/*!40000 ALTER TABLE `yiisns_user_universal_property` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `yiisns_user_universal_property` VALUES (1,1,1,1495803957,1495883514,'详细地址','address','Y',500,'S','L','N',NULL,'N','Y','Y','N',1,'yiisns\\kernel\\relatedProperties\\propertyTypes\\PropertyTypeText','a:8:{s:4:\"code\";s:1:\"S\";s:4:\"name\";s:4:\"Text\";s:13:\"default_value\";s:0:\"\";s:12:\"fieldElement\";s:8:\"textarea\";s:4:\"rows\";s:1:\"5\";s:2:\"id\";s:62:\"yiisns\\kernel\\relatedProperties\\propertyTypes\\PropertyTypeText\";s:8:\"property\";a:22:{s:2:\"id\";i:1;s:10:\"created_by\";i:1;s:10:\"updated_by\";i:1;s:10:\"created_at\";i:1495803957;s:10:\"updated_at\";i:1495818183;s:4:\"name\";s:12:\"详细地址\";s:4:\"code\";s:7:\"address\";s:6:\"active\";s:1:\"Y\";s:8:\"priority\";s:3:\"500\";s:13:\"property_type\";s:1:\"S\";s:9:\"list_type\";s:1:\"L\";s:8:\"multiple\";s:1:\"N\";s:12:\"multiple_cnt\";N;s:16:\"with_description\";s:1:\"N\";s:10:\"searchable\";s:1:\"Y\";s:9:\"filtrable\";s:1:\"Y\";s:11:\"is_required\";s:1:\"N\";s:7:\"version\";i:1;s:9:\"component\";s:62:\"yiisns\\kernel\\relatedProperties\\propertyTypes\\PropertyTypeText\";s:18:\"component_settings\";a:8:{s:4:\"code\";s:1:\"S\";s:4:\"name\";s:4:\"Text\";s:13:\"default_value\";s:0:\"\";s:12:\"fieldElement\";s:8:\"textarea\";s:4:\"rows\";s:1:\"5\";s:2:\"id\";s:62:\"yiisns\\kernel\\relatedProperties\\propertyTypes\\PropertyTypeText\";s:8:\"property\";a:22:{s:2:\"id\";i:1;s:10:\"created_by\";i:1;s:10:\"updated_by\";i:1;s:10:\"created_at\";i:1495803957;s:10:\"updated_at\";i:1495805864;s:4:\"name\";s:12:\"详细地址\";s:4:\"code\";s:7:\"address\";s:6:\"active\";s:1:\"Y\";s:8:\"priority\";s:3:\"500\";s:13:\"property_type\";s:1:\"S\";s:9:\"list_type\";s:1:\"L\";s:8:\"multiple\";s:1:\"N\";s:12:\"multiple_cnt\";N;s:16:\"with_description\";s:1:\"N\";s:10:\"searchable\";s:1:\"Y\";s:9:\"filtrable\";s:1:\"Y\";s:11:\"is_required\";s:1:\"Y\";s:7:\"version\";i:1;s:9:\"component\";s:62:\"yiisns\\kernel\\relatedProperties\\propertyTypes\\PropertyTypeText\";s:18:\"component_settings\";a:8:{s:4:\"code\";s:1:\"S\";s:4:\"name\";s:4:\"Text\";s:13:\"default_value\";s:10:\"1111111111\";s:12:\"fieldElement\";s:8:\"textarea\";s:4:\"rows\";s:1:\"5\";s:2:\"id\";s:62:\"yiisns\\kernel\\relatedProperties\\propertyTypes\\PropertyTypeText\";s:8:\"property\";a:22:{s:2:\"id\";i:1;s:10:\"created_by\";i:1;s:10:\"updated_by\";i:1;s:10:\"created_at\";i:1495803957;s:10:\"updated_at\";i:1495804852;s:4:\"name\";s:12:\"详细地址\";s:4:\"code\";s:7:\"address\";s:6:\"active\";s:1:\"Y\";s:8:\"priority\";s:3:\"500\";s:13:\"property_type\";s:1:\"S\";s:9:\"list_type\";s:1:\"L\";s:8:\"multiple\";s:1:\"N\";s:12:\"multiple_cnt\";N;s:16:\"with_description\";s:1:\"N\";s:10:\"searchable\";s:1:\"Y\";s:9:\"filtrable\";s:1:\"Y\";s:11:\"is_required\";s:1:\"Y\";s:7:\"version\";i:1;s:9:\"component\";s:62:\"yiisns\\kernel\\relatedProperties\\propertyTypes\\PropertyTypeText\";s:18:\"component_settings\";a:8:{s:4:\"code\";s:1:\"S\";s:4:\"name\";s:4:\"Text\";s:13:\"default_value\";s:10:\"1111111111\";s:12:\"fieldElement\";s:8:\"textarea\";s:4:\"rows\";s:1:\"5\";s:2:\"id\";s:62:\"yiisns\\kernel\\relatedProperties\\propertyTypes\\PropertyTypeText\";s:8:\"property\";a:22:{s:2:\"id\";i:1;s:10:\"created_by\";i:1;s:10:\"updated_by\";i:1;s:10:\"created_at\";i:1495803957;s:10:\"updated_at\";i:1495804824;s:4:\"name\";s:7:\"address\";s:4:\"code\";s:7:\"address\";s:6:\"active\";s:1:\"Y\";s:8:\"priority\";s:3:\"500\";s:13:\"property_type\";s:1:\"S\";s:9:\"list_type\";s:1:\"L\";s:8:\"multiple\";s:1:\"N\";s:12:\"multiple_cnt\";N;s:16:\"with_description\";s:1:\"N\";s:10:\"searchable\";s:1:\"Y\";s:9:\"filtrable\";s:1:\"Y\";s:11:\"is_required\";s:1:\"Y\";s:7:\"version\";i:1;s:9:\"component\";s:62:\"yiisns\\kernel\\relatedProperties\\propertyTypes\\PropertyTypeText\";s:18:\"component_settings\";a:8:{s:4:\"code\";s:1:\"S\";s:4:\"name\";s:4:\"Text\";s:13:\"default_value\";s:10:\"1111111111\";s:12:\"fieldElement\";s:11:\"hiddenInput\";s:4:\"rows\";s:1:\"5\";s:2:\"id\";s:62:\"yiisns\\kernel\\relatedProperties\\propertyTypes\\PropertyTypeText\";s:8:\"property\";a:22:{s:2:\"id\";i:1;s:10:\"created_by\";i:1;s:10:\"updated_by\";i:1;s:10:\"created_at\";i:1495803957;s:10:\"updated_at\";i:1495803957;s:4:\"name\";s:7:\"address\";s:4:\"code\";s:7:\"address\";s:6:\"active\";s:1:\"Y\";s:8:\"priority\";s:3:\"500\";s:13:\"property_type\";s:1:\"S\";s:9:\"list_type\";s:1:\"L\";s:8:\"multiple\";s:1:\"N\";s:12:\"multiple_cnt\";N;s:16:\"with_description\";s:1:\"N\";s:10:\"searchable\";s:1:\"Y\";s:9:\"filtrable\";s:1:\"Y\";s:11:\"is_required\";s:1:\"Y\";s:7:\"version\";i:1;s:9:\"component\";s:62:\"yiisns\\kernel\\relatedProperties\\propertyTypes\\PropertyTypeText\";s:18:\"component_settings\";a:8:{s:4:\"code\";s:1:\"S\";s:4:\"name\";s:4:\"Text\";s:13:\"default_value\";s:10:\"1111111111\";s:12:\"fieldElement\";s:11:\"hiddenInput\";s:4:\"rows\";s:1:\"5\";s:2:\"id\";s:62:\"yiisns\\kernel\\relatedProperties\\propertyTypes\\PropertyTypeText\";s:8:\"property\";a:14:{s:6:\"active\";s:1:\"Y\";s:8:\"priority\";s:3:\"500\";s:13:\"property_type\";s:1:\"S\";s:9:\"list_type\";s:1:\"L\";s:8:\"multiple\";s:1:\"N\";s:10:\"searchable\";s:1:\"N\";s:9:\"filtrable\";s:1:\"N\";s:7:\"version\";i:1;s:15:\"smart_filtrable\";s:1:\"N\";s:11:\"is_required\";s:1:\"Y\";s:4:\"name\";s:7:\"address\";s:4:\"code\";s:7:\"address\";s:9:\"component\";s:62:\"yiisns\\kernel\\relatedProperties\\propertyTypes\\PropertyTypeText\";s:4:\"hint\";s:0:\"\";}s:10:\"activeForm\";N;}s:4:\"hint\";s:12:\"有效地址\";s:15:\"smart_filtrable\";s:1:\"Y\";}s:10:\"activeForm\";N;}s:4:\"hint\";s:12:\"有效地址\";s:15:\"smart_filtrable\";s:1:\"Y\";}s:10:\"activeForm\";N;}s:4:\"hint\";s:12:\"有效地址\";s:15:\"smart_filtrable\";s:1:\"Y\";}s:10:\"activeForm\";N;}s:4:\"hint\";s:12:\"有效地址\";s:15:\"smart_filtrable\";s:1:\"Y\";}s:10:\"activeForm\";N;}s:4:\"hint\";s:12:\"有效地址\";s:15:\"smart_filtrable\";s:1:\"Y\";}s:10:\"activeForm\";N;}','有效地址','Y');
/*!40000 ALTER TABLE `yiisns_user_universal_property` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

--
-- Table structure for table `yiisns_user_universal_property_enum`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yiisns_user_universal_property_enum` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `property_id` int(11) DEFAULT NULL,
  `value` varchar(255) NOT NULL,
  `def` char(1) NOT NULL DEFAULT 'N',
  `code` varchar(32) NOT NULL,
  `priority` int(11) NOT NULL DEFAULT '500',
  PRIMARY KEY (`id`),
  KEY `updated_by` (`updated_by`),
  KEY `created_by` (`created_by`),
  KEY `created_at` (`created_at`),
  KEY `updated_at` (`updated_at`),
  KEY `property_id` (`property_id`),
  KEY `def` (`def`),
  KEY `code` (`code`),
  KEY `priority` (`priority`),
  KEY `value` (`value`),
  CONSTRAINT `yiisns_user_universal_property_enum_created_by` FOREIGN KEY (`created_by`) REFERENCES `yiisns_user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `yiisns_user_universal_property_enum_property_id` FOREIGN KEY (`property_id`) REFERENCES `yiisns_user_universal_property` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `yiisns_user_universal_property_enum_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `yiisns_user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Справочник значений свойств типа список';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yiisns_user_universal_property_enum`
--

LOCK TABLES `yiisns_user_universal_property_enum` WRITE;
/*!40000 ALTER TABLE `yiisns_user_universal_property_enum` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `yiisns_user_universal_property_enum` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on: Fri, 02 Jun 2017 17:53:49 +0000
