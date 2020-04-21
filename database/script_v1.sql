create table country
(
    id    int auto_increment
        primary key,
     name varchar(15) null
)
    engine = InnoDB;

create table city
(
    id       int auto_increment
        primary key,
     name    varchar(25) null,
    postcode varchar(6)  null,
    country  int         not null,
    constraint city_country_id_fk
        foreign key (country) references country (id)
)
    engine = InnoDB;

create table location
(
    id       int auto_increment
        primary key,
     name    varchar(30)  null,
     address varchar(100) null,
     city    int          not null,
    constraint location_city_id_fk
        foreign key ( city) references city (id)
)
    engine = InnoDB;

create table pseudo
(
    id    int auto_increment
        primary key,
     name varchar(20) null
)
    engine = InnoDB;

create table user
(
    id           int auto_increment
        primary key,
     name        varchar(30)                                                 null,
    first name   varchar(30)                                                 null,
    pseudo       int                                                         null,
    email        varchar(100)                                                null,
    role         enum ('Administrateur', 'Corporate', 'Client', 'Franchisé') null,
    password     varchar(100)                                                null,
    new_pwd_code varchar(100)                                                null,
    constraint user_pseudo_id_fk
        foreign key (pseudo) references pseudo (id)
)
    engine = InnoDB;

create table franchise_obligation
(
    id                   int auto_increment
        primary key,
     date_updated        date  null,
    entrance_fee         float null,
    revenue_percentage   float null,
    warehouse_percentage float null,
    user                 int   not null,
    constraint franchise_obligation_user_id_fk
        foreign key (user) references user (id)
)
    engine = InnoDB;

create table monthly_licence_fee
(
    id           int auto_increment
        primary key,
     amount      float                                null,
    date_emitted date                                 null,
    date_paid    date                                 null,
    status       enum ('A payer', 'Payée', 'Annulée') null,
    user         int                                  not null,
    constraint monthly_licence_fee_user_id_fk
        foreign key (user) references user (id)
)
    engine = InnoDB;

create table purchase_order
(
    user int  not null
        primary key,
    date date null,
    constraint purchase_order_user_id_fk
        foreign key (user) references user (id)
)
    engine = InnoDB;

create table sale
(
    id              int auto_increment
        primary key,
    payment_method  enum ('Carte bancaire', 'Liquide') null,
    online_order    tinyint(1)                         null,
    date            date                               null,
    user_franchised int                                not null,
    user_client     int                                null,
    constraint sale_user_id_fk
        foreign key (user_franchised) references user (id),
    constraint sale_user_id_fk_2
        foreign key (user_client) references user (id)
)
    engine = InnoDB;

create table truck
(
    id                     int auto_increment
        primary key,
     brand                 varchar(30)                                                                            null,
     model                 varchar(30)                                                                            null,
    functional             tinyint(1)                                                                             null,
     purchase_date         date                                                                                   null,
     license_plate         varchar(10)                                                                            null,
    registration_document  varchar(15)                                                                            null,
    insurance_number       varchar(20)                                                                            null,
     fuel_type             enum ('B7', 'B10', 'XTL', 'E10', 'E5', 'E85', 'LNG', 'H2', 'CNG', 'LPG', 'Electrique') null,
     chassis_number        int                                                                                    null,
    engine_number          int                                                                                    null,
     horsepower            int                                                                                    null,
     weight_empty          int                                                                                    null,
     payload               int                                                                                    null,
    general_state          varchar(255)                                                                           null,
    user                   int                                                                                    null,
    location               int                                                                                    not null,
    location_date_start    date                                                                                   null,
     location_date_end     date                                                                                   null,
    constraint truck_location_id_fk
        foreign key (location) references location (id),
    constraint truck_user_id_fk
        foreign key (user) references user (id)
)
    engine = InnoDB;

create table breakdown
(
    id          int auto_increment
        primary key,
     type       enum ('Batterie', 'Moteur', 'Alternateur', 'Freins', 'Refroidissement', 'Autre') null,
    description varchar(255)                                                                     null,
    cost        float                                                                            null,
    date        date                                                                             null,
    status      enum ('Signalée', 'Réparation en cours', 'Réparée')                              null,
    truck       int                                                                              not null,
    constraint breakdown_truck_id_fk
        foreign key (truck) references truck (id)
)
    engine = InnoDB;

create table safety_inspection
(
    id             int auto_increment
        primary key,
    date           date         null,
    truck_age      int          null,
    truck_mileage  int          null,
    replaced_parts varchar(150) null,
    drained_fluids varchar(150) null,
    truck          int          not null,
    constraint safety_inspection_truck_id_fk
        foreign key (truck) references truck (id)
)
    engine = InnoDB;

create table warehouse
(
    id       int auto_increment
        primary key,
     name    varchar(30)  null,
     address varchar(100) null,
     city    int          not null,
    constraint warehouse_city_id_fk
        foreign key ( city) references city (id)
)
    engine = InnoDB;

create table dish
(
    id               int auto_increment
        primary key,
     name            varchar(30)                                                               null,
     category        enum ('Plat chaud', 'Plat froid', 'Snack salé', 'Snack sucré', 'Boisson') null,
     warehouse_price float                                                                     null,
    quantity         int                                                                       null,
    warehouse        int                                                                       not null,
    constraint dish_warehouse_id_fk
        foreign key (warehouse) references warehouse (id)
)
    engine = InnoDB;

create table purchased_dish
(
    purchase_order int not null,
    dish           int not null,
    quantity       int null,
    primary key (purchase_order, dish),
    constraint purchased_dish_dish_id_fk
        foreign key (dish) references dish (id),
    constraint purchased_dish_purchase_order_user_fk
        foreign key (purchase_order) references purchase_order (user)
)
    engine = InnoDB;

create table sold_dish
(
    dish     int not null,
    sale     int not null,
    quantity int null,
    primary key (dish, sale),
    constraint sold_dish_dish_id_fk
        foreign key (dish) references dish (id),
    constraint sold_dish_sale_id_fk
        foreign key (sale) references sale (id)
)
    engine = InnoDB;

create table stock
(
    user       int   not null,
    dish       int   not null,
    quantity   int   null,
    unit_price float null,
    primary key (user, dish),
    constraint stock_dish_id_fk
        foreign key (dish) references dish (id),
    constraint stock_user_id_fk
        foreign key (user) references user (id)
)
    engine = InnoDB;


