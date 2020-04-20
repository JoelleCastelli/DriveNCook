create table country
(
    id   int auto_increment
        primary key,
    name varchar(15) null
);

create table city
(
    id         int auto_increment
        primary key,
    name       varchar(25) null,
    postcode   varchar(6)  null,
    country_id int         not null,
    constraint city_country_id_fk
        foreign key (country_id) references country (id)
);

create table location
(
    id      int auto_increment
        primary key,
    name    varchar(30)  null,
    address varchar(100) null,
    city_id int          not null,
    constraint location_city_id_fk
        foreign key (city_id) references city (id)
);

create table pseudo
(
    id   int auto_increment
        primary key,
    name varchar(20) null
);

create table user
(
    id              int auto_increment
        primary key,
    lastname        varchar(30)                                                 null,
    firstname       varchar(30)                                                 null,
    birthdate       date                                                        null,
    pseudo_id       int                                                         null,
    email           varchar(100)                                                null,
    telephone       varchar(15)                                                 null,
    role            enum ('Administrateur', 'Corporate', 'Client', 'Franchisé') null,
    driving_licence varchar(15)                                                 null,
    social_security int                                                         null,
    password        varchar(100)                                                null,
    new_pwd_code    varchar(100)                                                null,
    created_at      datetime                                                    null,
    updated_at      datetime                                                    null,
    constraint user_pseudo_id_fk
        foreign key (pseudo_id) references pseudo (id)
);

create table franchise_obligation
(
    id                   int auto_increment
        primary key,
    date_updated         date  null,
    entrance_fee         float null,
    revenue_percentage   float null,
    warehouse_percentage float null,
    billing_day          int   null,
    user_id              int   null,
    constraint franchise_obligation_user_id_fk
        foreign key (user_id) references user (id)
);

create table monthly_licence_fee
(
    id           int auto_increment
        primary key,
    amount       float                                null,
    date_emitted date                                 null,
    date_paid    date                                 null,
    status       enum ('A payer', 'Payée', 'Annulée') null,
    user_id      int                                  not null,
    constraint monthly_licence_fee_user_id_fk
        foreign key (user_id) references user (id)
);

create table purchase_order
(
    id      int auto_increment
        primary key,
    user_id int  null,
    date    date null,
    constraint purchase_order_user_id_fk
        foreign key (user_id) references user (id)
);

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
);

create table truck
(
    id                    int auto_increment
        primary key,
    brand                 varchar(30)                                                                          null,
    model                 varchar(30)                                                                          null,
    functional            tinyint(1)                                                                           null,
    purchase_date         date                                                                                 null,
    license_plate         varchar(10)                                                                          null,
    registration_document varchar(15)                                                                          null,
    insurance_number      varchar(20)                                                                          null,
    fuel_type             enum ('B7', 'B10', 'XTL', 'E10', 'E5', 'E85', 'LNG', 'H2', 'CNG', 'LPG', 'Electric') null,
    chassis_number        varchar(20)                                                                          null,
    engine_number         varchar(20)                                                                          null,
    horsepower            int                                                                                  null,
    weight_empty          int                                                                                  null,
    payload               int                                                                                  null,
    general_state         varchar(255)                                                                         null,
    user_id               int                                                                                  null,
    location_id           int                                                                                  not null,
    location_date_start   date                                                                                 null,
    location_date_end     date                                                                                 null,
    constraint truck_location_id_fk
        foreign key (location_id) references location (id),
    constraint truck_user_id_fk
        foreign key (user_id) references user (id)
);

create table breakdown
(
    id          int auto_increment
        primary key,
    type        enum ('Batterie', 'Moteur', 'Alternateur', 'Freins', 'Refroidissement', 'Autre') null,
    description varchar(255)                                                                     null,
    cost        float                                                                            null,
    date        date                                                                             null,
    status      enum ('Signalée', 'Réparation en cours', 'Réparée')                              null,
    truck_id    int                                                                              not null,
    constraint breakdown_truck_id_fk
        foreign key (truck_id) references truck (id)
);

create table safety_inspection
(
    id             int auto_increment
        primary key,
    date           date         null,
    truck_age      int          null,
    truck_mileage  int          null,
    replaced_parts varchar(150) null,
    drained_fluids varchar(150) null,
    truck_id       int          not null,
    constraint safety_inspection_truck_id_fk
        foreign key (truck_id) references truck (id)
);

create table warehouse
(
    id      int auto_increment
        primary key,
    name    varchar(30)  null,
    address varchar(100) null,
    city_id int          not null,
    constraint warehouse_city_id_fk
        foreign key (city_id) references city (id)
);

create table dish
(
    id              int auto_increment
        primary key,
    name            varchar(30)                                                               null,
    category        enum ('Plat chaud', 'Plat froid', 'Snack salé', 'Snack sucré', 'Boisson') null,
    warehouse_price float                                                                     null,
    quantity        int                                                                       null,
    warehouse_id    int                                                                       not null,
    constraint dish_warehouse_id_fk
        foreign key (warehouse_id) references warehouse (id)
);

create table purchased_dish
(
    purchase_order_id int not null,
    dish_id           int not null,
    quantity          int null,
    primary key (purchase_order_id, dish_id),
    constraint purchased_dish_dish_id_fk
        foreign key (dish_id) references dish (id),
    constraint purchased_dish_purchase_order_id_fk
        foreign key (purchase_order_id) references purchase_order (id)
);

create table sold_dish
(
    dish_id  int not null,
    sale_id  int not null,
    quantity int null,
    primary key (dish_id, sale_id),
    constraint sold_dish_dish_id_fk
        foreign key (dish_id) references dish (id),
    constraint sold_dish_sale_id_fk
        foreign key (sale_id) references sale (id)
);

create table stock
(
    user_id    int   not null,
    dish_id    int   not null,
    quantity   int   null,
    unit_price float null,
    primary key (user_id, dish_id),
    constraint stock_dish_id_fk
        foreign key (dish_id) references dish (id),
    constraint stock_user_id_fk
        foreign key (user_id) references user (id)
);