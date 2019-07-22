#
# Table structure for table 'tx_mymap_domain_model_location'
#
CREATE TABLE tx_mymap_domain_model_location (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	name varchar(255) DEFAULT '' NOT NULL,
	additionalname varchar(255) DEFAULT '' NOT NULL,
	additionalcontact varchar(255) DEFAULT '' NOT NULL,
	address varchar(255) DEFAULT '' NOT NULL,
	additionaladdress varchar(255) DEFAULT '' NOT NULL,
	zipcode varchar(255) DEFAULT '' NOT NULL,
	city varchar(255) DEFAULT '' NOT NULL,
	country varchar(255) DEFAULT '' NOT NULL,
	phone varchar(255) DEFAULT '' NOT NULL,
	fax varchar(255) DEFAULT '' NOT NULL,
	mobile varchar(255) DEFAULT '' NOT NULL,
	email varchar(255) DEFAULT '' NOT NULL,
	www varchar(255) DEFAULT '' NOT NULL,
	description text NOT NULL,
	kwp decimal(5,1) DEFAULT '0.0' NOT NULL,
	startup int(11) unsigned DEFAULT '0' NOT NULL,
	lat varchar(255) DEFAULT '' NOT NULL,
	lon varchar(255) DEFAULT '' NOT NULL,
	geocode int(11) DEFAULT '1' NOT NULL,
	icon varchar(255) DEFAULT '' NOT NULL,
	image varchar(255) DEFAULT '' NOT NULL,
	media varchar(255) DEFAULT '' NOT NULL,

	category varchar(255) DEFAULT '' NOT NULL,

#	categories int(11) unsigned DEFAULT '0' NOT NULL,

	images varchar(255) DEFAULT '' NOT NULL,
	files varchar(255) DEFAULT '' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid),

);

#
# Table structure for table 'tx_mymap_domain_model_category'
#
CREATE TABLE tx_mymap_domain_model_category (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	name varchar(255) DEFAULT '' NOT NULL,
	description varchar(255) DEFAULT '' NOT NULL,
	parent int(11) DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid),

);

