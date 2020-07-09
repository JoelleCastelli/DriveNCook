//
// Created by nou on 31/03/2020.
// Updated by Antoine on 06/04/2020.
//

#include "gtkFunctions.h"

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

void on_subscribeButton_clicked() {
    const char *name = gtk_entry_get_text(widgets->nameEntry);
    const char *firstName = gtk_entry_get_text(widgets->firstNameEntry);
    const char *email = gtk_entry_get_text(widgets->emailEntry);

    char *errorMessage = checkInputs(name, firstName, email);

    if (strlen(errorMessage) > 0) {
        errorStatus(errorMessage, widgets->statusLabel);
        return;
    }
    status("En cours de traitement...");

    time_t seconds = time(NULL);

    char filename[50];
    sprintf(filename, "%ld", seconds);

    char qrContent[300];
    sprintf(qrContent, "NAME=%s\nFIRSTNAME=%s\nEMAIL=%s\n", name, firstName, email);
    assert(strlen(qrContent) < 300);

    createQR(qrContent, filename);

    successStatus("code QR créé !", widgets->statusLabel);

    strcat(filename, ".png");

    status("Envoie du fichier..");
    int returnCode = sendFile(filename);
    if (returnCode == 0) {
        successStatus("Fichier envoyé ! Consulter le fichier log pour plus d'informations...", widgets->statusLabel);
    } else {
        errorStatus(
                "Une erreur s'est produite lors de l'envoie ! Consulter le fichier log pour plus d'informations...",
                widgets->statusLabel);
    }
}

void on_configureButton_clicked() {
    gtk_widget_set_sensitive(widgets->window, FALSE);
    gtk_window_set_accept_focus(GTK_WINDOW(widgets->window), FALSE);
    gtk_widget_set_visible(GTK_WIDGET(widgets->passRequestDialog), TRUE);
}

void on_okButton_clicked() {
    checkCredentials();
}

void on_cancel_loginButton_clicked() {
    gtk_widget_set_visible(GTK_WIDGET(widgets->passRequestDialog), FALSE);
    gtk_entry_set_text(widgets->userPwdEntry, "");
    gtk_label_set_text(widgets->passRequestErr, "");
    gtk_widget_set_sensitive(widgets->window, TRUE);
    gtk_window_set_accept_focus(GTK_WINDOW(widgets->window), TRUE);
}

void on_saveButton_clicked() {
    char *newConf;
    char anteIP[9] = "IPDEST= ";
    char anteUser[12] = "\nSFTPUSER= ";
    char antePwd[16] = "\nSFTPPASSWORD= ";
    const char *ip = gtk_entry_get_text(widgets->serverAddrEntry);
    const char *user = gtk_entry_get_text(widgets->serverUsrEntry);
    const char *pwd = gtk_entry_get_text(widgets->serverPwdEntry);

    gtk_widget_set_sensitive(GTK_WIDGET(widgets->serverAddrEntry), FALSE);
    gtk_widget_set_sensitive(GTK_WIDGET(widgets->serverUsrEntry), FALSE);
    gtk_widget_set_sensitive(GTK_WIDGET(widgets->serverPwdEntry), FALSE);

    newConf = malloc(
            sizeof(char) *
            (strlen(anteIP) + strlen(anteUser) + strlen(antePwd) +
             strlen(ip) + strlen(user) + strlen(pwd)
             + 2) // last '\n' + '\0'
    );

    strcpy(newConf, anteIP);
    strcat(newConf, ip);

    strcat(newConf, anteUser);
    strcat(newConf, user);

    strcat(newConf, antePwd);
    strcat(newConf, pwd);
    strcat(newConf, "\n");

    int returnCode = encode(configFilePath, newConf);
    if (returnCode) {
        errorStatus("Error while updating conf !!!", widgets->statusLabel);
        return;
    }

    free(newConf);

    processConfigFile(widgets->serverConfStatus);
    gtk_entry_set_text(widgets->serverAddrEntry, userArgs.ipDest);
    gtk_entry_set_text(widgets->serverUsrEntry, userArgs.sftpUser);
    gtk_entry_set_text(widgets->serverPwdEntry, userArgs.sftpPwd);

    gtk_widget_set_sensitive(GTK_WIDGET(widgets->editBtn), TRUE);
    gtk_widget_set_sensitive(GTK_WIDGET(widgets->saveBtn), FALSE);
}

