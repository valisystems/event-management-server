-- MySQL dump 10.13  Distrib 5.6.13, for osx10.6 (i386)
--
-- Host: mialert    Database: mialert
-- ------------------------------------------------------
-- Server version	5.1.71-log

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
-- Table structure for table `mia_access_number`
--

DROP TABLE IF EXISTS `mia_access_number`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mia_access_number` (
  `id_access_number` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `provisioning_number` varchar(100) DEFAULT NULL,
  `notification_number` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_access_number`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mia_access_number`
--

LOCK TABLES `mia_access_number` WRITE;
/*!40000 ALTER TABLE `mia_access_number` DISABLE KEYS */;
INSERT INTO `mia_access_number` VALUES (1,'12345','258');
/*!40000 ALTER TABLE `mia_access_number` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mia_asterisk`
--

DROP TABLE IF EXISTS `mia_asterisk`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mia_asterisk` (
  `id_asterisk` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `asterisk_name` varchar(150) CHARACTER SET latin1 DEFAULT NULL,
  `asterisk_url` varchar(200) CHARACTER SET latin1 DEFAULT NULL,
  `voip_url` varchar(200) DEFAULT NULL,
  `id_building` int(10) unsigned DEFAULT NULL,
  `limit_of_ext` tinyint(3) unsigned DEFAULT NULL,
  PRIMARY KEY (`id_asterisk`),
  KEY `FK_id_building` (`id_building`),
  CONSTRAINT `FK_id_building` FOREIGN KEY (`id_building`) REFERENCES `mia_buildings` (`id_building`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `mia_buildings`
--

DROP TABLE IF EXISTS `mia_buildings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mia_buildings` (
  `id_building` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `address` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id_building`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `mia_calls_type`
--

