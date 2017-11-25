# Host: localhost  (Version 5.7.17-log)
# Date: 2017-11-25 16:32:07
# Generator: MySQL-Front 6.0  (Build 2.20)


#
# Structure for table "firma"
#

CREATE TABLE `firma` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firma_ad` varchar(255) DEFAULT NULL,
  `tarih` datetime DEFAULT NULL,
  `durum` int(11) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

#
# Data for table "firma"
#

INSERT INTO `firma` VALUES (1,'Kayrasoft','2017-04-07 14:27:00',1),(2,'Atlas Ajans',NULL,1);

#
# Structure for table "islemler"
#

CREATE TABLE `islemler` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `tarih` datetime DEFAULT NULL,
  `personel` int(11) DEFAULT NULL,
  `tur` varchar(255) DEFAULT NULL,
  `aciklama` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=176 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "islemler"
#

INSERT INTO `islemler` VALUES (1,'2017-03-09 14:24:02',1,'Giriş','Yönetici sisteme giriş yaptı.'),(2,'2017-03-09 15:29:15',1,'Personel Ekleme','Yönetici, sisteme personel ekledi. (Evren Ayvaz, kullanıcı adı : evrenayvaz)'),(3,'2017-03-09 15:33:35',1,'Personel Düzenle','Yönetici, sistemdeki personeli güncelledi. (Evren Ayvaz - evrenayvaz)'),(4,'2017-03-09 15:52:59',1,'Personel Düzenle','Yönetici, sistemdeki personeli güncelledi. (Evren Ayvaz1 - evrenayvaz1)'),(5,'2017-03-09 15:54:54',1,'Personel Ekleme','Yönetici, sisteme personel ekledi. (tESTER, kullanıcı adı : tESTER)'),(6,'2017-03-09 15:55:45',1,'Personel Silme','Yönetici, sistemde ki personeli sildi. (tESTER, kullanıcı adı : tESTER)'),(7,'2017-03-09 15:57:41',1,'Personel Silme','Yönetici, sistemde ki personeli sildi. (Evren Ayvaz1, kullanıcı adı : evrenayvaz1)'),(8,'2017-03-09 16:19:03',1,'Firma Yönetimi | Ekle','Yönetici, tester, adlı firma ekledi..'),(9,'2017-03-09 16:19:25',1,'Firma Yönetimi | Ekle','Yönetici, fasfafs, adlı firma ekledi..'),(10,'2017-03-09 16:28:32',1,'Genel Tanımlar','Yönetici, asfafasfas, adlı şehiri düzenledi.. => Eski Adı : , Durumu : Pasif'),(11,'2017-03-09 16:29:14',1,'Genel Tanımlar','Yönetici, asfafasfas21515, adlı şehiri düzenledi.. => Eski Adı : asfafasfas, Durumu : Pasif'),(12,'2017-03-09 16:29:16',1,'Genel Tanımlar','Yönetici, asfafasfas21515, adlı şehiri düzenledi.. => Eski Adı : asfafasfas21515, Durumu : Pasif'),(13,'2017-03-10 11:37:29',1,'Giriş','Ahmet Koç sisteme giriş yaptı.'),(14,'2017-03-10 13:51:33',1,'Genel Tanımlar','Ahmet Koç, Amasya Şeker1, adlı işi/projeyi düzenledi..'),(15,'2017-03-10 13:51:41',1,'Genel Tanımlar','Ahmet Koç, Amasya Şeker12, adlı işi/projeyi düzenledi..'),(16,'2017-03-10 13:51:47',1,'Genel Tanımlar','Ahmet Koç, Amasya Şeker12, adlı işi/projeyi düzenledi..'),(17,'2017-03-10 13:51:52',1,'Genel Tanımlar','Ahmet Koç, Amasya Şeker12, adlı işi/projeyi düzenledi..'),(18,'2017-03-10 13:52:48',1,'Genel Tanımlar','Ahmet Koç, Amasya Şeker12, adlı işi/projeyi düzenledi..'),(19,'2017-03-10 13:53:04',1,'Genel Tanımlar','Ahmet Koç, Amasya Şeker12, adlı işi/projeyi düzenledi..'),(20,'2017-03-10 13:53:12',1,'Genel Tanımlar','Ahmet Koç, Amasya Şeker12, adlı işi/projeyi düzenledi..'),(21,'2017-03-10 13:57:03',1,'Genel Tanımlar','Ahmet Koç, Amasya Şeker12, adlı işi/projeyi düzenledi..'),(22,'2017-03-10 13:57:12',1,'Genel Tanımlar','Ahmet Koç, Amasya Şeker12, adlı işi/projeyi düzenledi..'),(23,'2017-03-10 14:08:37',1,'Genel Tanımlar','Ahmet Koç, Amasya Şeker, adlı işi/projeyi düzenledi..'),(24,'2017-03-10 14:10:49',1,'Genel Tanımlar','Ahmet Koç, Amasya Şeker, adlı işi/projeyi düzenledi..'),(25,'2017-03-10 14:11:22',1,'Genel Tanımlar','Ahmet Koç, Amasya Şeker, adlı işi/projeyi düzenledi..'),(26,'2017-03-10 14:12:27',1,'Genel Tanımlar','Ahmet Koç, Amasya Şeker, adlı işi/projeyi düzenledi..'),(27,'2017-03-10 14:14:27',1,'Genel Tanımlar','Ahmet Koç, Amasya Şeker, adlı işi/projeyi düzenledi..'),(28,'2017-03-10 15:19:08',1,'İş Yönetimi','Ahmet Koç, Amasya Şeker, adlı işi/projeyi düzenledi..'),(29,'2017-03-10 15:19:21',1,'İş Yönetimi','Ahmet Koç, Amasya Şeker, adlı işi/projeyi düzenledi..'),(30,'2017-03-10 15:47:44',1,'İş Yönetimi','Ahmet Koç, Alan Adı Takip, adlı proje ekledi..'),(31,'2017-03-10 15:50:46',1,'İş Yönetimi > İş/Proje Düzenle','Ahmet Koç, Amasya Şeker, adlı işi/projeyi düzenledi..'),(32,'2017-03-10 15:52:01',1,'İş Yönetimi > İş/Proje Listesi','Ahmet Koç, bir proje sildi. (Amasya Şeker)'),(33,'2017-03-14 22:49:00',1,'Giriş','Ahmet Koç sisteme giriş yaptı.'),(34,'2017-03-14 23:14:40',1,'Firma Yönetimi','Ahmet Koç, bir firma sildi. (tester)'),(35,'2017-03-14 23:14:43',1,'Firma Yönetimi','Ahmet Koç, bir firma sildi. (tester)'),(36,'2017-03-14 23:14:53',1,'Firma Yönetimi','Ahmet Koç, bir firma sildi. (tester)'),(37,'2017-03-14 23:14:54',1,'Firma Yönetimi','Ahmet Koç, bir firma sildi. (asfafasfas21515)'),(38,'2017-03-22 13:58:32',1,'Giriş','Ahmet Koç sisteme giriş yaptı.'),(39,'2017-03-22 14:09:50',1,'İş Yönetimi > İş/Proje Düzenle','Ahmet Koç, Alan Adı Takip, adlı işi/projeyi düzenledi..'),(40,'2017-03-22 14:09:55',1,'İş Yönetimi > İş/Proje Düzenle','Ahmet Koç, Alan Adı Takip, adlı işi/projeyi düzenledi..'),(41,'2017-03-22 14:10:06',1,'İş Yönetimi > İş/Proje Düzenle','Ahmet Koç, Alan Adı Takip, adlı işi/projeyi düzenledi..'),(42,'2017-03-22 14:10:12',1,'İş Yönetimi > İş/Proje Düzenle','Ahmet Koç, Alan Adı Takip, adlı işi/projeyi düzenledi..'),(43,'2017-03-22 14:10:18',1,'İş Yönetimi > İş/Proje Düzenle','Ahmet Koç, Alan Adı Takip, adlı işi/projeyi düzenledi..'),(44,'2017-03-22 16:18:55',1,'İş Yönetimi > İş/Proje Düzenle','Ahmet Koç, Alan Adı Takip, adlı işi/projeyi düzenledi..'),(45,'2017-03-22 16:22:16',1,'İş Yönetimi > İş/Proje Düzenle','Ahmet Koç, Alan Adı Takip, adlı işi/projeyi düzenledi..'),(46,'2017-03-22 17:37:58',1,'İş Yönetimi > İş/Proje Düzenle','Ahmet Koç, Alan Adı Takip, adlı işi/projeyi düzenledi..'),(47,'2017-03-22 17:38:17',1,'İş Yönetimi > İş/Proje Düzenle','Ahmet Koç, Alan Adı Takip, adlı işi/projeyi düzenledi..'),(48,'2017-03-28 20:57:24',1,'Giriş','Ahmet Koç sisteme giriş yaptı.'),(49,'2017-03-30 17:47:12',1,'Giriş','Ahmet Koç sisteme giriş yaptı.'),(50,'2017-04-05 15:29:16',1,'Giriş','Ahmet Koç sisteme giriş yaptı.'),(51,'2017-04-05 16:07:06',1,'İş Yönetimi > İş/Proje Ekle','Ahmet Koç, Tester, adlı proje ekledi..'),(52,'2017-04-05 16:07:57',1,'İş Yönetimi > İş/Proje Listesi','Ahmet Koç, bir proje sildi. (Tester)'),(53,'2017-04-05 16:08:14',1,'İş Yönetimi > İş/Proje Ekle','Ahmet Koç, Tester, adlı proje ekledi..'),(54,'2017-04-06 17:29:58',1,'Genel Tanımlar','Yönetici, , adlı şehiri düzenledi.. => Eski Adı : Atlas Ajans, Durumu : Pasif'),(55,'2017-04-06 17:37:08',1,'Alan Adı Takip | Gelişme Ekle','Yönetici, Yönetici, bir gelişme ekledi.'),(56,'2017-04-06 17:41:15',1,'Alan Adı Takip | Gelişme Ekle','Yönetici, bir gelişme ekledi.'),(57,'2017-04-06 17:44:01',1,'Alan Adı Takip | Gelişme Ekle','Yönetici, bir gelişme ekledi.'),(58,'2017-04-07 11:32:48',1,'Giriş','Ahmet Koç sisteme giriş yaptı.'),(59,'2017-04-07 11:37:14',1,'Alan Adı Takip | Gelişme Ekle','Ahmet Koç, bir gelişme ekledi.'),(60,'2017-04-07 11:39:43',1,'İş Yönetimi > İş/Proje Düzenle','Ahmet Koç, Başka İş, adlı işi/projeyi düzenledi..'),(61,'2017-04-07 11:40:02',1,'Başka İş | Gelişme Ekle','Ahmet Koç, bir gelişme ekledi.'),(62,'2017-04-07 14:08:52',1,'Genel Tanımlar','Ahmet Koç, Atlas Ajans, adlı şehiri düzenledi.. => Eski Adı : Atlas Ajans, Durumu : Pasif'),(63,'2017-04-07 14:09:05',1,'Genel Tanımlar','Ahmet Koç, Atlas Ajans, adlı şehiri düzenledi.. => Eski Adı : Atlas Ajans, Durumu : Pasif'),(64,'2017-04-07 14:09:11',1,'Genel Tanımlar','Ahmet Koç, Atlas Ajans, adlı şehiri düzenledi.. => Eski Adı : Atlas Ajans, Durumu : Pasif'),(65,'2017-04-07 14:10:43',1,'Genel Tanımlar','Ahmet Koç, Atlas Ajans, adlı şehiri düzenledi.. => Eski Adı : Atlas Ajans, Eski Durum : Pasif, Yeni Durum : Aktif'),(66,'2017-04-07 14:27:52',1,'Genel Tanımlar','Ahmet Koç, Kayrasoft, adlı şehiri düzenledi.. => Eski Adı : Kayrasoft, Eski Durum : Pasif, Yeni Durum : Aktif'),(67,'2017-04-07 14:29:50',1,'Genel Tanımlar','Ahmet Koç, Kayrasofta, adlı şehiri düzenledi.. => Eski Adı : Kayrasoft, Eski Durum : Pasif, Yeni Durum : Aktif'),(68,'2017-04-07 14:29:52',1,'Genel Tanımlar','Ahmet Koç, Kayrasoft, adlı şehiri düzenledi.. => Eski Adı : Kayrasofta, Eski Durum : Pasif, Yeni Durum : Aktif'),(69,'2017-04-07 14:29:54',1,'Genel Tanımlar','Ahmet Koç, Kayrasoft, adlı şehiri düzenledi.. => Eski Adı : Kayrasoft, Eski Durum : Pasif, Yeni Durum : Pasif'),(70,'2017-04-07 14:29:56',1,'Genel Tanımlar','Ahmet Koç, Kayrasoft, adlı şehiri düzenledi.. => Eski Adı : Kayrasoft, Eski Durum : Pasif, Yeni Durum : Aktif'),(71,'2017-04-07 14:30:36',1,'Firma Yönetimi | Ekle','Ahmet Koç, Tester, adlı firma ekledi..'),(72,'2017-04-07 14:31:06',1,'Firma Yönetimi','Ahmet Koç, bir firma sildi. (Tester)'),(73,'2017-04-07 14:33:04',1,'Tester | Gelişme Ekle','Ahmet Koç, bir gelişme ekledi.'),(74,'2017-04-07 14:34:29',1,'İş Yönetimi > İş/Proje Listesi','Ahmet Koç, bir iş sildi. (Tester)'),(75,'2017-04-07 15:17:02',2,'Giriş','İlker Şahin sisteme giriş yaptı.'),(76,'2017-04-07 16:03:35',2,'Giriş','İlker Şahin sisteme giriş yaptı.'),(77,'2017-04-07 16:06:34',1,'Giriş','Ahmet Koç sisteme giriş yaptı.'),(78,'2017-04-07 16:06:43',2,'Giriş','İlker Şahin sisteme giriş yaptı.'),(79,'2017-04-07 17:38:11',2,'Alan Adı Takip | Gelişme Ekle','İlker Şahin, bir gelişme ekledi.'),(80,'2017-04-07 17:38:48',1,'Giriş','Ahmet Koç sisteme giriş yaptı.'),(81,'2017-04-07 17:39:13',1,'Personel Ekleme','Ahmet Koç, sisteme personel ekledi. (Müşteri, kullanıcı adı : müşteri)'),(82,'2017-04-07 17:40:22',6,'Giriş','Müşteri sisteme giriş yaptı.'),(83,'2017-04-07 18:25:22',1,'Giriş','Evren Ayvaz(müşteri) sisteme giriş yaptı.'),(84,'2017-04-07 18:25:36',1,'Giriş','Evren Ayvaz(müşteri) sisteme giriş yaptı.'),(85,'2017-04-07 18:50:10',1,'Giriş','Evren Ayvaz(müşteri) sisteme giriş yaptı.'),(86,'2017-04-07 18:50:21',1,'Giriş','Evren Ayvaz(müşteri) sisteme giriş yaptı.'),(87,'2017-04-07 18:52:31',1,'Giriş','Evren Ayvaz(müşteri) sisteme giriş yaptı.'),(88,'2017-04-07 18:53:18',1,'Giriş','Evren Ayvaz(müşteri) sisteme giriş yaptı.'),(89,'2017-04-07 18:54:38',1,'Giriş','Evren Ayvaz(müşteri) sisteme giriş yaptı.'),(90,'2017-04-07 18:59:20',1,'Giriş','Evren Ayvaz(müşteri) sisteme giriş yaptı.'),(91,'2017-04-07 19:02:28',1,'Giriş','Ahmet Koç(personel) sisteme giriş yaptı.'),(92,'2017-04-07 19:02:57',1,'Giriş','Evren Ayvaz(müşteri) sisteme giriş yaptı.'),(93,'2017-04-07 19:05:45',1,'Giriş','Evren Ayvaz(müşteri) sisteme giriş yaptı.'),(94,'2017-04-07 19:08:12',1,'Giriş','Evren Ayvaz(müşteri) sisteme giriş yaptı.'),(95,'2017-04-08 10:41:20',1,'Giriş','Evren Ayvaz(müşteri) sisteme giriş yaptı.'),(96,'2017-04-08 14:58:22',1,'Giriş','Evren Ayvaz(müşteri) sisteme giriş yaptı.'),(97,'2017-04-08 15:22:53',NULL,'Giriş','Evren Ayvaz(müşteri) sisteme giriş yaptı.'),(98,'2017-04-08 15:23:37',1,'Alan Adı Takip | Talepte Bulun','Evren Ayvaz, bir talepte bulundu. Talep Türü : İstek / Değişiklik'),(99,'2017-04-08 15:27:36',NULL,'Giriş','Evren Ayvaz(müşteri) sisteme giriş yaptı.'),(100,'2017-04-08 15:50:32',1,'Alan Adı Takip | Talepte Bulun','Evren Ayvaz, (Müşteri) bir talepte bulundu. Talep Türü : İstek / Değişiklik'),(101,'2017-04-08 15:51:30',1,'Alan Adı Takip | Talepte Bulun','Evren Ayvaz, (Müşteri) bir talepte bulundu. Talep Türü : İstek / Değişiklik'),(102,'2017-04-08 15:58:43',NULL,'Giriş','Evren Ayvaz(müşteri) sisteme giriş yaptı.'),(103,'2017-04-08 15:58:57',1,'Giriş','Ahmet Koç(personel) sisteme giriş yaptı.'),(104,'2017-04-08 16:16:50',1,'Müşteri Talepleri','Ahmet Koç, bir talebi sildi. (Müşteri Adı : Evren Ayvaz, Talep Ettiği İş : Alan Adı Takip)'),(105,'2017-04-08 16:34:48',1,'Alan Adı Takip | Talebi Yapılandır','Ahmet Koç, bir talebi yapılandırdı..'),(106,'2017-04-08 16:35:02',1,'Alan Adı Takip | Talebi Yapılandır','Ahmet Koç, bir talebi yapılandırdı..'),(107,'2017-04-08 16:35:57',1,'Alan Adı Takip | Talebi Yapılandır','Ahmet Koç, bir talebi yapılandırdı..'),(108,'2017-04-08 16:36:29',1,'Alan Adı Takip | Talebi Yapılandır','Ahmet Koç, bir talebi yapılandırdı..'),(109,'2017-04-08 16:36:53',1,'Alan Adı Takip | Talebi Yapılandır','Ahmet Koç, bir talebi yapılandırdı..'),(110,'2017-04-08 16:36:57',1,'Alan Adı Takip | Talebi Yapılandır','Ahmet Koç, bir talebi yapılandırdı..'),(111,'2017-04-08 16:38:51',NULL,'Giriş','Evren Ayvaz (Müşteri) sisteme giriş yaptı.'),(112,'2017-04-08 16:39:36',1,'Giriş','Ahmet Koç sisteme giriş yaptı.'),(113,'2017-04-08 16:39:50',NULL,'Giriş','Evren Ayvaz (Müşteri) sisteme giriş yaptı.'),(114,'2017-04-08 16:44:09',NULL,'Giriş','Evren Ayvaz (Müşteri) sisteme giriş yaptı.'),(115,'2017-04-08 16:45:04',1,'Başka İş | Talepte Bulun','Evren Ayvaz, (Müşteri) bir talepte bulundu. Talep Türü : İstek / Değişiklik'),(116,'2017-04-08 16:47:51',1,'Giriş','Ahmet Koç sisteme giriş yaptı.'),(117,'2017-04-08 16:50:30',1,'Başka İş | Talebi Yapılandır','Ahmet Koç, bir talebi yapılandırdı..'),(118,'2017-04-08 16:50:35',NULL,'Giriş','Evren Ayvaz (Müşteri) sisteme giriş yaptı.'),(119,'2017-04-08 16:50:54',1,'Giriş','Ahmet Koç sisteme giriş yaptı.'),(120,'2017-04-08 16:51:21',1,'Müşteri Talepleri','Ahmet Koç, bir talebi sildi. (Müşteri Adı : Evren Ayvaz, Düzenleme Talep Ettiği İş Adı : Başka İş)'),(121,'2017-04-08 16:51:30',2,'Giriş','İlker Şahin sisteme giriş yaptı.'),(122,'2017-04-08 16:53:42',2,'Alan Adı Takip | Talebi Yapılandır','İlker Şahin, bir talebi yapılandırdı..'),(123,'2017-04-08 16:53:46',2,'Alan Adı Takip | Talebi Yapılandır','İlker Şahin, bir talebi yapılandırdı..'),(124,'2017-04-08 16:53:53',2,'Alan Adı Takip | Talebi Yapılandır','İlker Şahin, bir talebi yapılandırdı..'),(125,'2017-04-08 16:53:56',2,'Alan Adı Takip | Talebi Yapılandır','İlker Şahin, bir talebi yapılandırdı..'),(126,'2017-04-08 16:56:10',2,'Alan Adı Takip | Gelişme Ekle','İlker Şahin, bir gelişme ekledi.'),(127,'2017-04-08 16:58:15',2,'Alan Adı Takip | Gelişme Ekle','İlker Şahin, bir gelişme ekledi. (Düzenleme)'),(128,'2017-04-08 16:59:52',1,'Giriş','Ahmet Koç sisteme giriş yaptı.'),(129,'2017-04-08 17:03:35',1,'Personel Ekleme','Ahmet Koç, sisteme bir personel ekledi. (<b>Sabina Çergel</b>)'),(130,'2017-04-08 17:05:10',7,'Giriş','Sabina Çergel sisteme giriş yaptı.'),(131,'2017-04-08 17:08:17',2,'Giriş','İlker Şahin sisteme giriş yaptı.'),(132,'2017-04-08 17:08:24',7,'Giriş','Sabina Çergel sisteme giriş yaptı.'),(133,'2017-04-08 17:11:19',7,'İş Yönetimi > İş/Proje Düzenle','Sabina Çergel, Alan Adı Takip, adlı işi/projeyi düzenledi..'),(134,'2017-04-08 17:11:22',7,'İş Yönetimi > İş/Proje Düzenle','Sabina Çergel, Alan Adı Takip, adlı işi/projeyi düzenledi..'),(135,'2017-04-08 17:12:09',7,'Firma Yönetimi | Ekle','Sabina Çergel, Tester, adlı firma ekledi..'),(136,'2017-04-08 17:12:24',7,'Firma Yönetimi','Sabina Çergel, bir firma sildi. (Tester)'),(137,'2017-04-08 17:13:31',7,'Alan Adı Takip | Talebi Yapılandır','Sabina Çergel, bir talebi yapılandırdı..'),(138,'2017-04-08 17:13:35',7,'Alan Adı Takip | Talebi Yapılandır','Sabina Çergel, bir talebi yapılandırdı..'),(139,'2017-04-08 17:13:47',2,'Giriş','İlker Şahin sisteme giriş yaptı.'),(140,'2017-04-08 17:14:25',2,'Alan Adı Takip | Talebi Yapılandır','İlker Şahin, bir talebi yapılandırdı..'),(141,'2017-04-08 17:14:29',2,'Alan Adı Takip | Talebi Yapılandır','İlker Şahin, bir talebi yapılandırdı..'),(142,'2017-04-08 17:14:33',2,'Alan Adı Takip | Talebi Yapılandır','İlker Şahin, bir talebi yapılandırdı..'),(143,'2017-04-08 17:20:52',2,'Alan Adı Takip | Talebi Yapılandır','İlker Şahin, bir talebi yapılandırdı.. Talep Eden Müşteri : Evren Ayvaz, Talep Türü : İstek / Değişiklik. Cevap : Durumu \'İnceleniyor\' olarak güncelledi..'),(144,'2017-04-08 17:21:18',2,'Alan Adı Takip | Talebi Yapılandır','İlker Şahin, bir talebi yapılandırdı.. Talep Eden Müşteri : <b>Evren Ayvaz</b>, Talep Türü : İstek / Değişiklik. Durumu \'Yapım Aşamasında\' olarak güncelledi..'),(145,'2017-04-08 17:22:48',1,'Giriş','Ahmet Koç sisteme giriş yaptı.'),(146,'2017-04-08 17:23:00',1,'Personel Düzenle','Ahmet Koç, sistemdeki personeli güncelledi. (Barış Akbaş - bkbas)'),(147,'2017-04-08 17:23:32',1,'Personel Düzenle','Ahmet Koç, sistemdeki personeli güncelledi. (Barış Akbaş - bkbas)'),(148,'2017-04-08 17:24:04',4,'Giriş','Barış Akbaş sisteme giriş yaptı.'),(149,'2017-04-08 17:26:21',4,'Başka İş | Gelişme Ekle','Barış Akbaş, bir gelişme ekledi. (Düzenleme)'),(150,'2017-04-08 17:29:09',NULL,'Giriş','Evren Ayvaz (Müşteri) sisteme giriş yaptı.'),(151,'2017-04-08 17:30:30',7,'Giriş','Sabina Çergel sisteme giriş yaptı.'),(152,'2017-04-08 17:30:46',4,'Giriş','Barış Akbaş sisteme giriş yaptı.'),(153,'2017-04-08 17:30:56',1,'Giriş','Ahmet Koç sisteme giriş yaptı.'),(154,'2017-04-08 17:31:05',NULL,'Giriş','Evren Ayvaz (Müşteri) sisteme giriş yaptı.'),(155,'2017-04-09 16:32:28',1,'Giriş','Ahmet Koç sisteme giriş yaptı.'),(156,'2017-04-10 11:25:08',1,'Giriş','Ahmet Koç sisteme giriş yaptı.'),(157,'2017-04-11 17:53:51',1,'Yeni Müşteri Ekle','Yönetici, sisteme bir müşteri ekledi. (<b>İlker Şahin</b>)'),(158,'2017-04-11 17:54:11',1,'Yeni Müşteri Ekle','Yönetici, sisteme bir müşteri ekledi. (<b>İlker Şahin</b>)'),(159,'2017-04-11 17:54:38',1,'Yeni Müşteri Ekle','Yönetici, sisteme bir müşteri ekledi. (<b>İlker Şahin</b>)'),(160,'2017-04-11 17:56:06',1,'İş Yönetimi > İş/Proje Ekle','Yönetici, Deneme, adlı proje ekledi..'),(161,'2017-04-11 17:57:22',1,'Yeni Müşteri Ekle','Yönetici, sisteme bir müşteri ekledi. (<b>İlker Şahin</b>)'),(162,'2017-04-11 17:57:45',1,'Yeni Müşteri Ekle','Yönetici, sisteme bir müşteri ekledi. (<b>İlker Şahin</b>)'),(163,'2017-04-11 18:16:30',1,'Müşteri Düzenle','Yönetici, <b>Evren Ayvaz</b>, adlı müşterinin bilgilerini güncelledi.'),(164,'2017-04-11 18:16:36',1,'Müşteri Düzenle','Yönetici, <b>Evren Ayvaz</b>, adlı müşterinin bilgilerini güncelledi.'),(165,'2017-04-11 18:18:47',1,'Müşteri Listesi','Yönetici, <b>İlker Şahin</b>, adlı müşteriyi sildi.'),(166,'2017-05-28 22:20:23',1,'Giriş','Ahmet Koç, sisteme giriş yaptı.'),(167,'2017-06-19 17:10:54',1,'Giriş','Ahmet Koç, sisteme giriş yaptı.'),(168,'2017-06-19 17:13:23',1,'İş Yönetimi > İş/Proje Düzenle','Ahmet Koç, Başka İş, adlı işi/projeyi düzenledi..'),(169,'2017-08-16 14:36:03',1,'Giriş','Ahmet Koç, sisteme giriş yaptı.'),(170,'2017-11-25 16:14:53',2,'Giriş','İlker Şahin, sisteme giriş yaptı.'),(171,'2017-11-25 16:16:22',1,'Giriş','Ahmet Koç, sisteme giriş yaptı.'),(172,'2017-11-25 16:18:02',4,'Giriş','Barış Akbaş, sisteme giriş yaptı.'),(173,'2017-11-25 16:21:23',1,'Giriş','Ahmet Koç, sisteme giriş yaptı.'),(174,'2017-11-25 16:28:47',NULL,'Giriş','Evren Ayvaz (Müşteri) sisteme giriş yaptı.'),(175,'2017-11-25 16:31:31',1,'Giriş','Ahmet Koç, sisteme giriş yaptı.');

#
# Structure for table "jobs"
#

CREATE TABLE `jobs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `is_adi` varchar(255) DEFAULT '',
  `is_olusturma_tarihi` datetime DEFAULT NULL,
  `is_gorevliler` varchar(20) DEFAULT NULL,
  `is_firma` int(11) DEFAULT NULL,
  `is_durum` int(11) DEFAULT NULL,
  `is_not` text,
  `is_sahibiBilgi` text,
  `is_sahibiNot` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

