//
// Created by nou on 31/03/2020.
//

#include "gtkFunctions.h"

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

void on_subscribeButton_clicked() {
    const char *name = gtk_entry_get_text(widgets->nameEntry);
    const char *firstName = gtk_entry_get_text(widgets->firstNameEntry);
    const char *email = gtk_entry_get_text(widgets->emailEntry);

    char *errorMessage = checkInputs(name, firstName, email);

    if (strlen(errorMessage) > 0) {
        errorStatus(errorMessage);
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

    successStatus("code QR créé !");

    strcat(filename, ".png");

    status("Envoie du fichier..");
    int returnCode = sendFile(filename);
    if (returnCode == 0) {
        successStatus("Fichier envoyé ! Consulter le fichier log pour plus d'informations...");
    } else {
        errorStatus(
                "Une erreur s'est produite lors de l'envoie ! Consulter le fichier log pour plus d'informations...");
    }
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
    processKeyFile();
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
    widgets->serverAddrEntry = GTK_ENTRY(gtk_builder_get_object(builder, "serverAddrEntry"));
    widgets->serverUsrEntry = GTK_ENTRY(gtk_builder_get_object(builder, "serverUsrEntry"));
    widgets->serverPwdEntry = GTK_ENTRY(gtk_builder_get_object(builder, "serverPwdEntry"));

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

    //server configuration dialog

    //security dialog

    gtk_builder_connect_signals(builder, NULL);
}

void onDestroy() {
    gtk_main_quit();
}

void status(char *statusMessage) {
    gtk_label_set_label(widgets->statusLabel, statusMessage);
}

void successStatus(char *statusMessage) {
    char markupBuffer[255];
    sprintf(markupBuffer, "<span foreground='green'>%s</span>", statusMessage);
    gtk_label_set_markup(widgets->statusLabel, markupBuffer);
}

void errorStatus(char *statusMessage) {
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

    if (strlen(email) == 0) {
        errorMessage = realloc(errorMessage, strlen(errorMessage) + 17 + 1);
        strcat(errorMessage, "Email incorrect. ");
    }

    return errorMessage;
}

void processKeyFile() {
    fillC2B();
    int returnCode = fillMatrixDecode();
    if (returnCode == 1) {
        errorStatus("Erreur dans la configuration de la clé de chiffrement!");
        gtk_widget_set_sensitive(GTK_WIDGET(widgets->subscribeButton), FALSE);
    } else {
        processConfigFile();
    }
}

void processConfigFile() {
    char *conf = decode(configFilePath);
    if (strlen(conf) == 0) {
        errorStatus("Erreur la lecture du fichier de configuration");
        gtk_widget_set_sensitive(GTK_WIDGET(widgets->subscribeButton), FALSE);
        return;
    }
    successStatus("Configuration déchiffré !");
    char *confP;
    size_t lineSize = 0;
    //IPDEST=
    //SFTPUSER=
    //SFTPPASSWORD=

    confP = strstr(conf, "IPDEST= ");
    if (confP == NULL) {
        errorStatus("Configuration invalide! (ipdest)");
        gtk_widget_set_sensitive(GTK_WIDGET(widgets->subscribeButton), FALSE);
        return;
    }
    confP = strchr(confP, ' ') + 1;
    lineSize = strchr(confP, '\n') - confP;
    userArgs.ipDest = malloc(lineSize + 1);
    strncpy(userArgs.ipDest, confP, lineSize);
    userArgs.ipDest[lineSize] = '\0';

    confP = strstr(conf, "SFTPUSER= ");
    if (confP == NULL) {
        errorStatus("Configuration invalide! (sftp user)");
        gtk_widget_set_sensitive(GTK_WIDGET(widgets->subscribeButton), FALSE);
        return;
    }
    confP = strchr(confP, ' ') + 1;
    lineSize = strchr(confP, '\n') - confP;
    userArgs.sftpUser = malloc(lineSize + 1);
    strncpy(userArgs.sftpUser, confP, lineSize);
    userArgs.sftpUser[lineSize] = '\0';

    confP = strstr(conf, "SFTPPASSWORD= ");
    if (confP == NULL) {
        errorStatus("Configuration invalide! (sftp password)");
        gtk_widget_set_sensitive(GTK_WIDGET(widgets->subscribeButton), FALSE);
        return;
    }
    confP = strchr(confP, ' ') + 1;
    lineSize = strchr(confP, '\n') - confP;
    userArgs.sftpPwd = malloc(lineSize + 1);
    strncpy(userArgs.sftpPwd, confP, lineSize);
    userArgs.sftpPwd[lineSize] = '\0';

    successStatus("Configuration valide!");
}

int sendFile(char *filename) {
    userArgs.filename = filename;
    FILE *logFd;

    logFd = fopen("upload.log", "a");
    if (!logFd) return 1;
    return uploadFile(logFd, &userArgs);
}

