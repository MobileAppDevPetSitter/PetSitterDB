use crittersitter;

DROP TABLE IF EXISTS user;
create table user (
    user_id int not null auto_increment,
    email varchar(129) not null,
    password varchar(50) not null,
    salt varchar(30) not null,
    verification_code varchar(5) not null,
    status varchar(10) not null,
    primary key(user_id)
) character set 'utf8';

DROP TABLE IF EXISTS owner;
create table owner (
    owner_id int not null,
    user_id int not null,
    pet_id int not null,
    primary key(pet_id)
) character set 'utf8';

DROP TABLE IF EXISTS pet;
create table pet (
    pet_id int not null auto_increment,
    name varchar(128) not null,
    bio varchar(512),
    bathroom_instructions varchar(512), 
    exercise_instructions varchar(512),
    emergency_contact varchar(512),
    other varchar(512),
    veterinarian_info varchar(512),
    medicine varchar(512),
    food varchar(512),
    hasImage TINYINT(1) DEFAULT 0,
    primary key(pet_id)
) character set 'utf8';

DROP TABLE IF EXISTS pet_sitting;
create table pet_sitting (
    pet_sitting_id int not null auto_increment,
    sitter_id int not null,
    pet_id int not null,
    status varchar(10) not null,
    start_date date not null,
    end_date date not null, 
    primary key(pet_sitting_id,sitter_id)
) character set 'utf8';

DROP TABLE IF EXISTS activity;
create table activity (
    activity_id int not null auto_increment,
    pet_sitting_id int not null,
    title varchar(128) not null,
    description varchar(255) not null,
    status varchar(10) not null,
    completion_date date not null DEFAULT '2015-12-15',
    hasImage TINYINT(1) DEFAULT 0,
    primary key(activity_id)
) character set 'utf8';
