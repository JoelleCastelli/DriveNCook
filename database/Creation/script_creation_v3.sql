create table dish
(
    id          int auto_increment
        primary key,
    name        varchar(30)                                                           null,
    category    enum ('hot_dish', 'cold_dish', 'salty_snack', 'sweet_snack', 'drink') null,
    description varchar(255)                                                          null,
    diet        enum ('none', 'vegetarian', 'vegan') default 'none'                   null,
    created_at  datetime                                                              null,
    updated_at  datetime                                                              null
);

create table location
(
    id         int auto_increment
        primary key,
    name       varchar(30)  null,
    address    varchar(100) null,
    latitude   double       null,
    longitude  double       null,
    city       varchar(50)  null,
    postcode   varchar(7)   null,
    country    varchar(50)  null,
    updated_at timestamp    null
);

create table pseudo
(
    id         int auto_increment
        primary key,
    name       varchar(20) null,
    updated_at timestamp   null
);

create table user
(
    id              int auto_increment
        primary key,
    email           varchar(100)                                                                          null,
    firstname       varchar(30)                                                                           null,
    lastname        varchar(30)                                                                           null,
    role            enum ('Administrateur', 'Corporate', 'Client', 'Franchisé') default 'Franchisé'       null,
    password        varchar(100)                                                                          null,
    remember_token  varchar(100)                                                                          null,
    birthdate       date                                                                                  null,
    pseudo_id       int                                                                                   null,
    telephone       varchar(20)                                                                           null,
    driving_licence varchar(15)                                                                           null,
    social_security varchar(15)                                                                           null,
    loyalty_point   int                                                         default 0                 null,
    password_token  varchar(255)                                                                          null,
    opt_in          tinyint(1)                                                  default 1                 null,
    created_at      timestamp                                                   default CURRENT_TIMESTAMP not null,
    updated_at      datetime                                                                              null,
    constraint user_api_token_uindex
        unique (remember_token),
    constraint user_pseudo_id_fk
        foreign key (pseudo_id) references pseudo (id)
);

create table event
(
    id          int auto_increment
        primary key,
    type        enum ('news', 'public', 'private') not null,
    date_start  date                               not null,
    date_end    date                               not null,
    title       varchar(100)                       not null,
    description text                               not null,
    location_id int                                null,
    user_id     int                                not null,
    updated_at  timestamp                          null,
    constraint event_location_id_fk
        foreign key (location_id) references location (id),
    constraint event_user_id_fk
        foreign key (user_id) references user (id)
);

create table event_invited
(
    event_id int not null,
    user_id  int not null,
    primary key (event_id, user_id),
    constraint event_invited_event_id_fk
        foreign key (event_id) references event (id),
    constraint event_invited_user_id_fk
        foreign key (user_id) references user (id)
);

create table fidelity_step
(
    id        int auto_increment
        primary key,
    step      int not null,
    reduction int not null,
    user_id   int not null,
    constraint fidelity_step_user_id_fk
        foreign key (user_id) references user (id)
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

create table franchisee_stock
(
    user_id    int                  not null,
    dish_id    int                  not null,
    quantity   int                  null,
    unit_price float                null,
    menu       tinyint(1) default 0 not null,
    updated_at timestamp            null,
    primary key (user_id, dish_id),
    constraint stock_dish_id_fk
        foreign key (dish_id) references dish (id),
    constraint stock_user_id_fk
        foreign key (user_id) references user (id)
);

create table sale
(
    id               int auto_increment
        primary key,
    payment_method   enum ('Carte bancaire', 'Liquide')      null,
    online_order     tinyint(1)                              null,
    date             date                                    null,
    user_franchised  int                                     not null,
    user_client      int                                     null,
    updated_at       timestamp                               null,
    status           enum ('pending', 'done') default 'done' null,
    discount_amount  int                      default 0      null,
    points_to_return int                      default 0      null,
    payment_id       varchar(200)                            null,
    constraint sale_user_id_fk
        foreign key (user_franchised) references user (id),
    constraint sale_user_id_fk_2
        foreign key (user_client) references user (id)
);

create table sold_dish
(
    dish_id    int       not null,
    sale_id    int       not null,
    unit_price float     null,
    quantity   int       null,
    updated_at timestamp null,
    primary key (dish_id, sale_id),
    constraint sold_dish_dish_id_fk
        foreign key (dish_id) references dish (id),
    constraint sold_dish_sale_id_fk
        foreign key (sale_id) references sale (id)
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
    created_at            datetime                                                                             null,
    updated_at            datetime                                                                             null,
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
    updated_at  timestamp                                                                        null,
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
    updated_at     timestamp    null,
    constraint safety_inspection_truck_id_fk
        foreign key (truck_id) references truck (id)
);

create table warehouse
(
    id          int auto_increment
        primary key,
    name        varchar(30) null,
    location_id int         null,
    created_at  datetime    null,
    updated_at  datetime    null,
    constraint warehouse_location_id_fk
        foreign key (location_id) references location (id)
);

create table purchase_order
(
    id           int auto_increment
        primary key,
    user_id      int                                                                   null,
    warehouse_id int                                                                   not null,
    status       enum ('created', 'in_progress', 'sent', 'received') default 'created' null,
    date         date                                                                  null,
    updated_at   timestamp                                                             null,
    payment_id   varchar(200)                                                          null,
    constraint purchase_order_user_id_fk
        foreign key (user_id) references user (id),
    constraint purchase_order_warehouse_id_fk
        foreign key (warehouse_id) references warehouse (id)
);

create table invoice
(
    id                int auto_increment
        primary key,
    amount            float                                                 null,
    discount_amount   int                                                   null,
    date_emitted      date                                                  null,
    date_paid         date                                                  null,
    reference         varchar(15)                                           null,
    monthly_fee       tinyint(1)                                            null,
    initial_fee       tinyint(1)                                            null,
    franchisee_order  int                                                   null,
    client_order      int                                                   null,
    status            enum ('to_pay', 'paid', 'cancelled') default 'to_pay' null,
    user_id           int                                                   not null,
    purchase_order_id int                                                   null,
    sale_id           int                                                   null,
    created_at        timestamp                                             null,
    updated_at        timestamp                                             null,
    constraint invoice_purchase_order_id_fk
        foreign key (purchase_order_id) references purchase_order (id),
    constraint invoice_sale_id_fk
        foreign key (sale_id) references sale (id),
    constraint invoice_user_id_fk
        foreign key (user_id) references user (id)
);

create table purchased_dish
(
    purchase_order_id int           not null,
    dish_id           int           not null,
    quantity          int           null,
    unit_price        float         null,
    updated_at        timestamp     null,
    quantity_sent     int default 0 null,
    primary key (purchase_order_id, dish_id),
    constraint purchased_dish_dish_id_fk
        foreign key (dish_id) references dish (id),
    constraint purchased_dish_purchase_order_id_fk
        foreign key (purchase_order_id) references purchase_order (id)
);

create table warehouse_stock
(
    warehouse_id    int       not null,
    dish_id         int       not null,
    quantity        int       null,
    warehouse_price float     null,
    updated_at      timestamp null,
    primary key (warehouse_id, dish_id),
    constraint warehouse_stock_dish_id_fk
        foreign key (dish_id) references dish (id),
    constraint warehouse_stock_warehouse_id_fk
        foreign key (warehouse_id) references warehouse (id)
);


