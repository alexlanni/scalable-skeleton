create table mydatabase.log
(
    log_id   int auto_increment
        primary key,
    log_date datetime not null,
    log_data longtext null
) ENGINE=InnoDB;