#
# Data for table "jobs"
#

INSERT INTO `jobs` VALUES (2,'Alan Adı Takip','2017-03-22 17:37:00','3-2-1',1,2,'Deneme Mesajı\r\nVesayre','Ahmet Koç\r\nTelefon Numarası : 053 000 00 00','Vsvs olacak'),(3,'Başka İş','2017-03-22 17:37:00','1-3-2',2,2,'Deneme Mesajı\r\nVesayre','Ahmet Koç\r\nTelefon Numarası : 053 000 00 00','Vsvs olacak'),(6,'Deneme','2017-04-11 17:56:00','2-1',1,1,'Deneme','Deneme','Deneme');

#
# Structure for table "musteri"
#

CREATE TABLE `musteri` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `isim` varchar(50) DEFAULT NULL,
  `kadi` varchar(30) DEFAULT NULL,
  `sifre` varchar(50) DEFAULT NULL,
  `is_id` varchar(255) DEFAULT NULL,
  `avatar` varchar(20) DEFAULT 'avatar2.jpg',
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "musteri"
#

INSERT INTO `musteri` VALUES (1,'Evren Ayvaz','müşteri','müşteri','3-2','avatar2.jpg');

#
# Structure for table "musteri_talep"
#

CREATE TABLE `musteri_talep` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `musteri_id` int(11) DEFAULT NULL,
  `is_id` int(11) DEFAULT NULL,
  `talep_turu` int(3) DEFAULT NULL,
  `talep` text,
  `readly` int(3) DEFAULT '1',
  `tarih` datetime DEFAULT NULL,
  `readly_to` int(3) DEFAULT '0',
  `talep_cevap` text,
  `talep_durumu` int(11) DEFAULT '0',
  `talep_cevaplayan` int(11) DEFAULT NULL,
  `talep_cevap_tarih` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