DROP TABLE IF EXISTS `mia_calls_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mia_calls_type` (
  `id_call_type` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(150) DEFAULT NULL,
  `script` varchar(150) DEFAULT NULL,
  `priority` tinyint(3) unsigned DEFAULT NULL,
  `color_hex` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id_call_type`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `mia_device_number_call`
--

DROP TABLE IF EXISTS `mia_device_number_call`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mia_device_number_call` (
  `id_device_number_call` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_device` int(10) unsigned NOT NULL DEFAULT '0',
  `number_to_call` varchar(15) NOT NULL,
  PRIMARY KEY (`id_device_number_call`),
  KEY `FK_dev_numb_call_id_device` (`id_device`),
  CONSTRAINT `FK_dev_numb_call_id_device` FOREIGN KEY (`id_device`) REFERENCES `mia_devices` (`id_device`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mia_device_number_call`
--

LOCK TABLES `mia_device_number_call` WRITE;
/*!40000 ALTER TABLE `mia_device_number_call` DISABLE KEYS */;
/*!40000 ALTER TABLE `mia_device_number_call` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mia_devices`
--

DROP TABLE IF EXISTS `mia_devices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mia_devices` (
  `id_device` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_building` int(10) unsigned NOT NULL,
  `id_map` int(10) unsigned NOT NULL,
  `id_room` int(10) unsigned NOT NULL,
  `device_description` varchar(250) NOT NULL,
  `serial_number` varchar(50) NOT NULL,
  `language` varchar(3) NOT NULL,
  `activity_timer` tinyint(3) unsigned NOT NULL,
  `activity_timer_status` enum('0','1') NOT NULL DEFAULT '1',
  `nurce_aknowege` tinyint(3) unsigned NOT NULL,
  `nurce_aknowege_status` enum('0','1') NOT NULL DEFAULT '1',
  `device_type` enum('button','phone','camera') NOT NULL DEFAULT 'button',
  `call_duration` tinyint(3) unsigned NOT NULL,
  `auto_test` tinyint(3) unsigned NOT NULL,
  `auto_test_status` enum('0','1') NOT NULL DEFAULT '1',
  `comon_area` enum('0','1') NOT NULL DEFAULT '1',
  `id_access_number` int(11) NOT NULL,
  `type_access_number` varchar(10) NOT NULL,
  `coordonate_on_map` varchar(250) DEFAULT NULL,
  `position_popup` enum('left','top','right','bottom','topleft','topright','bottomleft','bottomright') DEFAULT 'top',
  PRIMARY KEY (`id_device`),
  KEY `FK_devices_id_building` (`id_building`),
  KEY `FK_devices_id_map` (`id_map`),
  KEY `FK_devices_id_room` (`id_room`),
  CONSTRAINT `FK_devices_id_building` FOREIGN KEY (`id_building`) REFERENCES `mia_buildings` (`id_building`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_devices_id_map` FOREIGN KEY (`id_map`) REFERENCES `mia_maps` (`id_map`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_devices_id_room` FOREIGN KEY (`id_room`) REFERENCES `mia_rooms` (`id_room`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;



--
-- Table structure for table `mia_emergency_contact`
--

DROP TABLE IF EXISTS `mia_emergency_contact`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mia_emergency_contact` (
  `id_emergency_contact` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_patient` int(10) unsigned NOT NULL,
  `name_contact` varchar(80) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `email` varchar(150) NOT NULL,
  `sms` varchar(15) NOT NULL,
  `login_id` varchar(250) NOT NULL,
  `passwd` varchar(250) NOT NULL,
  PRIMARY KEY (`id_emergency_contact`),
  KEY `emergency_contact_id_patient` (`id_patient`),
  CONSTRAINT `emergency_contact_id_patient` FOREIGN KEY (`id_patient`) REFERENCES `mia_patients` (`id_patient`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `mia_events_manage`
--

DROP TABLE IF EXISTS `mia_events_manage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mia_events_manage` (
  `id_event` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_device` int(10) unsigned NOT NULL DEFAULT '0',
  `id_call_type` int(10) unsigned DEFAULT '0',
  `id_notification_settings` int(10) unsigned NOT NULL DEFAULT '0',
  `event_type` enum('template','custom') NOT NULL,
  `id_global_event` int(10) unsigned DEFAULT NULL,
  `live_panel` enum('Y','N') DEFAULT 'Y',
  `require_acknowledge` enum('Y','N') DEFAULT 'Y',
  `auto_close` enum('Y','N') DEFAULT 'Y',
  `flashing_toggle` enum('Y','N') DEFAULT 'Y',
  `auto_close_duration` tinyint(3) unsigned DEFAULT NULL,
  `position_popup` enum('left','top','right','bottom','topleft','topright','bottomleft','bottomright') DEFAULT 'top',
  PRIMARY KEY (`id_event`),
  KEY `FK_events_manage_id_device` (`id_device`),
  KEY `FK_events_manage_id_call_type` (`id_call_type`),
  KEY `FK_events_manage_id_global_event` (`id_global_event`),
  CONSTRAINT `FK_events_manage_id_call_type` FOREIGN KEY (`id_call_type`) REFERENCES `mia_calls_type` (`id_call_type`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_events_manage_id_device` FOREIGN KEY (`id_device`) REFERENCES `mia_devices` (`id_device`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_events_manage_id_global_event` FOREIGN KEY (`id_global_event`) REFERENCES `mia_global_event_template` (`id_global_event_template`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;



--
-- Table structure for table `mia_extension_info`
--

DROP TABLE IF EXISTS `mia_extension_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mia_extension_info` (
  `id_extension` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_asterisk` int(10) unsigned DEFAULT '0',
  `id_device` int(10) unsigned DEFAULT '0',
  `ext_number` varchar(10) DEFAULT '0',
  `password` varchar(70) DEFAULT NULL,
  `caller_id_internal` varchar(70) DEFAULT NULL,
  `caller_id_external` varchar(70) DEFAULT NULL,
  `caller_id_name` varchar(70) DEFAULT NULL,
  `extension_define` enum('0','1') DEFAULT '0',
  PRIMARY KEY (`id_extension`),
  KEY `FK_extension_info_asterisk` (`id_asterisk`),
  KEY `FK_extension_info_device` (`id_device`),
  CONSTRAINT `FK_extension_info_asterisk` FOREIGN KEY (`id_asterisk`) REFERENCES `mia_asterisk` (`id_asterisk`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_extension_info_device` FOREIGN KEY (`id_device`) REFERENCES `mia_devices` (`id_device`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `mia_extension_status`
--

DROP TABLE IF EXISTS `mia_extension_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mia_extension_status` (
  `id_ext_status` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_call_type` int(10) unsigned DEFAULT NULL,
  `id_extension` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id_ext_status`),
  KEY `FK_extension_status_call_type` (`id_call_type`),
  KEY `FK_extension_id_extension` (`id_extension`),
  CONSTRAINT `FK_extension_id_extension` FOREIGN KEY (`id_extension`) REFERENCES `mia_extension_info` (`id_extension`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_extension_status_call_type` FOREIGN KEY (`id_call_type`) REFERENCES `mia_calls_type` (`id_call_type`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mia_extension_status`
--

LOCK TABLES `mia_extension_status` WRITE;
/*!40000 ALTER TABLE `mia_extension_status` DISABLE KEYS */;
/*!40000 ALTER TABLE `mia_extension_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mia_global_event_template`
--

DROP TABLE IF EXISTS `mia_global_event_template`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mia_global_event_template` (
  `id_global_event_template` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `desc_global_event` varchar(150) NOT NULL,
  `id_call_type` int(10) unsigned DEFAULT NULL,
  `pick_event_type` enum('SMS','EMAIL','VOIP') DEFAULT NULL,
  `id_global_message` int(10) unsigned DEFAULT NULL,
  `live_panel` enum('Y','N') DEFAULT 'Y',
  `require_acknowledge` enum('Y','N') DEFAULT 'Y',
  `auto_close` enum('Y','N') DEFAULT 'Y',
  `flashing_toggle` enum('Y','N') DEFAULT 'Y',
  `auto_close_duration` tinyint(3) unsigned DEFAULT NULL,
  `position_popup` enum('left','top','right','bottom','topleft','topright','bottomleft','bottomright') DEFAULT 'top',
  PRIMARY KEY (`id_global_event_template`),
  KEY `FKglobal_event_template_global_message` (`id_global_message`),
  KEY `FKglobal_event_template_call_type` (`id_call_type`),
  CONSTRAINT `FKglobal_event_template_call_type` FOREIGN KEY (`id_call_type`) REFERENCES `mia_calls_type` (`id_call_type`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FKglobal_event_template_global_message` FOREIGN KEY (`id_global_message`) REFERENCES `mia_global_messages` (`id_global_message`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;



--
-- Table structure for table `mia_global_messages`
--

DROP TABLE IF EXISTS `mia_global_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mia_global_messages` (
  `id_global_message` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `global_description` varchar(250) DEFAULT NULL,
  `global_subject` varchar(100) DEFAULT NULL,
  `global_text` text,
  PRIMARY KEY (`id_global_message`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;



--
-- Table structure for table `mia_mail_settings`
--

DROP TABLE IF EXISTS `mia_mail_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mia_mail_settings` (
  `id_mail_settings` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `host` varchar(100) DEFAULT NULL,
  `port` varchar(10) DEFAULT NULL,
  `security_type` varchar(3) DEFAULT NULL,
  `login_name` varchar(50) DEFAULT NULL,
  `passwd` varchar(50) DEFAULT NULL,
  `from_text` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_mail_settings`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;



--
-- Table structure for table `mia_maps`
--

DROP TABLE IF EXISTS `mia_maps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mia_maps` (
  `id_map` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name_map` varchar(100) DEFAULT NULL,
  `description` varchar(250) DEFAULT NULL,
  `id_building` int(10) unsigned DEFAULT NULL,
  `path_to_img` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id_map`),
  KEY `FK_maps_id_building` (`id_building`),
  CONSTRAINT `FK_maps_id_building` FOREIGN KEY (`id_building`) REFERENCES `mia_buildings` (`id_building`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;



--
-- Table structure for table `mia_messages_patients`
--

DROP TABLE IF EXISTS `mia_messages_patients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mia_messages_patients` (
  `id_message_patient` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_patient` int(10) unsigned DEFAULT NULL,
  `messages_type` enum('E','T') NOT NULL COMMENT 'Email, Text',
  `text_message` text NOT NULL COMMENT 'Email, Text',
  PRIMARY KEY (`id_message_patient`),
  KEY `FK_message_patient_id_paient` (`id_patient`),
  CONSTRAINT `FK_message_patient_id_paient` FOREIGN KEY (`id_patient`) REFERENCES `mia_patients` (`id_patient`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mia_messages_patients`
--

LOCK TABLES `mia_messages_patients` WRITE;
/*!40000 ALTER TABLE `mia_messages_patients` DISABLE KEYS */;
/*!40000 ALTER TABLE `mia_messages_patients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mia_notification_log`
--

DROP TABLE IF EXISTS `mia_notification_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mia_notification_log` (
  `id_log` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `serial_number` varchar(10) DEFAULT NULL,
  `code` varchar(5) DEFAULT NULL,
  `dtmf_device_number` varchar(5) DEFAULT NULL,
  `call_id` varchar(100) DEFAULT NULL,
  `type_notification` enum('SMS','EMAIL','VOIP') DEFAULT NULL,
  `receiver` varchar(250) DEFAULT NULL,
  `message_sent` text,
  `current_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `response_message` text,
  `status_of_notification` enum('0','1') DEFAULT NULL,
  `time_stamp` timestamp NULL DEFAULT NULL,
  `room_number` varchar(50) DEFAULT NULL,
  `room_id` int(10) unsigned DEFAULT NULL,
  `device_description` varchar(250) DEFAULT NULL,
  `live_panel` enum('Y','N') DEFAULT 'Y',
  `require_acknowledge` enum('Y','N') DEFAULT 'Y',
  `auto_close` enum('Y','N') DEFAULT 'Y',
  `flashing_toggle` enum('Y','N') DEFAULT 'Y',
  `auto_close_duration` tinyint(3) unsigned DEFAULT NULL,
  `position_popup` enum('left','top','right','bottom','topleft','topright','bottomleft','bottomright') DEFAULT 'top',
  PRIMARY KEY (`id_log`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mia_notification_settings`
--

DROP TABLE IF EXISTS `mia_notification_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mia_notification_settings` (
  `id_notification_setting` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `alarm_sound` enum('Y','N') DEFAULT 'Y',
  `escalation_interval` smallint(6) DEFAULT NULL,
  `number_of_retry` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id_notification_setting`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;



--
-- Table structure for table `mia_patient_cameras`
--

DROP TABLE IF EXISTS `mia_patient_cameras`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mia_patient_cameras` (
  `id_patient_cameras` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_patient` int(10) unsigned NOT NULL DEFAULT '0',
  `url_camera` varchar(150) NOT NULL,
  `desc_camera` varchar(150) NOT NULL,
  PRIMARY KEY (`id_patient_cameras`),
  KEY `FKpatient_cameras` (`id_patient`),
  CONSTRAINT `FKpatient_cameras` FOREIGN KEY (`id_patient`) REFERENCES `mia_patients` (`id_patient`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;



--
-- Table structure for table `mia_patients`
--

DROP TABLE IF EXISTS `mia_patients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mia_patients` (
  `id_patient` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(80) DEFAULT NULL,
  `last_name` varchar(80) DEFAULT NULL,
  `avatar_path` varchar(150) DEFAULT NULL,
  `afliction` varchar(80) DEFAULT NULL,
  `language` varchar(3) DEFAULT 'en',
  `text_desc` varchar(150) DEFAULT NULL,
  `email_desc` varchar(150) DEFAULT NULL,
  `voice_desc` varchar(150) DEFAULT NULL,
  `voice_message` text,
  `text_message` text,
  `email_message` text,
  PRIMARY KEY (`id_patient`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;



--
-- Table structure for table `mia_patients_notes`
--

DROP TABLE IF EXISTS `mia_patients_notes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mia_patients_notes` (
  `id_patients_notes` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_patient` int(10) unsigned NOT NULL,
  `notes` text NOT NULL,
  `file_url` varchar(250) NOT NULL,
  PRIMARY KEY (`id_patients_notes`),
  KEY `FK_patient_notes_id_patient` (`id_patient`),
  CONSTRAINT `FK_patient_notes_id_patient` FOREIGN KEY (`id_patient`) REFERENCES `mia_patients` (`id_patient`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;



--
-- Table structure for table `mia_pick_events`
--

DROP TABLE IF EXISTS `mia_pick_events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mia_pick_events` (
  `id_pick_event` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_event` int(10) unsigned NOT NULL,
  `pick_event_type` enum('SMS','EMAIL','VOIP') NOT NULL,
  `id_contact` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id_pick_event`),
  KEY `FK_id_event` (`id_event`),
  CONSTRAINT `FK_id_event` FOREIGN KEY (`id_event`) REFERENCES `mia_events_manage` (`id_event`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;



--
-- Table structure for table `mia_receiver`
--

DROP TABLE IF EXISTS `mia_receiver`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mia_receiver` (
  `id_receiver` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_global_event_template` int(10) unsigned NOT NULL,
  `id_system_sms_number` int(10) unsigned DEFAULT NULL,
  `id_system_email` int(10) unsigned DEFAULT NULL,
  `id_system_voice_number` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id_receiver`),
  KEY `FK_receiver_global_event_template` (`id_global_event_template`),
  KEY `FK_receiver_system_sms_number` (`id_system_sms_number`),
  KEY `FK_receiver_system_email` (`id_system_email`),
  KEY `FK_id_system_voice_number` (`id_system_voice_number`),
  CONSTRAINT `FK_id_system_voice_number` FOREIGN KEY (`id_system_voice_number`) REFERENCES `mia_system_voice_number` (`id_system_voice_number`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_receiver_global_event_template` FOREIGN KEY (`id_global_event_template`) REFERENCES `mia_global_event_template` (`id_global_event_template`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_receiver_system_email` FOREIGN KEY (`id_system_email`) REFERENCES `mia_system_email` (`id_system_email`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_receiver_system_sms_number` FOREIGN KEY (`id_system_sms_number`) REFERENCES `mia_system_sms_numbers` (`id_system_sms_number`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;



--
-- Table structure for table `mia_residents_of_rooms`
--

DROP TABLE IF EXISTS `mia_residents_of_rooms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mia_residents_of_rooms` (
  `id_resident_of_room` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_room` int(10) unsigned NOT NULL,
  `id_patient` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id_resident_of_room`),
  KEY `FK_resident_of_room_id_room` (`id_room`),
  KEY `FK_resident_of_room_id_patient` (`id_patient`),
  CONSTRAINT `FK_resident_of_room_id_patient` FOREIGN KEY (`id_patient`) REFERENCES `mia_patients` (`id_patient`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_resident_of_room_id_room` FOREIGN KEY (`id_room`) REFERENCES `mia_rooms` (`id_room`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;



--
-- Table structure for table `mia_room_device_patient`
--

DROP TABLE IF EXISTS `mia_room_device_patient`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mia_room_device_patient` (
  `id_room_device_patient` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_room` int(10) unsigned NOT NULL,
  `id_device` int(10) unsigned DEFAULT NULL,
  `id_patient` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id_room_device_patient`),
  KEY `FK_rdp_id_room` (`id_room`),
  KEY `FK_rdp_id_device` (`id_device`),
  KEY `FK_rdp_id_patient` (`id_patient`),
  CONSTRAINT `FK_rdp_id_device` FOREIGN KEY (`id_device`) REFERENCES `mia_devices` (`id_device`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_rdp_id_patient` FOREIGN KEY (`id_patient`) REFERENCES `mia_patients` (`id_patient`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_rdp_id_room` FOREIGN KEY (`id_room`) REFERENCES `mia_rooms` (`id_room`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `mia_rooms`
--

DROP TABLE IF EXISTS `mia_rooms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mia_rooms` (
  `id_room` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nb_room` varchar(10) DEFAULT '0',
  `nb_of_seats` tinyint(4) DEFAULT '0',
  `coordinate_on_map` varchar(100) DEFAULT NULL,
  `id_building` int(11) unsigned DEFAULT NULL,
  `id_map` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id_room`),
  KEY `FK_rooms_id_building` (`id_building`),
  KEY `FK_rooms_id_map` (`id_map`),
  CONSTRAINT `FK_rooms_id_building` FOREIGN KEY (`id_building`) REFERENCES `mia_buildings` (`id_building`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_rooms_id_map` FOREIGN KEY (`id_map`) REFERENCES `mia_maps` (`id_map`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;



--
-- Table structure for table `mia_settings`
--

DROP TABLE IF EXISTS `mia_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mia_settings` (
  `id_settings` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `site_name` varchar(100) DEFAULT NULL,
  `site_email` varchar(100) DEFAULT NULL,
  `logo_path` varchar(150) DEFAULT NULL,
  `header` text,
  `footer` text,
  `default_lang` varchar(3) NOT NULL DEFAULT 'en',
  `tts_voice` varchar(3) NOT NULL DEFAULT 'w',
  `provisioning_number` varchar(12) DEFAULT NULL,
  `notification_number` varchar(12) DEFAULT NULL,
  `extension_limit_number` tinyint(3) unsigned DEFAULT '3',
  `sms_url` varchar(200) DEFAULT NULL,
  `activation_key` varchar(250) NOT NULL DEFAULT '',
  `secret_key` varchar(250) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_settings`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;



--
-- Table structure for table `mia_system_email`
--

DROP TABLE IF EXISTS `mia_system_email`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mia_system_email` (
  `id_system_email` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description_email` varchar(250) CHARACTER SET latin1 DEFAULT NULL,
  `name_email` varchar(250) CHARACTER SET latin1 DEFAULT NULL,
  `email` varchar(250) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`id_system_email`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;



--
-- Table structure for table `mia_system_notice`
--

DROP TABLE IF EXISTS `mia_system_notice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mia_system_notice` (
  `id_system_notice` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description_notice` varchar(250) NOT NULL,
  `name_notice` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  PRIMARY KEY (`id_system_notice`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `mia_system_sms_numbers`
--

DROP TABLE IF EXISTS `mia_system_sms_numbers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mia_system_sms_numbers` (
  `id_system_sms_number` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description_sms` varchar(250) DEFAULT NULL,
  `name_sms` varchar(250) DEFAULT NULL,
  `number_sms` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`id_system_sms_number`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;



--
-- Table structure for table `mia_system_voice_number`
--

DROP TABLE IF EXISTS `mia_system_voice_number`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mia_system_voice_number` (
  `id_system_voice_number` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description_voice_number` varchar(250) NOT NULL,
  `name_voice_number` varchar(250) NOT NULL,
  `number_to_call` varchar(11) NOT NULL,
  PRIMARY KEY (`id_system_voice_number`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `mia_users`
--

DROP TABLE IF EXISTS `mia_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mia_users` (
  `id_user` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `login_name` varchar(50) DEFAULT NULL,
  `passwd` varchar(100) DEFAULT NULL,
  `role` enum('A','M','U') DEFAULT 'U',
  `email` varchar(80) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `company` varchar(50) DEFAULT NULL,
  `reports` enum('1','0') DEFAULT '1',
  `status` enum('0','1') DEFAULT '1',
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Dumping data for table `mia_users`
--

ALTER TABLE mia_users ADD access_rules MEDIUMTEXT NOT NULL;
ALTER TABLE mia_users ADD buildings_rules MEDIUMTEXT NOT NULL;


LOCK TABLES `mia_users` WRITE;
/*!40000 ALTER TABLE `mia_users` DISABLE KEYS */;
INSERT INTO `mia_users` VALUES (1,'Admin','Admin','admin','81dc9bdb52d04dc20036dbd8313ed055','A','admin@teleportvideo.com',NULL,'Claricom','1','1', '','');
/*!40000 ALTER TABLE `mia_users` ENABLE KEYS */;
UNLOCK TABLES;

update mia_users SET access_rules ='a:40:{i:0;s:14:"admin/asterisk";i:1;s:15:"admin/buildings";i:2;s:15:"admin/callsType";i:3;s:17:"admin/pendantType";i:4;s:17:"admin/maxivoxType";i:5;s:14:"admin/delivery";i:6;s:13:"admin/devices";i:7;s:17:"admin/positioning";i:8;s:20:"admin/pendantDevices";i:9;s:19:"admin/maxivoxDevice";i:10;s:12:"admin/export";i:11;s:10:"admin/func";i:12;s:25:"admin/globalEventTemplate";i:13;s:32:"admin/globalEventPendantTemplate";i:14;s:32:"admin/globalEventMaxivoxTemplate";i:15;s:20:"admin/globalMessages";i:16;s:13:"admin/command";i:17;s:19:"admin/systemCameras";i:18;s:10:"admin/maps";i:19;s:26:"admin/notificationSettings";i:20;s:14:"admin/patients";i:21;s:13:"admin/reports";i:22;s:19:"admin/eventsReports";i:23;s:26:"admin/eventsPendantReports";i:24;s:26:"admin/eventsMaxivoxReports";i:25;s:9:"admin/cdr";i:26;s:11:"admin/rooms";i:27;s:13:"admin/setting";i:28;s:17:"admin/systemEmail";i:29;s:18:"admin/systemNotice";i:30;s:22:"admin/systemSmsNumbers";i:31;s:23:"admin/systemVoiceNumber";i:32;s:11:"admin/users";i:33;s:12:"admin/events";i:34;s:19:"admin/eventsPendant";i:35;s:19:"admin/eventsMaxivox";i:36;s:11:"api/default";i:37;s:22:"api/notificationLookUp";i:38;s:17:"livepanel/default";i:39;s:21:"livepanel/liveRequest";}', buildings_rules='a:8:{i:0;s:3:"1/1";i:1;s:3:"1/3";i:2;s:4:"1/21";i:3;s:4:"1/22";i:4;s:3:"2/2";i:5;s:4:"2/20";i:6;s:4:"2/23";i:7;s:4:"2/24";}';
--
-- Table structure for table `mia_users_notes`
--

DROP TABLE IF EXISTS `mia_users_notes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mia_users_notes` (
  `id_user_note` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(10) unsigned NOT NULL,
  `notes` text NOT NULL,
  PRIMARY KEY (`id_user_note`),
  KEY `FK_un_id_user` (`id_user`),
  CONSTRAINT `FK_un_id_user` FOREIGN KEY (`id_user`) REFERENCES `mia_users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mia_users_notes`
--

LOCK TABLES `mia_users_notes` WRITE;
/*!40000 ALTER TABLE `mia_users_notes` DISABLE KEYS */;
/*!40000 ALTER TABLE `mia_users_notes` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-01-15 23:44:27