void on_editButton_clicked() {
    gtk_widget_set_sensitive(GTK_WIDGET(widgets->serverAddrEntry), TRUE);
    gtk_widget_set_sensitive(GTK_WIDGET(widgets->serverUsrEntry), TRUE);
    gtk_widget_set_sensitive(GTK_WIDGET(widgets->serverPwdEntry), TRUE);
    gtk_widget_set_sensitive(GTK_WIDGET(widgets->editBtn), FALSE);
    gtk_widget_set_sensitive(GTK_WIDGET(widgets->saveBtn), TRUE);
}

void on_closeButton_clicked() {
    gtk_widget_set_visible(GTK_WIDGET(widgets->serverConfDialog), FALSE);
    gtk_widget_set_sensitive(GTK_WIDGET(widgets->serverAddrEntry), FALSE);
    gtk_widget_set_sensitive(GTK_WIDGET(widgets->serverUsrEntry), FALSE);
    gtk_widget_set_sensitive(GTK_WIDGET(widgets->serverPwdEntry), FALSE);
    gtk_widget_set_sensitive(GTK_WIDGET(widgets->editBtn), TRUE);
    gtk_widget_set_sensitive(GTK_WIDGET(widgets->saveBtn), FALSE);
    gtk_widget_set_sensitive(widgets->window, TRUE);
    gtk_window_set_accept_focus(GTK_WINDOW(widgets->window), TRUE);
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

void startGTK(int *argc, char ***argv) {
    gtk_init(argc, argv);
    builder = gtk_builder_new_from_file(gladeFile);
    connectWidgets();

    connectSignals();
    g_object_unref(builder);

    gtk_widget_show_all(widgets->window);
    status("En attente d'entrée utilisateur...");
    processKeyFile(widgets->statusLabel); // on remplit les matrices d'encodage et décodage
    gtk_main();

    g_slice_free(AppWidgets, widgets);
}

void connectWidgets() {
    widgets = g_slice_new(AppWidgets);

    //main window
    widgets->window = GTK_WIDGET(gtk_builder_get_object(builder, "window"));
    widgets->subscribeButton = GTK_BUTTON(gtk_builder_get_object(builder, "subscribeButton"));
    widgets->nameEntry = GTK_ENTRY(gtk_builder_get_object(builder, "nameEntry"));
    widgets->firstNameEntry = GTK_ENTRY(gtk_builder_get_object(builder, "firstNameEntry"));
    widgets->emailEntry = GTK_ENTRY(gtk_builder_get_object(builder, "emailEntry"));
    widgets->statusLabel = GTK_LABEL(gtk_builder_get_object(builder, "statusLabel"));

    //server configuration dialog
    widgets->serverConfDialog = GTK_DIALOG(gtk_builder_get_object(builder, "serverConfDialog"));
    widgets->closeBtn = GTK_BUTTON(gtk_builder_get_object(builder, "closeBtn"));
    widgets->editBtn = GTK_BUTTON(gtk_builder_get_object(builder, "editBtn"));
    widgets->saveBtn = GTK_BUTTON(gtk_builder_get_object(builder, "saveBtn"));
    widgets->serverAddrEntry = GTK_ENTRY(gtk_builder_get_object(builder, "serverAddrEntry"));
    widgets->serverUsrEntry = GTK_ENTRY(gtk_builder_get_object(builder, "serverUsrEntry"));
    widgets->serverPwdEntry = GTK_ENTRY(gtk_builder_get_object(builder, "serverPwdEntry"));
    widgets->serverConfStatus = GTK_LABEL(gtk_builder_get_object(builder, "serverConfStatus"));

    //security dialog
    widgets->passRequestDialog = GTK_DIALOG(gtk_builder_get_object(builder, "passRequestDialog"));
    widgets->okBtn = GTK_BUTTON(gtk_builder_get_object(builder, "okBtn"));
    widgets->cancelBtn = GTK_BUTTON(gtk_builder_get_object(builder, "cancelBtn"));
    widgets->userLoginEntry = GTK_ENTRY(gtk_builder_get_object(builder, "userLoginEntry"));
    widgets->userPwdEntry = GTK_ENTRY(gtk_builder_get_object(builder, "userPwdEntry"));
    widgets->passRequestErr = GTK_LABEL(gtk_builder_get_object(builder, "passRequestErr"));
}

void connectSignals() {
    //main window
    g_signal_connect(widgets->window, "destroy", G_CALLBACK(onDestroy), NULL);
    gtk_builder_add_callback_symbol(builder, "on_subscribeButton_clicked", G_CALLBACK(on_subscribeButton_clicked));
    gtk_builder_add_callback_symbol(builder, "on_configureButton_clicked", G_CALLBACK(on_configureButton_clicked));

    //server configuration dialog
    gtk_builder_add_callback_symbol(builder, "on_saveButton_clicked", G_CALLBACK(on_saveButton_clicked));
    gtk_builder_add_callback_symbol(builder, "on_editButton_clicked", G_CALLBACK(on_editButton_clicked));
    gtk_builder_add_callback_symbol(builder, "on_closeButton_clicked", G_CALLBACK(on_closeButton_clicked));

    //security dialog
    gtk_builder_add_callback_symbol(builder, "on_okButton_clicked", G_CALLBACK(on_okButton_clicked));
    gtk_builder_add_callback_symbol(builder, "on_cancel_loginButton_clicked",
                                    G_CALLBACK(on_cancel_loginButton_clicked));

    gtk_builder_connect_signals(builder, NULL);
}

void onDestroy() {
    gtk_main_quit();
}

void status(char *statusMessage) {
    gtk_label_set_label(widgets->statusLabel, statusMessage);
}

void successStatus(char *statusMessage, GtkLabel *successLabel) {
    char markupBuffer[255];
    sprintf(markupBuffer, "<span foreground='green'>%s</span>", statusMessage);
    gtk_label_set_markup(widgets->statusLabel, markupBuffer);
}

void errorStatus(char *statusMessage, GtkLabel *errorLabel) {
    char markupBuffer[255];
    sprintf(markupBuffer, "<span foreground='red'>%s</span>", statusMessage);
    gtk_label_set_markup(widgets->statusLabel, markupBuffer);
}

char *checkInputs(const char *name, const char *firstName, const char *email) {
    char *errorMessage;
    errorMessage = malloc(1);
    strcpy(errorMessage, "");


    if (strlen(name) == 0) {
        errorMessage = realloc(errorMessage, strlen(errorMessage) + 15 + 1);
        strcat(errorMessage, "Nom incorrect. ");
    }
    if (strlen(firstName) == 0) {
        errorMessage = realloc(errorMessage, strlen(errorMessage) + 18 + 1);
        strcat(errorMessage, "Prénom incorrect. ");
    }

    if (strlen(email) == 0 || checkEmail(email) != 0) {
        errorMessage = realloc(errorMessage, strlen(errorMessage) + 17 + 1);
        strcat(errorMessage, "Email incorrect. ");
    }

    return errorMessage;
}

int processKeyFile(GtkLabel *logLabel) {
    fillC2B(); // un tableau avec décimal => byte
    int returnCode = fillMatrixDecode() || fillMatrixEncode();
    if (returnCode == 1) {
        errorStatus("Erreur dans la configuration de la clé de chiffrement!", logLabel);
        gtk_widget_set_sensitive(GTK_WIDGET(widgets->subscribeButton), FALSE);
        return EXIT_FAILURE;
    } else {
        processConfigFile(logLabel);
    }

    return EXIT_SUCCESS;
}

int processConfigFile(GtkLabel *logLabel) {
    char *conf = decode(configFilePath);
    if (strlen(conf) == 0) {
        errorStatus("Erreur la lecture du fichier de configuration", logLabel);
        gtk_widget_set_sensitive(GTK_WIDGET(widgets->subscribeButton), FALSE);
        return EXIT_FAILURE;
    }
    successStatus("Configuration déchiffré !", logLabel);
    char *confP;
    size_t lineSize = 0;
    //IPDEST=
    //SFTPUSER=
    //SFTPPASSWORD=

    confP = strstr(conf, "IPDEST= ");
    if (confP == NULL) {
        errorStatus("Configuration invalide! (ipdest)", logLabel);
        gtk_widget_set_sensitive(GTK_WIDGET(widgets->subscribeButton), FALSE);
        return EXIT_FAILURE;
    }
    confP = strchr(confP, ' ') + 1;
    lineSize = strchr(confP, '\n') - confP;
    userArgs.ipDest = malloc(lineSize + 1);
    strncpy(userArgs.ipDest, confP, lineSize);
    userArgs.ipDest[lineSize] = '\0';

    confP = strstr(conf, "SFTPUSER= ");
    if (confP == NULL) {
        errorStatus("Configuration invalide! (sftp user)", logLabel);
        gtk_widget_set_sensitive(GTK_WIDGET(widgets->subscribeButton), FALSE);
        return EXIT_FAILURE;
    }
    confP = strchr(confP, ' ') + 1;
    lineSize = strchr(confP, '\n') - confP;
    userArgs.sftpUser = malloc(lineSize + 1);
    strncpy(userArgs.sftpUser, confP, lineSize);
    userArgs.sftpUser[lineSize] = '\0';

    confP = strstr(conf, "SFTPPASSWORD= ");
    if (confP == NULL) {
        errorStatus("Configuration invalide! (sftp password)", logLabel);
        gtk_widget_set_sensitive(GTK_WIDGET(widgets->subscribeButton), FALSE);
        return EXIT_FAILURE;
    }
    confP = strchr(confP, ' ') + 1;
    lineSize = strchr(confP, '\n') - confP;
    userArgs.sftpPwd = malloc(lineSize + 1);
    strncpy(userArgs.sftpPwd, confP, lineSize);
    userArgs.sftpPwd[lineSize] = '\0';

    successStatus("Configuration valide!", logLabel);

    return EXIT_SUCCESS;
}

int sendFile(char *filename) {
    userArgs.filename = filename;
    FILE *logFd;

    logFd = fopen("upload.log", "a");
    if (!logFd) return 1;
    return uploadFile(logFd, &userArgs);
}

void checkCredentials() {
    char username[51];
    char password[51];

    strcpy(username, gtk_entry_get_text(widgets->userLoginEntry));
    strcpy(password, gtk_entry_get_text(widgets->userPwdEntry));
    if (!strcmp(username, "admin") && !strcmp(password, "admin")) {
        gtk_widget_set_visible(GTK_WIDGET(widgets->passRequestDialog), FALSE);
        gtk_widget_set_visible(GTK_WIDGET(widgets->serverConfDialog), TRUE);
        gtk_label_set_text(widgets->passRequestErr, "");

        loadServerConfig();
    } else {
        errorStatus("Wrong credentials!", widgets->passRequestErr);
    }
}

void loadServerConfig() {
    if (processKeyFile(widgets->serverConfStatus) == EXIT_SUCCESS) {
        if (processConfigFile(widgets->serverConfStatus) == EXIT_SUCCESS) {
            gtk_entry_set_text(widgets->serverAddrEntry, userArgs.ipDest);
            gtk_entry_set_text(widgets->serverUsrEntry, userArgs.sftpUser);
            gtk_entry_set_text(widgets->serverPwdEntry, userArgs.sftpPwd);
        } else {
            errorStatus("Configuration erronée création d'une nouvelle vide", widgets->serverConfStatus);
        }
    } else {
        errorStatus("Erreur dans la configuration de la clé de chiffrement!", widgets->serverConfStatus);
    }
}