#
# Data for table "musteri_talep"
#

INSERT INTO `musteri_talep` VALUES (1,1,2,0,'Test',0,'2017-04-08 15:37:00',0,'',4,2,'2017-04-08 16:53:56'),(3,1,2,0,'Testerr',0,'2017-04-08 15:51:30',0,'Talebiniz inceleniyor...',2,2,'2017-04-08 17:21:18');

#
# Structure for table "personel"
#

CREATE TABLE `personel` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `isim` varchar(50) DEFAULT NULL,
  `kadi` varchar(30) DEFAULT NULL,
  `sifre` varchar(50) DEFAULT NULL,
  `yetki` int(11) DEFAULT '1',
  `avatar` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "personel"
#

INSERT INTO `personel` VALUES (1,'Ahmet Koç','admin','123321',0,'avatar2.jpg'),(2,'İlker Şahin','edcsmile','edcsmile',2,'avatar2.jpg'),(3,'Bahadır Akköy','abahad','tester',2,'avatar2.jpg'),(4,'Barış Akbaş','baris','baris',3,'avatar2.jpg'),(7,'Sabina Çergel','sabina','sabina',4,'avatar1.jpg');

#
# Structure for table "security"
#

CREATE TABLE `security` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(255) DEFAULT NULL,
  `host` varchar(255) DEFAULT NULL,
  `browser` varchar(255) DEFAULT NULL,
  `sdate` datetime DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "security"
