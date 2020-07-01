<?php

return [

    'new_truck' => 'Nouveau camion',
    'trucks_list' => 'Liste des camions',
    'truck_view' => 'Consultation du camion',
    'truck_info' => 'Informations du camion',
    'brand' => 'Marque ',
    'model' => 'Modèle ',
    'functional' => 'Fonctionnel ',
    'purchase_date' => 'Date d\'achat ',
    'license_plate' => 'Plaque d\'immatriculation ',
    'insurance_number' => 'Numéro d\'assurance ',
    'registration_document' => 'Numéro de carte grise ',
    'mileage' => 'Kilométrage',
    'fuel_type' => 'Carburant ',
    'chassis_number' => 'Numéro de châssis ',
    'engine_number' => 'Numéro de moteur ',
    'horsepower' => 'Puissance ',
    'weight_empty' => 'Poids vide ',
    'payload' => 'Charge utile ',
    'general_state' => 'État général ',
    'availability' => 'Disponibilité',
    'available' => 'Disponible',
    'unavailable' => 'Indisponible : utilisé par :franchisee',
    'location' => 'Emplacement',
    'location_name' => 'Nom de l\'emplacement',
    'location_date_start' => 'Date de début à l\'emplacement',
    'location_date_end' => 'Date de fin à l\'emplacement',
    'latest_safety_inspection' => 'Dernier contrôle technique ',
    'truck_deployment' => 'Attribution du camion',
    'available_franchisees' => 'Franchisés disponibles',
    'assign' => 'Assigner',
    'assigned_to' => 'Assigné à :franchisee',
    'remove_truck' => 'Retirer le camion',
    'submit' => 'Ajouter',
    'update_submit' => 'Modifier',

    // Errors
    'brand_error' => 'Marque : format invalide',
    'model_error' => 'Modèle : format invalide',
    'functional_error' => 'Fonctionnel : format invalide',
    'purchase_date_error' => 'Date d\'achat : format invalide',
    'license_plate_error' => 'Plaque d\'immatriculation : format invalide',
    'registration_document_error' => 'Numéro de carte grise : format invalide',
    'insurance_number_error' => 'Numéro d\'assurance : format invalide',
    'fuel_type_error' => 'Type de carburant : format invalide',
    'chassis_number_error' => 'Numéro de châssis : format invalide',
    'engine_number_error' => 'Numéro de moteur : format invalide',
    'horsepower_error' => 'Puissance : format invalide',
    'weight_empty_error' => 'Poids vide : format invalide',
    'payload_error' => 'Charge utile : format invalide',
    'general_state_error' => 'État général : format invalide',
    'location_name_error' => 'Nom de l\'emplacement : format invalide',
    'location_date_start_error' => 'Date de début à l\'emplacement : format invalide',
    'duplicate_entry_error' => 'Camion déjà dans la base',
    'date_timeline_error' => 'La date d\'achat ne peut pas se trouver après la date de mise à l\'emplacement',
    'no_truck_assigned' => 'Vous n\'avez pas de camion attribué, veuillez contacter un responsable Drive\'N\'Cook',
    'breakdown_doesnt_exist' => 'Erreur, la panne n\'existe pas !',
    'inspection_doesnt_exist' => 'Erreur, le contrôle technique n\'existe pas !',
    'wrong_fields_number' => 'Nombre de champs incorrect',
    'franchisee_must_be_validated' => 'L\'utilisateur doit être un franchisé "confirmé" pour avoir un camion.',
    'truck_assigned' => 'Le camion a été assigné',
    'incorrect_id' => 'Erreur, l\'ID est incorrect',
    'license_plate_duplicate' => 'Cette plaque d\'immatriculation est déjà dans la base de données',
    'registration_document_duplicate' => 'Cette carte grise est déjà dans la base de données',
    'engine_number_duplicate' => 'Ce numéro de moteur est déjà dans la base de données',
    'chassis_number_duplicate' => 'Ce numéro de châssis est déjà dans la base de données',

    'new_truck_success' => 'Nouveau camion ajouté',
    'new_truck_error' => 'Erreur lors de l\'ajout du camion',
    'confirm_delete' => 'Voulez-vous vraiment supprimer ce camion ? Toutes les données associées seront supprimées.',
    'delete_success' => 'Le camion a été supprimé',
    'breakdown_updated' => 'La panne a été modifiée',
    'breakdown_created' => 'La panne a été créée',
    'inspection_updated' => 'Le contrôle technique a été modifié',
    'inspection_created' => 'Le contrôle technique a été créé',

    // Tooltips
    'set_brand' => 'Entrez la marque',
    'set_model' => 'Entrez le modèle',
    'set_license_plate' => 'Entrez l\'immatriculation',
    'set_registration_document' => 'Entrez le numéro de carte grise',
    'set_insurance_number' => 'Entrez le numéro d\'assurance',
    'set_chassis_number' => 'Entrez le numéro du chassis',
    'set_engine_number' => 'Entrez le numéro du moteur',
    'set_horsepower' => 'Entrez la puissance (en chevaux)',
    'set_weight_empty' => 'Entre le poids vide',
    'set_payload' => 'Entrez la charge utile',
    'set_general_state' => 'Entrez l\'état général',
    'set_location_name' => 'Entrez le nom de l\'emplacement',

    // Breakdown
    'breakdowns' => 'Pannes',
    'add_breakdown' => 'Ajouter une panne',
    'breakdown_date' => 'Date',
    'breakdown_cost' => 'Coût',
    'breakdown_status' => 'Statut',
    'breakdown_type' => 'Type',
    'breakdown_description' => 'Description',
    'breakdown_type_Batterie' => 'Batterie',
    'breakdown_type_Moteur' => 'Moteur',
    'breakdown_type_Alternateur' => 'Alternateur',
    'breakdown_type_Freins' => 'Freins',
    'breakdown_type_Refroidissement' => 'Refroidissement',
    'breakdown_type_Autre' => 'Autre',
    'breakdown_status_Signalée' => 'Signalée',
    'breakdown_status_Réparation en cours' => 'Réparation en cours',
    'breakdown_status_Réparée' => 'Réparée',
    'confirm_delete_breakdown' => 'Voulez-vous vraiment supprimer cette panne ?',
    'breakdown_deleted' => 'La panne a été supprimée',
    'new_breakdown' => 'Nouvelle panne',
    'breakdown_update' => 'Mise à jour d\'une panne',

    // Safety inspection
    'safety_inspections' => 'Contrôles techniques',
    'add_safety_inspection' => 'Ajouter un contrôle technique',
    'safety_inspection_date' => 'Date',
    'replaced_parts' => 'Pièces remplacées',
    'drained_fluids' => 'Liquides drainés',
    'truck_age' => 'Âge',
    'truck_age_years' => ':years ans',
    'confirm_delete_inspection' => 'Voulez-vous vraiment supprimer cet contrôle technique ?',
    'new_inspection' => 'Nouveau contrôle technique',
    'inspection_update' => 'Mise à jour d\'un contrôle technique',
    'inspection_deleted' => 'Le contrôle technique a été supprimé',

    // Dropdown menu
    'select_menu_off' => 'Choisissez...',
    'fuel_type_b7' => 'B7',
    'fuel_type_b10' => 'B10',
    'fuel_type_xtl' => 'XTL',
    'fuel_type_e10' => 'E10',
    'fuel_type_e5' => 'E5',
    'fuel_type_e85' => 'E85',
    'fuel_type_lng' => 'LNG',
    'fuel_type_h2' => 'H2',
    'fuel_type_cng' => 'CNG',
    'fuel_type_lpg' => 'LPG',
    'fuel_type_electric' => 'Électrique',

    'yes' => 'Oui',
    'no' => 'Non',
    'unknown' => 'Inconnu',
    'ajax_error' => 'Une erreur est survenue lors de la suppression, veuillez rafraîchir la page',
    'not_specified_m' => 'Non renseigné',
    'not_specified_f' => 'Non renseignée',
];