#


#
# Structure for table "security_count"
#

CREATE TABLE `security_count` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(255) DEFAULT NULL,
  `browser` varchar(255) DEFAULT NULL,
  `http_url` varchar(255) DEFAULT NULL,
  `sdate` datetime DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "security_count"
#


#
# Structure for table "tasks_performed"
#

CREATE TABLE `tasks_performed` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `is_no` varchar(255) DEFAULT NULL,
  `is_durum` int(11) DEFAULT '0',
  `is_tarih` datetime DEFAULT NULL,
  `is_not` text,
  `is_personel` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

#
# Data for table "tasks_performed"
#

INSERT INTO `tasks_performed` VALUES (1,'2',0,'2017-01-01 14:24:00','Tasarım yapılmaya başladı..','2'),(2,'2',1,'2017-01-01 14:24:00','slider düzenlendi..','2'),(3,'3',0,'2017-01-01 14:24:00','slider düzenlendi..','2'),(4,'2',0,'2017-04-06 17:37:00','Denemefafsafas','1'),(5,'2',1,'2017-04-06 17:41:00','Tasarım değişikliği','1'),(6,'2',0,'2017-04-06 17:44:01','Testerasfasfafas','1'),(7,'2',2,'2017-04-07 11:37:14','Deneme','1'),(8,'3',0,'2017-04-07 11:40:02','sosyal ağlar düzenlendi.','1'),(10,'2',0,'2017-04-07 17:38:11','Des','2'),(11,'2',0,'2017-04-08 16:56:10','Footer düzenlemesi...','2'),(12,'2',0,'2017-04-08 16:58:15','Ana tasarım düzenlemesi','2'),(13,'3',0,'2017-04-08 17:26:21','Resimler düzenlendi','4');
